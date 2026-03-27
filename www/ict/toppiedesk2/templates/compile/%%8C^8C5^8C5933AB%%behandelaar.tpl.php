<?php /* Smarty version 2.6.19, created on 2011-12-28 13:33:43
         compiled from behandelaar.tpl */ ?>
<div class="formulier">
    <h1>Invoerder</h1>
    <form action="toppiedesk.php" method="get" style="padding: 5px;">
        <input type="hidden" name="id" value="setuser" />
        <div class="float">
            
            <select name="behandelaar" id="behandelaar"  size="10">
                <?php $_from = $this->_tpl_vars['output']['behandelaars']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['behandelaar']):
?>
                    <option <?php if ($this->_tpl_vars['behandelaar']['selected'] == 'true'): ?> selected="selected" <?php endif; ?> value="<?php echo $this->_tpl_vars['behandelaar']['id']; ?>
"><?php echo $this->_tpl_vars['behandelaar']['naam']; ?>
</option>
                <?php endforeach; endif; unset($_from); ?>
            </select>
        </div>
        <div class="spacer"></div>
        <input type="submit" value="Ok" name="accept" />
    </form>
</div>