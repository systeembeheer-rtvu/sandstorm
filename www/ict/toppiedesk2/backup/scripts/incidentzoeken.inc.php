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
            return array();
        }
        function NavigatieBalk(){}
        
        function CheckPage()
        {
            return 0;
        }
        
        function DoRun()
        {
            global $input, $page, $output;
            
            $output['redirect'] = $page['settings']['locations']['file'] ."?id=callzoeken";
            	}
        
        function GetSidebarType()
        {
            return "incident";
        }
    }
?>