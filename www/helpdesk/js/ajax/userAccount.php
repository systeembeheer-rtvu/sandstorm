<?php
    require_once("../../config.inc.php");
    require_once("../../" . $page['root'] . "/libs/mysql.inc.php");
    
    $dbh = new sql();
    $dbh->connect();
    
    $voornaam = $_GET['voornaam'];
    $tussenvoegsel = $_GET['tussenvoegsel'];
    $achternaam = $_GET['achternaam'];
    $bdatum = $_GET['begindatum'];
    $afdeling = $_GET['afdeling'];
    
    $bdatumArray = explode("-", $bdatum);
    $bdatum = $bdatumArray[2] . "-" . $bdatumArray[1] . "-" . $bdatumArray[0];
    
    $queryvars = array($voornaam, $tussenvoegsel, $achternaam, strtolower(substr($voornaam,0,3)) . strtolower(substr($achternaam,0,3)), $bdatum . " 00:00:00", $afdeling);
    
    $query = "
        INSERT INTO " . $page['settings']['locations']['db_prefix'] . "ua_users (
            voornaam,
            tussenvoegsel,
            achternaam,
            inlognaam,
            begindatum,
            afdeling
        )
        VALUES
            (?,?,?,?,?,?)
    ";
    
    $dbh->do_placeholder_query($query,$queryvars,__line__,__file__);
?>