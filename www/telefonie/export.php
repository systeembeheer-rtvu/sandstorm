<?php
require_once("../config.inc.php");
require_once("../mysql.inc.php");
$dbh = new sql;
$dbh -> connect();

$query = "
	select naam,NAAM_VODAFONE,MOBIEL_NR,sim,extension
	from telefoon_gsm
	where abonnement like '%Zapper%'
	order by naam
";
$sth = $dbh -> do_query($query,__LINE__,__FILE__);

function echoline($naam,$sim,$nummer,$internnummer) {

	$parts = explode(" ", $naam);
	$lastname = array_pop($parts);
	$firstname = array_shift($parts);
	$middlename = implode(" ", $parts);
	if ($middlename) {
		$lastname = "$lastname, $middlename";
	}
	$nummer = preg_replace('/^06/m', '316', $nummer);
	
	$email = str_replace(' ', '.', $naam)."@rtvutrecht.nl";
	
	echo <<<DUMP
"Hengeveldstraat";"Hengeveldstraat";;"$firstname";"$lastname";"ict@rtvutrecht.nl";"$email";"31308500$internnummer";"$internnummer";"IP Centrex";"";"";"RTV Utrecht";"";"";"";"";"Nee";"ja";;"$nummer";"31308500600"<br>
DUMP;

}

while (list($naam,$naamvodafone,$nummer,$sim,$internnummer) = $dbh -> fetch_array($sth)) {	
	if (preg_match('/\AStagiair \d\z/im', $naamvodafone)) {
		$naam = $naamvodafone;
	}
	if (!is_numeric($sim)) echoline($naam,$sim,$nummer,$internnummer);

}
?>