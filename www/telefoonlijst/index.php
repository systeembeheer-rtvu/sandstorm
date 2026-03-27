<?php
require_once("/mnt/data/include/config.inc.php");
require_once("/mnt/data/include/mysqli.inc.php");
$dbh = new sql;
$dbh -> connect();

$actie = $_GET['actie'];
$workstation = $_GET['workstation'];
$workstation_rev = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$workstation_ip = $_SERVER['REMOTE_ADDR'];
$loginnaam = $_GET['loginnaam'];
$naam = trim($naam);
$loginnaam = trim($loginnaam);

echo $workstation;

$query = "
	select name,officephone
	from adusers
	where LOWER(samaccountname) = LOWER(?)
";
$sth = $dbh -> do_placeholder_query($query,array($loginnaam),__LINE__,__FILE__);
list($naam,$telefoonnummer) = $dbh -> fetch_array($sth);

echo "Naam - $naam; Telefoon - $telefoonnummer<br>";

if ($actie == "toevoegen") {
	if ($telefoonnummer == "---") {
		exit;
	}
	
	if (!preg_match('/^172\.1[6789]\./', $workstation_ip)) { // alleen interne ip adressen worden toegevoegd.
		// code wordt momenteel niet gestopt hierdoor.
	}

	$query = "
		replace into telefoonlijst
		(naam,workstation,workstationip,workstationdns,telefoonnummer,login)
		values (? , ? , ? , ? , ? , ? );
	";
	$sth=$dbh->do_placeholder_query($query,array($naam,$workstation,$workstation_ip,$workstation_rev,$telefoonnummer,$loginnaam),__LINE__,__FILE__);
} elseif ($actie == "verwijderen") {
	$query = "
		delete from telefoonlijst
		where workstation = ?
	";
	$sth=$dbh->do_placeholder_query($query,array($workstation),__LINE__,__FILE__); 
}
?>