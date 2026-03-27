<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    
    $dbh = new sql();
    
    $dbh->connect();
    
    $typenaam = $_GET['typenaam'];
    $naam = $_GET['naam'];
    $type = $_GET['type'];
    
    $queryvars = array($naam, $type);
    $query = "
        INSERT INTO " . $page['settings']['locations']['db_prefix'] . "hardware_fields (label, type)
        VALUES (?,?)
    ";

    $dbh->do_placeholder_query($query,$queryvars,__line__,__file__);
    
    $queryvars = array($typenaam, $type, $naam);
    $query = "
        insert into `" . $page['settings']['locations']['db_prefix'] . "hardware_type-fields` (type_id, field_id)
        values(
            (
                select id
                from `" . $page['settings']['locations']['db_prefix'] . "hardware_types`
                where type = ?
            ),
            (
                select id
                from `" . $page['settings']['locations']['db_prefix'] . "hardware_fields`
                where type = ?
                and name = ?
            )
        )
    ";
    
    $dbh->do_placeholder_query($query,$queryvars,__line__,__file__);
?>