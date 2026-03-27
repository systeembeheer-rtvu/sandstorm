<?php
require_once("/mnt/data/include/config.inc.php");
require_once("/mnt/data/include/mysqli.inc.php");
$dbh = new sql;
$dbh->connect();

include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();

if (!$Auth->checkUserRole('Task.Admin')) {
    echo "Computer says no!";
    exit;
}

// Status lookup
$statuses = [];
$sth = $dbh->do_query("SELECT status, text FROM park_status ORDER BY status", __LINE__, __FILE__);
while (list($sid, $stext) = $dbh->fetch_array($sth)) {
    $statuses[$sid] = $stext;
}

// Users
$users = [];
$sth = $dbh->do_query("
    SELECT id, voornaam, tussenvoegsel, achternaam, emailadres, aangevraagddoor,
           groups, dalet, status, alias, aanmakenop, lastchange
    FROM park_newusers
    WHERE lastchange >= NOW() - INTERVAL 1 YEAR
    ORDER BY status ASC, aanmakenop DESC
", __LINE__, __FILE__);

while (list($id, $voornaam, $tv, $achternaam, $email, $aanvrager, $groups, $dalet, $status, $alias, $aanmakenop, $lastchange) = $dbh->fetch_array($sth)) {
    $users[] = [
        'id'         => $id,
        'naam'       => trim("$voornaam $tv") . " $achternaam",
        'emailadres' => $email,
        'aanvrager'  => $aanvrager,
        'groups'     => $groups,
        'dalet'      => $dalet,
        'status'     => $status,
        'alias'      => $alias,
        'aanmakenop' => $aanmakenop,
        'lastchange' => $lastchange,
    ];
}

require_once('/mnt/data/include/smarty.inc.php');
$smarty = sandstorm_smarty($Auth, '/mnt/data/www/parkuser/templates/');
$smarty->assign('page_title', 'Parkuser');
$smarty->assign('statuses', $statuses);
$smarty->assign('users', $users);
$smarty->display('index.tpl');
