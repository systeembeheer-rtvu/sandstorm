<?php
    $page['classes']['load'] = new User();

    class User
    {
        function GetFileName()
        {
            global $tracer;
	    $tracer .= "- User/GetFileName()<br />";
	    
	    return "user";
        }
        
        function GetVars()
        {
            return array(
                "input" => array(
		    "searchoid" => array("searchoid", "get", ""),
		    "voornaam" => array("voornaam", "post", ""),
		    "tussenvoegsel" => array("tussenvoegsel", "post", ""),
		    "tussenvoegselafk" => array("tussenvoegselafk", "post", ""),
		    "achternaam" => array("achternaam", "post", ""),
		    "inlognaam" => array("inlognaam", "post", ""),
		    "adres" => array("adres", "post", ""),
		    "postcode" => array("postcode", "post", ""),
		    "plaats" => array("plaats", "post", ""),
		    "gebdat" => array("gebdat", "post", ""),
		    "datumindienst" => array("datumindienst", "post", ""),
		    "actief" => array("actief", "post", "")
		)
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
	    $tracer .= "- User/DoRun()<br />";
	    
	    if(isset($_POST['submit']))
		$this->opslaan();
	    
	    $this->userweergeve();
	    
	    $output['prevpage'] = $page['prevpage'];
        }
        
        function GetSidebarType()
        {
            global $tracer;
	    $tracer .= "- User/GetSidebarType()<br />";
            
            return "";
        }
	
	//overige function
	
	function userweergeve()
	{
	    global $input, $page, $output;
	    
	    $queryvars = array($input['searchoid']);
	    $query = "
		SELECT
		    voornaam,
		    tussenvoegsel,
		    tussenvoegselafk,
		    achternaam,
		    inlognaam,
		    adres,
		    postcode,
		    plaats,
		    UNIX_TIMESTAMP(gebdat) as gebdat,
		    UNIX_TIMESTAMP(datumindienst) as datumindienst,
		    actief
		FROM
		    " . $page['settings']['locations']['db_prefix'] . "users
		WHERE
		    id = ?
	    ";
	    
	    $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
	    
	    $vars = $page['classes']['sql']->fetch_array($sth);
	    
	    $output['searchoid'] = $input['searchoid'];
	    $output['user']['voornaam'] = $vars['voornaam'];
	    $output['user']['tussenvoegsel'] = $vars['tussenvoegsel'];
	    $output['user']['tussenvoegselafk'] = $vars['tussenvoegselafk'];
	    $output['user']['achternaam'] = $vars['achternaam'];
	    $output['user']['inlognaam'] = $vars['inlognaam'];
	    $output['user']['adres'] = $vars['adres'];
	    $output['user']['postcode'] = $vars['postcode'];
	    $output['user']['plaats'] = $vars['plaats'];
	    $output['user']['gebdat'] = date("d-m-Y", $vars['gebdat']);
	    $output['user']['datumindienst'] = date("d-m-Y", $vars['datumindienst']);
	    $output['user']['actief'] = $vars['actief'];
	}
	
	function opslaan()
	{
	    global $input, $page, $output;
	    
	    $naam = $input['naam'] . " " . $input['tussenvoegsel'] . " " . $input['achternaam'];
	    
	    $inlognaam = $this->CreateLoginName();
	    
	    $queryvars = array(
		$naam,
		$input['voornaam'],
		$input['tussenvoegsel'],
		$input['tussenvoegselafk'],
		$input['achternaam'],
		$inlognaam,
		$input['adres'],
		$input['postcode'],
		$input['plaats'],
		date("Y-m-d", strtotime($input['gebdat'])),
		date("Y-m-d", strtotime($input['datumindienst'])),
		$input['actief'],
		$input['searchoid']
	    );
	    
	    $query = "
		update " . $page['settings']['locations']['db_prefix'] . "users
		set
		    naam=?,
		    voornaam=?,
		    tussenvoegsel=?,
		    tussenvoegselafk=?,
		    achternaam=?,
		    inlognaam=?,
		    adres=?,
		    postcode=?,
		    plaats=?,
		    gebdat=?,
		    datumindienst=?,
		    actief=?
		where
		    id=?
	    ";
	    
	    $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
	}
	
	function CreateLoginName()
	{
	    global $input, $page, $output;
	    
	    $inlognaam = $input['inlognaam'];
	    
	    $queryvars = array($inlognaam, $input['searchoid']);
            $query = "
                select naam
                from " . $page['settings']['locations']['db_prefix'] . "users
                where inlognaam = ?
		and id != ?
            ";
            
            $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
            $aantal = $page['classes']['sql']->total_rows($sth);
            
            if($aantal > 0)
            {
                for($i = 2; $i < 10; $i++)
                {
                    $inlognaam = substr_replace($inlognaam, $i,-1,1);
                    
                    $queryvars = array($inlognaam);
                    $query = "
                        select naam
                        from " . $page['settings']['locations']['db_prefix'] . "users
                        where inlognaam = ?
                    ";
                    
                    $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                    $aantal = $page['classes']['sql']->total_rows($sth);
                    
                    if($aantal == 0)
                        break;
                }
            }
            
            return $inlognaam;
	}
    }
?>