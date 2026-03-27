<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");
    
    $dbh = new sql();
    $dbh->connect();
    
    $today = mktime(23,59,59, date("m"),date("d"), date("Y"));	
    $lastMonth = mktime(0, 0, 0, date("m")-1, date("d"), date("Y"));
    
    if($_GET["open"] == 0)
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
                group_concat(distinct(ifnull(b.naam, 'Afdeling ICT'))) as behandelaar,
                ia.actie
            from
                toppie_categorie c
            join toppie_incidenten i
                on c.id = i.categorie
            join toppie_status s
                on i.status = s.id
            left join toppie_incidentbehandelaar ib
                on i.id = ib.incident_id
            left join toppie_behandelaar b
                on ib.behandelaar_id = b.id
            left join toppie_incidentacties ia
                on i.id = ia.incident_id
            where
                ((i.afgemeld = 0 and ib.behandelaar_id <> 10)
            or
                (i.afgemeld = 1 and aangemeld between ? and ?))
            and
                ia.id = (
                    select max(ia.id)
                    from toppie_incidentacties ia
                    where incident_id = i.id
                    group by incident_id
                )
            group by
                i.id,
                i.naam,
                i.probleem,
                i.aangemeld,
                c.categorie,
                s.status,
                i.afgemeld
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
                group_concat(distinct(ifnull(b.naam, 'Afdeling ICT'))) as behandelaar,
                ia.actie
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
                ia.id = (
                    select max(ia.id)
                    from toppie_incidentacties ia
                    where incident_id = i.id
                    group by incident_id
                )
            and
                ib.behandelaar_id <> 10
            group by
                i.id,
                i.naam,
                i.probleem,
                i.aangemeld,
                c.categorie,
                s.status,
                i.afgemeld
            order by
                i.id desc
        ";
    }

    
    $sth = $dbh->do_placeholder_query($sql,$sqlVars,__line__,__file__);

    if($dbh->total_rows($sth) > 0)
    {
        echo "
            <table>
                <thead>
                    <td>Naam</td>
                    <td style='width:80px'>Datum</td>
                    <td>Categorie</td>
                    <td>Probleem</td>
                    <td>Status</td>
                    <td>Behandelaar</td>
                </thead>
        ";
        
        $counter = 0;
        
        while($vars = $dbh->fetch_array($sth))
        {
            
            
            $temp = "<tr #class# #mouseEvent# onclick=\"window.open('toppiedesk.php?id=callnieuw&searchoid=#id#','_blank');\"><td>#naam#</td><td>#datum#</td><td>#categorie#</td><td class='probleem'>#probleem#</td><td>#status#</td><td>#behandelaar#</td></tr>";
            $temp = str_replace("#id#", $vars['id'], $temp);
            $temp = str_replace("#naam#", $vars['naam'],$temp);
            $temp = str_replace("#datum#", date("d-m-Y", $vars['aangemeld']),$temp);
            $temp = str_replace("#categorie#", $vars['categorie'], $temp);
            $temp = str_replace("#probleem#", $vars['probleem'], $temp);
            $temp = str_replace("#status#", $vars['status'],$temp);
            $temp = str_replace("#behandelaar#", str_replace(",", "<br />",$vars['behandelaar'] ), $temp);
            
            $number = $counter % 2;
            
            if((int)$vars['afgemeld'] == 0 && $number == 0)
                $temp = str_replace("#class#", 'class="even pointer"', $temp);
            else if((int)$vars['afgemeld'] == 0 && $number == 1)
                $temp = str_replace("#class#", 'class="odd pointer"', $temp);
            else if((int)$vars['afgemeld'] == 1 && $number == 0)
                $temp = str_replace("#class#", 'class="even pointer afgemeld"', $temp);
            else if((int)$vars['afgemeld'] == 1 && $number == 1)
                $temp = str_replace("#class#", 'class="odd pointer afgemeld"', $temp);
            
            if($vars['actie'] == "")
                $temp = str_replace("#mouseEvent#","",$temp);
            else
                $temp = str_replace("#mouseEvent#", "onmouseover=\"return tooltip('" + $vars['actie'] + "','','bordercolor:black, border:1, backcolor:#d3d3d3');\" onmouseout=\"return hideTip();\";", $temp);
            
            echo $temp;
            
            $counter++;
        }
        
        echo "</table>";
    }
    else
    {
        echo "Geen resultaten gevonden";
        
    }
?>