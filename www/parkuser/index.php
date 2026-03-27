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

$query = "
	select status,text
	from park_status
	order by status
";
$sth = $dbh -> do_query($query,__LINE__,__FILE__);	
$statusar = [];
while (list($statusid,$text) = $dbh -> fetch_array($sth)) {
	$statusar[$statusid]=$text;
}

echo <<<DUMP
<!DOCTYPE html>
<html ng-app="app">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Sandstorm</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <meta name="description" content="Sandstorm" />
</head>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<body ng-cloak>

<a href="bewerk.php?new=user">Nieuwe user maken</a><br>
<a href="bewerk.php?new=contact">Nieuw contact maken</a><br>
<a href="bewerk.php?new=dist">Nieuwe distributielijst (met eventueel mail relay) maken</a><br>
<a href="bewerk.php?new=dist">Nieuwe shared mailbox maken</a> Is nu nog even stuk!!<br>
<br>
<table border=1>
<tr><th>Naam</th><th>EMail adres</th><th>Aanvrager</th><th>groep</th><th>Dalet</th><th>status</th><th>Alias</th><th>Aanmaken op</th><th>Laatste aanpassing</th></tr>
DUMP;
$query = "
	select id,voornaam,tussenvoegsel,achternaam,emailadres,aangevraagddoor,groups,dalet,status,alias,aanmakenop,lastchange
	from park_newusers
	where lastchange >= NOW() - INTERVAL 1 YEAR
	order by status asc,
	         aanmakenop desc
";
$sth = $dbh -> do_query($query,__LINE__,__FILE__);

while (list($id,$voornaam,$tussenvoegsel,$achternaam,$emailadres,$aanvrager,$groups,$dalet,$status,$alias,$aanmakenop,$lastchange) = $dbh -> fetch_array($sth)) {	
	$fullname=trim($voornaam." ".$tussenvoegsel)." ".$achternaam;
	if ($dalet) $dalet="Ja"; else $dalet="Nee";

	echo <<<DUMP
	<tr><td><a href="bewerk.php?id=$id">$fullname</a></td><td>$emailadres</td><td>$aanvrager</td><td>$groups</a></td><td>$dalet</td><td>$statusar[$status]</td><td>$alias</td><td>$aanmakenop</td><td>$lastchange</td></tr>
DUMP;

}

echo <<<DUMP

</table>
</body>
<br>
DUMP;
?>
