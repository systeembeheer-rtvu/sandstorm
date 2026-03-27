<?php /* Smarty version Smarty-3.1.8, created on 2012-08-17 14:43:27
         compiled from "templates/default/confighardwarekaart.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15225164864f42679e4880a7-34743186%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '25b68d12b10f1fb9e1a3374c9f0c3821d1912cce' => 
    array (
      0 => 'templates/default/confighardwarekaart.tpl',
      1 => 1344608514,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15225164864f42679e4880a7-34743186',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f42679e6915d',
  'variables' => 
  array (
    'output' => 0,
    'type' => 0,
    'leverancier' => 0,
    'contract' => 0,
    'hardware' => 0,
    'user' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f42679e6915d')) {function content_4f42679e6915d($_smarty_tpl) {?><div class="formulier">
    <h1 id="js_opslaan">Hardware Kaart</h1>
    <?php echo $_smarty_tpl->getSubTemplate ('navbar.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('output'=>$_smarty_tpl->tpl_vars['output']->value), 0);?>

    <form id="dataform">
        <input type="hidden" name="id" value="confighardwarekaart" />
        <table style="float:left;">
            <tr>
                <td>Asset tag</td>
                <td><input type="text" name="oid" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['values']['searchoid'];?>
" class="input" /></td>
            </tr>
            <tr>
                <td>Type</td>
                <td>
                    <select name="hardwaretype" class="input">
                        <?php  $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['type']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['hardware']['types']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['type']->key => $_smarty_tpl->tpl_vars['type']->value){
$_smarty_tpl->tpl_vars['type']->_loop = true;
?>
                            <option name="<?php echo $_smarty_tpl->tpl_vars['type']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['type']->value['type']==$_smarty_tpl->tpl_vars['output']->value['values']['hardwaretype']){?> selected="selected" <?php }?> ><?php echo $_smarty_tpl->tpl_vars['type']->value['type'];?>
</option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Multi</td>
                <td><input type="checkbox" name="multi" <?php if ($_smarty_tpl->tpl_vars['output']->value['values']['multi']==1){?> checked="checked" <?php }?> class="input" /></td>
            </tr>
            <tr>
                <td>Leverancier</td>
                <td>
                    <select name="leverancier" class="input">
                        <?php  $_smarty_tpl->tpl_vars['leverancier'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['leverancier']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['leverancier']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['leverancier']->key => $_smarty_tpl->tpl_vars['leverancier']->value){
$_smarty_tpl->tpl_vars['leverancier']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['leverancier']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['leverancier']->value['id']==$_smarty_tpl->tpl_vars['output']->value['values']['leverancier']){?> selected="selected" <?php }?>><?php echo $_smarty_tpl->tpl_vars['leverancier']->value['leverancier'];?>
</option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Contract</td>
                <td>
                    <select name="contract" class="input">
                        <?php  $_smarty_tpl->tpl_vars['contract'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['contract']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['contract']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['contract']->key => $_smarty_tpl->tpl_vars['contract']->value){
$_smarty_tpl->tpl_vars['contract']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['contract']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['contract']->value['contractid'];?>
</option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
        </table>
        
        <table style="float:left; margin:0 5px;">
            <?php  $_smarty_tpl->tpl_vars['hardware'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['hardware']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['hardware']['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['hardware']->key => $_smarty_tpl->tpl_vars['hardware']->value){
$_smarty_tpl->tpl_vars['hardware']->_loop = true;
?>
                <tr>
                    <td><?php echo $_smarty_tpl->tpl_vars['hardware']->value['label'];?>
</td>
                    <td><input type="<?php echo $_smarty_tpl->tpl_vars['hardware']->value['type'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['hardware']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['hardware']->value['value'];?>
" class="input" /></td>
                </tr>
            <?php } ?>
        </table>
    </form>
</div>

<div class="formulier" id="js_show">
    <h1>Gebruikers</h1>
    <div>
        <form action="toppiedesk.php?id=confighardwarekaart" method="post">
            <input type="hidden" name="searchoid" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['values']['searchoid'];?>
" />
            <input type="hidden" name="multi" value="<?php if ($_smarty_tpl->tpl_vars['output']->value['values']['multi']==1){?>1<?php }else{ ?>0<?php }?>" />
            <table>
                <tr>
                    <td>
                        <div id="behandelaars" style="margin:2px; overflow-y:scroll; max-height:500px;">
                            <?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['user']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['medewerkers']['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
 $_from = $_smarty_tpl->tpl_vars['output']->value['user']['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
    </div>
</div>

<a href="toppiedesk.php?id=confignieuwhardwaretype" />Nieuw hardware type aanmaken</a><br /><?php }} ?>