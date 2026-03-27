<?php /* Smarty version Smarty-3.1.7, created on 2012-01-13 14:12:12
         compiled from "templates/default/stats/incidentenperhardware.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5529748654f102dacf0ac10-66724932%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a68df1ecc2e0024007b0e245c530f1737e600c98' => 
    array (
      0 => 'templates/default/stats/incidentenperhardware.tpl',
      1 => 1325075664,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5529748654f102dacf0ac10-66724932',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'output' => 0,
    'andere' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f102dad11aa8',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f102dad11aa8')) {function content_4f102dad11aa8($_smarty_tpl) {?><div id="img">
    
</div>

<form action="toppiedesk.php" method="get">
    <input type="hidden" name="id" value="stats" />
    <input type="hidden" name="stat" value="incidentenpergebruiker" />
    naam: <input name="naam" class="hardware" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['vars']['naam'];?>
" type="text" />
    <input type="submit" name="submit" value="Toon" /> 
</form>

<?php if (isset($_smarty_tpl->tpl_vars['output']->value['vars'])){?>
    aantal meldingen van <?php echo $_smarty_tpl->tpl_vars['output']->value['vars']['naam'];?>
: <?php echo $_smarty_tpl->tpl_vars['output']->value['counter']['andere'];?>
<br /><br />
    
    <div id="resultaten" style="width:750px; margin:0px;">
        <table id="table">
            <thead>
                <tr>
                    <td>Naam</td>
                    <td>Datum</td>
                    <td>Categorie</td>
                    <td>Probleem</td>
                    <td>Status</td>
                    <td>Behandelaar</td>
                </tr>
            </thead>
            <?php if ($_smarty_tpl->tpl_vars['output']->value['counter']['andere']>0){?>
                <?php  $_smarty_tpl->tpl_vars['andere'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['andere']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['andere']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['andere']->key => $_smarty_tpl->tpl_vars['andere']->value){
$_smarty_tpl->tpl_vars['andere']->_loop = true;
?>
                    <tr class="
                        <?php if ($_smarty_tpl->tpl_vars['andere']->value['color']==1){?>odd
                        <?php }elseif($_smarty_tpl->tpl_vars['andere']->value['color']==2){?>even oldborder
                        <?php }elseif($_smarty_tpl->tpl_vars['andere']->value['color']==3){?>odd oldborder
                        <?php }elseif($_smarty_tpl->tpl_vars['andere']->value['color']==5){?>user
                        <?php }elseif($_smarty_tpl->tpl_vars['andere']->value['color']==0){?>even
                        <?php }?>
                        pointer"
                        <?php if ($_smarty_tpl->tpl_vars['output']->value['searchoid']==$_smarty_tpl->tpl_vars['andere']->value['id']){?>
                            id="selected"
                        <?php }?>
                        onclick=parent.location.href='toppiedesk.php?id=incidentnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['andere']->value['id'];?>
'
                    >
                        <td><?php echo $_smarty_tpl->tpl_vars['andere']->value['naam'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['andere']->value['datum'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['andere']->value['categorie'];?>
</td>
                        <td class="probleem"><?php echo $_smarty_tpl->tpl_vars['andere']->value['probleem'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['andere']->value['status'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['andere']->value['behandelaar'];?>
</td>
                    </tr>
                <?php } ?>
            <?php }else{ ?>
                <tr><td colspan="6">Geen incidenten</td></tr>
            <?php }?>
        </table>
    </div>
<?php }?>

<?php }} ?>