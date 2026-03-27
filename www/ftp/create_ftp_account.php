<?php
require_once("/mnt/data/include/config.ftp.inc.php");
require_once("/mnt/data/include/mysqlp.inc.php");
require_once("/mnt/data/www/vendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;

include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();

if (!$Auth->checkUserRole('Task.Admin')) { echo "Computer says no!"; exit; }

$dbh = new sql;
$dbh->connect();

$ftp_config = [
    'ftp_server'     => 'ftp.rtvutrecht.nl',
    'mail_from'      => 'no-reply@rtvutrecht.nl',
    'mail_from_name' => 'RTV Utrecht',
    'notify_email'   => 'ict@rtvutrecht.nl',
    'smtp_host'      => 'smtp.park.rtvutrecht.nl',
    'smtp_port'      => 25,
];

function createPassword(int $length = 8): string {
    return bin2hex(random_bytes($length / 2));
}

function sendFtpMail(string $username, string $password, string $comment, string $requestedBy, array $cfg): void {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = $cfg['smtp_host'];
    $mail->Port       = $cfg['smtp_port'];
    $mail->SMTPAutoTLS = false;
    $mail->SMTPAuth   = false;
    $mail->setFrom($cfg['mail_from'], $cfg['mail_from_name']);
    $mail->addAddress($cfg['notify_email']);
    $mail->Subject = "FTP account aangemaakt: $username";
    $mail->Body = "Gebruikersnaam: $username\nWachtwoord: $password\n\nOmschrijving:\n$comment\n\nAangevraagd door / Ticket:\n$requestedBy\n\nServeradres: ftp.rtvutrecht.nl";
    $mail->send();
}

$message = null;
$msg_type = 'success';
$username = $comment = $requested_by = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username     = strtolower(trim($_POST['username']     ?? ''));
    $comment      = trim($_POST['comment']      ?? '');
    $requested_by = trim($_POST['requested_by'] ?? '');
    $errors       = [];

    if (!preg_match('/^[a-z0-9]+$/i', $username)) $errors[] = "Ongeldige gebruikersnaam.";
    if ($requested_by === '')                       $errors[] = "Veld 'Aangevraagd door / Ticket' is verplicht.";

    if (empty($errors)) {
        $sth = $dbh->do_placeholder_query("SELECT user FROM users WHERE user = ?", [$username], __LINE__, __FILE__);
        if ($dbh->fetch_array($sth)) {
            $errors[] = "Gebruikersnaam bestaat al.";
        } else {
            $password = createPassword(8);
            $expiry   = date('Y-m-d', strtotime('+7 days'));
            $dbh->do_placeholder_query(
                "INSERT INTO users (user, password, uid, gid, comment, verloopdatum, AangevraagdDoor, KanVerlopen) VALUES (?, ?, 65534, 21, ?, ?, ?, 1)",
                [$username, md5($password), $comment, $expiry, $requested_by],
                __LINE__, __FILE__
            );
            try { $c = ftp_connect($ftp_config['ftp_server']); ftp_login($c, $username, $password); ftp_close($c); } catch (Throwable $e) {}
            sendFtpMail($username, $password, $comment, $requested_by, $ftp_config);
            $message  = "FTP-account aangemaakt en gemaild naar ICT.";
            $username = $comment = $requested_by = '';
        }
    }

    if (!empty($errors)) {
        $message  = implode('<br>', $errors);
        $msg_type = 'danger';
    }
}

require_once('/mnt/data/include/smarty.inc.php');
$smarty = sandstorm_smarty($Auth, '/mnt/data/www/ftp/templates/');
$smarty->assign('page_title', 'FTP Account aanmaken');
$smarty->assign(compact('message', 'msg_type', 'username', 'comment', 'requested_by'));
$smarty->display('create.tpl');
