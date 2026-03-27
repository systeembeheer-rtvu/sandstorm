<?php /* Smarty version Smarty-3.1.8, created on 2012-10-25 12:12:16
         compiled from "templates/default/incidentzoeken.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11498984174f042dd46f1760-66711794%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fec33d98355047b95e8eebb4630ea79bde593b45' => 
    array (
      0 => 'templates/default/incidentzoeken.tpl',
      1 => 1350647609,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11498984174f042dd46f1760-66711794',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f042dd4a2ab8',
  'variables' => 
  array (
    'output' => 0,
    'status' => 0,
    'categorie' => 0,
    'incident' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f042dd4a2ab8')) {function content_4f042dd4a2ab8($_smarty_tpl) {?><div class="formulier">
    <h1>Incident Zoeken</h1>
    <table>
        <tr>
            <td style="vertical-align: top;">
                <form id="dataform" action="" method="post">
                    <input type="hidden" name="id" value="incidentzoeken" />
                    <input type="hidden" name="empty" value="1" />
                    <table>
                        <tr>
                            <td><label for="opdracht">Zoekopdracht</label></td>
                            <td><input type="text" id="opdracht" name="opdracht" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['vars']['opdracht'];?>
" /></td>
                        </tr>
                        <tr>
                            <td><label for="naam">Aanmelder</label></td>
                            <td><input type="text" class="naam" name="naam" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['vars']['naam'];?>
" /></td>
                        </tr>
                        <tr>
                            <td><label>Van</label></td>
                            <td>
                                <select name="dagvan">
                                    <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['day'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['day']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['name'] = 'day';
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['loop'] = is_array($_loop=31) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['day']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['day']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['day']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['day']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['day']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['day']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['total']);
?> 
                                        <option <?php if ($_smarty_tpl->tpl_vars['output']->value['vars']['van']['dag']==$_smarty_tpl->getVariable('smarty')->value['section']['day']['iteration']){?> selected="selected" <?php }?> value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['day']['iteration'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['day']['iteration'];?>
</option>
                                    <?php endfor; endif; ?>
                                </select>
                                <select name="maandvan">
                                    <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['month'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['month']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['name'] = 'month';
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['loop'] = is_array($_loop=12) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['month']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['month']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['month']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['month']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['month']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['month']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['total']);
?> 
                                        <option <?php if ($_smarty_tpl->tpl_vars['output']->value['vars']['van']['maand']==$_smarty_tpl->getVariable('smarty')->value['section']['month']['iteration']){?> selected="selected" <?php }?> value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['month']['iteration'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['month']['iteration'];?>
</option>
                                    <?php endfor; endif; ?>
                                </select>
                                <select name="jaarvan">
                                    <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['year'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['year']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['name'] = 'year';
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['start'] = (int)2010;
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['output']->value['vars']['huidig']['jaar']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['total']);
?>
                                        <option <?php if ($_smarty_tpl->tpl_vars['output']->value['vars']['van']['jaar']==$_smarty_tpl->getVariable('smarty')->value['section']['year']['index']){?> selected="selected" <?php }?> value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['year']['index'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['year']['index'];?>
</option>
                                    <?php endfor; endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Tot</label></td>
                            <td>
                                <select name="dagtot">
                                <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['day'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['day']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['name'] = 'day';
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['loop'] = is_array($_loop=31) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['day']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['day']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['day']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['day']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['day']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['day']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['day']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['day']['total']);
?> 
                                    <option <?php if ($_smarty_tpl->tpl_vars['output']->value['vars']['tot']['dag']==$_smarty_tpl->getVariable('smarty')->value['section']['day']['iteration']){?> selected="selected" <?php }?> value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['day']['iteration'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['day']['iteration'];?>
</option>
                                <?php endfor; endif; ?>
                                </select>
                                <select name="maandtot">
                                    <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['month'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['month']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['name'] = 'month';
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['loop'] = is_array($_loop=12) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['month']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['month']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['month']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['month']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['month']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['month']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['month']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['month']['total']);
?> 
                                        <option <?php if ($_smarty_tpl->tpl_vars['output']->value['vars']['tot']['maand']==$_smarty_tpl->getVariable('smarty')->value['section']['month']['iteration']){?> selected="selected" <?php }?> value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['month']['iteration'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['month']['iteration'];?>
</option> 
                                    <?php endfor; endif; ?>
                                </select>
                                <select name="jaartot">
                                    <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['year'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['year']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['name'] = 'year';
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['start'] = (int)2010;
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['output']->value['vars']['huidig']['jaar']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['year']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['year']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['year']['total']);
?>
                                        <option <?php if ($_smarty_tpl->tpl_vars['output']->value['vars']['tot']['jaar']==$_smarty_tpl->getVariable('smarty')->value['section']['year']['index']){?> selected="selected" <?php }?> value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['year']['index'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['year']['index'];?>
</option>
                                    <?php endfor; endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="status">Status</label></td>
                            <td>
                                <select name="status">
                                    <?php  $_smarty_tpl->tpl_vars['status'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['status']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['status']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['status']->key => $_smarty_tpl->tpl_vars['status']->value){
$_smarty_tpl->tpl_vars['status']->_loop = true;
?> 
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['status']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['output']->value['vars']['status']==$_smarty_tpl->tpl_vars['status']->value['id']){?> selected="selected" <?php }?> ><?php echo $_smarty_tpl->tpl_vars['status']->value['status'];?>
</option>    
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="categorie">Categorie</label></td>
                            <td>
                                <select id="categorie" name="categorie">
                                    <?php  $_smarty_tpl->tpl_vars['categorie'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['categorie']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['categorie']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['categorie']->key => $_smarty_tpl->tpl_vars['categorie']->value){
$_smarty_tpl->tpl_vars['categorie']->_loop = true;
?>
                                        <option <?php if ($_smarty_tpl->tpl_vars['output']->value['vars']['categorie']==$_smarty_tpl->tpl_vars['categorie']->value['id']){?> selected="selected" <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['categorie']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['categorie']->value['categorie'];?>
</option>
                                    <?php } ?>
                                </select>
                            </td>
                    </table>
                    <input type="checkbox" name="aangemeld" <?php if ($_smarty_tpl->tpl_vars['output']->value['vars']['aangemeld']=="on"){?> checked <?php }?> id="aangemeld" /> <label for="aangemeld">Openstaande incidenten weergeven</label><br />
                    <input type="checkbox" name="afgemeld" <?php if ($_smarty_tpl->tpl_vars['output']->value['vars']['afgemeld']=="on"){?> checked <?php }?> id="afgemeld" /> <label for="afgemeld">Gesloten incidenten weergeven</label><br />
                    <input type="submit" name="zoeken" value="zoeken" />
                </form>
            </td>
        </tr>
    </table>
</div>
<div id="resultaten">
                    <table width="800px">
                        <tr>
                            <thead>
                                <td>Naam</td>
                                <td>Datum</td>
                                <td>Categorie</td>
                                <td>Probleem</td>
                                <td>Status</td>
                                <td>Behandelaar</td>
                            </thead>
                        </tr>
                        <?php if ($_smarty_tpl->tpl_vars['output']->value['counter']>0){?>
                            <?php  $_smarty_tpl->tpl_vars['incident'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['incident']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['incidenten']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['incident']->key => $_smarty_tpl->tpl_vars['incident']->value){
$_smarty_tpl->tpl_vars['incident']->_loop = true;
?>
                                <tr
                                    class="
                                        <?php if ($_smarty_tpl->tpl_vars['incident']->value['color']==1){?>odd
                                        <?php }elseif($_smarty_tpl->tpl_vars['incident']->value['color']==2){?>even oldborder
                                        <?php }elseif($_smarty_tpl->tpl_vars['incident']->value['color']==3){?>odd oldborder
                                        <?php }elseif($_smarty_tpl->tpl_vars['incident']->value['color']==5){?>user
                                        <?php }else{ ?>even
                                        <?php }?>
                                        
                                        <?php if ($_smarty_tpl->tpl_vars['incident']->value['afgemeld']==1){?>afgemeld<?php }?> pointer"
									onclick="window.open('toppiedesk.php?id=callnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['incident']->value['id'];?>
','_blank');"
                                >
                                    <td><?php echo $_smarty_tpl->tpl_vars['incident']->value['naam'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['incident']->value['datum'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['incident']->value['categorie'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['incident']->value['probleem'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['incident']->value['status'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['incident']->value['behandelaar'];?>
</td>
                                </tr>
                            <?php } ?>
                        <?php }else{ ?>
                            <tr><td colspan="6">Geen resultaten</td></tr>
                        <?php }?>
                    </table>
                </div><?php }} ?>