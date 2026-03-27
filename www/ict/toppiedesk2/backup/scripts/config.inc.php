<?php
    $page['classes']['load'] = new Config();

    class Config
    {
        function GetFileName()
        {
            global $tracer;
	    $tracer .= "- Config/GetFileName()<br />";
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
	    $tracer .= "- Config/DoRun()<br />";
            
            $output['redirect'] = $page['settings']['locations']['file'] ."?id=configoverzicht";
        }
        
        function GetSidebarType()
        {
            global $tracer;
	    $tracer .= "- Config/GetSidebarType()<br />";
            
            return "";
        }
    }
?>