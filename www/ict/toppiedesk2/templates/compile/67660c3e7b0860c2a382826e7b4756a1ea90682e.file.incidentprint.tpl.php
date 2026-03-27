<?php /* Smarty version Smarty-3.1.8, created on 2012-10-29 16:29:33
         compiled from "templates/default/incidentprint.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3674370124f1d620f4e6718-03753707%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '67660c3e7b0860c2a382826e7b4756a1ea90682e' => 
    array (
      0 => 'templates/default/incidentprint.tpl',
      1 => 1350647609,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3674370124f1d620f4e6718-03753707',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f1d620f66136',
  'variables' => 
  array (
    'output' => 0,
    'behandelaar' => 0,
    'i' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f1d620f66136')) {function content_4f1d620f66136($_smarty_tpl) {?><table>
    <tr>
        <td class="staticwidth">Aangemeld op:</td>
        <td class="rightspacewb"><?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['aangemeld'];?>
</td>
        <td>Status:</td>
        <td><?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['status'];?>
</td>
    </tr>
    <tr>
        <td class="staticwidth">Invoerder:</td>
        <td class="rightspacewb"><?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['invoerder'];?>
</td>
        <td class="rightspace" style="vertical-align:top;">Behandelaar(s):</td>
        <td rowspan="5" style="vertical-align:top;">
            <?php  $_smarty_tpl->tpl_vars['behandelaar'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['behandelaar']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['behandelaars']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['behandelaar']->key => $_smarty_tpl->tpl_vars['behandelaar']->value){
$_smarty_tpl->tpl_vars['behandelaar']->_loop = true;
?>
                <?php echo $_smarty_tpl->tpl_vars['behandelaar']->value['naam'];?>
<br />
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td class="staticwidth topborder">Tel#:</td>
        <td class="rightspacewb topborder"><?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['telefoonnummer'];?>
</td>
        
    </tr>
    <tr>
        <td class="staticwidth">Naam:</td>
        <td class="rightspacewb"><?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['naam'];?>
</td>
        
    </tr>
    <tr>  
        <td class="staticwidth">Afdeling:</td>
        <td class="rightspacewb"><?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['afdeling'];?>
</td>
    </tr>
    <tr>
        <td class="staticwidth">
            Categorie:
        </td>
        <td class="rightspacewb">
            <?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['categorie'];?>

        </td>
    </tr>
    <tr class="topspace">
        <td colspan="4">Melding:</td>
    </tr>
    <tr>
        <td colspan="4"><?php echo $_smarty_tpl->tpl_vars['output']->value['incident']['probleem'];?>
</td>
    </tr>
    <?php if (count($_smarty_tpl->tpl_vars['output']->value['incident']['actie'])>0){?>
        <tr class="topspace">
            <td colspan="4">Actie(s):</td>
        </tr>
        <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['incident']['actie']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
?>
            <tr class="actie">    
                <td colspan="4"><?php echo $_smarty_tpl->tpl_vars['i']->value['datum'];?>
 <?php echo $_smarty_tpl->tpl_vars['i']->value['behandelaar'];?>
</td>
            </tr>
            <tr>
                <td colspan="4" class="omschrijving"><?php echo $_smarty_tpl->tpl_vars['i']->value['actie'];?>
</td>
            </tr>
        <?php } ?>
    <?php }?>
</table><?php }} ?>