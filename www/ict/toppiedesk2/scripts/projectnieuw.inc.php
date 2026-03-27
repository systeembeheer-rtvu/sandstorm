<?php
    $page['classes']['load'] = new configcontract();

    class configcontract
    {
        function GetFileName()
        {
            return "projectnieuw";
        }
        
        function CheckPage()
        {
            return 0;
        }
        
        function NavigatieBalk(){}
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "searchoid" => array("searchoid", "get", ""),
                    "oid" => array("oid", "post", "int"),
                    "titel" => array("titel", "post", ""),
                    "doel" => array("doel", "post", ""),
                    "gesloten" => array("gesloten", "post", ""),
                    "geplandetijd" => array("geplandetijd", "post", ""),
                    "deadline" => array("deadline", "post", ""),
                    "date" => array("date","post", ""),
                    "bestedetijd" => array("bestedetijd", "post", ""),
                    "activiteit" => array("activiteit", "post", ""),
                    "act_id" => array("act_id", "post", ""),
                    "act_tijd" => array("act_tijd", "post", ""),
                    "act_datum" => array("act_datum", "post", ""),
                    "act_behandelaar" => array("act_behandelaar", "post", ""),
                    "act_omschrijving" => array("act_omschrijving", "post", ""),
                    "verantwoordelijk" => array("verantwoordelijk", "post", ""),
                    "behandelaar" => array("behandelaar", "post", ""),
                    "opdrachtgever" => array("opdrachtgever", "post", ""),
                    "begroting" => array("begroting", "post", ""),
                    "top10" => array("top10", "post", ""),
                    "prevAfgemeld" => array("prevAfgemeld", "post", "")
                )
            );
        }
        
        function DoRun()
        {
            global $input, $page, $output;
            
            $this->LoadMedewerkers();
            
            if(isset($_POST['submit']) && $_POST['submit'] == "Opslaan")
                $this->Opslaan();
            else if(isset($_POST['o&a']) && $_POST['o&a'] == "Sluiten")
            {
                $this->Opslaan();
                $output['redirect'] = $page['settings']['locations']['file'] ."?id=projectoverzicht";
            }
            else if($input['searchoid'] > 0)
            {
                $this->ProjectWeergeven();
                $this->BestedeTijd();
            }
            else
                $output['project']['id'] = 0;
        }
        
        function GetSidebarType()
        {
            return "project";
        }
        
        function Opslaan()
        {
            global $input, $page, $output;
            
            $this->ProjectOpslaan();
            $this->ActiviteitToevoegen();
            $this->ActiviteitBijwerken();
            $this->MedewerkerBijwerken();
            
            $output['redirect'] = $page['settings']['locations']['file'] ."?id=projectnieuw&searchoid=" . $input['oid'];
        }
        
        function ProjectOpslaan()
        {
            global $input, $page, $output;
            
            if($input['gesloten'] == "on")
            {
                $input['gesloten'] = 1;
            }
            else
            {
                $input['gesloten'] = 0;
            }
            
            if($input['top10'] == "on")
            {
                $input['top10'] = 1;
            }
            else
            {
                $input['top10'] = 0;
            }
            
            $input['deadline'] = strtotime($input['deadline']);
            
            if($input['oid'] > 0)
            {
                $queryvars = array(
                    $input['titel'],
                    $input['doel'],
                    $input['verantwoordelijk'],
                    date("Y-m-d", $input['deadline']),
                    $this->TimeToInt($input['geplandetijd']),
                    $input['gesloten'],
                    $input['opdrachtgever'],
                    $input['begroting'],
                    $input['top10'],
                    $input['oid'],
                    
                );
                
                $query = "
                    UPDATE " . $page['settings']['locations']['db_prefix'] . "project
                    SET titel = ?, doel = ?, verantwoordelijk = ?, deadline = ?, geplandetijd = ?, afgemeld = ?, opdrachtgever = ?, begroting = ?, top10 = ?
                    WHERE id = ?
                ";
                
                $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
            }
            else
            {
                $queryvars = array(
                    $input['titel'],
                    $input['doel'],
                    $input['verantwoordelijk'],
                    date("Y-m-d", $input['deadline']),
                    $this->TimeToInt($input['geplandetijd']),
                    $input['gesloten'],
                    date("Y-m-d", mktime(0,0,0,date('m'),date('d'),date('Y'))) . " 00:00:00",
                    $_COOKIE['behandelaar'],
                    $input['opdrachtgever'],
                    $input['begroting'],
                    $input['top10']
                );
                
                $query = "
                    INSERT INTO " . $page['settings']['locations']['db_prefix'] . "project(
                        titel,
                        doel,
                        verantwoordelijk,
                        deadline,
                        geplandetijd,
                        afgemeld,
                        aangemaaktop,
                        aangemaaktdoor,
                        opdrachtgever,
                        begroting,
                        top10)
                    VALUES(?,?,?,?,?,?,?,?,?,?,?)
                ";
                
                $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
                $input['oid'] = $page['classes']['sql']->last_insert_id(__line__,__file__);
            }
            
            if ($input["prevAfgemeld"] == "0" && $input['gesloten'] =="1")
            {
                $queryvars = array($input['oid']);
                $query = 'update toppie_project set geslotenop = CURRENT_TIMESTAMP where id =?';
                $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
            }
            else if($input["prevAfgemeld"] == "1" && $input['gesloten'] == "0")
            {
                $queryvars = array($input['oid']);
                $query = 'update toppie_project set geslotenop=NULL where id=?';
                $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
            }
        }
        
        function ActiviteitToevoegen()
        {
            global $input, $page, $output;
            
			$value = $page['classes']['sanitizer']->SanitizeInput($_POST['activiteit']);
			
            if($value != "")
            {
                $queryvars = array($input['oid'], $this->TimeToInt($input['bestedetijd']), $_COOKIE['behandelaar'], $value, date("Y-m-d", strtotime($input['date'])));
                
                $query = "
                    INSERT INTO " . $page['settings']['locations']['db_prefix'] . "project_activiteit(
                        projectid,
                        bestedetijd,
                        behandelaar,
                        omschrijving,
                        datum
                    )
                    VALUES(?,?,?,?,?)
                ";
                
                $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
            }
        }
        
        function ActiviteitBijwerken()
        {
            global $input, $page, $output;
            
            
            if($input['act_id'] != "")
            {
                foreach($input['act_id'] as $id)
                {
                    $queryvars = array($page['classes']['sanitizer']->SanitizeInput($input['act_omschrijving'][$id]), $this->TimeToInt($input['act_tijd'][$id]),date("Y-m-d", strtotime($input['act_datum'][$id])), $id);
                    
                    $query = "
                        UPDATE " . $page['settings']['locations']['db_prefix'] . "project_activiteit
                        SET omschrijving = ?, bestedetijd = ?, datum = ? 
                        WHERE id = ? 
                    ";
                    
                    $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
                }
            }
        }
        
        function MedewerkerBijwerken()
        {
            global $input, $page, $output;
            
            $queryvars = array($input['oid']);
            
            $query = "
                DELETE FROM `" . $page['settings']['locations']['db_prefix'] . "project_project-medewerker` where projectid = ? 
            ";
            
            $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
            
            
            if($input['behandelaar'] != "")
            {
                foreach($input['behandelaar'] as $behandelaar)
                {
                    $queryvars = array($input['oid'], $behandelaar);
                    
                    $query = "
                        insert into `" . $page['settings']['locations']['db_prefix'] . "project_project-medewerker` (projectid, medewerkerid) values (?,?)
                    ";
                    
                    $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
                }
            }
        }
        
        function ProjectWeergeven()
        {
            global $input, $page, $output;
            
            $this->SelectedMedewerkers();
            $this->LoadActiviteiten();
            
            $queryvars = array($input['searchoid']);
            $query = "
                SELECT
                    p.id,
                    titel,
                    doel,
                    verantwoordelijk,
                    UNIX_TIMESTAMP(deadline) as deadline,
                    geplandetijd,
                    afgemeld,
                    b.naam as aangemaaktdoor,
                    UNIX_TIMESTAMP(aangemaaktop) as aangemaaktop,
                    opdrachtgever,
                    begroting,
                    top10
                FROM
                    ". $page['settings']['locations']['db_prefix'] . "project p,
                    ". $page['settings']['locations']['db_prefix'] . "behandelaar b
                WHERE
                    p.aangemaaktdoor = b.id
                AND
                    p.id = ?
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
            
            $vars = $page['classes']['sql']->fetch_array($sth);
            
            $output['project']['id'] = $vars['id'];
            $output['project']['titel'] = $vars['titel'];
            $output['project']['date'] = date("d-m-Y");
            $output['project']['doel'] = $vars['doel'];
            $output['project']['verantwoordelijk'] = $vars['verantwoordelijk'];
            $output['project']['deadline'] = $vars['deadline'];
            $output['project']['geplandetijd'] = $this->IntToTime($vars['geplandetijd']);
            $output['project']['aangemaaktdoor'] = $vars['aangemaaktdoor'];
            $output['project']['aangemaaktop'] = date("d-m-Y", $vars['aangemaaktop']);
            $output['project']['begroting'] = $vars['begroting'];
            $output['project']['opdrachtgever'] = $vars['opdrachtgever'];
            $output['project']['afgemeld'] = $vars['afgemeld'];
            $output['project']['top10'] = $vars['top10'];
            
            if($output['project']['deadline'] != "0000-00-00 00:00:00" && $output['project']['deadline'] != null && $output['project'][$counter]["deadline"] == "01-01-1970")
                $output['project']['deadline'] = date("d-m-Y", $output['project']['deadline']);
            else
                $output['project']['deadline'] = "";
        }
        
        function SelectedMedewerkers()
        {
            global $input, $page, $output;
            
            $queryvars = array($input['searchoid']);
            $query = "
                SELECT
                    b.id,
                    b.naam
                FROM
                    ". $page['settings']['locations']['db_prefix'] . "project p
                LEFT JOIN
                    `". $page['settings']['locations']['db_prefix'] . "project_project-medewerker` pm
                ON
                    p.id = pm.projectid
                LEFT JOIN
                    ". $page['settings']['locations']['db_prefix'] . "behandelaar b
                ON
                    pm.medewerkerid = b.id
                WHERE
                    p.id = ?
                
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
            
            
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                foreach($output['behandelaars'] as &$behandelaar)
                {
                    if($behandelaar['id'] == $vars['id'])
                        $behandelaar['selected'] = "true";
                }
            }
        }
        
        function LoadMedewerkers()
        {
            global $input, $page, $output;
            
            $query = "
                SELECT id, naam, actief FROM " . $page['settings']['locations']['db_prefix'] . "behandelaar 
            ";
            $sth = $page['classes']['sql']->do_query($query,__LINE__,__FILE__);
            
            $counter = 0;
            
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                $output['behandelaars'][$counter++] = array('id' => $vars['id'], 'naam' => $vars['naam'], 'actief' => $vars['actief'],  'selected' => "false");
            }
            
            $output['behandelaars'] = subval_sort($output['behandelaars'],'naam');
        }
        
        function LoadActiviteiten()
        {
            global $input, $page, $output;
            
            $queryvars = array($input['searchoid']);
            $query = "
                SELECT
                    a.id,
                    a.bestedetijd,
                    b.naam,
                    a.omschrijving,
                    UNIX_TIMESTAMP(a.datum) as datum
                FROM
                    " . $page['settings']['locations']['db_prefix'] . "project_activiteit a,
                    " . $page['settings']['locations']['db_prefix'] . "behandelaar b
                WHERE
                    a.behandelaar = b.id
                AND
                    projectid = ?
                ORDER BY
                    datum DESC, a.id desc
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
            
            $counter = 0;
            
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                $output['project']['activiteiten'][$counter++] = array(
                    'id' => $vars['id'],
                    'bestedetijd' => $this->IntToTime($vars['bestedetijd']),
                    'behandelaar' => $vars['naam'],
                    'omschrijving' => $vars['omschrijving'],
                    'datum' => date("d-m-Y",$vars['datum']),
                );
            }
        }
        
        function BestedeTijd()
        {
            global $input, $page, $output;
            
            $queryvars = array($input['searchoid']);
            
            $query = "
                select geplandetijd from " . $page['settings']['locations']['db_prefix'] . "project where id = ?
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
            
            $vars = $page['classes']['sql']->fetch_array($sth);
            
            $output['bestedetijd']['gepland'] = $vars['geplandetijd'];
            
            
            $query = "
                SELECT
                    sum(`bestedetijd`) as bestedetijd,
                    b.naam
                FROM
                    " . $page['settings']['locations']['db_prefix'] . "behandelaar b,
                    " . $page['settings']['locations']['db_prefix'] . "project_activiteit a
                WHERE
                    a.behandelaar = b.id
                AND
                    a.projectid = ?
                GROUP BY
                    a.behandelaar
                ORDER BY
                    b.naam asc
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
            
            $counter = 0;
            
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                $output['bestedetijd']['users'][$counter++] = array("naam" => $vars['naam'], "bestedetijd" => $this->IntToTime($vars['bestedetijd']));
                
                if(!isset($output['bestedetijd']['totaal']))
                    $output['bestedetijd']['totaal'] = 0;
                    
                $output['bestedetijd']['totaal'] = $output['bestedetijd']['totaal'] + $vars['bestedetijd'];
            }
            
            $output['bestedetijd']['totaal'] = $output['bestedetijd']['totaal'];
            $output['bestedetijd']['over'] = $this->IntToTime($output['bestedetijd']['gepland'] - $output['bestedetijd']['totaal']);
            $output['bestedetijd']['totaal'] = $this->IntToTime($output['bestedetijd']['totaal']);
        }
        
        function IntToTime($int)
        {
            if($int < 0)
            {
                $hours = ceil($int/60);
                
                $min = ($int % 60) * -1;
                
                if($min <= 9)
                    $min = "0" . $min;
            }
            else
            {
                $hours = floor($int/60);
                $min = $int % 60;
                
                if($min <= 9)
                    $min = "0" . $min;
            }
            
            return $hours . ":" . $min;
        }
        
        function TimeToInt($time)
        {
            list($hours, $min) = split(":", $time);
            
            if($min == null)
                return $hours;
            else
                $hours = $hours * 60;
                
            return $hours + $min;
        }
    }
?>