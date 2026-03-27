<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

require_once("/mnt/data/include/config.ftp.inc.php");
require_once("/mnt/data/include/mysqli.inc.php");
require_once("/mnt/data/www/vendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;

// Azure AD Auth
include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();
include '/mnt/data/include/PHPAzureADoAuth/graph.php';
$Graph = new modGraph();

if (!$Auth->checkUserRole('Task.Admin')) {
    echo "Computer says no!";
    exit;
}

$dbh = new sql;
$dbh->connect();

$ftp_config = [
    'ftp_server' => 'ftp.rtvutrecht.nl',
    'mail_from' => 'no-reply@rtvutrecht.nl',
    'mail_from_name' => 'RTV Utrecht',
    'notify_email' => 'ict@rtvutrecht.nl',
    'smtp_host' => 'smtp.park.rtvutrecht.nl',
    'smtp_port' => 25
];

function createPassword(int $length = 8): string {
    return bin2hex(random_bytes($length / 2));
}

function validateInput(string $username, string $requestedBy): array {
    $errors = [];
    if (!preg_match('/^[a-z0-9]+$/i', $username)) {
        $errors[] = "Ongeldige gebruikersnaam.";
    }
    if (trim($requestedBy) === '') {
        $errors[] = "Veld 'Aangevraagd door / Ticket' is verplicht.";
    }
    return $errors;
}

function sendFtpMail(string $username, string $password, string $comment, string $requestedBy, array $ftp_config): void {
    $mail = new PHPMailer(true);

    // SMTP settings
    $mail->isSMTP();
    $mail->Host = $ftp_config['smtp_host'];
    $mail->Port = $ftp_config['smtp_port'];
    $mail->SMTPAutoTLS = false;
    $mail->SMTPAuth = false;

    $mail->setFrom($ftp_config['mail_from'], $ftp_config['mail_from_name']);
    $mail->addAddress($ftp_config['notify_email']);
    $mail->Subject = "FTP account aangemaakt: $username";
    $mail->Body = <<<TEXT
Beste ICT,

Er is een nieuw FTP account aangemaakt.

Gebruikersnaam: $username
Wachtwoord: $password

Omschrijving:
$comment

Aangevraagd door / Ticket:
$requestedBy

Serveradres: ftp.rtvutrecht.nl

Met vriendelijke groet,
FTP Aanvraagformulier
TEXT;
    $mail->send();
}

$message = '';
$table = 'users';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = strtolower(trim($_POST['username'] ?? ''));
    $comment = trim($_POST['comment'] ?? '');
    $requestedBy = trim($_POST['requested_by'] ?? '');

    $errors = validateInput($username, $requestedBy);

    if (empty($errors)) {
        $query = "
            select user
            from $table
            where 1
              and user = ?
        ";
        $sth = $dbh->do_placeholder_query($query, [$username], __LINE__, __FILE__);

        if ($dbh->total_rows($sth) > 0) {
            $errors[] = "Gebruikersnaam bestaat al.";
        } else {
            $password = createPassword(8);
            $hashedPassword = md5($password);
            $expiry = date('Y-m-d', strtotime('+7 days'));

            $query = "
                insert into $table
                (user, password, uid, gid, comment, verloopdatum, AangevraagdDoor, KanVerlopen)
                values (?, ?, 65534, 21, ?, ?, ?, 1)
            ";
            $dbh->do_placeholder_query($query, [
                $username,
                $hashedPassword,
                $comment,
                $expiry,
                $requestedBy
            ], __LINE__, __FILE__);

            try {
                $conn_id = ftp_connect($ftp_config['ftp_server']);
                ftp_login($conn_id, $username, $password);
                ftp_close($conn_id);
            } catch (Throwable $e) {}

            sendFtpMail($username, $password, $comment, $requestedBy, $ftp_config);

            $message = "<div class='alert alert-success'>FTP-account is succesvol aangemaakt en gemaild naar ICT.</div>";
        }
    }

    if (!empty($errors)) {
        $message = "<div class='alert alert-danger'><ul><li>" . implode('</li><li>', $errors) . "</li></ul></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>FTP Aanvraag</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">FTP Account Aanvragen</h4>
        </div>
        <div class="card-body">
            <?= $message ?>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Gebruikersnaam</label>
                    <input type="text" class="form-control" id="username" name="username" required pattern="[a-zA-Z0-9]+" title="Alleen letters en cijfers">
                </div>
                <div class="form-group">
                    <label for="comment">Omschrijving (optioneel)</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="requested_by">Aangevraagd door / Ticket</label>
                    <input type="text" class="form-control" id="requested_by" name="requested_by" required>
                </div>
                <button type="submit" class="btn btn-danger">Account aanmaken</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
