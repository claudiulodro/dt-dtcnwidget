{*----------------------------------------
$Id: list-feeds.tpl,v 1.9 2005/01/04 00:41:09 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

list-feeds.tpl - list of feeds, in a table
----------------------------------------*}
<table class="feeds" border="0" cellspacing="0" cellpadding="0">
    <tr class="head" align="left" valign="top">
        <th class="age"><a href="{$PHP_SELF}?feed_sort=age" target="_self">{if not $framed}Age{else}A{/if}</a></th>
        <th class="feed"><a href="{$PHP_SELF}?feed_sort=title" target="_self">Feed</a></th>
        <th class="read-count"><a href="{$PHP_SELF}?feed_sort=items" target="_self">Items</a></th>
        {if not $framed}
            <th class="public">Public?</th>
            <th class="actions">Actions</th>
        {/if}
    </tr>

	{include file="feed-stats.tpl" all_stats=$all_stats}
        {capture assign=sub_section_header}
            <tr class="sub-head" align="left" valign="top">
                <th colspan="5">New Content</th>
            </tr>
        {/capture}

    {foreach from=$feed_selects item=feed_select}
        {if $feed_select.stats.unread}
            {$sub_section_header}
            {assign var="sub_section_header" value=""}
            {include file="one-feed.tpl"}
        {/if}
    {/foreach}

    {capture assign=sub_section_header}
        <tr class="sub-head" align="left" valign="top">
            {if not $framed}
                <th colspan="5">No New Content</th>
            {else}
                <th colspan="3">No New Content</th>
            {/if}
        </tr>
    {/capture}

    {foreach from=$feed_selects item=feed_select}
        {if not $feed_select.stats.unread}
            {$sub_section_header}
            {assign var="sub_section_header" value=""}
            {include file="one-feed.tpl"}
        {/if}
    {/foreach}

</table>
