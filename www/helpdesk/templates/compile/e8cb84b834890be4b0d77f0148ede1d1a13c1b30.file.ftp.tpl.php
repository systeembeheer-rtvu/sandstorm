<?php /* Smarty version Smarty-3.1.8, created on 2012-05-21 14:24:34
         compiled from "templates/default/ftp.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14397708694efb108b2cc946-43520235%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8cb84b834890be4b0d77f0148ede1d1a13c1b30' => 
    array (
      0 => 'templates/default/ftp.tpl',
      1 => 1332263154,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14397708694efb108b2cc946-43520235',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4efb108b37750',
  'variables' => 
  array (
    'output' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4efb108b37750')) {function content_4efb108b37750($_smarty_tpl) {?><div id="formulier">
    <h1>Aanmaken FTP Account</h1>
    <p>
        Hier kun je een tijdelijk FTP account aanmaken. Dit account zal na 7 dagen verwijderd worden.<br /><br/>
        Mocht een account langer nodig zijn, vul dan de reden in waarvoor het account bedoeld is. De afdeling ICT zal vervolgens de aanvraag verwerken.<br /><br />
        De accountnaam wordt gelijk aan de naam van de map op de T: schijf.<br />
        <br />
        <?php if ($_smarty_tpl->tpl_vars['output']->value['setemail']==1){?>
            Er zal een mail verstuurd worden naar <b><?php echo $_smarty_tpl->tpl_vars['output']->value['email'];?>
</b> met de inloggegevens.<br />
        <br />
        <?php }?>
        <span class="required">*</span> = verplicht.
        <?php if (isset($_smarty_tpl->tpl_vars['output']->value['info'])){?>
            <br /><br />
            <span class="required"><?php echo $_smarty_tpl->tpl_vars['output']->value['info'];?>
</span>
        <?php }?>
    </p>
    
    <div id="hint">
        Geen spaties, geen hoofdletters, alleen a t/m z en cijfers.<br>Maximaal 16 karakters.
    </div>

    <form action="index.php?id=ftp" method="post" id="ftp">
        
        <label for="naam">Accountnaam <span class="required">*</span></label><br />
        <input name="naam" class="account" type="text" id="naam" MAXLENGTH="16" /><br />
        <br />
        <?php if ($_smarty_tpl->tpl_vars['output']->value['setemail']==1){?>
            <input type="hidden" name="email" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['email'];?>
" />
        <?php }else{ ?>
            <label for="email">E-mail <span class="required">*<br/>let op: alleen @rtvutrecht.nl adressen invullen</span></label><br />
            <input type="texy" name="email" id="email" size="40" /><br/><br/>
        <?php }?>
        <label for="omschrijving">Voor wie of wat is het account bedoeld?</label><br />
        <textarea name="omschrijving" id="omschrijving"></textarea><br />
        <br />
        <input type="submit" name="submit" value="Aanvragen" />
    </form>
</div>

<div id="fout">
    <h1>Fout</h1>
    <p>Niet alle velden hebben geldige waardes.</p>
</div><?php }} ?>