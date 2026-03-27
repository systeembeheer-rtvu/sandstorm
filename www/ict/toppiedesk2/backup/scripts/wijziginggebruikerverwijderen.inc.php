<?php
    $page['classes']['load'] = new wijziginggebruikerverwijderen();

    class wijziginggebruikerverwijderen
    {
        function GetFileName()
        {
            return "wijziginggebruikerverwijderen";
        }
        
        function CheckPage()
        {
            return 0;
        }
        
        function NavigatieBalk(){}
        
        function GetVars()
        {
            return array(
                "input" => array()
            );
        }
        
        function DoRun()
        {
            global $input, $page, $output;
            
            $mktime = mktime(0,0,0, date("m"), (date("d")+1), date("Y"));
            
            $queryvars = array(date("Y-m-d",$mktime) . " 00:00:00");
            $query = "
                SELECT
                    uu.id,
                    uu.voornaam,
                    uu.tussenvoegsel,
                    uu.achternaam,
                    uu.inlognaam,
                    UNIX_TIMESTAMP(uu.einddatum) as einddatum,
                    a.afdeling
                    
                FROM
                    " . $page['settings']['locations']['db_prefix'] . "ua_users uu,
                    " . $page['settings']['locations']['db_prefix'] . "afdelingen a
                WHERE
                    uu.afdeling = a.id
                AND
                    einddatum < ?
                AND
                   (uu.actie = 'verwijderen' AND archief = 0
                OR(
                    uu.actie = 'beide' AND archief = 1
                ))
            ";
            $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
            
            $counter = 0;
            
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                $output['users'][$counter++] = array(
                    'id' => $vars['id'],
                    'voornaam' => $vars['voornaam'],
                    'tussenvoegsel' => $vars['tussenvoegsel'],
                    'achternaam' => $vars['achternaam'],
                    'inlognaam' => $vars['inlognaam'],
                    'einddatum' => date("d-m-Y", $vars['einddatum']),
                    'afdeling' => $vars['afdeling']
                );
            }
        }
        
        function GetSidebarType()
        {
            return "wijziging";
        }
    }
?>