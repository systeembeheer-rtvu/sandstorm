<?php
    $page['classes']['load'] = new configcontract();

    class configcontract
    {
        function GetFileName()
        {
           
        }
        
        function CheckPage()
        {
            return 0;
        }
        
        function NavigatieBalk(){}
        
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
            
            $output['redirect'] = $page['settings']['locations']['file'] ."?id=projectoverzicht";
        }
        
        function GetSidebarType()
        {
            return "project";
        }
    }
?>