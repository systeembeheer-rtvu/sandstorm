<?php
    $page['classes']['load'] = new contract();

    class contract
    {
        function GetFileName()
        {
            global $tracer, $page, $output;
	    $tracer .= "- contract/GetFileName()<br />";
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
	    $tracer .= "- contract/DoRun()<br />";
            
            $output['redirect'] = $page['settings']['locations']['file'] ."?id=contractoverzicht";
        }
        
        function GetSidebarType()
        {
            global $tracer;
	    $tracer .= "- contract/GetSidebarType()<br />";
            
            return "";
        }
    }
?>