<?php /* Smarty version 2.6.5-dev, created on 2015-08-11 20:53:11
         compiled from head-links.tpl */ ?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="style/font.css" media="screen" />
		<link rel="stylesheet" href="style/layout.css" media="screen" />
		<link rel="stylesheet" href="style/color.css" media="screen" />
		<script src="/script/comm.js" type="text/javascript"></script>
		<script src="/script/app.js" type="text/javascript"></script>
		<script src="/script/coord.js" type="text/javascript"></script>
		<script src="/script/listitem.js" type="text/javascript"></script>
		<script src="/script/feed.js" type="text/javascript"></script>
		<script src="/script/item.js" type="text/javascript"></script>
		<script src="/script/init.js" type="text/javascript"></script>
		<script src="/style/dom.js" type="text/javascript"></script>
		<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />

        <script type="text/javascript" language="javascript1.2">
        // <![CDATA[
<?php if ($this->_tpl_vars['_CONSTANTS']['REF_USE_KEYBOARD']): ?>
            Refeed.App.registerHandler(Refeed.App, document, 'onKeyPress');
	    Refeed.App.use_kb = (<?php if ($this->_tpl_vars['_SESSION']['use_kb']): ?>1<?php else: ?>0<?php endif; ?>);
            document.framed = <?php if ($this->_tpl_vars['framed']): ?>true<?php else: ?>false<?php endif; ?>;

<?php endif; ?>
	var rf_framed = <?php if ($this->_tpl_vars['framed']): ?>1<?php else: ?>0<?php endif; ?>;
	
        // ]]>
        </script>		