<?php
    $page['classes']['load'] = new wijzigingnieuwegebruiker();

    class wijzigingnieuwegebruiker
    {
        function GetFileName()
        {
            return "wijzigingnieuwegebruiker";
        }
        
        function CheckPage()
        {
            return 0;
        }
        
        function NavigatieBalk()
        {
            global $output;
            
            $output["navbar"]["new"] = "false"; //waarde voor een nieuw object
            $output["navbar"]["save"] = "false"; //waarde voor het opslaan van een object
            $output["navbar"]["prev"] = "false"; //waarde voor een vorig object
            $output["navbar"]["next"] = "false"; //waarde voor een volgend object
            $output["navbar"]["archive"] = "false"; //waarde voor een nieuw object
            $output['navbar']['autocomplete'] = "naam";
            $output['navbar']['id'] = "configkaart";
        }
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "opslaan" => array("opslaan","post",""),
                    "accept" => array("accept","post","")
                )
            );
        }
        
        function DoRun()
        {
            global $input, $page, $output;
            
            if(isset($_POST['accepteren']))
                $this->accepterenOpslaan();
            else if(isset($_POST['behandeld']))
                $this->behandeldOpslaan();
            
            $this->nogTeAccepteren();
            $this->inbehandeling();
        }
        
        function GetSidebarType()
        {
            return "wijziging";
        }
        
        //overige functions
        function nogTeAccepteren()
        {
            global $input, $page, $output;
            
            $query = "
                SELECT id, voornaam, tussenvoegsel, achternaam, inlognaam, datumindienst
                FROM `" . $page['settings']['locations']['db_prefix'] . "users`
                WHERE actief = 0
            ";
            
            $sth = $page['classes']['sql']->do_query($query,__LINE__,__FILE__);
            
            $counter = 0;
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                $time = strtotime($vars['datumindienst']);
                
                $vars['datumindienst'] = date("d-m-Y", $time);
                
                $output['accepteren'][$counter] = array(
                    "id" => $vars['id'],
                    "voornaam" => $vars['voornaam'],
                    "tussenvoegsel" => $vars['tussenvoegsel'],
                    "achternaam" => $vars['achternaam'],
                    "inlognaam" => $vars['inlognaam'],
                    "datumindienst" => $vars['datumindienst'],
                    "color" => $counter % 2
                );
                
                $queryvars2 = array($vars['id']);
                $query2 = "
                    select
                        a.afdeling
                    from
                        `" . $page['settings']['locations']['db_prefix'] . "afdelingen` a,
                        `" . $page['settings']['locations']['db_prefix'] . "user_afdelingen` ua
                    where
                        a.id = ua.afdeling_id
                    and
                        ua.user_id = ?
                ";
                
                $sth2 = $page['classes']['sql']->do_placeholder_query($query2,$queryvars2,__LINE__,__FILE__);
                
                $first = true;
                $temp = "";
                while($vars2 = $page['classes']['sql']->fetch_array($sth2))
                {
                    if($first){
                        $temp .= $vars2['afdeling'];
                        $first = false;
                    }
                    else
                        $temp .= "<br />" . $vars2['afdeling'];
                    
                }
                
                $output['accepteren'][$counter]['afdeling'] = $temp;
                
                $counter++;
            }
            
            $output['counter']['accepteren'] = count($output['accepteren']);
        }
        
        function inbehandeling()
        {
            $mktime = mktime(0,0,0, date("m"), (date("d")+7), date("Y"));
            
            global $input, $page, $output;
            
            $query = "
                SELECT id, voornaam, tussenvoegsel, achternaam, inlognaam, datumindienst as datumindienst
                FROM `" . $page['settings']['locations']['db_prefix'] . "users`
                WHERE actief = 1
            ";
            
            $sth = $page['classes']['sql']->do_query($query,__LINE__,__FILE__);
            
            $counterkort = -1;
            $counterlang = -1;
            
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                $time = strtotime($vars['datumindienst']);
                
                $vars['datumindienst'] = date("d-m-Y", $time);
                
                $array = array(
                    "id" => $vars['id'],
                    "voornaam" => $vars['voornaam'],
                    "tussenvoegsel" => $vars['tussenvoegsel'],
                    "achternaam" => $vars['achternaam'],
                    "inlognaam" => $vars['inlognaam'],
                    "datumindienst" => $vars['datumindienst']
                );
                
                $queryvars2 = array($vars['id']);
                $query2 = "
                    select
                        a.afdeling
                    from
                        `" . $page['settings']['locations']['db_prefix'] . "afdelingen` a,
                        `" . $page['settings']['locations']['db_prefix'] . "user_afdelingen` ua
                    where
                        a.id = ua.afdeling_id
                    and
                        ua.user_id = ?
                ";
                
                $sth2 = $page['classes']['sql']->do_placeholder_query($query2,$queryvars2,__LINE__,__FILE__);
                
                $first = true;
                $temp = "";
                while($vars2 = $page['classes']['sql']->fetch_array($sth2))
                {
                    if($first){
                        $temp .= $vars2['afdeling'];
                        $first = false;
                    }
                    else
                        $temp .= "<br />" . $vars2['afdeling'];
                    
                }
                
                $array['afdeling'] = $temp;
                
                if($mktime < strtotime($vars['datumindienst']))
                {
                    $output['userslang'][++$counterlang] = $array;
                    $output['userslang'][$counterlang]['color'] = $counterlang % 2;
                }
                else
                {
                    $output['userskort'][++$counterkort] = $array;
                    $output['userskort'][$counterkort]['color'] = $counterkort % 2;
                }
            }
            
            $output['counter']['userslang'] = count($output['userslang']);
            $output['counter']['userskort'] = count($output['userskort']);
            $output['counter']['totaal'] = $output['counter']['userslang'] + $output['counter']['userskort'];
        }
        
        function accepterenOpslaan()
        {
            global $input, $page, $output;
            
            foreach ($input['accept'] as $k => $v)
            {
                $queryvars = array($k);
                
                if($v == "ja")
                {
                    $query = "
                        update `" . $page['settings']['locations']['db_prefix'] . "users`
                        set actief = 1
                        where id = ?
                    ";
                }
                else if($v == "nee")
                {
                    $query = "
                        delete from `" . $page['settings']['locations']['db_prefix'] . "users`
                        where id = ?
                    ";
                }
                
                $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
            }
        }
        
        function behandeldOpslaan()
        {
            global $input, $page, $output;
            
            $first = true;
            $queryWhere = "";
            foreach($input['opslaan'] as $id)
            {
                if($first)
                {
                    $queryWhere = $id;
                }
                else
                    $queryWhere .= ", " . $id;
            }
            
            $query = "
                update " . $page['settings']['locations']['db_prefix'] . "users set
                actief = 2 where id in ($id);
            ";
            
            $page['classes']['sql']->do_query($query,__line__,__FILE__);
        }
    }
?>