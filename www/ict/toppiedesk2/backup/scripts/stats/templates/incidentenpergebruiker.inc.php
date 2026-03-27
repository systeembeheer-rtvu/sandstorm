<?php
    class IncidentenPerGebruiker extends abstractStats
    {
        function __construct()
        {
            $this -> menutitle = "Incidenten per gebruiker";
            $this -> pagetitle = "";
            $this -> pageid = "incidentenpergebruiker";
            $this -> template = "";
        }
        
        public function GetData()
        {   
            global $page, $output;
            
            LoadGebruikers();
            
            if(isset($_GET['naam']))
                $page['vars']['naam'] = $_GET['naam'];
            
            if(isset($page['vars']['naam']))
            {
                $output['vars']['naam'] = htmlspecialchars($page['vars']['naam']);
                
                $queryvars = array(strtolower($output['vars']['naam']));
                
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
                        i.categorie = c.id
                    and
                        i.naam = ?
                    order by
                        i.id desc
                ";
                
                $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
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
                    
                    $queryvars2 = array($vars['id']);
                    $query2 = "
                        select
                            ib.behandelaar_id, b.naam
                        from
                            " . $page['settings']['locations']['db_prefix'] . "incidenten i,
                            " . $page['settings']['locations']['db_prefix'] . "incidentbehandelaar ib
                        left join
                            " . $page['settings']['locations']['db_prefix'] . "behandelaar b
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
                        {
                            $output['andere'][$counter]['color'] = 5;
                        }
                        
                        if($vars2['behandelaar_id'] == 0)
                            $vars2['naam'] = "Afdeling ICT";
                        
                        if($first){
                            $temp .= spaceToNbsp($vars2['naam']);
                            $first = false;
                        }
                        else
                            $temp .= "<br />" . spaceToNbsp($vars2['naam']);
                        
                        if($vars2['behandelaar_id'] != 10)
                            $unset = false;
                    }
                    
                    $output['andere'][$counter]['behandelaar'] = $temp;
                    
                    if($unset)
                        unset($output['andere'][$counter]);
                    else{
                        if(isset($output['andere'][$counter]['color']) && $output['andere'][$counter]['color'] == 5)
                        {}
                        else if($timestamp + 0 < $mktime)
                        {
                            $output['andere'][$counter]['color'] = ($counter % 2)+ 2;
                            $dagen = $dagen + 7;
                            
                            $mktime = mktime(0,0,0, (date("m")), (date("d")-$dagen), date("Y"));
                        }
                        else
                            $output['andere'][$counter]['color'] = $counter % 2;
                        
                        $counter++;
                    }
                }
                
                $output['counter']['andere'] = count($output['andere']);
                
                /*$query = "
                SELECT id, probleem
                FROM " . $page['settings']['locations']['db_prefix'] . "incidenten i
                WHERE naam = ?
                ";
                
                $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                
                $counter = 0;
                while($vars = $page['classes']['sql']->fetch_array($sth))
                {
                    $output['incidenten'][$counter] = array(
                        'id' => $vars['id'],
                        'probleem' => $vars['probleem'],
                        'color' => $counter % 2
                    );
                    
                    $counter++;
                }
                
                if(isset($output['incidenten']))
                    $output['vars']['counter'] = count($output['incidenten']);
                else
                    $output['vars']['counter'] = 0;*/
            }
            
            //$output;
        }
    }
    
    $page['stats']['classes'][$classcounter++] = new IncidentenPerGebruiker();
?>