<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    
    $dbh = new sql();
    $dbh->connect();
    
    $output = "";
    
    if(isset($_GET['id'])){
        $queryvars = array($_GET['id']);
        
        $query = "
            SELECT
                sc.id, c.id as categorie, sc.subcategorie, sc.actief
            FROM
                " . $page['settings']['locations']['db_prefix'] . "categorie c,
                " . $page['settings']['locations']['db_prefix'] . "subcategorie sc
            WHERE
                c.id = sc.categorie_id
            AND
                c.id = ?
        ";
        
        $sth = $dbh-> do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
        
        $counter = 0;
        while($vars = $dbh->fetch_array($sth))
        {
            $output[$counter++] = array(
                'id' => $vars['id'],
                'subcategorie' => $vars['subcategorie'],
                'categorie' => $vars['categorie'],
                'actief' => $vars['actief']
            );
        }
        
        if(is_array($output))
            sort($output);
    }
    
    echo json_encode($output);
?>