{*----------------------------------------
$Id: page-rss1.tpl,v 1.2 2004/11/30 01:31:10 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

page-rss1.tpl - RSS 1.0 output
----------------------------------------*}
<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet href="http://www.w3.org/2000/08/w3c-synd/style.css" type="text/css"?>
<rdf:RDF
    xmlns="http://purl.org/rss/1.0/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:cc="http://web.resource.org/cc/"
    xmlns:rb="http://reblog.org/namespace/">
    <channel rdf:about="{$feed_url|htmlspecialchars}">
        <title>{$feed_title|htmlspecialchars}</title>
        <description>{$feed_description|htmlspecialchars}</description>
        <link>{$feed_url|htmlspecialchars}</link>
        <dc:date>{$now|unix_timestamp2iso8601}</dc:date>
        <items>
            <rdf:Seq>
{foreach from=$item_selects item=item_select}
                <rdf:li rdf:resource="{$item_select.curr_link|htmlspecialchars}"/>
{/foreach}
            </rdf:Seq>

        </items>
    </channel>

{foreach from="$item_selects" item=item_select}
    <item rdf:about="{$item_select.curr_link|htmlspecialchars}">
        <dc:format>text/html</dc:format>
        <title>{$item_select.curr_title|htmlspecialchars}</title>
        <link>{$item_select.curr_link|htmlspecialchars}</link>

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

</rdf:RDF>
