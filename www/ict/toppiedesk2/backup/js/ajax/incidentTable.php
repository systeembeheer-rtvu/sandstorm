<div id="resultaten">
<?php
    require_once("../../config.inc.php");
    require_once("../../libs/mysql.inc.php");

    if($_GET['aanmelder'] != "" || $_GET['hardware'] != "")
    {
        $dbh = new sql();
        $dbh->connect();
        
        $queryvars = array();
        $query = "
            select
                i.id,
                i.naam,
                i.probleem,
                UNIX_TIMESTAMP(i.aangemeld) as aangemeld,
                c.categorie,
                s.status,
                i.afgemeld,
                group_concat(distinct(ifnull(b.naam, 'Afdeling ICT'))) as behandelaar,
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
            #phWhere#
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
        
        $phWhere = "";
        $first = true;
        
        if($_GET['aanmelder'] != "")
        {
            $first = false;
            $phWhere = "where i.naam = ? ";
            array_push($queryvars, $_GET['aanmelder']);
        }
        
        if($_GET['hardware'] != "")
        {
            if($first)
                $phWhere = "where i.asset = ? ";
            else
                $phWhere .= "or i.asset = ? ";
                
            array_push($queryvars, $_GET['hardware']);
        }
        
        $query = str_replace("#phWhere#",$phWhere, $query );
        
        $sth = $dbh->do_placeholder_query($query,$queryvars,__line__,__file__);
    
        if($dbh->total_rows($sth) > 0)
        {
            echo "
                <div style='background:#000;color:#fff;font-size:150%;'>Geschiedenis</div>
                <table>
                    <thead>
                        <td style='width:80px'>Datum</td>
                        <td>Categorie</td>
                        <td>Probleem</td>
                        <td>status</td>
                        <td>behandelaar</td>
                    </thead>
            ";
            
            $counter = 0;
            
            while($vars = $dbh->fetch_array($sth))
            {
                $temp = "<tr #class# onclick=\"window.open('toppiedesk.php?id=callnieuw&searchoid=#id#','_blank');\"><td>#datum#</td><td>#categorie#</td><td class='probleem'>#probleem#</td><td>#status#</td><td>#behandelaar#</td></tr>";
                $temp = str_replace("#id#", $vars['id'], $temp);
                $temp = str_replace("#naam#", $vars['naam'],$temp);
                $temp = str_replace("#datum#", date("d-m-Y", $vars['aangemeld']),$temp);
                $temp = str_replace("#categorie#", $vars['categorie'], $temp);
                $temp = str_replace("#probleem#", $vars['probleem'], $temp);
                $temp = str_replace("#status#", $vars['status'],$temp);
                $temp = str_replace("#behandelaar#", $vars['behandelaar'], $temp);
                
                $number = $counter % 2;
                
                if((int)$vars['afgemeld'] == 0 && $number == 0)
                    $temp = str_replace("#class#", 'class="even pointer"', $temp);
                else if((int)$vars['afgemeld'] == 0 && $number == 1)
                    $temp = str_replace("#class#", 'class="odd pointer"', $temp);
                else if((int)$vars['afgemeld'] == 1 && $number == 0)
                    $temp = str_replace("#class#", 'class="even pointer afgemeld"', $temp);
                else if((int)$vars['afgemeld'] == 1 && $number == 1)
                    $temp = str_replace("#class#", 'class="odd pointer afgemeld"', $temp);
                
                echo $temp;
                
                $counter++;
            }
            
            echo "</table>";
        }
        else
        {
            echo "Geen resultaten gevonden";
            
        }
    }
?>
</div>