<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    
    $dbh = new sql();
    $dbh->connect();

    if($_GET['actie'] == "aanmaken")
    {
        $queryvars = array($_GET['id']);
        $query = "update " . $page['settings']['locations']['db_prefix'] . "ua_users SET archief = 1 where id = ?";
    }
    else if($_GET['actie'] == "verwijderen")
    {
        $queryvars = array($_GET['id']);
        $query = "update " . $page['settings']['locations']['db_prefix'] . "ua_users SET archief = 2 where id = ?";
    }
    
    $dbh->do_placeholder_query($query,$queryvars,__line__,__file__);

?>