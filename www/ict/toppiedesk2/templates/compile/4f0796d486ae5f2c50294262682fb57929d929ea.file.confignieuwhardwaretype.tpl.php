<?php /* Smarty version Smarty-3.1.8, created on 2012-07-13 15:53:41
         compiled from "templates/default\confignieuwhardwaretype.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6955500028650404e3-25854738%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4f0796d486ae5f2c50294262682fb57929d929ea' => 
    array (
      0 => 'templates/default\\confignieuwhardwaretype.tpl',
      1 => 1325588209,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6955500028650404e3-25854738',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_50002865074957_16257277',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50002865074957_16257277')) {function content_50002865074957_16257277($_smarty_tpl) {?><div class="formulier">
    <h1>Nieuw hardware type</h1>
    <div id="velden">
        <form action="toppiedesk.php?id=confignieuwhardwaretype" method="post">
            <label for="aantal">Aantal velden</label>
            <input type="text" name="aantal" size="1" />
            <input type="submit" name="velden" value="Aanmaken" />
        </form>
    </div>
</div><?php }} ?>