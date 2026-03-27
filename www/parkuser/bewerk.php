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

$new      = $_GET['new']      ?? null;
$generate = $_GET['generate'] ?? null;
$edit     = $_POST['edit']    ?? null;

// ── POST: opslaan ─────────────────────────────────────────────────────────────
if ($edit) {
    if (!$_POST['id']) {
        $dbh->do_query("INSERT INTO park_newusers (lastchange) VALUES (CURRENT_TIMESTAMP)", __LINE__, __FILE__);
        $sth = $dbh->do_query("SELECT last_insert_id()", __LINE__, __FILE__);
        list($id) = $dbh->fetch_array($sth);
        $_POST['id'] = $id;
        $new = 1;
    }

    if ($_POST['status'] == 9) {
        $dbh->do_placeholder_query("DELETE FROM park_newusers WHERE id = ?", [$_POST['id']], __LINE__, __FILE__);
        header("Location: index.php");
        exit;
    }

    $mobilephone = $_POST['mobilephone'] ?? '';
    preg_match_all('/\d/', $mobilephone, $result, PREG_PATTERN_ORDER);
    $mobilephone = "+31 6" . substr(implode('', $result[0]), -8);

    $dbh->do_placeholder_query("
        UPDATE park_newusers
        SET voornaam = ?, tussenvoegsel = ?, achternaam = ?, emailadres = ?,
            mobilephone = ?, aangevraagddoor = ?, groups = ?, status = ?,
            alias = ?, topdeskcall = ?, aanmakenop = ?
        WHERE id = ?
    ", [
        trim($_POST['voornaam']), trim($_POST['tussenvoegsel']), trim($_POST['achternaam']),
        trim($_POST['emailadres']), $mobilephone, $_POST['aangevraagddoor'],
        $_POST['groups'], $_POST['status'] ?? 0,
        $_POST['alias'], $_POST['topdeskcall'], $_POST['aanmakenop'],
        $_POST['id']
    ], __LINE__, __FILE__);

    if ($new) {
        header("Location: generate.php?id={$_POST['id']}");
    } else {
        header("Location: bewerk.php?id={$_POST['id']}&edited=1");
    }
    exit;
}

// ── GET: formulier tonen ──────────────────────────────────────────────────────
$id    = $_GET['id'] ?? null;
$today = date("Y-m-d");

$voornaam = $tussenvoegsel = $achternaam = $emailadres = $mobilephone =
$aangevraagddoor = $groups = $alias = $topdeskcall = '';
$dalet  = 1;
$status = 0;
$aanmakenop = $today;
$type = $new;

if ($id) {
    $sth = $dbh->do_placeholder_query("
        SELECT voornaam, tussenvoegsel, achternaam, emailadres, mobilephone,
               aangevraagddoor, groups, dalet, status, alias, topdeskcall, aanmakenop
        FROM park_newusers WHERE id = ?
    ", [$id], __LINE__, __FILE__);
    list($voornaam, $tussenvoegsel, $achternaam, $emailadres, $mobilephone,
         $aangevraagddoor, $groups, $dalet, $status, $alias, $topdeskcall, $aanmakenop) = $dbh->fetch_array($sth);

    if ($groups == 'Contact maken')                        $type = 'contact';
    elseif (stripos($groups, 'Distributielijst') !== false) $type = 'dist';
    else                                                    $type = 'user';
} else {
    if ($type == 'dist')    $groups = 'Distributielijst maken';
    if ($type == 'contact') $groups = 'Contact maken';
}

// Mobile number validation
$mobile_invalid = false;
if ($type == 'user' && $mobilephone !== '') {
    if (!preg_match('/\A\+31 6\d{8}\z/i', $mobilephone)) {
        $mobile_invalid = true;
        if ((int)$status === 1) {
            $dbh->do_placeholder_query("UPDATE park_newusers SET status = 0 WHERE id = ?", [$id], __LINE__, __FILE__);
            $status = 0;
        }
    }
}

// Alias conflict check
$alias_conflict = false;
if ($alias) {
    $sth = $dbh->do_placeholder_query("SELECT COUNT(*) FROM adusers WHERE LOWER(samaccountname) = LOWER(?)", [$alias], __LINE__, __FILE__);
    list($found) = $dbh->fetch_array($sth);
    $alias_conflict = (bool)$found;
}

// Status options
$statuses = [];
$sth = $dbh->do_query("SELECT status, text FROM park_status ORDER BY status", __LINE__, __FILE__);
while (list($sid, $stext) = $dbh->fetch_array($sth)) {
    $statuses[$sid] = $stext;
}

// Group options
$typevalue = ($type == 'contact') ? 1 : (($type == 'dist') ? 2 : 0);
$groepen = [];
$sth = $dbh->do_placeholder_query("SELECT naam FROM park_groepen WHERE type = ? ORDER BY naam", [$typevalue], __LINE__, __FILE__);
while (list($naam) = $dbh->fetch_array($sth)) {
    $groepen[] = $naam;
}
// Add current value if not in list
if ($groups && !in_array($groups, $groepen)) {
    $groepen[] = $groups;
}

// Message
$message = null;
$message_type = 'info';
if (@$_GET['edited']) {
    $message = 'Opgeslagen!';
    $message_type = 'success';
}
if ($generate) {
    $message = 'E-mailadres en alias gegenereerd! Controleer deze en pas eventueel aan.';
    $message_type = 'warning';
}

require_once('/mnt/data/include/smarty.inc.php');
$smarty = sandstorm_smarty($Auth, '/mnt/data/www/parkuser/templates/');
$smarty->assign('page_title', 'Parkuser — ' . ($id ? trim("$voornaam $tussenvoegsel $achternaam") : 'Nieuw'));
$smarty->assign(compact(
    'id', 'type', 'is_edit', 'today',
    'voornaam', 'tussenvoegsel', 'achternaam', 'emailadres',
    'mobilephone', 'mobile_invalid', 'aangevraagddoor',
    'groups', 'groepen', 'dalet', 'status', 'statuses',
    'alias', 'alias_conflict', 'topdeskcall', 'aanmakenop',
    'message', 'message_type'
));
$smarty->assign('is_edit', (bool)$id);
$smarty->display('bewerk.tpl');
