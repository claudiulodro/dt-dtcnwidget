<?php /* Smarty version 2.6.5-dev, created on 2015-08-06 23:53:40
         compiled from opml.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'opml.tpl', 22, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0"<?php echo '?>'; ?>

<opml>
  <body>
  <?php if (count($_from = (array)$this->_tpl_vars['feed_selects'])):
    foreach ($_from as $this->_tpl_vars['feed_select']):
?>
	<outline description="<?php echo ((is_array($_tmp=$this->_tpl_vars['feed_select']['feed']['description'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"
             htmlurl="<?php echo ((is_array($_tmp=$this->_tpl_vars['feed_select']['feed']['link'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"
             title="<?php echo ((is_array($_tmp=$this->_tpl_vars['feed_select']['feed']['title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"
             xmlUrl="<?php echo ((is_array($_tmp=$this->_tpl_vars['feed_select']['feed']['url'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"
	/>
  <?php endforeach; unset($_from); endif; ?>
  </body>
</opml>