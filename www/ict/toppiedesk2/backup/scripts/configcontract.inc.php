<?php
    $page['classes']['load'] = new configcontract();

    class configcontract
    {
        function GetFileName()
        {
            global $input, $page;
            
            if(isset($_GET['submit']) && $_GET['submit'] == "Contract maken")
            {
                return "contractFillIn";
            }
            
            return "configcontract";
        }
        
        function CheckPage()
        {
            return 0;
        }
        
        function NavigatieBalk(){}
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "naam" => array("naam","both","alphanum"),
                    "gebdat" => array("gebdat","post","alphanum"),
                    "adres" => array("adres","post","alphanum"),
                    "postcode" => array("postcode","post","alphanum"),
                    "plaats" => array("plaats","post","alphanum"),
                )
            );
        }
        
        function DoRun()
        {
            global $input, $page, $output;
            
            if(isset($_GET['submit']) && $_GET['submit'] == "Contract maken")
            {
                $output['contract']['naam'] = $input['naam'];
                
                $queryvars = array($input['naam']);
                $query = "
                    Select
                        gebdat, adres, postcode, plaats
                    from
                       " .  $page['settings']['locations']['db_prefix'] . "users
                    where
                        naam = ?
                ";
                
                $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                $vars = $page['classes']['sql']->fetch_array($sth);
                
                $output['contract']['gebdat'] = date("d-m-Y",strtotime($vars['gebdat']));
                $output['contract']['adres'] = $vars['adres'];
                $output['contract']['postcode'] = $vars['postcode'];
                $output['contract']['plaats'] = $vars['plaats'];
            }
            else if($_POST['submit'] && $_POST['submit'] == "Genereer")
            {
                $queryvars = array(date("Y-m-d",strtotime($input['gebdat'])), $input['adres'], $input['postcode'], $input['plaats'], $input['naam']);
                $query = "
                    update " .  $page['settings']['locations']['db_prefix'] . "users
                    set gebdat=?, adres=?, postcode=?, plaats=?
                    where naam = ?
                ";
                
                $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                
                $template_file = "./file/contract.rtf";
                $handle = fopen($template_file , "r");
                $contents = fread($handle, filesize($template_file));
                 
                $original= array(
                    "*NAAM*",
                    "*GEBOORTEDATUM*",
                    "*ADRES*",
                    "*POSTCODE*",
                    "*PLAATS*",
                    "*DATUM*",
                );
                
                $new = array(
                    $input['naam'],
                    date("d-m-Y",strtotime($input['gebdat'])),
                    $input['adres'],
                    $input['postcode'],
                    $input['plaats'],
                    date("d-m-Y")
                );
                
                $newphrase = str_replace($original, $new, $contents);
                
                $queryvars = array($input['naam']);
                $query = "
                    select
                        hhp.hardware_oid, ht.type
                    from
                        `toppie_hardware_hardware-persoon` hhp,
                        `toppie_hardware_hardware-type` hht,
                        `toppie_hardware_types` ht
                    where
                        hhp.hardware_oid = hht.hardware_oid
                    and
                        hht.type_id = ht.id
                    and
                        hhp.naam = ?
                ";
                
                $sth = $page['classes']['sql']->do_placeholder_query($query,$queryvars,__LINE__,__FILE__);
                
                $counter = 0;
                
                while($vars = $page['classes']['sql']->fetch_array($sth))
                {
                    $original = array("*REGEL" . ++$counter . "*");
                    $new = array($vars['type'] . " (" . $vars['hardware_oid'] . ")");
                    
                    $newphrase = str_replace($original, $new, $newphrase);
                }
                
                $original = array();
                
                while($counter <40)
                {
                    array_push($original,"*REGEL" . ++$counter . "*");
                }
                
                $new = "";
                $newphrase = str_replace($original, $new, $newphrase);
                
                $handle2 = fopen("./file/contractgen.rtf" , "w");
                
                fwrite ($handle2 ,$newphrase);
                fclose ($handle);
                fclose($handle2);
                
                $fullPath = "./file/contractgen.rtf";
                 
                if ($fd = fopen ($fullPath, "r")) {
                    $fsize = filesize($fullPath);
                    $path_parts = pathinfo($fullPath);
                    $ext = strtolower($path_parts["extension"]);
                    switch ($ext) {
                        case "pdf":
                        header("Content-type: application/pdf"); // add here more headers for diff. extensions
                        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a download
                        break;
                        default;
                        header("Content-type: application/octet-stream");
                        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
                    }
                    header("Content-length: $fsize");
                    header("Cache-control: private"); //use this to open files directly
                    while(!feof($fd)) {
                        $buffer = fread($fd, 2048);
                        echo $buffer;
                    }
                }

                
            }
            
            /*if(isset($_GET['submit']))
            {
                
            }*/
        }
        
        function GetSidebarType()
        {
            return "configuratie";
        }
    }
?>