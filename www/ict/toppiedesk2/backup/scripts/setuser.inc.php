<?php
    $page['classes']['load'] = new SetUser();

    class SetUser
    {
        function GetFileName()
        {
            return "behandelaar";
        }
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "accept" => array("accept","get","int"),
                    "behandelaar" => array("behandelaar","get","alphanum")
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
            global $page, $output;
            
            $query = "
                SELECT * FROM " . $page['settings']['locations']['db_prefix'] . "behandelaar WHERE actief = 0; 
            ";
            $sth = $page['classes']['sql']-> do_query($query,__LINE__,__FILE__);
            
            $counter = 0;
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                if($counter == 0)
                    $output['behandelaars'][$counter++] = array('id' => $vars['id'], 'naam' => $vars['naam'], 'selected' => 'true');
                else
                    $output['behandelaars'][$counter++] = array('id' => $vars['id'], 'naam' => $vars['naam'], 'selected' => 'false');
            }
            
            $output['behandelaars'] = subval_sort($output['behandelaars'],'naam');
            
            if(isset($_GET['accept']))
            {
                $page['vars']['behandelaar'] = $_GET['behandelaar'];
                
                foreach($output['behandelaars'] as $behandelaar)
                {
                    if($page['vars']['behandelaar'] == $behandelaar['id'])
                    {   
                        setcookie('behandelaar', $behandelaar['id'], time()+3600*24*30);
                        $page['classes']['behandelaar']->setUser();
                        header("location:toppiedesk.php");
                    }
                }
            }
        }
        
        function GetSidebarType()
        {
            return "settings";
        }
    }
?>