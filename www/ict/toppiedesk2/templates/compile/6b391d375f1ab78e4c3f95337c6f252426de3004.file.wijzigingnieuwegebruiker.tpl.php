<?php /* Smarty version Smarty-3.1.8, created on 2012-08-10 10:26:54
         compiled from "templates/default\wijzigingnieuwegebruiker.tpl" */ ?>
<?php /*%%SmartyHeaderCode:59534f479284503919-28954792%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6b391d375f1ab78e4c3f95337c6f252426de3004' => 
    array (
      0 => 'templates/default\\wijzigingnieuwegebruiker.tpl',
      1 => 1325588209,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '59534f479284503919-28954792',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f4792845eab2',
  'variables' => 
  array (
    'output' => 0,
    'user' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f4792845eab2')) {function content_4f4792845eab2($_smarty_tpl) {?><div class="formulier">
    <h1>Nog goed te keuren gebruikersaccounts</h1>
    <div id="resultaten">
        <form action="toppiedesk.php?id=wijzigingnieuwegebruiker" method="post">
            <table id="table">
                <thead>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="2">Goedkeuren</td>
                    </tr>
                    <tr>
                        <td>Voornaam</td>
                        <td>Tussenvoegsel</td>
                        <td>Achternaam</td>
                        <td>Inlognaam</td>
                        <td>Begin datum</td>
                        <td>Afdeling</td>
                        <td>Ja</td>
                        <td>Nee</td>
                    </tr>
                </thead>
                <?php if ($_smarty_tpl->tpl_vars['output']->value['counter']['accepteren']!=0){?>
                    <?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['user']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['accepteren']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
$_smarty_tpl->tpl_vars['user']->_loop = true;
?>
                        <tr class="<?php if ($_smarty_tpl->tpl_vars['user']->value['color']==1){?>odd<?php }elseif($_smarty_tpl->tpl_vars['user']->value['color']==0){?>even<?php }?>">
                            <td class="pointer" onclick=parent.location.href='toppiedesk.php?id=user&searchoid=<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
'><?php echo $_smarty_tpl->tpl_vars['user']->value['voornaam'];?>
</td>
                            <td class="pointer" onclick=parent.location.href='toppiedesk.php?id=user&searchoid=<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
'><?php echo $_smarty_tpl->tpl_vars['user']->value['tussenvoegsel'];?>
</td>
                            <td class="pointer" onclick=parent.location.href='toppiedesk.php?id=user&searchoid=<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
'><?php echo $_smarty_tpl->tpl_vars['user']->value['achternaam'];?>
</td>
                            <td class="pointer" onclick=parent.location.href='toppiedesk.php?id=user&searchoid=<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
'><?php echo $_smarty_tpl->tpl_vars['user']->value['inlognaam'];?>
</td>
                            <td class="pointer" onclick=parent.location.href='toppiedesk.php?id=user&searchoid=<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
'><?php echo $_smarty_tpl->tpl_vars['user']->value['datumindienst'];?>
</td>
                            <td class="pointer" onclick=parent.location.href='toppiedesk.php?id=user&searchoid=<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
'><?php echo $_smarty_tpl->tpl_vars['user']->value['afdeling'];?>
</td>
                            <td><input type="radio" name="accept[<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
]" value="ja" /></td>
                            <td><input type="radio" name="accept[<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
]" value="nee" /></td>
                        </tr>
                    <?php } ?>
                    <tr><td colspan="8" style="text-align:right;"><input type="submit" name="accepteren" value="Opslaan" /></td></tr>
                <?php }else{ ?>
                    <tr>
                        <td colspan="8">Er zijn geen nieuwe aanvragen.</td>
                    </tr>
                <?php }?>
            </table>
        </form>
    </div>    
</div>

<div class="spacer" />

<div class="formulier">
    <h1>Nieuwe Gebruiker</h1>
    <div id="resultaten">
        <table id="table">
            <thead>
                <tr>
                    <td>Voornaam</td>
                    <td>Tussenvoegsel</td>
                    <td>Achternaam</td>
                    <td>Inlognaam</td>
                    <td>Begin datum</td>
                    <td>Afdeling</td>
                </tr>
            </thead>
            <?php if ($_smarty_tpl->tpl_vars['output']->value['counter']['userskort']!=0){?>
                <tr style="background-color:black;color:white;font-size:110%;text-align:center;"><td colspan="6">Binnen een week</td></tr>
                <?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['user']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['userskort']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
$_smarty_tpl->tpl_vars['user']->_loop = true;
?>
                    <tr onclick=parent.location.href='toppiedesk.php?id=user&searchoid=<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
' class="<?php if ($_smarty_tpl->tpl_vars['user']->value['color']==1){?>odd<?php }elseif($_smarty_tpl->tpl_vars['user']->value['color']==0){?>even<?php }?> pointer">
                        <td><?php echo $_smarty_tpl->tpl_vars['user']->value['voornaam'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['user']->value['tussenvoegsel'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['user']->value['achternaam'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['user']->value['inlognaam'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['user']->value['datumindienst'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['user']->value['afdeling'];?>
</td>
                    </tr>
                <?php } ?>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['output']->value['counter']['userslang']!=0){?>
                <tr style="background-color:black;color:white;font-size:110%;text-align:center;"><td colspan="6">Later</td></tr>
                <?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['user']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['userslang']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
$_smarty_tpl->tpl_vars['user']->_loop = true;
?>
                    <tr onclick=parent.location.href='toppiedesk.php?id=user&searchoid=<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
' class="<?php if ($_smarty_tpl->tpl_vars['user']->value['color']==1){?>odd<?php }elseif($_smarty_tpl->tpl_vars['user']->value['color']==0){?>even<?php }?> pointer">
                        <td><?php echo $_smarty_tpl->tpl_vars['user']->value['voornaam'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['user']->value['tussenvoegsel'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['user']->value['achternaam'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['user']->value['inlognaam'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['user']->value['datumindienst'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['user']->value['afdeling'];?>
</td>
                    </tr>
                <?php } ?>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['output']->value['counter']['userskort']==0&&$_smarty_tpl->tpl_vars['output']->value['counter']['userslang']==0){?>
                <tr><td colspan="6">Er zijn geen nieuwe accounts die aangemaakt moeten worden.</td></tr>
            <?php }?>
        </table>
    </div>    
</div><?php }} ?>