<?php /* Smarty version Smarty-3.1.8, created on 2013-07-01 13:43:22
         compiled from "templates/default/navbar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19527705494f42679e74c3e9-77537369%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '21bc8fd8ddf74b0734f75985adaad74721a179c8' => 
    array (
      0 => 'templates/default/navbar.tpl',
      1 => 1350647609,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19527705494f42679e74c3e9-77537369',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f42679e86604',
  'variables' => 
  array (
    'output' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f42679e86604')) {function content_4f42679e86604($_smarty_tpl) {?><div id="navbar">
    <form action="" method="get" name="navbar" >
        <?php if ($_smarty_tpl->tpl_vars['output']->value['navbar']['new']!="false"){?>
            <a href="<?php echo $_smarty_tpl->tpl_vars['output']->value['navbar']['new'];?>
" title="Nieuw" name="new"><img src="img/mail_new.png" /></a>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['output']->value['navbar']['save']!="false"){?>
            <a href="<?php echo $_smarty_tpl->tpl_vars['output']->value['navbar']['save'];?>
" title="Opslaan" name="save"><img src="img/filesave.png" /></a>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['output']->value['navbar']['mail']!="false"){?>
            <a href="<?php echo $_smarty_tpl->tpl_vars['output']->value['navbar']['mail'];?>
" title="E-mail" name="mail"><img src="img/mail_generic.png" /></a>
        <?php }?>
        
        <?php if ($_smarty_tpl->tpl_vars['output']->value['navbar']['search']!="false"){?>
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['navbar']['id'];?>
" />
            <input type="text" name="searchoid" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['values']['searchoid'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['output']->value['navbar']['autocomplete'])){?> class="<?php echo $_smarty_tpl->tpl_vars['output']->value['navbar']['autocomplete'];?>
" <?php }?> />
        <?php }?>
        
        <?php if ($_smarty_tpl->tpl_vars['output']->value['navbar']['prev']!="false"){?>
            <a href="<?php echo $_smarty_tpl->tpl_vars['output']->value['navbar']['prev'];?>
" title="Vorige" name="prev"><img src="img/1leftarrow.png" /></a>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['output']->value['navbar']['next']!="false"){?>
            <a href="<?php echo $_smarty_tpl->tpl_vars['output']->value['navbar']['next'];?>
" title="Volgende" name="next"><img src="img/1rightarrow.png" /></a>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['output']->value['navbar']['archive']!="false"){?>
            <a href="<?php echo $_smarty_tpl->tpl_vars['output']->value['navbar']['archive'];?>
" title="Archiveren" name="archive"><img src="img/delete.png" /></a>
        <?php }?>
    </form>
</div><?php }} ?>