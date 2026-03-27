<div id="img">
    
</div>

<form action="toppiedesk.php" method="get">
    <input type="hidden" name="id" value="stats" />
    <input type="hidden" name="stat" value="incidentenpergebruiker" />
    naam: <input name="naam" class="hardware" value="{$output.vars.naam}" type="text" />
    <input type="submit" name="submit" value="Toon" /> 
</form>

{if isset($output.vars)}
    aantal meldingen van {$output.vars.naam}: {$output.counter.andere}<br /><br />
    
    <div id="resultaten" style="width:750px; margin:0px;">
        <table id="table">
            <thead>
                <tr>
                    <td>Naam</td>
                    <td>Datum</td>
                    <td>Categorie</td>
                    <td>Probleem</td>
                    <td>Status</td>
                    <td>Behandelaar</td>
                </tr>
            </thead>
            {if $output.counter.andere > 0}
                {foreach from=$output.andere item=andere}
                    <tr class="
                        {if $andere.color eq 1}odd
                        {elseif $andere.color eq 2}even oldborder
                        {elseif $andere.color eq 3}odd oldborder
                        {elseif $andere.color eq 5}user
                        {elseif $andere.color eq 0}even
                        {/if}
                        pointer"
                        {if $output.searchoid eq $andere.id}
                            id="selected"
                        {/if}
                        onclick=parent.location.href='toppiedesk.php?id=incidentnieuw&searchoid={$andere.id}'
                    >
                        <td>{$andere.naam}</td>
                        <td>{$andere.datum}</td>
                        <td>{$andere.categorie}</td>
                        <td class="probleem">{$andere.probleem}</td>
                        <td>{$andere.status}</td>
                        <td>{$andere.behandelaar}</td>
                    </tr>
                {/foreach}
            {else}
                <tr><td colspan="6">Geen incidenten</td></tr>
            {/if}
        </table>
    </div>
{/if}

