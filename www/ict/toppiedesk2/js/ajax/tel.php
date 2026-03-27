<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    
    $dbh = new sql();
    
    $dbh->connect();
    
    $queryvars = array($_GET['q'] . '%');
    
    $query = "
            SELECT t.telefoonnummer
            FROM telefoonlijst t
            Left join smoelenboek s
            on t.login = s.inlognaam
            where telefoonnummer like ?
        ";
        
    $sth = $dbh-> do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
        
    $counter = 0;
    while($vars = $dbh->fetch_array($sth))
    {
        $output[$counter++] = $vars['telefoonnummer'];
    }
    
    if(isset($output))
    {
        sort($output);
        
        $first = true;
        
        foreach($output as $value)
        {
            echo $value . "\n";
        }
    }
?>