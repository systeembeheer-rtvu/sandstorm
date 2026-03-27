<?php
    $page['classes']['load'] = new Incidentprint();
    class Incidentprint
    {
        function GetFileName()
        {
            global $tracer;
	    $tracer .= "- Incidentprint/GetFileName()<br />";
	    
	    return "incidentprint";
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
            global $tracer, $input, $page, $output;
	    
	    $output['redirect'] = $page['settings']['locations']['file'] ."?id=callprint";
	}
    }
?>