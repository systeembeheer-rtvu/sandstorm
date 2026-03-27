<?php
header('Content-Type: application/json');

include('/mnt/data/include/config.inc.php');
include('/mnt/data/include/mysqlp.inc.php');

$dbh = new sql;
$dbh->connect();

$TZ_LOCAL = new DateTimeZone('Europe/Amsterdam');
$TZ_UTC   = new DateTimeZone('UTC');

$startDate = (new DateTime('now', $TZ_LOCAL))->modify('monday this week')->setTime(0, 0);
$endDate   = (clone $startDate)->modify('+13 days')->setTime(23, 59);

$startUtc = (clone $startDate)->setTimezone($TZ_UTC)->format('Y-m-d H:i:s');
$endUtc   = (clone $endDate)->setTimezone($TZ_UTC)->format('Y-m-d H:i:s');

// Load diensten css_class map — index by both ics_key (O365 raw subject) and
// dienst_value stripped of leading # (ICS stored subject, # is stripped on import)
$sth = $dbh->do_query("SELECT ics_key, dienst_value, css_class FROM rooster_diensten WHERE is_active = 1", __LINE__, __FILE__);
$diensten_css = [];
while ($row = $dbh->fetch_assoc($sth)) {
    $diensten_css[$row['ics_key']]                  = $row['css_class'];
    $diensten_css[ltrim($row['dienst_value'], '#')] = $row['css_class'];
}

// Load mailboxes
$sth = $dbh->do_query(
    "SELECT mailbox_email, voornaam, calender_read FROM rooster_mailboxes WHERE `dashboard`='ICT' ORDER BY voornaam",
    __LINE__, __FILE__
);
$mailboxes = [];
$calender_read = [];
while ($row = $dbh->fetch_assoc($sth)) {
    $mailboxes[$row['mailbox_email']]      = $row['voornaam'];
    $calender_read[$row['mailbox_email']]  = (int)$row['calender_read'];
}

$roster = [];
foreach ($mailboxes as $naam) {
    $roster[$naam] = [];
}

// Load events — o365 primary, ics fallback per mailbox
$sth = $dbh->do_placeholder_query("
    SELECT mailbox_email, subject, dtstart, dtend, is_allday
    FROM rooster_o365_events
    WHERE status = 'active'
      AND dtstart < ?
      AND dtend > ?
    UNION ALL
    SELECT i.mailbox_email, i.subject, i.dtstart, i.dtend, i.is_allday
    FROM rooster_ics_events i
    JOIN rooster_mailboxes m ON m.mailbox_email = i.mailbox_email
    WHERE i.status = 'active'
      AND i.dtstart < ?
      AND i.dtend > ?
      AND m.calender_read = 0
    ORDER BY mailbox_email, dtstart
", [$endUtc, $startUtc, $endUtc, $startUtc], __LINE__, __FILE__);

while ($row = $dbh->fetch_assoc($sth)) {
    $email = $row['mailbox_email'];
    if (!isset($mailboxes[$email])) continue;
    $naam = $mailboxes[$email];

    $dtstart = (new DateTime($row['dtstart'], $TZ_UTC))->setTimezone($TZ_LOCAL);
    $dtend   = (new DateTime($row['dtend'],   $TZ_UTC))->setTimezone($TZ_LOCAL);

    $tijd   = $row['is_allday'] ? '00:00 - 00:00' : $dtstart->format('H:i') . ' - ' . $dtend->format('H:i');
    $subject   = $row['subject'];
    $css_class = $diensten_css[$subject] ?? 'overig';
    $type      = ($row['is_allday'] || str_starts_with($css_class, '#')) ? 'full' : 'normal';

    $dayStart = new DateTime($dtstart->format('Y-m-d'), $TZ_LOCAL);
    $dayEnd   = new DateTime($dtend->format('Y-m-d'),   $TZ_LOCAL);
    if ($dtend->format('H:i') === '00:00') {
        $dayEnd->modify('-1 day');
    }
    $dayEnd->modify('+1 day');

    $periode = new DatePeriod($dayStart, new DateInterval('P1D'), $dayEnd);
    foreach ($periode as $datum) {
        if (!in_array($datum->format('N'), [6, 7])) {
            $roster[$naam][$datum->format('Y-m-d')][$type][] = [
                'dienst'   => $subject,
                'cssClass' => $css_class,
                'tijd'     => $tijd,
            ];
        }
    }
}

$nederlandseDagen = ['maandag','dinsdag','woensdag','donderdag','vrijdag','zaterdag','zondag'];
$today = (new DateTime('now', $TZ_LOCAL))->format('Y-m-d');

$dagen = [];
$currentDay = clone $startDate;
while ($currentDay <= $endDate) {
    if (!in_array($currentDay->format('N'), [6, 7])) {
        $dagen[] = [
            'date'    => $currentDay->format('Y-m-d'),
            'dag'     => ucfirst($nederlandseDagen[$currentDay->format('N') - 1]),
            'datum'   => $currentDay->format('d-m'),
            'isToday' => $currentDay->format('Y-m-d') === $today,
        ];
    }
    $currentDay->modify('+1 day');
}

echo json_encode([
    'week1'  => $startDate->format('W'),
    'week2'  => (clone $startDate)->modify('+7 days')->format('W'),
    'dagen'  => $dagen,
    'names'  => array_values($mailboxes),
    'roster' => $roster,
]);
