<?php
include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();

require_once('/mnt/data/include/smarty.inc.php');
$smarty = sandstorm_smarty($Auth);
$smarty->assign('page_title', 'Sandstorm');
$smarty->display('index.tpl');
