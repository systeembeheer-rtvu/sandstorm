<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    require_once("/mnt/data/include/config.shredder.inc.php");
    require_once("/mnt/data/include/mysqli.inc.php");
    $dbh = new sql;
    $dbh -> connect(); // connect

    $logs = array();
    $today = date("c");
    $query = "
        select dalet_id,bericht_id,last_update,website_online,website_offline,website_titel,website_categorie,mix_status,rex_rss,errors,
               website_dagen,nieuwsbrief_dagen,website_prioriteit,website_subcategorie,website_keywords
        from dalet_berichten
        where website_titel != ''
           and website_categorie like '%Omroep%'           
           and website_offline >= '$today'
        
    ";
    
    // and website_subcategorie like '%Uitgelicht%'
    $sth = $dbh->do_query($query,__LINE__,__FILE__);
    echo <<<DUMP
<!DOCTYPE html>
<html lang="en">
<head>
<title>Mini Exchange Omroep</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>
<h1 align="center">Mini Exchange Omroep</h1>
<div class="container" style="width:100%";>
<table class="table table-striped table-bordered" id="sortTable">
<thead>
	<th align="left">Nimbus ID</th>
	<th align="left">Online</th>
	<th align="left">Offline</th>
	<th align="left">Subcategorie</th>
	<th align="left">Keywords</th>
	<th align="left">Status</th>
	<th align="left">Website dagen</th>
	<th align="left">Nieuwsbrief dagen</th>
	<th align="left">Prio</th>
	<th align="left">Titel</th>
</thead>

DUMP;
    while (list($dalet_id,
           $bericht_id,
           $last_update,
           $online,
           $offline,
           $website_titel,
           $website_categorie,
           $mix_status,
           $rex_rss,
           $errors,
           $website_dagen,
           $nieuwsbrief_dagen,
           $website_prioriteit,
           $website_subcategorie,
           $website_keywords) = $dbh -> fetch_array($sth)) {
           $website_categorie = trim($website_categorie,"|");

        $online = preg_replace('/([\d-]{10})T([\d:]{5}).*/im', '\1<br>\2', $online);
        $offline = preg_replace('/([\d-]{10})T([\d:]{5}).*/im', '\1<br>\2', $offline);
        if (strpos($website_subcategorie,'Uitgelicht')) {
        	// $website_dagen = dagen($website_dagen,0);
                // $nieuwsbrief_dagen = dagen($nieuwsbrief_dagen,1);
                $nieuwsbrief_dagen = "";
	        $website_dagen = "";
	        $website_subcategorie = trim($website_subcategorie,"|");
        } else {
                $nieuwsbrief_dagen = "";
	        $website_dagen = "";
       }
        $website_keywords = str_replace(";","<br>",$website_keywords);
        if (strpos($website_subcategorie,'VP3')) {
          $vp3 = "&nbsp;(VP3)";
       } else {
          $vp3 = "";
       }  
       
                  $website_subcategorie = trim($website_subcategorie,"|");

        

                
        echo <<<DUMP
             <tr>
                 <td><a href="detail.php?id=$dalet_id">$dalet_id</a> (<a href="https://www.rtvutrecht.nl/nieuws/$bericht_id" target="_BLANK">W</a>) (<a href="https://nimbus.rtvutrecht.nl/title/$bericht_id" target="_BLANK">N</a>)</td>
                 <td>$online</td>
                 <td>$offline</td>
                 <td>$website_subcategorie</td>
                 <td>$website_keywords</td>
                 <td>{$mix_status}</td>
                 <td>{$website_dagen}</td>
                 <td>{$nieuwsbrief_dagen}</td>
                 <td>{$website_prioriteit}</td>
                 <td>$website_titel</td>                 
             </tr>
        
DUMP;
        
    }
    echo <<<DUMP
</table></div>
<script>
$(document).ready(function () {-
  $('#sortTable').DataTable({
    "order": [[ 8, "asc" ]],
    "pageLength": 25
  });
    $('.dataTables_length').addClass('bs-select');
});
</script>
</body>
</html>
DUMP;

?>