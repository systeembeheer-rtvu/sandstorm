<?php
    $page['classes']['load'] = new contractoverzicht();

    class contractoverzicht
    {
        function GetFileName()
        {
            return "contractoverzicht";
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
            return "contract";
        }
    }
?>