<?php
    $page['classes']['load'] = new IncidentNieuw();

    class IncidentNieuw
    {
        function GetFileName()
        {
            
            return "projecturen";
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
                    "week" => array("week", "both", "int"),
                    "medewerker" => array("medewerker", "both", "int"),
                    "datum" => array("datum", "both", "")
                )
            );
        }
        
        function DoRun()
        {
            global $input, $page, $output;
            
            $output['medewerker'] = $input['medewerker'];
            
            $this->GetDatum();
            $this->Loadbehandelaars();
            
            foreach($output['behandelaars'] as &$behandelaar)
            {
                if($behandelaar['id'] == $input['medewerker'])
                {
                    $behandelaar['selected'] = "true";
                }
            }
            
            if($input['medewerker'] > 0)
                $this->LoadMedewerkerOverzicht();
            else
                $this->LoadOverzicht();
        }
        
        function GetSidebarType()
        {
            return "project";
        }
        
        //Overige functions
        
        function GetDatum()
        {
            global $input, $page, $output;
            
            if(isset($_POST['submit']) && $_POST['submit'] == "Weergeven" && $input['datum'] != "")
            {
                $datum = strtotime($input['datum']);
                
                $huidige = date("W");
                $gewenst = date("W", $datum);
                
                $input['week'] = $gewenst - $huidige;
                
            }
            
            $output['huidige'] = $input['week'];
            
            $output['vorige'] = $input['week'] - 1;
            $output['volgende'] = $input['week'] + 1;
            
            $week = $input['week'];
            $week = $week * 7;
            
            $week = mktime(0,0,0, date("m"), date("d") + $week, date("Y"));
            $output['weeknummer'] = "Week " . date("W", $week);
            
            
            $output['first'] = date("Y-m-d", mktime(0,0,0,date("m",$week), date("d", $week) - date("w", $week) + 1, date("Y", $week)));
            $output['last'] = date("Y-m-d", mktime(0,0,0,date("m", $week), date("d", $week) + (6-(date("w", $week) % 7)) + 1, date("Y", $week)));
            
            $output['dagen']['ma'] = date("d-m-Y", strtotime($output['first']));
            $output['dagen']['di'] = date("d-m-Y", strtotime($output['first'] . " +1 day"));
            $output['dagen']['wo'] = date("d-m-Y", strtotime($output['first'] . " +2 day"));
            $output['dagen']['do'] = date("d-m-Y", strtotime($output['first'] . " +3 day"));
            $output['dagen']['vr'] = date("d-m-Y", strtotime($output['first'] . " +4 day"));
            $output['dagen']['za'] = date("d-m-Y", strtotime($output['first'] . " +5 day"));
            $output['dagen']['zo'] = date("d-m-Y", strtotime($output['first'] . " +6 day"));
        }
        
        function LoadMedewerkerOverzicht()
        {
            global $input, $page, $output;
            
            $queryvars = array($output['first'], $output['last'], $input['medewerker']);
            $query = "
                SELECT
                    p.titel,
                    sum(bestedetijd) as bestedetijd,
                    b.id,
                    UNIX_TIMESTAMP(a.datum) as datum,
                    b.naam
                FROM
                    `" . $page['settings']['locations']['db_prefix'] . "project` p
                LEFT JOIN
                    `" . $page['settings']['locations']['db_prefix'] . "project_activiteit` a
                ON
                    a.projectid = p.id
                LEFT JOIN
                    `" . $page['settings']['locations']['db_prefix'] . "behandelaar` b
                ON
                    a.behandelaar = b.id
                WHERE
                    a.datum between ? and ?
                AND
                    a.behandelaar = ?
                GROUP BY
                    b.id, p.titel, a.datum
                ORDER BY
                    b.naam ASC
            ";
            
            $counter = 0;
            
            $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
            if($page['classes']['sql']->total_rows($sth) > 0)
            {
                while($vars = $page['classes']['sql']->fetch_array($sth))
                {
                    if($vars['naam'] != null)
                    {
                        $datum = date("w", $vars['datum']);
                        
                        $output['project']['id'] = $vars['id'];
                        $output['project']['naam'] = $vars['naam'];
                        $output['project']['projecten'][$datum][$counter++] = array(
                            "project" => $vars['titel'],
                            "bestedetijd" => $this->IntToTime($vars['bestedetijd']),
                            "link" => 0
                        );
                    }
                }
            }
            else
            {
                $queryvars = array($input['medewerker']);
                $query = "
                    SELECT id, naam
                    FROM `" . $page['settings']['locations']['db_prefix'] . "behandelaar` b
                    WHERE id = ?
                ";
                
                $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                $vars = $page['classes']['sql']->fetch_array($sth);
                
                $output['project']['naam'] = $vars['naam'];
            }
            
            $queryvars = array($output['first'], $output['last'], $input['medewerker']);
            $query = "
                SELECT
                    incident_id,
                    b.naam,
                    UNIX_TIMESTAMP(datum) as datum,
                    sum(bestedetijd) as bestedetijd
                FROM
                    `" . $page['settings']['locations']['db_prefix'] . "incidentacties` ia
                LEFT JOIN
                    `" . $page['settings']['locations']['db_prefix'] . "behandelaar` b
                ON
                    ia.behandelaar = b.id
                WHERE
                    datum BETWEEN ? AND ?
                AND
                    b.id = ?
                GROUP BY
                    incident_id
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
            
            while($vars = $page['classes']['sql']->fetch_array($sth)){
                if(isset($vars['naam']) && $vars['naam'] != null)
                    {
                        $datum = date("w", $vars['datum']);
                        
                        $output['project']['projecten'][$datum][$counter++] = array(
                            "project" => "Incident " . $vars['incident_id'],
                            "bestedetijd" => $this->IntToTime($vars['bestedetijd']),
                            "link" => $vars['incident_id']
                        );
                        
                        
                    }
            }
            
            $color = 0;
        }
        
        function LoadOverzicht()
        {
            global $input, $page, $output;
            
            $queryvars = array($output['first'], $output['last']);
            $query = "
                SELECT
                    p.titel,
                    sum(bestedetijd) as bestedetijd,
                    b.id,
                    UNIX_TIMESTAMP(a.datum) as datum,
                    b.naam,
                    p.id as projectid
                FROM
                    `" . $page['settings']['locations']['db_prefix'] . "project` p
                LEFT JOIN
                    `" . $page['settings']['locations']['db_prefix'] . "project_activiteit` a
                ON
                    a.projectid = p.id
                LEFT JOIN
                    `" . $page['settings']['locations']['db_prefix'] . "behandelaar` b
                ON
                    a.behandelaar = b.id
                WHERE
                    a.datum between ? and ?
                GROUP BY
                    b.id, p.titel, a.datum
                ORDER BY
                    b.naam ASC
            ";
            
            $counter = 0;
            $color = 0;
            
            $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                if($vars['naam'] != null)
                {
                    $datum = date("w", $vars['datum']);
                    
                    $output['project'][$vars['id']]['naam'] = $vars['naam'];
                    $output['project'][$vars['id']]['projecten'][$datum][$counter++] = array(
                        "project" => $vars['titel'],
                        "bestedetijd" => $this->IntToTime($vars['bestedetijd']),
                        "link" => $vars['projectid'],
                        "type" => "project"
                    );
                }
            }
            
            $queryvars = array($output['first'], $output['last']);
            $query ="
                SELECT
                    incident_id,
                    b.id,
                    b.naam,
                    UNIX_TIMESTAMP(datum) as datum,
                    sum(bestedetijd) as bestedetijd
                FROM
                    `" . $page['settings']['locations']['db_prefix'] . "incidentacties` ia
                LEFT JOIN
                    `" . $page['settings']['locations']['db_prefix'] . "behandelaar` b
                ON
                    ia.behandelaar = b.id
                WHERE
                    datum BETWEEN ? AND ?
                GROUP BY
                    incident_id,
                    behandelaar
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
            
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                if($vars['naam'] != null)
                {
                    $datum = date("w", $vars['datum']);
                    
                    $output['project'][$vars['id']]['naam'] = $vars['naam'];
                    $output['project'][$vars['id']]['projecten'][$datum][$counter++] = array(
                        "project" => "Incident " . $vars['incident_id'],
                        "bestedetijd" => $this->IntToTime($vars['bestedetijd']),
                        "link" => $vars['incident_id'],
                        "type" => "incident"
                    );
                }
            }
            
            $color = 0;
            
            if(isset($output['project']) && count($output['project']) > 0)
            {
                foreach($output['project'] as &$project)
                {
                    $project['color'] = $color++ % 2;
                }
            }
        }
        
        function Loadbehandelaars()
        {
            global $page, $output;
            
            $query = "
                SELECT * FROM " . $page['settings']['locations']['db_prefix'] . "behandelaar 
            ";
            $sth = $page['classes']['sql']->do_query($query,__LINE__,__FILE__);
            
            $counter = 0;
            
            $output['behandelaars'][$counter++] = array('id' => 0, 'naam' => '', 'actief' => 0, 'selected' => "false");
            
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                $output['behandelaars'][$counter++] = array('id' => $vars['id'], 'naam' => $vars['naam'], 'actief' => $vars['actief'],  'selected' => "false");
            }
            
            $output['behandelaars'] = subval_sort($output['behandelaars'],'naam');
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
    }
?>