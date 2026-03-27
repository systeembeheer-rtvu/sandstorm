<?php
require_once "d:/scripts/php/vendor/autoload.php";
ob_start();

include "config.php";
include "d:/scripts/php/inc.libs/config.inc.shredder.php"; // Config file database
include "d:/scripts/php/inc.libs/mysqlp.inc.php";
include "calenderlib.php";

$dbh = new sql;
$dbh->connect();

$accessToken = getAccessToken($calenderconfig['TENANT_ID'], $calenderconfig['CLIENT_ID'], $calenderconfig['CLIENT_SECRET']);
foreach ($users as $mail => $file) {
    RunCalender($file,$mail,$accessToken);
}

?>
