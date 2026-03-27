<div class="formulier">
	<!--<h1>Overzicht incidenten</h1>-->
	<div class="header">
		<span class="title">Overzicht incidenten</span>
		<div style="float:right;">
			<form id="submitForm" action="" method="get">
				<input type="hidden" name="id" value="calloverzicht" />
				<input type="checkbox" name="open" {if $output.open eq 1}checked="checked" {/if}/>Alleen opstaande meldingen tonen
			</form>
		</div>
	</div>
	<div id="resultaten">
		<table id="table">
			<thead>
				<tr>
				<td>Naam</td>
				<td style="width:80px;">Datum</td>
				<td>Categorie</td>
				<td>Probleem</td>
				<td>Status</td>
				<td>Behandelaar</td>
				</tr>
			</thead>
			{if $output.counter.overzicht > 0}
				{foreach from=$output.overzicht item=andere}
					<tr class="
						{if $andere.color eq 1}odd{elseif $andere.color eq 2}even oldborder{elseif $andere.color eq 3}odd oldborder{elseif $andere.color eq 5}user{elseif $andere.color eq 0}even{/if} {if $andere.afgemeld eq 1}afgemeld{/if} pointer" {if $andere.actie != ""}onmouseover="return tooltip('{$andere.actie}','','bordercolor:black, border:1, backcolor:#d3d3d3');" onmouseout="return hideTip();"{/if} onclick="window.open('toppiedesk.php?id={$output.page.id}&searchoid={$andere.id}','_blank');">
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
</div>
<div id="tiplayer" style="position:absolute; visibility:hidden; z-index:10000;"></div>