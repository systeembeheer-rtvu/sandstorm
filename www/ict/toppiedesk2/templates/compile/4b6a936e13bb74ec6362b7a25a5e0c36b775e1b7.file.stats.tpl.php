<?php /* Smarty version Smarty-3.1.8, created on 2013-11-07 11:42:21
         compiled from "templates/default/stats.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11693254794efb0d861f39b3-21964048%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4b6a936e13bb74ec6362b7a25a5e0c36b775e1b7' => 
    array (
      0 => 'templates/default/stats.tpl',
      1 => 1350647609,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11693254794efb0d861f39b3-21964048',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4efb0d862c13a',
  'variables' => 
  array (
    'output' => 0,
    'menu' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4efb0d862c13a')) {function content_4efb0d862c13a($_smarty_tpl) {?><form action="toppiedesk.php" method="get">
    <input type="hidden" name="id" value="stats" />
    <select size="5" name="stat">
        <?php  $_smarty_tpl->tpl_vars['menu'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['menu']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['stats']['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['menu']->key => $_smarty_tpl->tpl_vars['menu']->value){
$_smarty_tpl->tpl_vars['menu']->_loop = true;
?>
            <option value="<?php echo $_smarty_tpl->tpl_vars['menu']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['menu']->value['title'];?>
</option>
        <?php } ?>
    </select>
    <input type="submit" value="Toon" name="submit" />
</form><?php }} ?>