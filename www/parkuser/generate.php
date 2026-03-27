<?php
require_once("/mnt/data/include/config.inc.php");
require_once("/mnt/data/include/mysqli.inc.php");
$dbh = new sql;
$dbh -> connect();

include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();
include '/mnt/data/include/PHPAzureADoAuth/graph.php';
$Graph = new modGraph();

if (!$Auth->checkUserRole('Task.Admin')) {
	echo "Computer says no!";
	exit;
}

$id=$_GET['id'];
$query = "
	select voornaam,tussenvoegsel,achternaam,type,emailadres
	from park_newusers,park_groepen
	where park_newusers.id = ?
	  and park_groepen.naam=park_newusers.groups
";
$sth = $dbh -> do_placeholder_query($query,array($id),__LINE__,__FILE__);
list($voornaam,$tussenvoegsel,$achternaam,$type,$emailadres) = $dbh -> fetch_array($sth);

$fullname=trim($voornaam." ".$tussenvoegsel)." ".$achternaam;
$generate = 0;

if ($type==0) { 
	$generate=1;
	$emailadres = strtolower(str_replace(" ",".",$fullname)."@rtvutrecht.nl");
	$alias = substr($voornaam,0,3).substr($achternaam,0,3);
	$alias = trim($alias,".");
}
$query = "
	update park_newusers
	set emailadres = ?,
	    alias = ?
	where id = ?
";
$dbh -> do_placeholder_query($query,array($emailadres,$alias,$id),__LINE__,__FILE__);
header("location: https://sandstorm.park.rtvutrecht.nl/parkuser/bewerk.php?id=$id&generate=$generate");
exit;
?>