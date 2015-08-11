<?php /* Smarty version 2.6.5-dev, created on 2015-08-06 23:51:53
         compiled from page-addfeed.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'page-addfeed.tpl', 46, false),)), $this); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">

	<head>
		<title>reFeed: add a feed</title>
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
                <a href="javascript:void(location.href='<?php echo $this->_tpl_vars['add_url']; ?>
?rss_url='+escape(location))">reFeed subscribe</a>
                - This bookmarklet will attempt to subscribe to whatever page you are on. 
                <br />
                Drag it to your toolbar and then click on it when you are at a weblog you like. 
            </div>
    
            <form method="post" action="<?php echo $this->_tpl_vars['add_script']; ?>
" enctype="multipart/form-data">
                <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
    
                <div class="input-row">
                    <label for="rss_url">Add feed from RSS or weblog URL: </label>
                    <input type="text" name="rss_url" id="rss_url" size="40" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['url'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
" />
                </div>
    
                <?php if ($this->_tpl_vars['rss_results']): ?> 
                    <div class="announcement">
                        <?php echo $this->_tpl_vars['rss_results']; ?>

                    </div>
                <?php endif; ?> 
    
                <div class="input-row">
                    <label for="opml_url">Add feeds from OPML file on the internet: </label>
                    <input type="text" name="opml_url" id="opml_url" size="40" value="<?php echo $this->_tpl_vars['opml']; ?>
" />
                </div>
    
                <?php if ($this->_tpl_vars['opml_results']): ?> 
                    <div class="announcement">
                        <?php echo $this->_tpl_vars['opml_results']; ?>

                    </div>
                <?php endif; ?> 
    
                <div class="input-row">
                    <label for="opml_file">Add feeds from local OPML file: </label>
                    <input type="file" name="opml_file" id="opml_file" size="40" value="<?php echo $this->_tpl_vars['file']; ?>
" />
                </div>
    
                <?php if ($this->_tpl_vars['file_results']): ?> 
                    <div class="announcement">
                        <td colspan="2"><?php echo $this->_tpl_vars['file_results']; ?>

                    </div>
                <?php endif; ?> 
    
                <div class="input-row">
                    <label for="public">Make feed(s) public: </label>
                    <input type="checkbox" name="public" id="public" value="1" <?php if ($this->_tpl_vars['public']): ?>checked="checked"<?php endif; ?> />
                </div>
    
                <div class="input-row">
                    <label for="submit">&nbsp;</label>
                    <input type="submit" name="submit" id="submit" value="Add Feeds" />
                </div>
    
            </form>
        
        </div>

	</body>
</html>