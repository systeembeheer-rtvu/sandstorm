<?php

$subject = file_get_contents("centrex.mbox");

$passwords=array();
$accounts=array();
$logincodes=array();
// alle mails af.

preg_match_all('%^To: (.*?)@twistedmind\.nl.*?</body>%sim', $subject, $result, PREG_PATTERN_ORDER);
for ($i = 0; $i < count($result[0]); $i++) {
	$mail = $result[0][$i];
	
	// let's get info!
	
	if (preg_match('%^To: (.*?)@twistedmind\.nl.*?</body>%sim', $mail, $regs)) {
		$mailadres = $regs[1];
		} else {
		$mailadres = "";
		continue;
	}
	
	if (preg_match('%<p>Uw IP Centrex gebruikersnaam is: (.*?)@ims\.imscore\.net</p>%sim', $mail, $regs)) {
		$account = $regs[1];
		$accounts[$mailadres]=$account;
	}
	if (preg_match('%<p>Uw IP Centrex wachtwoord is: (.*?)</p>%sim', $mail, $regs)) {
		$pwd = $regs[1];
		$passwords[$mailadres] = $pwd;
	}

	if (preg_match('%<p>Uw IP Centrex login code is: (.*?)</p>%sim', $mail, $regs)) {
		$logincode = $regs[1];
		$logincodes[$mailadres] = $logincode;
	}
	
}

echo "mail;account;number;password;logincode<br>";

foreach ($accounts as $key => $value) {

	$mailadres=$key;
	$account =$accounts[$key];
	$number = substr($account,-3);
	$pwd = $passwords[$key];
	$logincode = $logincodes[$key];
	echo "$mailadres;$account;$number;$pwd;$logincode<br>";

}


?>