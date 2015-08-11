<?php /* Smarty version 2.6.5-dev, created on 2015-08-11 19:26:58
         compiled from page-feeds.tpl */ ?>
<!DOCTYPE HTML>
<html lang="en">

	<head>
		<title>reFeed</title>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head-links.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</head>

	<body>

        <div id="head" class="logo">
        
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.tpl", 'smarty_include_vars' => array('args' => $this->_tpl_vars['args'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        
        </div>

        <div id="body">
            <?php $this->assign('cycle', 'by_name'); ?>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list-feeds.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        
        </div>

        <dl class="cheat-sheet" id="cheatsheet" style="display: none;">
            <dt class="label">Keyboard Shortcuts</dt>

            <dt>?</dt>
                <dd>
                    <strong>Hide/show this sheet.</strong>
                    This a cheat-sheet that briefly describes the
                    various keyboard control options that ReBlog
                    provides. When keyboard-reactivity is in effect, it
                    can be hidden or shown using the '?' key or the '?'
                    button at the top of the page.
                    <br />
                    <a href="#" onclick="toggle_cheatsheet(); return false;">Hide this sheet now.</a>
                </dd>
            <dt>/</dt>
                <dd>
                    <strong>Toggle keyboard reactivity.</strong>
                    Turns keyboard awareness on and off. This indicator
                    shows when keyboard reactivity is turned on:
                    <br />
                    <img src="<?php echo $this->_tpl_vars['refeed_root']; ?>
/<?php echo $this->_tpl_vars['style_dir']; ?>
/images/keyboard-switch.gif" />
                </dd>
            <dt>, .</dt>
                <dd>
                    <strong>Navigate up (,) and down (.) in the list of feeds.</strong>
                    Select rows from the list of displayed feeds.
                    Selection wraps around, so that when you navigate
                    past the final feed on the page, you will be
                    returned to the first feed on the page.
                </dd>
            <dt>return enter</dt>
                <dd>
                    <strong>List feed items.</strong>
                    Navigates to a page showing most-recent items in the
                    currently-selected feed.
                </dd>
            <dt>f i</dt>
                <dd>
                    <strong>List feeds (f) or items (i).</strong>
                    These keys will jump you to the list of all feeds
                    (this page) or the list of all most-recent items.
                </dd>
            <dt>a</dt>
                <dd>
                    <strong>Archive items.</strong>
                    Archives all items in the currently-selected feed.
                    Causes this feeds page to reload.
                </dd>
            <dt>p</dt>
                <dd>
                    <strong>Publish/unpublish feed.</strong>
                    Toggles the publish/unpublish default for a feed.
                    Public feeds are marked in blue, private feeds are
                    not. All future items in a published feed are marked
                    "public", though this action has no effect on past
                    items.
                </dd>
            <dt>u</dt>
                <dd>
                    <strong>Update feed</strong>.
                    Causes ReBlog to look for newly-published items in
                    the currently-selected feed. Normally this happens
                    in the background, so this option is rarely used.
                </dd>
        </dl>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "kb-indicator.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	</body>
</html>