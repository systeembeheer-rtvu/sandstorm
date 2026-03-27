<?php
    $page['classes']['load'] = new Settings();

    class Settings
    {
        function GetFileName()
        {
            return "settings";
        }
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "id" => array("id","get","int")
                )
            );
        }
        
        function CheckPage()
        {
            return 0;
        }
        
        function NavigatieBalk(){}
        
        function DoRun()
        {
            global $input, $page, $output;
            
            LoadAfdelingen();
            Loadbehandelaars(false);
            LoadCategorieen(false);
            LoadStatus(false);
            
            
            
        }
        
        function GetSidebarType()
        {
            return "settings";
        }
    }
?>