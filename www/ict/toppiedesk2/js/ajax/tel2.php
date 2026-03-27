<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    
    $dbh = new sql();
    
    $dbh->connect();
    
    $query = "
            SELECT t.telefoonnummer
            FROM telefoonlijst t
            Left join smoelenboek s
            on t.login = s.inlognaam
        ";
        
    $sth = $dbh-> do_query($query,__LINE__,__FILE__);
        
    $counter = 0;
    while($vars = $dbh->fetch_array($sth))
    {
        $output[$counter++] = $vars['telefoonnummer'];
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