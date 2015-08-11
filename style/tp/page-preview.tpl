{*----------------------------------------
$Id: page-preview.tpl,v 1.5 2005/04/19 22:47:20 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

page-preview.tpl - page template for previewing an item being edited
----------------------------------------*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>reFeed: Preview/Edit</title>
                {include file="head-links.tpl"}

	</head>

	<body class="preview">
	
        <div id="body">

            {if !$item_select}
                SORRY, THAT ITEM WAS NO GOOD

            {else}
                <h2><a href="{$item_select.curr_link}">{$item_select.curr_title}</a></h2>
        
                {include file="content-out.tpl" item_select=$item_select}
                {include file="via-out.tpl" item_select=$item_select}
    
                <p>
                    <a href="{$item_select.item.link|htmlspecialchars}">Originally</a>
                    {if $item_select.item.dccreator}
                        by {$item_select.item.dccreator}
                    {/if}
                    from <a href="{$item_select.feed.link|htmlspecialchars}">{$item_select.feed.title|htmlspecialchars}</a>
                    {if $item_select.item.dcdate} 
                        at {assign var="dcdate" value=$item_select.item.dcdate|iso86012unix_timestamp}
                        {$dcdate|date_format:"%B %e, %Y, %H:%M"}
                    {/if}
                </p>
            {/if}
	
        </div>

    </body>
</html>
