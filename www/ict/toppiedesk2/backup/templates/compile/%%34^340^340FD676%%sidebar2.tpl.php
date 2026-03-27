<?php /* Smarty version 2.6.19, created on 2011-12-28 13:33:43
         compiled from sidebars/sidebar2.tpl */ ?>
<div id="sidebar">
    <ul>
        <?php $_from = $this->_tpl_vars['output']['links']['sb_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['url']):
?>
            <li><a href="<?php echo $this->_tpl_vars['url']['url']; ?>
"><?php echo $this->_tpl_vars['url']['link']; ?>
</a></li>
        <?php endforeach; endif; unset($_from); ?>
    </ul>
</div>
<div id="content">