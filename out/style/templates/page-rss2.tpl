{*----------------------------------------
$Id: page-rss2.tpl,v 1.3 2004/12/20 17:32:36 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

page-rss2.tpl - RSS 2.0 output
----------------------------------------*}
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:rb="http://reblog.org/namespace/"
>
<channel>
	<title>{$feed_title|htmlspecialchars}</title>
        <description>{$feed_description|htmlspecialchars}</description>
        <link>{$feed_url|htmlspecialchars}</link>
	<copyright></copyright>
	<generator>reFeed</generator>
	<lastBuildDate>{$now|unix_timestamp2rfc822}</lastBuildDate>
	<docs>http://blogs.law.harvard.edu/tech/rss</docs> 

{foreach from="$item_selects" item=item_select}
	<item>
        	<title>{$item_select.curr_title|htmlspecialchars}</title>
	        <link>{$item_select.curr_link|htmlspecialchars}</link>
	        <guid isPermaLink="false">{$item_select.guid|htmlspecialchars}</guid>
	        <pubDate>{$item_select.timestamp|unix_timestamp2rfc822}</pubDate>
		<author>{$item_select.item.dccreator|htmlspecialchars}</author>
		<source url="{$item_select.feed.url|htmlspecialchars}" link="{$item_select.feed.link|htmlspecialchars}">{$item_select.feed.title|htmlspecialchars}</source>
		<category>{$item_select.subjects|htmlspecialchars}</category>


	        <dc:date>{$item_select.timestamp|unix_timestamp2iso8601}</dc:date>
	        <dc:subject>{$item_select.subjects|htmlspecialchars}</dc:subject>

	        <rb:guid>{$item_select.guid|htmlspecialchars}</rb:guid>
        	<rb:via_url>{$item_select.item.link|htmlspecialchars}</rb:via_url>
        	<rb:source>{$item_select.feed.title|htmlspecialchars}</rb:source>
        	<rb:source_url>{$item_select.feed.link|htmlspecialchars}</rb:source_url>
        	<rb:source_feed_url>{$item_select.feed.url|htmlspecialchars}</rb:source_feed_url>
        	<rb:source_author>{$item_select.item.dccreator|htmlspecialchars}</rb:source_author>
        	<rb:source_published_date>{$item_select.item.orig_dcdate|htmlspecialchars}</rb:source_published_date>

		{include file="content-out.tpl" item_select=$item_select assign=content}
	        <description><![CDATA[{$content|cdata_escape}]]></description>
	</item>
{/foreach}

</channel>
</rss>
