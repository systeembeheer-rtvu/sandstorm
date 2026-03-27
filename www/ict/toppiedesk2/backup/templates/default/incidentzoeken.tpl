<div class="formulier">
    <h1>Incident Zoeken</h1>
    <table>
        <tr>
            <td style="vertical-align: top;">
                <form id="dataform" action="" method="post">
                    <input type="hidden" name="id" value="incidentzoeken" />
                    <input type="hidden" name="empty" value="1" />
                    <table>
                        <tr>
                            <td><label for="opdracht">Zoekopdracht</label></td>
                            <td><input type="text" id="opdracht" name="opdracht" value="{$output.vars.opdracht}" /></td>
                        </tr>
                        <tr>
                            <td><label for="naam">Aanmelder</label></td>
                            <td><input type="text" class="naam" name="naam" value="{$output.vars.naam}" /></td>
                        </tr>
                        <tr>
                            <td><label>Van</label></td>
                            <td>
                                <select name="dagvan">
                                    {section name=day loop=31} 
                                        <option {if $output.vars.van.dag eq $smarty.section.day.iteration} selected="selected" {/if} value="{$smarty.section.day.iteration}">{$smarty.section.day.iteration}</option>
                                    {/section}
                                </select>
                                <select name="maandvan">
                                    {section name=month loop=12} 
                                        <option {if $output.vars.van.maand eq $smarty.section.month.iteration} selected="selected" {/if} value="{$smarty.section.month.iteration}">{$smarty.section.month.iteration}</option>
                                    {/section}
                                </select>
                                <select name="jaarvan">
                                    {section name=year start=2010 loop=$output.vars.huidig.jaar+1}
                                        <option {if $output.vars.van.jaar eq $smarty.section.year.index} selected="selected" {/if} value="{$smarty.section.year.index}">{$smarty.section.year.index}</option>
                                    {/section}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Tot</label></td>
                            <td>
                                <select name="dagtot">
                                {section name=day loop=31} 
                                    <option {if $output.vars.tot.dag eq $smarty.section.day.iteration} selected="selected" {/if} value="{$smarty.section.day.iteration}">{$smarty.section.day.iteration}</option>
                                {/section}
                                </select>
                                <select name="maandtot">
                                    {section name=month loop=12} 
                                        <option {if $output.vars.tot.maand eq $smarty.section.month.iteration} selected="selected" {/if} value="{$smarty.section.month.iteration}">{$smarty.section.month.iteration}</option> 
                                    {/section}
                                </select>
                                <select name="jaartot">
                                    {section name=year start=2010 loop=$output.vars.huidig.jaar+1}
                                        <option {if $output.vars.tot.jaar eq $smarty.section.year.index} selected="selected" {/if} value="{$smarty.section.year.index}">{$smarty.section.year.index}</option>
                                    {/section}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="status">Status</label></td>
                            <td>
                                <select name="status">
                                    {foreach from=$output.status item=status} 
                                        <option value="{$status.id}" {if $output.vars.status eq $status.id} selected="selected" {/if} >{$status.status}</option>    
                                    {/foreach}
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="categorie">Categorie</label></td>
                            <td>
                                <select id="categorie" name="categorie">
                                    {foreach from=$output.categorie item=categorie}
                                        <option {if $output.vars.categorie eq $categorie.id} selected="selected" {/if} value="{$categorie.id}">{$categorie.categorie}</option>
                                    {/foreach}
                                </select>
                            </td>
                    </table>
                    <input type="checkbox" name="aangemeld" {if $output.vars.aangemeld eq "on"} checked {/if} id="aangemeld" /> <label for="aangemeld">Openstaande incidenten weergeven</label><br />
                    <input type="checkbox" name="afgemeld" {if $output.vars.afgemeld eq "on"} checked {/if} id="afgemeld" /> <label for="afgemeld">Gesloten incidenten weergeven</label><br />
                    <input type="submit" name="zoeken" value="zoeken" />
                </form>
            </td>
        </tr>
    </table>
</div>
<div id="resultaten">
                    <table width="800px">
                        <tr>
                            <thead>
                                <td>Naam</td>
                                <td>Datum</td>
                                <td>Categorie</td>
                                <td>Probleem</td>
                                <td>Status</td>
                                <td>Behandelaar</td>
                            </thead>
                        </tr>
                        {if $output.counter > 0}
                            {foreach from=$output.incidenten item=incident}
                                <tr
                                    class="
                                        {if $incident.color eq 1}odd
                                        {elseif $incident.color eq 2}even oldborder
                                        {elseif $incident.color eq 3}odd oldborder
                                        {elseif $incident.color eq 5}user
                                        {else}even
                                        {/if}
                                        
                                        {if $incident.afgemeld eq 1}afgemeld{/if} pointer"
									onclick="window.open('toppiedesk.php?id=callnieuw&searchoid={$incident.id}','_blank');"
                                >
                                    <td>{$incident.naam}</td>
                                    <td>{$incident.datum}</td>
                                    <td>{$incident.categorie}</td>
                                    <td>{$incident.probleem}</td>
                                    <td>{$incident.status}</td>
                                    <td>{$incident.behandelaar}</td>
                                </tr>
                            {/foreach}
                        {else}
                            <tr><td colspan="6">Geen resultaten</td></tr>
                        {/if}
                    </table>
                </div>