<?php
    $page['classes']['load'] = new configedithardwaretype();
    
    class configedithardwaretype
    {
        function GetFileName()
        {
            return "configedithardwaretype";
        }
        
        function CheckPage()
        {
            return 0;
        }
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "oid" => array("oid","get",""),
                    "searchoid" => array("searchoid","get",""),
                    "hardwaretype" => array("hardwaretype", "get", "")
                )
            );
        }
        
        function NavigatieBalk()
        {
            global $input, $page, $output;
            
            $output["navbar"]["new"] = $page['settings']['locations']['file'] . "?id=confighardwarekaart"; //waarde voor een nieuw object
            $output["navbar"]["save"] = ""; //waarde voor het opslaan van een object
            $output["navbar"]["prev"] = "false"; //waarde voor een vorig object
            $output["navbar"]["next"] = "false"; //waarde voor een volgend object
            $output["navbar"]["archive"] = ""; //waarde voor een nieuw object
            $output['navbar']['autocomplete'] = "hardware";
            $output['navbar']['id'] = "configedithardwaretype";
        }
        
        function DoRun()
        {
            global $input, $page, $output;
        }
        
        function GetSidebarType()
        {
            return "configuratie";
        }
    }
?>