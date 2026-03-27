<?php
session_start(); // Start session to store preferences

require_once("/mnt/data/include/config.shredder.inc.php");
require_once("/mnt/data/include/mysqli.inc.php");
$dbh = new sql;
$dbh->connect(); // Connect to database

// List of channels
$channels = [
    'RTVU' => 'RTV Utrecht',
    'BFM'  => 'Bingo FM',
    'UST'  => 'UStad',
    'RUTR' => 'Radio M Utrecht'
];

// Get the selected date (default: today or session)
if (isset($_GET['datum'])) {
    $_SESSION['epg_datum'] = $_GET['datum'];
}
$selected_date = $_SESSION['epg_datum'] ?? date('Y-m-d');
$formatted_date = str_replace('-', '', $selected_date); // Convert to YYYYMMDD

// Get previous and next dates
$prev_date = date('Y-m-d', strtotime($selected_date . ' -1 day'));
$next_date = date('Y-m-d', strtotime($selected_date . ' +1 day'));

// Format for display: Monday 11-03-2024
$display_date = strftime("%A %d-%m-%Y", strtotime($selected_date));

// Get selected channel (default: RTVU or session)
if (isset($_GET['zender']) && array_key_exists($_GET['zender'], $channels)) {
    $_SESSION['epg_zender'] = $_GET['zender'];
}
$selected_channel = $_SESSION['epg_zender'] ?? 'RTVU';

// Handle rerun toggle correctly
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['show_reruns'])) {
        $_SESSION['epg_show_reruns'] = 1; // Checkbox checked
    } elseif (isset($_GET['datum']) || isset($_GET['zender'])) {
        $_SESSION['epg_show_reruns'] = 0; // Checkbox not present = unchecked
    } elseif (!isset($_SESSION['epg_show_reruns'])) {
        $_SESSION['epg_show_reruns'] = 1; // First page load: enable by default
    }
}
$show_reruns = $_SESSION['epg_show_reruns'];

// SQL query with rerun filtering
$query = "
    SELECT 
        p.datum, 
        p.tijd AS ProgStartTime,
        p.herhaling,
        e.SeriesTitle, 
        e.ProgTitle, 
        p.daletid
    FROM epg_programmering p
    LEFT JOIN epg_episodes e ON p.daletid = e.daletid
    WHERE p.zender = '{$selected_channel}'
    AND p.datum = '{$formatted_date}'
";

if (!$show_reruns) {
    $query .= " AND p.herhaling = 0";
}

$query .= " ORDER BY p.tijd";

$sth = $dbh->do_query($query, __LINE__, __FILE__);

$programs = [];
while (list($datum, $start, $herhaling, $series, $title, $daletid) = $dbh->fetch_array($sth)) {
    $programs[] = [
        'datum' => $datum,
        'start' => $start,
        'herhaling' => $herhaling ? 'Ja' : 'Nee',
        'series' => $series ?: '-',
        'title' => $title ?: '-',
        'daletid' => $daletid
    ];
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPG Overzicht</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        function autoSubmit() {
            document.getElementById("filterForm").submit();
        }
    </script>
</head>
<body class="container mt-4">

    <h2 class="mb-4">EPG Overzicht EPG Additor</h2>
    <h3 class="mb-4"><a href="https://sandstorm.park.rtvutrecht.nl/epg/epgarchief.php">Archief voor EPG Additor</a></h3>

    <form method="GET" id="filterForm" class="mb-3">
        <div class="row">
            <!-- Date Selection -->
            <div class="col-md-4">
                <label for="datum" class="form-label">Kies een datum:</label>
                <div class="input-group">
                    <a href="?datum=<?= $prev_date ?>&zender=<?= $selected_channel ?>&show_reruns=<?= $show_reruns ?>" class="btn btn-outline-secondary">← Vorige dag</a>
                    <input type="date" id="datum" name="datum" class="form-control" value="<?= htmlspecialchars($selected_date) ?>" onchange="autoSubmit()">
                    <a href="?datum=<?= $next_date ?>&zender=<?= $selected_channel ?>&show_reruns=<?= $show_reruns ?>" class="btn btn-outline-secondary">Volgende dag →</a>
                </div>
                <small class="text-muted"><?= ucfirst($display_date) ?></small>
            </div>

            <!-- Channel Selection -->
            <div class="col-md-4">
                <label for="zender" class="form-label">Selecteer een zender:</label>
                <select id="zender" name="zender" class="form-select" onchange="autoSubmit()">
                    <?php foreach ($channels as $key => $name): ?>
                        <option value="<?= $key ?>" <?= $key === $selected_channel ? 'selected' : '' ?>>
                            <?= htmlspecialchars($name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Rerun Toggle -->
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="show_reruns" name="show_reruns" value="1" <?= $show_reruns ? 'checked' : '' ?> onchange="autoSubmit()">
                    <label class="form-check-label" for="show_reruns">Toon herhalingen</label>
                </div>
            </div>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Datum</th>
                <th>Starttijd</th>
                <th>Herhaling</th>
                <th>Serie</th>
                <th>Programmatitel</th>
                <th>Additor link</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($programs)) : ?>
                <?php foreach ($programs as $prog) : ?>
<tr>
    <td style="<?= $prog['herhaling'] === 'Nee' ? 'background-color: #40E0D0 !important;' : '' ?>"><?= htmlspecialchars($prog['datum']) ?></td>
    <td style="<?= $prog['herhaling'] === 'Nee' ? 'background-color: #40E0D0 !important;' : '' ?>"><?= htmlspecialchars($prog['start']) ?></td>
    <td style="<?= $prog['herhaling'] === 'Nee' ? 'background-color: #40E0D0 !important;' : '' ?>"><?= htmlspecialchars($prog['herhaling']) ?></td>
    <td style="<?= $prog['herhaling'] === 'Nee' ? 'background-color: #40E0D0 !important;' : '' ?>"><?= htmlspecialchars($prog['series']) ?></td>
    <td style="<?= $prog['herhaling'] === 'Nee' ? 'background-color: #40E0D0 !important;' : '' ?>"><?= htmlspecialchars($prog['title']) ?></td>
    <td style="<?= $prog['herhaling'] === 'Nee' ? 'background-color: #40E0D0 !important;' : '' ?>">
        <a href="https://epg.rtvutrecht.nl/epg-guide/title/<?= htmlspecialchars($prog['daletid']) ?>" target="_blank">
            <?= htmlspecialchars($prog['daletid']) ?>
        </a>
    </td>
</tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="text-center">Geen resultaten gevonden voor deze datum.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
