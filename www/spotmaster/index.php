<?php
// spotmaster opzoeker!

require_once("/mnt/data/include/config.inc.php");
require_once("/mnt/data/include/mysqli.inc.php");
$dbh = new sql;
$dbh -> connect();

include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();
include '/mnt/data/include/PHPAzureADoAuth/graph.php';
$Graph = new modGraph();

if (!$Auth->checkUserRole('Task.Spotmaster')) {	
	echo "Computer says no!";
	exit;
}

$tag=$_POST['tag'];

echo <<<DUMP
<form method="post" action="index.php" style="display:inline;" name="bounce" id="bounce">
Tag: <input type="text" name="tag" value="$tag">
<input type="submit" name="execute" value="Zoek tag!" />
</form><br /><br />
DUMP;

$dectag=hexdec($tag);

if ($tag) {
	echo "<hr>Zoeken naar $tag<br />";
	$query = "
		select naam,DATE_FORMAT(LASTUPDATE,'%d-%c-%Y')
		from spotmaster
		where TAG = ?
		order by LASTUPDATE desc
	";
	$sth = $dbh -> do_placeholder_query($query,array($dectag),__LINE__,__FILE__);
	while(list($naam,$lastupdate) = $dbh -> fetch_array($sth)) {
		echo "<b>$naam</b> tot en met $lastupdate<br />";
	}}

?>