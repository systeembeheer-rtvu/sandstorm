<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    
    $dbh = new sql();
    $dbh->connect();

    $part = $_GET['part'];
    $action = $_GET['action'];

    if($part == "behandelaar" && $action == "Aanmaken")
    {
        $naam = $_GET['naam'];
        
        $queryvars = array($naam);
        $query = "
            insert into `" . $page['settings']['locations']['db_prefix'] . "behandelaar` (naam) values (?)
        ";
        
        $dbh->do_placeholder_query($query, $queryvars, __line__,__file__);
    }
    else if($part == "behandelaar" && $action == "(de)activeren")
    {
        $id = $_GET['id'];
        
        $queryvars = array($id);
        $query = "
            update `" . $page['settings']['locations']['db_prefix'] . "behandelaar` set actief = (actief + 1) % 2 where id = ?
        ";
        
        $dbh->do_placeholder_query($query, $queryvars, __line__,__file__);
    }
    else if($part == "status" && $action == "Aanmaken")
    {
        $naam = $_GET['naam'];
        
        $queryvars = array($naam);
        $query = "
            insert into `" . $page['settings']['locations']['db_prefix'] . "status` (status) values (?)
        ";
        
        $dbh->do_placeholder_query($query, $queryvars, __line__,__file__);
    }
    else if($part == "status" && $action == "(de)activeren")
    {
        $status = $_GET['status'];
        
        $queryvars = array($status);
        $query = "
            update `" . $page['settings']['locations']['db_prefix'] . "status` set actief = (actief + 1) % 2 where id = ?
        ";
        
        $dbh->do_placeholder_query($query, $queryvars, __line__,__file__);
    }
    else if($part == "categorie" && $action == "Aanmaken")
    {
        $naam = $_GET['catName'];
        
        $queryvars = array($naam);
        $query = "
            insert into `" . $page['settings']['locations']['db_prefix'] . "categorie` (categorie) values (?)
        ";
        
        $dbh->do_placeholder_query($query, $queryvars, __line__,__file__);
    }
    else if($part == "categorie" && $action == "(de)activeren")
    {
        $categorie = $_GET['categorie'];
        
        $queryvars = array($categorie);
        $query = "
            update `" . $page['settings']['locations']['db_prefix'] . "categorie` set actief = (actief + 1) % 2 where id = ?
        ";
        
        $dbh->do_placeholder_query($query, $queryvars, __line__,__file__);
    }
    else if($part == "userAccount" && $action == "Aanpassen")
    {
        $loginName = $_GET['loginName'];
        $afdelingen = $_GET['afdelingen'];
        
        $queryvars = array($loginName);
        $query = "
            Select login from telefoonlijst where naam = ?
        ";
        
        $sth = $dbh->do_placeholder_query($query, $queryvars, __line__,__file__);
        
        $vars = $dbh->fetch_array($sth);
        
        $loginName = $vars['login'];
        
        $queryvars = array($loginName);
        $query = "
            replace into " . $page['settings']['locations']['db_prefix'] . "uac_user (loginName) values (?)
        ";
        $dbh->do_placeholder_query($query, $queryvars,__line__,__file__);
        
        $query = "
            delete from `" . $page['settings']['locations']['db_prefix'] . "uac_user-afdelingen` where uac_user_loginName = ?;
        ";
        $dbh->do_placeholder_query($query, $queryvars,__line__,__file__);
        
        $afdelingArray = preg_split('/,/',$afdelingen);
        
        foreach($afdelingArray as $afdeling)
        {
            $queryvars = array($loginName, $afdeling);
            $query = "
                insert into `" . $page['settings']['locations']['db_prefix'] . "uac_user-afdelingen` (uac_user_loginname, afdelingen_id)
                values (?, ?)
            ";
            
            $dbh->do_placeholder_query($query, $queryvars,__line__,__file__);
        }
        
        $queryvars = array($loginName);
        $query ="
            insert into `" . $page['settings']['locations']['db_prefix'] . "uac_active` (page_id, user_id, active)
            values (
                (
                    select id from `" . $page['settings']['locations']['db_prefix'] . "uac_page`
                    where page_id = 'user'
                ),
                ?,0
            )
        ";
        $dbh->do_placeholder_query($query,$queryvars,__line__,__file__); 
    }
?>