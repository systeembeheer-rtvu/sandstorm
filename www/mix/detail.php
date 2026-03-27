<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    require_once("/mnt/data/include/config.shredder.inc.php");
    require_once("/mnt/data/include/mysqli.inc.php");
    $dbh = new sql;
    $dbh -> connect();

    $daletid = intval($_GET['id']);

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
    $js = json_decode($data['rex_feedback'] ?? '', TRUE);
    $data['rex_feedback'] = json_encode($js,JSON_PRETTY_PRINT);

    $titel = htmlspecialchars($data['website_titel'] ?? $daletid);

    echo <<<DUMP
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MIX — $titel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="mix.css?v=<?= filemtime(__DIR__.'/mix.css') ?>">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
</head>
<body class="bg-light">
<div class="container-fluid py-3">

    <div class="mb-3">
        <a href="/mix/" class="btn btn-secondary btn-sm">&larr; Home</a>
        <a href="https://nimbus.rtvutrecht.nl/title/$daletid" target="_blank" class="btn btn-primary btn-sm ms-2">Bewerk in Nimbus</a>
    </div>

    <h5 class="mb-3 text-muted">Nimbus ID: $daletid &mdash; $titel</h5>

    <div class="card mb-4">
        <div class="card-header"><strong>Berichtdetails</strong></div>
        <div class="card-body p-0">
            <table class="table table-striped table-sm mb-0" id="Overview">
            <tbody>
DUMP;

    foreach ($data as $key => $v) {
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

        echo "<tr><td valign='top' class='text-muted fw-bold' style='white-space:nowrap;width:1%;'>$key</td><td valign='top'>";

        if ($key == 'rex_feedback') {
            echo "<button class=\"btn btn-sm btn-outline-secondary\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#rex-feedback-collapse\">Toon / verberg</button>";
            echo "<div class=\"collapse\" id=\"rex-feedback-collapse\"><div style=\"white-space: pre-wrap;\">$v</div></div>";
        } else {
            echo "<div style=\"white-space: pre-wrap;\">$v</div>";
        }
        echo "</td></tr>";
    }

    echo <<<DUMP
            </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><strong>Verwerkingslog</strong></div>
        <div class="card-body p-0">
            <table class="table table-striped table-bordered table-sm mb-0" id="sortTable">
            <thead class="table-dark">
                <tr><th>Tijdstip</th><th>Actie</th><th>Door</th><th>Media</th></tr>
            </thead>
            <tbody>
DUMP;

    function ExpandMedia($content) {
        return implode(", ", array_map(fn($c) => ($split = explode("/", $c)) && $split[2] === "TRUE" ? "<b>{$split[0]}</b>" : $split[0], $content));
    }

    $logs = array();
    $query = "
        select id,processdatetime,filedatetime,titlelastmodifytime,author,status,log
        from dalet_log
        where dalet_id = ?
        order by processdatetime asc
    ";
    $sth = $dbh->do_placeholder_query($query,array($daletid),__LINE__,__FILE__);
    while (list($id,$processdatetime,$filedatetime,$titlelastmodifytime,$author,$status,$log) = $dbh -> fetch_array($sth)) {
        $logobj = json_decode($log,JSON_FORCE_OBJECT);
        $logf = array_filter(explode("|",$logobj['media_foto']));
        $loga = array_filter(explode("|",$logobj['media_audio']));
        $logv = array_filter(explode("|",$logobj['media_video']));
        $statusm = "F: ".implode(", ",$logf)."+";
        $statusm.= "A: ".ExpandMedia($loga)."+";
        $statusm.= "V: ".ExpandMedia($logv);
        if ($logobj['BreakingNews'] ?? false==true) $statusm.= "+P: nieuws";
        if ($logobj['BreakingSport'] ?? false==true) $statusm.= "+P: sport";

        $logs[] = "$processdatetime Processed by <a href=\"moredetail.php?id={$id}&daletid={$daletid}\">MIX</a>||$statusm";
        $logs[] = "$filedatetime Export Nimbus||$status";
        $logs[] = "$titlelastmodifytime Opgeslagen in nimbus|$author";
    }

    $query = "
        select datetime
        from syncoverylog
        where filename = '$daletid'
    ";
    $sth = $dbh->do_query($query,__LINE__,__FILE__);
    while (list($datetime) = $dbh -> fetch_array($sth)) {
        $logs[] = "$datetime Upload naar REX";
    }

    sort($logs);

    foreach ($logs as $log) {
        if (preg_match('/([\d-]{10})T([\d:]{8}).{7}(.*)/i', $log, $regs)) {
            $info = $regs[3];
            $info = explode("|",$info);
            if (empty($info[1])) $info[1]="&nbsp;";
            if (empty($info[2])) $info[2]="&nbsp;";
            $info[2]=str_replace('+','<br>',$info[2]);
            echo "<tr><td>{$regs[1]} {$regs[2]}</td><td>{$info[0]}</td><td>$info[1]</td><td>$info[2]</td></tr>";
        }
    }

    echo <<<DUMP
            </tbody>
            </table>
        </div>
    </div>

</div>
<script>
$(document).ready(function () {
  $('#sortTable').DataTable({
    "order": [[ 0, "desc" ]],
    "pageLength": 50,
    "paging": false,
    "searching": false,
    "info": false
  });
});
</script>
</body>
</html>
DUMP;
?>
