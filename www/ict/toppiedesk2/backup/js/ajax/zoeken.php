<?php
    date_default_timezone_set('Europe/Belgrade');

    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    require_once("../../scripts/functions/functions.inc.php");
    require_once("../../scripts/functions/sanitizer.inc.php");
    
    
    $san = new Sanitizer();
    
    $dbh = new sql();
    $dbh->connect();
    
    $output = "";
    
    $page['vars']['opdracht'] = htmlspecialchars($_GET['opdracht']);

    $page['vars']['van']['dag']     = $_GET['vanDag'];
    $page['vars']['van']['maand']   = $_GET['vanMaand'];
    $page['vars']['van']['jaar']    = $_GET['vanJaar'];

    $page['vars']['tot']['dag']     = $_GET['totDag'];
    $page['vars']['tot']['maand']   = $_GET['totMaand'];
    $page['vars']['tot']['jaar']    = $_GET['totJaar'];

    $page['vars']['van']['totaal']  = mktime(0,  0,  0,  $page['vars']['van']['maand'],  $page['vars']['van']['dag'],    $page['vars']['van']['jaar']);
    $page['vars']['tot']['totaal']  = mktime(23, 59, 59, $page['vars']['tot']['maand'],  $page['vars']['tot']['dag'],    $page['vars']['tot']['jaar']);

    $page['vars']['status']         = $_GET['status'];

    if(isset($_GET['categorie']) && $_GET['categorie'] != 0)
    {
        $page['vars']['categorie'] = $_GET['categorie'];
    }

    if(isset($_GET['categorie']) && $_GET['categorie'] != 0)
    {
        $page['vars']['categorie'] = $_GET['categorie'];
    }

    if(isset($_GET['naam']))
        $page['vars']['naam'] = htmlspecialchars($_GET['naam']);

    if(isset($_GET['afgemeld']))
        $page['vars']['afgemeld'] =  $_GET['afgemeld'];

    $dateformat = "Y-m-d H:i:s";

    $queryvars = array( "%" .$page['vars']['opdracht']. "%", date($dateformat, $page['vars']['van']['totaal']), date($dateformat, $page['vars']['tot']['totaal']));
    $query = "
        SELECT
            i.id,
            i.naam,
            i.probleem,
            unix_timestamp(i.aangemeld) as aangemeld,
            s.status,
            ib.behandelaar_id,
            b.naam as behandelaarnaam,
            ia.id as id_incidentactie,
            ia.actie,
            c.categorie
        FROM
            {$page['settings']['locations']['db_prefix']}incidenten i
        LEFT JOIN
            {$page['settings']['locations']['db_prefix']}incidentbehandelaar ib
        ON
            i.id = ib.incident_id
        LEFT JOIN
            {$page['settings']['locations']['db_prefix']}behandelaar b
        ON
            b.id = ib.behandelaar_id
        LEFT JOIN
            {$page['settings']['locations']['db_prefix']}incidentacties ia
        ON
            i.id = ia.incident_id
        LEFT JOIN
            {$page['settings']['locations']['db_prefix']}status s
        ON
            i.status = s.id
        LEFT JOIN
            {$page['settings']['locations']['db_prefix']}categorie c
        ON
            i.categorie = c.id
        WHERE
            lower(probleem) like lower(?)
        AND
            aangemeld between ? and ?
    ";

    if(isset($page['vars']['status']) && $page['vars']['status'] != 0)
    {
        $queryvars[count($queryvars)] = $page['vars']['status'];
        $query .= " AND i.status = ?";
    }

    if(isset($page['vars']['naam']) && $page['vars']['naam'] != "")
    {
        $queryvars[count($queryvars)] = $page['vars']['naam'];
        $query .= " AND i.naam = ?";
    }

    if(isset($page['vars']['subcategorie']) && $page['vars']['subcategorie'] != 0)
    {
        $queryvars[count($queryvars)] = $page['vars']['subcategorie'];
        $query .= " AND sc.id = ?";
    }
    else if(isset($page['vars']['categorie']) && $page['vars']['categorie'] != 0)
    {
        $queryvars[count($queryvars)] = $page['vars']['categorie'];
        $query .= " AND c.id = ?";
    }

    if($page['vars']['afgemeld'] == "false")
        $query .= " AND i.afgemeld = 0";

    $query .= " order by i.id desc";
    
    $sth = $dbh -> do_placeholder_query($query, $queryvars,__LINE__,__FILE__);

    $counter = 0;
    while ($vars = $dbh -> fetch_array($sth))
    {
        if($vars['behandelaar_id'] == 0)
            $vars['behandelaarnaam'] = "Afdeling ICT";
        
        if(isset($output[$vars['id']]))
        {
            $check = true;
            foreach($output[$vars['id']]['behandelaars'] as $value)
            {
                if($value['id'] == $vars['behandelaar_id'])
                $check = false;
            }
            
            if($check)
                array_push($output[$vars['id']]['behandelaars'], array('id' => $vars['behandelaar_id'], 'naam' => $vars['behandelaarnaam']));
            
            $check = true;
            foreach($output[$vars['id']]['incidenten'] as $value)
            {
                if($value['id'] == $vars['id_incidentactie'])
                $check = false;
            }
            
            if($check)
                array_push($output[$vars['id']]['incidenten'], array('id' => $vars['id_incidentactie'], 'naam' => $vars['actie']));
        }
        else
        {
            $output[$vars['id']] = array(
                'id' => $san->SanitizeOutput($vars['id']),
                'naam' => spaceToNbsp($san->SanitizeOutput($vars['naam'])),
                'probleem' => $san->SanitizeOutput($vars['probleem']),
                'aangemeld' => $san->SanitizeOutput(date($page['settings']['datetime'],$vars['aangemeld'])),
                'status' => $san->SanitizeOutput($vars['status']),
                'behandelaars' => array(),
                'incidenten' => array(),
                'categorie' => $san->SanitizeOutput($vars['categorie']),
            );
            
            array_push($output[$vars['id']]['behandelaars'], array('id' => $vars['behandelaar_id'], 'naam' => $vars['behandelaarnaam']));
            array_push($output[$vars['id']]['incidenten'], array('id' => $vars['id_incidentactie'], 'naam' => $vars['actie']));
        }
    }
    
    echo json_encode($output);
?>