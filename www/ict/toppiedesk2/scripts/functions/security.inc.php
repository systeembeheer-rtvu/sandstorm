<?php
    class Security
    {
        function CheckId(){
            global $page;
            
            $remote_ip = $_SERVER['REMOTE_ADDR'];
            
            if(preg_match('/\w+/', $page['scriptname']))
            {   
                $queryvars = array($page['scriptname'], $remote_ip);
                $query = "
                    SELECT
                        u.loginName
                    FROM
                        toppie_uac_active g,
                        toppie_uac_page p,
                        toppie_uac_user u
                    WHERE
                        p.id = g.page_id
                    AND
                        g.user_id = u.loginName
                    AND
                        g.active = 0
                    AND
                        p.page_id = ?
                    AND
                        u.loginname = (
                            SELECT login
                            FROM telefoonlijst
                            WHERE workstationip = ?
                        )
                ";
                
                $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                $teller = $page['classes']['sql']->total_rows($sth);
                $vars = $page['classes']['sql']->fetch_array($sth);
                
                $page['security']['username'] = $vars['loginName'];
                
                if($teller > 0)
                    return 1;
            }
            
            return 0;
        }
    }
?>