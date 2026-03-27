<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    require_once("/mnt/data/include/config.shredder.inc.php");
    require_once("/mnt/data/include/mysqlp.inc.php");
    $dbh = new sql;
    $dbh -> connect(); // connect
    
    $id = intval(@$_GET['id']);
    $daletid = intval(@$_GET['daletid']);
    if (!$id) exit;
    $query = "
        select timestamp,log,status,xml_in
        from dalet_log
        where id = ?
    ";
    $sth = $dbh->do_placeholder_query($query,array($id),__LINE__,__FILE__);
    list($timestamp,$log,$status,$xml_in) = $dbh -> fetch_array($sth);
    $xml = htmlspecialchars($xml_in, ENT_QUOTES);
    
    $log = json_decode($log,TRUE);
    $display = array();
    $display['Tijdstip verwerking'] = $timestamp;
    $display['MIX Status'] = $status;
    $display['XML vanuit Nimbus'] = "<a href=\"showxml.php?id=$id\" target=\"_BLANK\">Show</a>";

    $errorsinhoudelijk = implode("|",$log['errors']['inhoud']);    
    $errorstechnisch = implode("|",$log['errors']['technisch']);
    unset($log['errors']);
    $log['Errors inhoudelijk'] = $errorsinhoudelijk;
    $log['Errors technisch'] = $errorstechnisch;
    
    $show = array_merge($display,$log);
    

    echo <<<DUMP
<!DOCTYPE html>
<html ng-app="app">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>MIX Moredetail - $daletid ($id)</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <meta name="description" content="Sandstorm" />
</head>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<body ng-cloak>
<table class="table-striped"><tbody>
DUMP;
foreach($show as $key=>$s) {
    if (is_array($s)) {
	echo "<tr><td>$key</td><td><pre>"; print_r($s); echo "</td></tr>";
          } else {
        $s = trim($s,"|");
        $s = str_replace("|","<br>",$s);
	echo "<tr><td valign='top'>$key</td><td valign='top'>$s</td></tr>";
    }
  
} 
    
    
        
    echo <<<DUMP
    </tbody></table>
</body>
</html>

DUMP;
?>