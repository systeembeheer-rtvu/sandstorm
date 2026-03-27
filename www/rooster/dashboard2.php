<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';
include 'config.php';
include 'calenderlib.php';

$smarty = new \Smarty\Smarty();
$smarty->setTemplateDir('/mnt/data/www/rooster/templates/');
$smarty->setCompileDir('/mnt/data/www/rooster/templates_c/');

// Gebruikersnamen mapping
$userNamen = [
    "hans.siemons@rtvutrecht.nl" => "Hans",
    "perry.kramps@rtvutrecht.nl" => "Perry",
    "jurriaan.vreeburg@rtvutrecht.nl" => "Jurriaan",
    "maarten.kaspers@rtvutrecht.nl" => "Maarten",
    "dennis.seuren@rtvutrecht.nl" => "Dennis",
    "wouter.louwerse@rtvutrecht.nl" => "Wouter",
];

$nederlandseDagen = ['maandag','dinsdag','woensdag','donderdag','vrijdag','zaterdag','zondag'];
$filterLocaties = ['RSTR', 'RSTR-RM'];

$accessToken = getAccessToken(
    $calenderconfig['TENANT_ID'],
    $calenderconfig['CLIENT_ID'],
    $calenderconfig['CLIENT_SECRET']
);

$startDate = (new DateTime())->modify('monday this week')->setTime(0, 0);
$endDate = (clone $startDate)->modify('+13 days')->setTime(23, 59);
$today = (new DateTime())->format('Y-m-d');

// Leeg rooster opzetten
$rooster = [];
foreach ($users as $mail => $icsUrl) {
    $naam = $userNamen[$mail] ?? $mail;
    $rooster[$naam] = [];
}

// Events ophalen via Graph
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
                'Prefer' => 'outlook.timezone=\"Europe/Amsterdam\"'
            ],
            'query' => $query,
        ]);
        $data = json_decode($response->getBody(), true);
        return $data['value'] ?? [];
    } catch (Exception $e) {
        return [];
    }
}

// Events verwerken
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
                $key = $datum->format('Y-m-d');
                $type = ($tijd === '00:00 - 00:00' || str_contains($dienstMapped, '#')) ? 'full' : 'normal';
                $rooster[$naam][$key][$type][] = [
                    'dienst' => $dienstMapped,
                    'tijd' => $tijd
                ];
            }
        }
    }
}

// Dagen voorbereiden voor de kop
$dagen = [];
$dagenFormatted = [];
$currentDay = clone $startDate;
while ($currentDay <= $endDate) {
    if (!in_array($currentDay->format('N'), [6, 7])) {
        $dagen[] = clone $currentDay;
        $dagenFormatted[] = [
            'date' => $currentDay->format('Y-m-d'),
            'label' => ucfirst($nederlandseDagen[$currentDay->format('N') - 1]) . '<br />' . $currentDay->format('d-m'),
            'isToday' => $currentDay->format('Y-m-d') === $today
        ];
    }
    $currentDay->modify('+1 day');
}

// CSS class logica
function bepaalCssClass($dienstMapped) {
    $dienstClean = strtolower(preg_replace('/[^a-z0-9]/', '', $dienstMapped));
    return match ($dienstClean) {
        'ictdiv9s' => 'saccent',
        'storingsdienst', 'storingict' => 'storingsdienst',
        'ictdiv9', 'ictpf' => 'div',
        'icts' => 'servicedesk',
        'ictwow9' => 'wow',
        'extern' => 'extern',
        'cursus' => 'cursus',
        default => 'overig',
    };
}

// Weeknummer berekening
$week1 = $startDate->format('W');
$week2 = (clone $startDate)->modify('+7 days')->format('W');

// Smarty instellingen
$smarty->assign('rooster', $rooster);
$smarty->assign('dagen', $dagen); // objectvorm als fallback
$smarty->assign('dagenFormatted', $dagenFormatted);
$smarty->assign('today', $today);
$smarty->assign('week1', $week1);
$smarty->assign('week2', $week2);

// ✅ Register the class mapping function as a modifier
$smarty->registerPlugin('modifier', 'bepaalCssClass', 'bepaalCssClass');

// Template tonen
$smarty->display('dashboard.tpl.html');
