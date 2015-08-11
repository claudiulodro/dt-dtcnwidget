{*----------------------------------------
$Id: page-update.tpl,v 1.7 2005/06/26 23:56:07 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

page-update.tpl - page for updating new items in feeds
----------------------------------------*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">

	<head>
		<title>reFeed: update feeds</title>
                {include file="head-links.tpl"}
	</head>

	<body id="panel-page">

        <div id="head" class="logo">
        
            {include file="menu-minimal.tpl"}
            
        </div>
        
        <div id="body">
        
            <div class="announcement">
                {foreach from=$results item=result}
                    <p>
                        Updating <strong>{$result.title}</strong>...
                        {if $result.updated}Done.{/if}
                        <strong>{$result.new_items}</strong> new items.
			Purged <strong>{$result.del_items}</strong> old items.
			{if $result.err}<BR>ERROR: {$result.err}{/if}
                    </p>
                {/foreach}
            </div>

        </div>

	</body>
</html>
