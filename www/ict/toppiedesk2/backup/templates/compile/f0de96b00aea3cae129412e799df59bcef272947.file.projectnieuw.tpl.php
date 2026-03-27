<?php /* Smarty version Smarty-3.1.8, created on 2012-08-10 15:56:03
         compiled from "templates/default\projectnieuw.tpl" */ ?>
<?php /*%%SmartyHeaderCode:249674f4770a5742896-89384658%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f0de96b00aea3cae129412e799df59bcef272947' => 
    array (
      0 => 'templates/default\\projectnieuw.tpl',
      1 => 1344606951,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '249674f4770a5742896-89384658',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f4770a5862ef',
  'variables' => 
  array (
    'output' => 0,
    'user' => 0,
    'a' => 0,
    'behandelaar' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f4770a5862ef')) {function content_4f4770a5862ef($_smarty_tpl) {?><div class="formulier">
    <h1>Project</h1>
    <form action="toppiedesk.php?id=projectnieuw" <?php if ($_smarty_tpl->tpl_vars['output']->value['project']['id']!=0){?>class="selected"<?php }?> id="dataform" method="post">
        <input type="hidden" name="oid" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['project']['id'];?>
" />
        <input type="hidden" name="prevAfgemeld" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['project']['afgemeld'];?>
" />
        <table>
            <tr>
                <td>Titel</td>
                <td><input type="text" name="titel" size="50" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['project']['titel'];?>
" /></td>
                <td rowspan="4" style="vertical-align: top;">
                    <table style="float:right; margin: 0 5px;">
                        <?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['user']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['bestedetijd']['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
$_smarty_tpl->tpl_vars['user']->_loop = true;
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['user']->value['naam'];?>
</td>
                                <td style="text-align:right; padding-right:3px;"><?php echo $_smarty_tpl->tpl_vars['user']->value['bestedetijd'];?>
</td>
                            </tr>
                        <?php } ?>
                        <tr style="border-top: solid 1px #000">
                            <td>Bestede tijd</td>
                            <td style="text-align:right; padding-right:3px;"><?php echo $_smarty_tpl->tpl_vars['output']->value['bestedetijd']['totaal'];?>
</td>
                        </tr>
                        <tr>
                            <td>Geplande tijd</td>
                            <td style="text-align:right;"><input style="text-align:right;" type="text" size="5" name="geplandetijd" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['project']['geplandetijd'];?>
" /></td>
                        </tr>
                        <tr style="border-top: solid 1px #000">
                            <td>Over</td>
                            <td style="text-align:right; padding-right:3px; color:<?php if ($_smarty_tpl->tpl_vars['output']->value['bestedetijd']['over']>0){?>#339933<?php }elseif($_smarty_tpl->tpl_vars['output']->value['bestedetijd']['over']<0){?>#FF0000<?php }else{ ?>#000<?php }?>"><?php echo $_smarty_tpl->tpl_vars['output']->value['bestedetijd']['over'];?>
</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>Deadline</td>
                <td><input type="text" name="deadline" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['project']['deadline'];?>
" /></td>
            </tr>
            <tr>
                <td>Begroting</td>
            </tr>
            <tr>
                <td colspan="2"><textarea name="begroting" class="js_resize"><?php echo $_smarty_tpl->tpl_vars['output']->value['project']['begroting'];?>
 </textarea></td>
            </tr>
            <tr>
                <td>Doel</td>
            </tr>
            <tr>
                <td colspan="2"><textarea name="doel" class="js_resize"><?php echo $_smarty_tpl->tpl_vars['output']->value['project']['doel'];?>
</textarea></td>
            </tr>
            <tr>
                <td colspan="2" style="vertical-align:top">
                    <table>
                        <tr>
                            <td colspan="2">Nieuwe activiteit</td>
                        </tr>
                        <tr>
                            <td><input type="text" name="date" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['project']['date'];?>
" /></td>
                            <td colspan="1" style="text-align:right;">
                                bestede tijd <input type="text" name="bestedetijd" size="5" value="0:15" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><textarea name="activiteit" class="js_resize"></textarea></td>
                        </tr>
                        <?php if (count($_smarty_tpl->tpl_vars['output']->value['project']['activiteiten'])>0){?>
                            <tr>
                                <td>Vorige activiteit(en)</td>
                            </tr>
                            <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['a']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['project']['activiteiten']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
$_smarty_tpl->tpl_vars['a']->_loop = true;
?>
                                <tr>
                                    <td colspan="2" style="text-align:right;">
                                        <input type="hidden" name="act_id[]" value="<?php echo $_smarty_tpl->tpl_vars['a']->value['id'];?>
" />
                                        bestede tijd
                                        <input type="text" class="old_incident" name="act_tijd[<?php echo $_smarty_tpl->tpl_vars['a']->value['id'];?>
]" size="5" value="<?php echo $_smarty_tpl->tpl_vars['a']->value['bestedetijd'];?>
" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" class="old_incident" name="act_datum[<?php echo $_smarty_tpl->tpl_vars['a']->value['id'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['a']->value['datum'];?>
" /></td>
                                    <td style="text-align:right;"><input class="old_incident" type="text" name="act_behandelaar[<?php echo $_smarty_tpl->tpl_vars['a']->value['id'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['a']->value['behandelaar'];?>
" /></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><textarea name="act_omschrijving[<?php echo $_smarty_tpl->tpl_vars['a']->value['id'];?>
]" class="old_incident js_resize"><?php echo $_smarty_tpl->tpl_vars['a']->value['omschrijving'];?>
</textarea></td>
                                </tr>
                            <?php } ?>
                        <?php }?>
                    </table>
                </td>
                <td style="vertical-align:top; padding: 5px;">
                    <div>
                        Opdrachtgever<br />
                        <input type="text" name="opdrachtgever" size="25" class="naam" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['project']['opdrachtgever'];?>
" />
                    </div>
                    <div>
                        Verantwoordelijke<br />
                        <select name="verantwoordelijk">
                            <option value="0"></option>
                            <?php  $_smarty_tpl->tpl_vars['behandelaar'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['behandelaar']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['behandelaars']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['behandelaar']->key => $_smarty_tpl->tpl_vars['behandelaar']->value){
$_smarty_tpl->tpl_vars['behandelaar']->_loop = true;
?>
                                <?php if ($_smarty_tpl->tpl_vars['behandelaar']->value['actief']==0||$_smarty_tpl->tpl_vars['behandelaar']->value['selected']=="true"){?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['behandelaar']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['output']->value['project']['verantwoordelijk']==$_smarty_tpl->tpl_vars['behandelaar']->value['id']){?> selected="selected" <?php }?>><?php echo $_smarty_tpl->tpl_vars['behandelaar']->value['naam'];?>
</option>
                                <?php }?>
                            <?php } ?>
                        </select>
                    </div>
                    Medewerkers<br/>
                    <div id="behandelaars">
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
                    <div style="float:right;">
                        Top 10 <input type="checkbox" name="top10" <?php if ($_smarty_tpl->tpl_vars['output']->value['project']['top10']){?>checked="checked"<?php }?> />
                    </div>
                    <div style="clear:both;"></div>
                    <div style="float:right;">
                        <input type="submit" name="submit" value="Opslaan" />
                        <input type="submit" name="o&a" value="Sluiten" />
                        <input type="checkbox" name="gesloten" <?php if ($_smarty_tpl->tpl_vars['output']->value['project']['afgemeld']){?>checked="checked"<?php }?> />
                    </div>
                </td>
            </tr>
        </table>
        
    </form>
    <div style="clear:both;"></div>
    <?php if (isset($_smarty_tpl->tpl_vars['output']->value['project']['aangemaaktdoor'])){?>
        <div id="footer">
            Aangemaakt door: <b><?php echo $_smarty_tpl->tpl_vars['output']->value['project']['aangemaaktdoor'];?>
</b> op <b><?php echo $_smarty_tpl->tpl_vars['output']->value['project']['aangemaaktop'];?>
</b>
        </div>
    <?php }?>
</div><?php }} ?>