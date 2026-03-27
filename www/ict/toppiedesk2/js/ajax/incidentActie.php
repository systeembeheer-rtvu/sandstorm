<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    require_once("../../scripts/functions/sanitizer.inc.php");

    $dbh = new sql();
    
    $dbh->connect();
    
    $san = new Sanitizer();

    $id = $_GET['id'];
    $value = $san->SanitizeInput($_GET['value']);
    
    $queryvars = array($value, $id);
    $query = "UPDATE " . $page['settings']['locations']['db_prefix'] . "incidentacties SET actie = ? where id = ?";
    
    $dbh->do_placeholder_query($query,$queryvars,__line__,__file__);
?>