<?php
    $page['classes']['load'] = new confignieuwhardwaretype();

    class confignieuwhardwaretype
    {
        function GetFileName()
        {
            if(isset($_POST['velden']) && $_POST['velden'] == "Aanmaken")
                return "confignieuwhardwaretype2";
            
            return "confignieuwhardwaretype";
        }
        
        function CheckPage()
        {
            return 0;
        }
        
        function NavigatieBalk()
        {
            global $input, $page, $output;
            
        }
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "searchoid" => array("searchoid","get","alphanum"),
                    "aantal" => array("aantal", "post", "int"),
                    "naam" => array("naam", "post", ""),
                    "type" => array("type", "post", ""),
                    "typenaam" => array("typenaam", "post", "")
                )
            );
        }
        
        function DoRun()
        {
            global $input, $page, $output;
            
            if(isset($_POST['velden']) && $_POST['velden'] == "Aanmaken")
                $this->hardwaretyperegistreren();
            else if(isset($_POST['submit']))
                $this->opslaan();
        }
        
        function GetSidebarType()
        {
            return "configuratie";
        }
        
        //overige functions
        
        function hardwaretyperegistreren()
        {
            global $input, $page, $output;
            
            $output['vars']['aantal'] = $input['aantal'];
        }
        
        function opslaan()
        {
            global $input, $page, $output;
            
            $queryvars = array($input['typenaam']);
            $query = "
                INSERT INTO " . $page['settings']['locations']['db_prefix'] . "hardware_types (type)
                VALUES (?)
            ";
            
            $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
            
            for( $i = 1; $i <= $input['aantal']; $i++ )
            {
                $queryvars = array($input['naam'][$i], $input['type'][$i]);
                $query = "
                    INSERT INTO " . $page['settings']['locations']['db_prefix'] . "hardware_fields (label, type)
                    VALUES (?,?)
                ";
                
                $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
                
                $queryvars = array($input['typenaam'], $input['type'][$i], $input['naam'][$i]);
                $query = "
                    insert into `" . $page['settings']['locations']['db_prefix'] . "hardware_type-fields` (type_id, field_id)
                    values(
                        (
                            select id
                            from `" . $page['settings']['locations']['db_prefix'] . "hardware_types`
                            where type = ?
                        ),
                        (
                            select id
                            from `" . $page['settings']['locations']['db_prefix'] . "hardware_fields`
                            where type = ?
                            and label = ?
                        )
                    )
                ";
                
                $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
                
            }
            
            $output['redirect'] = $page['settings']['locations']['file'] ."?id=confighardwarekaart";
        }
    }
?>