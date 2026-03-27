<?php /* Smarty version Smarty-3.1.8, created on 2012-08-10 16:49:54
         compiled from "templates/default/behandelaar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3644356114f107588ead270-60835585%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b04ae92c354ea64473117a10739bf58730f741c3' => 
    array (
      0 => 'templates/default/behandelaar.tpl',
      1 => 1344608514,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3644356114f107588ead270-60835585',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f1075890fe69',
  'variables' => 
  array (
    'output' => 0,
    'behandelaar' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f1075890fe69')) {function content_4f1075890fe69($_smarty_tpl) {?><div class="formulier">
    <h1>Invoerder</h1>
    <form action="toppiedesk.php" method="get" style="padding: 5px;">
        <input type="hidden" name="id" value="setuser" />
        <div class="float">
            
            <select name="behandelaar" id="behandelaar"  size="10">
                <?php  $_smarty_tpl->tpl_vars['behandelaar'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['behandelaar']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['behandelaars']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['behandelaar']->key => $_smarty_tpl->tpl_vars['behandelaar']->value){
$_smarty_tpl->tpl_vars['behandelaar']->_loop = true;
?>
                    <option <?php if ($_smarty_tpl->tpl_vars['behandelaar']->value['selected']=='true'){?> selected="selected" <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['behandelaar']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['behandelaar']->value['naam'];?>
</option>
                <?php } ?>
            </select>
        </div>
        <div class="spacer"></div>
        <input type="submit" value="Ok" name="accept" />
    </form>
</div><?php }} ?>