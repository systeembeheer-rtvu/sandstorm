<?php /* Smarty version Smarty-3.1.8, created on 2012-08-10 09:36:42
         compiled from "templates/default\incidentnieuw.tpl" */ ?>
<?php /*%%SmartyHeaderCode:224834f476838b67924-48573616%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c4696d23b7b048d59d870a492a6afe9a033a4858' => 
    array (
      0 => 'templates/default\\incidentnieuw.tpl',
      1 => 1344584200,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '224834f476838b67924-48573616',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f476838cca73',
  'variables' => 
  array (
    'output' => 0,
    'i' => 0,
    'categorie' => 0,
    'behandelaar' => 0,
    'status' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f476838cca73')) {function content_4f476838cca73($_smarty_tpl) {?><div class="formulier" style="width: 99%;">
	<?php if (isset($_smarty_tpl->tpl_vars['output']->value['refresh']['status'])){?>
		<SCRIPT type="text/javascript">
			window.close();
		</SCRIPT>
	<?php }?>
	
	<div class="header">
		<span class="title">Call</span>
		<?php if ($_smarty_tpl->tpl_vars['output']->value['incident']['id']!=0){?>
			<a href="<?php echo $_smarty_tpl->tpl_vars['output']->value['navbar']['mail'];?>
" name="mail"><img src="img/mail_generic.png" /></a>
			<a href="#" name="print"><img src="img/agt_print.png" /></a>
			<div style="float:right;">Ingevoerd door <b class="js_behandelaar"><?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['invoerder'];?>
</b> op <b class="js_tijd"><?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['aangemeld'];?>
</b></div>
		<?php }?>	
	</div>
	
	<input type="hidden" name="searchoidcheck" value="false" />
	
	
	<form action="toppiedesk.php?id=callnieuw" <?php if ($_smarty_tpl->tpl_vars['output']->value['incident']['id']!=0){?>class="selected"<?php }?> name="incident" id="dataform" method="post" style="width: 99.6%">
		<input type="hidden" name="oid" value="<?php if ($_smarty_tpl->tpl_vars['output']->value['incident']['id']!=0){?><?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['id'];?>
<?php }else{ ?>0<?php }?>" />
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
								<td colspan="2" style="vertical-align:top;"><textarea tabindex="3" class="js_resize" id="melding" style="width: 99.6%" cols="60" name="probleem"><?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['probleem'];?>
</textarea></td>
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
									<?php if (count($_smarty_tpl->tpl_vars['output']->value['incident']['actie'])>0){?>
										Vorige Actie(s)
										<table border=0 width="100%">
										
											<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['incident']['actie']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
												<tr >
													<input type="hidden" name="ai_id[]" value="<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
" />
													<td style="width: 120px;" valign="top"> <input class="old_incident" type="text" value="<?php echo $_smarty_tpl->tpl_vars['i']->value['datum'];?>
" readonly="readonly" /></td>
													<td valign="top"><textarea class="old_incident js_resize" cols="60" name="ai_text<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
" style="width:99%" ><?php echo $_smarty_tpl->tpl_vars['i']->value['actie'];?>
</textarea></td>
													<td style="width: 150px;" valign="top"><input class="old_incident" type="text" size="25" value="<?php echo $_smarty_tpl->tpl_vars['i']->value['behandelaar'];?>
" readonly="readonly" /></td>
													<td style="width: 60px;" valign="top"><input class="old_incident" type="text" name="ai_tijd[<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
]" size="7" value="<?php echo $_smarty_tpl->tpl_vars['i']->value['bestedetijd'];?>
" /></td>
												</tr>
											<?php } ?>
										</table>
									<?php }?>
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
						<input tabindex="1" type="text" id="tel" class="tel" class="ac_input" name="tel" size="25" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['telefoonnummer'];?>
" /><br/>
					</td>
				<tr>
					<td>
						<label for="naam">Naam</label>
					</td>
					<td>
						<input tabindex="2" type="text" id="naam" class="naam ac_input" name="naam" size="25" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['naam'];?>
" />
						<input id="gebruiker" type="checkbox" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="afdeling">Afdeling</label>
					</td>
					<td>
						<input type="text" id="afdeling" name="afdeling" size="25" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['afdeling'];?>
" />
					</td>
				</tr>
				<tr><td colspan="2">Asset</td></tr>
				<tr>
					<td>
						<label for="assettext">ID</label>
					</td>
					<td>
						<input type="text" id="assettext" name="asset" size="25" class="hardware" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['asset'];?>
" />
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
										<?php  $_smarty_tpl->tpl_vars['categorie'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['categorie']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['categorie']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['categorie']->key => $_smarty_tpl->tpl_vars['categorie']->value){
$_smarty_tpl->tpl_vars['categorie']->_loop = true;
?>
											<?php if (isset($_smarty_tpl->tpl_vars['categorie']->value['split'])){?>
												</td><td style='vertical-align: top;'>
											<?php }?>
											<input <?php if ($_smarty_tpl->tpl_vars['output']->value['incident']['catid']==$_smarty_tpl->tpl_vars['categorie']->value['id']){?> checked="checked" <?php }?> type="radio" id="probleem<?php echo $_smarty_tpl->tpl_vars['categorie']->value['categorie'];?>
" name="categorie" value="<?php echo $_smarty_tpl->tpl_vars['categorie']->value['id'];?>
" /> <label for="probleem<?php echo $_smarty_tpl->tpl_vars['categorie']->value['categorie'];?>
"><?php echo $_smarty_tpl->tpl_vars['categorie']->value['categorie'];?>
</label><br />
										<?php } ?>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<input type="radio" <?php if ($_smarty_tpl->tpl_vars['output']->value['incident']['catid']==0||$_smarty_tpl->tpl_vars['output']->value['incident']['catactief']==1){?> checked="checked" <?php }?> id="probleem" name="categorie" value="0" />
										<label for="probleem">Anders, n.l.</label>
										<input type="text" name="probleemtekst" class="categorie ac_input" value="<?php if ($_smarty_tpl->tpl_vars['output']->value['incident']['catactief']==1){?><?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['categorie'];?>
<?php }?>"/>
									<td>
								</tr>
							</table>
						</div>
						Behandelaar<br />
						<div class="behandelaars">
						    <?php  $_smarty_tpl->tpl_vars['behandelaar'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['behandelaar']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['behandelaars']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['behandelaar']->key => $_smarty_tpl->tpl_vars['behandelaar']->value){
$_smarty_tpl->tpl_vars['behandelaar']->_loop = true;
?>
							<?php if ($_smarty_tpl->tpl_vars['behandelaar']->value['actief']==0||$_smarty_tpl->tpl_vars['behandelaar']->value['selected']=="true"){?>
							    <input type="checkbox" name="behandelaar[]" <?php if ($_smarty_tpl->tpl_vars['behandelaar']->value['selected']=='true'){?> checked="checked" <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['behandelaar']->value['id'];?>
" /><?php echo $_smarty_tpl->tpl_vars['behandelaar']->value['naam'];?>
<br />
							<?php }?>
						    <?php } ?>
						</div>
						status<br/>
						<select name="status" id="status" style="width:172px">
							<?php  $_smarty_tpl->tpl_vars['status'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['status']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['status']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['status']->key => $_smarty_tpl->tpl_vars['status']->value){
$_smarty_tpl->tpl_vars['status']->_loop = true;
?>
							    <?php if ($_smarty_tpl->tpl_vars['status']->value['actief']==0||$_smarty_tpl->tpl_vars['status']->value['id']==$_smarty_tpl->tpl_vars['output']->value['incident']['status']){?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['status']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['output']->value['incident']['status']==$_smarty_tpl->tpl_vars['status']->value['id']){?> selected="selected" <?php }?> ><?php echo $_smarty_tpl->tpl_vars['status']->value['status'];?>
</option>
							    <?php }?>
							<?php } ?>
						</select><br />
						<input type="submit" name="opslaan" value="Opslaan" />
						<input type="submit" name="o&a" value="Afmelden" />
						<input type="hidden" name="oldafgemeld" value="<?php if (isset($_smarty_tpl->tpl_vars['output']->value['incident']['afgemeld'])){?><?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['afgemeld'];?>
<?php }else{ ?>0<?php }?>" />
						<input type="checkbox" name="afgemeld" <?php if (($_smarty_tpl->tpl_vars['output']->value['incident']['afgemeld']==1)){?> checked="yes" <?php }?> /><br />
						<input type="submit" name="project" value="Call -> Project" /><br/>
					</td>
				</tr>
				<tr><td colspan="4">
					
				</td></tr>
			</table>
			
	</form>
</div>
<div style="clear: both"></div>
<?php }} ?>