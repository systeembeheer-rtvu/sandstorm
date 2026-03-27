<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    require_once("/mnt/data/include/config.shredder.inc.php");
    require_once("/mnt/data/include/mysqli.inc.php");
    $dbh = new sql;
    $dbh -> connect(); // connect

    $logs = array();
    $query = "
        select dalet_id,bericht_id,last_update,website_online,website_offline,website_titel,website_categorie,mix_status,rex_rss,errors
        from dalet_berichten
        where website_titel != ''
        and (last_update > DATE_SUB(now(), INTERVAL 7 DAY))
        order by last_update desc
        
    ";
    $sth = $dbh->do_query($query,__LINE__,__FILE__);
    $rows = array();
    while (list($dalet_id,
           $bericht_id,
           $last_update,
           $online,
           $offline,
           $website_titel,
           $website_categorie,
           $mix_status,
           $rex_rss,
           $errors) = $dbh -> fetch_array($sth)) {
        $website_categorie = trim($website_categorie,"|");
        if ($errors=='{"technisch":{},"inhoud":{}}') {
        	$errors = "&nbsp;";
    	} else {
    		$errors = "&#10060;";    
        }
        
        if ($rex_rss) {
        	$rex_rss = "&#9989;";
    	} else {
    		$rex_rss = "&nbsp;";    
        }

        $online = preg_replace('/([\d-]{10})T([\d:]{5}).*/im', '\1 \2', $online);
        $offline = preg_replace('/([\d-]{10})T([\d:]{5}).*/im', '\1 \2', $offline);

	$row = array(                
                 "<a href=\"detail.php?id=$dalet_id\">$dalet_id</a>",
                 "<a href=\"https://www.rtvutrecht.nl/nieuws/$bericht_id\" target=\"_BLANK\">$bericht_id</a>",
                 "$last_update",
                 "$online",
                 "$offline",
                 "$website_categorie",
                 "{$mix_status}",
                 "{$rex_rss}",
                 "{$errors}",
                 "$website_titel"
                 );
        $rows[] = $row;
    }
    
    $json = json_encode($rows,JSON_FORCE_OBJECT);
    header('Content-Type: application/json; charset=utf-8');
    echo $json;

?>