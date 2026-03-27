<?php /* Smarty version Smarty-3.1.8, created on 2013-09-18 16:43:31
         compiled from "templates/default/confignieuwhardwaretype2.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20782318675239bc13ad6ad0-62889017%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '262d1c8eb98eff040db08e6fe84f47af1d69ae4b' => 
    array (
      0 => 'templates/default/confignieuwhardwaretype2.tpl',
      1 => 1350647609,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20782318675239bc13ad6ad0-62889017',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'output' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5239bc13b81db1_28146970',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5239bc13b81db1_28146970')) {function content_5239bc13b81db1_28146970($_smarty_tpl) {?><div class="formulier">
    <h1>Nieuw hardware type</h1>
    <div id="velden">
        <form action="toppiedesk.php?id=confignieuwhardwaretype" method="post">
            <input type="hidden" name="aantal" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['vars']['aantal'];?>
" />
            
            <table>
                <tr>
                    <td><label for="typenaam">Type naam</label></td>
                    <td><input type="text" name="typenaam" /></td>
                </tr>
                <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['foo'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['name'] = 'foo';
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['output']->value['vars']['aantal']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['total']);
?>
                    <tr>
                        <td><label for="naam[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['foo']['iteration'];?>
]">Veld naam</label></td>
                        <td><input type="naam" name="naam[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['foo']['iteration'];?>
]" id="naam" /></td>
                        <td><label for="type[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['foo']['iteration'];?>
]">Type</label></td>
                        <td>
                            <select name="type[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['foo']['iteration'];?>
]" id="type">
                                <option value="text">Text</option>
                            </select>
                        </td>
                    </tr>
                <?php endfor; endif; ?>
            </table>
            <br />
            <input type="submit" name="submit" value="Aanmaken" />
            <input type="submit" name="submit" value="Annuleren" />
        </form>
    </div>
</div><?php }} ?>