<?php /* Smarty version 2.6.19, created on 2011-12-28 13:33:43
         compiled from headers/header.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" />
        <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <META HTTP-EQUIV="Expires" CONTENT="-1">
	<title><?php echo $this->_tpl_vars['output']['titles']['header']; ?>
</title>
        
        <script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="js/ui/jquery-ui-1.8.11.custom.min.js"></script>
	<script type="text/javascript" src="js/ui/jquery.ui.datepicker-nl.js"></script>
        <script type="text/javascript" src="js/jquery.ata.js"></script>
        <script type="text/javascript" src="js/jquery.expander.js"></script>
        <script type="text/javascript" src="js/jquery.preload.js"></script>
        <script type="text/javascript" src="js/functions2.js"></script>
	<script type="text/javascript" src="js/jquery.highlight-3.js"></script>
        
        <?php if (isset ( $this->_tpl_vars['output']['script'] )): ?>
            <?php echo $this->_tpl_vars['output']['script']; ?>

        <?php endif; ?>
        
        <link href="css/reset-min.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link type="text/css" href="css/jquery-ui-1.8.11.custom.css" rel="Stylesheet" />
    </head>
    <body>
        <div id="tester"></div>
        <div id="site">
            <div id="header">
                <div id="options">
                    <?php $_from = $this->_tpl_vars['output']['links']['settings']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['settings']):
?>
                        <a href="<?php echo $this->_tpl_vars['settings']['path']; ?>
"><img src="img/<?php echo $this->_tpl_vars['settings']['img']; ?>
" height="25" width="25" alt="<?php echo $this->_tpl_vars['settings']['name']; ?>
" /></a>
                    <?php endforeach; endif; unset($_from); ?>
                </div>
                <div id="title">
                    <?php echo $this->_tpl_vars['output']['titles']['page']; ?>

                </div>
                
                <div id="links">
                    <?php $_from = $this->_tpl_vars['output']['links']['top_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['value']):
?>
                        <a href="<?php echo $this->_tpl_vars['value']['path']; ?>
"><?php echo $this->_tpl_vars['value']['name']; ?>
</a>
                    <?php endforeach; endif; unset($_from); ?>
                </div>
                <div class="spacer"></div>
            </div>
            <div id="main">