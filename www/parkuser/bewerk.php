<?php
require_once("/mnt/data/include/config.inc.php");
require_once("/mnt/data/include/mysqli.inc.php");
$dbh = new sql;
$dbh -> connect();

/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();
include '/mnt/data/include/PHPAzureADoAuth/graph.php';
$Graph = new modGraph();

if (!$Auth->checkUserRole('Task.Admin')) {
	echo "Computer says no!";
	exit;
}

$new = $_GET['new'] ?? null;
$generate = $_GET['generate'] ?? null;

$edit = $_POST['edit'] ?? null;

if ($edit) {
	// waarden in db bijwerken
	if (!$_POST['id']) {
		// nieuwe user maken
		$query = "
			INSERT INTO park_newusers (lastchange) VALUES (CURRENT_TIMESTAMP);
		";
		$dbh -> do_query($query,__LINE__,__FILE__);

		// Get the id
		$query = "
			SELECT last_insert_id()
		";
		$sth = $dbh -> do_query($query,__LINE__,__FILE__);
		list ($id) = $dbh -> fetch_array($sth);
		$_POST['id']=$id;	
		$new = 1;
	}
	
	if ($_POST['status']==9) {
		// verwijderen
		$query = "
			delete
			from park_newusers
			where id = ?
		";
		$sth = $dbh -> do_placeholder_query($query,array($_POST['id']),__LINE__,__FILE__);
		header("location: index.php");
	} else {
		$mobilephone = $_POST['mobilephone'];
		preg_match_all('/\d/', $mobilephone, $result, PREG_PATTERN_ORDER);

		$mobilephone = implode('',$result[0]);		
		$mobilephone = "+31 6".substr($mobilephone,-8); # pak laatste 8 cijfers, en plak daar '+31 6' voor.
		
		$status = $_POST['status'] ?? 0;
				
		$query = "
			update park_newusers
			set voornaam = ?,
			    tussenvoegsel = ?,
			    achternaam = ?,
			    emailadres = ?,
			    mobilephone = ?,
			    aangevraagddoor = ?,
			    groups = ?,
			    status = ?,
			    alias = ?,
			    topdeskcall = ?,
			    aanmakenop = ?
			 where id = ?
		";
		echo "<pre>"; var_dump($_POST);
		$queryvars = array(trim($_POST['voornaam']),trim($_POST['tussenvoegsel']),trim($_POST['achternaam']),trim($_POST['emailadres']),$mobilephone,
		                   $_POST['aangevraagddoor'],$_POST['groups'],$status,
		                   $_POST['alias'],$_POST['topdeskcall'],$_POST['aanmakenop'],
		                   $_POST['id']);
		$sth = $dbh -> do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
		if ($new) {
			header("location: generate.php?id=$id");
		} else {
			header("location: bewerk.php?id={$_POST['id']}&edited=1");
		}
		exit;  
	}  
}

$id=$_GET['id'];

$today = date("Y-m-d");

if ($id) {
	$query = "
		select voornaam,tussenvoegsel,achternaam,emailadres,mobilephone,aangevraagddoor,groups,dalet,status,alias,topdeskcall,aanmakenop
		from park_newusers
		where id = ?
	";
	$sth = $dbh -> do_placeholder_query($query,array($id),__LINE__,__FILE__);	
	list($voornaam,$tussenvoegsel,$achternaam,$emailadres,$mobilephone,$aangevraagddoor,$groups,$dalet,$status,$alias,$topdeskcall,$aanmakenop) = $dbh -> fetch_array($sth);
	
	if ($groups=='Contact maken') {
		$type="contact";
	} elseif (stripos($groups,'Distributielijst') !== FALSE) {
		$type="dist";		
	} else {
		$type="user";
	}

} else {
	$aanmakenop=$today;
	$status="0";
	$dalet="1";
	$groups="TG Leeg";
	$type = $new;
	if ($type=="dist") { $groups = "Distributielijst maken"; }
	if ($type=="contact") { $groups = "Contact maken"; }
}

$firstname = "Voornaam";
if ($type=="dist") $firstname = "Naam distributiegroep";

if (@$_GET['edited']) { $bewerkt = "<b><font color=\"red\">Bewerkt!</font></b><br><br>"; }

if ($generate) {  
	$alertstart = "<font color=\"orange\">";
	$alertstop = "</font>";	 
	$bewerkt = "<b>{$alertstart}E-Mail adres en alias gegenereert! Controleer deze en pas eventueel aan!$alertstop</b><br><br>"; 
		 
}


$query = "
	SELECT count(*)  
	FROM adusers 
	WHERE LOWER(samaccountname) = LOWER(?)
";
$sth = $dbh -> do_placeholder_query($query,array($alias),__LINE__,__FILE__);	
list($userfound) = $dbh -> fetch_array($sth);
if ($userfound) {
	$alert="<font color=\"red\"><strong>ALIAS BESTAAT MISSCHIEN AL<sup>(*)</sup>!</strong><br>Controleer in ad/disk of deze alias al echt in gebruik is.<br>Zo ja andere alias kiezen,<br>zo nee gewoon status op goedgekeurd zetten&nbsp;<br>";
} else {
	$alert="<font>";
}

echo <<<DUMP
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ParkUser</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({
      altField: "#datepicker",
      altFormat: "yy-mm-dd"
    });
  } );
  </script>
</head>
<body>

<form  method="post" action="bewerk.php">
<input type="hidden" name="edit" value="1">
<input type="hidden" name="id" value="$id">
<table border="1">
<tr><td>$firstname</td><td><input type="text" name="voornaam" value="$voornaam"></td><td>&nbsp;</td></tr>
DUMP;

if ($type!="dist") {
	echo <<<DUMP
<tr><td>Tussenvoegsel</td><td><input type="text" name="tussenvoegsel" value="$tussenvoegsel"></td><td><i>volledig tussenvoegsel. Van der en van den hoeft niet meer afgekort te worden.</td><tr>0
<tr><td>Achternaam</td><td><input type="text" name="achternaam" value="$achternaam"></td><td>&nbsp;</td></tr>
DUMP;
}



if ($type=="user") {
	$nummeralert = "&nbsp;";
	if ($mobilephone!="") {
		if (!preg_match('/\A\+31 6\d{8}\z/i', $mobilephone)) {
			$nummeralert = "<font color=\"red\">Mobiel nummer NIET correct!</font> Mocht het geen normale gebruiker betreffen mag je +31 611111111 invullen.";
			if (intval($status) == 1) {
				$status = 0;
				$query2 = "
					update park_newusers
					set status = 0
					where id = ?
				";
				$stq = $dbh -> do_placeholder_query($query2,array($id),__LINE__,__FILE__);
			}
		} 
	}
	echo <<<DUMP
<tr><td>Mobiel nummer</td><td><input type="text" name="mobilephone" value="$mobilephone"></td><td>$nummeralert</td></tr>
DUMP;
}

$selectedstatus[$status]="selected";

$query = "
	select status,text
	from park_status
	order by status
";
$sth = $dbh -> do_query($query,__LINE__,__FILE__);	

$options = "";
while (list($statusid,$text) = $dbh -> fetch_array($sth)) {
	if ($statusid==$status) $selected=" selected"; else $selected = "";
	$options.="<option value=\"$statusid\"$selected>$text</option>";
}


$groep = "Actie";
if ($type=="contact") $typevalue=1; elseif ($type=="dist") $typevalue=2; else { $typevalue=0; $groep = "Template groep"; }

$query = "
	select naam
	from park_groepen
	where type = $typevalue
	order by naam
";

$sth = $dbh -> do_query($query,__LINE__,__FILE__);	
$groepen="";
$valuefound=0;
while (list($groepnamen) = $dbh -> fetch_array($sth)) {
	if ($groepnamen==$groups) { $checked=" checked"; $valuefound=1; } else $checked = "";
	$groepen.="<input type=\"radio\" name=\"groups\" value=\"$groepnamen\"$checked>$groepnamen<br>";
}
if (!$valuefound) {
	$groepen.="<input type=\"radio\" name=\"groups\" value=\"$groups\" checked>$groups<br>";
}


if ($dalet) $daletchecked = " checked"; else $daletchecked="";

$alertstart = $alertstart ?? '';
$alertstop = $alertstop ?? '';
$bewerkt = $bewerkt ?? '';

if ($type=='user') {
	$aliasline = "<tr><td>{$alertstart}{$alert}Alias (inlognaam){$alertstop}</font></td><td><input type=\"text\" name=\"alias\" size=\"40\" value=\"$alias\"></td><td>&nbsp;</td></tr>";
	$daletline = "<tr><td>Dalet</td><td><input type=\"checkbox\" name=\"dalet\" value=\"1\"$daletchecked></td><td><i>Voegt user toe aan PG Dalet Client Verslaggeving</i></td></tr>";
	$emailaddresshint = "<i>Dit is altijd een RTV Utrecht mail adres voor een user, nooit bingofm.nl<br>Betreft het een bingofm medewerker achteraf bingofm.nl adres als alias toevoegen.<br>Alleen reclame krijgt voornaam@rtvutrecht.nl als mail adres. De rest voornaam.tussenvoegsel.achternaam@rtvuutrecht.nl</i>";
} else {
	$emailaddresshint = "&nbsp;";
}

$emailaddressline = "<tr><td>{$alertstart}EMail adres{$alertstop}</td><td><input type=\"text\" name=\"emailadres\" size=\"40\" value=\"$emailadres\"></td><td>$emailaddresshint</tr></tr>";

if (($id) or ($typevalue != 0)) echo $emailaddressline;

if ($id) {

switch ($status) {
	case 0:
		$statushint = "<font color=\"red\">Nog niet goedgekeurd</font>";
		break;
	case 8: 
		$statushint = "<font color=\"green\">Done</font>";
		break;
	default:
		$statushint = "<font color=\"purple\">Processing</font>";
		break;
}

echo <<<DUMP
$aliasline
<tr><td>Status</td><td>
  <select name="status">
    $options
  </select>
</td><td>$statushint</tr>
DUMP;
	$opslaan = "Opslaan";
	$generate = "<a href=\"generate.php?id=$id\">Genereer email adres en alias aan de hand van voornaam/tussenvoegsel/achternaam (eerst opslaan!!!)</a><br><br>";

} else {
	$opslaan = "Opslaan en email adres+alias genereren";


}

echo <<<DUMP
<tr><td>Aangevraagd door</td><td><input type="text" name="aangevraagddoor" size="40" value="$aangevraagddoor"></td><td>&nbsp;</td></tr>
<tr><td valign="top">$groep</td><td>$groepen</td><td>&nbsp;</td></tr>
<tr><td>TOPdesk call</td><td><input type="text" name="topdeskcall" size="40" value="$topdeskcall"></td><td>&nbsp;</td></tr>
<tr><td>Aanmaken op (YYYY-MM-DD) (<input type="text" value="$today">)</td><td><input type="text" name="aanmakenop" size="40" value="$aanmakenop" id="datepicker"></td><td>&nbsp;</td></tr>
</table>
<input type="submit" value="$opslaan"> $bewerkt

<br><br><a href="index.php">Hoofdpagina</a><br><br>
$generate
</body></html>
DUMP;

echo "";

?>