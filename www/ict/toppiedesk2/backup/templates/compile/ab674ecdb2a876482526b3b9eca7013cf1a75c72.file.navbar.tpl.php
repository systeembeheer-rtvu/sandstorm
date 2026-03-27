<?php /* Smarty version Smarty-3.1.8, created on 2012-07-13 15:53:16
         compiled from "templates/default\navbar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:182934f59d90bab71a4-64500090%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ab674ecdb2a876482526b3b9eca7013cf1a75c72' => 
    array (
      0 => 'templates/default\\navbar.tpl',
      1 => 1325588209,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '182934f59d90bab71a4-64500090',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f59d90bb1c07',
  'variables' => 
  array (
    'output' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f59d90bb1c07')) {function content_4f59d90bb1c07($_smarty_tpl) {?><div id="navbar">
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