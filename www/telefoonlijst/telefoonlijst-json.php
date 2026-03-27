<?php
// Include necessary files
require_once("/mnt/data/include/config.inc.php");
require_once("/mnt/data/include/mysqli.inc.php");

// Initialize database connection
$dbh = new sql;
$dbh->connect();

$thelist = [];

// Define the query
$query = "
    SELECT 
        tl.naam, 
        tl.telefoonnummer, 
        tl.login,
        (DATE(tl.tijd) = CURDATE()) AS today, 
        ROUND(TIME_TO_SEC(TIMEDIFF(NOW(), tl.tijd)) / 3600) AS hours, 
        tl.workstation, 
        tl.workstationip, 
        tn.upn
    FROM 
        telefoonlijst AS tl
    JOIN 
        adusers AS tn ON LOWER(tl.login) = LOWER(tn.samaccountname)
    ORDER BY 
        tl.naam ASC
";

// Execute the query
$sth = $dbh->do_query($query, __LINE__, __FILE__);

// Fetch the results
while (list($naam, $telefoonnummer, $login, $today, $hours, $workstation, $workstationip, $upn) = $dbh->fetch_array($sth)) {
    // Skip if more than 12 hours have passed
    if ($hours > 12) continue;

    // Determine location
    $location = "hengeveldstraat";
    if (preg_match('/^VDI.*/i', $workstation)) {
        $location = "vdi";
    } elseif (preg_match('/^172\.31\..*/', $workstationip)) {
        $location = "globalprotect";
    }

    // Create the entry
    $thelist[] = [
        'name' => $naam,
        'alias' => $login,
        'upn' => $upn,
        'phonenumber' => $telefoonnummer,
        'location' => $location
    ];
}

// Output the list as JSON
echo json_encode($thelist, JSON_PRETTY_PRINT);

?>
