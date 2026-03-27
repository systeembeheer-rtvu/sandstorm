<?php /* Smarty version Smarty-3.1.7, created on 2012-03-09 16:52:52
         compiled from "templates/default\mail\toewijzing.tpl" */ ?>
<?php /*%%SmartyHeaderCode:104474f5a1a2b837539-91515005%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2262b40d1eeba37d42ef2cfad5c5d1b4ea306806' => 
    array (
      0 => 'templates/default\\mail\\toewijzing.tpl',
      1 => 1331308240,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '104474f5a1a2b837539-91515005',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f5a1a2b8945e',
  'variables' => 
  array (
    'output' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f5a1a2b8945e')) {function content_4f5a1a2b8945e($_smarty_tpl) {?><html>
    <head>
    </head>
    <body>
        Beste ICT'er,<br />
        <br />
        Er is een call op je naam gezet door <?php echo $_smarty_tpl->tpl_vars['output']->value['invoerder'];?>
.<br />
        <br />
        <table>
            <tr>
                <td>Invoerder:</td>
                <td><?php echo $_smarty_tpl->tpl_vars['output']->value['behandelaar'];?>
</td>
            </tr>
            <tr>
                <td>Aanmelder:</td>
                <td><?php echo $_smarty_tpl->tpl_vars['output']->value['aanmelder'];?>

            </tr>
            <tr>
                <td>Telefoonnummer</td>
                <td><?php echo $_smarty_tpl->tpl_vars['output']->value['telefoonnummer'];?>
</td>
            </tr>
            <tr>
                <td>Categorie</td>
                <td><?php echo $_smarty_tpl->tpl_vars['output']->value['categorie'];?>
</td>
            </tr>
            <tr style="vertical-align:top">
                <td>Melding</td>
                <td><?php echo $_smarty_tpl->tpl_vars['output']->value['melding'];?>
</td>
            </tr>
        </table>
        <br />
        <a href="http://intranet/ict/toppiedesk2/toppiedesk.php?id=callnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['output']->value['oid'];?>
">Hier de link naar de call</a><br />
        <br />
        Met vriendelijke groet,<br />
        Afdeling ICT<br />
        RTV Utrecht
    </body>
</html><?php }} ?>