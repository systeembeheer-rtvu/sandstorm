<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("/mnt/data/include/config.shredder.inc.php");
require_once("/mnt/data/include/mysqlp.inc.php");

$dbh = new sql;
$dbh->connect(); // connect

$query = "
	SELECT website_titel, media_video, media_audio, dalet_id, website_online
	FROM dalet_berichten
	WHERE 
	    (media_video LIKE '%FALSE%' OR media_audio LIKE '%FALSE%' OR media_audio LIKE '%//TRUE%')
	    AND last_update >= NOW() - INTERVAL 1 YEAR
	    AND mix_status = 'PUBLISH';
";

$sth = $dbh->do_query($query, __LINE__, __FILE__);
while (list($titel, $media_video, $media_audio,$daletid, $website_online) = $dbh->fetch_array($sth)) {
    $videos = explode("|", $media_video);
    echo "$titel -> $website_online<br>";
    foreach ($videos as $video) {
        echo "$video<br>";
    }
    $videos = explode("|", $media_audio);
    echo "$titel -> $website_online<br>";
    foreach ($videos as $video) {
        echo "$video<br>";
    }
    echo "<hr>";
}
?>
