<?php
    $page['classes']['load'] = new configleverancier();

    class configleverancier
    {
        function GetFileName()
        {
            return "configleverancier";
        }
        
        function CheckPage()
        {
            return 0;
        }
        
        function NavigatieBalk()
        {
            global $input, $page, $output;
            
            $oid = $input['searchoid'];
            
            if($oid == "")
            {
                $oid = 0;
            }
            
            $queryvars = array($oid);
            $query = "
                SELECT id
                FROM " . $page['settings']['locations']['db_prefix'] . "leverancier
                WHERE id > ?
                ORDER BY leverancier DESC
                LIMIT 0,1
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query, $queryvars,__line__,__file__);
            $vars = $page['classes']['sql']->fetch_array($sth);
            $next = $vars['id'];
            
            $queryvars = array($oid);
            $query = "
                SELECT id
                FROM " . $page['settings']['locations']['db_prefix'] . "leverancier
                WHERE id < ?
                ORDER BY leverancier ASC
                LIMIT 0,1
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query, $queryvars,__line__,__file__);
            $vars = $page['classes']['sql']->fetch_array($sth);
            $prev = $vars['id'];
            
            $output["navbar"]["new"] = $page['settings']['locations']['file'] . "?id=configleverancier"; //waarde voor een nieuw object
            $output["navbar"]["save"] = "false"; //waarde voor het opslaan van een object
            
            if($prev == null)
                $output["navbar"]["prev"] = "false";
            else
                $output["navbar"]["prev"] = $page['settings']['locations']['file'] . "?id=configleverancier&searchoid=" . $prev; //waarde voor een vorig object
            
            if($next == null)
                $output["navbar"]["next"] = "false";
            else
                $output["navbar"]["next"] = $page['settings']['locations']['file'] . "?id=configleverancier&searchoid=" . $next; //waarde voor een volgend object
            
            $output["navbar"]["archive"] = ""; //waarde voor een nieuw object
            $output["navbar"]["mail"] = "false";
            $output['navbar']['autocomplete'] = "";
            $output['navbar']['id'] = "configleverancier";
        }
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "searchoid" => array("searchoid","get","alphanum")
                )
            );
        }
        
        function DoRun()
        {
            global $input, $page, $output;
            
            if (preg_match('/\d+/', $input['searchoid']) && $input['searchoid'] > 0)
            {
                $queryvars = array($input['searchoid']);
                $query = "
                    SELECT
                        id,
                        leverancier,
                        klantnummer,
                        contactpersoon,
                        telefoonnummer
                    FROM
                       " . $page['settings']['locations']['db_prefix'] . "leverancier
                    WHERE
                        id = ?
                ";
                
                $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__line__,__file__);
                
                $vars = $page['classes']['sql']->fetch_array($sth);
                
                $output['leverancier']['id'] = $vars['id'];
                $output['leverancier']['leverancier'] = $vars['leverancier'];
                $output['leverancier']['klantnummer'] = $vars['klantnummer'];
                $output['leverancier']['contactpersoon'] = $vars['contactpersoon'];
                $output['leverancier']['telefoonnummer'] = $vars['telefoonnummer'];
            }
            else if(preg_match('/.+/', $input['searchoid']))
            {
                $queryvars = array($input['searchoid'] . "%");
                $query = "
                    SELECT
                        id,
                        leverancier,
                        klantnummer,
                        contactpersoon,
                        telefoonnummer
                    FROM
                        " . $page['settings']['locations']['db_prefix'] . "leverancier
                    WHERE
                        leverancier LIKE ?
                ";
                
                $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__line__,__file__);
                
                $vars = $page['classes']['sql']->fetch_array($sth);
                
                $output['leverancier']['id'] = $vars['id'];
                $output['leverancier']['leverancier'] = $vars['leverancier'];
                $output['leverancier']['klantnummer'] = $vars['klantnummer'];
                $output['leverancier']['contactpersoon'] = $vars['contactpersoon'];
                $output['leverancier']['telefoonnummer'] = $vars['telefoonnummer'];
                
                $input['searchoid'] = $vars['id'];
                $this->NavigatieBalk();
            }
            
            
        }
        
        function GetSidebarType()
        {
            return "configuratie";
        }
    }
?>