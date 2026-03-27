<?php
require_once("/mnt/data/include/config.ftp.inc.php");
require_once("/mnt/data/include/mysqlp.inc.php");

include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();

if (!$Auth->checkUserRole('Task.Admin')) { echo "Computer says no!"; exit; }

session_start();
$dbh = new sql;
$dbh->connect();

if (empty($_GET['User'])) { http_response_code(400); die("No user selected."); }
$user = $_GET['User'];

$sth = $dbh->do_placeholder_query("SELECT * FROM `ftpusers`.`users` WHERE `User` = ?", [$user], __LINE__, __FILE__);
$row = $dbh->fetch_assoc($sth);
if (!$row) { http_response_code(404); die("User not found."); }

if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
$csrf   = $_SESSION['csrf_token'];
$errors = [];
$saved  = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf'])) {
        $errors[] = "Ongeldig CSRF token.";
    } elseif (isset($_POST['action_delete'])) {
        $dbh->do_placeholder_query(
            "UPDATE `ftpusers`.`users` SET `Enabled` = 0, `KanVerlopen` = 1, `Verloopdatum` = ? WHERE `User` = ?",
            [date('Y-m-d', strtotime('-1 day')), $user],
            __LINE__, __FILE__
        );
        $_SESSION['ftp_flash'] = "Gebruiker '$user' is gemarkeerd voor verwijdering.";
        $_SESSION['ftp_flash_type'] = 'warning';
        header('Location: ftpusers_list.php');
        exit;
    } else {
        $updates = [];
        $params  = [];

        $updates[] = "`Enabled` = ?";      $params[] = isset($_POST['Enabled']) ? 1 : 0;
        $updates[] = "`KanVerlopen` = ?";  $params[] = isset($_POST['KanVerlopen']) ? 1 : 0;

        $vd = trim($_POST['Verloopdatum'] ?? '');
        if ($vd === '') $vd = '0000-00-00';
        elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $vd)) $errors[] = "Verloopdatum moet YYYY-MM-DD zijn.";
        $updates[] = "`Verloopdatum` = ?"; $params[] = $vd;
        $updates[] = "`Comment` = ?";      $params[] = trim($_POST['Comment'] ?? '');
        $updates[] = "`AangevraagdDoor` = ?"; $params[] = trim($_POST['AangevraagdDoor'] ?? '');

        $pwd = $_POST['PasswordClear'] ?? '';
        if ($pwd !== '') {
            $updates[] = "`PasswordClear` = ?, `Password` = MD5(?)";
            $params[]  = $pwd;
            $params[]  = $pwd;
        }

        if (!$errors) {
            $params[] = $user;
            $dbh->do_placeholder_query("UPDATE `ftpusers`.`users` SET " . implode(', ', $updates) . " WHERE `User` = ?", $params, __LINE__, __FILE__);
            $saved = true;
            $sth = $dbh->do_placeholder_query("SELECT * FROM `ftpusers`.`users` WHERE `User` = ?", [$user], __LINE__, __FILE__);
            $row = $dbh->fetch_assoc($sth);
        }
    } // end else (normal save)
}

$readonly = [
    'LastLogin'  => $row['LastLogin'],
];

require_once('/mnt/data/include/smarty.inc.php');
$smarty = sandstorm_smarty($Auth, '/mnt/data/www/ftp/templates/');
$smarty->assign('page_title', "FTP: $user");
$smarty->assign(compact('user', 'row', 'csrf', 'errors', 'saved', 'readonly'));
$smarty->display('edit.tpl');
