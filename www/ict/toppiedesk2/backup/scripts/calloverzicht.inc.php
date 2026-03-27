<?php
    $page['classes']['load'] = new IncidentOverzicht();
    
    class IncidentOverzicht
    {
        function GetFileName()
        {
            return "incidentoverzicht";
        }
        
        function GetVars()
        {
            return array(
                "input" => array(
                    "first" => array("first", "both", "int"),
			"open" => array("open", "both", ""),
			"versturen" => array("versturen", "both", "")
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
	    global $input, $page, $output;
	    
	    $today = mktime(23,59,59, date("m"),date("d"), date("Y"));	
	    $lastMonth = mktime(0, 0, 0, date("m")-1, date("d"), date("Y"));
	    
	    if($input["versturen"] == "Toon")
		$output["open"] = $input["open"] == "on" ? 1 : 0;
	    else
		$output["open"] = 1;
    
	    if($output["open"] ==0)
	    {
		$sqlVars = array(date("Y-m-d H:i:s", $lastMonth), date("Y-m-d H:i:s", $today));
		$sql = "
		    select
			i.id,
			i.naam,
			i.probleem,
			UNIX_TIMESTAMP(i.aangemeld) as aangemeld,
			c.categorie,
			s.status,
			i.afgemeld,
			ifnull(ib.behandelaar_id,0) as behandelaar_id,
			ifnull(b.naam, 'Afdeling ICT') as behandelaar,
			max(ia.actie) as actie
		    from
			toppie_categorie c
		    join
			toppie_incidenten i
		    on
			c.id = i.categorie
		    join
			toppie_status s
		    on
			i.status = s.id
		    left join
			toppie_incidentbehandelaar ib
		    on
			i.id = ib.incident_id
		    left join
			toppie_behandelaar b
		    on
			ib.behandelaar_id = b.id
		    left join
			toppie_incidentacties ia
		    on
			i.id = ia.incident_id
		    where
			(i.afgemeld = 0 and ib.behandelaar_id <> 10)
		    or
			(i.afgemeld = 1 and aangemeld between ? and ?)
		    group by
			i.id,
			i.naam,
			i.probleem,
			i.aangemeld,
			c.categorie,
			s.status,
			i.afgemeld,
			ib.behandelaar_id,
			b.naam
		    order by i.id desc
		";
	    }
	    else
	    {
		$sqlVars = array();
		$sql = "
		    select
			i.id,
			i.naam,
			i.probleem,
			UNIX_TIMESTAMP(i.aangemeld) as aangemeld,
			c.categorie,
			s.status,
			i.afgemeld,
			ifnull(ib.behandelaar_id,0) as behandelaar_id,
			ifnull(b.naam, 'Afdeling ICT') as behandelaar,
			max(ia.actie) as actie
		    from
			toppie_categorie c
		    join
			toppie_incidenten i
		    on
			c.id = i.categorie
		    join
			toppie_status s
		    on
			i.status = s.id
		    left join
			toppie_incidentbehandelaar ib
		    on
			i.id = ib.incident_id
		    left join
			toppie_behandelaar b
		    on
			ib.behandelaar_id = b.id
		    left join
			toppie_incidentacties ia
		    on
			i.id = ia.incident_id
		    where
			i.afgemeld = 0
		    and
			ib.behandelaar_id <> 10
		    group by
			i.id,
			i.naam,
			i.probleem,
			i.aangemeld,
			c.categorie,
			s.status,
			i.afgemeld,
			ib.behandelaar_id,
			b.naam
		    order by
			i.id desc
		";
	    }
	    
	    $sth = $page['classes']['sql']->do_placeholder_query($sql, $sqlVars,  __LINE__, __FILE__);
	    
	    $counter = 0;
	    $dagen = 6;
	    
	    while($vars = $page['classes']['sql']->fetch_array($sth))
	    {
		if(!isset($output['overzicht'][$vars['id']]))
		{
		    $output['overzicht'][$vars['id']] = array(
			'id' => $vars['id'],
			'naam' => $vars['naam'],
			'probleem' => $vars['probleem'],
			'datum' => date("d-m-Y", $vars['aangemeld']),
			'categorie' => $vars['categorie'],
			'status' => $vars['status'],
			'afgemeld' => $vars['afgemeld'],
			'color'=> $counter % 2,
			'behandelaar' => $vars['behandelaar'],
			'actie' => $vars['actie']
		    );
		    
		    $timestamp = $vars['aangemeld'];
		    
		    if($_COOKIE['behandelaar'] == $vars['behandelaar_id'])
		    {
			$output['overzicht'][$vars['id']]['color'] = 5;
		    }
		    
		    $counter++;
		}
		else
		{
		    $output['overzicht'][$vars['id']]['behandelaar'] = $output['overzicht'][$vars['id']]['behandelaar'] . "<br /> " . $vars['behandelaar'];
		    
		    if($_COOKIE['behandelaar'] == $vars['behandelaar_id'])
		    {
			$output['overzicht'][$vars['id']]['color'] = 5;
		    }
		}	
	    }
	    
	    $output['counter']['overzicht'] = $counter;
	    $output['page']['id']="callnieuw";
        }
        
        function GetSidebarType()
        {
            return "incident";
        }
    }
?>