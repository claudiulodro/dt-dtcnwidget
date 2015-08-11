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

        // <![CDATA[
{if $_CONSTANTS.REF_USE_KEYBOARD}
            Refeed.App.registerHandler(Refeed.App, document, 'onKeyPress');
	    Refeed.App.use_kb = ({if $_SESSION.use_kb}1{else}0{/if});
            document.framed = {if $framed}true{else}false{/if};

{/if}
	var rf_framed = {if $framed}1{else}0{/if};
	
        // ]]>
        </script>		
