<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    require_once("/mnt/data/include/config.shredder.inc.php");
    require_once("/mnt/data/include/mysqli.inc.php");
    $dbh = new sql;
    $dbh -> connect(); // connect
    $zender = "RTVU";
    $datum1 = "20230313";
    $datum2 = "20230310";
    $hour1 = "13:00:00";
    $hour2 = "13:00:00";
    
    $epgfields = array(
        "BlockReplayTV",
        "Episode_number",
        "LastAirDate",
        "PrCategory",
        "ProgAlternativeTitle",
        "ProgDate",
        "ProgDuration",
        "ProgEndTime",
        "ProgHHID",
        "ProgId",
        "ProgItemID",
        "ProgMediaDuration",
        "ProgMediaFile",
        "ProgMediaId",
        "ProgStartTime",
        "ProgTitle",
        "ProgType",
        "Published",
        "SeriesTitle",
        "ShowInGuide",
        "ShowInMissed",
        "Overview"
    );
    
    echo "<table>";
    
	for ($hour=0;$hour<24;$hour++) { // ga elk uur af
		$hours = str_pad($hour,2,"0");
		for ($minute=0;$minute<60;$minute+=5) { // ga elke 5 minuten af
		    $minutes = str_pad($minute,2,"0");
		    $starttime = "$hours:$minutes:00";
		    $query = "
		    	select * from epg
		    	   where datum = ?
		    	   and ProgStartTime = ?		    	   
		    ";
		    $sth1 = $dbh->do_placeholder_query($query,array($datum1,$startime),__LINE__,__FILE__);
		    $sth2 = $dbh->do_placeholder_query($query,array($datum2,$startime),__LINE__,__FILE__);
		    $rows1 = $dbh->total_rows($sth1);
		    $rows2 = $dbh->total_rows($sth2);
		    if ($rows1+$rows2) {
		        
		    } 
		    
		    
	    	}	

        }

?>