<?php
require_once("../config.inc.php");
require_once("../mysql.inc.php");
$dbh = new sql;
$dbh -> connect();

$nummers = "";

$nummersar = explode(" ", $nummers);
$nummersverbruikar = array();

$query = "select distinct Beller from telefoon_gesprekken";
$sth = $dbh -> do_query($query,__LINE__,__FILE__);
while (list($nummer) = $dbh -> fetch_array($sth)) {		
	$nummer = "0".substr($nummer,3);
	$nummersverbruikar[]=$nummer;
	
}

echo <<<DUMP
<a href="bewerk.php?new=1">Maak nieuwe entry</a><hr>


<table>
<tr><th>Naam</th><th>Naam intern</th><th>Status</th><th>Nummer</th><th>Contractdatum</th><th>IMEI</th><th>extension</th><th>Toestel</th></tr>
DUMP;
$query = "
	select naam,NAAM_VODAFONE,MOBIEL_NR,DATUM,sim,imei,VERBRUIK,EMAIL,inlijst,abonnement,sim,merkmodel,extension
	from telefoon_gsm
	where abonnement != 'delete'
	order by NAAM_VODAFONE asc,datum asc
";
//	order by NAAM_VODAFONE,naam

//	  and merkmodel like '%5c%'



//  0613341436 0652509543 ------

$sth = $dbh -> do_query($query,__LINE__,__FILE__);

while (list($naam,$naamvodafone,$nummer,$datum,$sim,$imei,$verbruik,$email,$inlijst,$abonnement,$sim,$merkmodel,$extension) = $dbh -> fetch_array($sth)) {	
	$nummers = str_replace($nummer,"",$nummers);
	if (!$naam) { $naam="---"; }
	if (in_array($nummer,$nummersar)) { $naam = "<b>$naam</b>"; }	
	if ($datum=="0000-00-00") $datum = "-";

//	if ($inlijst) { 
	if (1) { 
	echo <<<DUMP
	<tr><td>$naam&nbsp;</td><td>$naamvodafone</td><td>$abonnement</td><td><a href="bewerk.php?nummer=$nummer">$nummer</a></td><td>$datum</td><td>$imei</td><td>$extension</td><td>$merkmodel</td></tr>
DUMP;
	}

}
echo "</table>";

// echo "---- $nummers ------";

?>