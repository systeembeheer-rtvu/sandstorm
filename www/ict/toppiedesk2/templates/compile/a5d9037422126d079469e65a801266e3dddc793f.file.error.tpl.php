<?php /* Smarty version Smarty-3.1.7, created on 2012-04-03 14:57:59
         compiled from "templates/default/error.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16610318814f04459a961600-61264218%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a5d9037422126d079469e65a801266e3dddc793f' => 
    array (
      0 => 'templates/default/error.tpl',
      1 => 1331304480,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16610318814f04459a961600-61264218',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f04459aa0ff6',
  'variables' => 
  array (
    'output' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f04459aa0ff6')) {function content_4f04459aa0ff6($_smarty_tpl) {?><div id="fout">
    <h1>Error</h1>
    <?php echo $_smarty_tpl->tpl_vars['output']->value['info'];?>

</div><?php }} ?>