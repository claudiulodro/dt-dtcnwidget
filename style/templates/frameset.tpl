{*----------------------------------------
$Id: frameset.tpl,v 1.5 2005/06/26 23:56:07 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

frameset.tpl - frameset for framed view
----------------------------------------*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html lang="en">
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
