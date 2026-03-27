<?php /* Smarty version Smarty-3.1.8, created on 2012-07-13 15:53:16
         compiled from "templates/default\configkaart.tpl" */ ?>
<?php /*%%SmartyHeaderCode:281814f59d90e98e5c6-57230534%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8a52c24f293d4349c387566e4e01bee378c6a55b' => 
    array (
      0 => 'templates/default\\configkaart.tpl',
      1 => 1325588209,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '281814f59d90e98e5c6-57230534',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f59d90ea140b',
  'variables' => 
  array (
    'output' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f59d90ea140b')) {function content_4f59d90ea140b($_smarty_tpl) {?><div class="formulier">
    <h1>Persoonskaart</h1>
    <?php echo $_smarty_tpl->getSubTemplate ('navbar.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('output'=>$_smarty_tpl->tpl_vars['output']->value), 0);?>

    <form id="dataform" action="toppiedesk.php?id=configkaart" method="post">
        <?php if (isset($_smarty_tpl->tpl_vars['output']->value['config'])){?>
            <input type="hidden" name="searchoid" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['values']['searchoid'];?>
" />
            <table>
                <tr>
                    <td>Item</td>
                    <td><input type="text" name="hardware" class="hardware" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Toevoegen" />
                        <input type="submit" name="submit" value="Contract" />
                    </td>
                </tr>
            </table>
        <?php }?>
    </form>
</div>

<div id="resultaten" style="width:750px;">
    <?php if ($_smarty_tpl->tpl_vars['output']->value['values']['name']!=''){?>
        Items van <?php echo $_smarty_tpl->tpl_vars['output']->value['values']['name'];?>

    <?php }?>
    <table id="table">
        <thead>
            <tr>
                <td>Object ID</td>
                <td>Type</td>
                <td><a href="toppiedesk.php?id=configkaart" title="Alles verwijderen" name="archive"><img src="img/delete.png" /></a></td>
            </tr>
        </thead>
        <?php  $_smarty_tpl->tpl_vars['config'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['config']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['config']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['config']->key => $_smarty_tpl->tpl_vars['config']->value){
$_smarty_tpl->tpl_vars['config']->_loop = true;
?>
            <tr class="<?php if ($_smarty_tpl->tpl_vars['config']->value['color']==1){?>odd<?php }else{ ?>even<?php }?> pointer" onclick=parent.location.href='toppiedesk.php?id=confighardwarekaart&searchoid=<?php echo $_smarty_tpl->tpl_vars['config']->value['oid'];?>
' >
                <td><?php echo $_smarty_tpl->tpl_vars['config']->value['oid'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['config']->value['type'];?>
</td>
                <td><a href="" name="<?php echo $_smarty_tpl->tpl_vars['config']->value['oid'];?>
" title="Item verwijderen" class="js_delete"><img src="img/delete.png" /></a></td>
            </tr>
        <?php } ?>
    </table>
</div>
<?php }} ?>