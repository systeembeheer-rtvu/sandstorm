<?php /* Smarty version Smarty-3.1.8, created on 2012-05-18 11:26:11
         compiled from "templates/default\sidebars\sidebar2.tpl" */ ?>
<?php /*%%SmartyHeaderCode:114914f476838b3c377-91657211%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd2a7ae50f132936146402ce26c153c5e0beaa587' => 
    array (
      0 => 'templates/default\\sidebars\\sidebar2.tpl',
      1 => 1330078518,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '114914f476838b3c377-91657211',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f476838b50fb',
  'variables' => 
  array (
    'output' => 0,
    'url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f476838b50fb')) {function content_4f476838b50fb($_smarty_tpl) {?><div id="sidebar">
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