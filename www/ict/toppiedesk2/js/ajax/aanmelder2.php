<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    
    $dbh = new sql();
    
    $output = "";
    
    $dbh->connect();
    
    $output = array();
    
    $query = "
        SELECT naam
        FROM toppie_users
        where actief = 2
    ";

    $sth = $dbh-> do_query($query,__LINE__,__FILE__);
        
    $counter = 0;
    while($vars = $dbh->fetch_array($sth))
    {
        $output[$counter++] = $vars['naam'];
    }
    
    $query = "
        Select naam
        FROM telefoonlijst
        where naam not in (
            SELECT naam
            FROM toppie_users
            where actief = 2
        )
    ";
    
    $sth = $dbh-> do_query($query,__LINE__,__FILE__);
        
    while($vars = $dbh->fetch_array($sth))
    {
        $output[$counter++] = $vars['naam'];
    }
    
    if(isset($output))
    {
        sort($output);
        
        echo "[";
        
        $first = true;
        
        foreach($output as $value)
        {
            if($first)
            {
                echo '"' . $value . '"';
                $first = false;
            }
            else
            {
                echo ', "' . $value . '"';
            }
        }
        
        echo "]"; 
    }
?>