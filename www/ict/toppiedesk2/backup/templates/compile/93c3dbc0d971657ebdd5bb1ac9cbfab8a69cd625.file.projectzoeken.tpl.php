<?php /* Smarty version Smarty-3.1.7, created on 2012-02-24 16:02:14
         compiled from "templates/default/projectzoeken.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11876735354efb3a1c18a685-98198092%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '93c3dbc0d971657ebdd5bb1ac9cbfab8a69cd625' => 
    array (
      0 => 'templates/default/projectzoeken.tpl',
      1 => 1330084517,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11876735354efb3a1c18a685-98198092',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4efb3a1c349e8',
  'variables' => 
  array (
    'output' => 0,
    'behandelaar' => 0,
    'project' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4efb3a1c349e8')) {function content_4efb3a1c349e8($_smarty_tpl) {?><div class="formulier">
    <h1>Project Zoeken</h1>
    <form action="toppiedesk.php?id=projectzoeken" id="dataform" method="post">
        <table>
            <tr>
                <td>Titel</td>
                <td><input type="text" name="titel" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['search']['titel'];?>
" /></td>
            </tr>
            <tr>
                <td>Deadline</td>
                <td><input type="text" name="deadline" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['search']['deadline'];?>
" /></td>
            </tr>
            <tr>
                <td>Doel</td>
                <td><input type="text" name="doel" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['search']['doel'];?>
"</td>
            </tr>
            <tr>
                <td>Opdrachtgever</td>
                <td><input type="text" name="opdrachtgever" class="naam" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['search']['opdrachtgever'];?>
"</td>
            </tr>
            <tr>
                <td>Verantwoordelijke</td>
                <td>
                    <select name="verantwoordelijke">
                        <?php  $_smarty_tpl->tpl_vars['behandelaar'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['behandelaar']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['behandelaars']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['behandelaar']->key => $_smarty_tpl->tpl_vars['behandelaar']->value){
$_smarty_tpl->tpl_vars['behandelaar']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['behandelaar']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['behandelaar']->value['selected']=="true"){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['behandelaar']->value['naam'];?>
</option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="checkbox" name="aangemeld" <?php if ($_smarty_tpl->tpl_vars['output']->value['vars']['aangemeld']=="on"){?> checked <?php }?> id="aangemeld" /> <label for="aangemeld">Openstaande projecten weergeven</label><br />
                    <input type="checkbox" name="afgemeld" <?php if ($_smarty_tpl->tpl_vars['output']->value['vars']['afgemeld']=="on"){?> checked <?php }?> id="afgemeld" /> <label for="afgemeld">Gesloten projecten weergeven</label><br />
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:right;"><input type="submit" name="submit" value="Zoeken" /></td>
            </tr>
        </table>
    </form>
</div>

<div id="resultaten">
    <table id="table">
        <tr>
            <thead>
                <td>Titel</td>
                <td>Verantwoordelijke</td>
                <td>Deadline</td>
                <td>Medewerkers</td>
                <td>Geplande tijd</td>
                <td>Bestede tijd</td>
            </thead>
        </tr>
        <?php if ($_smarty_tpl->tpl_vars['output']->value['counter']>0){?>
            <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['project']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
                <tr
                    class="
                        <?php if ($_smarty_tpl->tpl_vars['project']->value['color']==1){?>odd
                        <?php }elseif($_smarty_tpl->tpl_vars['project']->value['color']==2){?>even oldborder
                        <?php }elseif($_smarty_tpl->tpl_vars['project']->value['color']==3){?>odd oldborder
                        <?php }else{ ?>even
                        <?php }?>
                        
                        <?php if ($_smarty_tpl->tpl_vars['project']->value['afgemeld']==1){?>afgemeld<?php }?> pointer"
                    onclick=parent.location.href='toppiedesk.php?id=projectnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['id'];?>
'
                >
                    <td><?php echo $_smarty_tpl->tpl_vars['project']->value['titel'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['project']->value['verantwoordelijk'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['project']->value['deadline'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['project']->value['medewerkers'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['project']->value['geplandetijd'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
</td>
                </tr>
            <?php } ?>
        <?php }else{ ?>
            <tr><td colspan="6">Geen resultaten</td></tr>
        <?php }?>
    </table>
</div><?php }} ?>