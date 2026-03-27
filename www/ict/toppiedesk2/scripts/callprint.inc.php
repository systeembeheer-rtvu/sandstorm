<?php
    $page['classes']['load'] = new Incidentprint();
    class Incidentprint
    {
        function GetFileName()
        {
            global $tracer;
	    $tracer .= "- Incidentprint/GetFileName()<br />";
	    
	    return "incidentprint";
        }
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "searchoid" => array("searchoid","get","int")
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
            global $tracer, $input, $page, $output;
	    $tracer .= "- Incidentprint/DoRun()<br />";
            
            $page['settings']['locations']['default_site']['header'] = "headers/printheader";
	    $page['settings']['locations']['default_site']['sidebar'] = "sidebars/printsidebar";
	    
	    $queryvars = array($input['searchoid']);
	    $query = "
		select
		    i.naam,
		    i.telefoonnummer,
		    i.afdeling,
		    i.probleem,
		    UNIX_TIMESTAMP(i.datum) as datum,
		    c.categorie,
		    s.status,
		    b.naam as invoerder
		from
		    `toppie_incidenten` i,
		    `toppie_categorie` c,
		    `toppie_status` s,
		    `toppie_behandelaar` b
		where
		    i.id = ?
		and
		    i.categorie = c.id
		and
		    i.status = s.id
		and
		    i.invoerder = b.id
	    ";
	    
	    $sth = $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
            $vars = $page['classes']['sql']->fetch_array($sth);
	    
	    $output['incident']['telefoonnummer'] = $vars['telefoonnummer'];
	    $output['incident']['naam'] = $vars['naam'];
	    $output['incident']['afdeling'] = $vars['afdeling'];
	    $output['incident']['categorie'] = $vars['categorie'];
	    $output['incident']['status'] = $vars['status'];
	    $output['incident']['probleem'] = $vars['probleem'];
	    $output['incident']['invoerder'] = $vars['invoerder'];
	    $output['incident']['aangemeld'] = date($page['settings']['datetime'], $vars['datum']);
	    
	    $query = "
		select
		    ib.behandelaar_id
		    naam
		from
		    `toppie_incidentbehandelaar` ib
		left join
		    `toppie_behandelaar` b
		on
		    ib.behandelaar_id = b.id
		where
		    ib.incident_id = ?
	    ";
	    
	    $counter = 0;
	    $sth = $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
            while($vars = $page['classes']['sql']->fetch_array($sth))
	    {
		if($vars['behandelaar_id'] == 0)
		    $output['behandelaars'][$counter++]['naam'] = "Afdeling ICT";
		else
		    $output['behandelaars'][$counter++]['naam'] = $vars['naam'];
	    }
	    
	    $query = "
		select
		    ia.actie,
		    UNIX_TIMESTAMP(ia.datum) as datum,
		    b.naam
		from
		    `toppie_incidentacties` ia,
		    `toppie_behandelaar` b
		where
		    ia.behandelaar = b.id
		and
		    ia.incident_id = ?
	    ";
	    
	    $counter = 0;
	    $sth = $page['classes']['sql']->do_placeholder_query($query, $queryvars,__LINE__,__FILE__);
            while($vars = $page['classes']['sql']->fetch_array($sth))
	    {
		$output['incident']['actie'][$counter++] = array(
                    'actie' => $vars['actie'],
                    'behandelaar' => $vars['naam'],
                    'datum' =>  date($page['settings']['datetime'],$vars['datum'])
                );
	    }
        }
        
        function GetSidebarType()
        {
            global $tracer;
	    $tracer .= "- Incidentprint/GetSidebarType()<br />";
            
            return "";
        }
    }
?>