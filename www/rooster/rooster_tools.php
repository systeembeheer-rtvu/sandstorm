<?php
include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();

if (!$Auth->checkUserRole('Task.Admin')) { echo "Computer says no!"; exit; }

require_once('/mnt/data/include/smarty.inc.php');
$smarty = sandstorm_smarty($Auth, '/mnt/data/www/rooster/templates/');
$smarty->assign('page_title', 'Rooster Tools');
$smarty->display('rooster_tools.tpl');
