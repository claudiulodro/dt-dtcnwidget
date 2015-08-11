<?php /* Smarty version 2.6.5-dev, created on 2015-08-06 23:50:52
         compiled from page-html.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'page-html.tpl', 20, false),)), $this); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?php echo ((is_array($_tmp=$this->_tpl_vars['feed_title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</title>
        <link rel="alternate" href="rss.php" type="text/xml">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="style/font.css" media="screen" />
        <link rel="stylesheet" href="style/layout.css" media="screen" />
        <link rel="stylesheet" href="style/color.css" media="screen" />
    </head>
    <body>
    
        <div id="head">
        
            <h1><a href="http://www.reblog.org" target="_about" id="logo"><span class="text">reBlog</span></a></h1>
            <h2><?php echo ((is_array($_tmp=$this->_tpl_vars['feed_title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</h2>
        
            <ul class="menu">
                <li class="label">Feeds:</li>
                <li><a href="opml.php" target="_blank">Feed List As OPML</a></li>
                <li><a href="rss.php?v=1">Output RSS 1.0</a></li>
                <li><a href="rss.php?v=2">Output RSS 2.0</a></li>
            </ul>
        
        </div>

        <div id="body">

            <p class="announcement"><?php echo ((is_array($_tmp=$this->_tpl_vars['feed_description'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</p>
        
            <?php if (count($_from = (array)($this->_tpl_vars['item_selects']))):
    foreach ($_from as $this->_tpl_vars['item_select']):
?>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "item.tpl", 'smarty_include_vars' => array('item_select' => $this->_tpl_vars['item_select'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endforeach; unset($_from); endif; ?>
        
        </div>
    
    </body>
</html>