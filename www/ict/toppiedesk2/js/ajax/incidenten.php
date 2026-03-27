<?php
    date_default_timezone_set('Europe/Belgrade');

    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    require_once("../../scripts/functions/functions.inc.php");
    require_once("../../scripts/functions/sanitizer.inc.php");
    
    $dbh = new sql();
    
    $dbh->connect();
    
    $san = new Sanitizer();
    
    $query = "
        SELECT i.id, i.naam, i.probleem, unix_timestamp(i.aangemeld) as aangemeld, b.behandelaar_id
        FROM {$page['settings']['locations']['db_prefix']}incidenten i
        LEFT JOIN toppie_incidentbehandelaar b
        ON i.id = b.incident_id
        WHERE i.afgemeld = 0
        ORDER BY id
    ";
    
    $sth = $dbh -> do_query($query,__line__,__file__);
    
    $counter = 0;
    
    while($vars = $dbh->fetch_array($sth))
    {
        $output['incidenten'][$counter++] = array(
            'id' => $vars['id'],
            'naam' => spaceToNbsp($vars['naam']),
            'probleem' => $san->SanitizeOutput($vars['probleem']),
            'aangemeld' => spaceToNbsp(date($page['settings']['datetime'],$vars['aangemeld'])),
            'behandelaar' => $vars['behandelaar_id']
        );
    }
 
    $query = "
        SELECT * FROM " . $page['settings']['locations']['db_prefix'] . "behandelaar 
    ";
    $sth = $dbh->do_query($query,__LINE__,__FILE__);
    
    $counter = 0;
    
    $output['behandelaars'][$counter++] = array('id' => 0, 'naam' => 'Afdeling ICT', 'actief' => 0, 'selected' => "true");
    
    while($vars = $dbh->fetch_array($sth))
    {
        $output['behandelaars'][$counter++] = array(
            'id' => $vars['id'],
            'naam' => spaceToNbsp($vars['naam']),
            'actief' => $vars['actief'],
            'selected' => "false");
    }
    
    echo json_encode($output);
?>