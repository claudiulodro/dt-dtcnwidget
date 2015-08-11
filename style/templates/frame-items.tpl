{*----------------------------------------
$Id: frame-items.tpl,v 1.7 2005/06/26 23:56:07 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

frame-items.tpl - frame for items list
----------------------------------------*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">

	<head>
		<title>{$title}</title>
                {include file="head-links.tpl"}
	</head>
    <body class="body-focus" onload="feeds_delayed_reload();">

        <div id="head" class="logo">
        
            {include file="menu.tpl"}

            <ul class="menu">
                <li class="label">Current Items:</li>
                {if $links}{$links}{/if}
            </ul>
            
            <ul class="menu">
                <li class="label"> </li>
                <li><a id="archive_all" href="{link_all_read item_selects=$item_selects refeed_root=$refeed_root}" title="Mark every item on this page as read - not undo-able!">Archive All Items On This Page</a></li>
            </ul>
            
        </div>

        <div id="body">

    	    {include file="list-items.tpl"}
            
        </div>

        <div id="foot">

            {include file="menu.tpl"}

            <ul class="menu">
                <li class="label">Current Items:</li>
                {if $links}{$links}{/if}
            </ul>
            
            <ul class="menu">
                <li class="label"> </li>
                <li><a id="archive_all" href="{link_all_read item_selects=$item_selects refeed_root=$refeed_root}" title="Mark every item on this page as read - not undo-able!">Archive All Items On This Page</a></li>
            </ul>

        </div>

    </body>
</html>
