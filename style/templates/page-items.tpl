{*----------------------------------------
$Id: page-items.tpl,v 1.15 2005/06/26 23:56:07 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

page-items.tpl - page template for items list
----------------------------------------*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">

	<head>
		<title>reFeed: {$title}</title>
                {include file="head-links.tpl"}
	</head>

	<body>

        <div id="head" class="logo">
        
            {include file="menu.tpl" args=$args}
        
            <ul class="menu">
                <li class="label">Current Items:</li>
                {if $links}{$links}{/if}
                <li><a id="archive_all" href="{link_all_read item_selects=$item_selects refeed_root=$refeed_root}" title="Mark every item on this page as read - not undo-able!">Archive All Items On This Page</a></li>
            </ul>
            
        </div>

        <div id="body">

            {include file="list-items.tpl"}

	    {if !$item_selects}
		<a href="{view_link script=$refeed_root}" target="_top">There are no items to view, go back to the Feed List</a>
	    {/if}

        </div>

        <div id="foot">

            {include file="menu.tpl"}

            <ul class="menu">
                <li class="label">Current Items:</li>
                {if $links}{$links}{/if}
                <li><a href="{link_all_read item_selects=$item_selects refeed_root=$refeed_root}" title="Mark every item on this page as read - not undo-able!">Archive All Items On This Page</a></li>
            </ul>
    
        </div>
            
        <dl class="cheat-sheet" id="cheatsheet" style="display: none;">
            <dt class="label">Keyboard Shortcuts:</dt>

            <dt>?</dt>
                <dd>
                    <strong>Hide/show this sheet.</strong>
                    This a cheat-sheet that briefly describes the
                    various keyboard control options that ReBlog
                    provides. When keyboard-reactivity is in effect, it
                    can be hidden or shown using the '?' key or the '?'
                    button at the top of the page.
                    <br />
                    <a href="#" onclick="toggle_cheatsheet(); return false;">Hide this sheet now.</a>
                </dd>
            <dt>/</dt>
                <dd>
                    <strong>Toggle keyboard reactivity.</strong>
                    Turns keyboard awareness on and off. This indicator
                    shows when keyboard reactivity is turned on:
                    <br />
                    <img src="{$refeed_root}/{$style_dir}/images/keyboard-switch.gif" />
                </dd>
            <dt>, .</dt>
                <dd>
                    <strong>Navigate up (,) and down (.) in the list of items.</strong>
                    Select from the list of displayed items. Selection
                    wraps around, so that when you navigate past the
                    final item on the page, you will be returned to the
                    first item on the page.
                </dd>
            <dt>f i</dt>
                <dd>
                    <strong>List feeds (f) or items (i).</strong>
                    These keys will jump you to the list of all feeds or
                    the list of all most-recent items in the current
                    feed (if any).
                </dd>
            <dt>a p</dt>
                <dd>
                    <strong>Archive/unarchive, Publish/unpublish item.</strong>
                    Toggles archived or published status for the
                    currently-selected item. These actions can be undone
                    by repeating the same keypress, just like pressing
                    the "archive", "disinter", "publish" or "revoke"
                    buttons attached to an item. Public items are marked
                    in blue, private items are not.
                </dd>
            <dt>return enter</dt>
                <dd>
                    <strong>Follow link.</strong>
                    Navigates to the page a given items links to.
                </dd>
            <dt>A</dt>
                <dd>
                    <strong>Archive all items on this page.</strong>
                    Archives every item displayed on the current page.
                    Causes this page to reload.
                </dd>
            <dt>0 - 9</dt>
                <dd>
                    <strong>Select link.</strong>
                    Selects a link from the item body to be the active
                    link in the republished feed. Links in the body are
                    marked with numbered icons:
                    <img src="{$refeed_root}/{$style_dir}/images/selected.gif" />
                    <img src="{$refeed_root}/{$style_dir}/images/unselected.gif" />
                </dd>
            <dt>ctrl + (0 - 9) OR alt + (0 - 9)</dt>
                <dd>
                    <strong>Open link.</strong>
                    Opens a link from the item body in a new window.
                    Note that you may need to set your browser to permit
                    popups. Links in the body are marked with numbered
                    icons:
                    <img src="{$refeed_root}/{$style_dir}/images/selected.gif" />
                    <img src="{$refeed_root}/{$style_dir}/images/unselected.gif" />
                </dd>
    
            <dt>c</dt>
                <dd>
                    <strong>Open the inline comment/tag form.</strong>
                    Opens a small form that can be used to add comments
                    and tags to the currently-selected item. Submitting
                    this form also publishes the item.
                </dd>
            <dt>esc</dt>
                <dd>
                    <strong>Close the inline comment/tag form.</strong>
                    Closes an open comment form on the
                    currently-selected item, without adding comments or
                    publishing the item.
                </dd>
        </dl>

	{include file="kb-indicator.tpl"}
    
	</body>
</html>
