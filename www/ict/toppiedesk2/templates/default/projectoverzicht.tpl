<div class="formulier">
	<!--<h1>Project overzicht</h1>-->
	<div class="header" align="right">
		<span style="float:left" class="title">Project overzicht</span>
		
		<div>
			<input type="hidden" name="Currentid" value="{$output.currentid}" />
			
			<form method="get">
				<input type="hidden" name="id" value="projectoverzicht" />
				<select tabindex="8" name="medewerker" >
					{foreach from=$output.behandelaars item=behandelaar}
						{if $behandelaar.actief eq 0}
							<option value="{$behandelaar.id}" {if $behandelaar.selected eq "true"} selected="selected" {/if} >{$behandelaar.naam}</option>
						{/if}
					{/foreach}
				</select>
				<input type="submit"  value="Toon" />
				<input type="button" name="print" value="print" />
			</form>
		
		</div>
	</div>
	
	<div id="resultaten">
		<table id="table">
			<tr>
				<thead>
					<td><a href="?id=projectoverzicht&medewerker={$output.currentid}&sortCol=titel&sortOrder={if $output.sort.column eq "p.titel"}{$output.sort.order}{else}asc{/if}"> Titel</a></td>
					<td><a href="?id=projectoverzicht&medewerker={$output.currentid}&sortCol=deadline&sortOrder={if $output.sort.column eq "p.deadline"}{$output.sort.order}{else}asc{/if}">Deadline</a></td>
					<td>Medewerkers</td>
					<td>Geplande tijd</td>
					<td>Bestede tijd</td>
				</thead>
			</tr>
			{foreach from=$output.project item=project}
				<tr
					class="
						{if $project.color eq 1}odd
						{elseif $project.color eq 0}even
						{elseif $project.color eq 4}user
						{elseif $project.color eq 5}selected
						{elseif $project.color eq 6}red
						{elseif $project.color eq 7}orange
						{/if}
				
						{if $incident.afgemeld eq 1}afgemeld{/if} pointer"
						onclick=parent.location.href='toppiedesk.php?id=projectnieuw&searchoid={$project.id}'
						>
					<td>{if $project.top10 eq 1}<b>{$project.titel}</b>{else}{$project.titel}{/if}</td>
					<td>{if $project.top10 eq 1}<b>{$project.deadline}</b>{else}{$project.deadline}{/if}</td>
					<td><b>{$project.naam}</b><br />{$project.medewerkers}</td>
					<td>{if $project.top10 eq 1}<b>{$project.geplandetijd}</b>{else}{$project.geplandetijd}{/if}</td>
					<td>{if $project.top10 eq 1}<b>{$project.bestedetijd}</b>{else}{$project.bestedetijd}{/if}</td>
				</tr>
			{/foreach}
		</table>
	</div>
</div>
