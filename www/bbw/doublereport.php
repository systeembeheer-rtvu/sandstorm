<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require_once("/mnt/data/include/config.shredder.inc.php");
require_once("/mnt/data/include/mysqli.inc.php");
$dbh = new sql;
$dbh -> connect(); // connect
$totsize=0;
$aantal = 0;
$datums = array();

$query = "
	SELECT daletid,COUNT(daletid) AS cnt
	FROM bbwfiles
	WHERE daletid != ''
	GROUP BY daletid
	HAVING cnt>1
";

/*
	  and filename not like '%.wav'
	  and filename not like '%.mp3'

*/

$sth = $dbh->do_query($query,__LINE__,__FILE__);
while (list($dalet_id,$count) = $dbh -> fetch_array($sth)) {
	$query = "
		select filename,path,datum,size
		from bbwfiles
		where daletid = ?
		order by datum desc
	";
	$sti = $dbh->do_placeholder_query($query,array($dalet_id),__LINE__,__FILE__);
	
	$aantal++;
	echo "<hr>$dalet_id<br>";
	
	while (list($filename,$path,$datum,$size) = $dbh -> fetch_array($sti)) {
		$totsize=$totsize+intval($size);
		$size = round($size/1000/1000/1000,2);
		echo "$datum $path\\$filename ($size gb)<br>";
		$datums[]=$datum;
	}
	
}

$totsizetb = round($totsize/1000/1000/1000/1000/2,2);
$daycount = array_count_values($datums);
asort($daycount);

echo <<<DUMP
Aantal: $aantal files<br>
Total $totsizetb TB
<hr>
<pre>
DUMP;

print_r($daycount);

echo "</pre>";

?>