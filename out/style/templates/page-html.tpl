{*----------------------------------------
$Id: page-html.tpl,v 1.1 2004/11/18 17:37:10 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

page.tpl - HTML output
----------------------------------------*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>{$feed_title|htmlspecialchars}</title>
        <link rel="alternate" href="rss.php" type="text/xml">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="style/font.css" media="screen" />
        <link rel="stylesheet" href="style/layout.css" media="screen" />
        <link rel="stylesheet" href="style/color.css" media="screen" />
    </head>
    <body>
    
        <div id="head">
        
            <h1><a href="http://www.reblog.org" target="_about" id="logo"><span class="text">reBlog</span></a></h1>
            <h2>{$feed_title|htmlspecialchars}</h2>
        
            <ul class="menu">
                <li class="label">Feeds:</li>
                <li><a href="opml.php" target="_blank">Feed List As OPML</a></li>
                <li><a href="rss.php?v=1">Output RSS 1.0</a></li>
                <li><a href="rss.php?v=2">Output RSS 2.0</a></li>
            </ul>
        
        </div>

        <div id="body">

            <p class="announcement">{$feed_description|htmlspecialchars}</p>
        
            {foreach from="$item_selects" item=item_select}
                {include file="item.tpl" item_select=$item_select}
            {/foreach}
        
        </div>
    
    </body>
</html>
