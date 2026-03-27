<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    require_once("/mnt/data/include/config.shredder.inc.php");
    require_once("/mnt/data/include/mysqli.inc.php");
    $dbh = new sql;
    $dbh -> connect(); // connect

    echo "<table border='1'>";
    $query = "
    	SELECT p.category, b.dalet_id, b.website_titel, b.website_online, b.website_subcategorie, p.volgorde
	FROM website_priority_copy2 AS p
	JOIN dalet_berichten AS b ON p.dalet_id = b.dalet_id
	ORDER BY p.id
    ";
    $sth = $dbh->do_query($query,__LINE__,__FILE__);
    
    while (list($category,$dalet_id,$website_titel,$website_online,$website_subcat,$volgorde) = $dbh -> fetch_array($sth)) {
        
    		echo <<<DUMP
    <tr>
    	<td>$category</td>
    	<td>$dalet_id</td>
    	<td>$website_titel</td>
    	<td>$website_online</td>
    	<td>$website_subcat</td>
    	<td>$volgorde</td>
    </tr>
    		
DUMP;
        
	}
	
	echo "</table>";
    

?>