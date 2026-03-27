<?php /* Smarty version Smarty-3.1.8, created on 2012-11-09 15:58:50
         compiled from "templates/default/projecturen.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17337994324efb20f3bfdd31-94874118%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '93e1b6aeed2627cc2b87a0ca1c0c70c70697943d' => 
    array (
      0 => 'templates/default/projecturen.tpl',
      1 => 1350647609,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17337994324efb20f3bfdd31-94874118',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4efb20f40365d',
  'variables' => 
  array (
    'output' => 0,
    'behandelaar' => 0,
    'project' => 0,
    'gebruiker' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4efb20f40365d')) {function content_4efb20f40365d($_smarty_tpl) {?><div class="formulier">
    	<!--
		<h1>Projecturen</h1>
	-->
	<div class="header">
		<span class="title">Projecturen</span>
	        <div style="float:right;"><a href="turbodesk.php?id=projecturen&week=<?php echo $_smarty_tpl->tpl_vars['output']->value['vorige'];?>
">Vorige</a> <a href="turbodesk.php?id=projecturen&week=<?php echo $_smarty_tpl->tpl_vars['output']->value['volgende'];?>
">Volgende</a></div>
	</div>

    <div id="resultaten">
        <form form="js_submit" action="toppiedesk.php?id=projecturen" method="post">
            <input type="hidden" name="week" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['huidige'];?>
" />
            <input type="hidden" name="id" value="projecturen" />
            <table>
                <tr>
                    <td>Medewerker</td>
                    <td>
                        <select name="medewerker" onChange="this.form.submit();">
                            <?php  $_smarty_tpl->tpl_vars['behandelaar'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['behandelaar']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['behandelaars']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['behandelaar']->key => $_smarty_tpl->tpl_vars['behandelaar']->value){
$_smarty_tpl->tpl_vars['behandelaar']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['behandelaar']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['behandelaar']->value['selected']=="true"){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['behandelaar']->value['naam'];?>
</option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Datum</td>
                    <td><input type="text" name="datum" value="<?php echo $_smarty_tpl->tpl_vars['output']->value['search']['datum'];?>
"  /><input type="submit" name="submit" value="Weergeven" /></td>
                </tr>
            </table>
        </form>
        <?php if ($_smarty_tpl->tpl_vars['output']->value['medewerker']>0){?>
            <h2><?php echo $_smarty_tpl->tpl_vars['output']->value['project']['naam'];?>
 - <?php echo $_smarty_tpl->tpl_vars['output']->value['weeknummer'];?>
</h2>
            <table id="table">
                <tr class="even">
                    <td>Maandag</td>
		    <td><?php echo $_smarty_tpl->tpl_vars['output']->value['dagen']['ma'];?>
</td>
                    <td>
                        <table style="width:100%">
                            <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['project']['projecten'][1]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
                                <tr style="border:1px solid #000000">
                                    <td style="border:none;">
                                        <?php if ($_smarty_tpl->tpl_vars['project']->value['type']=="incident"){?><a href="turbodesk.php?id=callnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a>
                                        <?php }else{ ?><a href="toppiedesk.php?id=projectnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a><?php }?>
                                    </td>
                                    <td style="border:none; padding-left:20px; text-align:right;"><b> <?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
</b></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
                <tr class="odd">
                    <td>Dinsdag</td>
		    <td><?php echo $_smarty_tpl->tpl_vars['output']->value['dagen']['di'];?>
</td>
                    <td>
                        <table style="width:100%">
                            <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['project']['projecten'][2]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
                                <tr style="border:1px solid #000000">
                                    <td style="border:none;">
                                       <?php if ($_smarty_tpl->tpl_vars['project']->value['type']=="incident"){?><a href="turbodesk.php?id=callnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a>
                                        <?php }else{ ?><a href="toppiedesk.php?id=projectnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a><?php }?>
                                    </td>
                                    <td style="border:none; padding-left:20px; text-align:right;"><b> <?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
</b></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
                <tr class="even">
                    <td>Woensdag</td>
		    <td><?php echo $_smarty_tpl->tpl_vars['output']->value['dagen']['wo'];?>
</td>
                    <td>
                        <table style="width:100%">
                            <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['project']['projecten'][3]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
                                <tr style="border:1px solid #000000">
                                    <td style="border:none;">
                                       <?php if ($_smarty_tpl->tpl_vars['project']->value['type']=="incident"){?><a href="turbodesk.php?id=callnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a>
                                        <?php }else{ ?><a href="toppiedesk.php?id=projectnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a><?php }?>
                                    </td>
                                    <td style="border:none; padding-left:20px; text-align:right;"><b> <?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
</b></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
                <tr class="odd">
                    <td>Donderdag</td>
		    <td><?php echo $_smarty_tpl->tpl_vars['output']->value['dagen']['do'];?>
</td>
                    <td>
                        <table style="width:100%">
                            <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['project']['projecten'][4]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
                                <tr style="border:1px solid #000000">
                                    <td style="border:none;">
                                        <?php if ($_smarty_tpl->tpl_vars['project']->value['type']=="incident"){?><a href="turbodesk.php?id=callnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a>
                                        <?php }else{ ?><a href="toppiedesk.php?id=projectnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a><?php }?>
                                    </td>
                                    <td style="border:none; padding-left:20px; text-align:right;"><b> <?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
</b></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
                <tr class="even">
                    <td>Vrijdag</td>
		    <td><?php echo $_smarty_tpl->tpl_vars['output']->value['dagen']['vr'];?>
</td>
                    <td>
                        <table style="width:100%">
                            <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['project']['projecten'][5]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
                                <tr style="border:1px solid #000000">
                                    <td style="border:none;">
                                        <?php if ($_smarty_tpl->tpl_vars['project']->value['type']=="incident"){?><a href="turbodesk.php?id=callnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a>
                                        <?php }else{ ?><a href="toppiedesk.php?id=projectnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a><?php }?>
                                    </td>
                                    <td style="border:none; padding-left:20px; text-align:right;"><b> <?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
</b></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
                <tr class="odd">
                    <td>Zaterdag</td>
		    <td><?php echo $_smarty_tpl->tpl_vars['output']->value['dagen']['za'];?>
</td>
                    <td>
                        <table style="width:100%">
                            <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['project']['projecten'][6]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
                                <tr style="border:1px solid #000000">
                                    <td style="border:none;">
                                       <?php if ($_smarty_tpl->tpl_vars['project']->value['type']=="incident"){?><a href="turbodesk.php?id=callnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a>
                                        <?php }else{ ?><a href="toppiedesk.php?id=projectnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a><?php }?>
                                    </td>
                                    <td style="border:none; padding-left:20px; text-align:right;"><b> <?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
</b></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
                <tr class="even">
                    <td>Zondag</td>
		    <td><?php echo $_smarty_tpl->tpl_vars['output']->value['dagen']['zo'];?>
</td>
                    <td>
                        <table style="width:100%">
                            <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['project']['projecten'][0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
                                <tr style="border:1px solid #000000">
                                    <td style="border:none;">
                                       <?php if ($_smarty_tpl->tpl_vars['project']->value['type']=="incident"){?><a href="turbodesk.php?id=callnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a>
                                        <?php }else{ ?><a href="toppiedesk.php?id=projectnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a><?php }?>
                                    </td>
                                    <td style="border:none; padding-left:20px; text-align:right;"><b> <?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
</b></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:center;">
                        <a href="turbodesk.php?id=projecturen&medewerker=<?php echo $_smarty_tpl->tpl_vars['output']->value['medewerker'];?>
&week=<?php echo $_smarty_tpl->tpl_vars['output']->value['vorige'];?>
">Vorige</a> <a href="turbodesk.php?id=projecturen&medewerker=<?php echo $_smarty_tpl->tpl_vars['output']->value['medewerker'];?>
&week=<?php echo $_smarty_tpl->tpl_vars['output']->value['volgende'];?>
">Volgende</a>
                    </td>
                </tr>
            </table>
        <?php }else{ ?>
            <h2><?php echo $_smarty_tpl->tpl_vars['output']->value['weeknummer'];?>
</h2>
            <table id="table">
                <thead>
                    <tr>
                        <td></td>
                        <td>Maandag</td>
                        <td>Dinsdag</td>
                        <td>Woensdag</td>
                        <td>Donderdag</td>
                        <td>Vrijdag</td>
                        <td>Zaterdag</td>
                        <td>Zondag</td>
                    </tr>
		    <tr>
			<td></td>
			<td><?php echo $_smarty_tpl->tpl_vars['output']->value['dagen']['ma'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['output']->value['dagen']['di'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['output']->value['dagen']['wo'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['output']->value['dagen']['do'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['output']->value['dagen']['vr'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['output']->value['dagen']['za'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['output']->value['dagen']['zo'];?>
</td>
			</tr>
                </thead>
                <?php if (count($_smarty_tpl->tpl_vars['output']->value['project'])>0){?>
                    <?php  $_smarty_tpl->tpl_vars['gebruiker'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['gebruiker']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['project']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['gebruiker']->key => $_smarty_tpl->tpl_vars['gebruiker']->value){
$_smarty_tpl->tpl_vars['gebruiker']->_loop = true;
?>
                        <tr class="<?php if ($_smarty_tpl->tpl_vars['gebruiker']->value['color']==0){?>odd<?php }elseif($_smarty_tpl->tpl_vars['gebruiker']->value['color']==1){?>even<?php }?>" >
                            <td>
                                <?php echo $_smarty_tpl->tpl_vars['gebruiker']->value['naam'];?>

                            </td>
                            <td>
                                <table style="width:100%;">
                                    <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['gebruiker']->value['projecten'][1]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
                                        <tr style="border: solid 1px #000" />
                                            <td style="border:none;">
                                                <?php if ($_smarty_tpl->tpl_vars['project']->value['type']=="incident"){?><a href="turbodesk.php?id=callnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a>
						<?php }else{ ?><a href="toppiedesk.php?id=projectnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a><?php }?>
                                            </td>
                                            <td style="border:none; padding-left:20px; text-align:right;"><b> <?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
</b></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td>
                                <table style="width:100%;">
                                    <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['gebruiker']->value['projecten'][2]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
                                        <tr style="border: solid 1px #000" />
                                            <td style="border:none;">
                                                <?php if ($_smarty_tpl->tpl_vars['project']->value['type']=="incident"){?><a href="turbodesk.php?id=callnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a>
						<?php }else{ ?><a href="toppiedesk.php?id=projectnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a><?php }?>
                                            </td>
                                            <td style="border:none; padding-left:20px; text-align:right;"><b> <?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
</b></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td>
                                <table style="width:100%;">
                                    <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['gebruiker']->value['projecten'][3]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
                                        <tr style="border: solid 1px #000" />
                                            <td style="border:none;">
                                                <?php if ($_smarty_tpl->tpl_vars['project']->value['type']=="incident"){?><a href="turbodesk.php?id=callnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a>
						<?php }else{ ?><a href="toppiedesk.php?id=projectnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a><?php }?>
                                            </td>
                                            <td style="border:none; padding-left:20px; text-align:right;"><b> <?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
</b></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td>
                                <table style="width:100%;">
                                    <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['gebruiker']->value['projecten'][4]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
                                        <tr style="border: solid 1px #000" />
                                            <td style="border:none;">
                                               <?php if ($_smarty_tpl->tpl_vars['project']->value['type']=="incident"){?><a href="turbodesk.php?id=callnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a>
						<?php }else{ ?><a href="toppiedesk.php?id=projectnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a><?php }?>
                                            </td>
                                            <td style="border:none; padding-left:20px; text-align:right;"><b> <?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
</b></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td>
                                <table style="width:100%;">
                                    <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['gebruiker']->value['projecten'][5]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
                                        <tr style="border: solid 1px #000" />
                                            <td style="border:none;">
                                               <?php if ($_smarty_tpl->tpl_vars['project']->value['type']=="incident"){?><a href="turbodesk.php?id=callnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a>
						<?php }else{ ?><a href="toppiedesk.php?id=projectnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a><?php }?>
                                            </td>
                                            <td style="border:none; padding-left:20px; text-align:right;"><b> <?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
</b></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td>
                                <table style="width:100%;">
                                    <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['gebruiker']->value['projecten'][6]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
                                        <tr style="border: solid 1px #000" />
                                            <td style="border:none;">
                                                <?php if ($_smarty_tpl->tpl_vars['project']->value['type']=="incident"){?><a href="turbodesk.php?id=callnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a>
						<?php }else{ ?><a href="toppiedesk.php?id=projectnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a><?php }?>
                                            </td>
                                            <td style="border:none; padding-left:20px; text-align:right;"><b> <?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
</b></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                            <td>
                                <table style="width:100%;">
                                    <?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['gebruiker']->value['projecten'][0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
?>
                                        <tr style="border: solid 1px #000" />
                                            <td style="border:none;">
                                                <?php if ($_smarty_tpl->tpl_vars['project']->value['type']=="incident"){?><a href="turbodesk.php?id=callnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a>
						<?php }else{ ?><a href="toppiedesk.php?id=projectnieuw&searchoid=<?php echo $_smarty_tpl->tpl_vars['project']->value['link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['project']->value['project'];?>
</a><?php }?>
                                            </td>
                                            <td style="border:none; padding-left:20px; text-align:right;"><b> <?php echo $_smarty_tpl->tpl_vars['project']->value['bestedetijd'];?>
</b></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                    <?php } ?>
                <?php }else{ ?>
                    <tr class="even">
                        <td colspan="8" style="text-align:center;">
                            Er zijn geen projecten deze week
                        </td>
                    </tr>
                <?php }?>
            </table>
        <?php }?>
        
    </div>
</div><?php }} ?>