<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    
    $dbh = new sql();
    
    $dbh->connect();
    
    $query = "
            SELECT oid
            FROM " . $page['settings']['locations']['db_prefix'] . "hardware
            where actief = 0
        ";
        
    $sth = $dbh-> do_query($query,__LINE__,__FILE__);
    
    $counter = 0;
    while($vars = $dbh->fetch_array($sth))
    {
        $output[$counter++] = $vars['oid'];
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