<?php
    $page['classes']['load'] = new Incident();
    class Incident
    {
        function GetFileName()
        {
            global $tracer, $page, $output;
	    $tracer .= "- Incident/GetFileName()<br />";
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
	    $tracer .= "- Incident/DoRun()<br />";
            
            $output['redirect'] = $page['settings']['locations']['file'] ."?id=calloverzicht";
        }
        
        function GetSidebarType()
        {
            global $tracer;
	    $tracer .= "- Incident/GetSidebarType()<br />";
            
            return "";
        }
    }
?>