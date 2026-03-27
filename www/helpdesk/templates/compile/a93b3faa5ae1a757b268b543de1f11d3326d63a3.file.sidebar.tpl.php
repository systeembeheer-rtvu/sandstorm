<?php /* Smarty version Smarty-3.1.8, created on 2012-05-21 14:24:29
         compiled from "templates/default/sidebars/sidebar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14609028414efb10775c5fa4-56491903%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a93b3faa5ae1a757b268b543de1f11d3326d63a3' => 
    array (
      0 => 'templates/default/sidebars/sidebar.tpl',
      1 => 1325076292,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14609028414efb10775c5fa4-56491903',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4efb1077645c1',
  'variables' => 
  array (
    'output' => 0,
    'url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4efb1077645c1')) {function content_4efb1077645c1($_smarty_tpl) {?><div id="sidebar">
    <?php  $_smarty_tpl->tpl_vars['url'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['url']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['links']['sb_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['url']->key => $_smarty_tpl->tpl_vars['url']->value){
$_smarty_tpl->tpl_vars['url']->_loop = true;
?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['url']->value['link'];?>
</a><br />
    <?php } ?>
</div>
<div id="content"><?php }} ?>