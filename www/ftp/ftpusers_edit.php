<?php
// error_reporting(E_ALL); ini_set('display_errors', 1);

require_once("/mnt/data/include/config.ftp.inc.php");
require_once("/mnt/data/include/mysqli.inc.php");
require_once("/mnt/data/www/vendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;

// Azure AD Auth
include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();
include '/mnt/data/include/PHPAzureADoAuth/graph.php';
$Graph = new modGraph();

if (!$Auth->checkUserRole('Task.Admin')) { echo "Computer says no!"; exit; }

session_start();

$dbh = new sql;
$dbh->connect();

// --- Config: editable / readonly fields ---
$EDITABLE_FIELDS = ['Enabled','KanVerlopen','Verloopdatum','Comment','AangevraagdDoor','PasswordClear'];
$READONLY_FIELDS = ['Dir','Uid','Gid','LastLogin'];

// --- Input: PK ---
if (empty($_GET['User'])) {
    http_response_code(400);
    die("No user selected.");
}
$user = $_GET['User'];

// --- Load row (SELECT * with placeholder) ---
$sth = $dbh->do_placeholder_query(
    "SELECT * FROM `ftpusers`.`users` WHERE `User` = ?",
    [$user],
    __LINE__, __FILE__
);
$row = $dbh->fetch_assoc($sth);
if (!$row) {
    http_response_code(404);
    die("User not found.");
}

// --- CSRF token ---
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf = $_SESSION['csrf_token'];

$errors = [];
$saved  = false;

// --- Handle POST ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf'])) {
        $errors[] = "Invalid CSRF token.";
    } else {
        $updates = [];
        $params  = [];

        // Enabled (0/1)
        $enabled = isset($_POST['Enabled']) ? 1 : 0;
        $updates[] = "`Enabled` = ?";
        $params[]  = $enabled;

        // KanVerlopen (0/1)
        $kan = isset($_POST['KanVerlopen']) ? 1 : 0;
        $updates[] = "`KanVerlopen` = ?";
        $params[]  = $kan;

        // Verloopdatum (YYYY-MM-DD or 0000-00-00)
        $vd = trim($_POST['Verloopdatum'] ?? '');
        if ($vd === '') {
            $vd = '0000-00-00';
        } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $vd)) {
            $errors[] = "Verloopdatum must be in YYYY-MM-DD format.";
        }
        $updates[] = "`Verloopdatum` = ?";
        $params[]  = $vd;

        // Comment
        $comment = trim($_POST['Comment'] ?? '');
        $updates[] = "`Comment` = ?";
        $params[]  = $comment;

        // AangevraagdDoor
        $aan = trim($_POST['AangevraagdDoor'] ?? '');
        $updates[] = "`AangevraagdDoor` = ?";
        $params[]  = $aan;

        // PasswordClear (optional) + set Password=MD5(?)
        $pwd = $_POST['PasswordClear'] ?? '';
        if ($pwd !== '') {
            $updates[] = "`PasswordClear` = ?, `Password` = MD5(?)";
            $params[]  = $pwd;
            $params[]  = $pwd;
        }

        if (!$errors) {
            // Build UPDATE and execute
            $params[] = $user;
            $sql = "UPDATE `ftpusers`.`users` SET ".implode(', ', $updates)." WHERE `User` = ?";
            $dbh->do_placeholder_query($sql, $params, __LINE__, __FILE__);
            $saved = true;

            // Reload the row to show current values after save
            $sth = $dbh->do_placeholder_query(
                "SELECT * FROM `ftpusers`.`users` WHERE `User` = ?",
                [$user],
                __LINE__, __FILE__
            );
            $row = $dbh->fetch_assoc($sth);
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Edit FTP User — <?=htmlspecialchars($user)?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Edit FTP User: <span class="text-primary"><?=htmlspecialchars($user)?></span></h1>
    <a href="ftpusers_list.php" class="btn btn-secondary">Back to list</a>
  </div>

  <?php if ($saved): ?>
    <div class="alert alert-success">Changes saved.</div>
  <?php endif; ?>

  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <ul class="mb-0"><?php foreach ($errors as $e): ?><li><?=htmlspecialchars($e)?></li><?php endforeach; ?></ul>
    </div>
  <?php endif; ?>

  <form method="post" class="card card-body shadow-sm mb-4">
    <input type="hidden" name="csrf" value="<?=htmlspecialchars($csrf)?>">

    <div class="row mb-3">
      <div class="col-md-6">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="Enabled" name="Enabled" <?=$row['Enabled'] ? 'checked' : ''?>>
          <label class="form-check-label" for="Enabled">Enabled</label>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="KanVerlopen" name="KanVerlopen" <?=$row['KanVerlopen'] ? 'checked' : ''?>>
          <label class="form-check-label" for="KanVerlopen">KanVerlopen</label>
        </div>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Verloopdatum</label>
        <input
          type="date"
          name="Verloopdatum"
          class="form-control"
          value="<?=($row['Verloopdatum'] && $row['Verloopdatum']!=='0000-00-00') ? htmlspecialchars($row['Verloopdatum']) : ''?>">
        <div class="form-text">Laat leeg voor <code>0000-00-00</code> (geen verloop).</div>
      </div>
      <div class="col-md-6">
        <label class="form-label">AangevraagdDoor</label>
        <input type="text" name="AangevraagdDoor" class="form-control" value="<?=htmlspecialchars((string)$row['AangevraagdDoor'])?>">
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Comment</label>
      <textarea name="Comment" class="form-control" rows="3"><?=htmlspecialchars((string)$row['Comment'])?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">New Password</label>
      <input type="password" name="PasswordClear" class="form-control" value="">
      <div class="form-text">Laat leeg om het bestaande wachtwoord te behouden.</div>
    </div>

    <button type="submit" class="btn btn-success">Save</button>
    <a href="ftpusers_list.php" class="btn btn-outline-secondary">Cancel</a>
  </form>

  <!-- Read-only info (optional) -->
  <div class="card card-body">
    <h5 class="mb-3">Read-only info</h5>
    <dl class="row mb-0">
      <?php foreach ($READONLY_FIELDS as $f): ?>
        <dt class="col-sm-3"><?=htmlspecialchars($f)?></dt>
        <dd class="col-sm-9"><?=htmlspecialchars((string)$row[$f])?></dd>
      <?php endforeach; ?>
    </dl>
  </div>

</div>
</body>
</html>
