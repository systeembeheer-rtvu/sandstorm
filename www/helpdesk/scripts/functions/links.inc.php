<?php
    class Links
    {
        function LoadLinks($type = "")
        {
            global $output, $page;
            
            $output['links']['settings'][0] = array('name' => "Settings", 'img' => "agt_home.png", 'path' => $page['settings']['locations']['file']);
            
            if(isset($type))
            {
                if($type == "user")
                {
                    $output['links']['sb_links'] = array(
                        array('url' => "{$page['settings']['locations']['file']}?id=ftp", 'link' => 'FTP account aanvragen')
                        /*array('url' => "{$page['settings']['locations']['file']}?id=user", 'link' => 'User account aanvragen')*/
                    );
                    
                    $remote_ip = $_SERVER['REMOTE_ADDR'];
                    $queryvars = array($remote_ip);
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
                            p.page_id = 'user'
                        AND
                            u.loginname = (
                                SELECT login 
                                FROM telefoonlijst 
                                WHERE workstationip = ? 
                            )
                    ";
                    
                    $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                    $teller = $page['classes']['sql']->total_rows($sth);
                    
                    if($teller > 0){
                        array_push($output['links']['sb_links'],
                            array(
                                'url' => "{$page['settings']['locations']['file']}?id=user",
                                'link' => 'User account aanvragen'
                            )
                        );
                    }
                }
            }
        }
    }
?>