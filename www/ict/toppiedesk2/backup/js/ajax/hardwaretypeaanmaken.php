<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    
    $dbh = new sql();
    
    $dbh->connect();
    
    $typenaam = $_GET['typenaam'];
    
    $queryvars = array($typenaam);
    $query = "
        INSERT INTO " . $page['settings']['locations']['db_prefix'] . "hardware_types (type)
        VALUES (?)
    ";

    $dbh->do_placeholder_query($query,$queryvars,__line__,__file__);
?>