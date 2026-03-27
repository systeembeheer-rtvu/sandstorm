<?php
    $page['classes']['load'] = new contractnieuw();

    class contractnieuw
    {
        function GetFileName()
        {
            return "contractnieuw";
        }
        
        function CheckPage()
        {
            return 0;
        }
        
        function NavigatieBalk()
        {
            global $input, $page, $output;
            
            $queryvars = array($input['searchoid']);
            $query = "
                SELECT id
                FROM " . $page['settings']['locations']['db_prefix'] . "contract
                WHERE id > ?
                AND actief = 0
                ORDER BY contractid DESC
                LIMIT 0,1
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query, $queryvars,__line__,__file__);
            $vars = $page['classes']['sql']->fetch_array($sth);
            $next = $vars['id'];
            
            $queryvars = array($input['searchoid']);
            $query = "
                SELECT id
                FROM " . $page['settings']['locations']['db_prefix'] . "contract
                WHERE id < ?
                AND actief = 0
                ORDER BY contractid ASC
                LIMIT 0,1
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query, $queryvars,__line__,__file__);
            $vars = $page['classes']['sql']->fetch_array($sth);
            $prev = $vars['id'];

            if($prev == null)
                $output["navbar"]["prev"] = "false";
            else
                $output["navbar"]["prev"] = $page['settings']['locations']['file'] . "?id=contractnieuw&searchoid=" . $prev; //waarde voor een vorig object
            
            if($next == null)
                $output["navbar"]["next"] = "false";
            else
                $output["navbar"]["next"] = $page['settings']['locations']['file'] . "?id=contractnieuw&searchoid=" . $next; //waarde voor een volgend object
            
            $output["navbar"]["new"] = "false";
            $output["navbar"]["save"] = "false";
            $output["navbar"]["mail"] = "false";
            $output["navbar"]["search"] = "";
            $output["navbar"]["archive"] = ""; //waarde voor een nieuw object
            $output['navbar']['autocomplete'] = "";
            $output['navbar']['id'] = "contractnieuw";
        }
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "searchoid" => array("searchoid","get",""),
                    "oid" => array("oid","post",""),
                    "contractnummer" => array("contractnummer","post", ""),
                    "begindatum" => array("begindatum", "post", ""),
                    "einddatum" => array("einddatum", "post", ""),
                    "contracttype" => array("contracttype", "post", "int"),
                    "leverancier" => array("leverancier", "post", "int"),
                    "opmerking" => array("opmerking", "post", "")
                )
            );
        }
        
        function DoRun()
        {
            global $input, $page, $output;
            
            LoadLeveranciers(true);
            LoadContracttype(true);
            
            
            
            if(isset($_POST['submit']))
                $this->Opslaan();
            else if($input['searchoid'] != "")
                $this->ContractWeergeven();
        }
        
        function GetSidebarType()
        {
            return "contract";
        }
        
        //overige functions
        
        function ContractWeergeven()
        {
            global $input, $page, $output;
            
            $queryvars = array($input['searchoid']);
            $query = "
                Select
                    contractid,
                    begindatum,
                    einddatum,
                    contracttype,
                    leverancier,
                    opmerking,
                    actief
                FROM
                    " . $page['settings']['locations']['db_prefix'] . "contract
                where
                    id = ?
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
            
            $vars = $page['classes']['sql']->fetch_array($sth);
            
            $output['contract']['id'] = $input['searchoid'];
            $output['contract']['contractid'] = $vars['contractid'];
            $output['contract']['begindatum'] = date("d-m-Y",strtotime($vars['begindatum']));
            $output['contract']['einddatum'] = date("d-m-Y",strtotime($vars['einddatum']));
            $output['contract']['contracttype'] = $vars['contracttype'];
            $output['contract']['leverancier'] = $vars['leverancier'];
            $output['contract']['opmerking'] = $vars['opmerking'];
            $output['contract']['actief'] = $vars['actief'];
        }
        
        function Opslaan()
        {
            global $input, $page, $output;
            
            $input['begindatum'] = date("Y-m-d", strtotime($input['begindatum']));
            $input['einddatum'] = date("Y-m-d", strtotime($input['einddatum']));
            
            if($input['oid'] != "")
            {
                $queryvars = array(
                    $input['contractnummer'],
                    $input['begindatum'],
                    $input['einddatum'],
                    $input['contracttype'],
                    $input['leverancier'],
                    $input['opmerking'],
                    $input['oid']
                );
                $query = "
                    update " . $page['settings']['locations']['db_prefix'] . "contract
                    set contractid=?, begindatum=?, einddatum=?, contracttype=?, leverancier=?, opmerking=?
                    where id=?
                ";
                
                $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
            }
            else
            {
                $queryvars = array(
                    $input['contractnummer'],
                    $input['begindatum'],
                    $input['einddatum'],
                    $input['contracttype'],
                    $input['leverancier'],
                    $input['opmerking']
                );
                
                $query = "
                    insert into " . $page['settings']['locations']['db_prefix'] . "contract (contractid,begindatum, einddatum, contracttype, leverancier, opmerking)
                    values(?, ?, ?, ?, ?, ?)
                ";
                
                $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
            }
        }
        
        function LoadLists()
        {
            /*$queryvars = array();
            $query = "
                select....
                from " . $page['settings']['locations']['db_prefix'] . "hardware
                
            ";*/
        }
    }
?>