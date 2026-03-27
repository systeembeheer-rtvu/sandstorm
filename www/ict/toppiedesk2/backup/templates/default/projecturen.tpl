<div class="formulier">
    	<!--
		<h1>Projecturen</h1>
	-->
	<div class="header">
		<span class="title">Projecturen</span>
	        <div style="float:right;"><a href="turbodesk.php?id=projecturen&week={$output.vorige}">Vorige</a> <a href="turbodesk.php?id=projecturen&week={$output.volgende}">Volgende</a></div>
	</div>

    <div id="resultaten">
        <form form="js_submit" action="toppiedesk.php?id=projecturen" method="post">
            <input type="hidden" name="week" value="{$output.huidige}" />
            <input type="hidden" name="id" value="projecturen" />
            <table>
                <tr>
                    <td>Medewerker</td>
                    <td>
                        <select name="medewerker" onChange="this.form.submit();">
                            {foreach from=$output.behandelaars item=behandelaar}
                                <option value="{$behandelaar.id}" {if $behandelaar.selected eq "true"}selected="selected"{/if}>{$behandelaar.naam}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Datum</td>
                    <td><input type="text" name="datum" value="{$output.search.datum}"  /><input type="submit" name="submit" value="Weergeven" /></td>
                </tr>
            </table>
        </form>
        {if $output.medewerker > 0}
            <h2>{$output.project.naam} - {$output.weeknummer}</h2>
            <table id="table">
                <tr class="even">
                    <td>Maandag</td>
		    <td>{$output.dagen.ma}</td>
                    <td>
                        <table style="width:100%">
                            {foreach from=$output.project.projecten.1 item=project}
                                <tr style="border:1px solid #000000">
                                    <td style="border:none;">
                                        {if $project.type eq "incident"}<a href="turbodesk.php?id=callnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>
                                        {else}<a href="toppiedesk.php?id=projectnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>{/if}
                                    </td>
                                    <td style="border:none; padding-left:20px; text-align:right;"><b> {$project.bestedetijd}</b></td>
                                </tr>
                            {/foreach}
                        </table>
                    </td>
                </tr>
                <tr class="odd">
                    <td>Dinsdag</td>
		    <td>{$output.dagen.di}</td>
                    <td>
                        <table style="width:100%">
                            {foreach from=$output.project.projecten.2 item=project}
                                <tr style="border:1px solid #000000">
                                    <td style="border:none;">
                                       {if $project.type eq "incident"}<a href="turbodesk.php?id=callnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>
                                        {else}<a href="toppiedesk.php?id=projectnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>{/if}
                                    </td>
                                    <td style="border:none; padding-left:20px; text-align:right;"><b> {$project.bestedetijd}</b></td>
                                </tr>
                            {/foreach}
                        </table>
                    </td>
                </tr>
                <tr class="even">
                    <td>Woensdag</td>
		    <td>{$output.dagen.wo}</td>
                    <td>
                        <table style="width:100%">
                            {foreach from=$output.project.projecten.3 item=project}
                                <tr style="border:1px solid #000000">
                                    <td style="border:none;">
                                       {if $project.type eq "incident"}<a href="turbodesk.php?id=callnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>
                                        {else}<a href="toppiedesk.php?id=projectnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>{/if}
                                    </td>
                                    <td style="border:none; padding-left:20px; text-align:right;"><b> {$project.bestedetijd}</b></td>
                                </tr>
                            {/foreach}
                        </table>
                    </td>
                </tr>
                <tr class="odd">
                    <td>Donderdag</td>
		    <td>{$output.dagen.do}</td>
                    <td>
                        <table style="width:100%">
                            {foreach from=$output.project.projecten.4 item=project}
                                <tr style="border:1px solid #000000">
                                    <td style="border:none;">
                                        {if $project.type eq "incident"}<a href="turbodesk.php?id=callnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>
                                        {else}<a href="toppiedesk.php?id=projectnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>{/if}
                                    </td>
                                    <td style="border:none; padding-left:20px; text-align:right;"><b> {$project.bestedetijd}</b></td>
                                </tr>
                            {/foreach}
                        </table>
                    </td>
                </tr>
                <tr class="even">
                    <td>Vrijdag</td>
		    <td>{$output.dagen.vr}</td>
                    <td>
                        <table style="width:100%">
                            {foreach from=$output.project.projecten.5 item=project}
                                <tr style="border:1px solid #000000">
                                    <td style="border:none;">
                                        {if $project.type eq "incident"}<a href="turbodesk.php?id=callnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>
                                        {else}<a href="toppiedesk.php?id=projectnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>{/if}
                                    </td>
                                    <td style="border:none; padding-left:20px; text-align:right;"><b> {$project.bestedetijd}</b></td>
                                </tr>
                            {/foreach}
                        </table>
                    </td>
                </tr>
                <tr class="odd">
                    <td>Zaterdag</td>
		    <td>{$output.dagen.za}</td>
                    <td>
                        <table style="width:100%">
                            {foreach from=$output.project.projecten.6 item=project}
                                <tr style="border:1px solid #000000">
                                    <td style="border:none;">
                                       {if $project.type eq "incident"}<a href="turbodesk.php?id=callnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>
                                        {else}<a href="toppiedesk.php?id=projectnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>{/if}
                                    </td>
                                    <td style="border:none; padding-left:20px; text-align:right;"><b> {$project.bestedetijd}</b></td>
                                </tr>
                            {/foreach}
                        </table>
                    </td>
                </tr>
                <tr class="even">
                    <td>Zondag</td>
		    <td>{$output.dagen.zo}</td>
                    <td>
                        <table style="width:100%">
                            {foreach from=$output.project.projecten.0 item=project}
                                <tr style="border:1px solid #000000">
                                    <td style="border:none;">
                                       {if $project.type eq "incident"}<a href="turbodesk.php?id=callnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>
                                        {else}<a href="toppiedesk.php?id=projectnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>{/if}
                                    </td>
                                    <td style="border:none; padding-left:20px; text-align:right;"><b> {$project.bestedetijd}</b></td>
                                </tr>
                            {/foreach}
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:center;">
                        <a href="turbodesk.php?id=projecturen&medewerker={$output.medewerker}&week={$output.vorige}">Vorige</a> <a href="turbodesk.php?id=projecturen&medewerker={$output.medewerker}&week={$output.volgende}">Volgende</a>
                    </td>
                </tr>
            </table>
        {else}
            <h2>{$output.weeknummer}</h2>
            <table id="table">
                <thead>
                    <tr>
                        <td></td>
                        <td>Maandag</td>
                        <td>Dinsdag</td>
                        <td>Woensdag</td>
                        <td>Donderdag</td>
                        <td>Vrijdag</td>
                        <td>Zaterdag</td>
                        <td>Zondag</td>
                    </tr>
		    <tr>
			<td></td>
			<td>{$output.dagen.ma}</td>
			<td>{$output.dagen.di}</td>
			<td>{$output.dagen.wo}</td>
			<td>{$output.dagen.do}</td>
			<td>{$output.dagen.vr}</td>
			<td>{$output.dagen.za}</td>
			<td>{$output.dagen.zo}</td>
			</tr>
                </thead>
                {if $output.project|@count gt 0}
                    {foreach from=$output.project item=gebruiker}
                        <tr class="{if $gebruiker.color eq 0}odd{elseif $gebruiker.color eq 1}even{/if}" >
                            <td>
                                {$gebruiker.naam}
                            </td>
                            <td>
                                <table style="width:100%;">
                                    {foreach from=$gebruiker.projecten.1 item=project}
                                        <tr style="border: solid 1px #000" />
                                            <td style="border:none;">
                                                {if $project.type eq "incident"}<a href="turbodesk.php?id=callnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>
						{else}<a href="toppiedesk.php?id=projectnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>{/if}
                                            </td>
                                            <td style="border:none; padding-left:20px; text-align:right;"><b> {$project.bestedetijd}</b></td>
                                        </tr>
                                    {/foreach}
                                </table>
                            </td>
                            <td>
                                <table style="width:100%;">
                                    {foreach from=$gebruiker.projecten.2 item=project}
                                        <tr style="border: solid 1px #000" />
                                            <td style="border:none;">
                                                {if $project.type eq "incident"}<a href="turbodesk.php?id=callnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>
						{else}<a href="toppiedesk.php?id=projectnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>{/if}
                                            </td>
                                            <td style="border:none; padding-left:20px; text-align:right;"><b> {$project.bestedetijd}</b></td>
                                        </tr>
                                    {/foreach}
                                </table>
                            </td>
                            <td>
                                <table style="width:100%;">
                                    {foreach from=$gebruiker.projecten.3 item=project}
                                        <tr style="border: solid 1px #000" />
                                            <td style="border:none;">
                                                {if $project.type eq "incident"}<a href="turbodesk.php?id=callnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>
						{else}<a href="toppiedesk.php?id=projectnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>{/if}
                                            </td>
                                            <td style="border:none; padding-left:20px; text-align:right;"><b> {$project.bestedetijd}</b></td>
                                        </tr>
                                    {/foreach}
                                </table>
                            </td>
                            <td>
                                <table style="width:100%;">
                                    {foreach from=$gebruiker.projecten.4 item=project}
                                        <tr style="border: solid 1px #000" />
                                            <td style="border:none;">
                                               {if $project.type eq "incident"}<a href="turbodesk.php?id=callnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>
						{else}<a href="toppiedesk.php?id=projectnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>{/if}
                                            </td>
                                            <td style="border:none; padding-left:20px; text-align:right;"><b> {$project.bestedetijd}</b></td>
                                        </tr>
                                    {/foreach}
                                </table>
                            </td>
                            <td>
                                <table style="width:100%;">
                                    {foreach from=$gebruiker.projecten.5 item=project}
                                        <tr style="border: solid 1px #000" />
                                            <td style="border:none;">
                                               {if $project.type eq "incident"}<a href="turbodesk.php?id=callnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>
						{else}<a href="toppiedesk.php?id=projectnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>{/if}
                                            </td>
                                            <td style="border:none; padding-left:20px; text-align:right;"><b> {$project.bestedetijd}</b></td>
                                        </tr>
                                    {/foreach}
                                </table>
                            </td>
                            <td>
                                <table style="width:100%;">
                                    {foreach from=$gebruiker.projecten.6 item=project}
                                        <tr style="border: solid 1px #000" />
                                            <td style="border:none;">
                                                {if $project.type eq "incident"}<a href="turbodesk.php?id=callnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>
						{else}<a href="toppiedesk.php?id=projectnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>{/if}
                                            </td>
                                            <td style="border:none; padding-left:20px; text-align:right;"><b> {$project.bestedetijd}</b></td>
                                        </tr>
                                    {/foreach}
                                </table>
                            </td>
                            <td>
                                <table style="width:100%;">
                                    {foreach from=$gebruiker.projecten.0 item=project}
                                        <tr style="border: solid 1px #000" />
                                            <td style="border:none;">
                                                {if $project.type eq "incident"}<a href="turbodesk.php?id=callnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>
						{else}<a href="toppiedesk.php?id=projectnieuw&searchoid={$project.link}" target="_blank">{$project.project}</a>{/if}
                                            </td>
                                            <td style="border:none; padding-left:20px; text-align:right;"><b> {$project.bestedetijd}</b></td>
                                        </tr>
                                    {/foreach}
                                </table>
                            </td>
                        </tr>
                    {/foreach}
                {else}
                    <tr class="even">
                        <td colspan="8" style="text-align:center;">
                            Er zijn geen projecten deze week
                        </td>
                    </tr>
                {/if}
            </table>
        {/if}
        
    </div>
</div>