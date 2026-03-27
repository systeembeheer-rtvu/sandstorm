<?php
    class voorbeeld2 extends abstractStats
    {
        function __construct()
        {
            $this -> menutitle = "Incidenten per uur";
            $this -> pagetitle = "Incidenten per uur";
            $this -> pageid = "voorbeeld2";
            $this -> template = "stats/incidenten/voorbeeld2.tpl";
        }
        
        public function GetData()
        {
            global $page, $output;
            
            $this->weergeven();
        }
        
        // overige functions
        public function weergeven()
        {
            global $page, $output;
            
            $output['title'] = $this->pagetitle;
            
            $output['vars']['van']['dag']     = $input['dagvan'];
            $output['vars']['van']['maand']   = $input['maandvan'];
            $output['vars']['van']['jaar']    = $input['jaarvan'];
            
            $output['vars']['tot']['dag']     = $input['dagtot'];
            $output['vars']['tot']['maand']   = $input['maandtot'];
            $output['vars']['tot']['jaar']    = $input['jaartot'];
            
            $output['vars']['van']['totaal']  = mktime(0,  0,  0,  $output['vars']['van']['maand'],  $output['vars']['van']['dag'],    $output['vars']['van']['jaar']);
            $output['vars']['tot']['totaal']  = mktime(23, 59, 59, $output['vars']['tot']['maand'],  $output['vars']['tot']['dag'],    $output['vars']['tot']['jaar']);
            
            $query = "
                SELECT
                    i.id,
                    i.naam,
                    i.probleem,
                    unix_timestamp(i.aangemeld) as aangemeld
                FROM
                    ". $page['settings']['locations']['db_prefix'] . "incidenten as i
            ";
            
            $sth = $page['classes']['sql']-> do_query($query,__line__,__file__);
            
            $counter = 0;
            
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                $output['incidenten'][$counter++] = array('id' => $vars['id'], 'naam' => $vars['naam'], 'probleem' => $vars['probleem'], 'aangemeld' => $vars['aangemeld']);
            }
            
            for($i = 0; $i<24; $i++)
            {
                $time = $i+1;
                $output['time'][$i]['title'] = "{$i}:00 - {$time}:00";
                $output['time'][$i]['count'] = 0;
                $output['time'][$i]['color'] = $i % 2;
            }
         
            if(isset($output['incidenten']))
            {
                foreach($output['incidenten'] as $value)
                {
                    $output['time'][date("G", $value['aangemeld'])]['count'] = $output['time'][date("G", $value['aangemeld'])]['count'] + 1;
                }
            }
            
            $output['vars']['huidig']['jaar'] = date("Y");
        }
    }
    
    $page['stats']['classes'][$classcounter++] = new voorbeeld2();
?>