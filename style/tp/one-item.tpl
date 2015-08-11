{*----------------------------------------
$Id: one-item.tpl,v 1.10 2005/05/10 16:17:26 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

one-item.tpl - a single item
----------------------------------------*}

{if $item_select.read}
    {assign var="class_read" value="read-but-visible"}
{else}
    {assign var="class_read" value="unread"}
{/if}
{if $item_select.public}
    {assign var="class_public" value="public"}
{else}
    {assign var="class_public" value="private"}
{/if}

<div name="item" id="item{$item_select.id}" class="item item_hilight_off {$class_read} {$class_public}">
    <div class="header">
        {if $item_select.read}
            <a id="controlRead{$item_select.id}" class="control control-read"
                title="Mark this item as unread"
                href="{$refeed_root}/do.php?action=mark-item-unread&id={$item_select.id}&return={$REQUEST_URI|urlencode}"
                onclick="return toggle_read({$item_select.id}, {if $framed}1{else}0{/if});"><img id="buttonRead{$item_select.id}" class="button" src="{$refeed_root}/{$style_dir}/images/read.gif" border="0" /></a>
        {else}
            <a id="controlRead{$item_select.id}" class="control control-read"
                title="Mark this item as read"
                href="{$refeed_root}/do.php?action=mark-item-read&id={$item_select.id}&return={$REQUEST_URI|urlencode}"
                onclick="return toggle_read({$item_select.id}, {if $framed}1{else}0{/if});"><img id="buttonRead{$item_select.id}" class="button" src="{$refeed_root}/{$style_dir}/images/unread.gif" border="0" /></a>
        {/if}

        {if $item_select.public}
            <a id="controlPublic{$item_select.id}" class="control control-public"
                title="Mark this item as private"
                href="{$refeed_root}/do.php?action=mark-item-private&id={$item_select.id}&return={$REQUEST_URI|urlencode}"
                onclick="return toggle_public('item', {$item_select.id}, {if $framed}1{else}0{/if});"><img id="buttonPublic{$item_select.id}" class="button" src="{$refeed_root}/{$style_dir}/images/public-item.gif" border="0" /></a>
        {else}
            <a id="controlPublic{$item_select.id}" class="control control-public"
                title="Mark this item as public"
                href="{$refeed_root}/do.php?action=mark-item-public&id={$item_select.id}&return={$REQUEST_URI|urlencode}"
                onclick="return toggle_public('item', {$item_select.id}, {if $framed}1{else}0{/if});"><img id="buttonPublic{$item_select.id}" class="button" src="{$refeed_root}/{$style_dir}/images/private-item.gif" border="0" /></a>
        {/if}

        <h3 class="shy">{link_feed link=$item_select.feed.link title=$item_select.feed.title description=$item_select.feed.description}</h3>

        <h2>{link_item link=$item_select.item.link title=$item_select.curr_title|hilight_search_terms}
            {link_select item=$item_select.id link_index="0" link=$item_select.item.link curr_link=$item_select.curr_link framed=$framed}

            <a class="bold preview-edit" href="{if $framed}../{/if}edit.php?id={$item_select.id}&return={$REQUEST_URI|urlencode}" title="Modify this news item for public consumption">Preview/Edit</a>
            <a class="bold preview-edit" href="#" title="Comment/Tag this item, inline" onclick="toggle_inline_form({$item_select.id}); return false;">Comment/Tag</a>
        </h2>
        <p class="shy">
            {if $item_select.item.dccreator}by <strong>{$item_select.item.dccreator|hilight_search_terms}</strong>{/if}
            {if $item_select.item.dcsubject}on <strong>{$item_select.item.dcsubject|hilight_search_terms}</strong>{/if}
            {if $item_select.item.dcdate} 
                at <strong>
                {assign var="dcdate" value=$item_select.item.dcdate|iso86012unix_timestamp}
                {$dcdate|date_format:"%B %e, %Y, %H:%M"}
                </strong>
            {/if}
            <em>(cached {$item_select.item.timestamp|relative_date})</em>
        </p>

        <form name="commentForm{$item_select.id}" id="commentForm{$item_select.id}" class="comment-form shy" onsubmit="return submit_inline_form({$item_select.id});" style="display: none;">
            <label>
                Comments
                <input type="text" name="comment{$item_select.id}" id="comment{$item_select.id}" value="{$item_select.comment|htmlspecialchars}">
            </label>
            
            <label>
                Tags
                <input type="text" name="subjects{$item_select.id}" id="subjects{$item_select.id}" value="{$item_select.subjects|htmlspecialchars}">
            </label>
        
            <input id="submit{$item_select.id}" type="submit" name="submit" value="Submit/Publish">
            <input id="cancel{$item_select.id}" type="button" name="cancel" value="Cancel" onclick="toggle_inline_form({$item_select.id});">
        </form>
    </div>

    <div class="body shy">
        {content_link_select content=$item_select.curr_content|hilight_search_terms item=$item_select.id curr_link=$item_select.curr_link framed=$framed}

        {include file="comment-out.tpl" comment=$item_select.comment}
    </div>
</div>

<script type="text/javascript" language="javascript1.2">
// <![CDATA[
    Refeed.App.add_list_thing(new Refeed.Item({$item_select.id}, document.getElementById('item{$item_select.id}'), '{$item_select.item.link}', {$link_new_windows}));
// ]]>
</script>
