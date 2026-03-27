<?php
require_once("/mnt/data/include/config.shredder.inc.php");
require_once("/mnt/data/include/mysqli.inc.php");
$dbh = new sql;
$dbh -> connect();

$date1 = (string)@$_GET['date1'];
$date2 = (string)@$_GET['date2'];

$validDate1 = preg_match('/\A\d{4}-\d\d-\d\d\z/', $date1);
$validDate2 = preg_match('/\A\d{4}-\d\d-\d\d\z/', $date2);

function formatDutchDate($datestr) {
    $dagen  = ['zondag','maandag','dinsdag','woensdag','donderdag','vrijdag','zaterdag'];
    $maanden = ['','januari','februari','maart','april','mei','juni','juli','augustus','september','oktober','november','december'];
    $dt = new DateTime($datestr);
    return $dagen[(int)$dt->format('w')] . ' ' .
           (int)$dt->format('j') . ' ' .
           $maanden[(int)$dt->format('n')] . ' ' .
           $dt->format('Y H:i');
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mini Exchange — Overzicht</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
</head>
<body class="bg-light">
<div class="container-fluid py-3">

    <div class="d-flex align-items-center gap-3 mb-3">
        <a href="/mix/" class="btn btn-secondary btn-sm">&larr; Home</a>
        <h5 class="mb-0">Overzicht gepubliceerde berichten</h5>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="get" action="">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <label class="mb-0">Van:</label>
                    <input type="date" name="date1" class="form-control" style="width:auto;" value="<?= htmlspecialchars($date1) ?>">
                    <label class="mb-0">Tot:</label>
                    <input type="date" name="date2" class="form-control" style="width:auto;" value="<?= htmlspecialchars($date2) ?>">
                    <button type="submit" class="btn btn-primary">Tonen</button>
                </div>
            </form>
        </div>
    </div>

<?php if ($validDate1 && $validDate2): ?>

    <div class="card">
        <div class="card-header">
            <strong><?= htmlspecialchars($date1) ?></strong> t/m <strong><?= htmlspecialchars($date2) ?></strong>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-bordered table-sm mb-0" id="sortTable">
            <thead class="table-dark">
                <tr>
                    <th>Online</th>
                    <th>Titel</th>
                    <th>URL</th>
                    <th>Outlets</th>
                </tr>
            </thead>
            <tbody>
<?php
    $sth = $dbh->do_placeholder_query("
        SELECT dalet_id, website_online, website_titel, website_categorie, website_outlet
        FROM dalet_berichten
        WHERE rex_online = 1
          AND website_zichtbaar = 'TRUE'
          AND ((website_categorie LIKE '%|Sport|%') OR (website_categorie LIKE '%|Nieuws|%'))
          AND website_online BETWEEN ? AND ?
          AND website_outlet NOT LIKE '%|NP33|%'
        ORDER BY website_online
    ", array($date1, $date2), __LINE__, __FILE__);

    while (list($dalet_id, $online, $website_titel, $website_categorie, $website_outlet) = $dbh->fetch_array($sth)) {
        $cat     = strpos($website_categorie, "|Sport|") !== false ? "sport" : "nieuws";
        $url     = "https://www.rtvutrecht.nl/$cat/$dalet_id/-";
        $outlets = implode(", ", array_filter(explode("|", $website_outlet)));
        $online  = htmlspecialchars(formatDutchDate($online));
        $titel   = htmlspecialchars($website_titel);
        $outlets = htmlspecialchars($outlets);
        echo "<tr><td>$online</td><td>$titel</td><td><a href=\"$url\" target=\"_blank\">$url</a></td><td>$outlets</td></tr>\n";
    }
?>
            </tbody>
            </table>
        </div>
    </div>

<?php elseif ($date1 || $date2): ?>
    <div class="alert alert-warning">Vul beide datums in.</div>
<?php endif; ?>

</div>
<script>
$(document).ready(function () {
  $('#sortTable').DataTable({
    "order": [[ 0, "asc" ]],
    "pageLength": 50
  });
});
</script>
</body>
</html>
