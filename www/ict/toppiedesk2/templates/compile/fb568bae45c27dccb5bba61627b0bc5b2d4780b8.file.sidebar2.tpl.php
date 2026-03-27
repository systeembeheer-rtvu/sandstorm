<?php /* Smarty version Smarty-3.1.8, created on 2012-10-19 21:04:41
         compiled from "templates/default/sidebars/sidebar2.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14420758034efb0d053c5560-68857707%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fb568bae45c27dccb5bba61627b0bc5b2d4780b8' => 
    array (
      0 => 'templates/default/sidebars/sidebar2.tpl',
      1 => 1350647609,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14420758034efb0d053c5560-68857707',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4efb0d0545dd0',
  'variables' => 
  array (
    'output' => 0,
    'url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4efb0d0545dd0')) {function content_4efb0d0545dd0($_smarty_tpl) {?><div id="sidebar">
    <ul>
        <?php  $_smarty_tpl->tpl_vars['url'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['url']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['links']['sb_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['url']->key => $_smarty_tpl->tpl_vars['url']->value){
$_smarty_tpl->tpl_vars['url']->_loop = true;
?>
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value['url'];?>
" target="_<?php echo $_smarty_tpl->tpl_vars['url']->value['target'];?>
"><?php echo $_smarty_tpl->tpl_vars['url']->value['link'];?>
</a></li>
        <?php } ?>
    </ul>
</div>
<div id="content"><?php }} ?>