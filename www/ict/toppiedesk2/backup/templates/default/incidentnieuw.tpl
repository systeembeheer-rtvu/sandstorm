<div class="formulier" style="width: 99%;">
	{if isset($output.refresh.status)}
		<SCRIPT type="text/javascript">
			window.close();
		</SCRIPT>
	{/if}
	
	<div class="header">
		<span class="title">Call</span>
		{if $output.incident.id != 0}
			<a href="{$output.navbar.mail}" name="mail"><img src="img/mail_generic.png" /></a>
			<a href="#" name="print"><img src="img/agt_print.png" /></a>
			<div style="float:right;">Ingevoerd door <b class="js_behandelaar">{$output.incident.invoerder}</b> op <b class="js_tijd">{$output.incident.aangemeld}</b></div>
		{/if}	
	</div>
	
	<input type="hidden" name="searchoidcheck" value="false" />
	
	
	<form action="toppiedesk.php?id=callnieuw" {if $output.incident.id != 0}class="selected"{/if} name="incident" id="dataform" method="post" style="width: 99.6%">
		<input type="hidden" name="oid" value="{if $output.incident.id != 0}{$output.incident.id}{else}0{/if}" />
		<table width="100%">
				<tr>
					<td colspan="3">Aanmelder</td>
					<td rowspan="6" style="width:100px;"><div id="img"><img src="" /></div></td>
					<td rowspan="100" style="width: 80%; padding: 5px;" valign="top">
						<table width="100%">
							<tr>
								<td>Melding</td>
							</tr>
							<tr>
								<td colspan="2" style="vertical-align:top;"><textarea tabindex="3" class="js_resize" id="melding" style="width: 99.6%" cols="60" name="probleem">{$output.incident.probleem}</textarea></td>
							</tr>
							<tr>
								<td>Nieuwe Actie</td>
								<td style="text-align:right;">bestede tijd <input style="text-align:right;" name="bestedetijd" size="6" type="text" value="0:05" /></td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="actie">
										<textarea tabindex="4" class="js_resize" style="width:99.6%" cols="60" id="actie" name="actie" ></textarea>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									{if $output.incident.actie|@count gt 0}
										Vorige Actie(s)
										<table border=0 width="100%">
										
											{foreach from=$output.incident.actie item=i}
												<tr >
													<input type="hidden" name="ai_id[]" value="{$i.id}" />
													<td style="width: 120px;" valign="top"> <input class="old_incident" type="text" value="{$i.datum}" readonly="readonly" /></td>
													<td valign="top"><textarea class="old_incident js_resize" cols="60" name="ai_text{$i.id}" style="width:99%" >{$i.actie}</textarea></td>
													<td style="width: 150px;" valign="top"><input class="old_incident" type="text" size="25" value="{$i.behandelaar}" readonly="readonly" /></td>
													<td style="width: 60px;" valign="top"><input class="old_incident" type="text" name="ai_tijd[{$i.id}]" size="7" value="{$i.bestedetijd}" /></td>
												</tr>
											{/foreach}
										</table>
									{/if}
								</td>
							</tr>
							<tr>
								<td><div id="userHardware"></div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<label for="tel">Tel#</label>
					</td>
					<td>
						<input tabindex="1" type="text" id="tel" class="tel" class="ac_input" name="tel" size="25" value="{$output.incident.telefoonnummer}" /><br/>
					</td>
				<tr>
					<td>
						<label for="naam">Naam</label>
					</td>
					<td>
						<input tabindex="2" type="text" id="naam" class="naam ac_input" name="naam" size="25" value="{$output.incident.naam}" />
						<input id="gebruiker" type="checkbox" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="afdeling">Afdeling</label>
					</td>
					<td>
						<input type="text" id="afdeling" name="afdeling" size="25" value="{$output.incident.afdeling}" />
					</td>
				</tr>
				<tr><td colspan="2">Asset</td></tr>
				<tr>
					<td>
						<label for="assettext">ID</label>
					</td>
					<td>
						<input type="text" id="assettext" name="asset" size="25" class="hardware" value="{$output.incident.asset}" />
						<input id="asset" type="checkbox"  />
					</td>
				</tr>
				<tr>
					<td colspan="4" valign="top">
						Categorie<br />
						<div class="behandelaars" >
							<table>
								<tr>
									<td>
										{foreach from=$output.categorie item=categorie}
											{if isset($categorie.split)}
												</td><td style='vertical-align: top;'>
											{/if}
											<input {if $output.incident.catid eq $categorie.id} checked="checked" {/if} type="radio" id="probleem{$categorie.categorie}" name="categorie" value="{$categorie.id}" /> <label for="probleem{$categorie.categorie}">{$categorie.categorie}</label><br />
										{/foreach}
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<input type="radio" {if $output.incident.catid eq 0 || $output.incident.catactief eq 1} checked="checked" {/if} id="probleem" name="categorie" value="0" />
										<label for="probleem">Anders, n.l.</label>
										<input type="text" name="probleemtekst" class="categorie ac_input" value="{if $output.incident.catactief eq 1}{$output.incident.categorie}{/if}"/>
									<td>
								</tr>
							</table>
						</div>
						Behandelaar<br />
						<div class="behandelaars">
						    {foreach from=$output.behandelaars item=behandelaar}
							{if $behandelaar.actief eq 0 or $behandelaar.selected eq "true"}
							    <input type="checkbox" name="behandelaar[]" {if $behandelaar.selected eq 'true'} checked="checked" {/if} value="{$behandelaar.id}" />{$behandelaar.naam}<br />
							{/if}
						    {/foreach}
						</div>
						status<br/>
						<select name="status" id="status" style="width:172px">
							{foreach from=$output.status item=status}
							    {if $status.actief eq 0 or $status.id eq $output.incident.status}
								<option value="{$status.id}" {if $output.incident.status eq $status.id} selected="selected" {/if} >{$status.status}</option>
							    {/if}
							{/foreach}
						</select><br />
						<input type="submit" name="opslaan" value="Opslaan" />
						<input type="submit" name="o&a" value="Afmelden" />
						<input type="hidden" name="oldafgemeld" value="{if isset($output.incident.afgemeld)}{$output.incident.afgemeld}{else}0{/if}" />
						<input type="checkbox" name="afgemeld" {if ($output.incident.afgemeld == 1)} checked="yes" {/if} /><br />
						<input type="submit" name="project" value="Call -> Project" /><br/>
					</td>
				</tr>
				<tr><td colspan="4">
					
				</td></tr>
			</table>
			
	</form>
</div>
<div style="clear: both"></div>
