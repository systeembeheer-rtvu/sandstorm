<?php
    $page['classes']['load'] = new Branka();

    class Branka
    {
        function GetFileName()
        {
            global $tracer;
			$tracer .= "- Branka/GetFileName()<br />";
            
            return "branka";
        }
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "id" => array("id","get","int"),
                    "oid" => array("oid", "post", ""),
                    "searchoid" => array("searchoid","get","int"),
                    "tel" => array("tel","post", ""),
                    "naam" => array("naam", "post", ""),
                    "afdeling" => array("afdeling", "post", ""),
                    "categorie" => array("categorie", "post", "int"),
                    "categorieTekst" => array("probleemtekst", "post", ""),
                    "probleem" => array("probleem", "post", ""),
                    "actie" => array("actie", "post", ""),
                    "oldafgemeld" => array("oldafgemeld", "post", ""),
                    "status" => array("status", "post", ""),
                    "afgemeld" => array("afgemeld", "post", ""),
                    "behandelaar" => array("behandelaar", "post", ""),
                    "ai_id" => array("ai_id", "post", "")
                )
            );
        }
        
        function NavigatieBalk(){}
        
        function CheckPage()
        {
            return 0;
        }
        
        function DoRun()
        {
            global $tracer, $input, $page, $output;
			$tracer .= "- Branka/DoRun()<br />";
	    
            Loadbehandelaars(true);
            LoadCategorieen(false, false);
            LoadStatus(false);
            LoadGebruikers();
	    
			$output['page']['id']= "branka";
            
            $input['inputTime'] = date("Y-m-d H:i");
            $output['incident']['catid'] = "36";
	    
            if(isset($_POST['opslaan']) || isset($_POST['o&a']))
                $this->Opslaan();
            else if(isset($_GET['searchoid']))
                $this->IncidentWeergeven();
            else if(isset($_GET['status']) && $_GET['saveid'] > 0)
            {
                $output['searchoid'] = $_GET['saveid'];
                $output['refresh']['status'] = "show";
            }
			else
			{
			foreach($output['behandelaars'] as &$behandelaar)
                {
                    if($behandelaar['id'] == 10)
                        $behandelaar['selected'] = "true";
                }
			}
            
            $this->OverigeIncidenten();
	    
			$output['counter']['categorie'] = count($output['categorie']);
            $counter = 0;
	    
            foreach($output['categorie'] as &$categorie)
            {
                if($counter++ == ceil($output['counter']['categorie']/2))
                {
                    $categorie['split'] = true;
                }
            }
        }
        
        function GetSidebarType()
        {
            global $tracer;
			$tracer .= "- Branka/GetSidebarType()<br />";
            
            return "incident";
        }
        
        //overige functions
        function Opslaan()
        {
            global $input, $output;
            
            $this->categorieToewijzen();
            $this->incidentOpslaan();
            $this->actieToevoegen();
            $this->actieBijwerken();
            $this->behandelaarBijwerken();
            
            $output['redirect'] = $page['settings']['locations']['file'] ."?id=branka&status=saved&saveid=" . $output['oid']; 
        }
        
        function categorieToewijzen()
        {
            global $input, $page;
            
            if($input['categorie'] == 0)
            {
                $queryvars = array($input['categorieTekst']);
                $query = "select id from `" . $page['settings']['locations']['db_prefix'] . "categorie` where categorie = ?";
                $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__line__,__file__);
                
                if($page['classes']['sql']->total_rows($sth) >0)
                {
                    $vars = $page['classes']['sql']->fetch_array($sth);
                    $input['categorie'] = $vars['id'] + 0;
                }
                else
                {
                    $query = "
                        insert into `" . $page['settings']['locations']['db_prefix'] . "categorie` (categorie, actief)
                        values(?, 1)
                    ";
                    
                    $page['classes']['sql']->do_placeholder_query($query,$queryvars,__line__,__file__);
                    
                    $input['categorie'] = $page['classes']['sql']->last_insert_id(__line__,__file__);
                }
            }
        }
        
        function incidentOpslaan()
        {
            global $input, $page, $output;
	    
            if($input['afgemeld'] == "on")
                $input['afgemeld'] = 1;
            else
                $input['afgemeld'] = 0;
            
            if($input['oid'] > 0)
            {
                $queryvars= array(
                    $input['naam'],
                    $input['tel'],
                    $input['afdeling'],
                    $input['probleem'],
                    $input['status'],
                    $input['afgemeld'],
                    $input['categorie'],
                    $input['oid']
                );
                
                $query = "
                    UPDATE " . $page['settings']['locations']['db_prefix'] . "incidenten
                    SET naam = ?, telefoonnummer = ?, afdeling = ?, probleem = ?, status = ?, afgemeld = ?, categorie = ?
                ";
                
                if($input['afgemeld'] == 1)
                {
                    $query .= ", datum = NOW() ";
                    $query .= ", afgemeld = 1 ";
                }
                else if($input['afgemeld'] == 0)
                    $query .= ", afgemeld = 0 ";
                
                $query .= "where id = ?";
				
                $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
                
                $output['oid'] =  $input['oid'];
		
				//$this->IncidentAfmelden();
            }
            else if($input['oid'] == 0)
            {
                $queryvars= array(
                    $input['naam'],
                    $input['tel'],
                    $input['afdeling'],
                    $input['probleem'],
                    $input['status'],
                    $input['inputTime'],
                    $input['afgemeld'],
                    $input['categorie'],
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
                
                $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
                $output['oid'] = $page['classes']['sql']->last_insert_id(__line__,__file__);
            }
        }
        
        function actieToevoegen()
        {
            global $input, $page, $output;
            
            if($input['actie'] != "" && $output['oid'] != 0)
            {
                $queryvars= array(
                    $output['oid'],
                    $input['actie'],
                    $_COOKIE['behandelaar'],
                    $input['inputTime']
                );
		
                $query = "
                    INSERT INTO " . $page['settings']['locations']['db_prefix'] . "incidentacties (incident_id, actie, behandelaar, datum)VALUES (?, ?, ?, ?)
                ";
                
                $page['classes']['sql']->do_placeholder_query($query, $queryvars,__line__,__file__);
            }
        }
        
        function actieBijwerken()
        {
            global $input, $page;
            
            if($input['ai_id'] != "")
            {
                foreach($input['ai_id'] as $ai_id)
                {
                    $value = $page['classes']['sanitizer']->SanitizeInput($_POST['ai_text' . $ai_id]);
                    
                    $queryvars = array($value, $ai_id);
                    $query = "UPDATE " . $page['settings']['locations']['db_prefix'] . "incidentacties SET actie = ? where id = ?";
                    
                    $page['classes']['sql']->do_placeholder_query($query, $queryvars,__line__,__file__);
                }
            }
        }
        
        function behandelaarBijwerken()
        {
            global $input, $page, $output;
            
            $queryvars = array($output['oid']);
            $query = "
                select
                    behandelaar_id
                from
                    " . $page['settings']['locations']['db_prefix'] . "incidentbehandelaar ib
                where
                    incident_id = ?
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
            
            $counter = 0;
            
            $temp['behandelaars'] = array();
            
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                $temp['behandelaars'][$counter++] = $vars['behandelaar_id'];
            }
            
            if(!isset($temp['behandelaars']))
                $temp['behandelaars'][$counter++] = 0;
            
            $first = true;
            $result = "";
            
            if($input['behandelaar'] == "")
                $input['behandelaar'][0] = "0";
            
            foreach($input['behandelaar'] as $new)
            {
                $found = false;
                
                foreach($temp['behandelaars'] as $current)
                {
                    if($current == $new)
                        $found = true;
                }
                
                if(!$found && $first)
                {
                    $first = false;
                    $result = $new;
                }
                else if (!$found && !$first)
                    $result .= ", " . $new;
            }
            
            if($result != "")
            {
                $query = "select id, naam from " . $page['settings']['locations']['db_prefix'] . "behandelaar where id in (".$result.") ";
                
                $sth = $page['classes']['sql']->do_query($query,__LINE__,__FILE__);
                
                $first = true;
                
                $temp['input'] = "";
                while($vars = $page['classes']['sql']->fetch_array($sth))
                {
                    if($first)
                    {
                        $temp['input'] .= $vars['naam'];
                        $first = false;
                    }
                    else
                    {
                        $temp['input'] .= ", " . $vars['naam'];
                    }
                    
                    if($_COOKIE['behandelaar'] != $vars['id'])
                        $this->mailToewijzing($vars['naam']);
                }
                
                if($temp['input'] != "")
                {
                    $queryvars = array($output['oid'], "Toegewezen aan: " .  $temp['input'], $_COOKIE['behandelaar']);
                    $query = "
                        INSERT INTO " . $page['settings']['locations']['db_prefix'] . "incidentacties (
                            incident_id,
                            actie,
                            behandelaar,
                            datum
                        )
                        VALUES (?, ?, ?, NOW())
                    ";
                    
                    $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                }
            }
            
            $queryvars= array($output['oid']);
            $query = "
                DELETE FROM " . $page['settings']['locations']['db_prefix'] . "incidentbehandelaar WHERE incident_id = ?
            ";
            $page['classes']['sql'] -> do_placeholder_query($query, $queryvars,__line__,__file__);
            
            foreach($input['behandelaar'] as $behandelaar)
            {
                $queryvars= array($output['oid'], $behandelaar);
                
                $query = "
                    INSERT INTO " . $page['settings']['locations']['db_prefix'] . "incidentbehandelaar (incident_id, behandelaar_id)VALUES (?, ?)
                ";
                
                $page['classes']['sql'] -> do_placeholder_query($query, $queryvars,__line__,__file__);
            }
        }
        
        function mailToewijzing($behandelaar)
        {
            /*global $input, $page;
            
            $queryvars = array($input['categorie']);
            $query = "
                select categorie
                from " . $page['settings']['locations']['db_prefix'] . "categorie
                where id = ?
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
            $vars = $page['classes']['sql']->fetch_array($sth);
            
            $output['oid'] = $input['oid'];
            $output['aanmelder'] = $input['naam'];
            $output['telefoonnummer'] = $input['tel'];
            $output['categorie'] = $vars['categorie'];
            $output['melding'] = $input['probleem'];
            
            $queryvars = array($input['oid']);
            $query = "
                select b.naam
                from " . $page['settings']['locations']['db_prefix'] . "behandelaar b, " . $page['settings']['locations']['db_prefix'] . "incidenten i
                where i.id = ?
                and b.id = i.invoerder
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
            $vars = $page['classes']['sql']->fetch_array($sth);
            
            $output['behandelaar'] = $vars['naam'];
            
            $queryvars = array($_COOKIE['behandelaar']);
            $query = "
                select naam
                from " . $page['settings']['locations']['db_prefix'] . "behandelaar
                where id = ?
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
            $vars = $page['classes']['sql']->fetch_array($sth);
            
            $output['invoerder'] = $vars['naam'];
            
            $behandelaar_mail = strtolower(str_replace(" ",".",$behandelaar));
            
            $email = $behandelaar_mail . "@rtvutrecht.nl";
            
            $smarty = new Smarty();
            $smarty->template_dir = 'templates/default';
            $smarty->compile_dir = 'templates/compile';
            $smarty->assign("output", $output);
            
            $page['classes']['phpmailer'] = new PHPMailer();
            $page['classes']['phpmailer']->IsHTML(true);
            $page['classes']['phpmailer']->From = "ict@rtvutrecht.nl";
            $page['classes']['phpmailer']->FromName = "RTV Utrecht";
            
            $page['classes']['phpmailer']->AddAddress($email);
            
            $page['classes']['phpmailer']->Subject = "(Call toegewezen)(" . $output['categorie'] .")...";
            $page['classes']['phpmailer']->Body = $smarty->fetch('./mail/toewijzing.tpl');
            
            $page['classes']['phpmailer']->Send();*/
        }
        
        function IncidentWeergeven()
        {
            global $input, $page, $output;
            
            $output['searchoid'] = $input['searchoid'];
            
            $page['vars']['id'] = $input['searchoid'];
            
            $queryvars= array($page['vars']['id']);
            
            $query = "
                SELECT
                    i.id,
                    i.naam,
                    i.telefoonnummer as oudTel,
                    i.afdeling as oudafdeling,
                    i.probleem,
                    i.status,
                    i.invoerder,
                    UNIX_TIMESTAMP(i.datum) as datum,
                    i.afgemeld,
                    ib.behandelaar_id,
                    s.afdeling4 as afdeling,
                    t.telefoonnummer,
                    s.inlognaam,
                    c.id as catid,
                    c.categorie,
		    c.actief
                FROM
                    " . $page['settings']['locations']['db_prefix'] . "incidenten i
                LEFT JOIN
                    " . $page['settings']['locations']['db_prefix'] . "incidentbehandelaar ib
                ON
                    i.id=ib.incident_id
                LEFT JOIN
                    " . $page['settings']['locations']['db_prefix'] . "categorie c
                ON
                    i.categorie = c.id
                LEFT JOIN
                    telefoon_ooit t_o
                ON
                    i.naam = t_o.naam
                LEFT JOIN
                    telefoonlijst t
                ON
                    t_o.naam = t.naam
                LEFT JOIN
                    smoelenboek s
                ON
                    t_o.naam = s.naam
                WHERE i.id = ?
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
            
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                $output['incident']['id']           	= $vars['id'];
                $output['incident']['naam']         	= $vars['naam'];
                $output['incident']['oudtel']       	= $vars['oudTel'];
                $output['incident']['oudafdeling']  	= $vars['oudafdeling'];
                $output['incident']['probleem']     	= $vars['probleem'];
                $output['incident']['status']       	= $vars['status'];
                $output['incident']['afgemeld']     	= $vars['afgemeld'];
                $output['incident']['datum']        	= date($page['settings']['datetime'], $vars['datum']);
                $output['incident']['categorie']    	= $vars['categorie'];
                $output['incident']['catid']        	= $vars['catid'];
				$output['incident']['catactief']		= $vars['actief'];
                
                if(date("Y", $vars['datum']) < "2000" || $output['incident']['afgemeld'] != 1)
                {
                    $output['incident']['datum'] = "";
                }
                
                $output['incident']['telefoonnummer'] = $vars['oudTel'];
                
                if($output['incident']['oudafdeling'] != $vars['afdeling'])
                    $output['incident']['afdeling'] = $output['incident']['oudafdeling'];
                else
                    $output['incident']['afdeling'] = $vars['afdeling'];
                
                $counter = 0;
                foreach($output['behandelaars'] as $behandelaar)
                {
                    if($behandelaar['id'] == $vars['behandelaar_id'])
                    {
                        $behandelaar['selected'] = "true";
                        $output['behandelaars'][$counter] = $behandelaar;
                    }
                    
                    $counter++;
                }
            }
            
            $query = "
                select
                    UNIX_TIMESTAMP(i.aangemeld) as aangemeld, b.naam
                from
                    " . $page['settings']['locations']['db_prefix'] . "incidenten i,
                    " . $page['settings']['locations']['db_prefix'] . "behandelaar b
                where
                    i.invoerder = b.id
                and
                    i.id = ?
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
            $vars = $page['classes']['sql']->fetch_array($sth);
            
            $output['incident']['aangemeld'] = date($page['settings']['datetime'], $vars['aangemeld']) ;
            $output['incident']['invoerder'] = $vars['naam'];
            
            $query = "
                SELECT
                    ia.id,
                    actie,
                    naam as behandelaar,
                    UNIX_TIMESTAMP(datum) as datum
                FROM
                    " . $page['settings']['locations']['db_prefix'] . "incidentacties ia, " . $page['settings']['locations']['db_prefix'] . "behandelaar b
                WHERE
                    b.id = ia.behandelaar
                AND
                    incident_id = ?
                ORDER BY
                    datum DESC
            ";
            
            $sth = $page['classes']['sql'] -> do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
            
            $counter = 0;
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                $output['incident']['actie'][$counter++] = array(
                    'id' => $vars['id'],
                    'actie' => $vars['actie'],
                    'behandelaar' => $vars['behandelaar'],
                    'datum' =>  date($page['settings']['datetime'],$vars['datum'])
                );
            }
        }
        
		function IncidentAfmelden()
        {
            global $input, $page, $output;
            
            $queryvars = array($output['oid'], "Incident afgemeld", $_COOKIE['behandelaar']);
            $query = "
                INSERT INTO " . $page['settings']['locations']['db_prefix'] . "incidentacties (
                    incident_id,
                    actie,
                    behandelaar,
                    datum
                )
                VALUES (?, ?, ?, NOW())
            ";
            
            $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
        }
	
        function OverigeIncidenten()
        {
            global $input, $page, $output;
            
            $query = "
                SELECT
                    i.id, i.naam, i.probleem, UNIX_TIMESTAMP(i.aangemeld) as aangemeld, c.categorie, s.status
                FROM
                    " . $page['settings']['locations']['db_prefix'] . "categorie c,
                    " . $page['settings']['locations']['db_prefix'] . "incidenten i
                LEFT JOIN
                    " . $page['settings']['locations']['db_prefix'] . "status s
                ON
                    i.status = s.id
                Where
                    i.afgemeld = 0
                and
                    i.categorie = c.id
                order by
                    i.id desc
            ";
            
            $sth = $page['classes']['sql']->do_query($query,__LINE__,__FILE__);
            $counter = 0;
            $dagen = 6;
            $mktime = mktime(0,0,0, (date("m")), (date("d")-$dagen), date("Y"));
            
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                $length = 150;
                if(strlen($vars['probleem']) > $length)
                    $vars['probleem'] = substr( $vars['probleem'], 0, strrpos( substr( $vars['probleem'], 0, $length), ' ' )) . " ...";
               
                $dag = date("w",$vars['aangemeld']);
                $dagtekst = "";
                
                $dagArr = array("Zondag","Maandag","Dinsdag","Woensdag","Donderdag","Vrijdag","Zaterdag");
                
                $timestamp = $vars['aangemeld'];
                $vars['aangemeld'] = $dagArr[$dag] . " " . date($page['settings']['datetime'],$vars['aangemeld']);
                
                $output['andere'][$counter] = array(
                    'id' => $vars['id'],
                    'naam' => $page['classes']['sanitizer']->SanitizeOutput($vars['naam']),
                    'probleem' => $page['classes']['sanitizer']->SanitizeOutput($vars['probleem']),
                    'categorie' => $page['classes']['sanitizer']->SanitizeOutput($vars['categorie']),
                    'datum' => $vars['aangemeld'],
                    'status' => $vars['status']
                );
                
                if($timestamp + 0 < $mktime)
                {
                    $output['andere'][$counter]['color'] = ($counter % 2)+ 2;
                    $dagen = $dagen + 7;
                    
                    $mktime = mktime(0,0,0, (date("m")), (date("d")-$dagen), date("Y"));
                }
                else
                    $output['andere'][$counter]['color'] = $counter % 2;
                
                $queryvars2 = array($vars['id']);
                $query2 = "
                    select
                        ib.behandelaar_id, b.naam
                    from
                        toppie_incidenten i,
                        toppie_incidentbehandelaar ib
                    left join
                        toppie_behandelaar b
                    on
                        ib.behandelaar_id = b.id
                    where
                        i.id = ib.incident_id
                    and
                        i.id = ?
                ";
                
                $sth2 = $page['classes']['sql']->do_placeholder_query($query2,$queryvars2,__LINE__,__FILE__);
                
                $first = true;
                $temp = "";
                
                $unset = true;
                
                while($vars2 = $page['classes']['sql']->fetch_array($sth2))
                {
                    if($_COOKIE['behandelaar'] == $vars2['behandelaar_id'])
                        $output['andere'][$counter]['color'] = 5;
                    
                    if($vars2['behandelaar_id'] == 0)
                        $vars2['naam'] = "Afdeling ICT";
                    
                    if($first){
                        $temp .= spaceToNbsp($vars2['naam']);
                        $first = false;
                    }
                    else
                        $temp .= "<br />" . spaceToNbsp($vars2['naam']);
                    
                    if($vars2['behandelaar_id'] == 10)
                        $unset = false;
                }
                
                $output['andere'][$counter]['behandelaar'] = $temp;
                
                if($unset)
                    unset($output['andere'][$counter]);
                else
					$counter++;
		
				$output['counter']['andere'] = count($output['andere']);
            }
        }
    }
?>