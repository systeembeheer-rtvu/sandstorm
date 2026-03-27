<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    
    $dbh = new sql();
    
    $output = "";
    
    $dbh->connect();
    
    if($_GET['type'] == 'single')
    {
        $queryvars = array($_GET['oid'], $_GET['name']);
        
        $query = "
            delete from 
                `toppie_hardware_hardware-persoon` 
            where
                hardware_oid = ?
            and 
                naam = ?
        ";
    }
    else if($_GET['type'] == 'all')
    {
        $queryvars = array($_GET['name']);
        
        $query = "
            delete from 
                `toppie_hardware_hardware-persoon` 
            where
                naam = ?
        ";
    }
    
    $dbh-> do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
?>