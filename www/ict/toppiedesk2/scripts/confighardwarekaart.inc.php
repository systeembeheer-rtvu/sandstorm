<?php
    $page['classes']['load'] = new confighardwarekaart();

    //TODO: batch import
    //TODO: leverancier veld

    class confighardwarekaart
    {
        function GetFileName()
        {
            return "confighardwarekaart";
        }
        
        function CheckPage()
        {
            return 0;
        }
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "oid" => array("oid","get",""),
                    "searchoid" => array("searchoid","both",""),
                    "hardwaretype" => array("hardwaretype", "get", ""),
                    "multi" => array("multi", "both", "int"),
                    "naam" => array("naam", "post", "alpha"),
                    "users" => array("users", "post", ""),
                    "medewerkers" => array("medewerkers", "post", "")
                )
            );
        }
        
        function NavigatieBalk()
        {
            global $input, $page, $output;
            
            $output["navbar"]["new"] = $page['settings']['locations']['file'] . "?id=confighardwarekaart"; //waarde voor een nieuw object
            $output["navbar"]["save"] = ""; //waarde voor het opslaan van een object
            $output["navbar"]["prev"] = "false"; //waarde voor een vorig object
            $output["navbar"]["next"] = "false"; //waarde voor een volgend object
            $output["navbar"]["archive"] = ""; //waarde voor een nieuw object
            $output["navbar"]["mail"] = "false";
            $output['navbar']['autocomplete'] = "hardware";
            $output['navbar']['id'] = "confighardwarekaart";
        }
        
        function DoRun()
        {
            global $input, $page, $output;
            
            LoadLeveranciers(true);
            LoadContract(true);
            
            $query = "select id, type from " . $page['settings']['locations']['db_prefix'] . "hardware_types";
            $sth = $page['classes']['sql'] -> do_query($query,__LINE__,__FILE__);
            
            $output['hardware']['types'] = array("");
            while($vars = $page['classes']['sql']->fetch_array($sth))
            {
                array_push($output['hardware']['types'], array(
                    "id" => $vars['id'],
                    "type" => $vars['type']
                ));
            }
            
            $output['value']['hardwaretype'] = $input['hardwaretype'];
            
            if(isset($_POST['submit']) && $_POST['submit'] == "--- Toevoegen -->")
            {
                $check = false;
                
                if($input['medewerkers'] != "" && $input['multi'] == 0)
                {
                    $queryvars = array($input['searchoid']);
                    $query = "
                        select naam from `" . $page['settings']['locations']['db_prefix'] . "hardware_hardware-persoon`
                        where hardware_oid = ?
                    ";
                    
                    $sth = $page['classes']['sql'] -> do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                    
                    $count = $page['classes']['sql'] ->total_rows($sth);
                    
                    if($count < 1)
                        $check = true;
                }
                else if($input['medewerkers'] != "")
                {
                    $check = true;
                }
                
                if($check){
                    foreach($input['medewerkers'] as $medewerker)
                    {
                        $queryvars = array($input['searchoid'],$medewerker);
                        $query = "
                            insert into `" . $page['settings']['locations']['db_prefix'] . "hardware_hardware-persoon` (hardware_oid, naam)
                            values(?, ?)
                        ";
                        
                        $page['classes']['sql'] -> do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                    }
                }
            }
            else if(isset($_POST['submit']) && $_POST['submit'] == "<-- Verwijderen --")
            {
                if($input['users'] != "")
                {
                    foreach($input['users'] as $user)
                    {
                        $queryvars = array($input['searchoid'], $user);
                        $query = "
                            delete from `" . $page['settings']['locations']['db_prefix'] . "hardware_hardware-persoon`
                            where hardware_oid = ?
                            and naam = ?
                        ";
                        
                        $page['classes']['sql'] -> do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                    }
                }
            }
            
            if($input['searchoid'] != "0" && $input['searchoid'] != "" )
            {
                $queryvars = array($input['searchoid']);
                $query = "
                    select
                        h.multi,
                        h.leverancier,
                        f.id,
                        f.label,
                        f.type,
                        f.waardes,
                        t.type
                    from
                        " . $page['settings']['locations']['db_prefix'] . "hardware h,
                        `" . $page['settings']['locations']['db_prefix'] . "hardware_hardware-type` ht,
                        " . $page['settings']['locations']['db_prefix'] . "hardware_types t,
                        `" . $page['settings']['locations']['db_prefix'] . "hardware_type-fields` tf,
                        " . $page['settings']['locations']['db_prefix'] . "hardware_fields f
                    where
                        h.oid = ht.hardware_oid
                    and
                        ht.type_id = t.id
                    and
                        t.id = tf.type_id
                    and
                        tf.field_id = f.id
                    and
                        h.oid = ?
                ";
                
                $sth = $page['classes']['sql'] -> do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                
                $counter = 0;
                $output['values']['searchoid'] = $input['searchoid'];
                
                while($vars = $page['classes']['sql']->fetch_array($sth))
                {
                    $output['values']['multi'] = $vars['multi'];
                    $output['values']['hardwaretype'] = $vars['type'];
                    $output['values']['leverancier'] = $vars['leverancier'];
                    $output['hardware']['value'][$counter++] = array(
                        "id" => $vars['id'],
                        "label" => $vars['label'],
                        "type" => $vars['type'],
                        "waardes" => $vars['waardes'],
                        "value" => ""
                    );
                }
                
                $query = "
                    select
                        i.field_id,
                        i.value
                    from
                        " . $page['settings']['locations']['db_prefix'] . "hardware h,
                        " . $page['settings']['locations']['db_prefix'] . "hardware_input i
                    where
                        h.oid = i.hardware_oid
                    and
                        h.oid = ?
                ";
                
                $sth = $page['classes']['sql'] -> do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                
                $counter = 0;
                while($vars = $page['classes']['sql']->fetch_array($sth))
                {
                    foreach($output['hardware']['value'] as &$value)
                    {
                        if($value['id'] == $vars['field_id'])
                        {
                            $value['value'] = $vars['value'];
                        }
                    }
                }
                
                $queryvars = array($input['searchoid']);
                $query = "
                    select naam
                    from `" . $page['settings']['locations']['db_prefix'] . "hardware_hardware-persoon`
                    where hardware_oid = ?
                ";
                
                $sth = $page['classes']['sql'] -> do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                
                $counter = 0;
                while($vars = $page['classes']['sql']->fetch_array($sth))
                {
                    $output['user']['value'][$counter++] = $vars['naam'];
                }
                
                if(isset($output['user']['value']))
                    $output['user']['value'] = subval_sort($output['user']['value'],'naam');
                
                $queryvars = array($input['searchoid']);
                $query = "
                    select naam
                    from `" . $page['settings']['locations']['db_prefix'] . "users`
                    where naam not in (
                        select naam
                        from `" . $page['settings']['locations']['db_prefix'] . "hardware_hardware-persoon`
                        where hardware_oid = ?
                    )
                    and actief = 2 
                ";
                
                $sth = $page['classes']['sql'] -> do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                
                $counter = 0;
                while($vars = $page['classes']['sql']->fetch_array($sth))
                {
                    $output['medewerkers']['value'][$counter++]  = $vars['naam'];
                }
                
                sort($output['medewerkers']['value']);
                
            }
            else if(isset($input['hardwaretype']))
            {
                $output['values']['searchoid'] = $input['oid'];
                
                $queryvars = array($input['hardwaretype']);
                $query = "
                    SELECT
                        f.label,
                        f.type,
                        f.id,
                        f.waardes
                    FROM
                        " . $page['settings']['locations']['db_prefix'] . "hardware_types t,
                        `" . $page['settings']['locations']['db_prefix'] . "hardware_type-fields` tf,
                        " . $page['settings']['locations']['db_prefix'] . "hardware_fields f
                    WHERE
                        t.id = tf.type_id
                    AND
                        tf.field_id = f.id
                    AND
                        t.type = ?
                ";
                
                $output['values']['hardwaretype'] = $input['hardwaretype'];
                
                $sth = $page['classes']['sql'] -> do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                
                $counter = 0;
                while($vars = $page['classes']['sql']->fetch_array($sth))
                {
                    $output['hardware']['value'][$counter++] = array(
                        "label" => $vars['label'],
                        "type" => $vars['type'],
                        "id" => $vars['id'],
                        "waardes" => $vars['waardes'],
                        "value" => ""
                    );
                }
            }
        }
        
        function GetSidebarType()
        {
            return "configuratie";
        }
    }
?>