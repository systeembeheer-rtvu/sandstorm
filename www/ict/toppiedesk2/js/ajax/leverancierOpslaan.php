<?
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    require_once("../../scripts/functions/sanitizer.inc.php");
    
    date_default_timezone_set('Europe/Belgrade');
    
    $dbh = new sql();
    $dbh->connect();
    
    $san = new Sanitizer();

    $id = $san->SanitizeInput($_GET['id']);
    $leverancier = $san->SanitizeInput($_GET['leverancier']);
    $klantnummer = $san->SanitizeInput($_GET['klantnummer']);
    $contactpersoon = $san->SanitizeInput($_GET['contactpersoon']);
    $telefoonnummer = $san->SanitizeInput($_GET['telefoonnummer']);
    
    if($id > 0){
        $queryvars = array($leverancier, $klantnummer, $contactpersoon, $telefoonnummer, $id);
        $query = "
            UPDATE " . $page['settings']['locations']['db_prefix'] . "leverancier
            SET leverancier = ?, klantnummer = ?, contactpersoon = ?, telefoonnummer = ?
            WHERE id = ?
        ";
        
        $dbh->do_placeholder_query($query,$queryvars,__line__,__file__);
    }
    else{
        /*$queryvars = array($leverancier, $klantnummer, $contactpersoon, $telefoonnummer);
        $query = "
            INSERT INTO " . $page['settings']['locations']['db_prefix'] . "leverancier (leverancier, klantnummer, contactpersoon, telefoonnummer)
            VALUES(?, ?, ?, ?)
        ";
        
        $dbh->do_placeholder_query($query,$queryvars,__line__,__file__);*/
    }
?>