<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    
    $dbh = new sql();
    
    $output = "";
    
    $dbh->connect();
    
    $queryvars = array($_GET['contract']);
    
    $query = "
        update `toppie_contract` 
        set actief = (actief + 1) % 2
        where id = ?
    ";
    
    $dbh-> do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
?>