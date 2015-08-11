<?php /* Smarty version 2.6.5-dev, created on 2015-08-06 23:51:53
         compiled from menu-minimal.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'view_link', 'menu-minimal.tpl', 19, false),array('modifier', 'htmlspecialchars', 'menu-minimal.tpl', 26, false),)), $this); ?>

<script language="javascript1.2">
// <![CDATA[
    Refeed.App.items_href = '<?php echo $this->_plugins['function']['view_link'][0][0]->view_link(array('script' => "view.php",'args' => $this->_tpl_vars['args'],'how' => 'paged','what' => 'new'), $this);?>
';
// ]]>
</script>

<ul class="menu">
    <li class="label">Back:</li>
    <?php if ($this->_tpl_vars['return']): ?>
        <li><a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['return'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
">&lt;&lt;&nbsp;Return</a></li>
    <?php endif; ?>
    <li><a href="<?php echo $this->_tpl_vars['refeed_root']; ?>
/" target="_top">To Feed List</a></li>
    <li><a href="<?php echo $this->_tpl_vars['refeed_root']; ?>
/frames/" target="_top">To Frames</a></li>
</ul>