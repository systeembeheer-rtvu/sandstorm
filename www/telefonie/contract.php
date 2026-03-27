<?php
// database class + database config
require_once("../config.inc.php");
require_once("../mysql.inc.php");
$dbh = new sql;
$dbh -> connect();

$nummer=$_GET['nummer'];
$negeerdatum = $_GET['negeerdatum'];

if (!nummer) {
	echo "Geen nummer";
	exit;
}

$query = "
	SELECT naam, adres, postcode, woonplaats, DATE_FORMAT(geboortedatum, '%d-%m-%Y') , imei, merkmodel, DATE_FORMAT(datum, '%d-%m-%Y') , DATE_FORMAT(CURDATE(), '%d-%m-%Y')
	FROM telefoon_gsm 
	WHERE MOBIEL_NR = ?
";	
$sth = $dbh -> do_placeholder_query($query,array($nummer),__LINE__,__FILE__);
list($naam,$adres,$postcode,$woonplaats,$geboortedatum,$imei,$merkmodel,$datum,$curdate) = $dbh -> fetch_array($sth);

if ($datum!=$curdate && !$negeerdatum) {
	echo <<<DUMP
	Datum is niet de huidige datum!<br><br>
	<a href="http://intranet/admin/telefonie/contract.php?nummer=$nummer&negeerdatum=1">Contract toch downloaden!</a><br>
	<a href="http://intranet/admin/telefonie/bewerk.php?nummer=$nummer">Bewerken!</a>
DUMP;
	exit;
}

$file = file_get_contents('contract.rtf');
$file = str_ireplace('*naam*', $naam, $file);
$file = str_ireplace('*adres*', $adres, $file);
$file = str_ireplace('*postcode*', $postcode, $file);
$file = str_ireplace('*plaats*', $woonplaats, $file);
$file = str_ireplace('*geboortedatum*', $geboortedatum, $file);
$file = str_ireplace('*serienummer*', $imei, $file);
$file = str_ireplace('*merktype*', $merkmodel, $file);
$file = str_ireplace('*datum*', $datum, $file);
$file = str_ireplace('*telefoonnummer*', $nummer, $file);
$file = str_ireplace('*lvt*', $lvtnummer, $file);

$contractfile = preg_replace("/[^A-Za-z0-9]/", "", $naam)."rtf";

// write the file
//file_put_contents("contract/$nummer.rtf", $file);

header("Content-type: application/force-download"); 
header('Content-Disposition: inline; filename="contract.rtf"'); 
header("Content-Transfer-Encoding: Binary"); 
header("Content-length: ".strlen($file)); 
header('Content-Type: application/octet-stream'); 
header('Content-Disposition: attachment; filename="contract.rtf"'); 
echo $file;
?>