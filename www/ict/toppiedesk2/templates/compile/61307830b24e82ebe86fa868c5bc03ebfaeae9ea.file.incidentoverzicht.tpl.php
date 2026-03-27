<?php /* Smarty version Smarty-3.1.8, created on 2012-10-19 13:51:35
         compiled from "templates/default\incidentoverzicht.tpl" */ ?>
<?php /*%%SmartyHeaderCode:309504f47683b046f93-36619749%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '61307830b24e82ebe86fa868c5bc03ebfaeae9ea' => 
    array (
      0 => 'templates/default\\incidentoverzicht.tpl',
      1 => 1350647491,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '309504f47683b046f93-36619749',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f47683b0ce15',
  'variables' => 
  array (
    'output' => 0,
    'andere' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f47683b0ce15')) {function content_4f47683b0ce15($_smarty_tpl) {?><div class="formulier">
	<!--<h1>Overzicht incidenten</h1>-->
	<div class="header">
		<span class="title">Overzicht incidenten</span>
		<div style="float:right;">
			<form id="submitForm" action="" method="get">
				<input type="hidden" name="id" value="calloverzicht" />
				<input type="checkbox" name="open" <?php if ($_smarty_tpl->tpl_vars['output']->value['open']==1){?>checked="checked" <?php }?>/>Alleen opstaande meldingen tonen
			</form>
		</div>
	</div>
	<div id="resultaten">
		<table id="table">
			<thead>
				<tr>
				<td>Naam</td>
				<td style="width:80px;">Datum</td>
				<td>Categorie</td>
				<td>Probleem</td>
				<td>
					#&nbsp;<a href="URL" onclick="window.open('info.html', 'venster_naam', 'width=200,height=100,location=no,status=no,menubar=no,directory=no,toolbar=no,resizable=no'); return false">?</a>	
				</td>
				<td>Status</td>
				<td>Behandelaar</td>
				</tr>
			</thead>
			<?php if ($_smarty_tpl->tpl_vars['output']->value['counter']['overzicht']>0){?>
				<?php  $_smarty_tpl->tpl_vars['andere'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['andere']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['output']->value['overzicht']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['andere']->key => $_smarty_tpl->tpl_vars['andere']->value){
$_smarty_tpl->tpl_vars['andere']->_loop = true;
?>
					<tr class="
						<?php if ($_smarty_tpl->tpl_vars['andere']->value['color']==1){?>odd
						<?php }elseif($_smarty_tpl->tpl_vars['andere']->value['color']==2){?>even oldborder
						<?php }elseif($_smarty_tpl->tpl_vars['andere']->value['color']==3){?>odd oldborder
						<?php }elseif($_smarty_tpl->tpl_vars['andere']->value['color']==5){?>user
						<?php }elseif($_smarty_tpl->tpl_vars['andere']->value['color']==0){?>even<?php }?>
						
						<?php if ($_smarty_tpl->tpl_vars['andere']->value['afgemeld']==1){?>afgemeld<?php }?>
						
						pointer"
					    
						<?php if ($_smarty_tpl->tpl_vars['andere']->value['actie']!=''){?>
							onmouseover='return tooltip("<?php echo $_smarty_tpl->tpl_vars['andere']->value['actie'];?>
","","bordercolor:black, border:1, backcolor:#d3d3d3");'
							onmouseout='return hideTip();'
						<?php }?>
					    
						onclick="window.open('toppiedesk.php?id=<?php echo $_smarty_tpl->tpl_vars['output']->value['page']['id'];?>
&searchoid=<?php echo $_smarty_tpl->tpl_vars['andere']->value['id'];?>
','_blank');">
						<td><?php echo $_smarty_tpl->tpl_vars['andere']->value['naam'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['andere']->value['datum'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['andere']->value['categorie'];?>
</td>
						<td class="probleem"><?php echo $_smarty_tpl->tpl_vars['andere']->value['probleem'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['andere']->value['counter'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['andere']->value['status'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['andere']->value['behandelaar'];?>
</td>
					</tr>
				<?php } ?>
			<?php }else{ ?>
				<tr><td colspan="6">Geen incidenten</td></tr>
			<?php }?>
		</table>
	</div>
</div>
<div id="tiplayer" style="position:absolute; visibility:hidden; z-index:10000;"></div><?php }} ?>