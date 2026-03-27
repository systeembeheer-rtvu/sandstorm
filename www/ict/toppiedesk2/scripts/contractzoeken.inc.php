<?php
    $page['classes']['load'] = new contractzoeken();

    class contractzoeken
    {
        function GetFileName()
        {
            return "contractzoeken";
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