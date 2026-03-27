<?php
    $page['classes']['load'] = new Settings();

    class Settings
    {
        private $content;
        
        function GetFileName()
        {
            return $this->content;
        }
        
        function GetVars()
        {
            return array(
                "input" => array()
            );
        }
        
        function NavigatieBalk(){}
        
        function CheckPage()
        {
            return 0;
        }
        
        function DoRun()
        {
            global $input, $page, $output;
            require("./scripts/stats/default.inc.php");
            
            $classcounter = 0;
            $filepath = "./scripts/stats/templates/";
            
            $handle = opendir($filepath);
            
            while (($file = readdir($handle)) !== false)
            {   
                if(substr($file,-7,7) == "inc.php")
                    include($filepath . $file);
            }
            
            if(isset($_GET['submit']))
            {
                foreach($page['stats']['classes'] as $value)
                {
                    if($value -> GetPageId() == $_GET['stat'])
                    {
                        $page['vars'] = $_GET;
                        $value -> GetData();
                        $this->content = "stats/" . $_GET['stat'];
                    }
                }
            }
            else
            {
                $counter = 0;
                foreach($page['stats']['classes'] as $value)
                {
                    $output['stats']['menu'][$counter++] = array('title' => $value -> GetMenuTitle(), 'id' => $value -> GetPageId());
                }
                
                $this->content = 'stats';
            }
        }
        
        function GetSidebarType()
        {
            return "";
        }
    }
?>