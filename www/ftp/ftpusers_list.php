<?php
require_once("/mnt/data/include/config.ftp.inc.php");
require_once("/mnt/data/include/mysqlp.inc.php");

include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();

if (!$Auth->checkUserRole('Task.Admin')) { echo "Computer says no!"; exit; }

$flash      = $_SESSION['ftp_flash']      ?? null;
$flash_type = $_SESSION['ftp_flash_type'] ?? 'success';
unset($_SESSION['ftp_flash'], $_SESSION['ftp_flash_type']);

$dbh = new sql;
$dbh->connect();

$sth  = $dbh->do_placeholder_query("SELECT * FROM `ftpusers`.`users` ORDER BY `User` ASC LIMIT 500", [], __LINE__, __FILE__);
$rows = $dbh->fetch_all_assoc($sth);

require_once('/mnt/data/include/smarty.inc.php');
$smarty = sandstorm_smarty($Auth, '/mnt/data/www/ftp/templates/');
$smarty->assign('page_title', 'FTP Gebruikers');
$smarty->assign('rows', $rows);
$smarty->assign('flash', $flash);
$smarty->assign('flash_type', $flash_type);
$smarty->display('list.tpl');
