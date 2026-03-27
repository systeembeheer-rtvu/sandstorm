<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    
    $dbh = new sql();
    
    $output = "";
    
    $dbh->connect();
    
    $query = "
        select
            u.naam,
            telefoonnummer,
            u.inlognaam,
            s.id,
            afdeling4
        from
            `toppie_users` u 
        left join
            smoelenboek s
        on
            u.inlognaam = s.inlognaam
        left join
            telefoonlijst t
        on
            u.inlognaam = t.login
    ";
    
    $sth = $dbh -> do_query($query,__LINE__,__FILE__);
    
    $counter = 0;
    while($vars = $dbh->fetch_array($sth))
    {
        $load['gebruikers'][$counter++] = array(
            'naam' => $vars['naam'],
            'afdeling' => $vars['afdeling4'],
            'id' => $vars['id'],
            'telefoonnummer' => $vars['telefoonnummer'],
            'inlognaam' => strtolower($vars['inlognaam'])
        );
    }

    echo json_encode($load);
?>