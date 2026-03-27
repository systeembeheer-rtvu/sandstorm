<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '/mnt/data/www/vendor/autoload.php';

$smarty = new \Smarty\Smarty();
$smarty->setTemplateDir('/mnt/data/www/rooster/templates/');
$smarty->setCompileDir('/mnt/data/www/rooster/templates_c/');

$smarty->display('rooster_dashboard.tpl.html');
