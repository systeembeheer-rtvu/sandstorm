<?php
    $page['classes']['load'] = new configoverzicht();

    class configoverzicht
    {
        function GetFileName()
        {
            return "configoverzicht";
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
        }
        
        function GetSidebarType()
        {
            return "configuratie";
        }
    }
?>