<?php /* Smarty version Smarty-3.1.8, created on 2013-09-18 16:43:26
         compiled from "templates/default/confignieuwhardwaretype.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11635986815239bc0eb33747-30061147%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24a958d1cd687c6ffa91886218c3efeec17f6ebf' => 
    array (
      0 => 'templates/default/confignieuwhardwaretype.tpl',
      1 => 1350647609,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11635986815239bc0eb33747-30061147',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5239bc0ec55327_13832949',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5239bc0ec55327_13832949')) {function content_5239bc0ec55327_13832949($_smarty_tpl) {?><div class="formulier">
    <h1>Nieuw hardware type</h1>
    <div id="velden">
        <form action="toppiedesk.php?id=confignieuwhardwaretype" method="post">
            <label for="aantal">Aantal velden</label>
            <input type="text" name="aantal" size="1" />
            <input type="submit" name="velden" value="Aanmaken" />
        </form>
    </div>
</div><?php }} ?>