<?php
    $page['classes']['load'] = new wijzigingftpaccountbeheer();

    class wijzigingftpaccountbeheer
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
            return "wijzigingftpaccountbeheer";
        }
        
        function CheckPage()
        {
            return 0;
        }
        
        function NavigatieBalk(){}
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "action" => array("action","post",""),
                    "item" => array("item", "post",""),
                    "comment" => array("comment", "post", ""),
                    "verloopdat" => array("verloopdat", "post", ""),
                    "wachtwoord" => array("wachtwoord", "post", ""),
                    "verlopen" => array("verlopen", "post", "")
                )
            );
        }
        
        function DoRun()
        {
            global $input, $page, $output;
            
            $this->LoadFtpAccounts();
        }
        
        function GetSidebarType()
        {
            return "wijziging";
        }
        
        //overige functions
        function LoadFtpAccounts()
        {
            global $page, $output;
            
            $query = "
                SELECT
                    user,
                    dir,
                    comment,
                    lastlogin,
                    verloopdatum,
                    kanverlopen
                FROM users
                order by user
            ";
            
            $sth = $this->sql->do_query($query,__LINE__,__FILE__);
            
            $counter = 0;
            
            while($vars = $this->sql->fetch_array($sth))
            {
                $verloopdatum = date("d-m-Y",strtotime($vars['verloopdatum']));
                $lastlogin = date("d-m-Y G:i",strtotime($vars['lastlogin']));
                
                if($verloopdatum == "30-11--0001")
                    $verloopdatum = "";
                
                if($lastlogin == "30-11--0001 0:00")
                    $lastlogin = "";
                
                $output['ftp'][$counter] = array(
                    'user' => $vars['user'],
                    'dir' => $vars['dir'],
                    'comment' => $vars['comment'],
                    'lastlogin' => $lastlogin,
                    'verloopdatum' => $verloopdatum,
                    'kanverlopen' => $vars['kanverlopen'],
                    'color' => $counter % 2
                );
                
                if(strtotime($vars['verloopdatum']) < strtotime(date("d-m-Y")) && $verloopdatum != "" && $vars['kanverlopen'] == 1)
                {
                    $output['ftp'][$counter]['color'] = 3;
                }
                
                $counter++;
            }
        }
    }
?>