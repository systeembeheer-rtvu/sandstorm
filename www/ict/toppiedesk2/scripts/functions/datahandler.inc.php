<?php
    class DataHandler
    {
	private $loadScript = false;
	private $fileSet = false;
	
        function DataInput()
        {
            global $input, $page, $tracer, $output;
            $tracer .= "- DataHandler/DataInput()<br />";
            
	    if(isset($_COOKIE['prevpage']) && $_COOKIE['prevpage'] != "")
		$page['prevpage'] = $_COOKIE['prevpage'];
	    else
		$page['prevpage'] = "";
	    
            $page['scriptname'] = "";
            
            if(isset($_GET['id']))
		$page['scriptname'] = $_GET['id'];
	    else
                $page['scriptname'] = $page['settings']['locations']['default_site']['content'];
            
            if(file_exists("scripts/". $page['scriptname'] . ".inc.php"))
                include("scripts/" . $page['scriptname'] . ".inc.php");
	    else
                include($page['root'] . "scripts/error.inc.php");
	    
	    //$page['settings']['locations']['default_site']['content'] = $page['scriptname'];
	    
	    if($page['classes']['load']->CheckPage() == 1 && $page['classes']['security']->CheckId() == 0)
		$this->SetError("Geen toegang");
	    
	    if(file_exists("js/script/". $page['scriptname'] . ".js"))
		$output['script'] = "<script type=\"text/javascript\" src=\"js/script/". $page['scriptname'] .  ".js\"></script>";
	    
	    $in = array();
	    $init['input'] = $this->array_get($page['classes']['load']->GetVars(),'input', array());
	    
	    if (is_array($init['input']))
	    {
		foreach($init['input'] as $k => $v)
		{
		    if (count($v) == 4)
			$input[$k] = $page['classes']['sanitizer']->SanitizeInput($this->get_input($v['0'],$v['1'],$v['2'], $v['3']));
		    else
			$input[$k] = $page['classes']['sanitizer']->SanitizeInput($this->get_input($v['0'],$v['1'],$v['2'], ''));
		} // end foreach
	    } // end if
        }
	
	///////////////////
	
	function array_get($arr, $key, $default = false)
	{
	    if (is_array($arr) && array_key_exists($key, $arr) && !is_null($arr[$key]))
		return $arr[$key];
	    else
		return $default;
	}
	
	function get_input($name = "", $type = "", $validate = "", $default = "")
	{
	    // Special case:
	    if (is_array($validate) && !is_array($default))
		$default = array();
	    
	    switch ($type)
	    {
		case "both":
		    return $this->ubbt_validate($validate, $this->array_get($_GET, $name, $this->array_get($_POST, $name, $default)));
	        case "get":
    		    return $this->ubbt_validate($validate, $this->array_get($_GET, $name, $default));
		case "post":
		    return $this->ubbt_validate($validate, $this->array_get($_POST, $name, $default));
		case "cookie":
		    return $this->ubbt_validate($validate, $this->array_get($_COOKIE, $name, $default));
		case "session":
		    return $this->array_get($_SESSION, $name, $default);
		default:
		    return $default;
	    }
	}
	
	function ubbt_validate($validate, $value)
	{
	    if (is_array($value))
	    {
		$return_array = array();
		
		foreach ($value as $k => $v)
		{
		    $return_array[$k] = $this->ubbt_validate($validate, $v);
		}
		
		return $return_array;
	    }
	    
	    if (is_scalar($value))
	    {
		if (is_array($validate))
		    return (in_array($value, $validate) ? $value : "");
		else
		{
		    switch ($validate)
		    {
			case "int":
			    return preg_replace("/[^\d\.\-]/", "", $value) + 0;
			case "alpha":
			    return preg_replace("/[^A-Za-z\s\-_]/", "", $value);
			case "alphanum":
			    return preg_replace("/[^A-Za-z0-9\s\-_]/", "", $value);
			default:
			    return $value;
		    }
		}
	    }
	}
	
	///////////////////////////
	
	function Run()
	{
	    global $page, $tracer;
	    $tracer .= "- DataHandler/Run()<br />";
	    
	    try
	    {
		if(isset($page['classes']['load']))
		    $page['classes']['load']->DoRun();
		else
		    $this->SetError("De classe kan niet worden aangeroepen");
	    }
	    catch(Exception $ex)
	    {
		$this->SetError($ex->getMessage());
	    }
	}
        
        function DataOutput()
        {   
            global $output, $page, $tracer;
            $tracer .= "- DataHandler/DataOutput()<br />";
	    
	    if(isset($output['redirect']))
	    {
		//Controlle op alle debug values
		$redirect = true;
		foreach($page['settings']['debug'] as $value)
		{
		    if($value == 1)
			$redirect = false;
		}
		
		if($redirect)
		    //Normale mode - directe redirect
		    header("location:" . $output['redirect']);
		else
		    //Debug mode - redirect door te klikken op een link
		    $this->SetError("Debug mode: klikt <a href=\"". $output['redirect'] . "\">hier</a> om verder te gaan");
	    }
            else
	    {
		$page['classes']['load']->NavigatieBalk();
		
		//haalt de naam op van de tpl file die nodig is
		if(isset($page['classes']['load']))
		    $this->SetFile($page['classes']['load']->GetFileName());
	    }
	    
	    if($page['classes']['load']->GetSidebarType() == "configuratie")
		$output["currentTab"] = "Configuratie";
	    else if($page['classes']['load']->GetSidebarType() == "contract")
		$output["currentTab"] = "Contract";
	    else if($page['classes']['load']->GetSidebarType() == "incident")
		$output["currentTab"] = "Call";
	    else if($page['classes']['load']->GetSidebarType() == "wijziging")
		$output["currentTab"] = "Wijziging";
	    else if($page['classes']['load']->GetSidebarType() == "project")
		$output["currentTab"] = "Project";
	    
	    if(isset($page['classes']['load']))
		$page['classes']['links']->LoadLinks($page['classes']['load']->GetSidebarType());
	    else
		$page['classes']['links']->LoadLinks();
	    
	    $output['titles'] = array(
		'header' => $page['settings']['titles']['header'],
		'page' => $page['settings']['titles']['page']
	    );
        }
	
	function SetError($value)
	{
	    global $tracer, $output;
	    $tracer .= "- DataHandler/SetError()<br />";
	    
	    $this->SetFile("error");
	    $output['info'] = $value;
	    $this->fileSet = true;
	}
	
	function SetFile($value)
	{
	    global $page;
	    
	    if(!$this->fileSet)
	    {
		if(file_exists("templates/default/" . $value . ".tpl"))
		{
		    $page['settings']['locations']['default_site']['content'] = $value;
		    $this->fileSet = true;
		}
		else
		    $this->SetError(".tpl file bestaat niet.");
	    }
	}
        
	//Toont alle website onderdelen.
        function Show()
        {
            global $output, $page, $tracer;
            
	    $tracer .= "- DataHandler/Show()<br />";
            $tracer .= "<br />***End tracing***";
	    
	    if(!isset($_COOKIE['prevpage']) || $page['scriptname'] != $_COOKIE['prevpage'])
		setcookie('prevpage', $page['scriptname']);
	    
            $page['classes']['smarty']->assign("output", $output);
            
	    if($page['settings']['debug']['tracer'] == 1)
		echo $tracer;
	    
            $page['classes']['smarty']->display("{$page['settings']['locations']['default_site']['header']}.tpl");
            $page['classes']['smarty']->display("{$page['settings']['locations']['default_site']['sidebar']}.tpl");
            $page['classes']['smarty']->display("{$page['settings']['locations']['default_site']['content']}.tpl");
            $page['classes']['smarty']->display("{$page['settings']['locations']['default_site']['footer']}.tpl");
        }
    }
?>