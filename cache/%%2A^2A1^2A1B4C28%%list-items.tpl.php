<?php /* Smarty version 2.6.5-dev, created on 2015-08-06 23:51:11
         compiled from list-items.tpl */ ?>

<?php if (count($_from = (array)$this->_tpl_vars['item_selects'])):
    foreach ($_from as $this->_tpl_vars['item_select']):
?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "one-item.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  endforeach; unset($_from); endif; ?>