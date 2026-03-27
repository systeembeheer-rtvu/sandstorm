<?php /* Smarty version Smarty-3.1.8, created on 2013-04-02 15:11:23
         compiled from "templates/default/ftp.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14721639614f54cdec96beb3-58541835%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8cb84b834890be4b0d77f0148ede1d1a13c1b30' => 
    array (
      0 => 'templates/default/ftp.tpl',
      1 => 1350647609,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14721639614f54cdec96beb3-58541835',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f54cdeca3eb4',
  'variables' => 
  array (
    'output' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f54cdeca3eb4')) {function content_4f54cdeca3eb4($_smarty_tpl) {?><div class="formulier">
    <h1>FTP account</h1>
    <form action="toppiedesk.php?id=ftp&searchoid=<?php echo $_smarty_tpl->tpl_vars['output']->value['ftp']['user'];?>
" method="post">
        <table>
            <tr>
                <td>User</td>
                <td><?php echo $_smarty_tpl->tpl_vars['output']->value['ftp']['user'];?>
</td>
            </tr>
            <tr>
                <td>Home directory</td>
                <td><?php echo $_smarty_tpl->tpl_vars['output']->value['ftp']['dir'];?>
</td>
            </tr>
            <tr>
                <td style="vertical-align:top;">Commentaar</td>
                <td><textarea name="comment"><?php echo $_smarty_tpl->tpl_vars['output']->value['ftp']['comment'];?>
</textarea></td>
            </tr>
            <tr>
                <td>Permanent</td>
                <td><input type="checkbox" name="verlopen" <?php if ($_smarty_tpl->tpl_vars['output']->value['ftp']['kanverlopen']==0){?>checked="checked"<?php }?> /></td>
            </tr>
            <tr>            
                <td><span id="color">Verloopdatum</span></td>
                <td><input type="text" name="verloopdat" autocomplete="off" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['ftp']['verloopdatum'];?>
" /></td>
            </tr>
            <tr>
                <td>Wachtwoord Wijzigen</td>
                <td><input type="text" name="password" autocomplete="off" size="23" /></td>
            </tr>
            <tr>
                <td><a href="toppiedesk.php?id=wijzigingftpaccountbeheer">&lt; Terug</a></td>
                <td style="text-align: right;">
                    <input type="submit" name="submit" value="Opslaan" /><input type="submit" name="opschonen" value="Verwijderen" /><br />
                    <span class="info">Met verwijderen wordt het account verwijderd met de volgende opschoon ronde</span>
                </td>
            </tr>
        </table>
        <?php if ($_smarty_tpl->tpl_vars['output']->value['ftp']['AangevraagdDoor']!=''){?><div id="footer">Aangemaakt door <b><?php echo $_smarty_tpl->tpl_vars['output']->value['ftp']['AangevraagdDoor'];?>
</b></div><?php }?>
    </form>
</div>
<?php }} ?>