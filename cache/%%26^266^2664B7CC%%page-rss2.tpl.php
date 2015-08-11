<?php /* Smarty version 2.6.5-dev, created on 2015-08-06 23:51:28
         compiled from page-rss2.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlspecialchars', 'page-rss2.tpl', 24, false),array('modifier', 'unix_timestamp2rfc822', 'page-rss2.tpl', 29, false),array('modifier', 'unix_timestamp2iso8601', 'page-rss2.tpl', 43, false),array('modifier', 'cdata_escape', 'page-rss2.tpl', 55, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="UTF-8"<?php echo '?>'; ?>

<rss version="2.0"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:rb="http://reblog.org/namespace/"
>
<channel>
	<title><?php echo ((is_array($_tmp=$this->_tpl_vars['feed_title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</title>
        <description><?php echo ((is_array($_tmp=$this->_tpl_vars['feed_description'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</description>
        <link><?php echo ((is_array($_tmp=$this->_tpl_vars['feed_url'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</link>
	<copyright></copyright>
	<generator>reFeed</generator>
	<lastBuildDate><?php echo ((is_array($_tmp=$this->_tpl_vars['now'])) ? $this->_run_mod_handler('unix_timestamp2rfc822', true, $_tmp) : ref_unix_timestamp2rfc822($_tmp)); ?>
</lastBuildDate>
	<docs>http://blogs.law.harvard.edu/tech/rss</docs> 

<?php if (count($_from = (array)($this->_tpl_vars['item_selects']))):
    foreach ($_from as $this->_tpl_vars['item_select']):
?>
	<item>
        	<title><?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['curr_title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</title>
	        <link><?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['curr_link'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</link>
	        <guid isPermaLink="false"><?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['guid'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</guid>
	        <pubDate><?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['timestamp'])) ? $this->_run_mod_handler('unix_timestamp2rfc822', true, $_tmp) : ref_unix_timestamp2rfc822($_tmp)); ?>
</pubDate>
		<author><?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['item']['dccreator'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</author>
		<source url="<?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['feed']['url'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
" link="<?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['feed']['link'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['feed']['title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</source>
		<category><?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['subjects'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</category>


	        <dc:date><?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['timestamp'])) ? $this->_run_mod_handler('unix_timestamp2iso8601', true, $_tmp) : ref_unix_timestamp2iso8601($_tmp)); ?>
</dc:date>
	        <dc:subject><?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['subjects'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</dc:subject>

	        <rb:guid><?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['guid'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</rb:guid>
        	<rb:via_url><?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['item']['link'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</rb:via_url>
        	<rb:source><?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['feed']['title'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</rb:source>
        	<rb:source_url><?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['feed']['link'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</rb:source_url>
        	<rb:source_feed_url><?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['feed']['url'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</rb:source_feed_url>
        	<rb:source_author><?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['item']['dccreator'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</rb:source_author>
        	<rb:source_published_date><?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['item']['orig_dcdate'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
</rb:source_published_date>

		<?php ob_start();
$_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "content-out.tpl", 'smarty_include_vars' => array('item_select' => $this->_tpl_vars['item_select'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
$this->assign('content', ob_get_contents()); ob_end_clean();
 ?>
	        <description><![CDATA[<?php echo ((is_array($_tmp=$this->_tpl_vars['content'])) ? $this->_run_mod_handler('cdata_escape', true, $_tmp) : ref_cdata_escape($_tmp)); ?>
]]></description>
	</item>
<?php endforeach; unset($_from); endif; ?>

</channel>
</rss>