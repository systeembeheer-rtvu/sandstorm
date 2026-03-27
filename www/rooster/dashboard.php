<?php

header("location: https://sandstorm.park.rtvutrecht.nl/rooster/rooster_dashboard.php");
exit;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';
include 'config.php';
include 'calenderlib.php';

// Gebruikersnamen mapping
$userNamen = [
    "hans.siemons@rtvutrecht.nl" => "Hans",
    "perry.kramps@rtvutrecht.nl" => "Perry",
    "jurriaan.vreeburg@rtvutrecht.nl" => "Jurriaan",
    "maarten.kaspers@rtvutrecht.nl" => "Maarten",
    "dennis.seuren@rtvutrecht.nl" => "Dennis",
    "wouter.louwerse@rtvutrecht.nl" => "Wouter",
];

// Dagen mapping
$nederlandseDagen = [
    'maandag',
    'dinsdag',
    'woensdag',
    'donderdag',
    'vrijdag',
    'zaterdag',
    'zondag'
];

$accessToken = getAccessToken(
    $calenderconfig['TENANT_ID'],
    $calenderconfig['CLIENT_ID'],
    $calenderconfig['CLIENT_SECRET']
);

$startDate = (new DateTime())->modify('monday this week')->setTime(0, 0);
$endDate = (clone $startDate)->modify('+13 days')->setTime(23, 59);

$filterLocaties = ['RSTR', 'RSTR-RM'];
$rooster = [];

foreach ($users as $mail => $icsUrl) {
    $naam = $userNamen[$mail] ?? $mail;
    $rooster[$naam] = [];
}

function getCalendarViewEvents($accessToken, $email, $startDate, $endDate) {
    $client = new \GuzzleHttp\Client();
    $url = "https://graph.microsoft.com/v1.0/users/$email/calendarView";

    $query = [
        'startDateTime' => $startDate . 'T00:00:00',
        'endDateTime' => $endDate . 'T23:59:59',
        '$top' => 999,
    ];

    try {
        $response = $client->get($url, [
            'headers' => [
                'Authorization' => "Bearer $accessToken",
                'Prefer' => 'outlook.timezone="Europe/Amsterdam"'
            ],
            'query' => $query,
        ]);

        $data = json_decode($response->getBody(), true);
        return $data['value'] ?? [];
    } catch (Exception $e) {
        echo "<pre>Fout bij ophalen events: {$e->getMessage()}</pre>";
        return [];
    }
}

foreach ($users as $mail => $icsUrl) {
    $naam = $userNamen[$mail] ?? $mail;
    $events = getCalendarViewEvents($accessToken, $mail, $startDate->format('Y-m-d'), $endDate->format('Y-m-d'));

    foreach ($events as $event) {
        $locatie = $event['location']['displayName'] ?? '';
        if (stripos($locatie, 'rstr') === false) continue;

        $start = new DateTime($event['start']['dateTime'], new DateTimeZone('Europe/Amsterdam'));
        $einde = new DateTime($event['end']['dateTime'], new DateTimeZone('Europe/Amsterdam'));

        $tijd = $start->format('H:i') . ' - ' . $einde->format('H:i');
        $dienst = $event['subject'];
        $dienstMapped = strtolower($diensten[$dienst] ?? $dienst);

        $eindeDatum = new DateTime($einde->format('Y-m-d'));
        if ($einde->format('H:i') === '00:00') {
            $eindeDatum->modify('-1 day');
        }

        $periode = new DatePeriod(
            new DateTime($start->format('Y-m-d')),
            new DateInterval('P1D'),
            $eindeDatum->modify('+1 day')
        );

        foreach ($periode as $datum) {
            if (!in_array($datum->format('N'), [6, 7])) {
                $rooster[$naam][$datum->format('Y-m-d')][] = [
                    'dienst' => $dienstMapped,
                    'tijd' => $tijd
                ];
            }
        }
    }
}

$dagen = [];
$currentDay = clone $startDate;
while ($currentDay <= $endDate) {
    if (!in_array($currentDay->format('N'), [6, 7])) {
        $dagen[] = clone $currentDay;
    }
    $currentDay->modify('+1 day');
}

$today = (new DateTime())->format('Y-m-d');

function bepaalCssClass($dienstMapped) {
    // Strip speciale tekens en lowercase
    $dienstClean = strtolower(preg_replace('/[^a-z0-9]/', '', $dienstMapped));

    return match ($dienstClean) {
        'ictdiv9s' => 'saccent',
        'storingsdienst', 'storingict' => 'storingsdienst',
        'ictdiv9' => 'div',
        'ictpf' => 'div',
        'icts' => 'servicedesk',
        'ictwow9', 'ictwow' => 'wow',
        'extern' => 'extern',
        'cursus' => 'cursus',
        default => 'overig',
    };
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Rooster ICT</title>
    <link rel="stylesheet" href="style.css?v=1">
</head>
<body>

<table class="roster-table">
    <thead>
        <tr>
            <th class="largeheader text-center">Week <br /> <?= $startDate->format('W') ?> / <?= (clone $startDate)->modify('+7 days')->format('W') ?></th>
            <?php foreach ($dagen as $index => $dag): ?>
                <th class="largeheader text-center <?= $dag->format('Y-m-d') === $today ? 'bgRed' : '' ?>">
                    <?= ucfirst($nederlandseDagen[$dag->format('N') - 1]) ?><br /><?= $dag->format('d-m') ?>
                </th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rooster as $naam => $dagenData): ?>
            <tr class="customrow">
                <td class="largename"><?= htmlspecialchars($naam) ?></td>
                <?php foreach ($dagen as $dag): ?>
                    <td class="custompadding">
                    <?php
                        $dateKey = $dag->format('Y-m-d');
                        $blokken = $dagenData[$dateKey] ?? [];

                        // Split blokken in full-day en normale blokken
                        $fullDayBlocks = [];
                        $normalBlocks = [];

                        foreach ($blokken as $blok) {
                            if ($blok['tijd'] === '00:00 - 00:00' || str_contains($blok['dienst'], '#')) {
                                $fullDayBlocks[] = $blok;
                            } else {
                                $normalBlocks[] = $blok;
                            }
                        }
                    ?>

                    <?php if (!empty($fullDayBlocks)): ?>
                        <div class="cell-full-day">
                        <?php foreach ($fullDayBlocks as $blok): ?>
                            <?php $class = bepaalCssClass($blok['dienst']); ?>
                            <p class="<?= $class ?> largetime text-center">&nbsp;</p>
                        <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($normalBlocks)): ?>
                        <div class="cell-flex">
                            <?php foreach ($normalBlocks as $blok): ?>
                                <?php $class = bepaalCssClass($blok['dienst']); ?>
                                <p class="<?= $class ?> largetime text-center"><?= htmlspecialchars($blok['tijd']) ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Legenda -->
<div class="row legend">
    <div class="col-md-2"><p class="div largetime text-center">DIV</p></div>
    <div class="col-md-2"><p class="servicedesk largetime text-center">Servicedesk</p></div>
    <div class="col-md-2"><p class="saccent largetime text-center">S-accent</p></div>
    <div class="col-md-2"><p class="wow largetime text-center">WOW</p></div>
    <div class="col-md-2"><p class="cursus largetime text-center">Cursus</p></div>
    <div class="col-md-2"><p class="extern largetime text-center">Extern</p></div>
    <div class="col-md-2"><p class="overig largetime text-center">Overig</p></div>
    <div class="col-md-2"><p class="storingsdienst largetime text-center">Storingsdienst</p></div>
</div>
<script>
    setInterval(function() {
      location.reload();
    }, 900000); // 15 minutes
</script>
</body>
</html>
