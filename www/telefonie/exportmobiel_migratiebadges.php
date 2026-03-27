<?php
require_once("../config.inc.php");
require_once("../mysql.inc.php");
$dbh = new sql;
$dbh -> connect();

$query = "
	select naam,NAAM_VODAFONE,MOBIEL_NR,sim,extension
	from telefoon_gsm
	where sim!=''
	and abonnement like '%s4%'
	order by NAAM_VODAFONE,naam
";
$sth = $dbh -> do_query($query,__LINE__,__FILE__);

function echoline($naam,$sim,$nummer,$internnummer) {

	$parts = explode(" ", $naam);
	$lastname = array_pop($parts);
	$firstname = array_shift($parts);
	$middlename = implode(" ", $parts);
	$nummer = preg_replace('/^06/m', '316', $nummer);
	
	echo <<<DUMP
"$sim";"$nummer";"M";"N";"$firstname";"$middlename";"$lastname";"$internnummer";"";"KPN RoutIT";"216137";"RTV Utrecht";"7-3-2017";"RTV Utrecht";"";"ZM Profiel 1"<br>
DUMP;

}


while (list($naam,$naamvodafone,$nummer,$sim,$internnummer) = $dbh -> fetch_array($sth)) {	
	if (preg_match('/\AStagiair \d\z/im', $naamvodafone)) {
		$naam = $naamvodafone;
	}
	if (is_numeric($sim)) echoline($naam,$sim,$nummer,$internnummer);

}


?>