<div class="formulier">
    <div id="resultaten">
        <table id="table" width="800px">
            <tr style="border-bottom:1px solid #000000">
                <thead>
                    <td>Titel</td>
                    <td>Deadline</td>
                    <td>Medewerkers</td>
                    <td>Geplande tijd</td>
                    <td>Bestede tijd</td>
                </thead>
            </tr>
            {foreach from=$output.project item=project}
                <tr style="border-bottom: 1px solid #000000">
                    <td valign="top">{if $project.top10 eq 1}<b>{$project.titel}</b>{else}{$project.titel}{/if}</td>
                    <td valign="top">{if $project.top10 eq 1}<b>{$project.deadline}</b>{else}{$project.deadline}{/if}</td>
                    <td valign="top"><b>{$project.naam}</b><br />{$project.medewerkers}</td>
                    <td valign="top">{if $project.top10 eq 1}<b>{$project.geplandetijd}</b>{else}{$project.geplandetijd}{/if}</td>
                    <td valign="top">{if $project.top10 eq 1}<b>{$project.bestedetijd}</b>{else}{$project.bestedetijd}{/if}</td>
                </tr>
            {/foreach}
        </table>
    </div>
</div>