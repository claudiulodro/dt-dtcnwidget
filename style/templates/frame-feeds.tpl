{*----------------------------------------
$Id: frame-feeds.tpl,v 1.7 2005/06/26 23:56:07 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

frame-feeds.tpl - frame for feeds list
----------------------------------------*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">

	<head>
		<title>{$title}</title>
                {include file="head-links.tpl"}
		<base target="items" />
	</head>

	<body class="framed body-focus" id="panel-page">

        <div id="head" class="head-narrow">
        
            {include file="menu.tpl"}
            
        </div>

        <div id="body">

            <div class="content-immobile" id="feeds_by_name" {*style="display: none;"*}>
                {assign var="cycle" value="by_name"}
                {include file="list-feeds.tpl"}
            </div>

        </div>

	</body>
</html>
