<?php /* Smarty version Smarty-3.1.7, created on 2012-02-24 14:37:19
         compiled from "templates/default\ftp.tpl" */ ?>
<?php /*%%SmartyHeaderCode:214194f47928f33f0d3-55454160%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5359b6a3519a071a0f5e617d0af88ba50aa82ca7' => 
    array (
      0 => 'templates/default\\ftp.tpl',
      1 => 1325588209,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '214194f47928f33f0d3-55454160',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'output' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f47928f393c0',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f47928f393c0')) {function content_4f47928f393c0($_smarty_tpl) {?><div class="formulier">
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