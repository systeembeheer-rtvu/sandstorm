<table>
    <tr>
        <td class="staticwidth">Aangemeld op:</td>
        <td class="rightspacewb">{$output.incident.aangemeld}</td>
        <td>Status:</td>
        <td>{$output.incident.status}</td>
    </tr>
    <tr>
        <td class="staticwidth">Invoerder:</td>
        <td class="rightspacewb">{$output.incident.invoerder}</td>
        <td class="rightspace" style="vertical-align:top;">Behandelaar(s):</td>
        <td rowspan="5" style="vertical-align:top;">
            {foreach from=$output.behandelaars item=behandelaar}
                {$behandelaar.naam}<br />
            {/foreach}
        </td>
    </tr>
    <tr>
        <td class="staticwidth topborder">Tel#:</td>
        <td class="rightspacewb topborder">{$output.incident.telefoonnummer}</td>
        
    </tr>
    <tr>
        <td class="staticwidth">Naam:</td>
        <td class="rightspacewb">{$output.incident.naam}</td>
        
    </tr>
    <tr>  
        <td class="staticwidth">Afdeling:</td>
        <td class="rightspacewb">{$output.incident.afdeling}</td>
    </tr>
    <tr>
        <td class="staticwidth">
            Categorie:
        </td>
        <td class="rightspacewb">
            {$output.incident.categorie}
        </td>
    </tr>
    <tr class="topspace">
        <td colspan="4">Melding:</td>
    </tr>
    <tr>
        <td colspan="4">{$output.incident.probleem}</td>
    </tr>
    {if $output.incident.actie|@count gt 0}
        <tr class="topspace">
            <td colspan="4">Actie(s):</td>
        </tr>
        {foreach from=$output.incident.actie item=i}
            <tr class="actie">    
                <td colspan="4">{$i.datum} {$i.behandelaar}</td>
            </tr>
            <tr>
                <td colspan="4" class="omschrijving">{$i.actie}</td>
            </tr>
        {/foreach}
    {/if}
</table>