<?php /* Smarty version 2.6.5-dev, created on 2015-08-06 23:51:11
         compiled from comment-out.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'balance_tags', 'comment-out.tpl', 17, false),)), $this); ?>
<?php if ($this->_tpl_vars['comment']): ?>
    <p><em><?php echo ((is_array($_tmp=$this->_tpl_vars['comment'])) ? $this->_run_mod_handler('balance_tags', true, $_tmp) : $this->_plugins['modifier']['balance_tags'][0][0]->balance_tags($_tmp)); ?>
</em></p>
<?php endif; ?>
    