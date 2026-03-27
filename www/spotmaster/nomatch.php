<?php
// spotmaster opzoeker!

require_once("../config.inc.php");
require_once("../mysql.inc.php");
$dbh = new sql;
$dbh -> connect();

$names = file("log.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$first = 1;
$found = 0;
$body = "Beste collega,\r\nBij de volgende gebruikers in het tagsysteem is geen match gevonden in Active Directory\r\n";

foreach ($names as &$naam) {
	if ($first) {
		$date = $naam;
		$first = 0;
	} else {
		$query = "
			select max(LASTUSE) from spotmaster
			where NAAM = ?
		";
		$sth = $dbh -> do_placeholder_query($query,array($naam),__LINE__,__FILE__);		
		list($lastuse) = $dbh -> fetch_array($sth);
		$body.="\t$naam ($lastuse voor het laatst gebruikt)\r\n";
		$found = 1;
	}
}

if ($found) {

	$body.=<<<DUMP
Komt de naam exact overeen met de naam in active directory? (tussenvoegsels moeten bij middlename, van der wordt vd bijvoorbeeld)
Is het een RTV Utrecht medewerker zonder active directory account, maak dan van department RTVU Extra.
Is het wel een RTV Utrecht medewerker? Zo niet vul dan het goede department in.
Groetjes,
Scriptje
DUMP;

	
	$to = "ict@rtvutrecht.nl";
	$subject = "Geen match gevonden tussen impro en Active Directory";
	$headers = "From: ict@rtvutrecht.nl\r\nBcc: hans.siemons@rtvutrecht.nl";
	mail($to,$subject,$body,$headers);
}

?>