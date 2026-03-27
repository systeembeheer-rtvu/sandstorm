<?php
require_once("../config.inc.php");
require_once("../mysql.inc.php");
$dbh = new sql;
$dbh -> connect();

$edit=$_POST['edit'];
if ($edit) {
	// waarden in db bijwerken
	$query = "
		update telefoon_gsm
		set EMAIL = ?,
		    PERS_NR = ?,
		    INLIJST = ?,
		    naam = ?,
		    adres = ?,
		    postcode = ?,
		    woonplaats = ?,
		    geboortedatum = ?,
		    imei = ?,
		    merkmodel = ?,
		    datum = ?,
		    opmerkingen = ?,
		    sim = ?,
		    MOBIEL_NR = ?,
		    zapperwachtwoord = ?,
		    portalpassword = ?,
		    extension = ?,
		    NAAM_VODAFONE = ?,
		    ABONNEMENT = ?,
		    PUK = ?
		 where MOBIEL_NR = ?
	";
	$queryvars = array($_POST['EMAIL'],$_POST['PERS_NR'],$_POST['INLIJST'],$_POST['naam'],
	                   $_POST['adres'],$_POST['postcode'],$_POST['woonplaats'],$_POST['geboortedatum'],
	                   $_POST['imei'],$_POST['merkmodel'],$_POST['datum'],$_POST['opmerkingen'],$_POST['sim'],	
	                   $_POST['nummer'],$_POST['zapperpassword'],$_POST['portalpassword'],$_POST['internnummer'],
	                   $_POST['naamvodafone'],$_POST['abonnement'],$_POST['PUK'],
	                   $_POST['nummeroud']);
	$sth = $dbh -> do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
//	header("location: index.php");

	header("location: bewerk.php?nummer={$_POST['nummer']}&edited=1");
	exit;  
		    
}

$new=$_GET['new'];
if ($new) {
	$query = "
		insert into telefoon_gsm
		(MOBIEL_NR)
		values ('new')
	";
	$sth = $dbh -> do_query($query,__LINE__,__FILE__);
	header("location: bewerk.php?nummer=new");
	exit;  
}

$nummer=$_GET['nummer'];
if (!$nummer) {
	echo "Geen nummer!";
	exit;
}

$delete = $_GET['delete'];

if ($delete) {
	if ($delete==1) { 
		echo "Zeker weten? <a href='bewerk.php?nummer=$nummer&delete=2'>Klik hier!</a>";
	} else {
		$query = "
			delete from telefoon_gsm where MOBIEL_NR = ?
		";
		$sth = $dbh -> do_placeholder_query($query,array($nummer),__LINE__,__FILE__);
		header("location: index.php");
	}
	exit;
}

$query = "
	select EMAIL,PERS_NR,NAAM_VODAFONE,INLIJST,naam,adres,postcode,woonplaats,geboortedatum,imei,merkmodel,datum,opmerkingen,sim,ABONNEMENT,zapperwachtwoord,portalpassword,extension,PUK
	from telefoon_gsm
	where MOBIEL_NR = ?
";
$sth = $dbh -> do_placeholder_query($query,array($nummer),__LINE__,__FILE__);	
list($EMAIL,$PERS_NR,$NAAM_VODAFONE,$INLIJST,$naam,$adres,$postcode,$woonplaats,$geboortedatum,$imei,$merkmodel,$datum,$opmerkingen,$sim,$abonnement,$zapperpassword,$portalpassword,$extension,$puk) = $dbh -> fetch_array($sth);

$urlnaam = urlencode($naam);
$today = date("Y-m-d");

$date2 = strtotime($today);  
$date1 = strtotime($datum);  
  
// Formulate the Difference between two dates 
$diff = abs($date2 - $date1);  
$years = floor($diff / (365*60*60*24));  
$months = floor(($diff - $years * 365*60*60*24) 
                               / (30*60*60*24));  
  
$days = floor(($diff - $years * 365*60*60*24 -  
             $months*30*60*60*24)/ (60*60*24)); 

$age = "$years jaar, $months maanden, $days dagen oud"; 

if ($_GET['edited']) { $bewerkt = "<b><font color=\"red\">Bewerkt!</font></b><br><br>"; }

function randomPassword() {
    $alphabet = "abcdefghjklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

$digits = 4;
$portalww = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$zapperww = randomPassword();

$totalkb=0;
$verbruik = <<<DUMP
<table border="1"><tr><th>Beller</th><th>Bestemming</th><th>Nummer</th><th>KB</th><th>duur</th><th>Type dienst</th><th>Start</th><th>Einde</th><th>Kosten</th></tr>
DUMP;
$searchnummer = "+31".ltrim($nummer,"0");
$query = "
	select Beller,Bestemming,Nummer,KB,duur,TypeDienst,Start,Einde,Kosten
	from telefoon_gesprekken
	where Beller = ?
";
$sth = $dbh -> do_placeholder_query($query,array($searchnummer),__LINE__,__FILE__);	
while (list($Beller,$Bestemming,$BestNummer,$kb,$duur,$typedienst,$start,$einde,$kosten) = $dbh -> fetch_array($sth)) {
	$totalkb = $totalkb + $kb;
	$verbruik.="<tr>
	               <td>$Beller</td>
	               <td>$Bestemming</td>
	               <td>$BestNummer</td>
	               <td>$kb</td>
	               <td>$duur</td>
	               <td>$typedienst</td>
	               <td>$start</td>
	               <td>$einde</td>
	               <td>$kosten</td>
	            </tr>";
}
$totalgb = $totalkb/1024/1024;
$verbruik.="</table>Total GB: $totalgb";

echo <<<DUMP
<html><body>
<div 
   id="TipBox" 
   style="
      display:none; 
      position:absolute; 
      font-size:12px; 
      font-weight:bold; 
      font-family:verdana; 
      border:#72B0E6 solid 1px; 
      padding:15px; 
      color:#1A80DB; 
      background-color:#FFFFFF;">
</div>
<script type = "text/javascript">
// Tip Box Display, version 1.0
// Bontrager Connection, LLC
// http://www.willmaster.com/
// -> Functions findPosX and findPosY by 
//    Peter-Paul Koch & Alex Tingle at 
//    http://www.quirksmode.org/js/findpos.html and 
//    http://blog.firetree.net/2005/07/04/javascript-find-position/
//
// One customization:
//
// Specify the ID of the DIV or other container that is the tip box.

var TipBoxID = "TipBox";

// No other customizations required
// // // // // // // // // // // //

var tip_box_id;

function findPosX(obj)
{
   var curleft = 0;
   if(obj.offsetParent)
   while(1) 
   {
      curleft += obj.offsetLeft;
      if(!obj.offsetParent)
         break;
      obj = obj.offsetParent;
   }
   else if(obj.x)
      curleft += obj.x;
   return curleft;
}

function findPosY(obj)
{
   var curtop = 0;
   if(obj.offsetParent)
   while(1)
   {
      curtop += obj.offsetTop;
      if(!obj.offsetParent)
         break;
      obj = obj.offsetParent;
   }
   else if(obj.y)
      curtop += obj.y;
   return curtop;
}

function DisplayTip(me,offX,offY,content) {
   var tipO = me;
   tip_box_id = document.getElementById(TipBoxID);
   var x = findPosX(me);
   var y = findPosY(me);
   tip_box_id.style.left = String(parseInt(x + offX) + 'px');
   tip_box_id.style.top = String(parseInt(y + offY) + 'px');
   tip_box_id.innerHTML = content;
   tip_box_id.style.display = "block";
   tipO.onmouseout = HideTip;
} // function DisplayTip()

function HideTip() { tip_box_id.style.display = "none"; }
</script>

$bewerkt<form  method="post" action="bewerk.php">
<input type="hidden" name="edit" value="1">
<input type="hidden" name="nummeroud" value="$nummer">
<table border="1">
<tr><td><span onmouseover="DisplayTip(this,25,-50,'Mobiele nummer!')">06 nummer (mobiel)<br>030 nummer (ZAPPER only)</span></td><td><input type="text" name="nummer" value="$nummer"></td><tr>
<tr><td>Simkaart</td><td><input type="text" name="sim" value="$sim"></td><tr>
<tr><td>PUK Code</td><td><input type="text" name="PUK" value="$puk"></td><tr>
<tr><td>Intern nummer</td><td><input type="text" name="internnummer" size="5" value="$extension"></td></tr>
<tr><td>Status</td><td><input type="text" name="abonnement" size="40" autofocus="autofocus"  value="$abonnement"></td><tr>
<tr><td><span onmouseover="DisplayTip(this,25,-50,'Was interne naam bij vodafone, nu in gebruik om b.v. stagiair telefoons aan te merken!')">Naam intern</span></td><td><input type="text" name="naamvodafone" size="40" value="$NAAM_VODAFONE"></td><tr>
<tr><td><span onmouseover="DisplayTip(this,25,-50,'Oude telefoonlijst functionaliteit!')">In lijst</span></td><td><input type="text" name="INLIJST" size="40" value="$INLIJST"></td></tr>
<tr><td>Naam</td><td><input type="text" name="naam" size="40" value="$naam"></td></tr>
<tr><td>adres</td><td><input type="text" name="adres" size="40" value="$adres"></td></tr>
<tr><td>postcode</td><td><input type="text" name="postcode" size="40" value="$postcode"></td></tr>
<tr><td>woonplaats</td><td><input type="text" name="woonplaats" size="40" value="$woonplaats"></td></tr>
<tr><td>geboortedatum (YYYY-MM-DD)</td><td><input type="text" name="geboortedatum" size="40" value="$geboortedatum"></td></tr>
<tr><td>imei</td><td><input type="text" name="imei" size="40" value="$imei"></td></tr>
<tr><td>merkmodel</td><td><input type="text" name="merkmodel" size="40" value="$merkmodel"></td></tr>
<tr><td>datum (<input type="text" value="$today">)<br>$age</td><td><input type="text" name="datum" size="40" value="$datum"></td></tr>
<tr><td><span onmouseover="DisplayTip(this,25,-50,'Random gegenereerde mogelijke voicemail code!')">Portal password (<input type="text" value="$portalww">)</input></td><td><input type="text" name="portalpassword" size="40" value="$portalpassword"></td></tr>
<tr><td>Zapper <a href="https://passwordsgenerator.net/?length=10&symbols=1&numbers=1&lowercase=1&uppercase=1&similar=1&ambiguous=1&client=1&autoselect=1" target="_blank">password</a></td><td><input type="text" name="zapperpassword" size="40" value="$zapperpassword"></td></tr>
<tr><td valign="top">Opmerkingen</td><td><textarea name="opmerkingen" cols="40" rows="6">$opmerkingen</textarea></td></tr>
</table>
<input type="submit" value="Bewerken">

<br><br><a href="contract.php?nummer=$nummer">Contract downloaden</a>.<br><br>
<a href="index.php">Hoofdpagina</a><br><br>
<a href="bewerk.php?nummer=$nummer&delete=1">Verwijder nummer.</a><br>
<a href="mailkpneen.php?nummer=$nummer">KPNeen zapper gegevens versturen.</a><br>
<a href="mailzapperonly.php?nummer=$nummer">KPNeen zapper only gegevens versturen.</a>



</body></html>
DUMP;

echo "";

?>