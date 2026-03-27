<?php /* Smarty version Smarty-3.1.8, created on 2012-09-24 10:43:12
         compiled from "templates/default/wijzigingftpaccountbeheer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20301349394efb18e7b60c14-89792907%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fc3ef54e0d767ef9bffcfd58a9e33341cf24725c' => 
    array (
      0 => 'templates/default/wijzigingftpaccountbeheer.tpl',
      1 => 1344608515,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20301349394efb18e7b60c14-89792907',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4efb18e7c8d2f',
  'variables' => 
  array (
    'output' => 0,
    'ftp' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4efb18e7c8d2f')) {function content_4efb18e7c8d2f($_smarty_tpl) {?><div class="formulier">
    <h1>FTP accounts</h1>
    <div id="resultaten">
        <table id="table">
            <tr>
                <thead>
                    <td>User</td>
                    <td>Home directory</td>
                    <td>Commentaar</td>
                    <td>Verloopdatum</td>
                </thead>
            </tr>
            <?php  $_smarty_tpl->tpl_vars['ftp'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ftp']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['ftp']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ftp']->key => $_smarty_tpl->tpl_vars['ftp']->value){
$_smarty_tpl->tpl_vars['ftp']->_loop = true;
?>
                <tr class="<?php if ($_smarty_tpl->tpl_vars['ftp']->value['color']==1){?>odd<?php }elseif($_smarty_tpl->tpl_vars['ftp']->value['color']==0){?>even<?php }elseif($_smarty_tpl->tpl_vars['ftp']->value['color']==3){?>user<?php }?> pointer" onclick=parent.location.href='toppiedesk.php?id=ftp&searchoid=<?php echo $_smarty_tpl->tpl_vars['ftp']->value['user'];?>
'>
                    <td><?php echo $_smarty_tpl->tpl_vars['ftp']->value['user'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['ftp']->value['dir'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['ftp']->value['comment'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['ftp']->value['verloopdatum'];?>
</td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div><?php }} ?>