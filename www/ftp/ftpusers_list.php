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

$dbh = new sql;
$dbh->connect();

// Columns to display (Ipaddress removed)
$LIST_COLUMNS = [
    'User','Enabled','Verloopdatum','KanVerlopen','LastLogin','Comment'
];

// Pull rows
$sql = "
    SELECT * 
    FROM `ftpusers`.`users`
    ORDER BY `User` ASC
    LIMIT 500
";
$rows = $dbh->do_placeholder_query($sql, [], __LINE__, __FILE__);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>FTP Users — Overview</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap-table CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.1/dist/bootstrap-table.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">

  <h1 class="mb-3">FTP Users</h1>

  <table
    id="ftpusersTable"
    class="table table-striped table-bordered"
    data-toggle="table"
    data-search="true"
    data-show-columns="true"
    data-pagination="true"
    data-page-size="25"
  >
    <thead class="table-dark">
      <tr>
        <?php foreach ($LIST_COLUMNS as $col): ?>
          <th data-field="<?=htmlspecialchars($col)?>" data-sortable="true"><?=htmlspecialchars($col)?></th>
        <?php endforeach; ?>
        <th data-field="_edit" data-sortable="false">Edit</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row): ?>
        <tr>
          <?php foreach ($LIST_COLUMNS as $col): ?>
            <td>
              <?php
                // Basic pretty printing for booleans & dates
                if (in_array($col, ['Enabled','KanVerlopen'], true)) {
                    echo $row[$col] ? 'Yes' : 'No';
                } else {
                    echo htmlspecialchars((string)$row[$col]);
                }
              ?>
            </td>
          <?php endforeach; ?>
          <td>
            <a href="ftpusers_edit.php?User=<?=urlencode($row['User'])?>" class="btn btn-sm btn-primary">Edit</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</div>

<!-- jQuery (required by bootstrap-table) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- bootstrap-table JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>

</body>
</html>
