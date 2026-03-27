<?php
    function Loadbehandelaars($empty = false)
    {
        global $page, $output;
        
        $query = "
            SELECT * FROM " . $page['settings']['locations']['db_prefix'] . "behandelaar 
        ";
        $sth = $page['classes']['sql']->do_query($query,__LINE__,__FILE__);
        
        $counter = 0;
        
        if($empty)
            $output['behandelaars'][$counter++] = array('id' => 0, 'naam' => 'Afdeling ICT', 'actief' => 0, 'selected' => "false");
        
        while($vars = $page['classes']['sql']->fetch_array($sth))
        {
            $output['behandelaars'][$counter++] = array('id' => $vars['id'], 'naam' => $vars['naam'], 'actief' => $vars['actief'],  'selected' => "false");
        }
        
        $output['behandelaars'] = subval_sort($output['behandelaars'],'naam');
    }
    
    function LoadCategorieen($empty, $inactive = true)
    {
        global $page, $output;
        
        $query = "
            SELECT id, categorie, actief FROM " . $page['settings']['locations']['db_prefix'] . "categorie c
        ";
        
        if(!$inactive)
            $query .= " where actief = 0";
        
        $sth = $page['classes']['sql']-> do_query($query,__LINE__,__FILE__);
        $counter = 0;
        
        if($empty)
        {
            $output['categorie'][$counter++] = array('id' => 0, 'categorie' => '&lt;Alles&gt;');
        }
        
        while($vars = $page['classes']['sql']->fetch_array($sth))
        {
            $output['categorie'][$counter++] = array('id' => $vars['id'], 'categorie' => $vars['categorie'], 'actief' => $vars['actief']);
        }
        
        $output['categorie'] = subval_sort($output['categorie'],'categorie');
    }
    
    function LoadStatus($empty)
    {
        global $page, $output;
        
        $query = "
            SELECT * FROM " . $page['settings']['locations']['db_prefix'] . "status
        ";
        
        $sth = $page['classes']['sql']-> do_query($query,__LINE__,__FILE__);
        
        $counter = 0;
        
        if($empty)
        {
            $output['status'][$counter++] = array('id' => 0, 'status' => '');
        }
        
        while($vars = $page['classes']['sql']->fetch_array($sth))
        {
            $output['status'][$counter++] = array('id' => $vars['id'], 'status' => $vars['status'], 'actief' => $vars['actief']);
        }
    }
    
    function LoadGebruikers()
    {
        global $page, $output;
        
        $query = "
            SELECT t.naam, t.telefoonnummer, inlognaam, afdeling4
            FROM telefoonlijst t 
            LEFT JOIN smoelenboek s
            on t.login = s.inlognaam
        ";
        
        $sth = $page['classes']['sql']-> do_query($query,__LINE__,__FILE__);
        
        $counter = 0;
        while($vars = $page['classes']['sql']->fetch_array($sth))
        {
            $output['gebruikers'][$counter++] = array('naam' => $vars['naam'], 'afdeling' => $vars['afdeling4'], 'telefoonnummer' => $vars['telefoonnummer'], 'inlognaam' => $vars['inlognaam']);
        }
        
        $query = "
            SELECT t.naam, s.inlognaam, s.afdeling4
            FROM telefoon_ooit t
            LEFT join smoelenboek s
                on t.naam = s.naam
            where t.naam not in (
                SELECT naam as test
                FROM telefoonlijst)
        ";
        
        $sth = $page['classes']['sql'] -> do_query($query,__line__,__file__);
        
        while($vars = $page['classes']['sql']->fetch_array($sth))
        {
            $output['gebruikers'][$counter++] = array('naam' => $vars['naam'], 'afdeling' => $vars['afdeling4'], 'telefoonnummer' => '', 'inlognaam' => $vars['inlognaam']);
        }
    }
    
    function LoadIncidenten()
    {
        global $page, $output;
        
        $query = "
            SELECT i.id, i.naam, i.probleem, unix_timestamp(i.aangemeld) as aangemeld
            FROM ". $page['settings']['locations']['db_prefix'] . "incidenten as i
        ";
        
        $sth = $page['classes']['sql']-> do_query($query,__line__,__file__);
        
        $counter = 0;
        
        while($vars = $page['classes']['sql']->fetch_array($sth))
        {
            $output['incidenten'][$counter++] = array('id' => $vars['id'], 'naam' => $vars['naam'], 'probleem' => $vars['probleem'], 'aangemeld' => $vars['aangemeld']);
        }
    }
    
    function LoadLeveranciers($empty = false)
    {
        global $page, $output;
        
        $query = "
            SELECT l.id, l.leverancier
            FROM {$page['settings']['locations']['db_prefix']}leverancier l
        ";
        
        $sth = $page['classes']['sql'] -> do_query($query,__line__,__file__);
        
        $counter = 0;
        
        if($empty)
            $output['leverancier'][$counter++] = array('id' => 0, 'leverancier' => "");
        
        while($vars = $page['classes']['sql']->fetch_array($sth))
        {
            $output['leverancier'][$counter++] = array('id' => $vars['id'], 'leverancier' => $vars['leverancier']);
        }
    }
    
    function LoadAfdelingen()
    {
        global $page, $output;
        
        $query = "
            SELECT
                id, afdeling
            FROM
                " . $page['settings']['locations']['db_prefix'] . "afdelingen
        ";
        
        $sth = $page['classes']['sql']->do_query($query,__LINE__,__FILE__);
        
        $counter = 0;
        
        while($vars = $page['classes']['sql']->fetch_array($sth))
        {
            $output['afdeling'][$counter++] = array(
                'id' => $vars['id'],
                'afdeling' => spaceToNbsp(htmlentities($vars['afdeling']))
            );
        }
    }
    
    function LoadContracttype($empty = false)
    {
        global $page, $output;
        
        $query = "
            SELECT c.id, c.contracttype
            FROM {$page['settings']['locations']['db_prefix']}contracttype c
        ";
        
        $sth = $page['classes']['sql'] -> do_query($query,__line__,__file__);
        
        $counter = 0;
        
        if($empty)
            $output['contracttype'][$counter++] = array('id' => 0, 'contracttype' => "");
        
        while($vars = $page['classes']['sql']->fetch_array($sth))
        {
            $output['contracttype'][$counter++] = array('id' => $vars['id'], 'contracttype' => $vars['contracttype']);
        }
    }
    
    function LoadContract($empty = false)
    {
        global $page, $output;
        
        $query = "
            SELECT c.id, c.contractid
            FROM {$page['settings']['locations']['db_prefix']}contract c
        ";
        
        $sth = $page['classes']['sql'] -> do_query($query,__line__,__file__);
        
        $counter = 0;
        
        if($empty)
            $output['contract'][$counter++] = array('id' => 0, 'contractid' => "");
        
        while($vars = $page['classes']['sql']->fetch_array($sth))
        {
            $output['contract'][$counter++] = array('id' => $vars['id'], 'contractid' => $vars['contractid']);
        }
    }
    
    function subval_sort($a,$subkey)
    {
	foreach($a as $k=>$v)
        {
	    $b[$k] = strtolower($v[$subkey]);
	}
        
	asort($b);
        
	foreach($b as $key=>$val)
        {
	    $c[] = $a[$key];
	}
        
	return $c;
    }
    
    function spaceToNbsp($str)
    {
        return str_replace(' ','&nbsp;',$str);
    }
    
    function IntToTime($int)
    {
        if($int < 0)
        {
            $hours = ceil($int/60);
            
            $min = ($int % 60) * -1;
            
            if($min <= 9)
                $min = "0" . $min;
        }
        else
        {
            $hours = floor($int/60);
            $min = $int % 60;
            
            if($min <= 9)
                $min = "0" . $min;
        }
        
        return $hours . ":" . $min;
    }
    
    function TimeToInt($time)
    {
        list($hours, $min) = split(":", $time);
        
        if($min == null)
            return $hours;
        else
            $hours = $hours * 60;
            
        return $hours + $min;
    }
    
    function createPassword($length) {
	$chars = "1234567890";
        $chars .= "abcdefghijkmnopqrstuvwxyz";
        $chars .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        
	$i = 0;
	$password = "";
	while ($i <= $length) {
	    $password .= $chars{mt_rand(0,strlen($chars)-1)};
	    $i++;
	}
	return $password;
    }
?>