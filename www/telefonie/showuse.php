<?php
require_once("../config.inc.php");
require_once("../mysql.inc.php");
$dbh = new sql;
$dbh -> connect();

$where = "WHERE jaarmaand =  '201609'";

$query = "
	SELECT SUM( KB ) /1024 /1024 AS GB, Beller
	FROM telefoon_gesprekken
	$where
	GROUP BY Beller
	HAVING GB >0
	ORDER BY  `GB` DESC
";
$sth = $dbh->do_query($query,__LINE__,__FILE__);
while (list($gb,$nummer) = $dbh->fetch_array($sth)) {
	$nummer=ltrim($nummer,"+");
	$nummer=ltrim($nummer,"3");
	$nummer=ltrim($nummer,"1");
	$nummer = "0$nummer";
	$query = "
		select naam,NAAM_VODAFONE
		from telefoon_gsm
		where MOBIEL_NR = $nummer
	";
	$sti = $dbh->do_query($query,__LINE__,__FILE__);
	list($naam,$naamintern) = $dbh->fetch_array($sti);

	$special = 1;
	if (!$naamintern) $special=0;
	if (preg_match('/Stagiair/sim', $naamintern)) {
		$special=0;
	} 
	
	if ($special) 
		{ 
			$naam="<b>$naam</b>";
			$specials.="$gb<br>";
			$totalspecial = $totalspecial + floatval($gb);		
		} else {
			$total = $total + floatval($gb);		
		}
		
	$line = "<tr><td>$naam</td><td>$nummer</td><td>$gb</td></tr>";
	
	if ($special) {
		$tab2.=$line;
	} else {
		$tab1.=$line;
	}

}
echo <<<DUMP
<table border=1>
$tab1
$tab2
</table>
$specials<br><br>Totaal specials: $totalspecial<br>Totaal overig: $total

DUMP;

?>