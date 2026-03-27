<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    require_once("/mnt/data/include/config.shredder.inc.php");
    require_once("/mnt/data/include/mysqli.inc.php");
    $dbh = new sql;
    $dbh -> connect(); // connect

    $daletid = intval($_GET['id']);
    
    // let's get this message
    
    $query = "
    	select bericht_id,last_update,website_titel,website_categorie,website_subcategorie,website_keywords,website_online,website_offline,
    	       website_zichtbaar,errors,media_foto,media_audio,media_video,website_outlet,rex_rss,mix_status,rex_feedback
    	from dalet_berichten
    	where dalet_id = ?
    ";
    $sth = $dbh->do_placeholder_query($query,array($daletid),__LINE__,__FILE__);    
    $data = $dbh -> fetch_array($sth, MYSQLI_ASSOC);
    if ($data['rex_rss']) $data['rex_rss'] = "Processed";
    $errors = json_decode($data['errors'],true);
    
    $errorsinhoudelijk = implode("|",$errors['inhoud']);    
    $errorstechnisch = implode("|",$errors['technisch']);
    unset($data['errors']);
    $data['Errors inhoudelijk'] = $errorsinhoudelijk;
    $data['Errors technisch'] = $errorstechnisch;
    $data['website_keywords'] = str_replace(";","|",$data['website_keywords']);
    $js = @json_decode($data['rex_feedback'],TRUE);
    $data['rex_feedback'] = json_encode($js,JSON_PRETTY_PRINT);


    echo <<<DUMP
<!DOCTYPE html>
<html ng-app="app">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>MIX - $daletid</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <meta name="description" content="Sandstorm" />
</head>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<body ng-cloak>

<p><a href="/mix/">Home</a></p>
<p><a href="https://nimbus.rtvutrecht.nl/title/$daletid">Bewerk in Nimbus</a></p>
<table class="table-striped" id="Overview"><tbody>
DUMP;
    foreach ($data as $key => $v) {
    	echo "<tr><td valign='top'>$key</td><td valig='top'>";
    	
	if (!$v) $v="";
    	$v = trim($v,"|");
    	
    	if ($key=="media_foto") {
    		$v = preg_replace('/(\d+)/im', '<a href="https://nimbus.rtvutrecht.nl/title/\1" target="_blank">\1</a>', $v);
        }
        if (($key=="media_audio") || ($key=="media_video")) {        
	      $v = str_replace("|","\n",$v);
    	      $v = preg_replace('%^(\d+)/(.*?)/(.*?)/(.*)$%im', 
    	           'Nimbus: <a href="https://nimbus.rtvutrecht.nl/title/\1" target="_blank">\1</a><br>BBW: <a href="https://bbvms.com/ovp/#/library/mediaclip/\2/" target="_BLANK">\2</a><br>Published: \3<br>URL: <a href="\4" target="_BLANK">\4</a>', $v);
	      $v = str_replace("\n","|",$v);




        }
        $v = str_replace("|","<br>",$v);


    	echo " <div style=\"white-space: pre-wrap;\">$v</div>";
    	echo "</td></tr>";
        
    }
    echo "</table><hr>";  
    
    $logs = array();
    $query = "
        select id,processdatetime,filedatetime,titlelastmodifytime,author,status
        from dalet_log
        where dalet_id = ?
        order by processdatetime asc
    ";
    $sth = $dbh->do_placeholder_query($query,array($daletid),__LINE__,__FILE__);
    while (list($id,$processdatetime,$filedatetime,$titlelastmodifytime,$author,$status) = $dbh -> fetch_array($sth)) {
        $logs[] = "$processdatetime Processed by <a href=\"moredetail.php?id={$id}&daletid={$daletid}\">MIX</a>";
        $logs[] = "$filedatetime Export Nimbus||$status";
        $logs[] = "$titlelastmodifytime Opgeslagen in nimbus|$author";
    }

    $query = "
        select datetime
        from syncoverylog
        where filename like '%$daletid.xml'
    ";
    $sth = $dbh->do_query($query,__LINE__,__FILE__);
    while (list($datetime) = $dbh -> fetch_array($sth)) {
        $logs[] = "$datetime Upload naar REX";
    }

    sort($logs);
    
    echo <<<DUMP
<table class="table table-striped table-bordered" id="sortTable">    
DUMP;

    foreach ($logs as $log) {
        if (preg_match('/([\d-]{10})T([\d:]{8}).{7}(.*)/i', $log, $regs)) {
            $info = $regs[3];
            // $info = preg_replace('/(.*)\((\d+)\)$/im', '\1(<a href="moredetail.php?id=\2">\2</a>)', $info);
            $info = explode("|",$info);
            if (!@$info[1]) $info[1]="&nbsp;";
            if (!@$info[2]) $info[2]="&nbsp;";
            
            echo "<tr><td>{$regs[1]} {$regs[2]}</td><td>{$info[0]}</td><td>$info[1]</td><td>$info[2]</td></tr>";
        }
    }
    echo <<<DUMP
    </table>
<script>
$(document).ready(function () {-
  $('#sortTable').DataTable({
    "order": [[ 2, "desc" ]],
    "pageLength": 50
  });
    $('.dataTables_length').addClass('bs-select');
});
</script>
</body>
</html>
DUMP;

?>