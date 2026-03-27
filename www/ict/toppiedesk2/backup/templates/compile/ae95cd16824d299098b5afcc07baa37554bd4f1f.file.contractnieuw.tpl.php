<?php /* Smarty version Smarty-3.1.7, created on 2012-03-09 11:18:51
         compiled from "templates/default\contractnieuw.tpl" */ ?>
<?php /*%%SmartyHeaderCode:67714f59d90b623843-40322426%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ae95cd16824d299098b5afcc07baa37554bd4f1f' => 
    array (
      0 => 'templates/default\\contractnieuw.tpl',
      1 => 1325588209,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '67714f59d90b623843-40322426',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'output' => 0,
    'contracttype' => 0,
    'leverancier' => 0,
    'user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f59d90ba80a5',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f59d90ba80a5')) {function content_4f59d90ba80a5($_smarty_tpl) {?><div class="formulier">
    <h1>Nieuw Contract</h1>
    <?php echo $_smarty_tpl->getSubTemplate ('navbar.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('output'=>$_smarty_tpl->tpl_vars['output']->value), 0);?>

    
    <form action="toppiedesk.php?id=contractnieuw" id="dataform" method="post">
        <input type="hidden" name="oid" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['contract']['id'];?>
" />
        
        <table>
            <tr>
                <td><label for="contractnummer">Contractnummer</label></td>
                <td><input name="contractnummer" id="contractnummer" type="text" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['contract']['contractid'];?>
" /></td>
            </tr>
            <tr>
                <td><label for="begindatum">Begin datum</label></td>
                <td><input name="begindatum" autocomplete="off" id="begindatum" type="text" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['contract']['begindatum'];?>
" /></td>
            </tr>
            <tr>
                <td><label for="einddatum">Eind datum</label></td>
                <td><input name="einddatum" autocomplete="off" id="einddatum" type="text" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['contract']['einddatum'];?>
" /></td>
            </tr>
            <tr>
                <td><label for="contracttype">Contracttype</label></td>
                <td>
                    <select name="contracttype" id="contracttype">
                        <?php  $_smarty_tpl->tpl_vars['contracttype'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['contracttype']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['contracttype']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['contracttype']->key => $_smarty_tpl->tpl_vars['contracttype']->value){
$_smarty_tpl->tpl_vars['contracttype']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['contracttype']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['contracttype']->value['id']==$_smarty_tpl->tpl_vars['output']->value['contract']['contracttype']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['contracttype']->value['contracttype'];?>
</option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="leverancier">Leverancier</label></td>
                <td>
                    <select name="leverancier" id="leverancier">
                        <?php  $_smarty_tpl->tpl_vars['leverancier'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['leverancier']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['leverancier']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['leverancier']->key => $_smarty_tpl->tpl_vars['leverancier']->value){
$_smarty_tpl->tpl_vars['leverancier']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['leverancier']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['leverancier']->value['id']==$_smarty_tpl->tpl_vars['output']->value['contract']['leverancier']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['leverancier']->value['leverancier'];?>
</option>
                        <?php } ?>
                    </select>
            </tr>
            <tr>
                <td><label for="opmerking">Opmerking</label></td>
                <td><textarea name="opmerking" id="opmerking"><?php echo $_smarty_tpl->tpl_vars['output']->value['contract']['opmerking'];?>
</textarea></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align:right"><input type="submit" name="submit" value="Opslaan" /></td>
            </tr>
        </table>
    </form>
    
    <div class="spacer"></div>
    <?php if ($_smarty_tpl->tpl_vars['output']->value['contract']['actief']==1){?>
        <div id="footer">
            Dit contract is gearchiveerd
        </div>
    <?php }?>
</div>

<div class="formulier">
    <h1>Assets</h1>
    
    <form action="toppiedesk.php?id=contractnieuw" method="post">
        <input type="hidden" name="searchoid" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['values']['searchoid'];?>
" />
        <input type="hidden" name="multi" value="<?php if ($_smarty_tpl->tpl_vars['output']->value['values']['multi']==1){?>1<?php }else{ ?>0<?php }?>" />
        <table>
            <tr>
                <td>
                    <div id="behandelaars" style="margin:2px; overflow-y:scroll; max-height:500px;">
                        <?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['user']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['assets']['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
$_smarty_tpl->tpl_vars['user']->_loop = true;
?>
                            <input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['user']->value;?>
" name="medewerkers[]" id="<?php echo $_smarty_tpl->tpl_vars['user']->value;?>
" /> <label for="<?php echo $_smarty_tpl->tpl_vars['user']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['user']->value;?>
</label><br />
                        <?php } ?>
                    </div>
                </td>
                <td>
                    <input type="submit" name="submit" value="--- Toevoegen -->" /><br />
                    <input type="submit" name="submit" value="<-- Verwijderen --" />
                </td>
                <td>
                    <div id="behandelaars" style="margin:2px; overflow-y:scroll; max-height:500px;">
                        <?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['user']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['gekoppeld']['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
$_smarty_tpl->tpl_vars['user']->_loop = true;
?>
                            <input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['user']->value;?>
" name="users[]" id="<?php echo $_smarty_tpl->tpl_vars['user']->value;?>
" /> <label for="<?php echo $_smarty_tpl->tpl_vars['user']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['user']->value;?>
</label><br />
                        <?php } ?>
                    </div>
                </td>
            </tr>
        </table>
    </form>
    
</div><?php }} ?>