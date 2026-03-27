<?php /* Smarty version Smarty-3.1.7, created on 2011-12-28 14:27:01
         compiled from "templates/default/projectoverzichtprint.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3672393504efb19255aab66-74279947%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '46cb3c93f6677a45653de980bbc1358a7fcead5a' => 
    array (
      0 => 'templates/default/projectoverzichtprint.tpl',
      1 => 1325075664,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3672393504efb19255aab66-74279947',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'output' => 0,
    'project' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4efb1925691f1',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4efb1925691f1')) {function content_4efb1925691f1($_smarty_tpl) {?><div class="formulier">
    <div id="resultaten">
        <table id="table" width="800px">
            <tr style="border-bottom:1px solid #000000">
                <thead>
                    <td>Titel</td>
                    <td>Deadline</td>
                    <td>Medewerkers</td>
                    <td>Geplande tijd</td>
                    <td>Besteedde tijd</td>
                </thead>
            </tr>
            <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['project']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
                <tr style="border-bottom: 1px solid #000000">
                    <td valign="top"><?php if ($_smarty_tpl->tpl_vars['project']->value['top10']==1){?><b><?php echo $_smarty_tpl->tpl_vars['project']->value['titel'];?>
</b><?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['project']->value['titel'];?>
<?php }?></td>
                    <td valign="top"><?php if ($_smarty_tpl->tpl_vars['project']->value['top10']==1){?><b><?php echo $_smarty_tpl->tpl_vars['project']->value['deadline'];?>
</b><?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['project']->value['deadline'];?>
<?php }?></td>
                    <td valign="top"><b><?php echo $_smarty_tpl->tpl_vars['project']->value['naam'];?>
</b><br /><?php echo $_smarty_tpl->tpl_vars['project']->value['medewerkers'];?>
</td>
                    <td valign="top"><?php if ($_smarty_tpl->tpl_vars['project']->value['top10']==1){?><b><?php echo $_smarty_tpl->tpl_vars['project']->value['geplandetijd'];?>
</b><?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['project']->value['geplandetijd'];?>
<?php }?></td>
                    <td valign="top"><?php if ($_smarty_tpl->tpl_vars['project']->value['top10']==1){?><b><?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
</b><?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
<?php }?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div><?php }} ?>