<div class="formulier">
    <h1>Project Zoeken</h1>
    <form action="toppiedesk.php?id=projectzoeken" id="dataform" method="post">
        <table>
            <tr>
                <td>Titel</td>
                <td><input type="text" name="titel" value="{$output.search.titel}" /></td>
            </tr>
            <tr>
                <td>Deadline</td>
                <td><input type="text" name="deadline" value="{$output.search.deadline}" /></td>
            </tr>
            <tr>
                <td>Doel</td>
                <td><input type="text" name="doel" value="{$output.search.doel}"</td>
            </tr>
            <tr>
                <td>Opdrachtgever</td>
                <td><input type="text" name="opdrachtgever" class="naam" value="{$output.search.opdrachtgever}"</td>
            </tr>
            <tr>
                <td>Verantwoordelijke</td>
                <td>
                    <select name="verantwoordelijke">
                        {foreach from=$output.behandelaars item=behandelaar}
                            <option value="{$behandelaar.id}" {if $behandelaar.selected eq "true"}selected="selected"{/if}>{$behandelaar.naam}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="checkbox" name="aangemeld" {if $output.search.aangemeld eq "on"} checked {/if} id="aangemeld" /> <label for="aangemeld">Openstaande projecten weergeven</label><br />
                    <input type="checkbox" name="afgemeld" {if $output.search.afgemeld eq "on"} checked {/if} id="afgemeld" /> <label for="afgemeld">Gesloten projecten weergeven</label><br />
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:right;"><input type="submit" name="submit" value="Zoeken" /></td>
            </tr>
        </table>
    </form>
</div>

<div id="resultaten">
    <table id="table">
        <tr>
            <thead>
                <td>Titel</td>
                <td>Verantwoordelijke</td>
                <td>Deadline</td>
                <td>Medewerkers</td>
                <td>Geplande tijd</td>
                <td>Bestede tijd</td>
                <td>Start datum</td>
                <td>Datum gesloten</td>
            </thead>
        </tr>
        {if $output.counter > 0}
            {foreach from=$output.project item=project}
                <tr
                    class="
                        {if $project.color eq 1}odd
                        {elseif $project.color eq 2}even oldborder
                        {elseif $project.color eq 3}odd oldborder
                        {else}even
                        {/if}
                        
                        {if $project.afgemeld eq 1}afgemeld{/if} pointer"
                    onclick=parent.location.href='toppiedesk.php?id=projectnieuw&searchoid={$project.id}'
                >
                    <td>{$project.titel}</td>
                    <td>{$project.verantwoordelijk}</td>
                    <td>{$project.deadline}</td>
                    <td>{$project.medewerkers}</td>
                    <td>{$project.geplandetijd}</td>
                    <td>{$project.bestedetijd}</td>
                    <td>{$project.aangemaaktop}</td>
                    <td>{$project.geslotenop}</td>
                </tr>
            {/foreach}
        {else}
            <tr><td colspan="6">Geen resultaten</td></tr>
        {/if}
    </table>
</div>