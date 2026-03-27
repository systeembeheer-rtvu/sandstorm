<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    
    $dbh = new sql();
    $dbh->connect();
    
    $output['value'] = array();
    $output['value']['fields'] = array();
    
    preg_match_all('/\\\\"(.*?)\\\\":\\\\"(.*?)\\\\"/i', $_GET['value'], $result, PREG_SET_ORDER);
    
    foreach($result as $value)
    {
        if($value[1] == "oid")
            $output['value']["oid"] = $value[2];
        else if($value[1] == 'hardwaretype')
            $output['value']['hardwaretype'] = $value[2];
        else if($value[1] == 'multi')
        {
            if($value[2] == "true")
                $output['value']["multi"] = 1;
            else if($value[2] == "false")
                $output['value']["multi"] = 0;
        }
        else if($value[1] == 'leverancier')
            $output['value']['leverancier'] = $value[2];
        else
        {
            array_push(
                $output['value']['fields'],
                array(
                    "field" => $value[1],
                    "value" => $value[2]
                )
            );
        }
    }
    
    print_r($output);
    
    $queryvars = array($output['value']['oid'],$output['value']['multi'], $output['value']['leverancier']);
    $query = "
        replace into " . $page['settings']['locations']['db_prefix'] . "hardware (oid, multi, leverancier)
        values (?,?,?)
    ";
    $dbh->do_placeholder_query($query,$queryvars,__line__,__file__);
    
    $queryvars = array($output['value']["oid"], $output['value']['hardwaretype']);
    $query = "
        replace into `" . $page['settings']['locations']['db_prefix'] . "hardware_hardware-type` (hardware_oid, type_id)
        values(?,(
            select id
            from `" . $page['settings']['locations']['db_prefix'] . "hardware_types`
            where type = ?
        ))
    ";
    
    $dbh->do_placeholder_query($query,$queryvars,__line__,__FILE__);
    
    foreach($output['value']['fields'] as $field)
    {
        $queryvars = array($output['value']["oid"], $field['field'], $field['value']);
        $query = "
            replace into " . $page['settings']['locations']['db_prefix'] . "hardware_input (hardware_oid, field_id, value)
            values(?,?,?)
        ";
        
        $dbh->do_placeholder_query($query,$queryvars,__line__,__file__);
    }
?>