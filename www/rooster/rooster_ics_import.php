<?php
require "/mnt/data/www/vendor/autoload.php";
include("/mnt/data/include/config.inc.php");    // config file database
include("/mnt/data/include/mysqlp.inc.php");    // your sql wrapper

use Sabre\VObject\Reader;
use GuzzleHttp\Client;

$TZ_LOCAL = new DateTimeZone('Europe/Amsterdam');
$TZ_UTC   = new DateTimeZone('UTC');

$run_id = time();
$now_utc = new DateTimeImmutable('now', $TZ_UTC);
$now_utc_str = $now_utc->format('Y-m-d H:i:s');

echo "<pre>";
echo "----\n";
echo "Rooster ICS importer (FULL RANGE)\n";
echo "run_id=$run_id\n";
echo "Now utc: " . $now_utc_str . " UTC\n";

// ------------------------------------------------------------
// DB connect
// ------------------------------------------------------------
$dbh = new sql;
$dbh->connect();

// ------------------------------------------------------------
// Helpers
// ------------------------------------------------------------
function normalize_text($s) {
    $s = trim((string)$s);
    $s = preg_replace('/\s+/u', ' ', $s);
    return $s;
}

function clamp_str($s, $max) {
    $s = (string)$s;
    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
        if (mb_strlen($s, 'UTF-8') > $max) {
            return mb_substr($s, 0, $max, 'UTF-8');
        }
        return $s;
    }
    if (strlen($s) > $max) return substr($s, 0, $max);
    return $s;
}

/**
 * Stable SUMMARY key extraction:
 * - handles literal "\n"
 * - uses only first line
 * - normalizes "|" splits (trim each part)
 */
function normalize_summary_key($summary_raw) {
    $s = (string)$summary_raw;

    $s = str_replace("\r", "", $s);
    $s = str_replace("\\n", "\n", $s);

    $parts = explode("\n", $s, 2);
    $first = $parts[0];

    $first = implode("|", array_filter(array_map('trim', explode("|", $first))));
    $first = normalize_text($first);

    return clamp_str($first, 200);
}

function download_ics($url) {
    $client = new Client([
        'timeout' => 30,
        'connect_timeout' => 10,
        'allow_redirects' => true,
        'http_errors' => false,
        'verify' => false, // SSL cert validation disabled
    ]);

    $resp = $client->get($url, [
        'headers' => [
            'User-Agent' => 'RTV-Utrecht-RoosterSync/1.0',
            'Accept' => 'text/calendar, text/plain, */*',
        ],
    ]);

    $code = $resp->getStatusCode();
    $body = (string)$resp->getBody();

    if ($code < 200 || $code >= 300) {
        throw new Exception("HTTP $code");
    }
    if (stripos($body, 'BEGIN:VCALENDAR') === false) {
        throw new Exception("Response missing BEGIN:VCALENDAR");
    }
    return $body;
}

function load_diensten_map($dbh) {
    $map = [];
    $q = "SELECT ics_key, dienst_value FROM rooster_diensten WHERE is_active=1";
    $sth = $dbh->do_query($q, __LINE__, __FILE__);
    while ($row = $dbh->fetch_assoc($sth)) {
        $k = normalize_text($row['ics_key']);
        $map[$k] = (string)$row['dienst_value'];
    }
    return $map;
}

/**
 * Unknown keys are auto-inserted into rooster_diensten (is_active=0)
 * so they can be configured later. Returns "N/A: key" as fallback value.
 */
function get_dienst_value($diensten_map, $ics_key, $dbh = null) {
    $k = normalize_text($ics_key);
    if (isset($diensten_map[$k])) return (string)$diensten_map[$k];

    if ($dbh !== null) {
        $dbh->do_placeholder_query(
            "INSERT IGNORE INTO rooster_diensten (ics_key, dienst_value, css_class, is_active, created_at, updated_at)
             VALUES (?, '', 'overig', 0, NOW(), NOW())",
            [$k], __LINE__, __FILE__
        );
    }

    return clamp_str("N/A: " . $k, 255);
}

/**
 * Convert vobject prop to UTC datetime.
 * DATE => local midnight
 * DATE-TIME => deterministic conversion using createFromInterface
 */
function vobj_prop_to_utc($prop, DateTimeZone $tzLocal, DateTimeZone $tzUtc, &$valueTypeOut) {
    $valueTypeOut = null;
    if (!$prop) return null;

    if (method_exists($prop, 'getValueType')) {
        $valueTypeOut = $prop->getValueType(); // 'DATE' or 'DATE-TIME'
    }

    if ($valueTypeOut === 'DATE') {
        $datestr = (string)$prop;
        $dt_local = DateTimeImmutable::createFromFormat('Ymd', $datestr, $tzLocal);
        if (!$dt_local) return null;
        return $dt_local->setTime(0, 0, 0)->setTimezone($tzUtc);
    }

    $dt = $prop->getDateTime();
    $imm = DateTimeImmutable::createFromInterface($dt);
    return $imm->setTimezone($tzUtc);
}

/**
 * Normalize all-day bounds to:
 * local midnight of DTSTART date -> next local midnight
 */
function normalize_allday_bounds(DateTimeImmutable $dtstart_utc, DateTimeZone $tzLocal, DateTimeZone $tzUtc) {
    $d_local = $dtstart_utc->setTimezone($tzLocal);
    $start_local_mid = (new DateTimeImmutable($d_local->format('Y-m-d'), $tzLocal))->setTime(0, 0, 0);
    $end_local_mid = $start_local_mid->modify('+1 day');
    return [
        $start_local_mid->setTimezone($tzUtc),
        $end_local_mid->setTimezone($tzUtc),
    ];
}

function build_fingerprint($ics_key, $subject, $dtstart_utc_str, $dtend_utc_str, $isAllDay) {
    $ics_key = normalize_text($ics_key);
    $subject = normalize_text($subject);
    return "K={$ics_key}|S={$subject}|A=" . (int)$isAllDay . "|START={$dtstart_utc_str}|END={$dtend_utc_str}";
}

/**
 * Postprocess one VEVENT into canonical event structure.
 * Returns null to skip.
 */
function postprocess_ics_vevent($diensten_map, $vevent, DateTimeZone $tzLocal, DateTimeZone $tzUtc, $dbh = null) {

    $uid = isset($vevent->UID) ? trim((string)$vevent->UID) : '';
    $uid = clamp_str($uid, 255);

    $summary_raw = isset($vevent->SUMMARY) ? (string)$vevent->SUMMARY : '';
    $ics_key = normalize_summary_key($summary_raw);

    $dienst_value = get_dienst_value($diensten_map, $ics_key, $dbh);

    $skip_prefix = (strlen($dienst_value) > 0 && $dienst_value[0] === '!');
    $allday_prefix = (strlen($dienst_value) > 0 && $dienst_value[0] === '#');

    if ($skip_prefix) return null;

    // mapping decides is_allday, ALWAYS
    $is_allday = $allday_prefix ? 1 : 0;

    $subject = $dienst_value;
    if ($allday_prefix) $subject = ltrim($subject, '#');
    $subject = clamp_str(normalize_text($subject), 255);

    // Parse DTSTART/DTEND
    $valueTypeStart = null;
    $valueTypeEnd = null;

    $dtstart_utc = vobj_prop_to_utc($vevent->DTSTART ?? null, $tzLocal, $tzUtc, $valueTypeStart);
    $dtend_utc   = vobj_prop_to_utc($vevent->DTEND ?? null, $tzLocal, $tzUtc, $valueTypeEnd);

    if (!$dtstart_utc || !$dtend_utc) return null;
    if ($dtend_utc <= $dtstart_utc) return null;

    // ------------------------------------------------------------
    // ✅ Storingsdienst: ALL-DAY ONLY (mapping decides), skip tail only
    // Tail: local start 00:00 and local end <= 09:00 (weekday only)
    // ------------------------------------------------------------
    if ($ics_key === 'Bereikbaarheid' && $subject === 'Storing ICT') {

        // Force all-day regardless (even if diensten table was misconfigured)
        $is_allday = 1;

        $s_local = $dtstart_utc->setTimezone($tzLocal);
        $e_local = $dtend_utc->setTimezone($tzLocal);

        $weekday = (int)$s_local->format('N'); // 1=Mon..7=Sun
        $is_workday = ($weekday >= 1 && $weekday <= 5);

        $s_hm = $s_local->format('H:i');
        $end_minutes = ((int)$e_local->format('H')) * 60 + ((int)$e_local->format('i'));

        // Skip weekday tail fragment only
        if ($is_workday && $s_hm === '00:00' && $end_minutes <= 540) { // <=09:00
            return null;
        }

        // Always attach to DTSTART local date (startdate is king)
        [$dtstart_utc, $dtend_utc] = normalize_allday_bounds($dtstart_utc, $tzLocal, $tzUtc);
    }

    // ------------------------------------------------------------
    // ICT-S clamp ONLY when it matches provider pattern 08:30 -> 18:00.
    // ------------------------------------------------------------
    if ($subject === 'ICT-S' && !$is_allday) {
        $s_local = $dtstart_utc->setTimezone($tzLocal);
        $e_local = $dtend_utc->setTimezone($tzLocal);

        if ($s_local->format('H:i') === '08:30' && $e_local->format('H:i') === '18:00') {
            $s_local = $s_local->setTime(9, 0, 0);
            $e_local = $e_local->setTime(17, 30, 0);
            if ($e_local > $s_local) {
                $dtstart_utc = $s_local->setTimezone($tzUtc);
                $dtend_utc   = $e_local->setTimezone($tzUtc);
            }
        }
    }

    // Normalize other all-day events to local midnight -> next midnight
    if ($is_allday) {
        [$dtstart_utc, $dtend_utc] = normalize_allday_bounds($dtstart_utc, $tzLocal, $tzUtc);
    }

    if ($dtend_utc <= $dtstart_utc) return null;

    $dtstart_str = $dtstart_utc->format('Y-m-d H:i:s');
    $dtend_str   = $dtend_utc->format('Y-m-d H:i:s');

    $fingerprint = build_fingerprint($ics_key, $subject, $dtstart_str, $dtend_str, (int)$is_allday);
    $fingerprint = clamp_str($fingerprint, 512);
    $event_hash = hash('sha256', $fingerprint);

    return [
        'ics_uid' => $uid,
        'ics_key' => $ics_key,
        'subject' => $subject,
        'dtstart' => $dtstart_str,
        'dtend' => $dtend_str,
        'is_allday' => (int)$is_allday,
        'fingerprint' => $fingerprint,
        'event_hash' => $event_hash,
    ];
}

function get_min_start_from_events($events) {
    $min = null;
    foreach ($events as $ev) {
        if (!$min || $ev['dtstart'] < $min) $min = $ev['dtstart'];
    }
    return $min;
}

function get_max_end_from_events($events) {
    $max = null;
    foreach ($events as $ev) {
        if (!$max || $ev['dtend'] > $max) $max = $ev['dtend'];
    }
    return $max;
}

// ------------------------------------------------------------
// Load diensten
// ------------------------------------------------------------
$diensten_map = load_diensten_map($dbh);
echo "Loaded diensten: " . count($diensten_map) . "\n";

// ------------------------------------------------------------
// Load mailboxes to read ICS
// ------------------------------------------------------------
$q = "
    SELECT mailbox_email, ics_url
    FROM rooster_mailboxes
    WHERE ics_read = 1
    ORDER BY mailbox_email
";
$sth = $dbh->do_query($q, __LINE__, __FILE__);

$mailboxes = [];
while ($row = $dbh->fetch_assoc($sth)) {
    $mailboxes[] = $row;
}
echo "Mailboxes to read ICS: " . count($mailboxes) . "\n";

// ------------------------------------------------------------
// Main loop
// ------------------------------------------------------------
foreach ($mailboxes as $mb) {

    $mailbox_email = strtolower(trim((string)$mb['mailbox_email']));
    $ics_url = trim((string)$mb['ics_url']);

    echo "----\n";
    echo "Mailbox: $mailbox_email\n";
    echo "ICS URL: $ics_url\n";

    try {
        $ics = download_ics($ics_url);
    } catch (Exception $e) {
        echo "ERROR: Exception while downloading ICS: " . $e->getMessage() . "\n";
        continue;
    }

    try {
        $vcalendar = Reader::read($ics);
    } catch (Exception $e) {
        echo "ERROR: Failed to parse ICS: " . $e->getMessage() . "\n";
        continue;
    }

    $events = [];
    foreach ($vcalendar->select('VEVENT') as $vevent) {
        $pp = postprocess_ics_vevent($diensten_map, $vevent, $TZ_LOCAL, $TZ_UTC, $dbh);
        if (!$pp) continue;
        $events[] = $pp;
    }

    echo "Events in scope: " . count($events) . "\n";
    if (!count($events)) {
        echo "No events; skipping DB sync for this mailbox.\n";
        continue;
    }

    $window_start_utc_str = get_min_start_from_events($events);
    $window_end_utc_str   = get_max_end_from_events($events);
    echo "Window UTC (from ICS): $window_start_utc_str -> $window_end_utc_str\n";

    // Upsert by uniq_ics_hash (mailbox_email, calendar_id, event_hash)
    // IMPORTANT: 14 placeholders, 14 params.
    $q_upsert = "
        INSERT INTO rooster_ics_events
            (mailbox_email, calendar_id,
             ics_uid, subject, dtstart, dtend, is_allday,
             event_hash, fingerprint, source_url,
             first_seen_at, last_seen_at, last_seen_run, status)
        VALUES
            (?,?,?,?,?,
             ?,?,?,?,
             ?,?,?,?,?)
        ON DUPLICATE KEY UPDATE
            ics_uid=VALUES(ics_uid),
            subject=VALUES(subject),
            dtstart=VALUES(dtstart),
            dtend=VALUES(dtend),
            is_allday=VALUES(is_allday),
            fingerprint=VALUES(fingerprint),
            source_url=VALUES(source_url),
            last_seen_at=VALUES(last_seen_at),
            last_seen_run=VALUES(last_seen_run),
            status='active'
    ";

    $inserted = 0;
    $updated = 0;
    $touched = 0;

    foreach ($events as $ev) {

        $q_check = "
            SELECT id, fingerprint, status
            FROM rooster_ics_events
            WHERE mailbox_email=?
              AND calendar_id='default'
              AND event_hash=?
            LIMIT 1
        ";
        $sth = $dbh->do_placeholder_query($q_check, [$mailbox_email, $ev['event_hash']], __LINE__, __FILE__);
        $old = $dbh->fetch_assoc($sth);

        $params = [
            $mailbox_email,
            'default',

            $ev['ics_uid'],
            $ev['subject'],
            $ev['dtstart'],

            $ev['dtend'],
            $ev['is_allday'],
            $ev['event_hash'],
            $ev['fingerprint'],

            $ics_url,
            $now_utc_str,
            $now_utc_str,
            $run_id,
            'active'
        ];

        $dbh->do_placeholder_query($q_upsert, $params, __LINE__, __FILE__);

        if (!$old) {
            $inserted++;
        } else {
            if ($old['fingerprint'] !== $ev['fingerprint'] || $old['status'] !== 'active') {
                $updated++;
            } else {
                $touched++;
            }
        }
    }

    // Count active rows seen this run in window
    $q_seen = "
        SELECT COUNT(*) AS cnt
        FROM rooster_ics_events
        WHERE mailbox_email=?
          AND calendar_id='default'
          AND status='active'
          AND dtstart < ?
          AND dtend > ?
          AND last_seen_run=?
    ";
    $sth = $dbh->do_placeholder_query($q_seen, [
        $mailbox_email,
        $window_end_utc_str,
        $window_start_utc_str,
        $run_id
    ], __LINE__, __FILE__);
    $row = $dbh->fetch_assoc($sth);
    $seen_this_run = (int)($row['cnt'] ?? 0);

    echo "Inserted: $inserted\n";
    echo "Updated:  $updated\n";
    echo "Touched:  $touched\n";
    echo "Active rows seen this run (in window): $seen_this_run\n";

    // Mark missing in the FULL ICS window as deleted (do not overwrite last_seen_run)
    $q_del = "
        UPDATE rooster_ics_events
        SET status='deleted',
            last_seen_at=?
        WHERE mailbox_email=?
          AND calendar_id='default'
          AND status='active'
          AND dtstart < ?
          AND dtend > ?
          AND (last_seen_run IS NULL OR last_seen_run <> ?)
    ";
    $dbh->do_placeholder_query($q_del, [
        $now_utc_str,
        $mailbox_email,
        $window_end_utc_str,
        $window_start_utc_str,
        $run_id
    ], __LINE__, __FILE__);

    // Count deletes this run (by last_seen_at timestamp)
    $q_cnt = "
        SELECT COUNT(*) AS cnt
        FROM rooster_ics_events
        WHERE mailbox_email=?
          AND calendar_id='default'
          AND status='deleted'
          AND last_seen_at=?
          AND dtstart < ?
          AND dtend > ?
    ";
    $sth = $dbh->do_placeholder_query($q_cnt, [
        $mailbox_email,
        $now_utc_str,
        $window_end_utc_str,
        $window_start_utc_str
    ], __LINE__, __FILE__);
    $row = $dbh->fetch_assoc($sth);
    $deleted = (int)($row['cnt'] ?? 0);

    echo "Marked deleted (missing in ICS window): $deleted\n";
}

echo "----\nDone.\n";
echo "</pre>";
?>
