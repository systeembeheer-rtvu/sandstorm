<?php
    $page['classes']['load'] = new IncidentZoeken();

    class IncidentZoeken
    {
        function GetFileName()
        {
            return "incidentzoeken";
        }
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "search" => array("search","get",""),
                    "opdracht" => array("opdracht", "post", ""),
                    "naam" => array("naam", "post", ""),
                    "dagvan" => array("dagvan", "post", ""),
                    "maandvan" => array("maandvan", "post", ""),
                    "jaarvan" => array("jaarvan", "post", ""),
                    "dagtot" => array("dagtot", "post", ""),
                    "maandtot" => array("maandtot", "post", ""),
                    "jaartot" => array("jaartot", "post", ""),
                    "status" => array("status", "post", ""),
                    "categorie" => array("categorie", "post", ""),
                    "aangemeld" => array("aangemeld", "post", ""),
                    "afgemeld" => array("afgemeld", "post", "")
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
            global $input, $page, $output;
            
            LoadStatus(true);
            LoadCategorieen(true);
            
            $this->zoekvensterWeergeven();
            
            if(isset($_POST['zoeken']))
            {
                $this->zoeken();
            }
            else
            {
                $output['vars']['aangemeld'] = "on";
                $output['counter'] = 1;
            }
        }
        
        function GetSidebarType()
        {
            return "incident";
        }
        
        //overige functies
        function zoeken()
        {
            global $input, $page, $output;
            
            $output['vars']['opdracht'] = $input['opdracht'];
            $output['vars']['van']['dag']     = $input['dagvan'];
            $output['vars']['van']['maand']   = $input['maandvan'];
            $output['vars']['van']['jaar']    = $input['jaarvan'];
            
            $output['vars']['tot']['dag']     = $input['dagtot'];
            $output['vars']['tot']['maand']   = $input['maandtot'];
            $output['vars']['tot']['jaar']    = $input['jaartot'];
            
            $output['vars']['van']['totaal']  = mktime(0,  0,  0,  $output['vars']['van']['maand'],  $output['vars']['van']['dag'],    $output['vars']['van']['jaar']);
            $output['vars']['tot']['totaal']  = mktime(23, 59, 59, $output['vars']['tot']['maand'],  $output['vars']['tot']['dag'],    $output['vars']['tot']['jaar']);
            
            $output['vars']['status']         = $input['status'];
            
            if(isset($input['categorie']) && $input['categorie'] != 0)
            {
                $output['vars']['categorie'] = $input['categorie'];
            }
            
            $output['vars']['afgemeld'] = $input['afgemeld'];
            $output['vars']['aangemeld'] = $input['aangemeld'];
            
            if(isset($input['naam']))
                $output['vars']['naam'] = $input['naam'];
            
            $dateformat = "Y-m-d H:i:s";
            
            $queryvars = array(
                "%" .$output['vars']['opdracht']. "%",
                date($dateformat, $output['vars']['van']['totaal']),
                date($dateformat, $output['vars']['tot']['totaal'])
            );
            
            $query = "
                SELECT
                    i.id,
                    i.naam,
                    i.probleem,
                    UNIX_TIMESTAMP(i.aangemeld) as aangemeld,
                    c.categorie,
                    s.status,
                    i.afgemeld
                FROM
                    " . $page['settings']['locations']['db_prefix'] . "categorie c,
                    " . $page['settings']['locations']['db_prefix'] . "incidenten i
                LEFT JOIN
                    " . $page['settings']['locations']['db_prefix'] . "status s
                ON
                    i.status = s.id
                Where
                    i.categorie = c.id
                AND
                    lower(probleem) like lower(?)
                AND
                    aangemeld between ? and ?
            ";
            
            if(isset($output['vars']['status']) && $output['vars']['status'] != 0)
            {
                $queryvars[count($queryvars)] = $output['vars']['status'];
                $query .= " AND i.status = ?";
            }
            
            $naamzoeken = "%". $output['vars']['naam'] . "%";
            
            if(isset($output['vars']['naam']) && $output['vars']['naam'] != "")
            {
                $queryvars[count($queryvars)] = $naamzoeken;
                $query .= " AND i.naam like ?";
            }
            
            if(isset($output['vars']['categorie']) && $output['vars']['categorie'] != 0)
            {
                $queryvars[count($queryvars)] = $output['vars']['categorie'];
                $query .= " AND c.id = ?";
            }
            
            if($input['aangemeld'] == "on" && $input['afgemeld'] == "")
            {
                $query .= " AND i.afgemeld = 0";
            }
            else if($input['afgemeld'] == "on" && $input['aangemeld'] == "")
            {
                $query .= " AND i.afgemeld = 1";
            } 
            
            $query .= " order by i.id desc";
            
            $sth = $page['classes']['sql'] -> do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
            
            $counter = 0;
            $dagen = 6;
            $mktime = mktime(0,0,0, (date("m")), (date("d")-$dagen), date("Y"));
            
            while ($vars = $page['classes']['sql'] -> fetch_array($sth))
            {
                $dag = date("w",$vars['aangemeld']);
                $dagArr = array("Zondag","Maandag","Dinsdag","Woensdag","Donderdag","Vrijdag","Zaterdag");
                
                $timestamp = $vars['aangemeld'];
                $vars['aangemeld'] = $dagArr[$dag] . " " . date($page['settings']['datetime'],$vars['aangemeld']);
                
                $output['incidenten'][$counter] = array(
                    'id' => $vars['id'],
                    'naam' => $page['classes']['sanitizer']->SanitizeOutput($vars['naam']),
                    'probleem' => $page['classes']['sanitizer']->SanitizeOutput($vars['probleem']),
                    'categorie' => $page['classes']['sanitizer']->SanitizeOutput($vars['categorie']),
                    'datum' => $vars['aangemeld'],
                    'status' => $vars['status'],
                    'afgemeld' => $vars['afgemeld']
                );
                
                
                    $output['incidenten'][$counter]['color'] = $counter % 2;
               
                
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
                
                while($vars2 = $page['classes']['sql']->fetch_array($sth2))
                {
                    if($_COOKIE['behandelaar'] == $vars2['behandelaar_id'])
                    {
                        $output['incidenten'][$counter]['color'] = 5;
                    }
                    
                    if($vars2['behandelaar_id'] == 0)
                        $vars2['naam'] = "Afdeling ICT";
                    
                    if($first){
                        $temp .= spaceToNbsp($vars2['naam']);
                        $first = false;
                    }
                    else
                        $temp .= "<br />" . spaceToNbsp($vars2['naam']);
                }
                
                $output['incidenten'][$counter]['behandelaar'] = $temp;
                
                $counter++;
            }
            
            $output['counter'] = $counter;
        }
        
        function zoekvensterWeergeven()
        {
            global $output;
            
            $lastMonth = mktime(0, 0, 0, date("m")-1, date("d"), date("Y"));
            
            $output['vars']['van']['dag']     = date("d", $lastMonth);
            $output['vars']['van']['maand']   = date("m", $lastMonth);
            $output['vars']['van']['jaar']    = date("Y", $lastMonth);
            
            $output['vars']['tot']['dag']     = date("d", time());
            $output['vars']['tot']['maand']   = date("m", time());
            $output['vars']['tot']['jaar']    = date("Y", time());
            
            $output['vars']['van']['totaal'] = mktime(0,0,0,$output['vars']['van']['maand'],$output['vars']['van']['dag'],$output['vars']['van']['jaar']);
            $output['vars']['tot']['totaal'] = mktime(23,59,59,$output['vars']['tot']['maand'],$output['vars']['tot']['dag'],$output['vars']['tot']['jaar']);
            
            $output['vars']['categorie'] = 0;
            
            $output['vars']['huidig']['jaar'] = date("Y");
        }
    }
?>