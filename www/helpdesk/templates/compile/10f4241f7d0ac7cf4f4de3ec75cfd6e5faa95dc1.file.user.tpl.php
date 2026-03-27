<?php /* Smarty version Smarty-3.1.8, created on 2013-04-02 13:16:37
         compiled from "templates/default/user.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19618906464efb126c80f899-01228717%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '10f4241f7d0ac7cf4f4de3ec75cfd6e5faa95dc1' => 
    array (
      0 => 'templates/default/user.tpl',
      1 => 1325076292,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19618906464efb126c80f899-01228717',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4efb126c8b95c',
  'variables' => 
  array (
    'output' => 0,
    'afdeling' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4efb126c8b95c')) {function content_4efb126c8b95c($_smarty_tpl) {?><div id="formulier">
    <h1>Aanmaken User Account</h1>
    <p>
        Hier kun je een useraccount aanmaken.<br />
        <br />
        <span class="required">*</span> = verplicht.
    </p>
    <form style="width: auto;" action="index.php?id=user" method="post" />
        <input type="hidden" name="id" value="user" />
        <label for="voornaam">Voornaam <span class="required">*</span></label><br />
        <input type="text" name="voornaam" id="voornaam" /><br />
        <br />
        <label for="tussenvoegsel">Tussenvoegsel</label><br />
        <input type="text" name="tussenvoegsel" id="tussenvoegsel" /><br />
        <br />
        <label for="achternaam">Achternaam <span class="required">*</span></label><br />
        <input type="text" name="achternaam" id="achternaam" /><br />
        <br />
        <br/>
        <label for="adres">Adres <span class="required">*</span></label><br />
        <input type="text" name="adres" id="adres" /><br />
        <br />
        <label for="postcode">Postcode <span class="required">*</span></label><br />
        <input type="text" name="postcode" id="postcode" /><br />
        <br />
        <label for="plaats">Plaats <span class="required">*</span></label><br />
        <input type="text" name="plaats" id="plaats" /><br />
        <br />
        <label for="gebdat">Geboortedatum <span class="required">*</span></label><br />
        <input type="text" autocomplete="off" name="gebdat" id="gebdat" /> <span class="info">Bijv: 01-01-2011</span><br />
        <br />
        <br />
        <label for="begindatum">Begin datum <span class="required">*</span></label><br />
        <input type="text" autocomplete="off" name="begindatum" id="begindatum" /> <span class="info">Bijv: 01-01-2011</span><br />
        <br />
        <label for="afdeling">Afdeling <span class="required">*</span></label><br />
        <select name="afdeling">
            <option value="0"></option>
            <?php  $_smarty_tpl->tpl_vars['afdeling'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['afdeling']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['afdeling']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['afdeling']->key => $_smarty_tpl->tpl_vars['afdeling']->value){
$_smarty_tpl->tpl_vars['afdeling']->_loop = true;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['afdeling']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['afdeling']->value['afdeling'];?>
</option>
            <?php } ?>
        </select>
        <input style="float:right;" name='submit' type="submit" value="Opslaan" />
    </form>
</div>

<div style="position:absolute; top:410px; left:540px;" id="fout">
    <h1>Fout</h1>
    <p></p>
</div><?php }} ?>