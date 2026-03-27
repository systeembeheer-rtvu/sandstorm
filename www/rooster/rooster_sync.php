<?php
/**
 * rooster_sync.php (DAY-SET REPLACE MODEL)
 *
 * Goal:
 * - Managed events are ONLY location = "RSTR-RM".
 * - Manual override events are location = "RSTR".
 *
 * New simplified rules:
 * 1) If ANY RSTR event starts on a local date => SKIP syncing that date completely.
 * 2) Otherwise, compare the "desired set" (ICS) vs "current managed set" (O365 RSTR-RM) for that local date.
 * 3) If sets are identical => SKIP date.
 * 4) If sets differ => REPLACE the date:
 *    - delete ALL managed (RSTR-RM) events that start on that local date
 *    - create ALL desired events that start on that local date
 *
 * Key detail:
 * - Day ownership is based on LOCAL DTSTART (Europe/Amsterdam), NOT overlap.
 * - We DO NOT do duplicate cleanup as a separate feature. It disappears naturally on REPLACE days.
 *
 * Default behavior:
 * - Report-first (set $DO_WRITES=false)
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

require "/mnt/data/www/vendor/autoload.php";
include("/mnt/data/include/config.inc.php");
include("/mnt/data/include/mysqlp.inc.php");

use GuzzleHttp\Client;
use PHPMailer\PHPMailer\PHPMailer;

include "config.php"; // $calenderconfig (TENANT_ID/CLIENT_ID/CLIENT_SECRET)

// -------------------- CONFIG --------------------
$DO_WRITES    = true;  // <<< set false for report-only
if (getenv('ROOSTER_SYNC_DRY_RUN') === '1') $DO_WRITES = false;
$CALENDAR_ID  = 'default';

// -------------------- EMAIL CONFIG --------------------
$email_override  = "hans.siemons@rtvutrecht.nl"; // set to "" for production
$email_to        = "rooster@rtvutrecht.nl";
$email_from      = "ict@rtvutrecht.nl";
$email_from_name = "Rooster Sync";

$TZ_LOCAL = new DateTimeZone('Europe/Amsterdam');
$TZ_UTC   = new DateTimeZone('UTC');

$run_id = time();
$now_utc = new DateTimeImmutable('now', $TZ_UTC);
$now_utc_str = $now_utc->format('Y-m-d H:i:s');

$email_report = []; // collect changes per mailbox for email

// -------------------- time window --------------------
// Sync runs from today 00:00 local
$now_local = new DateTimeImmutable('now', $TZ_LOCAL);
$today_local = $now_local->setTime(0, 0, 0);

// Monday of current week
$weekday = (int)$today_local->format('N'); // 1..7
$week_monday_local = $today_local->modify('-' . ($weekday - 1) . ' days');

// Default end: Sunday of week 3 from current-week Monday
$default_end_local = $week_monday_local->modify('+20 days')->setTime(23, 59, 59);

$window_start_local = $today_local;
$window_start_utc   = $window_start_local->setTimezone($TZ_UTC);

echo "<pre>";
echo "----\n";
echo "Rooster sync (DAY-SET REPLACE) " . ($DO_WRITES ? "(WRITES ENABLED)" : "(NO WRITES)") . "\n";
echo "run_id=$run_id\n";
echo "Window start local: " . $window_start_local->format('Y-m-d H:i:s') . " Europe/Amsterdam\n";
echo "Window start utc:   " . $window_start_utc->format('Y-m-d H:i:s') . " UTC\n";
echo "Default window end local (3 weeks): " . $default_end_local->format('Y-m-d H:i:s') . " Europe/Amsterdam\n";

// -------------------- DB connect --------------------
$dbh = new sql;
$dbh->connect();

// -------------------- Helpers --------------------
function normalize_text($s) {
    $s = trim((string)$s);
    $s = preg_replace('/\s+/u', ' ', $s);
    return $s;
}

/**
 * Fingerprint is debug-friendly and MUST match between ICS and O365 sides.
 * We base it on the normalized subject + UTC dtstart/dtend + is_allday.
 */
function make_fingerprint($subject, $dtstart_utc_str, $dtend_utc_str, $is_allday) {
    $subject = normalize_text($subject);
    return "S={$subject}|A=" . ((int)$is_allday) . "|START={$dtstart_utc_str}|END={$dtend_utc_str}";
}

function fmt_local_range($dtstart_utc_str, $dtend_utc_str, $isAllDay) {
    $tzU = new DateTimeZone('UTC');
    $tzL = new DateTimeZone('Europe/Amsterdam');

    $s = (new DateTimeImmutable($dtstart_utc_str, $tzU))->setTimezone($tzL);
    $e = (new DateTimeImmutable($dtend_utc_str, $tzU))->setTimezone($tzL);

    if ((int)$isAllDay === 1) {
        return $s->format('Y-m-d');
    }
    return $s->format('Y-m-d H:i') . " -> " . $e->format('H:i');
}

/**
 * Return [day_start_utc_str, day_end_utc_str] for a local day (YYYY-mm-dd).
 * We do NOT rely on CONVERT_TZ because TZ tables may be missing.
 */
function local_day_bounds_to_utc($day_ymd, DateTimeZone $tzLocal, DateTimeZone $tzUtc) {
    $day_start_local = new DateTimeImmutable($day_ymd . ' 00:00:00', $tzLocal);
    $day_end_local   = $day_start_local->modify('+1 day');

    $day_start_utc = $day_start_local->setTimezone($tzUtc);
    $day_end_utc   = $day_end_local->setTimezone($tzUtc);

    return [
        $day_start_utc->format('Y-m-d H:i:s'),
        $day_end_utc->format('Y-m-d H:i:s'),
    ];
}

/**
 * Iterate local days from start_local (inclusive) to end_local (inclusive), returning array of Y-m-d.
 */
function build_local_day_list(DateTimeImmutable $start_local, DateTimeImmutable $end_local) {
    $days = [];
    $cur = $start_local->setTime(0,0,0);
    $end = $end_local->setTime(0,0,0);

    while ($cur <= $end) {
        $days[] = $cur->format('Y-m-d');
        $cur = $cur->modify('+1 day');
    }
    return $days;
}

// -------------------- Graph helpers --------------------
function graph_get_access_token($tenant_id, $client_id, $client_secret) {
    $client = new Client(['timeout' => 20, 'connect_timeout' => 10]);
    $url = "https://login.microsoftonline.com/$tenant_id/oauth2/v2.0/token";

    $resp = $client->post($url, [
        'form_params' => [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'scope' => 'https://graph.microsoft.com/.default',
            'grant_type' => 'client_credentials',
        ],
    ]);

    $data = json_decode((string)$resp->getBody(), true);
    return $data['access_token'] ?? null;
}

function graph_create_event($accessToken, $mailbox_email, $subject, $start_local_str, $end_local_str, $isAllDay) {
    $client = new Client(['timeout' => 25, 'connect_timeout' => 10, 'http_errors' => false]);
    $url = "https://graph.microsoft.com/v1.0/users/" . rawurlencode($mailbox_email) . "/events";

    $data = [
        'subject' => $subject,
        'start' => [
            'dateTime' => $start_local_str,
            'timeZone' => 'Europe/Amsterdam',
        ],
        'end' => [
            'dateTime' => $end_local_str,
            'timeZone' => 'Europe/Amsterdam',
        ],
        'showAs' => 'free',
        'categories' => [
            "RSTR " . $subject
        ],
        'location' => [
            'displayName' => 'RSTR-RM',
        ],
        'isReminderOn' => false,
    ];

    if ($isAllDay) {
        $data['isAllDay'] = true;
    }

    $resp = $client->post($url, [
        'headers' => [
            'Authorization' => "Bearer $accessToken",
            'Content-Type' => 'application/json',
        ],
        'json' => $data,
    ]);

    return [
        'status' => $resp->getStatusCode(),
        'body' => json_decode((string)$resp->getBody(), true),
    ];
}

function graph_delete_event($accessToken, $mailbox_email, $event_id) {
    $client = new Client(['timeout' => 25, 'connect_timeout' => 10, 'http_errors' => false]);
    $url = "https://graph.microsoft.com/v1.0/users/" . rawurlencode($mailbox_email) . "/events/" . rawurlencode($event_id);

    $resp = $client->delete($url, [
        'headers' => [
            'Authorization' => "Bearer $accessToken",
        ],
    ]);

    return [
        'status' => $resp->getStatusCode(), // 204 success, 404 already gone
        'body' => (string)$resp->getBody(),
    ];
}

// -------------------- load mailboxes to sync --------------------
$q = "
    SELECT mailbox_email
    FROM rooster_mailboxes
    WHERE o365_sync = 1
    ORDER BY mailbox_email
";
$sth = $dbh->do_query($q, __LINE__, __FILE__);

$mailboxes = [];
while ($row = $dbh->fetch_assoc($sth)) {
    $mailboxes[] = $row['mailbox_email'];
}
echo "Mailboxes in sync: " . count($mailboxes) . "\n";

// Access token only if writing
$accessToken = null;
if ($DO_WRITES) {
    $accessToken = graph_get_access_token(
        $calenderconfig['TENANT_ID'],
        $calenderconfig['CLIENT_ID'],
        $calenderconfig['CLIENT_SECRET']
    );
    if (!$accessToken) {
        echo "ERROR: could not get access token\n";
        exit(1);
    }
}

foreach ($mailboxes as $mailbox_email) {
    echo "----\n";
    echo "Mailbox: $mailbox_email\n";

    // Determine per-mailbox window end by ICS max end (>= window start), else default
    $window_end_local = $default_end_local;

    $q = "
        SELECT MAX(dtend) AS max_end
        FROM rooster_ics_events
        WHERE mailbox_email=?
          AND calendar_id=?
          AND status='active'
          AND dtend >= ?
    ";
    $sth = $dbh->do_placeholder_query($q, [
        $mailbox_email,
        $CALENDAR_ID,
        $window_start_utc->format('Y-m-d H:i:s'),
    ], __LINE__, __FILE__);
    $row = $dbh->fetch_assoc($sth);
    $max_end_utc_str = $row['max_end'] ?? null;

    if ($max_end_utc_str) {
        $max_end_local = (new DateTimeImmutable($max_end_utc_str, $TZ_UTC))->setTimezone($TZ_LOCAL);
        if ($max_end_local > $window_end_local) {
            $window_end_local = $max_end_local;
            echo "Window end extended by ICS to: " . $window_end_local->format('Y-m-d H:i:s') . " Europe/Amsterdam\n";
        }
    }

    $window_end_utc = $window_end_local->setTimezone($TZ_UTC);
    $window_start_utc_str = $window_start_utc->format('Y-m-d H:i:s');
    $window_end_utc_str   = $window_end_utc->format('Y-m-d H:i:s');

    echo "Window UTC: $window_start_utc_str -> $window_end_utc_str\n";

    // Preload ICS desired events in window (active)
    $q = "
        SELECT subject, dtstart, dtend, is_allday, event_hash
        FROM rooster_ics_events
        WHERE mailbox_email=?
          AND calendar_id=?
          AND status='active'
          AND dtstart >= ?
          AND dtstart < ?
        ORDER BY dtstart
    ";
    $sth = $dbh->do_placeholder_query($q, [
        $mailbox_email,
        $CALENDAR_ID,
        $window_start_utc_str,
        $window_end_utc_str,
    ], __LINE__, __FILE__);
    $ics_all = $dbh->fetch_all_assoc($sth);

    // Preload O365 events in window (active, only RSTR-RM and RSTR)
    $q = "
        SELECT o365_event_id, subject, dtstart, dtend, is_allday, location, event_hash
        FROM rooster_o365_events
        WHERE mailbox_email=?
          AND calendar_id=?
          AND status='active'
          AND dtstart >= ?
          AND dtstart < ?
          AND (location='RSTR-RM' OR location='RSTR')
        ORDER BY dtstart
    ";
    $sth = $dbh->do_placeholder_query($q, [
        $mailbox_email,
        $CALENDAR_ID,
        $window_start_utc_str,
        $window_end_utc_str,
    ], __LINE__, __FILE__);
    $o365_all = $dbh->fetch_all_assoc($sth);

    // Bucket events per local day (start-date is king)
    $ics_by_day = [];   // day => [events...]
    foreach ($ics_all as $ev) {
        $s_local = (new DateTimeImmutable($ev['dtstart'], $TZ_UTC))->setTimezone($TZ_LOCAL);
        $day = $s_local->format('Y-m-d');
        if (!isset($ics_by_day[$day])) $ics_by_day[$day] = [];
        $ics_by_day[$day][] = $ev;
    }

    $o365_rm_by_day = [];   // day => [managed events...]
    $o365_rstr_by_day = []; // day => [override events...]
    foreach ($o365_all as $ev) {
        $s_local = (new DateTimeImmutable($ev['dtstart'], $TZ_UTC))->setTimezone($TZ_LOCAL);
        $day = $s_local->format('Y-m-d');

        if ($ev['location'] === 'RSTR-RM') {
            if (!isset($o365_rm_by_day[$day])) $o365_rm_by_day[$day] = [];
            $o365_rm_by_day[$day][] = $ev;
        } elseif ($ev['location'] === 'RSTR') {
            if (!isset($o365_rstr_by_day[$day])) $o365_rstr_by_day[$day] = [];
            $o365_rstr_by_day[$day][] = $ev;
        }
    }

    // Day list to process
    $days = build_local_day_list($window_start_local, $window_end_local);

    echo "Days in scope: " . count($days) . "\n";
    echo "Preload counts: ICS=" . count($ics_all) . " / O365(RM+RSTR)=" . count($o365_all) . "\n\n";

    $total_days_skip_override = 0;
    $total_days_skip_ok = 0;
    $total_days_replace = 0;

    $total_create = 0;
    $total_delete = 0;

    foreach ($days as $day) {
        $has_override = isset($o365_rstr_by_day[$day]) && count($o365_rstr_by_day[$day]) > 0;
        if ($has_override) {
            $total_days_skip_override++;
            echo "DAY $day: SKIP (override RSTR present: " . count($o365_rstr_by_day[$day]) . ")\n";
            continue;
        }

        $desired = $ics_by_day[$day] ?? [];
        $current = $o365_rm_by_day[$day] ?? [];

        // Build fingerprint sets for comparison
        $desired_fp = [];
        foreach ($desired as $ev) {
            $fp = make_fingerprint($ev['subject'], $ev['dtstart'], $ev['dtend'], $ev['is_allday']);
            $desired_fp[$fp] = true;
        }

        $current_fp = [];
        foreach ($current as $ev) {
            $fp = make_fingerprint($ev['subject'], $ev['dtstart'], $ev['dtend'], $ev['is_allday']);
            $current_fp[$fp] = true;
        }

        $desired_keys = array_keys($desired_fp);
        $current_keys = array_keys($current_fp);
        sort($desired_keys);
        sort($current_keys);

        $is_equal = ($desired_keys === $current_keys) && (count($desired) === count($current));

        if ($is_equal) {
            $total_days_skip_ok++;
            echo "DAY $day: OK (no change) desired=" . count($desired) . " current=" . count($current) . "\n";
            continue;
        }

        $total_days_replace++;
        echo "DAY $day: REPLACE desired=" . count($desired) . " current=" . count($current) . "\n";
        $email_report[$mailbox_email]['days'][$day] = ['creates' => [], 'deletes' => []];

        // Report difference (debug)
        $to_create_fp = array_diff($desired_keys, $current_keys);
        $to_delete_fp = array_diff($current_keys, $desired_keys);

        if (count($to_create_fp)) {
            echo "  CREATE needed: " . count($to_create_fp) . "\n";
        }
        if (count($to_delete_fp)) {
            echo "  DELETE needed: " . count($to_delete_fp) . "\n";
        }

        // Replace semantics:
        // Delete ALL managed events on that day (start-date based)
        // Create ALL desired events on that day
        $day_deletes = $current; // all managed
        $day_creates = $desired; // all desired

        // Apply deletes (de-dupe by o365_event_id)
        $delete_by_id = [];
        foreach ($day_deletes as $ev) {
            $id = (string)($ev['o365_event_id'] ?? '');
            if ($id === '') continue;
            $delete_by_id[$id] = $ev;
        }

        $total_delete += count($delete_by_id);
        $total_create += count($day_creates);

        if (!$DO_WRITES) {
            // Report-only details
            foreach ($delete_by_id as $id => $ev) {
                $kind = ((int)$ev['is_allday'] === 1) ? "ALLDAY" : "TIMED";
                echo "    DEL: [$kind] {$ev['subject']} (" . fmt_local_range($ev['dtstart'], $ev['dtend'], $ev['is_allday']) . ") id=$id\n";
                $email_report[$mailbox_email]['days'][$day]['deletes'][] = $ev['subject'] . " (" . fmt_local_range($ev['dtstart'], $ev['dtend'], $ev['is_allday']) . ")";
            }
            foreach ($day_creates as $ev) {
                $kind = ((int)$ev['is_allday'] === 1) ? "ALLDAY" : "TIMED";
                echo "    NEW: [$kind] {$ev['subject']} (" . fmt_local_range($ev['dtstart'], $ev['dtend'], $ev['is_allday']) . ")\n";
                $email_report[$mailbox_email]['days'][$day]['creates'][] = $ev['subject'] . " (" . fmt_local_range($ev['dtstart'], $ev['dtend'], $ev['is_allday']) . ")";
            }
            continue;
        }

        // --- WRITES ENABLED ---

        // Deletes first
        foreach ($delete_by_id as $event_id => $ev) {
            $resp = graph_delete_event($accessToken, $mailbox_email, $event_id);
            $code = (int)$resp['status'];

            if ($code === 204) {
                echo "    DELETE OK: {$ev['subject']} ($event_id) HTTP $code\n";
                $email_report[$mailbox_email]['days'][$day]['deletes'][] = $ev['subject'] . " (" . fmt_local_range($ev['dtstart'], $ev['dtend'], $ev['is_allday']) . ")";
            } elseif ($code === 404) {
                echo "    DELETE OK (already gone): {$ev['subject']} ($event_id) HTTP $code\n";
            } else {
                echo "    DELETE WARN: {$ev['subject']} ($event_id) HTTP $code\n";
                if ($resp['body'] !== '') {
                    echo "      Body: " . $resp['body'] . "\n";
                }
            }
        }

        // Creates
        foreach ($day_creates as $ev) {
            $subject = normalize_text($ev['subject']);
            $isAllDay = ((int)$ev['is_allday'] === 1);

            $s_local = (new DateTimeImmutable($ev['dtstart'], $TZ_UTC))->setTimezone($TZ_LOCAL)->format('Y-m-d\TH:i:s');
            $e_local = (new DateTimeImmutable($ev['dtend'], $TZ_UTC))->setTimezone($TZ_LOCAL)->format('Y-m-d\TH:i:s');

            $resp = graph_create_event($accessToken, $mailbox_email, $subject, $s_local, $e_local, $isAllDay);
            $code = (int)($resp['status'] ?? 0);
            $body = $resp['body'] ?? [];
            $newId = $body['id'] ?? '(no id)';

            if ($code >= 200 && $code < 300) {
                echo "    CREATE OK: {$subject} ($newId)\n";
                $email_report[$mailbox_email]['days'][$day]['creates'][] = $subject . " (" . fmt_local_range($ev['dtstart'], $ev['dtend'], $ev['is_allday']) . ")";
            } else {
                echo "    CREATE FAIL: {$subject} HTTP $code\n";
                echo "      Body: " . json_encode($body) . "\n";
            }
        }
    }

    echo "\nSUMMARY mailbox $mailbox_email\n";
    echo "  Days: " . count($days) . "\n";
    echo "  Days SKIP override: $total_days_skip_override\n";
    echo "  Days OK:            $total_days_skip_ok\n";
    echo "  Days REPLACE:       $total_days_replace\n";
    echo "  Total DELETE ops:   $total_delete\n";
    echo "  Total CREATE ops:   $total_create\n";
    echo "\n";
}

echo "----\nDone.\n";

// -------------------- EMAIL REPORT --------------------
if (!empty($email_report)) {
    $dateStr = (new DateTimeImmutable('now', $TZ_LOCAL))->format('Y-m-d H:i');
    $mode    = $DO_WRITES ? "live" : "droog";

    $html = "<p>Rooster sync uitgevoerd op $dateStr ($mode).</p>";

    foreach ($email_report as $mailbox => $data) {
        $html .= "<h3>$mailbox</h3>";
        foreach ($data['days'] as $day => $changes) {
            $html .= "<p><strong>$day</strong><br>";
            foreach ($changes['deletes'] as $item) {
                $html .= "&nbsp;&nbsp;&#10060; $item<br>";
            }
            foreach ($changes['creates'] as $item) {
                $html .= "&nbsp;&nbsp;&#10003; $item<br>";
            }
            $html .= "</p>";
        }
    }

    $sendTo = $email_override ?: $email_to;

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp.park.rtvutrecht.nl';
    $mail->Port       = 25;
    $mail->SMTPAutoTLS = false;
    $mail->SMTPAuth   = false;
    $mail->setFrom($email_from, $email_from_name);
    $mail->addAddress($sendTo);
    $mail->Subject  = "Rooster sync $dateStr ($mode)";
    $mail->isHTML(true);
    $mail->Body     = $html;

    try {
        $mail->send();
        echo "Email verzonden naar $sendTo\n";
    } catch (Exception $e) {
        echo "Email fout: " . $mail->ErrorInfo . "\n";
    }
}
echo "</pre>";
?>
