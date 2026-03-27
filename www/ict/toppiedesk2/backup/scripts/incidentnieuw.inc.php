<?php
    $page['classes']['load'] = new IncidentNieuw();
    class IncidentNieuw
    {
        function GetFileName()
        {
            return "incidentnieuw";
        }
        
        function CheckPage()
        {
            return 0;
        }
        
        function NavigatieBalk()
        {
            
        }
        
        function GetVars()
        {
            return array(
                "input" => array(
                )
            );
        }
        
        function DoRun()
        {
            global $input, $page, $output;
            
            $output['redirect'] = $page['settings']['locations']['file'] ."?id=callnieuw";
        }
        
        function GetSidebarType()
        {
            return "incident";
        }
    }
?>