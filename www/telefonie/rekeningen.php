<?php

$nummer = $_GET['nummer'];
$naam = $_GET['naam'];

echo <<<DUMP
<html><title>Rekeningen voor $nummer</title>
<body><h2>Rekeningen voor $nummer ($naam)</h2>
<a href="bewerk.php?nummer=$nummer">Bewerk nummer</a> <a href="index.php">Home</a><br><br><br>

DUMP;

foreach(array_reverse(glob('/usr/local/www/intranet/admin/telefonie/rekeningen/*/*'.$nummer.'*')) as $file)  
{  
	$file = str_replace('/usr/local/www/intranet/admin/telefonie/rekeningen/','',$file);
	echo "<a href=\"rekeningen/$file\">$file</a><br>";	

}  

echo "</body></html>";

?>