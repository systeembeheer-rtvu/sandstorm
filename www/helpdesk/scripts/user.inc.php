<?php
    $page['classes']['load'] = new User();

    class User
    {
        function GetFileName()
        {
            /*if(isset($_GET['status']))
                return "bedankt";*/
            return "user";
        }
        
        function CheckPage()
        {
            return 1;
        }
        
        function NavigatieBalk()
        {}
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "voornaam" => array("voornaam","post","alpha"),
                    "tussenvoegsel" => array("tussenvoegsel", "post", "alpha"),
                    "achternaam" => array("achternaam", "post", "alpha"),
                    "adres" => array("adres", "post", "alphanum"),
                    "postcode" => array("postcode", "post", "alphanum"),
                    "plaats" => array("plaats", "post", "alpha"),
                    "gebdat" => array("gebdat", "post", "alphanum"),
                    "begindatum" => array("begindatum", "post", "alphanum"),
                    "afdeling" => array("afdeling", "post", "int")
                )
            );
        }
        
        function DoRun()
        {
            global $input, $page, $output;
            
            if(isset($_POST['submit']))
            {
                $naam = $input['voornaam'];
                
                if($input['tussenvoegsel'] != "")
                {
                    $naam .= " " . $input['tussenvoegsel'];
                }
                
                $naam .= " " . $input['achternaam'];
                
                if(
                   $input['voornaam'] != "" &&
                   $input['achternaam'] != "" &&
                   $input['adres'] != "" &&
                   $input['postcode'] != "" &&
                   $input['plaats'] != "" &&
                   $input['gebdat'] != "" &&
                   $input['begindatum'] != "" &&
                   $input['afdeling'] > 0 &&
                   $this->Checkdata()
                )
                {
                    $queryvars = array($input['voornaam'], $input['achternaam']);
                    $query = "
                        select naam
                        from " . $page['settings']['locations']['db_prefix'] . "users
                        where voornaam = ?
                        and achternaam = ?
                        and actief = 3
                    ";
                    
                    if($input['tussenvoegsel'] != "")
                    {
                        $queryvars[count($queryvars)] = $input['tussenvoegsel'];
                        $query .= " AND tussenvoegsel = ?";
                    }
                    
                    $gebdat = strtotime($input['gebdat']);
                    $begindatum = strtotime($input['begindatum']);
                    
                    $sth = $page['classes']['sql']-> do_placeholder_query($query,$queryvars,__line__,__file__);
                    
                    if($page['classes']['sql']->total_rows($sth) == 0)
                    {
                        $naam = $input['voornaam'];
                        
                        if($input['tussenvoegsel'] != "")
                        {
                            $naam .= " " . $input['tussenvoegsel'];
                        }
                        
                        $naam .= " " . $input['achternaam'];
                        
                        if(strlen($input['tussenvoegsel']) > 6)
                        {
                            $afkorting = "";
                            
                            $words = split(" ", $input['tussenvoegsel']);
                            foreach($words as $word)
                            {
                                $afkorting .= substr($word,0,1);
                            }   
                        }
                        else
                            $afkorting = $input['tussenvoegsel'];
                        
                        $inlognaam = $this->CreateLoginName();
                        
                        $queryvars = array(
                            $naam,
                            $input['voornaam'],
                            $input['tussenvoegsel'],
                            $afkorting,
                            $input['achternaam'],
                            $inlognaam,
                            $input['adres'],
                            $input['postcode'],
                            $input['plaats'],
                            date("Y-m-d",$gebdat),
                            date("Y-m-d",$begindatum)
                        );
                        
                        $query = "insert into " . $page['settings']['locations']['db_prefix'] . "users (
                                naam,
                                voornaam,
                                tussenvoegsel,
                                tussenvoegselafk,
                                achternaam,
                                inlognaam,
                                adres,
                                postcode,
                                plaats,
                                gebdat,
                                datumindienst,
                                actief
                            )
                            values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0);
                        ";
                        
                        $page['classes']['sql']-> do_placeholder_query($query,$queryvars,__line__,__file__);
                        
                        $id = $page['classes']['sql']->last_insert_id(__line__,__file__);
                        
                        $queryvars = array($id,$input['afdeling']);
                        $query = "
                            replace into " . $page['settings']['locations']['db_prefix'] . "user_afdelingen (user_id, afdeling_id)
                            values (?, ?);
                        ";
                        
                        $page['classes']['sql']-> do_placeholder_query($query,$queryvars,__line__,__file__);
                    }
                    else
                    {
                        $inlognaam = $this->CreateLoginName();
                        
                        $queryvars = array(
                            $input['adres'],
                            $input['postcode'],
                            $input['plaats'],
                            date("Y-m-d",$begindatum),
                            $inlognaam
                        );
                        
                        $query = "
                            update " . $page['settings']['locations']['db_prefix'] . "users
                            set adres=?, postcode=?, plaats=?, datumindienst=?, actief=0
                            where inlognaam = ?
                        ";
                        
                        $page['classes']['sql']-> do_placeholder_query($query,$queryvars,__line__,__file__);
                    }
                    
                    $output['redirect'] = $page['settings']['locations']['file'];
                }
                else
                {
                    
                }
                
                
            }
            
            $this->Getafdelingen();
        }
        
        function GetSidebarType()
        {
            return "user";
        }
        
        //overige functions
        
        function Checkdata()
        {
            global $input, $page, $output;
            
            $output['error'] = array();
            
            $input['postcode'] = strtoupper($input['postcode']);
            
            if (!preg_match('/^\d{4}\s?[A-Z]{2}$/m', $input['postcode'])) {
                array_push($output['error'],"postcode");
            }
            
            if (!preg_match('%^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)[0-9]{2}$%', $input['gebdat'])) {
                array_push($output['error'], "gebdat");
            }
            
            if (!preg_match('%^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)[0-9]{2}$%m', $input['begindatum'])) {
                array_push($output['error'], "begindatum");
            }
            
            if(count($output['error'])>0)
                return false;
            else
                return true;
        }
        
        function Getafdelingen()
        {
            global $input, $page, $output;
            
            $queryvars = array($page['security']['username']);
            $query = "
                SELECT
                    a.id, a.afdeling
                FROM
                    " . $page['settings']['locations']['db_prefix'] . "afdelingen a,
                    `" . $page['settings']['locations']['db_prefix'] . "uac_user-afdelingen` ua,
                    " . $page['settings']['locations']['db_prefix'] . "uac_user uu
                WHERE
                    a.id = ua.afdelingen_id
                AND
                    ua.uac_user_loginName = uu.loginName
                AND
                    uu.loginName = ?
            ";
            
            $sth = $page['classes']['sql']-> do_placeholder_query($query,$queryvars,__line__,__file__);
        
            $counter = 0;
            
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                $output['afdeling'][$counter++] = array(
                    'id' => $vars['id'],
                    'afdeling' => $vars['afdeling']
                );
            }
        }
        
        function CreateLoginName()
        {
            global $input, $page;
            
            $voornaam = $input['voornaam'];
            $achternaam = $input['achternaam'];
            
            if(strlen($voornaam) > 3)
                $voornaam = substr($voornaam,0,3);
            
            if(strlen($achternaam) > 3)
                $achternaam = substr($achternaam,0,3);
            
            $inlognaam = strtolower($voornaam . $achternaam);
            
            $queryvars = array($inlognaam);
            $query = "
                select naam
                from " . $page['settings']['locations']['db_prefix'] . "users
                where inlognaam = ?
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