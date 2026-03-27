<?php

include("/mnt/data/include/formr/class.formr.php");
$form = new Formr\Formr('bootstrap4');

$prefill = $_GET['prefill'] ?? '';
if ($prefill) {
	$prefilldata = file_get_contents("/mnt/data/www/contract/contracten/$prefill.json");
	$prefilldata = json_decode($prefilldata,true);
	$_POST = $prefilldata;
	$_REQUEST = $prefilldata;
	$prefilled = 1;
} else {
	$prefilled = 0;	
}

$template = $_REQUEST['template'] ?? '';
if (!$template) {
	echo "Geen template!";
	exit;	
}

$json = file_get_contents("/mnt/data/www/contract/templates/$template.json");

$data = json_decode($json,true);
$contracttemplate = $data['template'];
$contracttemplatenaam = $data['naam'];

$vandaag = date("Y-m-d");

echo <<<DUMP
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
<title>$contracttemplatenaam</title>

</head>
<body class="container">
<a href="index.php">Home</a>
<h2>$contracttemplatenaam</h2>
DUMP;


$form->open();

foreach ($data['fields'] as $key => $value) {
	if (strtoupper($key)=="DATUM") {
		$form->date($key,$value,$vandaag);
	} else {
		$form->text($key,$value);
	}
	$form->hidden("template",$template);
}
$form->submit_button("Maak contract");

if ($form->submitted() || $prefilled)
{
	$search = array();
	$replace = array();
	foreach ($data['fields'] as $key => $value) {
		$search[] = "**$key**";
		
		$repl = $_POST[$key];
		if (strtoupper($key)=="DATUM") {
			$repl = preg_replace('/(\d{4})-(\d\d)-(\d\d)/i', '\3-\2-\1', $repl);
		}
			
		$replace[] = $repl;
	}
	
	$file = file_get_contents("/mnt/data/www/contract/templates/$contracttemplate");
	$file = str_ireplace($search,$replace,$file);
	$filename = md5(serialize($_POST));
	file_put_contents("/mnt/data/www/contract/contracten/$filename.rtf",$file);
	$request_data = json_encode($_REQUEST, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT);
	file_put_contents("/mnt/data/www/contract/contracten/$filename.json",$request_data);
	
	$url = "https://sandstorm.park.rtvutrecht.nl/contract/contracten/$filename";
	$form->success_message = "Download <a href='$url.rtf'>hier</a> het contract!<br><br><a href='contract.php?prefill=$filename'>Link</a> om dit contract te delen";
	echo $form->messages();
}



echo <<<DUMP
</body>
</html>
DUMP;

?>