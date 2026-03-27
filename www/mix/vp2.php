<?php
    // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    require_once("/mnt/data/include/config.shredder.inc.php");
    require_once("/mnt/data/include/mysqli.inc.php");
    $dbh = new sql;
    $dbh -> connect(); // connect
    $now = date("c");

    function buildquery($category,$subcategory) {
        global $now;
        $extra = "";
        if ($category) {
            $cat = "and website_categorie like '%|$category|%'";
        } else {
            $cat = "";
        }

        if ($subcategory) {
            $subcat = "and website_subcategorie like '%|$subcategory|%' ";
            if (($subcategory=="NOS") || ($subcategory=="Voorpagina"))  {
                $subcat.="and (website_categorie like '%|Nieuws|%' or website_categorie like '%|Sport|%') ";
            }
        } else {
            $subcat = "";
        }

        if ($category=="Omroep") {
            $prioriteit = "website_prioriteit ASC";
        } else {
            $prioriteit = "website_ordertime DESC";
        }

        /*
        if ($subcategory == "VP2") {
            //$prioriteit = "1";
        
        }
        */

        $query = "
            select dalet_id,website_online,website_offline,website_titel
              
            from dalet_berichten
            where website_online < '$now'
            and website_offline >  '$now'
            $cat
            $subcat
            and website_zichtbaar = 'TRUE'
            order by $prioriteit,website_online desc
        ";
        // echo $query."\n";
        return $query;
    }
    
    
    $dagencount = array();
    $dagenar = array("Maandag","Dinsdag","Woensdag","Donderdag","Vrijdag","Zaterdag","Zondag");
    foreach ($dagenar as $dag) {
    	$dagencount[$dag] = 0;
    } 
    
    function dagen($dagen,$countit) {
      global $dagencount,$dagenar;
      
      $days = "";
      foreach ($dagenar as $dag) {
	      if (strpos($dagen,$dag)) {
	      		$days.="$dag<br>";
	      		if ($countit) {
	      		  $dagencount[$dag]++;
	      	        }
	      } else {
	        	$days.="<br>";
	      }     	   
      }
      return $days;
      
    }
    $logs = array();
    $today = date("c");
    $query = buildquery("","VP2");    
    // echo $query;
    // and website_subcategorie like '%Uitgelicht%'
    $sth = $dbh->do_query($query,__LINE__,__FILE__);
    echo <<<DUMP
<!DOCTYPE html>
<html lang="en">
<head>
<title>Mini Exchange VP2</title>
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
<h1 align="center">Mini Exchange VP2</h1>
<div class="container" style="width:100%";>
<table class="table table-striped table-bordered">
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
           $online,
           $offline,
           $website_titel,
) = $dbh -> fetch_array($sth)) {
           $website_categorie = trim($website_categorie,"|");

        $online = preg_replace('/([\d-]{10})T([\d:]{5}).*/im', '\1<br>\2', $online);
        $offline = preg_replace('/([\d-]{10})T([\d:]{5}).*/im', '\1<br>\2', $offline);
        if (strpos($website_subcategorie,'Uitgelicht')) {
        	$website_dagen = dagen($website_dagen,0);
                $nieuwsbrief_dagen = dagen($nieuwsbrief_dagen,1);
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
echo <<<DUMP
</body>
</html>
DUMP;

?>