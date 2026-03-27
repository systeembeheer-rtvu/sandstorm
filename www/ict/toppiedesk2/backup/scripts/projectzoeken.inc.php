<?php
    $page['classes']['load'] = new IncidentNieuw();
    
    class IncidentNieuw
    {
        function GetFileName()
        {
            return "projectzoeken";
        }
        
        function CheckPage()
        {
            return 0;
        }
        
        function NavigatieBalk()
        {
            global $input, $page, $output;
        }
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "titel" => array("titel", "post", ""),
                    "deadline" => array("deadline", "post", ""),
                    "doel" => array("doel", "post", ""),
                    "opdrachtgever" => array("opdrachtgever", "post", ""),
                    "verantwoordelijke" => array("verantwoordelijke", "post", ""),
                    "medewerkers" => array("medewerkers", "post", ""),
                    "aangemeld" => array("aangemeld", "post", ""),
                    "afgemeld" => array("afgemeld", "post", "")
                )
            );
        }
        
        function DoRun()
        {
            global $input, $page, $output;
            
            $this->Weergeven();
            
            if(isset($_POST['submit']) && $_POST['submit'] == "Zoeken")
                $this->zoeken();
        }
        
        function GetSidebarType()
        {
            return "project";
        }
        
        //Overige functions
        
        function Zoeken()
        {
            global $input, $page, $output;
            
            $output['search']['titel'] = $input['titel'];
            $output['search']['deadline'] = $input['deadline'];
            $output['search']['doel'] = $input['doel'];
            $output['search']['opdrachtgever'] = $input['opdrachtgever'];
            $output['search']['verantwoordelijke'] = $input['verantwoordelijke'];
            $output['search']['afgemeld'] = $input['afgemeld'];
            $output['search']['aangemeld'] = $input['aangemeld'];
            
            foreach($output['behandelaars'] as &$verantwoordelijke)
            {
                if($verantwoordelijke['id'] == $output['search']['verantwoordelijke'])
                {
                    $verantwoordelijke['selected'] = "true";
                }
            }
            
            if($input['medewerkers'] != "")
            {
                foreach($output['medewerkers'] as &$medewerker)
                {
                    foreach($input['medewerkers'] as $temp)
                    {
                        if($medewerker['id'] == $temp)
                            $medewerker['selected'] = "true";
                    }
                }
            }
            
            $queryvars = array();
            $query = "
                SELECT
                    p.id,
                    p.titel,
                    b.naam as verantwoordelijk,
                    UNIX_TIMESTAMP(p.deadline) as deadline,
                    p.geplandetijd,
                    sum(a.bestedetijd) as bestedetijd,
                    UNIX_TIMESTAMP(aangemaaktop) as aangemaaktop,
                    UNIX_TIMESTAMP(geslotenop) as geslotenop
                FROM
                    ". $page['settings']['locations']['db_prefix'] . "project p
                LEFT JOIN
                    ". $page['settings']['locations']['db_prefix'] . "behandelaar b
                ON
                    p.verantwoordelijk = b.id
                LEFT JOIN
                    ". $page['settings']['locations']['db_prefix'] . "project_activiteit a
                ON
                    p.id = a.projectid
                WHERE
                    1
                
            ";
            
            if(isset($output['search']['titel']) && $output['search']['titel'] != "")
            {
                $queryvars[count($queryvars)] = "%" . $output['search']['titel'] . "%";
                $query .= " AND p.titel like ?";
            }
            
            if(isset($output['search']['deadline']) && $output['search']['deadline'] != "")
            {
                $queryvars[count($queryvars)] = $output['search']['deadline'];
                $query .= " AND p.deadline like ?";
            }
            
            if(isset($output['search']['doel']) && $output['search']['doel'] != "")
            {
                $queryvars[count($queryvars)] = "%" . $output['search']['doel'] . "%";
                $query .= " AND p.doel like ?";
            }
            
            if(isset($output['search']['opdrachtgever']) && $output['search']['opdrachtgever'] != "")
            {
                $queryvars[count($queryvars)] = "%" . $output['search']['opdrachtgever'] . "%";
                $query .= " AND p.opdrachtgever like ?";
            }
            
            if(isset($output['search']['verantwoordelijke']) && $output['search']['verantwoordelijke'] != "-1")
            {
                $queryvars[count($queryvars)] = $output['search']['verantwoordelijke'];
                $query .= " AND p.verantwoordelijk like ?";
            }
            
            if($input['aangemeld'] == "on" && $input['afgemeld'] == "")
                $query .= " AND p.afgemeld = 0";
            else if($input['afgemeld'] == "on" && $input['aangemeld'] == "")
                $query .= " AND p.afgemeld = 1";
            
            $query .= " GROUP BY p.id";
            
            $sth = $page['classes']['sql'] -> do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
            
            $counter = 0;
            
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                $output['project'][$counter] = array(
                    "id" => $vars['id'],
                    "titel" => $vars['titel'],
                    "deadline" => date("d-m-Y", $vars['deadline']),
                    "geplandetijd" => IntToTime($vars['geplandetijd']),
                    "verantwoordelijk" => $vars['verantwoordelijk'],
                    "bestedetijd" => IntToTime($vars['bestedetijd']),
                    "aangemaaktop" => date("d-m-Y", $vars['aangemaaktop']),
                    "geslotenop" => $vars['geslotenop'] == "" ? "" : date("d-m-Y", $vars['geslotenop'])
                );
                
                if($output['project'][$counter]['deadline'] == "01-01-1970")
                    $output['project'][$counter]['deadline'] = "";
                    
                /*if($output['project'][$counter]['geslotenop'] == "01-01-1970");
                    $output['project'][$counter]['geslotenop'] == "";*/
                
                $queryvars2 = array($vars['id']);
                $query2 = "
                    SELECT
                        id, naam
                    FROM
                        `" . $page['settings']['locations']['db_prefix'] . "project_project-medewerker` pm,
                        " . $page['settings']['locations']['db_prefix'] . "behandelaar b
                    WHERE
                        pm.medewerkerid = b.id
                    AND
                        pm.projectid = ? 
                ";
                
                $sth2 = $page['classes']['sql']->do_placeholder_query($query2,$queryvars2,__LINE__,__FILE__);
                
                $first = true;
                $temp ="";
                while($vars2 = $page['classes']['sql']->fetch_array($sth2))
                {
                    $output['project'][$counter]['color'] = $counter % 2;
                    
                    if($first)
                    {
                        $temp .= spaceToNbsp($vars2['naam']);
                        $first = false;
                    }
                    else
                        $temp .= "<br />" . spaceToNbsp($vars2['naam']);
                    
                    if($_COOKIE['behandelaar'] == $vars2['id'])
                        $output['project'][$counter]['color'] = 4;
                    
                }
                
                if($_COOKIE['behandelaar'] == $vars['verantwoordelijk'])
                    $output['project'][$counter]['color'] = 5;
                
                $output['project'][$counter]['medewerkers'] = $temp;
                
                $counter++;
            }
            
            $output['counter'] = $counter;
        }
        
        function Weergeven()
        {
            $this->LoadMedewerker();
            $this->LoadVerantwoordelijke();
        }
        
        function LoadMedewerker()
        {
            global $page, $output;
            
            $query = "
                SELECT * FROM " . $page['settings']['locations']['db_prefix'] . "behandelaar 
            ";
            $sth = $page['classes']['sql']->do_query($query,__LINE__,__FILE__);
            
            $counter = 0;
            
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                $output['medewerkers'][$counter++] = array('id' => $vars['id'], 'naam' => $vars['naam'], 'actief' => $vars['actief'],  'selected' => "false");
            }
            
            $output['medewerkers'] = subval_sort($output['medewerkers'],'naam');
        }
        
        function LoadVerantwoordelijke()
        {
            global $page, $output;
            
            $query = "
                SELECT * FROM " . $page['settings']['locations']['db_prefix'] . "behandelaar 
            ";
            $sth = $page['classes']['sql']->do_query($query,__LINE__,__FILE__);
            
            $counter = 0;
            
            $output['behandelaars'][$counter++] = array('id' => 0, 'naam' => '', 'actief' => 0, 'selected' => "false");
            
            if(isset($intput['verantwoordelijke']) && $input['verantwoordelijke'] == "")
                $output['behandelaars'][$counter++] = array('id' => -1, 'naam' => '&lt;alle&gt;', 'actief' => 0, 'selected' => "true");
            else
                $output['behandelaars'][$counter++] = array('id' => -1, 'naam' => '&lt;alle&gt;', 'actief' => 0, 'selected' => "false");
            
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                $output['behandelaars'][$counter++] = array('id' => $vars['id'], 'naam' => $vars['naam'], 'actief' => $vars['actief'],  'selected' => "false");
            }
            
            $output['behandelaars'] = subval_sort($output['behandelaars'],'naam');
        }
    }
?>