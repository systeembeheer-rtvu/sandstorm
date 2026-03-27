<?php /* Smarty version Smarty-3.1.8, created on 2012-08-10 10:38:38
         compiled from "templates/default\settings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:197034f476f88994bd3-61059217%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '75519e8111932bf201aa4ce0eb86ba0820dc8a8a' => 
    array (
      0 => 'templates/default\\settings.tpl',
      1 => 1325588209,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '197034f476f88994bd3-61059217',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f476f88a1ca1',
  'variables' => 
  array (
    'output' => 0,
    'behandelaar' => 0,
    'status' => 0,
    'categorie' => 0,
    'afdeling' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f476f88a1ca1')) {function content_4f476f88a1ca1($_smarty_tpl) {?><div id="accordion">
    <h3><a href="#">Behandelaars</a></h3>
    <div>
        <div class="tabs">
            <ul>
                <li><a href="#tabs-1">Aanmaken</a></li>
                <li><a href="#tabs-2">Bewerken</a></li>
            </ul>
            <div id="tabs-1">
                <form>
                    <input type="hidden" name="part" value="behandelaar" />
                    <table>
                        <tr>
                            <td><label for="naam">Naam</label></td>
                            <td><input type="text" name="naam" id="naam" class="naam" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;"><input type="submit" name="submit" value="Aanmaken" /></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="tabs-2">
                <form>
                    <input type="hidden" name="part" value="behandelaar" />
                    <table>
                        <tr>
                            <td>Naam</td>
                            <td>
                                <select name="behandelaar">
                                    <?php  $_smarty_tpl->tpl_vars['behandelaar'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['behandelaar']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['behandelaars']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['behandelaar']->key => $_smarty_tpl->tpl_vars['behandelaar']->value){
$_smarty_tpl->tpl_vars['behandelaar']->_loop = true;
?>
                                        <option <?php if ($_smarty_tpl->tpl_vars['output']->value['vars']['behandelaar']==$_smarty_tpl->tpl_vars['behandelaar']->value['id']){?>selected="selected" <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['behandelaar']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['behandelaar']->value['naam'];?>
<?php if ($_smarty_tpl->tpl_vars['behandelaar']->value['actief']==1){?> (inactief)<?php }?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;"><input type="submit" name="submit" value="(de)activeren" /></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <h3><a href="#">Status</a></h3>
    <div>
        <div class="tabs">
            <ul>
                <li><a href="#tabs-1">Aanmaken</a></li>
                <li><a href="#tabs-2">Bewerken</a></li>
            </ul>
            <div id="tabs-1">
                <form>
                    <input type="hidden" name="part" value="status" />
                    <table>
                        <tr>
                            <td>Status</td>
                            <td><input type="text" name="naam" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" name="submit" value="Aanmaken" /></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="tabs-2">
                <form>
                    <input type="hidden" name="part" value="status" />
                    <table>
                        <tr>
                            <td>status</td>
                            <td>
                                <select name="status">
                                    <?php  $_smarty_tpl->tpl_vars['status'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['status']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['status']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['status']->key => $_smarty_tpl->tpl_vars['status']->value){
$_smarty_tpl->tpl_vars['status']->_loop = true;
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['status']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['status']->value['status'];?>
 <?php if ($_smarty_tpl->tpl_vars['status']->value['actief']==1){?> (inactief)<?php }?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" name="submit" value="(de)activeren" /></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <h3><a href="#">Categorie&euml;n</a></h3>
    <div>
        <div class="tabs">
            <ul>
                <li><a href="#tabs-1">Aanmaken</a></li>
                <li><a href="#tabs-2">Bewerken</a></li>
            </ul>
            <div id="tabs-1">
                <form>
                    <input type="hidden" name="part" value="categorie" />
                    <table>
                        <tr>
                            <td>Categorie</td>
                            <td><input type="text" name="catName" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;"><input type="submit" name="submit" value="Aanmaken" /></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="tabs-2">
                <form>
                    <input type="hidden" name="part" value="categorie" />
                    <table>
                        <tr>
                            <td>Categorie</td>
                            <td>
                                <select name="categorie">
                                    <?php  $_smarty_tpl->tpl_vars['categorie'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['categorie']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['categorie']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['categorie']->key => $_smarty_tpl->tpl_vars['categorie']->value){
$_smarty_tpl->tpl_vars['categorie']->_loop = true;
?>
                                        <option <?php if ($_smarty_tpl->tpl_vars['output']->value['vars']['categorie']==$_smarty_tpl->tpl_vars['categorie']->value['id']){?>selected="selected" <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['categorie']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['categorie']->value['categorie'];?>
<?php if ($_smarty_tpl->tpl_vars['categorie']->value['actief']==1){?> (inactief)<?php }?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;"><input type="submit" name="submit" value="(de)activeren" /></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <h3><a href="#">Toegangscontrolle</a></h3>
    <div>
        <div class="tabs">
            <ul>
                <li><a href="#tabs-1">user account aanvragen</a></li>
                <li><a href="#tabs-2">Unknown</a></li>
            </ul>
            <div id="tabs-1">
                <form>
                    <table>
                        <tr><td><label for="uaa_naam">Naam</label></td><td>Afdeling</td></tr>
                        <tr>
                            <td style="vertical-align: top;">
                                <input type="text" name="naam" class="naam" id="uaa_naam" />
                            </td>
                            <td>
                                <div id="checkbox" style="width:300px;">
                                    <table>
                                        <?php  $_smarty_tpl->tpl_vars['afdeling'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['afdeling']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['afdeling']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['afdeling']->key => $_smarty_tpl->tpl_vars['afdeling']->value){
$_smarty_tpl->tpl_vars['afdeling']->_loop = true;
?>
                                            <tr><td><input type="checkbox" name="afdeling" value=<?php echo $_smarty_tpl->tpl_vars['afdeling']->value['id'];?>
 /></td><td><?php echo $_smarty_tpl->tpl_vars['afdeling']->value['afdeling'];?>
</td></tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:right;"><input type="submit" name="submit" value="Aanpassen" /></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="tabs-2">
                
            </div>
        </div>
    </div>
</div><?php }} ?>