<?php
    $page['classes']['load'] = new Wijziging();

    class Wijziging
    {
        function GetFileName()
        {
            global $tracer, $page, $output;
	    $tracer .= "- Wijziging/GetFileName()<br />";
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
            global $tracer, $page, $output;
	    $tracer .= "- Wijziging/DoRun()<br />";
            
            $output['redirect'] = $page['settings']['locations']['file'] ."?id=wijzigingsoverzicht";
        }
        
        function GetSidebarType()
        {
            global $tracer;
	    $tracer .= "- Wijziging/GetSidebarType()<br />";
            
            return "";
        }
    }
?>