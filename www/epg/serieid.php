<?php

    require_once("/mnt/data/include/config.shredder.inc.php");
    require_once("/mnt/data/include/mysqli.inc.php");
    $dbh = new sql;
    $dbh -> connect(); // connect
	
    $zenderprefix = array();
    $zenderprefix['RTVU'] = "rtvutrecht";
    $zenderprefix['RUTR'] = "radiomutrecht";
    $zenderprefix['USTAD'] = "ustad";
    $zenderprefix['BFM'] = "bingofm";

    
   // header('content-type: text/csv; charset=utf-8');

   echo "<table border=1><tr><th>SerieID</th><th>titel</th><th>isonline</th><th>online</th><th>offline</th></tr>";

    foreach ($zenderprefix as $prefix => $zender) {
        $query = "
            SELECT id,programma_titel,programma_zender,online,offline,now() between online and offline as IsOnline
            FROM table_EPG_programma
            WHERE programma_zender like '%{$zender}%'
            ORDER BY `IsOnline`  DESC,programma_titel;
        ";
        $sth = $dbh->do_query($query,__LINE__,__FILE__);
	while (list($id,$programma_titel,$programma_zender,$online,$offline,$IsOnline) = $dbh -> fetch_array($sth)) {
            $SerieID = "{$prefix}_{$id}";
            echo "<tr><td>$SerieID</td><td>$programma_titel</td><td>$IsOnline</td><td>$online</td><td>$offline</td></tr>";
        }
    }
    echo "</table>";
    
    
?>