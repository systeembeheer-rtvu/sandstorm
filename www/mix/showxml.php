<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    require_once("/mnt/data/include/config.shredder.inc.php");
    require_once("/mnt/data/include/mysqli.inc.php");
    $dbh = new sql;
    $dbh -> connect(); // connect
    
    $id = $_GET['id'] ?? 0;
    $field = isset($_GET['out']) ? 'xml_out' : 'xml_in';

    if (!$id) exit;
    $query = "
        select timestamp,log,status,$field
        from dalet_log
        where id = ?
    ";
    $sth = $dbh->do_placeholder_query($query,array($id),__LINE__,__FILE__);
    list($timestamp,$log,$status,$xml_in) = $dbh -> fetch_array($sth);
    header ("Content-Type:text/xml");
    echo $xml_in;    
?>