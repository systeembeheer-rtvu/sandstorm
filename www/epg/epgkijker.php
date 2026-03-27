<?php

/*
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
*/

session_start();

require_once("/mnt/data/include/config.shredder.inc.php");
require_once("/mnt/data/include/mysqli.inc.php");
require_once("/mnt/data/www/vendor/autoload.php");

$dbh = new sql;
$dbh->connect();

$smarty = new \Smarty\Smarty();
$smarty->setTemplateDir('/mnt/data/www/epg/templates/');
$smarty->setCompileDir('/mnt/data/www/epg/templates_c/');

// Channels
$channels = [
    'RTVU' => 'RTV Utrecht',
    'BFM'  => 'Bingo FM',
    'UST'  => 'UStad',
    'RUTR' => 'Radio M Utrecht'
];

// Date selection
if (isset($_GET['datum'])) {
    $_SESSION['epg_datum'] = $_GET['datum'];
}
$selected_date = $_SESSION['epg_datum'] ?? date('Y-m-d');
$formatted_date = str_replace('-', '', $selected_date);
$prev_date = date('Y-m-d', strtotime($selected_date . ' -1 day'));
$next_date = date('Y-m-d', strtotime($selected_date . ' +1 day'));
$display_date = strftime("%A %d-%m-%Y", strtotime($selected_date));

// Channel selection
if (isset($_GET['zender']) && array_key_exists($_GET['zender'], $channels)) {
    $_SESSION['epg_zender'] = $_GET['zender'];
}
$selected_channel = $_SESSION['epg_zender'] ?? 'RTVU';

// Rerun toggle
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['show_reruns'])) {
        $_SESSION['epg_show_reruns'] = 1;
    } elseif (isset($_GET['datum']) || isset($_GET['zender'])) {
        $_SESSION['epg_show_reruns'] = 0;
    } elseif (!isset($_SESSION['epg_show_reruns'])) {
        $_SESSION['epg_show_reruns'] = 1;
    }
}
$show_reruns = $_SESSION['epg_show_reruns'];

// SQL
$query = "
    SELECT 
        p.datum, 
        p.tijd AS ProgStartTime,
        e.ProgDuration,
        p.herhaling,
        e.SeriesTitle,
        e.ProgAlternativeTitle,
        e.ProgTitle,
        e.ShowInMissed,
        p.daletid
    FROM epg_programmering p
    LEFT JOIN epg_episodes e ON p.daletid = e.daletid
    WHERE p.zender = '{$selected_channel}'
    AND p.datum = '{$formatted_date}'";

if (!$show_reruns) {
    $query .= " AND p.herhaling = 0";
}

$query .= " ORDER BY p.tijd";

$sth = $dbh->do_query($query, __LINE__, __FILE__);

$programs = [];
while (list($datum, $start, $lengte, $herhaling, $series, $title, $alternativetitle, $showinmissed,$daletid) = $dbh->fetch_array($sth)) {
    /*
	if (preg_match('/\A\d\d:00:00\z/im', $start)) {
	    $start = "<b>$start</b>";
    }
    */
    $title = $title." ".$alternativetitle;
    $programs[] = [
        'datum' => $datum,
        'start' => $start,
        'duur' => round($lengte / 60),
        'herhaling' => $herhaling ? 'Ja' : 'Nee',
        'gemist' => ($showinmissed === 'TRUE') ? '✅' : '',
        'title' => $title ?: '-',
        'daletid' => $daletid
    ];
}

$columns = [
    'datum'     => 'Datum',
    'start'     => 'Starttijd',
    'duur'      => 'Lengte (minuten)',
    'herhaling' => 'Herhaling',
    'title'     => 'Programmatitel',
    'gemist'    => 'Uitzending gemist',
    'daletid'   => 'Additor link',
];

// Assign vars to Smarty
$smarty->assign('columns', $columns);
$smarty->assign(compact(
    'channels',
    'selected_channel',
    'selected_date',
    'prev_date',
    'next_date',
    'display_date',
    'show_reruns',
    'programs'
));

$smarty->display('epgkijker.tpl');
?>