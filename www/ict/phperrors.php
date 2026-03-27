<?php
/*
include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();
include '/mnt/data/include/PHPAzureADoAuth/graph.php';
$Graph = new modGraph();


if (!$Auth->checkUserRole('Task.Admin')) {	
	echo "Computer says no!";
	exit;
}
*/

$lines = `tail -10 /var/log/nginx/sandstorm.park.rtvutrecht.nl.error.log.1`;

$linesar = explode("\n",$lines);
$linesar = array_reverse($linesar);

echo "<table border='1'>";
foreach ($linesar as $line) {
	
$line = str_replace("\"PHP message:","\"<br><br><b>PHP message:</b>",$line);
$line = preg_replace('%(\d{4}/\d\d/\d\d \d\d:\d\d:\d\d)%im', '<b>\1</b>', $line);

	
echo "<tr><td>$line</td></tr>";	
}

echo "</table>";

?>