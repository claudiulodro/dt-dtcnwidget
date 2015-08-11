<?php /* Smarty version 2.6.5-dev, created on 2015-08-07 00:02:39
         compiled from page-update.tpl */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">

	<head>
		<title>reFeed: update feeds</title>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head-links.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</head>

	<body id="panel-page">

        <div id="head" class="logo">
        
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu-minimal.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            
        </div>
        
        <div id="body">
        
            <div class="announcement">
                <?php if (count($_from = (array)$this->_tpl_vars['results'])):
    foreach ($_from as $this->_tpl_vars['result']):
?>
                    <p>
                        Updating <strong><?php echo $this->_tpl_vars['result']['title']; ?>
</strong>...
                        <?php if ($this->_tpl_vars['result']['updated']): ?>Done.<?php endif; ?>
                        <strong><?php echo $this->_tpl_vars['result']['new_items']; ?>
</strong> new items.
			Purged <strong><?php echo $this->_tpl_vars['result']['del_items']; ?>
</strong> old items.
			<?php if ($this->_tpl_vars['result']['err']): ?><BR>ERROR: <?php echo $this->_tpl_vars['result']['err'];  endif; ?>
                    </p>
                <?php endforeach; unset($_from); endif; ?>
            </div>

        </div>

	</body>
</html>