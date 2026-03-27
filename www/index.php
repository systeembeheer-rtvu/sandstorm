<?php

include '/mnt/data/include/PHPAzureADoAuth/auth.php';
$Auth = new modAuth();
include '/mnt/data/include/PHPAzureADoAuth/graph.php';
$Graph = new modGraph();

/*
if (!$Auth->checkUserRole('Task.Admin')) {	
	echo "Computer says no!";
	exit;
}
*/


echo <<<DUMP
<!DOCTYPE html>
<html ng-app="app">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Sandstorm</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <meta name="description" content="Sandstorm" />
</head>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<body ng-cloak>
<div ng-controller="noController">
    <div class="row">&nbsp;</div>
    <div class="row">
        <div class="col-md-4">
            <h2>Redactie</h2>
            <a class="btn btn-block btn-primary" href="mix\">Mini Exchange</a>
        </div>
DUMP;

if ($Auth->checkUserRole('Task.Admin')) {

echo <<<DUMP
        <div class="col-md-4">
            <h2>ICT</h2>
            <a class="btn btn-block btn-primary" href="contract\">Contracten invullen</a>
            <a class="btn btn-block btn-primary" href="ftp/create_ftp_account.php">FTP Account maken</a>
            <a class="btn btn-block btn-primary" href="parkuser\">Parkuser</a>
            <a class="btn btn-block btn-primary" href="https://rocky.park.rtvutrecht.nl">Rocky</a>
            <a class="btn btn-block btn-primary" href="rooster/dashboard.php">Roosterscherm</a>
        </div>
DUMP;
}


echo <<<DUMP
        <div class="col-md-4">
            <h2>EPG</h2>
            <a class="btn btn-block btn-primary" href="epg/epgarchief.php">EPG Archief</a>
            <a class="btn btn-block btn-primary" href="epg/epgadditorplus.php">EPG Additor Plus</a>
        </div>

    </div>
DUMP;

echo <<<DUMP
</div>
</body>
</html>
DUMP;

?>