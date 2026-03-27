<?php
    class Links
    {
        function LoadLinks($type = "")
        {
            global $output, $page;
            
            $output['links']['top_links'][0] = array('name' => "Call", 'path' => $page['settings']['locations']['file'] . "?id=call");
            $output['links']['top_links'][1] = array('name' => "Wijziging", 'path' => $page['settings']['locations']['file'] . "?id=wijziging");
            $output['links']['top_links'][2] = array('name' => "Project", 'path' => $page['settings']['locations']['file'] . "?id=project");
            $output['links']['top_links'][3] = array('name' => "Contract", 'path' => $page['settings']['locations']['file'] . "?id=contract");
            $output['links']['top_links'][4] = array('name' => "Configuratie", 'path' => $page['settings']['locations']['file'] . "?id=config");
            
            $output['links']['settings'][0] = array('name' => "Settings", 'img' => "agt_softwareD.png", 'path' => $page['settings']['locations']['file'] . "?id=settings");
            $output['links']['settings'][1] = array('name' => "Stats", 'img' => "agt_business.png", 'path' => $page['settings']['locations']['file'] . "?id=stats");
            
            if(isset($type))
            {
                if($type == "configuratie")
                {
                    $output['links']['sb_links'] = array(
                        array('url' => "{$page['settings']['locations']['file']}?id=configkaart", 'link' => 'Persoonskaart', 'target' => "self"),
                        array('url' => "{$page['settings']['locations']['file']}?id=confighardwarekaart", 'link' => 'Hardwarekaart', 'target' => "self"),
                        array('url' => "{$page['settings']['locations']['file']}?id=configleverancier", 'link' => 'Leverancier', 'target' => "self"),
                    );
                }
                else if($type == "contract")
                {
                    $output['links']['sb_links'] = array(
                        array('url' => "{$page['settings']['locations']['file']}?id=contractnieuw", 'link' => 'Nieuw', 'target' => "self"),
                        array('url' => "{$page['settings']['locations']['file']}?id=contractzoeken", 'link' => 'Zoeken', 'target' => "self"),
                    );
                }
                else if($type == "incident")
                {
                    $output['links']['sb_links'] = array(
                        array('url' => "{$page['settings']['locations']['file']}?id=callnieuw", 'link' => 'Nieuw', 'target' => "blank"),
                        array('url' => "{$page['settings']['locations']['file']}?id=calloverzicht", 'link' => 'Overzicht', 'target' => "self"),
                        array('url' => "{$page['settings']['locations']['file']}?id=callzoeken", 'link' => 'Zoeken', 'target' => "self"),
                        array('url' => "{$page['settings']['locations']['file']}?id=branka", 'link' => 'Branka', 'target' => "self"),
                    );
                }
                else if($type == "wijziging")
                {
                    $output['links']['sb_links'] = array(
                        array('url' => "{$page['settings']['locations']['file']}?id=wijzigingnieuwegebruiker", 'link' => 'Nieuwe gebruiker', 'target' => "self"),
                        array('url' => "{$page['settings']['locations']['file']}?id=wijzigingftpaccountbeheer", 'link' => 'FTP accountbeheer', 'target' => "self")
                    );
                }
                else if($type == "settings")
                {
                    $output['links']['sb_links'] = array(
                        array('url' => "{$page['settings']['locations']['file']}?id=settings", 'link' => 'settings', 'target' => "self"),
                        array('url' => "{$page['settings']['locations']['file']}?id=setuser", 'link' => 'wijzig behandelaar', 'target' => "self"),
                    );
                }
                else if($type == "project")
                {
                    $output['links']['sb_links'] = array(
                        array('url' => "{$page['settings']['locations']['file']}?id=projectoverzicht", 'link' => 'Overzicht', 'target' => "self"),
                        array('url' => "{$page['settings']['locations']['file']}?id=projectnieuw", 'link' => 'Nieuw', 'target' => "self"),
                        array('url' => "{$page['settings']['locations']['file']}?id=projectzoeken", 'link' => 'Zoeken', 'target' => "self"),
                        array('url' => "{$page['settings']['locations']['file']}?id=projecturen", 'link' => 'Projecturen', 'target' => "self")
                    );
                }
            }
        }
    }
?>