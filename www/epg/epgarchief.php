<?php

// Voeg de PDO database verbinding toe
require_once("/mnt/data/include/config.epg.inc.php");
require_once("/mnt/data/include/pdo.db.inc.php");


$jaar = intval(@$_GET['jaar']);
$maand = intval(@$_GET['maand']);
$dag = intval(@$_GET['dag']);
$zender = @$_GET['zender'];
if ($zender != "ustad" && $zender != "bingofm" && $zender != "radiomutrecht") {
    $zender = "rtvutrecht";
}

if (!$jaar) {
    $jaar = 2022;
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
$datum = "$jaar-$maand-$dag";
$datumvolgorde = "$dag-$maand-$jaar";
if (($datum >= "2019-08-30") && ($zender == "ustad" || $zender == "rtvutrecht")) {
    $tabel = "table_epg_gids_tv";
} else {
    $tabel = "table_epg_gids";
}

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
    <title>EPG Archief</title>
</head>
<body>
<h1>EPG Archief</h1>
<h2>$dagnaam $datumvolgorde</h2>
<form name='selectors' method="GET">
HEADER;

echo addselector('dag', 'Dag', 1, 31, $dag);
echo addselector('maand', 'Maand', 1, 12, $maand);
echo addselector('jaar', 'Jaar', 2011, 2022, $jaar);

// Voeg de zender selector toe
echo "<label>Zender:</label>
      <select name='zender'>
        <option value='rtvutrecht' " . ($zender == 'rtvutrecht' ? 'selected' : '') . ">RTV Utrecht</option>
        <option value='ustad' " . ($zender == 'ustad' ? 'selected' : '') . ">UStad</option>
        <option value='radiomutrecht' " . ($zender == 'radiomutrecht' ? 'selected' : '') . ">Radio M Utrecht</option>
        <option value='bingofm' " . ($zender == 'bingofm' ? 'selected' : '') . ">BingoFM</option>
      </select>";

echo <<<TABLEEPG
<input type="submit" value="Ga" style="margin-left: 10px;">
</form>
<br>
TABLEEPG;

// MySQL query
$epgtabel = "
    SELECT id,uitzending_datum, uitzending_tijdstip, programma_titel, programma_subtitel
    FROM $tabel
    WHERE uitzending_datum = :date AND zender = :zender
    AND programma_herhaling = 0
    AND uitzendinggemist_omroep = 1
    ORDER BY uitzending_tijdstip
";

$stmt = $connnpo->prepare($epgtabel);
$stmt->bindParam(':date', $datum);
$stmt->bindParam(':zender', $zender);
$stmt->execute();

// Kijken of er data in de database zit
if ($stmt->rowCount() > 0) {
    // Wanneer data beschikbaar is
    echo <<<TABLEEPG
    <table class="styled-table">
    <tr>
        <th>ID</th>
        <th>Datum</th>
        <th>Tijdstip</th>
        <th>Programma</th>
        <th>Subtitel</th>
    </tr>
    TABLEEPG;

    // Laat de resultaten zien in de tabel
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['uitzending_datum']}</td>
            <td>{$row['uitzending_tijdstip']}</td>
            <td>{$row['programma_titel']}</td>
            <td>{$row['programma_subtitel']}</td>
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