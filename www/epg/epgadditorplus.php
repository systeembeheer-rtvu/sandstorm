<?php

// Voeg de PDO database verbinding toe
require_once("/mnt/data/include/config.epg.inc.php");
require_once("/mnt/data/include/pdo.db.inc.php");

$jaar = intval(@$_GET['jaar']);
$maand = intval(@$_GET['maand']);
$dag = intval(@$_GET['dag']);
$zender = @$_GET['zender'];
if ($zender != "UST" && $zender != "BFM" && $zender != "RUTR") {
    $zender = "RTVU";
}

$huidigjaar = intval(date('Y'));

if (!$jaar) {
    $jaar = $huidigjaar; //todo huidig jaar 
    $maand = '1';
    $dag = '1';
}

$weekdagen = array(
    "Maandag",
    "Dinsdag",
    "Woensdag",
    "Donderdag",
    "Vrijdag",
    "Zaterdag",
    "Zondag"
);

$maand = str_pad($maand, 2, "0", STR_PAD_LEFT);
$dag = str_pad($dag, 2, "0", STR_PAD_LEFT);
$datum = (isset($_GET['dag']) && isset($_GET['maand']) && isset($_GET['jaar']))
    ? sprintf("%02d-%02d-%04d", $_GET['dag'], $_GET['maand'], $_GET['jaar'])
    : date('d-m-Y');
    
function addselector($name, $label, $min, $max, $current){
    $result = "$label: <select name='$name' onChange='goThere2()'>";
    for ($i = $min; $i <= $max; $i++) {
        $di = str_pad($i, 2, "0", STR_PAD_LEFT);
        $result .= "<option value='$i'";
        if ($i == $current) $result .= " selected";
        $result .= ">$di</option>";
    }
    $result .= "</select>";
    return $result;
}

$geselecteerdedatum = date("N", strtotime($datum)) - 1;
$dagnaam = $weekdagen[$geselecteerdedatum];

echo <<<HEADER
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>EPG Additor Plus</title>
</head>
<body>
<h1>EPG Additor Plus</h1>
<h2>$dagnaam $datum</h2>
<form name='selectors' method="GET">
HEADER;

echo addselector('dag', 'Dag', 1, 31, isset($_GET['dag']) ? intval($_GET['dag']) : date('d'));
echo addselector('maand', 'Maand', 1, 12, isset($_GET['maand']) ? intval($_GET['maand']) : date('m'));
echo addselector('jaar', 'Jaar', 2022, $huidigjaar, isset($_GET['jaar']) ? intval($_GET['jaar']) : date('Y'));


// Voeg de zender selector toe
echo "<label>Zender:</label>
      <select name='zender'>
        <option value='RTVU' " . ($zender == 'RTVU' ? 'selected' : '') . ">RTV Utrecht</option>
        <option value='UST' " . ($zender == 'UST' ? 'selected' : '') . ">UStad</option>
        <option value='RUTR' " . ($zender == 'RUTR' ? 'selected' : '') . ">Radio M Utrecht</option>
        <option value='BFM' " . ($zender == 'BFM' ? 'selected' : '') . ">BingoFM</option>
      </select>";

echo <<<TABLEEPG
<input type="submit" value="Ga" style="margin-left: 10px;">
</form>
<br>
TABLEEPG;

// MySQL query
$epgtabel = "
    SELECT ProgDate, ProgStartTime, ProgTitle, ProgItemID, ProgHHID, ProgMediaFile, Published, ShowInMissed, ProgId
    FROM epg
    WHERE ProgDate = :date AND zender = :zender
    ORDER BY ProgStartTime
";

$stmt = $connweb->prepare($epgtabel);
$stmt->bindParam(':date', $datum);
$stmt->bindParam(':zender', $zender);
$stmt->execute();

// Kijken of er data in de database zit
if ($stmt->rowCount() > 0) {
    // Wanneer data beschikbaar is
    echo <<<TABLEEPG
    <table class="styled-table">
    <tr>
        <th>Datum</th>
        <th>Tijdstip</th>
        <th>Programma</th>
        <th>Herhaling</th>
        <th>Gepubliceerd</th>
        <th>Uitzending Gemist</th>
    </tr>
    TABLEEPG;

    $row['ProgId'] = "https://www.rtvutrecht.nl/tv/aflevering/";

    // Laat de resultaten zien in de tabel
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $origineel = $row['ProgItemID'] == $row['ProgHHID'];
        $gemist = $row['ShowInMissed'];
        echo "<tr>
            <td>{$row['ProgDate']}</td>
            <td>{$row['ProgStartTime']}</td>
            <td>{$row['ProgTitle']}</a></td>
            <td>" . ($origineel ? 'Nee' : 'Ja') . "</td>
            <td>" . ($row['Published'] ? 'Ja' : 'Nee') . "</td>
            <td>" . ($gemist ? 'Ja' : 'Nee') . "</td>
        </tr>\n";
    }

    echo "</table>";
} else {
    // Wanneer geen data beschikbaar is
    echo "Er is geen data beschikbaar voor deze datum en zender.";
}

echo <<<FOOTER
</body>
</html>
FOOTER;

?>