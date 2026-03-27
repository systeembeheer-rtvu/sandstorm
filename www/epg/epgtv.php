<?php

require_once("/mnt/data/include/config.shredder.inc.php");
require_once("/mnt/data/include/mysqli.inc.php");
$dbh = new sql;
$dbh -> connect();


$jaar = intval(@$_GET['jaar']);
$maand = intval(@$_GET['maand']);
$dag = intval(@$_GET['dag']);
$zender = @$_GET['zender'];
if ($zender!="ustad") $zender="rtvutrecht";

if (!$jaar) {
 	$jaar = 2022;
 	$maand = '1';
 	$dag = '1'; 
}

function addselector($name,$label,$min,$max,$current) {
 	$result = "$label: <select name='$name' onChange='goThere2()'>";
 	for ($i = $min;$i<=$max;$i++) {
 	    	$di = str_pad($i,2,"0",STR_PAD_LEFT);
 		$result.="<option value='$i'";
 		if ($i==$current) $result.= " selected";
 		$result.=">$di</option>";
    	}
    	$result.="</select>\n";
    	return $result;
    
}

echo <<<DUMP
<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<br>
<form name='quick_menu2' method="GET">
DUMP;

echo addselector('jaar','Jaar',2019,2022,$jaar);
echo addselector('maand','Maand',1,12,$maand);
echo addselector('dag','Dag',1,31,$dag);

echo <<<DUMP
<input type="submit" value="go">
</form>
<table class="table table-striped">
<tr><th>Datum</th><th>Tijdstip</th><th>Programma</th><th>Subtitel</th></tr>
DUMP;

$maand = str_pad($maand,2,"0",STR_PAD_LEFT);
$dag = str_pad($dag,2,"0",STR_PAD_LEFT);
$date = "$jaar-$maand-$dag";

$query = "
SELECT uitzending_datum, uitzending_tijdstip, programma_titel, programma_subtitel
FROM  npo.table_epg_gids_tv
WHERE uitzending_datum = '$date' AND zender = '$zender'
ORDER BY uitzending_tijdstip
";

$sth = $dbh->do_query($query,__LINE__,__FILE__);

while (list($datum,$tijdstip,$titel,$subtitel) = $dbh->fetch_array($sth)) {
	echo "<tr><td>$datum</td><td>$tijdstip</td><td>$titel</td><td>$subtitel</td></tr>\n";
     	   
}

echo <<<DUMP
</table>
</body>
</html>
DUMP;

?>
