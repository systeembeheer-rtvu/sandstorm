<?php
include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();

if (!$Auth->checkUserRole('Task.Admin')) {
    echo "Computer says no!";
    exit;
}

$templates = [];
foreach (scandir("/mnt/data/www/contract/templates", SCANDIR_SORT_ASCENDING) as $filename) {
    if (pathinfo($filename, PATHINFO_EXTENSION) !== 'json') continue;
    $json = json_decode(file_get_contents("/mnt/data/www/contract/templates/$filename"), true);
    $templates[] = [
        'base'   => pathinfo($filename, PATHINFO_FILENAME),
        'naam'   => $json['naam'],
        'actief' => $json['actief'] ?? true,
    ];
}

require_once('/mnt/data/include/smarty.inc.php');
$smarty = sandstorm_smarty($Auth, '/mnt/data/www/contract/views/');
$smarty->assign('page_title', 'Contracten');
$smarty->assign('templates', $templates);
$smarty->display('index.tpl');
