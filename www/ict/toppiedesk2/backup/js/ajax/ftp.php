<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");

    $naam = $_GET['name'];
    $status = intval($_GET['checked']);
    $datum = $_GET['datum'];
    $comment = $_GET['comment'];
    
    $dbh = new sql();
    $dbh->connect();
    
    $output['error'] = array();
    
    $continue = true;
    
    if (!preg_match('/\d{4}-\d{1,2}-\d{1,2}/', $datum)) {
	$continue = false;
        array_push($output['error'], "datum");
    }

    if($continue)
    {
        $queryvars = array($datum, $status, $comment, $naam);
        
        $query = "UPDATE users SET verloopdatum = ?, kanverlopen = ?, Comment = ? WHERE user = ?";
        $dbh->do_placeholder_query($query,$queryvars,__line__,__file__);
        
        $output['status'] = "success";
    }
    else
        $output['status'] = "failed";
    
    echo json_encode($output);
?>