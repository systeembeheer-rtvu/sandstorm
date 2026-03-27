<?php /* Smarty version Smarty-3.1.8, created on 2012-10-29 16:29:17
         compiled from "templates/default/branka.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15104160294f4e37b9ce0e39-74127630%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f5f9bff0e559d8412c87db448efb63319d7635b2' => 
    array (
      0 => 'templates/default/branka.tpl',
      1 => 1350647609,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15104160294f4e37b9ce0e39-74127630',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f4e37ba14d0e',
  'variables' => 
  array (
    'output' => 0,
    'status' => 0,
    'i' => 0,
    'categorie' => 0,
    'behandelaar' => 0,
    'andere' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f4e37ba14d0e')) {function content_4f4e37ba14d0e($_smarty_tpl) {?><div class="formulier">
    <!--<h1>Incident
        <?php if ($_smarty_tpl->tpl_vars['output']->value['incident']['id']!=0){?>
            <a href="<?php echo $_smarty_tpl->tpl_vars['output']->value['navbar']['mail'];?>
" name="mail"><img src="img/mail_generic.png" /></a>
            <a href="#" name="print"><img src="img/agt_print.png" /></a>
        <?php }?>
    </h1>-->

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
    <form action="toppiedesk.php?id=branka" <?php if ($_smarty_tpl->tpl_vars['output']->value['incident']['id']!=0){?>class="selected"<?php }?> name="incident" id="dataform" method="post">
        <table>
            <tr>
                <td colspan="2">Aanmelder</td>
                <td colspan="2">Asset</td>
                <td colspan="2" rowspan="5">
                    <div id="img"><img src="" /></div>
                </td>
            </tr>
            <tr>
                <td><label for="tel">Tel#</label></td>
                <td><input type="text" class="tel" class="ac_input" name="tel" size="25" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['telefoonnummer'];?>
" tabindex="1" /></td>
                <td><label for="id">ID</label></td>
                <td><input type="text" tabindex="8" name="asset" class="hardware" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['asset'];?>
" /></td>
            </tr>
            <tr>
                <td><label for="naam">Naam</label></td>
                <td><input type="text" class="naam" class="ac_input" name="naam" size="25" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['naam'];?>
" tabindex="2" /></td>
            </tr>
            <tr>  
                <td><label for="afdeling">Afdeling</label></td>
                <td><input type="text" tabindex="3" id="afdeling" name="afdeling" size="25" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['afdeling'];?>
" /></td>
            </tr>
            
            <tr>
                <td><label for="probleem">Melding</label></td>
            </tr>
            <tr>
                <td colspan="4" style="vertical-align:top;"><textarea class="js_resize" cols="60" tabindex="6" name="probleem"><?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['probleem'];?>
</textarea></td>
                <td style="vertical-align: top;">
                    Calls<br />
                    <input id="gebruiker" type="button" value="Gebruiker" tabindex="0" />
                    <input id="asset" type="button" value="Asset" tabindex="0" />
                </td>
            </tr>
            <tr>
                <td colspan="3"><label for="actie">Nieuwe Actie</label></td>
                <td style="text-align:right;">bestede tijd <input style="text-align:right;" name="bestedetijd" size="6" type="text" value="0:05" /></td>
                <td>Status</td>
            </tr>
            
            <tr>
                <td colspan="4" style="vertical-align:top;">
                    <div class="actie">
                        <textarea class="js_resize" cols="60" id="actie" tabindex="7" name="actie" ></textarea>
                    </div>
                    
                </td>
                <td style="vertical-align: top;">
                    <table>
                        <tr>
                            <td>
                                <select tabindex="8" name="status" id="status" tabindex="11" style="width:172px">
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
                                </select>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <?php if (count($_smarty_tpl->tpl_vars['output']->value['incident']['actie'])>0){?>
                        Vorige Actie(s)
                        <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['incident']['actie']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
                            <div class="actie">
                                <input type="hidden" name="ai_id[]" value="<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
" />
                                <input type="text" class="old_incident" value="<?php echo $_smarty_tpl->tpl_vars['i']->value['datum'];?>
" readonly="readonly" /><input type="text" size="25" class="old_incident" value="<?php echo $_smarty_tpl->tpl_vars['i']->value['behandelaar'];?>
" readonly="readonly" />
                                <input type="text" class="old_incident" name="ai_tijd[<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
]" size="7" value="<?php echo $_smarty_tpl->tpl_vars['i']->value['bestedetijd'];?>
" />
                                <textarea class="js_resize old_incident" cols="60" tabindex="0" name="ai_text<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
" ><?php echo $_smarty_tpl->tpl_vars['i']->value['actie'];?>
</textarea>
                            </div>
                        <?php } ?>
                        
                    <?php }?>
                    Categorie:<br />
                    <div class="catList" >
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
                </td>
                <td style="vertical-align:top;">
                    Behandelaar<br />
                    <div id="behandelaars">
                        <?php  $_smarty_tpl->tpl_vars['behandelaar'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['behandelaar']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['behandelaars']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['behandelaar']->key => $_smarty_tpl->tpl_vars['behandelaar']->value){
$_smarty_tpl->tpl_vars['behandelaar']->_loop = true;
?>
                            <?php if ($_smarty_tpl->tpl_vars['behandelaar']->value['actief']==0||$_smarty_tpl->tpl_vars['behandelaar']->value['selected']=="true"){?>
                                <input tabindex="10" type="checkbox" name="behandelaar[]" <?php if ($_smarty_tpl->tpl_vars['behandelaar']->value['selected']=='true'){?> checked="checked" <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['behandelaar']->value['id'];?>
" /><?php echo $_smarty_tpl->tpl_vars['behandelaar']->value['naam'];?>
<br />
                            <?php }?>
                        <?php } ?>
                    </div>
                    <input type="submit" name="opslaan" value="Opslaan" />
                    <input type="submit" name="o&a" value="Afmelden" />
                    <input type="hidden" name="oldafgemeld" value="<?php if (isset($_smarty_tpl->tpl_vars['output']->value['incident']['afgemeld'])){?><?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['afgemeld'];?>
<?php }else{ ?>0<?php }?>" />
                    <input type="checkbox" name="afgemeld" tabindex="9" <?php if (($_smarty_tpl->tpl_vars['output']->value['incident']['afgemeld']==1)){?> checked="yes" <?php }?> /><br />
                    <input type="submit" name="project" value="Call -> Project" /><br/>
                    <?php if (isset($_smarty_tpl->tpl_vars['output']->value['refresh']['status'])){?>
                        <div id="succes">
                            <h1>Opgeslagen</h1>
                            <p>
                                Incident is opgeslagen<br />
                                <a href="toppiedesk.php?id=incidentnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['output']->value['searchoid'];?>
">Laatste call: <?php echo $_smarty_tpl->tpl_vars['output']->value['searchoid'];?>
</a>
                            </p>
                        </div>
                    <?php }?>
                </td>
            </tr>
        </table>
        <input type="hidden" name="oid" value="<?php if ($_smarty_tpl->tpl_vars['output']->value['incident']['id']!=0){?><?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['id'];?>
<?php }else{ ?>0<?php }?>" />
    </form>
    <div class="spacer"></div>
    <?php if (isset($_smarty_tpl->tpl_vars['output']->value['incident']['invoerder'])){?><div id="footer"> </div><?php }?>
</div>

<div id="resultaten" style="width:750px;">
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
        <?php if ($_smarty_tpl->tpl_vars['output']->value['counter']['andere']>0){?>
            <?php  $_smarty_tpl->tpl_vars['andere'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['andere']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['andere']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['andere']->key => $_smarty_tpl->tpl_vars['andere']->value){
$_smarty_tpl->tpl_vars['andere']->_loop = true;
?>
                <tr class="<?php if ($_smarty_tpl->tpl_vars['andere']->value['color']==1){?>odd<?php }elseif($_smarty_tpl->tpl_vars['andere']->value['color']==2){?>even oldborder<?php }elseif($_smarty_tpl->tpl_vars['andere']->value['color']==3){?>odd oldborder<?php }elseif($_smarty_tpl->tpl_vars['andere']->value['color']==5){?>user<?php }elseif($_smarty_tpl->tpl_vars['andere']->value['color']==0){?>even<?php }?> pointer" <?php if ($_smarty_tpl->tpl_vars['output']->value['searchoid']==$_smarty_tpl->tpl_vars['andere']->value['id']){?>id="selected"<?php }?>  onclick=parent.location.href='toppiedesk.php?id=<?php echo $_smarty_tpl->tpl_vars['output']->value['page']['id'];?>
&searchoid=<?php echo $_smarty_tpl->tpl_vars['andere']->value['id'];?>
'>
                    <td><?php echo $_smarty_tpl->tpl_vars['andere']->value['naam'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['andere']->value['datum'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['andere']->value['categorie'];?>
</td>
                    <td class="probleem"><?php echo $_smarty_tpl->tpl_vars['andere']->value['probleem'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['andere']->value['status'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['andere']->value['behandelaar'];?>
</td>
                </tr>
            <?php } ?>
        <?php }else{ ?>
            <tr><td colspan="6">Geen incidenten</td></tr>
        <?php }?>
    </table>
</div>
<?php }} ?>