<?php /* Smarty version Smarty-3.1.8, created on 2012-06-29 09:21:36
         compiled from "templates/default\behandelaar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:244404f6c3aef240394-14360496%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8dbc10483f9cd7098200b43c383b87e3ecb8fe3c' => 
    array (
      0 => 'templates/default\\behandelaar.tpl',
      1 => 1325588209,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '244404f6c3aef240394-14360496',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f6c3aef51ff8',
  'variables' => 
  array (
    'output' => 0,
    'behandelaar' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f6c3aef51ff8')) {function content_4f6c3aef51ff8($_smarty_tpl) {?><div class="formulier">
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