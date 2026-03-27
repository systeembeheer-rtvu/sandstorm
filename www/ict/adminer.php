<?php
require_once("/mnt/data/include/config.inc.php");
require_once("/mnt/data/include/mysqli.inc.php");
$dbh = new sql;
$dbh -> connect();

include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();
include '/mnt/data/include/PHPAzureADoAuth/graph.php';
$Graph = new modGraph();

if (!$Auth->checkUserRole('Task.Admin')) {	
	echo "Computer says no!";
	exit;
}

include('/mnt/data/include/adminer/adminer-4.8.1-mysql.php');
?>