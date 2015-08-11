{*----------------------------------------
$Id: opml.tpl,v 1.1 2004/11/06 22:46:40 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

opml.tpl - output list of feeds in OPML format
----------------------------------------*}
<?xml version="1.0"?>
<opml>
  <body>
  {foreach from=$feed_selects item=feed_select}
	<outline description="{$feed_select.feed.description|htmlspecialchars}"
             htmlurl="{$feed_select.feed.link|htmlspecialchars}"
             title="{$feed_select.feed.title|htmlspecialchars}"
             xmlUrl="{$feed_select.feed.url|htmlspecialchars}"
	/>
  {/foreach}
  </body>
</opml>
