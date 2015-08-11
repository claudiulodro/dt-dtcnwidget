<?php /* Smarty version 2.6.5-dev, created on 2015-08-06 23:50:02
         compiled from kb-indicator.tpl */ ?>
<?php if ($this->_tpl_vars['_CONSTANTS']['REF_USE_KEYBOARD']): ?>
<div id="kb-indicator" class="kb-indicator" style="display: <?php if ($this->_tpl_vars['_SESSION']['use_kb']): ?>block<?php else: ?>none<?php endif; ?>;">
    <a href="#" onclick="toggle_cheatsheet(); return false;"><img src="<?php echo $this->_tpl_vars['refeed_root']; ?>
/<?php echo $this->_tpl_vars['style_dir']; ?>
/images/keyboard-switch.gif" border="0" /></a>
</div>
<script type="text/javascript" language="javascript1.2">
// <![CDATA[
    position_kb_indicator();
// ]]>
</script>
<?php endif; ?>