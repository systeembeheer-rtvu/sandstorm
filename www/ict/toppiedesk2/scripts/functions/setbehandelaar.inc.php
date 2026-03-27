<?php
    class Behandelaar
    {
        function check()
        {
            global $page;
            
            if(isset($_GET['id']))
                $page['page'] = $_GET['id'];
            else
                $page['page'] = "";
            
            $siteSet = false;
            
            if(!isset($_COOKIE['behandelaar']))
            {
                $queryvars = array($_SERVER['REMOTE_ADDR']);
                $query = "
                    select
                        id
                    from
                        toppie_behandelaar
                    where
                        naam like(
                            SELECT
                                naam
                            FROM
                                telefoonlijst
                            WHERE
                                workstationip = ?
                        )
                ";
                
                $sth = $page['classes']['sql']-> do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                if($page['classes']['sql']->total_rows($sth)>0)
                {
                    $vars = $page['classes']['sql']->fetch_array($sth);
                    
                    setcookie('behandelaar', $vars['id'], time()+3600*24*30);
                    $siteSet = true;
                }
            }
            
            $query = "select * from {$page['settings']['locations']['db_prefix']}behandelaar WHERE actief = 0";
            $sth = $page['classes']['sql']->do_query($query,__line__,__file__);
            
            if($page['classes']['sql']->total_rows($sth)<1 && $page['page'] != "settings")
            {
                $page['site'] = "location: toppiedesk.php?id=settings";
            }
            
            $query = "select * from {$page['settings']['locations']['db_prefix']}categorie WHERE actief = 0";
            $sth = $page['classes']['sql']->do_query($query,__line__,__file__);
            
            if(!$siteSet && $page['classes']['sql']->total_rows($sth)<1  && $page['page'] != "settings")
            {
                $page['site'] = "location: toppiedesk.php?id=settings";
                $siteSet = true;
            }
            
            if(!$siteSet && (!isset($_COOKIE['behandelaar']) && $page['page'] != "setuser" && $page['page'] != "settings"))
            {
                $page['site'] = "location: toppiedesk.php?id=setuser";
            }
            
            if(isset($page['site']))
                header($page['site']);
            
            $this->setUser();
        }
        
        function setUser()
        {
            global $page, $output;
            
            if(isset($_COOKIE['behandelaar']))
            {
                $queryvars = array($_COOKIE['behandelaar']);
                $query = "
                        SELECT naam
                        FROM
                            " . $page['settings']['locations']['db_prefix'] . "behandelaar b
                        WHERE
                            id = ?
                ";
                
                $sth = $page['classes']['sql']-> do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
                
                $naam = $page['classes']['sql']->fetch_array($sth);
                
                $output['behandelaar']['naam'] = $naam['naam'];
                $output['behandelaar']['id'] = $_COOKIE['behandelaar'];
            }
        }
    }
?>