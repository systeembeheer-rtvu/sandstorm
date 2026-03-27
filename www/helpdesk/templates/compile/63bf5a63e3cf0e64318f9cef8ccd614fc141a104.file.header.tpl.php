<?php /* Smarty version Smarty-3.1.8, created on 2012-05-21 14:24:29
         compiled from "templates/default/headers/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18376856184efb1077421816-57726535%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '63bf5a63e3cf0e64318f9cef8ccd614fc141a104' => 
    array (
      0 => 'templates/default/headers/header.tpl',
      1 => 1325076292,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18376856184efb1077421816-57726535',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4efb107750d82',
  'variables' => 
  array (
    'output' => 0,
    'settings' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4efb107750d82')) {function content_4efb107750d82($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" />
        <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <META HTTP-EQUIV="Expires" CONTENT="-1">
            
        <title><?php echo $_smarty_tpl->tpl_vars['output']->value['titles']['header'];?>
</title>
        
        <script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" src="js/jquery.autocomplete.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.11.custom.min.js"></script>
        <?php if (isset($_smarty_tpl->tpl_vars['output']->value['script'])){?>
            <?php echo $_smarty_tpl->tpl_vars['output']->value['script'];?>

        <?php }?>
        
        <link href="css/reset-min.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link type="text/css" href="css/jquery-ui-1.8.11.custom.css" rel="Stylesheet" />
    </head>
    <body>
        <div id="tester"></div>
        <div id="site">
            <div id="header">
                <div id="options">
                    <?php  $_smarty_tpl->tpl_vars['settings'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['settings']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['links']['settings']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['settings']->key => $_smarty_tpl->tpl_vars['settings']->value){
$_smarty_tpl->tpl_vars['settings']->_loop = true;
?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['settings']->value['path'];?>
"><img src="img/<?php echo $_smarty_tpl->tpl_vars['settings']->value['img'];?>
" height="25" width="25" alt="<?php echo $_smarty_tpl->tpl_vars['settings']->value['name'];?>
" /></a>
                    <?php } ?>
                </div>
                <div id="title">
                    <?php echo $_smarty_tpl->tpl_vars['output']->value['titles']['page'];?>

                </div>
                
                <div id="links">
                    <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['links']['top_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['value']->value['path'];?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</a>
                    <?php } ?>
                </div>
                <div class="spacer"></div>
            </div>
            <div id="main"><?php }} ?>