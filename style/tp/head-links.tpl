		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="{$refeed_root}/style/font.css" media="screen" />
		<link rel="stylesheet" href="{$refeed_root}/style/layout.css" media="screen" />
		<link rel="stylesheet" href="{$refeed_root}/style/color.css" media="screen" />
		<script src="{$refeed_root}/script/comm.js" type="text/javascript"></script>
		<script src="{$refeed_root}/script/app.js" type="text/javascript"></script>
		<script src="{$refeed_root}/script/coord.js" type="text/javascript"></script>
		<script src="{$refeed_root}/script/listitem.js" type="text/javascript"></script>
		<script src="{$refeed_root}/script/feed.js" type="text/javascript"></script>
		<script src="{$refeed_root}/script/item.js" type="text/javascript"></script>
		<script src="{$refeed_root}/script/init.js" type="text/javascript"></script>
		<script src="{$refeed_root}/style/dom.js" type="text/javascript"></script>
		<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />

        <script type="text/javascript" language="javascript1.2">
        // <![CDATA[
{if $_CONSTANTS.REF_USE_KEYBOARD}
            Refeed.App.registerHandler(Refeed.App, document, 'onKeyPress');
	    Refeed.App.use_kb = ({if $_SESSION.use_kb}1{else}0{/if});
            document.framed = {if $framed}true{else}false{/if};

{/if}
	var rf_framed = {if $framed}1{else}0{/if};
	
        // ]]>
        </script>		
