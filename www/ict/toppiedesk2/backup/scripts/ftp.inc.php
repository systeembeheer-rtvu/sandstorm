<?php
    $page['classes']['load'] = new ftp();

    class ftp
    {
        private $sql;
        
        function __construct()
        {
            global $global_ftp;
            
            $this->sql = new sql();
            $this->sql->connect2(
                $global_ftp['DATABASE_SERVER'],
                $global_ftp['DATABASE_USER'],
                $global_ftp['DATABASE_PASSWORD'],
                $global_ftp['DATABASE_NAME']
            );
        }
        
        function GetFileName()
        {
            global $tracer;
	    $tracer .= "- ftp/GetFileName()<br />";
            
            return "ftp";
        }
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "searchoid" => array("searchoid","get",""),
		    "comment" => array("comment", "post", ""),
		    "verloopdat" => array("verloopdat", "post", ""),
		    "password" => array("password", "post", ""),
		    "verlopen" => array("verlopen", "post", "")
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
	    $tracer .= "- ftp/DoRun()<br />";
            
            if(isset($_POST['submit']) && $_POST['submit'] == "Opslaan")
                $this->Opslaan();
	    else if(isset($_POST['opschonen']) && $_POST['opschonen'] == "Verwijderen")
		$this->Opschonen();
            
            $this->Weergeven();
        }
        
        function GetSidebarType()
        {
            global $tracer;
	    $tracer .= "- ftp/GetSidebarType()<br />";
            
            return "";
        }
        
        //overige functions
        function Opslaan()
        {
            global $input, $page, $output;
	    
	    $verloopdat = date("Y-m-d", strtotime($input['verloopdat']));
	    
	    if($input['verlopen'] == "on")
	    {
		$verlopen = 0;
		$verloopdat = "0000-00-00";
	    }
	    else
	    {
		$verlopen = 1;
		
		if($verloopdat == "")
		{
		    $verloopdat = "0000-00-00";
		}
	    }
	    
	    $queryvars = array($input['comment'], $verloopdat, $verlopen);
	    $query = "
		update users set comment=?, verloopdatum=?, kanverlopen=?
	    ";
	    
	    if(isset($input['password']) && $input['password'] != "")
            {
                $queryvars[count($queryvars)] = $input['password'];
                $query .= ", password=?";
            }
	    
	    $queryvars[count($queryvars)] = $input['searchoid'];
	    $query .= " where user = ?";
	    
	    $this->sql->do_placeholder_query($query,$queryvars,__line__,__file__);
	    
	    $output['redirect'] = $page['settings']['locations']['file'] ."?id=wijzigingftpaccountbeheer";
        }
        
        function Opschonen()
        {
            global $input, $page, $output;
	    
	    $password = createPassword(8);
	    $password = md5($password);
	    
	    $queryvars = array($password, $input['searchoid']);
	    $query = "
		update users set verloopdatum='1900-01-01', kanverlopen=1, password=? where user=?
	    ";
	    
	    $this->sql->do_placeholder_query($query,$queryvars,__line__,__file__);
	    
	    $output['redirect'] = $page['settings']['locations']['file'] ."?id=wijzigingftpaccountbeheer";
        }
        
        function Weergeven()
        {
            global $input, $page, $output;
            
            $queryvars = array($input['searchoid']);
            $query = "
                SELECT
                    dir,
                    comment,
                    verloopdatum,
                    kanverlopen,
		    AangevraagdDoor
                FROM users
                where user = ?
            ";
            
            $sth = $this->sql->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
            $vars = $this->sql->fetch_array($sth);
            
            $verloopdatum = date("d-m-Y", strtotime($vars['verloopdatum']));
            
            if($verloopdatum == "30-11--0001")
                $verloopdatum = "";
            
            $output['ftp'] = array
	    (
                'user' => $input['searchoid'],
                'dir' => $vars['dir'],
                'comment' => $vars['comment'],
                'verloopdatum' => $verloopdatum,
                'kanverlopen' => $vars['kanverlopen'],
		'AangevraagdDoor' => $vars['AangevraagdDoor']
            );
        }
    }
?>