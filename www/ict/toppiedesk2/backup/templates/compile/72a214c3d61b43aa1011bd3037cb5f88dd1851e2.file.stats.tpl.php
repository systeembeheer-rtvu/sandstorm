<?php /* Smarty version Smarty-3.1.7, created on 2012-02-24 12:07:54
         compiled from "templates/default\stats.tpl" */ ?>
<?php /*%%SmartyHeaderCode:149674f476f8aacd525-24592467%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '72a214c3d61b43aa1011bd3037cb5f88dd1851e2' => 
    array (
      0 => 'templates/default\\stats.tpl',
      1 => 1325588209,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '149674f476f8aacd525-24592467',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'output' => 0,
    'menu' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f476f8ab0a21',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f476f8ab0a21')) {function content_4f476f8ab0a21($_smarty_tpl) {?><form action="toppiedesk.php" method="get">
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