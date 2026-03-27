<?php
    require_once("../../config.inc.php");
    require_once("../../" . $page['root'] . "/libs/mysql.inc.php");
    
    $dbh = new sql();
    $dbh->connect2(
	$global_ftp['DATABASE_SERVER'],
	$global_ftp['DATABASE_USER'],
	$global_ftp['DATABASE_PASSWORD'],
	$global_ftp['DATABASE_NAME']
    );

    $array['error'] = array();

    $input['naam'] = $_GET['naam'];
    
    $error = 1;

    if (!preg_match('/\b[a-z0-9]+\b/', $input['naam'])) {
	array_push($array['error'], "naam");
        $error = 0;
    }
    
    $queryvars = array($input['naam']);
    $query = "select count(u.user) as count from users u where u.user = ?";

    $sth = $dbh->do_placeholder_query($query,$queryvars,__line__,__file__);
    
    $array = $dbh->fetch_array($sth);
    echo $array[0];
?>