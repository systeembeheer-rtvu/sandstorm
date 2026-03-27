<?php /* Smarty version Smarty-3.1.7, created on 2012-02-24 16:02:10
         compiled from "templates/default/projectoverzicht.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18345448074efb0d0aedca53-68448849%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fb2d91bced866399c872fff300a2cc745fe5a146' => 
    array (
      0 => 'templates/default/projectoverzicht.tpl',
      1 => 1330084517,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18345448074efb0d0aedca53-68448849',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4efb0d0b0fdea',
  'variables' => 
  array (
    'output' => 0,
    'project' => 0,
    'incident' => 0,
    'behandelaar' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4efb0d0b0fdea')) {function content_4efb0d0b0fdea($_smarty_tpl) {?><div class="formulier">
    <h1>Project overzicht</h1>
    <div id="resultaten">
        <table id="table" width="800px">
            <tr>
                <thead>
                    <td>Titel</td>
                    <td>Deadline</td>
                    <td>Medewerkers</td>
                    <td>Geplande tijd</td>
                    <td>Bestede tijd</td>
                </thead>
            </tr>
            <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['project']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
                <tr
                    class="
                        <?php if ($_smarty_tpl->tpl_vars['project']->value['color']==1){?>odd
                        <?php }elseif($_smarty_tpl->tpl_vars['project']->value['color']==0){?>even
                        <?php }elseif($_smarty_tpl->tpl_vars['project']->value['color']==4){?>user
                        <?php }elseif($_smarty_tpl->tpl_vars['project']->value['color']==5){?>selected
                        <?php }elseif($_smarty_tpl->tpl_vars['project']->value['color']==6){?>red
                        <?php }elseif($_smarty_tpl->tpl_vars['project']->value['color']==7){?>orange
                        <?php }?>
                        
                        <?php if ($_smarty_tpl->tpl_vars['incident']->value['afgemeld']==1){?>afgemeld<?php }?> pointer"
                    onclick=parent.location.href='toppiedesk.php?id=projectnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['id'];?>
'
                >
                    <td><?php if ($_smarty_tpl->tpl_vars['project']->value['top10']==1){?><b><?php echo $_smarty_tpl->tpl_vars['project']->value['titel'];?>
</b><?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['project']->value['titel'];?>
<?php }?></td>
                    <td><?php if ($_smarty_tpl->tpl_vars['project']->value['top10']==1){?><b><?php echo $_smarty_tpl->tpl_vars['project']->value['deadline'];?>
</b><?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['project']->value['deadline'];?>
<?php }?></td>
                    <td><b><?php echo $_smarty_tpl->tpl_vars['project']->value['naam'];?>
</b><br /><?php echo $_smarty_tpl->tpl_vars['project']->value['medewerkers'];?>
</td>
                    <td><?php if ($_smarty_tpl->tpl_vars['project']->value['top10']==1){?><b><?php echo $_smarty_tpl->tpl_vars['project']->value['geplandetijd'];?>
</b><?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['project']->value['geplandetijd'];?>
<?php }?></td>
                    <td><?php if ($_smarty_tpl->tpl_vars['project']->value['top10']==1){?><b><?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
</b><?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
<?php }?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<input type="hidden" name="Currentid" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['currentid'];?>
" />
<form method="get">
    <input type="hidden" name="id" value="projectoverzicht" />
    <select tabindex="8" name="medewerker" style="width:178px">
        <?php  $_smarty_tpl->tpl_vars['behandelaar'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['behandelaar']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['behandelaars']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['behandelaar']->key => $_smarty_tpl->tpl_vars['behandelaar']->value){
$_smarty_tpl->tpl_vars['behandelaar']->_loop = true;
?>
            <?php if ($_smarty_tpl->tpl_vars['behandelaar']->value['actief']==0){?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['behandelaar']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['behandelaar']->value['selected']=="true"){?> selected="selected" <?php }?> ><?php echo $_smarty_tpl->tpl_vars['behandelaar']->value['naam'];?>
</option>
            <?php }?>
        <?php } ?>
    </select>
    <input type="submit"  value="Toon" />
</form>
<br />
<input type="button" name="print" value="print" /><?php }} ?>