{*----------------------------------------
$Id: frame-feeds.tpl,v 1.6 2005/04/19 22:47:20 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

frame-feeds.tpl - frame for feeds list
----------------------------------------*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

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
