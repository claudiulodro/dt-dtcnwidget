{*----------------------------------------
$Id: frameset.tpl,v 1.4 2005/04/19 22:47:20 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

frameset.tpl - frameset for framed view
----------------------------------------*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>reFeed</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<frameset id="hframeset" cols="360, *" onload="top.frames['items'].focus(); top.frames['feeds'].focus();">
        <frame name="feeds" src="feeds.php" />
        {if $QUERY_STRING}
            <frame name="items" src="view.php?{$QUERY_STRING|htmlspecialchars}" />
		{else}
            <frame name="items" src="{view_link script="view.php" what="new" how="paged"}" />
		{/if}
	</frameset>
</html>
