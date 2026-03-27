<?php /* Smarty version Smarty-3.1.8, created on 2012-07-13 14:21:54
         compiled from "templates/default\error.tpl" */ ?>
<?php /*%%SmartyHeaderCode:253914f476c325a4766-60413266%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eb3bf701c0c2efa88cfe33ad00839b36b328c690' => 
    array (
      0 => 'templates/default\\error.tpl',
      1 => 1325588209,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '253914f476c325a4766-60413266',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f476c325d6a9',
  'variables' => 
  array (
    'output' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f476c325d6a9')) {function content_4f476c325d6a9($_smarty_tpl) {?><div id="fout">
    <h1>Error</h1>
    <?php echo $_smarty_tpl->tpl_vars['output']->value['info'];?>

</div><?php }} ?>