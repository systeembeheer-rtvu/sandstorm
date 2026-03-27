<?php
    $page['classes']['load'] = new Home();

    class Home
    {
        function GetFileName()
        {
            return "home";
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
            return "user";
        }
    }
?>