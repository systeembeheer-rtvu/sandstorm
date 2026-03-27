<?php
    $page['classes']['load'] = new IncidentOverzicht();

    class IncidentOverzicht
    {
        function GetFileName()
        {
            return "incidentoverzicht";
        }
        
        function GetVars()
        {
            return array(
                "input" => array()
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
            
            $output['redirect'] = $page['settings']['locations']['file'] ."?id=calloverzicht";
        }
        
        function GetSidebarType()
        {
            return "incident";
        }
    }
?>