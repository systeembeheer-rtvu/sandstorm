<?php
require_once("/mnt/data/include/config.inc.php");
require_once("/mnt/data/include/mysqli.inc.php");
$dbh = new sql;
$dbh -> connect();

// status = 0 ingevoerd door niet ict
// status = 1 goedgekeurd door ict
// status = 2 verwerkt, wacht op licentie
// status = 9 klaar
// status = 10 Error, map bestaat al

$debug = @$_GET['debug'];
$id = @$_GET['id'];
$newstatus = @$_GET['newstatus'];
$script = "";
if ($id) {
	$query = "
		update park_newusers
		   set status = ?
		   where id = ?   
	";
	$sth = $dbh->do_placeholder_query($query,array($newstatus,$id),__LINE__,__FILE__);
	exit;
}

if ($debug) $br = "<br>"; else $br = "\r\n";

// Users/contact aanmaken

$query = "
	select id,status,voornaam,tussenvoegsel,achternaam,emailadres,mobilephone,aangevraagddoor,groups,dalet,alias,topdeskcall
	from park_newusers
	where status between 1 and 7
	  and aanmakenop<=CURDATE()
        order by status desc,id
";
$sth = $dbh->do_query($query,__LINE__,__FILE__);

while (list($id,$status,$firstname,$middlename,$lastname,$emailaddress,$mobilephone,$requester,$groups,$dalet,$alias,$topdeskcall) = $dbh -> fetch_array($sth)) {
	$firstname = trim($firstname);
	$middlename = trim($middlename);
	$lastname = trim($lastname);
	$fullname = "$firstname " . ($middlename ? "$middlename " : "") . $lastname;
	// Check if middlename is longer than 6 characters
	if (strlen($middlename) > 6) {
		$words = explode(' ', $middlename);
	
		$shortened = '';
		foreach ($words as $word) {
			if (!empty($word)) {
			    $shortened .= substr($word, 0, 1);
			}
		}
		$middlename = $shortened;
	}

	// Update the middlename with the shortened version
	if ($dalet) $dalet="true"; else $dalet="false";
	if ($groups == "Distributielijst maken (mail relay)") {
		if ($status==1) {
		$script = "
Add-PSSnapin Microsoft.Exchange.Management.PowerShell.SnapIn -ErrorAction SilentlyContinue$br
\$name = \"$firstname\"$br
\$emailaddress = \"$emailaddress\"$br
\$parkuserid = $id$br
\$callid = \"$topdeskcall\"$br
& \\\\stampida\d$\scripts\libs\CreateNewDistributionList.ps1 -name \$name -emailaddress \$emailaddress -parkuserid \$parkuserid -callid \$callid -hidden true$br
Invoke-WebRequest \"https://sandstorm.park.rtvutrecht.nl/parkuser/powershell.php?id=$id&newstatus=2\"$br
& \\\\stampida\d$\scripts\\forcesync.ps1$br
";
} elseif ($status==2) {
	$script = "
& \\\\stampida\d$\scripts\libs\O365-Exchange-Powershell.ps1$br
Add-RecipientPermission -Identity $emailaddress -Trustee mail.to.office365@rtvutrecht.nl -AccessRights SendAs -Confirm:\$false$br
Invoke-WebRequest \"https://sandstorm.park.rtvutrecht.nl/parkuser/powershell.php?id=$id&newstatus=8\"$br
";
}
} else if ($groups == "Shared Mailbox") {
if ($status==1) {
		$script = "
Add-PSSnapin Microsoft.Exchange.Management.PowerShell.SnapIn -ErrorAction SilentlyContinue$br
\$name = \"$firstname\"$br
\$emailaddress = \"$emailaddress\"$br
\$parkuserid = $id$br
\$callid = \"$topdeskcall\"$br
& \\\\stampida\d$\scripts\libs\CreateNewSharedMailBox.ps1 -name \$name -emailaddress \$emailaddress -parkuserid \$parkuserid -callid \$callid$br
& \\\\stampida\d$\scripts\\forcesync.ps1$br
Invoke-WebRequest \"https://sandstorm.park.rtvutrecht.nl/parkuser/powershell.php?id=$id&newstatus=2\"$br
"; 
} elseif ($status==2) {
		$script = "
& \\\\stampida\d$\scripts\libs\O365-Exchange-Powershell.ps1$br
\$callid = \"$topdeskcall\"$br
& \\\\stampida\d$\scripts\libs\AddSharedMailBoxLicense.ps1 -email \"$emailaddress\"$br
Invoke-WebRequest \"https://sandstorm.park.rtvutrecht.nl/parkuser/powershell.php?id=$id&newstatus=3\"$br
";
} else {
	// status = 3

		$script = "
& \\\\stampida\d$\scripts\libs\O365-Exchange-Powershell.ps1$br
\$callid = \"$topdeskcall\"$br
& \\\\stampida\d$\scripts\libs\ConvertToSharedMailbox.ps1 -email \"$emailaddress\"$br
Invoke-WebRequest \"https://sandstorm.park.rtvutrecht.nl/parkuser/powershell.php?id=$id&newstatus=8\"$br
";
}
} else if ($groups == "Distributielijst maken") {
		$script = "
Add-PSSnapin Microsoft.Exchange.Management.PowerShell.SnapIn -ErrorAction SilentlyContinue$br
\$name = \"$firstname\"$br
\$emailaddress = \"$emailaddress\"$br
\$parkuserid = $id$br
\$callid = \"$topdeskcall\"$br
& \\\\stampida\d$\scripts\libs\CreateNewDistributionList.ps1 -name \$name -emailaddress \$emailaddress -parkuserid \$parkuserid -callid \$callid$br
Invoke-WebRequest \"https://sandstorm.park.rtvutrecht.nl/parkuser/powershell.php?id=$id&newstatus=8\"$br
";	
} else if ($groups == "Distributielijst maken (hidden)") {
		$script = "
Add-PSSnapin Microsoft.Exchange.Management.PowerShell.SnapIn -ErrorAction SilentlyContinue$br
\$name = \"$firstname\"$br
\$emailaddress = \"$emailaddress\"$br
\$parkuserid = $id$br
\$callid = \"$topdeskcall\"$br
& \\\\stampida\d$\scripts\libs\CreateNewDistributionList.ps1 -name \$name -emailaddress \$emailaddress -parkuserid \$parkuserid -callid \$callid -hidden true$br
Invoke-WebRequest \"https://sandstorm.park.rtvutrecht.nl/parkuser/powershell.php?id=$id&newstatus=8\"$br
";	

	} elseif ($groups == "Contact maken") {
		$script = "
Add-PSSnapin Microsoft.Exchange.Management.PowerShell.SnapIn -ErrorAction SilentlyContinue$br
\$firstname = \"$firstname\"$br
\$middlename = \"$middlename\"$br
\$lastname = \"$lastname\"$br
\$fullname = \"$fullname\"$br
\$emailaddress = \"$emailaddress\"$br
\$parkuserid = $id$br
\$callid = \"$topdeskcall\"$br
& \\\\stampida\d$\scripts\libs\CreateNewContact.ps1 -firstname \$firstname -lastname \$lastname -middlename \$middlename -fullname \$fullname -emailaddress \$emailaddress -parkuserid \$parkuserid -callid \$callid$br
Invoke-WebRequest \"https://sandstorm.park.rtvutrecht.nl/parkuser/powershell.php?id=$id&newstatus=8\"$br
";			
	}
	elseif ($status==1) { // aanmaken user
		$script = "
Add-PSSnapin Microsoft.Exchange.Management.PowerShell.SnapIn -ErrorAction SilentlyContinue$br
\$aanvrager = \"$requester\"$br
\$alias = \"$alias\"$br
\$firstname = \"$firstname\"$br
\$middlename = \"$middlename\"$br
\$lastname = \"$lastname\"$br
\$fullname = \"$fullname\"$br
\$upn = \"$emailaddress\"$br
\$groups = \"$groups\"$br
\$dalet = \"$dalet\"$br
\$mobilephone = \"$mobilephone\"$br
\$parkuserid = $id$br
\$callid = \"$topdeskcall\"$br
& \\\\stampida\d$\scripts\libs\CreateNewUser.ps1 -aanvrager \$aanvrager -alias \$alias -firstname \$firstname -lastname \$lastname -middlename \$middlename -fullname \$fullname -upn \$upn -groups \$groups -dalet \$dalet -parkuserid \$parkuserid -callid \$callid -mobilephone \$mobilephone$br
& \\\\stampida\d$\scripts\\forcesync.ps1$br
Invoke-WebRequest \"https://sandstorm.park.rtvutrecht.nl/parkuser/powershell.php?id=$id&newstatus=2\"$br
";
	} else { // status=2
		$script = "
& \\\\stampida\d$\scripts\libs\O365-Exchange-Powershell.ps1$br
\$callid = \"$topdeskcall\"$br
& \\\\stampida\d$\scripts\libs\addlicense.ps1 -upn \"$emailaddress\" -callid \$callid$br
Invoke-WebRequest \"https://sandstorm.park.rtvutrecht.nl/parkuser/powershell.php?id=$id&newstatus=8\"$br
";
	}
}

echo $script;
?>