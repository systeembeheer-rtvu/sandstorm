<?php
require "/mnt/data/www/vendor/autoload.php";
include("/mnt/data/include/config.inc.php");    // config file database
include("/mnt/data/include/mysqlp.inc.php");    // PDO sql library

use GuzzleHttp\Client;

include "config.php"; // $calenderconfig

$TZ_LOCAL = new DateTimeZone('Europe/Amsterdam');
$TZ_UTC   = new DateTimeZone('UTC');

$run_id      = time();
$now_utc     = new DateTimeImmutable('now', $TZ_UTC);
$now_utc_str = $now_utc->format('Y-m-d H:i:s');

echo "<pre>";
echo "----\n";
echo "Rooster O365 calendar reader\n";

// ------------------------------------------------------------
// DB connect
// ------------------------------------------------------------
$dbh = new sql;
$dbh->connect();

// ------------------------------------------------------------
// Helpers
// ------------------------------------------------------------
function normalize_text($s) {
    return trim(preg_replace('/\s+/u', ' ', (string)$s));
}

function calc_event_hash($subject, $dtstart_utc_str, $dtend_utc_str, $isAllDay) {
    $subject = normalize_text($subject);
    return hash('sha256', $subject . '|' . $dtstart_utc_str . '|' . $dtend_utc_str . '|' . (int)$isAllDay);
}

function get_location_name($event) {
    if (!isset($event['location']['displayName'])) return '';
    return trim((string)$event['location']['displayName']);
}

/**
 * Fetch events via calendarView, paging through @odata.nextLink
 */
function fetch_graph_events($accessToken, $mailbox_email, $startUtcIso, $endUtcIso) {
    $client = new Client([
        'timeout' => 60,
        'connect_timeout' => 10,
        'http_errors' => false,
    ]);

    $url = "https://graph.microsoft.com/v1.0/users/$mailbox_email/calendarView";
    $query = [
        '$select'       => 'id,changeKey,lastModifiedDateTime,subject,start,end,isAllDay,location',
        '$top'          => 999,
        'startDateTime' => $startUtcIso,
        'endDateTime'   => $endUtcIso,
    ];

    $events = [];
    while (true) {
        $resp = $client->get($url, [
            'headers' => ['Authorization' => "Bearer $accessToken"],
            'query'   => $query,
        ]);

        $code = $resp->getStatusCode();
        $body = (string)$resp->getBody();

        if ($code < 200 || $code >= 300) {
            echo "ERROR: Graph HTTP $code for $mailbox_email\n$body\n";
            return [];
        }

        $data = json_decode($body, true);
        if (!isset($data['value'])) return $events;

        foreach ($data['value'] as $ev) $events[] = $ev;

        if (!empty($data['@odata.nextLink'])) {
            $url   = $data['@odata.nextLink'];
            $query = [];
        } else {
            break;
        }
    }
    return $events;
}

/**
 * Get OAuth access token (client credentials)
 */
function getAccessToken($tenant_id, $client_id, $client_secret) {
    $client = new Client();
    $url = "https://login.microsoftonline.com/$tenant_id/oauth2/v2.0/token";
    $response = $client->post($url, [
        'form_params' => [
            'client_id'     => $client_id,
            'client_secret' => $client_secret,
            'scope'         => 'https://graph.microsoft.com/.default',
            'grant_type'    => 'client_credentials',
        ],
        'timeout' => 30,
    ]);
    $data = json_decode($response->getBody(), true);
    return $data['access_token'];
}

// ------------------------------------------------------------
// Window start: monday this week. Default end: +20 days.
// Per mailbox, end is extended to match max ICS event end.
// ------------------------------------------------------------
$startLocal      = (new DateTimeImmutable('now', $TZ_LOCAL))->modify('monday this week')->setTime(0, 0, 0);
$defaultEndLocal = $startLocal->modify('+20 days')->setTime(23, 59, 59);
$startUtc        = $startLocal->setTimezone($TZ_UTC);
$startUtcStr     = $startUtc->format('Y-m-d H:i:s');

echo "Window start local: " . $startLocal->format('Y-m-d H:i:s') . " Europe/Amsterdam\n";
echo "Default window end: " . $defaultEndLocal->format('Y-m-d H:i:s') . " Europe/Amsterdam\n";

// ------------------------------------------------------------
// Load mailboxes
// ------------------------------------------------------------
$sth = $dbh->do_query(
    "SELECT mailbox_email, debug FROM rooster_mailboxes WHERE calender_read = 1 ORDER BY mailbox_email",
    __LINE__, __FILE__
);

$mailboxes     = [];
$mailbox_debug = [];
while ($row = $dbh->fetch_assoc($sth)) {
    $mailboxes[]                             = $row['mailbox_email'];
    $mailbox_debug[$row['mailbox_email']]    = (int)$row['debug'];
}

if (!count($mailboxes)) {
    echo "No mailboxes found with calender_read=1.\n";
    exit;
}
echo "Mailboxes: " . count($mailboxes) . "\n";

// ------------------------------------------------------------
// Get Graph token
// ------------------------------------------------------------
$accessToken = getAccessToken(
    $calenderconfig['TENANT_ID'],
    $calenderconfig['CLIENT_ID'],
    $calenderconfig['CLIENT_SECRET']
);

foreach ($mailboxes as $mailbox_email) {
    echo "----\n";
    echo "Mailbox: $mailbox_email\n";

    // Extend window end to max ICS event end for this mailbox
    $endLocal = $defaultEndLocal;
    $sth = $dbh->do_placeholder_query(
        "SELECT MAX(dtend) AS max_end FROM rooster_ics_events WHERE mailbox_email = ? AND status = 'active' AND dtend >= ?",
        [$mailbox_email, $startUtcStr], __LINE__, __FILE__
    );
    $row = $dbh->fetch_assoc($sth);
    if (!empty($row['max_end'])) {
        $icsEnd = (new DateTimeImmutable($row['max_end'], $TZ_UTC))->setTimezone($TZ_LOCAL);
        if ($icsEnd > $endLocal) {
            $endLocal = $icsEnd;
            echo "Window end extended by ICS to: " . $endLocal->format('Y-m-d H:i:s') . " Europe/Amsterdam\n";
        }
    }
    $endUtc  = $endLocal->setTimezone($TZ_UTC);
    $startIso = $startUtc->format('Y-m-d\TH:i:s\Z');
    $endIso   = $endUtc->format('Y-m-d\TH:i:s\Z');

    $graph_events = fetch_graph_events($accessToken, $mailbox_email, $startIso, $endIso);
    echo "Graph events retrieved: " . count($graph_events) . "\n";

    // Delete all existing events for this mailbox and re-insert fresh, atomically
    $dbh->dbh->beginTransaction();

    $dbh->do_placeholder_query(
        "DELETE FROM rooster_o365_events WHERE mailbox_email = ?",
        [$mailbox_email], __LINE__, __FILE__
    );

    $ins = 0;
    $seen_ids = [];
    foreach ($graph_events as $ev) {
        $location = strtoupper(get_location_name($ev));

        // Keep only events with RSTR in the location (case-insensitive, same as old dashboard)
        if (stripos($location, 'RSTR') === false) continue;

        // Correct known typos/aliases
        if ($location === 'RSTR-MR') $location = 'RSTR-RM';

        $o365_event_id = (string)($ev['id'] ?? '');
        if (isset($seen_ids[$o365_event_id])) continue;
        $seen_ids[$o365_event_id] = true;

        $changeKey     = (string)($ev['changeKey'] ?? '');
        $lastMod       = (string)($ev['lastModifiedDateTime'] ?? '');
        $subject       = normalize_text($ev['subject'] ?? '');
        $is_allday     = !empty($ev['isAllDay']) ? 1 : 0;

        if ($is_allday) {
            $start_local = (new DateTimeImmutable($ev['start']['dateTime'], $TZ_LOCAL))->setTime(0, 0, 0);
            $dtstart_utc = $start_local->setTimezone($TZ_UTC);
            $dtend_utc   = $start_local->modify('+1 day')->setTimezone($TZ_UTC);
        } else {
            $start_tz    = new DateTimeZone($ev['start']['timeZone'] ?? 'UTC');
            $end_tz      = new DateTimeZone($ev['end']['timeZone']   ?? 'UTC');
            $dtstart_utc = (new DateTimeImmutable($ev['start']['dateTime'], $start_tz))->setTimezone($TZ_UTC);
            $dtend_utc   = (new DateTimeImmutable($ev['end']['dateTime'],   $end_tz))->setTimezone($TZ_UTC);
        }

        if ($dtend_utc <= $dtstart_utc) continue;

        $dtstart_str = $dtstart_utc->format('Y-m-d H:i:s');
        $dtend_str   = $dtend_utc->format('Y-m-d H:i:s');
        $event_hash  = calc_event_hash($subject, $dtstart_str, $dtend_str, $is_allday);

        $last_modified_utc_str = null;
        if ($lastMod !== '') {
            try {
                $last_modified_utc_str = (new DateTimeImmutable($lastMod))->setTimezone($TZ_UTC)->format('Y-m-d H:i:s');
            } catch (Exception $e) {}
        }

        if ($mailbox_debug[$mailbox_email] ?? 0) {
            echo "  INSERT: $subject | $dtstart_str → $dtend_str | loc=$location\n";
        }

        $dbh->do_placeholder_query("
            INSERT IGNORE INTO rooster_o365_events
                (mailbox_email, calendar_id, o365_event_id,
                 change_key, last_modified_utc,
                 subject, dtstart, dtend, is_allday, location, event_hash,
                 first_seen_at, last_seen_at, last_seen_run, status)
            VALUES (?, 'default', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')
        ", [
            $mailbox_email, $o365_event_id,
            $changeKey, $last_modified_utc_str,
            $subject, $dtstart_str, $dtend_str, $is_allday, $location, $event_hash,
            $now_utc_str, $now_utc_str, $run_id,
        ], __LINE__, __FILE__);

        $ins++;
    }

    $dbh->dbh->commit();
    echo "Inserted: $ins\n";
}

echo "----\nDone.\n";
echo "</pre>";
?>
