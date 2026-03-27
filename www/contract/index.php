<?php

include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();
include '/mnt/data/include/PHPAzureADoAuth/graph.php';
$Graph = new modGraph();

if (!$Auth->checkUserRole('Task.Admin')) {	
	echo "Computer says no!";
	exit;
}


echo <<<DUMP
<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
<title>Contracten invullen</title>
</head>
<body>
<div>
<h2>Standaard contracten/templates invuller</h2>
<ul>
DUMP;

$filepath = "/mnt/data/www/contract/templates";

$files = scandir($filepath,SCANDIR_SORT_ASCENDING);

foreach ($files as $filename) {
	if (pathinfo($filename, PATHINFO_EXTENSION) === 'json') {
	    $file_path = $filepath . '/' . $filename;
	    $file_contents = file_get_contents($file_path);
	    $json_contents = json_decode($file_contents, true);
	    $base = pathinfo($filename,PATHINFO_FILENAME);
	    
	    $naam = $json_contents['naam'];
	    $actief = $json_contents['actief'];
	    echo "<li><a href='https://sandstorm.park.rtvutrecht.nl/contract/contract.php?template=$base'>$naam</a></li>";
	}
}

echo "</ul>";

echo <<<DUMP
</div>
</body>
</html>
DUMP;
?>