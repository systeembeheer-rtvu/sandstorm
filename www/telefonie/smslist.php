<?php
require_once("../config.inc.php");
require_once("../mysql.inc.php");
$dbh = new sql;
$dbh -> connect();

require_once("./class.phpmailer.php");


echo "Afzender;Ontvanger;Bericht<br>";

$query = "
	select mobielnummer,mail,number,password,logincode,account
	from kpngzcred
	where SentSMS = 1 and mail!='hans.blasiemons'
	order by mail
";
$sth = $dbh -> do_query($query,__LINE__,__FILE__);
while (list($mobielnummer,$mailadres,$number,$password,$logincode,$account) = $dbh -> fetch_array($sth)) {	

	$name = explode(".",$mailadres);
	$firstname = $name[0];
	
	if ($mobielnummer == "0612780968" ) { $firstname = "Anita Sara"; }
	
	echo "RTV_Utrecht;$mobielnummer;Beste $firstname! We hebben bij RTV Utrecht sinds gisterenavond een nieuwe telefooncentrale. Je moet opnieuw inloggen in de KPN Zapper. De gegevens daarvan vind je in je RTV Utrecht mailbox. Met vriendelijke groet, Afdeling ICT RTV Utrecht.<br>";
	
	$mail = new PHPMailer(); // defaults to using php "Sendmail" (or Qmail, depending on availability)
	$body = <<<DUMP
Beste $firstname,<br><br>
Bij deze ontvang je inlognaam en wachtwoord van de KPN Zapper. Je gebruikersnaam is gelijk aan je vaste telefoonnummer.<br><br>
<table border="0">
<tr><td>Gebruikersnaam</td><td>:</td><td>$account</td></tr>
<tr><td>Wachtwoord</td><td>:</td><td>$password</td></tr>
</table>
<br>
Na inloggen moet je meteen het wachtwoord veranderen in een zelf gekozen wachtwoord.<br><br>
Met vriendelijke groet,<br>
Afdeling ICT
DUMP;

	$body             = @eregi_replace("[\]",'',$body);
	$mail->SetFrom('ict@rtvutrecht.nl', 'Afdeling ICT');
	$email = "$mailadres@rtvutrecht.nl";
	$mail->AddAddress($email);
	$mail->Subject    = "Nieuwe KPN Zapper gegevens voor $account";
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	$mail->MsgHTML($body);

//	$mail->Send();
//	echo "Mail sent!<br";
}

?>