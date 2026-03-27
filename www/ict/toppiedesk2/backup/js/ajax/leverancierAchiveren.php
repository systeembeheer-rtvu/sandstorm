<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    require_once("../../scripts/functions/sanitizer.inc.php");
    
    date_default_timezone_set('Europe/Belgrade');
    
    $dbh = new sql();
    $dbh->connect();
    
    $san = new Sanitizer();

    $id = $san->SanitizeInput($_GET['id']);
    
    if($id > 0){
        $queryvars = array($id);
        $query = "
            UPDATE " . $page['settings']['locations']['db_prefix'] . "leverancier
            SET leverancier = ?, klantnummer = ?, contactpersoon = ?, telefoonnummer = ?
            WHERE id = ?
        ";
        
        $dbh->do_placeholder_query($query,$queryvars,__line__,__file__);
    }
?>