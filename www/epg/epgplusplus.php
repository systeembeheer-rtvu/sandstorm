<?php
// Voeg de PDO database verbinding toe
require_once("/mnt/data/include/config.epg.inc.php");
require_once("/mnt/data/include/pdo.db.inc.php");

date_default_timezone_set('Europe/Amsterdam'); // Set your timezone

$currentDate = date('d-m-Y'); // Get the current date in DD-MM-YYYY format
$selectedDate = isset($_GET['date']) ? $_GET['date'] : $currentDate; // Use selected date if available
$selectedZender = isset($_GET['zender']) ? $_GET['zender'] : 'RTVU'; // Default to 'RTVU'
$filterHerhaling = isset($_GET['filterHerhaling']) ? $_GET['filterHerhaling'] : ''; // Check if Herhaling filter is applied

// The selected date is already in DD-MM-YYYY format
$formattedDate = $selectedDate;

$zenders = array(
    "BFM" => "Bingo FM",
    "UST" => "UStad",
    "RTVU" => "RTV Utrecht",
    "RUTR" => "Radio M Utrecht"
);

$tableContent = "";

try {
    $epgtabel = "
        SELECT ProgDate, ProgStartTime, ProgTitle, ProgItemID, ProgHHID, Published, ShowInMissed
        FROM epg
        WHERE ProgDate = :date AND zender = :zender
    ";

    // Add condition to filter out replays if the Herhaling filter is checked
    if ($filterHerhaling) {
        $epgtabel .= " AND ProgItemID = ProgHHID";
    }

    $epgtabel .= " ORDER BY ProgStartTime";

    $stmt = $connweb->prepare($epgtabel);
    $stmt->bindParam(':date', $formattedDate);
    $stmt->bindParam(':zender', $selectedZender);
    $stmt->execute();

    // Debugging: Show the query parameters and the generated query
    $debugQuery = str_replace(
        [':date', ':zender'],
        [$formattedDate, $selectedZender],
        $epgtabel
    );

    echo "<pre>Debugging Information:\n";
    echo "Selected Date: $selectedDate\n";
    echo "Formatted Date: $formattedDate\n";
    echo "Selected Zender: $selectedZender\n";
    echo "Filter Herhaling: $filterHerhaling\n";
    echo "Generated Query:\n$debugQuery\n";
    echo "</pre>";

    if ($stmt->rowCount() > 0) {
        $tableContent .= <<<TABLEEPG
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Datum</th>
                <th>Tijdstip</th>
                <th>Programma</th>
                <th>Herhaling</th>
                <th>Gepubliceerd</th>
                <th>Uitzending Gemist</th>
            </tr>
        </thead>
        <tbody>
        TABLEEPG;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $origineel = $row['ProgItemID'] == $row['ProgHHID'];
            $published = filter_var($row['Published'], FILTER_VALIDATE_BOOLEAN);
            $gemist = filter_var($row['ShowInMissed'], FILTER_VALIDATE_BOOLEAN);

            $tableContent .= "<tr>
                <td>{$row['ProgDate']}</td>
                <td>{$row['ProgStartTime']}</td>
                <td>{$row['ProgTitle']}</td>
                <td>" . ($origineel ? 'Nee' : 'Ja') . "</td>
                <td>" . ($published ? 'Ja' : 'Nee') . "</td>
                <td>" . ($gemist ? 'Ja' : 'Nee') . "</td>
            </tr>\n";
        }

        $tableContent .= "</tbody></table>";
    } else {
        $tableContent = "Er is geen data beschikbaar voor deze datum en zender.";
    }
} catch (PDOException $e) {
    $tableContent = "Database error: " . $e->getMessage();
}

// HTML and JavaScript content
echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datepicker Form with Sortable Table</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <!-- Custom CSS -->
    <style>
        .quick-select-buttons {
            display: flex;
            align-items: center;
        }
        .quick-select-buttons button {
            margin-right: 5px;
        }
        .form-inline .form-group {
            margin-right: 10px;
        }
        .checkbox-filters {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .checkbox-filters label {
            margin-right: 15px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <form id="dateForm" class="form-inline" method="GET">
        <div class="form-group">
            <label for="zender" class="mr-2">Zender:</label>
            <select class="form-control" id="zender" name="zender">
HTML;

foreach ($zenders as $key => $value) {
    $selected = ($key == $selectedZender) ? 'selected' : '';
    echo "<option value=\"$key\" $selected>$value</option>";
}

echo <<<HTML
            </select>
        </div>
        <div class="form-group">
            <label for="datepicker" class="mr-2">Select Date:</label>
            <input type="text" class="form-control" id="datepicker" name="date" value="$selectedDate">
        </div>
        <div class="quick-select-buttons">
            <button type="button" class="btn btn-secondary" onclick="setQuickDate('previousDay')">Previous Day</button>
            <button type="button" class="btn btn-secondary" onclick="setQuickDate('today')">Today</button>
            <button type="button" class="btn btn-secondary" onclick="setQuickDate('nextDay')">Next Day</button>
            <button type="button" class="btn btn-secondary" onclick="setQuickDate('lastWeek')">Previous Week</button>
            <button type="button" class="btn btn-secondary" onclick="setQuickDate('nextWeek')">Next Week</button>
            <button type="button" class="btn btn-secondary" onclick="setQuickDate('lastMonth')">Previous Month</button>
            <button type="button" class="btn btn-secondary" onclick="setQuickDate('nextMonth')">Next Month</button>
        </div>
        <div class="form-group">
            <label for="filterHerhaling" class="mr-2">Herhaling:</label>
            <input type="checkbox" id="filterHerhaling" name="filterHerhaling" value="1" 
HTML;

if ($filterHerhaling) {
    echo ' checked';
}

echo <<<HTML
>
        </div>
        <button type="submit" class="btn btn-primary ml-2">Submit</button>
    </form>

    <div class="checkbox-filters mt-4">
        <label><input type="checkbox" id="filterHerhalingCheckbox"> Herhaling</label>
        <label><input type="checkbox" id="filterGepubliceerd"> Gepubliceerd</label>
        <label><input type="checkbox" id="filterUitzendingGemist"> Uitzending Gemist</label>
    </div>

    $tableContent
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<!-- Custom JS -->
<script>
    $(function() {
        $("#datepicker").datepicker({
            dateFormat: 'dd-mm-yy'
        });

        // Initialize DataTables without pagination
        var table = $('#example').DataTable({
            "paging": false, // Disable pagination
            "order": [[ 1, "asc" ]] // Default sort on 'Tijdstip' column
        });

        $('#filterHerhalingCheckbox').on('change', function() {
            filterColumn(3, this.checked);
        });

        $('#filterGepubliceerd').on('change', function() {
            filterColumn(4, this.checked);
        });

        $('#filterUitzendingGemist').on('change', function() {
            filterColumn(5, this.checked);
        });

        function filterColumn(columnIndex, checked) {
            table.column(columnIndex).search(checked ? 'Ja' : '', true, false).draw();
        }
    });

    function setQuickDate(type) {
        var date = $('#datepicker').datepicker('getDate') || new Date();
        switch(type) {
            case 'previousDay':
                date.setDate(date.getDate() - 1);
                break;
            case 'today':
                date = new Date();
                break;
            case 'nextDay':
                date.setDate(date.getDate() + 1);
                break;
            case 'lastWeek':
                date.setDate(date.getDate() - 7);
                break;
            case 'nextWeek':
                date.setDate(date.getDate() + 7);
                break;
            case 'lastMonth':
                date.setMonth(date.getMonth() - 1);
                break;
            case 'nextMonth':
                date.setMonth(date.getMonth() + 1);
                break;
        }
        $("#datepicker").datepicker("setDate", date);
        $("#dateForm").submit(); // Submit the form
    }
</script>

</body>
</html>
HTML;
?>
