<?php
    $page['classes']['load'] = new Error();

    class Error
    {
        function GetFileName()
        {
            global $tracer;
	    $tracer .= "- Error/GetFileName()<br />";
            
            return "error";
        }
        
        function GetVars()
        {
            return array(
                "input" => array()
            );
        }
        
        function NavigatieBalk(){}
        
        function DoRun()
        {
            global $tracer;
	    $tracer .= "- Error/DoRun()<br />";
            
            global $output;
            $output['info'] = "pagina kan niet worden gevonden";
        }
        
        function CheckPage()
        {
            return 0;
        }
        
        function GetSidebarType()
        {
            global $tracer;
	    $tracer .= "- Error/GetSidebarType()<br />";
            
            return "";
        }
    }
?>