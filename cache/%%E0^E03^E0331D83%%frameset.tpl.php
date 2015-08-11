<?php /* Smarty version 2.6.5-dev, created on 2015-08-07 00:02:27
         compiled from frameset.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'frameset.tpl', 25, false),array('function', 'view_link', 'frameset.tpl', 27, false),)), $this); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html lang="en">
	<head>
		<title>reFeed</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<frameset id="hframeset" cols="360, *" onload="top.frames['items'].focus(); top.frames['feeds'].focus();">
        <frame name="feeds" src="feeds.php" />
        <?php if ($this->_tpl_vars['QUERY_STRING']): ?>
            <frame name="items" src="view.php?<?php echo ((is_array($_tmp=$this->_tpl_vars['QUERY_STRING'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
" />
		<?php else: ?>
            <frame name="items" src="<?php echo $this->_plugins['function']['view_link'][0][0]->view_link(array('script' => "view.php",'what' => 'new','how' => 'paged'), $this);?>
" />
		<?php endif; ?>
	</frameset>
</html>