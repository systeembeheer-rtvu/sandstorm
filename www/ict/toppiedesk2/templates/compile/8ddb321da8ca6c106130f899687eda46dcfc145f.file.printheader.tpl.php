<?php /* Smarty version Smarty-3.1.8, created on 2012-10-29 16:29:33
         compiled from "templates/default/headers/printheader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18687626884efb1925328208-67632539%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8ddb321da8ca6c106130f899687eda46dcfc145f' => 
    array (
      0 => 'templates/default/headers/printheader.tpl',
      1 => 1350647609,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18687626884efb1925328208-67632539',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4efb19253d218',
  'variables' => 
  array (
    'output' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4efb19253d218')) {function content_4efb19253d218($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" />
        <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <META HTTP-EQUIV="Expires" CONTENT="-1">
        
        <title><?php echo $_smarty_tpl->tpl_vars['output']->value['titles']['header'];?>
</title>
        
        <?php if (isset($_smarty_tpl->tpl_vars['output']->value['script'])){?>
            <?php echo $_smarty_tpl->tpl_vars['output']->value['script'];?>

        <?php }?>
        
        <link href="css/reset-min.css" rel="stylesheet" type="text/css" />
        <link href="css/printstyle.css" rel="stylesheet" type="text/css" />
    </head>
    <body onload="window.print()">
        <div id="tester"></div>
        <div id="site">
            <div id="header">
                
                <div class="spacer"></div>
            </div>
            <div id="main"><?php }} ?>