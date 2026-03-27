<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    
    $dbh = new sql();
    
    $output = "";
    
    $dbh->connect();

    $queryvars = array($_GET['hardware']);
    $query = "
        select multi, count(naam) as persoon
        from ".  $page['settings']['locations']['db_prefix'] ."hardware h 
        left join `" .  $page['settings']['locations']['db_prefix'] . "hardware_hardware-persoon` hp
        on h.oid = hp.hardware_oid
        where h.oid = ?
        group by naam
    ";
    
    $sth = $dbh -> do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
    
    $vars = $dbh->fetch_array($sth);
    
    if($vars['multi'] == 1 || $vars['persoon'] == 0)
    {
        $queryvars = array($_GET['hardware'], $_GET['name']);
        $query = "
            insert into `" .  $page['settings']['locations']['db_prefix'] . "hardware_hardware-persoon` (hardware_oid, naam)
            values(?, ?)
        ";
        
        $dbh -> do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
    }
?>