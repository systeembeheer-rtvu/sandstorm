<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    
    $dbh = new sql();
    
    $dbh->connect();
    
    $typenaam = $_GET['typenaam'];
    
    $queryvars = array($typenaam);
    $query = "
        select count(*) as count from `" . $page['settings']['locations']['db_prefix'] . "hardware_types`
        where type = ?
    ";

    $sth = $dbh->do_placeholder_query($query,$queryvars,__line__,__file__);
    
    $vars = $dbh->fetch_array($sth);
    
    echo $vars['count'];
?>