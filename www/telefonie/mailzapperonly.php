<?php

function count_capitals($s) {
  return strlen(preg_replace('![^A-Z]+!', '', $s));
}

require_once("../config.inc.php");
require_once("../mysql.inc.php");
require_once("class.phpmailer.php");

$dbh = new sql;
$dbh -> connect();

$nummer = $_GET['nummer'];
if (!$nummer) { 
	echo "Geen nummer"; 
	exit; 
	}

$query = "
	select EMAIL,MOBIEL_NR,naam,zapperwachtwoord,portalpassword,extension
	from telefoon_gsm
	where MOBIEL_NR = ?
";
$sth = $dbh -> do_placeholder_query($query,array($nummer),__LINE__,__FILE__);
list($email,$mobielnr,$naam,$zapperwachtwoord,$portalpassword,$extension) = $dbh -> fetch_array($sth);
$loginnaam = "0308500".$extension;

if (preg_match('/(.*?)[\s]/im', $naam, $regs)) {
	$voornaam = $regs[1];
}

$body=<<<DUMP
Beste $voornaam<br><br>
RTV Utrecht gebruikt als telefonie systeem ipcentrex van KPN. In deze mail volgen de gegevens hiervan.<br><br>
Om het 030 nummer te gebruiken heb je de KPN Zapper app nodig op je smartphone. Deze kun je gratis downloaden van <a href="https://play.google.com/store/apps/details?id=com.kpn.zapper">Google Play</a> of uit de <a href="https://itunes.apple.com/nl/app/kpn-zapper/id585602704?mt=8">Apple App Store</a>. Zodra deze geinstalleerd is, kun je hierop inloggen met de hieronder vermelde gegevens. De KPN Zapper geeft je vanaf nu de mogelijkheid om bijvoorbeeld intern door te verbinden.<br><br>
<table border="0">
<tr><td>Jouw 030 nummer is:</td><td><b>(030-8500)$extension</b></td></tr>
<tr><td>Jouw inlognaam voor de KPN Zapper is:</td><td><b>$loginnaam</b> (let op, dit is gelijk aan je telefoonnummer)</td></tr>
<tr><td>Jouw wachtwoord voor de KPN Zapper is:</td><td><b>$zapperwachtwoord</b></td></tr>
</table><br>
Om te kunnen bellen met de KPN Zapper moet je nog wel je <a href="https://rtvutrecht.topdesk.net/tas/public/ssp/content/detail/knowledgeitem?unid=5dbaa85180fe4c6f8968ba7044ec3a1b">eigen nummer koppelen aan de KPN Zapper</a>. <br><br>
Met vriendelijke groet,<br>
Afdeling ICT
DUMP;

//	$achternaam = preg_replace('/(van de|vd|van der|van|te|de|ten) /im', '', $achternaam);
//	$login = substr($voornaam,0,3).substr($achternaam,0,03);	
	
	if (count_capitals($login)==2) {
		// echo "echo $extensie>{$login}_tel.txt<br>";
		
		//echo "dsquery user -samid $login -limit 0 | dsmod user -tel \"$extensie\"<br>";
		
//		echo "$login 
}


/*		

$mail=new PHPMailer(); // defaults to using php "Sendmail" (or Qmail, depending on availability)
$body             = @eregi_replace("[\]",'',$body);

echo $body;
$mail->SetFrom('ict@rtvutrecht.nl', 'Afdeling ICT');
$address = "$email";
//$mail->AddAddress($address);
$mail->AddAddress("hans.siemons@rtvutrecht.nl");
$mail->Subject    = "[Reminder] Belangrijk: telefoniegegevens!!";
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$mail->MsgHTML($body);

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}

//	echo "<hr>";


unset($mail);
*/
//echo "Done!";


// <tr><td>Jouw toegangscode voor de voicemail portal is:</td><td><b>$portalpassword</b></td></tr>

// In de voicemail portal (bel vanaf de zapper 1233) kun je je toegangscode voor de voicemail portal wijzigen.

echo $body;
?>