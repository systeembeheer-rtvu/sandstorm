<?php /* Smarty version Smarty-3.1.8, created on 2012-10-22 15:48:22
         compiled from "templates/default/mail/toewijzing.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17905283674f06a57cebc981-76397187%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ab852a098326933055cb9547cc445ea28da6bad9' => 
    array (
      0 => 'templates/default/mail/toewijzing.tpl',
      1 => 1350647609,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17905283674f06a57cebc981-76397187',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f06a57d07217',
  'variables' => 
  array (
    'output' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f06a57d07217')) {function content_4f06a57d07217($_smarty_tpl) {?><html>
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