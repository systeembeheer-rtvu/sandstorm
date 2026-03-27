<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    
    $dbh = new sql();
    
    $dbh->connect();
    
    $output = array();
    
    $query = "
            SELECT id, categorie
            FROM " . $page['settings']['locations']['db_prefix'] . "categorie
            WHERE actief = 0
        ";
        
    $sth = $dbh-> do_query($query,__LINE__,__FILE__);
        
    $counter = 0;
    while($vars = $dbh->fetch_array($sth))
    {
        $output[$counter++] = array(
            'id' => $vars['id'],
            'categorie' => $vars['categorie']
        );
    }
    
    echo json_encode($output);
?>