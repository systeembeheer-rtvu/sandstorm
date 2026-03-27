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
        ";
        
    $sth = $dbh-> do_query($query,__LINE__,__FILE__);
        
    $counter = 0;
    while($vars = $dbh->fetch_array($sth))
    {
        $output[$counter++] = $vars['naam'];
    }
    
    if(isset($output))
    {
        sort($output);
        
        foreach($output as $value)
        {
            echo $value . "\n";
        }
    }
?>