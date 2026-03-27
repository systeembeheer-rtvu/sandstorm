<?php
    $page['classes']['load'] = new wijzigingsOverzicht();

    class wijzigingsOverzicht
    {
        function GetFileName()
        {
            return "wijzigingsoverzicht";
        }
        
        function CheckPage()
        {
            return 0;
        }
        
        function NavigatieBalk()
        {}
        
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
            return "wijziging";
        }
    }
?>