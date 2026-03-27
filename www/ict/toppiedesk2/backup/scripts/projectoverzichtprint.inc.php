<?php
    $page['classes']['load'] = new configcontract();

    class configcontract
    {
        function GetFileName()
        {
            return "projectoverzichtprint";
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
                    "medewerker" => array("medewerker", "both", "")
                )
            );
        }
        
        function DoRun()
        {
            global $input, $page, $output;
            
            $page['settings']['locations']['default_site']['header'] = "headers/printheader";
			$page['settings']['locations']['default_site']['sidebar'] = "sidebars/printsidebar";
            
            if($input['medewerker'] == "")
                $input['medewerker'] = 0;
                
            Loadbehandelaars(true);
            
            $counter = 0;
            
            foreach($output['behandelaars'] as $behandelaar)
            {
                if($behandelaar['id'] == $input['medewerker'])
                {
                    $behandelaar['selected'] = "true";
                    $output['behandelaars'][$counter] = $behandelaar;
                }
                
                $counter++;
            }
                
            if($input['medewerker'] != "0" || $input['medewerker'] <> 0)
            {
                $query = "
                    select
                        p.id,
                        p.titel,
                        UNIX_TIMESTAMP(p.deadline) as deadline,
                        p.geplandetijd,
                        b.id as verantwoordelijk,
                        b.naam,
                        sum(a.bestedetijd) as bestedetijd,
                        p.top10
                from
                    toppie_project p
                left join
                    `toppie_project_activiteit` a
                on
                    p.id = a.projectid
                left join
                    " . $page['settings']['locations']['db_prefix'] . "behandelaar b
                on
                    p.verantwoordelijk = b.id
                where (
                    p.id in (
                        select
                            projectid
                        from
                            `toppie_project_project-medewerker`
                        where
                            medewerkerid = ?
                    )
                    or
                        p.verantwoordelijk = ?
                )
                and
                    p.afgemeld = 0
                group by
                    p.id";
                
                $queryvars = array($input['medewerker'], $input['medewerker']);
                
                $sth = $page['classes']['sql']->do_placeholder_query($query, $queryvars,__line__,__file__);
            }
            else
            {
            
                $query = "
                    SELECT
                        p.id,
                        p.titel,
                        UNIX_TIMESTAMP(p.deadline) as deadline,
                        p.geplandetijd,
                        b.id as verantwoordelijk,
                        b.naam,
                        sum(a.bestedetijd) as bestedetijd,
                        p.top10
                    FROM
                        " . $page['settings']['locations']['db_prefix'] . "project p
                    LEFT JOIN
                        " . $page['settings']['locations']['db_prefix'] . "behandelaar b
                    ON
                        p.verantwoordelijk = b.id
                    LEFT JOIN
                        " . $page['settings']['locations']['db_prefix'] . "project_activiteit a
                    ON
                        p.id = a.projectid
                    WHERE
                        afgemeld = 0
                    group by
                        p.id
                    ORDER BY
                        top10 DESC
                ";
                
                $sth = $page['classes']['sql']->do_query($query,__LINE__,__FILE__);
            }
            
            $counter = 0;
            
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                $output['project'][$counter] = array(
                    "id" => $vars['id'],
                    "titel" => $vars['titel'],
                    "deadline" => date("d-m-Y", $vars['deadline']),
                    "geplandetijd" => $this->IntToTime($vars['geplandetijd']),
                    "verantwoordelijk" => $vars['verantwoordelijk'],
                    "naam" => $vars['naam'],
                    "bestedetijd" => $this->IntToTime($vars['bestedetijd']),
                    "top10" => $vars['top10']
                );
                
                $geplandetijd = $vars['geplandetijd'];
                $deadline = $vars['deadline'];
                
                if($output['project'][$counter]["deadline"] == "01-01-1970")
                    $output['project'][$counter]["deadline"] = "";
                
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
                    
                    if($vars['naam'] != $vars2['naam'])
                    {
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
                 
                }
                
                if($_COOKIE['behandelaar'] == $vars['verantwoordelijk'])
                    $output['project'][$counter]['color'] = 5;
                
                $geplandetijd = floor($geplandetijd / 60);
                $geplandetijd = ceil($geplandetijd / 7);
                
                if((date('w',mktime(0,0,0,date('m'),date('d') + $geplandetijd, date("Y"))) - 1) < 1)
                    $geplandetijd = $geplandetijd + 2;
                else if($geplandetijd > 5)
                    $geplandetijd = $geplandetijd + (round($geplandetijd / 7) * 2);
                
                if($output['project'][$counter]["deadline"] != "" && $deadline < mktime(0,0,0,date('m'),date('d')+ $geplandetijd, date("Y")))
                   $output['project'][$counter]['color'] = 7;
                
                if($output['project'][$counter]["deadline"] != "" && $deadline < mktime(0,0,0,date("m"),date("d"),date("Y")))
                {
                    $output['project'][$counter]['color'] = 6;
                }
                
                $output['project'][$counter]['medewerkers'] = $temp;
                
                $counter++;
            }
            
            
            
            
        }
        
        function GetSidebarType()
        {
            return "project";
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