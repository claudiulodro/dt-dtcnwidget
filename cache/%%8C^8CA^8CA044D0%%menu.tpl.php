<?php /* Smarty version 2.6.5-dev, created on 2015-08-06 23:50:02
         compiled from menu.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'view_link', 'menu.tpl', 19, false),array('modifier', 'htmlspecialchars', 'menu.tpl', 43, false),array('modifier', 'urlencode', 'menu.tpl', 52, false),)), $this); ?>

<script language="javascript1.2">
// <![CDATA[
    Refeed.App.items_href = '<?php echo $this->_plugins['function']['view_link'][0][0]->view_link(array('script' => "view.php",'args' => $this->_tpl_vars['args'],'how' => 'paged','what' => 'new'), $this);?>
';
// ]]>
</script>

<?php if (( $this->_tpl_vars['which_page'] == 'page-feeds' ) || ( $this->_tpl_vars['which_page'] == 'frame-feeds' )): ?>
    <ul class="menu">
        <li class="label">Feeds:</li>
        <li><a href="<?php echo $this->_tpl_vars['refeed_root']; ?>
/add.php">Add Feeds</a></li>
        <li><a href="<?php echo $this->_tpl_vars['refeed_root']; ?>
/update.php">Update All</a></li>
        <?php if ($this->_tpl_vars['which_page'] == 'page-feeds'): ?>
            <li><a href="<?php echo $this->_tpl_vars['refeed_root']; ?>
/out/opml.php" target="_blank">Feed List As OPML</a></li>
            <li><a href="<?php echo $this->_tpl_vars['refeed_root']; ?>
/out/">Output HTML</a></li>
            <li><a href="<?php echo $this->_tpl_vars['refeed_root']; ?>
/out/rss.php?v=1">Output RSS 1.0</a></li>
            <li><a href="<?php echo $this->_tpl_vars['refeed_root']; ?>
/out/rss.php?v=2">Output RSS 2.0</a></li>
        <?php endif; ?>
    </ul>
<?php endif; ?>


<?php if ($this->_tpl_vars['which_page'] != 'frame-items'): ?>
<!-- IE is fucked --><div></div>
    <ul class="menu">
        <li class="label">More:</li>
        <?php if ($this->_tpl_vars['return']): ?>
            <li><a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['return'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
">&lt;&lt;&lt;&nbsp;Return</a>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['which_page'] == 'frame-feeds'): ?>
            <li><a href="<?php echo $this->_tpl_vars['refeed_root']; ?>
/" target="_top">No Frames</a></li>
        <?php elseif ($this->_tpl_vars['which_page'] == 'page-items'): ?>
            <li><a href="<?php echo $this->_plugins['function']['view_link'][0][0]->view_link(array('script' => $this->_tpl_vars['refeed_root']), $this);?>
" target="_top">Feed List</a></li>
            <li><a href="<?php echo $this->_tpl_vars['refeed_root']; ?>
/frames/index.php?<?php echo ((is_array($_tmp=$this->_tpl_vars['QUERY_STRING'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
" target="_top">Frames</a></li>
        <?php elseif ($this->_tpl_vars['which_page'] == 'page-feeds'): ?>
            <li><a href="<?php echo $this->_tpl_vars['refeed_root']; ?>
/frames/" target="_top">Frames</a></li>
<li><a id="archive_all" href="do.php?action=mark-items-read&amp;return=<?php echo ((is_array($_tmp=$this->_tpl_vars['REQUEST_URI'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
&amp;feed=all" onclick="return confirm('Archive everything?');">Archive Everything</a></li>
        <?php endif; ?>

        <li><a href="http://www.reblog.org" target="_about">About reBlog</a></li>
        <li><a href="README.html">Help</a></li>
    </ul>
<?php endif; ?>

<?php if ($this->_tpl_vars['which_page'] != 'frame-feeds'): ?>
    <form class="menu-search" action="" method="GET">
        <ul class="menu">

            <li class="label">Filters:</li>

            <?php if ($this->_tpl_vars['which_page'] == "page-items" || $this->_tpl_vars['which_page'] == "frame-items"): ?>
        
                <li><label>New? <input type="radio" onclick="this.form.submit();" name="what" value="new" <?php if ($this->_tpl_vars['args']['what'] == 'new'): ?>checked="checked"<?php endif; ?> /></label></li>
                <li><label>Public? <input type="radio" onclick="this.form.submit();" name="what" value="public" <?php if ($this->_tpl_vars['args']['what'] == 'public'): ?>checked="checked"<?php endif; ?> /></label></li>
                <li><label>All? <input type="radio" onclick="this.form.submit();" name="what" value="all" <?php if ($this->_tpl_vars['args']['what'] == 'all'): ?>checked="checked"<?php endif; ?> /></label></li>
                <li><label>Today? <input type="checkbox" onclick="this.form.submit();" name="when" value="today" <?php if ($this->_tpl_vars['args']['when'] == 'today'): ?>checked="checked"<?php endif; ?> /></label></li>

                <?php if ($this->_tpl_vars['args']['feed']): ?>
                    <li><label>Only this feed? <input type="checkbox" onclick="this.form.submit();" name="feed" value="<?php echo $this->_tpl_vars['args']['feed']; ?>
" checked="checked" /></label></li>
                <?php endif; ?>

                <input type="hidden" name="howmany" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['args']['howmany'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
" />
                <input type="hidden" name="how" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['args']['how'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
">
            <?php endif; ?>        

            <li>
                <label>
                    <!--With word(s):-->
                    <input class="menu-search" type="text" name="search" size="10" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['args']['search'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
" />
                    <input class="menu-search-submit" type="Submit" name="action" value="Search" />
                </label>
            </li>

            <?php if ($this->_tpl_vars['args']['search']): ?>
                <li>
                    <label><a href="<?php echo $this->_plugins['function']['view_link'][0][0]->view_link(array('script' => "",'args' => $this->_tpl_vars['args'],'search' => ""), $this);?>
">Clear Search</a></label>
                </li>
            <?php endif; ?>

        </ul>
    </form>
<?php endif; ?>