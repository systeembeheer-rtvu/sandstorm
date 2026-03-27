<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    
    $dbh = new sql();
    
    $dbh->connect();
    
    $queryvars = array($_GET['q'] . '%');
    
    $query = "
            SELECT categorie
            FROM " . $page['settings']['locations']['db_prefix'] . "categorie
            where actief = 1
            and categorie like ?
        ";
        
    $sth = $dbh-> do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
        
    $counter = 0;
    while($vars = $dbh->fetch_array($sth))
    {
        $output[$counter++] = $vars['categorie'];
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