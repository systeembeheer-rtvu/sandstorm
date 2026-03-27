<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    require_once("../../scripts/functions/sanitizer.inc.php");
    require_once("../../libs/phpmailer/class.phpmailer.php");
    require_once("../../libs/smarty/Smarty.class.php");
    
    date_default_timezone_set('Europe/Belgrade');
    
    $dbh = new sql();
    $dbh->connect();
    
    $san = new Sanitizer();
    
    $naam = $_GET['naam'];
    $tel = $_GET['tel'];
    $afdeling = $_GET['afdeling'];
    $probleem = $san->SanitizeInput($_GET['probleem']);
    $status = $_GET['status'];
    $oldafgemeld = "" . $_GET['oldafgemeld'];
    $afgemeld = "" . $_GET['afgemeld'];
    $categorie = $_GET['categorie'];
    $categorieTekst = $_GET['categorieTekst'];
    $oid = $_GET['oid'];
    
    $input['inputTime'] = date("Y-m-d H:i");
    
    if($categorie == "0")
    {
        $queryvars = array($categorieTekst);
        
        $query = "select id from `" . $page['settings']['locations']['db_prefix'] . "categorie` where categorie = ?";
        $sth = $dbh->do_placeholder_query($query,$queryvars,__line__,__file__);
        
        if($dbh->total_rows($sth) >0)
        {
            $vars = $dbh->fetch_array($sth);
            $categorie = $vars['id'];
        }
        else
        {
            $query = "
                insert into `" . $page['settings']['locations']['db_prefix'] . "categorie` (categorie, actief)
                values(?, 1)
            ";
            
            $dbh->do_placeholder_query($query,$queryvars,__line__,__file__);
            
            $categorie = $dbh->last_insert_id(__line__,__file__);
        }
    }
    
    if($_GET['oid'] > 0)
    {
        $output['id'] = $_GET['oid'];
        $queryvars= array(
            $naam,
            $tel,
            $afdeling,
            $probleem,
            $status,
            $afgemeld,
            $categorie,
            $oid
        );
        
        $query = "
            UPDATE " . $page['settings']['locations']['db_prefix'] . "incidenten
            SET naam = ?, telefoonnummer = ?, afdeling = ?, probleem = ?, status = ?, afgemeld = ?, categorie = ?
        ";
        
        if($afgemeld == "true")
        {
            $query .= ", datum = NOW() ";
            $query .= ", afgemeld = 1 ";
        }
        else if($afgemeld == "false")
        {
            $query .= ", afgemeld = 0 ";
        }
        
        $query .= "WHERE " . $page['settings']['locations']['db_prefix'] . "incidenten.id = ?";
        
        $dbh->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
        
        actieToevoegen($output['id'], $input['inputTime']);
        beheerderToevoegen($output['id'], $input['inputTime']);
        
        if($oldafgemeld != $afgemeld && $afgemeld == "1")
        {
            $queryvars2 = array($oid, $_COOKIE['behandelaar']);
            $query2 = "
                INSERT INTO " . $page['settings']['locations']['db_prefix'] . "incidentacties (
                    incident_id,
                    actie,
                    behandelaar,
                    datum
                )
                VALUES (?, 'Incident afgemeld', ?, NOW())
            ";
            
            $dbh -> do_placeholder_query($query2,$queryvars2,__LINE__,__FILE__);
        }
        else if($oldafgemeld != $afgemeld && $afgemeld == "0")
        {
            $queryvars2 = array($oid, $_COOKIE['behandelaar']);
            $query2 = "
                INSERT INTO " . $page['settings']['locations']['db_prefix'] . "incidentacties (
                    incident_id,
                    actie,
                    behandelaar,
                    datum
                )
                VALUES (?, 'Incident geopend', ?, NOW())
            ";
            
            $dbh -> do_placeholder_query($query2,$queryvars2,__LINE__,__FILE__);
        }
    }
    else
    {
        $query = "SHOW TABLE STATUS LIKE '" . $page['settings']['locations']['db_prefix'] . "incidenten'";
        $sth = $dbh -> do_query($query,__LINE__,__FILE__);
        $temp = $dbh -> fetch_array($sth);
        
        if($afgemeld == "true" || $afgemeld == "1")
        {
            $afgemeld = 1;
        }
        else
        {
            $afgemeld = 0;
        }
        
        $queryvars= array(
            $naam,
            $tel,
            $afdeling,
            $probleem,
            $status,
            $input['inputTime'],
            $afgemeld,
            $categorie,
            $_COOKIE['behandelaar']
        );
        
        $query = "
            INSERT INTO " . $page['settings']['locations']['db_prefix'] . "incidenten (
                naam,
                telefoonnummer,
                afdeling,
                probleem,
                status,
                datum,
                aangemeld,
                afgemeld,
                categorie,
                invoerder
            )
            VALUES (?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?)
        ";
        $dbh->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
        $oid = $dbh->last_insert_id(__line__,__file__);
        $output['id'] = $oid;
        if($oldafgemeld != $afgemeld && $afgemeld == "1")
        {
            $queryvars2 = array($oid, $_COOKIE['behandelaar']);
            $query2 = "
                INSERT INTO " . $page['settings']['locations']['db_prefix'] . "incidentacties (
                    incident_id,
                    actie,
                    behandelaar,
                    datum
                )
                VALUES (?, 'Incident afgemeld', ?, NOW())
            ";
            
            $dbh -> do_placeholder_query($query2,$queryvars2,__LINE__,__FILE__);
        }
        
        actieToevoegen($oid, $input['inputTime']);
        beheerderToevoegen($oid, $input['inputTime']);
    }
    
    echo json_encode($output);
    
    //functions
    function behandelaarBijwerken($oid)
    {
        global $dbh, $page;
        
        if($_GET['behandelaarChange'] == "true"){
            
            $behandelaars = $_GET['behandelaars'];
            if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
                $behandelaarArray = preg_split('/;/',$behandelaars);
            else
                $behandelaarArray = preg_split('/,/',$behandelaars);
            
            $queryvars = array($oid);
            $query = "Select behandelaar_id from " . $page['settings']['locations']['db_prefix'] . "incidentbehandelaar where incident_id = ?";
            $sth = $dbh->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
            
            $counter = 0;
            
            while($vars = $dbh->fetch_array($sth))
            {
                $temp['behandelaars'][$counter++] = $vars['behandelaar_id'];
            }
            
            if($counter == 0)
            {
                $temp['behandelaars'][$counter++] = "";
            }
            
            $input = "";
            $first = true;
            
            foreach($behandelaarArray as $search)
            {
                $found = false;
                
                foreach($temp['behandelaars'] as $behandelaar)
                {
                    if($search == $behandelaar)
                        $found = true;
                }
                
                if(!$found && $first)
                {
                    $first = false;
                    $input .= $search;
                }
                else if(!$found && !$first){
                    $input .= ", " . $search;
                }
            }
            
            if($input != "")
            {
                $query = "select id, naam from " . $page['settings']['locations']['db_prefix'] . "behandelaar where id in (".$input.") ";
                
                $sth = $dbh->do_query($query,__LINE__,__FILE__);
                
                $first = true;
                
                $input = "";
                while($vars = $dbh->fetch_array($sth))
                {
                    if($first)
                    {
                        $input .= $vars['naam'];
                        $first = false;
                    }
                    else
                    {
                        $input .= ", " . $vars['naam'];
                    }
                    
                    if($_COOKIE['behandelaar'] != $vars['id'])
                        mailToewijzing($vars['naam'], $probleem, $categorie);
                }
                
                if($input != "")
                {
                    $queryvars = array($oid, "Toegewezen aan: " .  $input, $_COOKIE['behandelaar']);
                    $query = "
                        INSERT INTO " . $page['settings']['locations']['db_prefix'] . "incidentacties (
                            incident_id,
                            actie,
                            behandelaar,
                            datum
                        )
                        VALUES (?, ?, ?, NOW())
                    ";
                    
                    $dbh->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                }
            }
        }
    }
    
    function mailToewijzing($behandelaar)
    {
        global $san, $oid, $naam, $tel, $probleem, $categorie, $dbh, $page;
        
        $queryvars = array($categorie);
        $query = "
            select categorie
            from " . $page['settings']['locations']['db_prefix'] . "categorie
            where id = ?
        ";
        
        $sth = $dbh->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
        $vars = $dbh->fetch_array($sth);
        
        $output['oid'] = $oid;
        $output['aanmelder'] = $naam;
        $output['telefoonnummer'] = $tel;
        $output['categorie'] = $vars['categorie'];
        $output['melding'] = $san->SanitizeOutput($probleem);
        
        $queryvars = array($oid);
        $query = "
            select b.naam
            from " . $page['settings']['locations']['db_prefix'] . "behandelaar b, " . $page['settings']['locations']['db_prefix'] . "incidenten i
            where i.id = ?
            and b.id = i.invoerder
        ";
        
        $sth = $dbh->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
        $vars = $dbh->fetch_array($sth);
        
        $output['behandelaar'] = $vars['naam'];
        
        $queryvars = array($_COOKIE['behandelaar']);
        $query = "
            select naam
            from " . $page['settings']['locations']['db_prefix'] . "behandelaar
            where id = ?
        ";
        
        $sth = $dbh->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
        $vars = $dbh->fetch_array($sth);
        
        $output['invoerder'] = $vars['naam'];
        
        $behandelaar_mail = strtolower(str_replace(" ",".",$behandelaar));
        
        $email = $behandelaar_mail . "@rtvutrecht.nl";
        
        $smarty = new Smarty();
        $smarty->template_dir = '../../templates/default';
        $smarty->compile_dir = '../../templates/compile';
        $smarty->assign("output", $output);
        
        $mail = new PHPMailer();
        $mail->IsHTML(true);
        $mail->From = "ict@rtvutrecht.nl";
        $mail->FromName = "RTV Utrecht";
        
        $mail->AddAddress($email);
        
        $mail->Subject = "(Call toegewezen)(" . $output['categorie'] .")...";
        $mail->Body = $smarty->fetch('./mail/toewijzing.tpl');
        
        $mail->Send();
    }
    
    function actieToevoegen($oid, $inputTime)
    {
        global $dbh, $page, $san;
        
        if($_GET['actie'] != "" && $oid != 0)
        {
            $queryvars= array($oid, $san->SanitizeInput($_GET['actie']), $_COOKIE['behandelaar'], $inputTime);
            $query = "
                INSERT INTO " . $page['settings']['locations']['db_prefix'] . "incidentacties (incident_id, actie, behandelaar, datum)VALUES (?, ?, ?, ?)
            ";
            
            $dbh->do_placeholder_query($query, $queryvars,__line__,__file__);
        }
        
        behandelaarBijwerken($oid);
    }
    
    function beheerderToevoegen($oid, $inputTime)
    {
        global $dbh, $page;
        
        $behandelaars = $_GET['behandelaars'];
        
        if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
            $behandelaarArray = preg_split('/;/',$behandelaars);
        else
            $behandelaarArray = preg_split('/,/',$behandelaars);
        
        $queryvars= array($oid);
        $query = "
            DELETE FROM " . $page['settings']['locations']['db_prefix'] . "incidentbehandelaar WHERE incident_id = ?
        ";
        
        $dbh -> do_placeholder_query($query, $queryvars,__line__,__file__);
        
        if(!isset($input['behandelaar']) || $input['behandelaar'] == "")
        {
            $input['behandelaar'][0] = 0;
        }
        
        foreach($behandelaarArray as $behandelaar)
        {
            $queryvars= array($oid, $behandelaar);
            
            $query = "
                INSERT INTO " . $page['settings']['locations']['db_prefix'] . "incidentbehandelaar (incident_id, behandelaar_id)VALUES (?, ?)
            ";
            
            $dbh -> do_placeholder_query($query, $queryvars,__line__,__file__);
        }
    }
?>