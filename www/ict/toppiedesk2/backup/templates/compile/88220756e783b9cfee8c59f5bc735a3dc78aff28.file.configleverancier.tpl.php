<?php /* Smarty version Smarty-3.1.8, created on 2012-10-04 15:00:07
         compiled from "templates/default/configleverancier.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1839025129506d88575f61b1-64565941%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '88220756e783b9cfee8c59f5bc735a3dc78aff28' => 
    array (
      0 => 'templates/default/configleverancier.tpl',
      1 => 1344608514,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1839025129506d88575f61b1-64565941',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'output' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_506d88576a1288_51769548',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_506d88576a1288_51769548')) {function content_506d88576a1288_51769548($_smarty_tpl) {?><div class="formulier">
    <h1>Leverancier</h1>
    <?php echo $_smarty_tpl->getSubTemplate ('navbar.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('output'=>$_smarty_tpl->tpl_vars['output']->value), 0);?>

    <form id="dataform">
        <input type="hidden" name="oid" value="<?php if (isset($_smarty_tpl->tpl_vars['output']->value['leverancier']['id'])){?><?php echo $_smarty_tpl->tpl_vars['output']->value['leverancier']['id'];?>
<?php }else{ ?>0<?php }?>" />
        <table>
            <tr>
                <td><label for="leverancier">Leverancier</label></td>
                <td><input type="text" id="leverancier" name="leverancier" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['leverancier']['leverancier'];?>
" /></td>
            </tr>
            <tr>
                <td><label for="klantnummer">Klantnummer</label></td>
                <td><input type="text" name="klantnummer" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['leverancier']['klantnummer'];?>
" /></td>
            </tr>
            <tr>
                <td><label for="Contactpersoon">Contactpersoon</label></td>
                <td><input type="text" name="contactpersoon" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['leverancier']['contactpersoon'];?>
" /></td>
            </tr>
            <tr>
                <td><label for="Telefoonnummer">Telefoonnummer</label></td>
                <td><input type="text" name="telefoonnummer" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['leverancier']['telefoonnummer'];?>
" /></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align:right;"><input type="button" name="opslaan" value="Opslaan" /></td>
            </tr>
        </table>
    </form>
</div><?php }} ?>