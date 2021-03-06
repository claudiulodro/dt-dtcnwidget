{*----------------------------------------
$Id: page-feeds.tpl,v 1.12 2005/05/16 05:14:03 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

page-feeds.tpl - page template for feed list
----------------------------------------*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>reFeed</title>
		{include file="head-links.tpl"}
	</head>

	<body>

        <div id="head" class="logo">
        
            {include file="menu.tpl" args=$args}
        
        </div>

        <div id="body">
            {assign var="cycle" value="by_name"}
            {include file="list-feeds.tpl"}
        
        </div>

        <dl class="cheat-sheet" id="cheatsheet" style="display: none;">
            <dt class="label">Keyboard Shortcuts</dt>

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
                    <strong>Navigate up (,) and down (.) in the list of feeds.</strong>
                    Select rows from the list of displayed feeds.
                    Selection wraps around, so that when you navigate
                    past the final feed on the page, you will be
                    returned to the first feed on the page.
                </dd>
            <dt>return enter</dt>
                <dd>
                    <strong>List feed items.</strong>
                    Navigates to a page showing most-recent items in the
                    currently-selected feed.
                </dd>
            <dt>f i</dt>
                <dd>
                    <strong>List feeds (f) or items (i).</strong>
                    These keys will jump you to the list of all feeds
                    (this page) or the list of all most-recent items.
                </dd>
            <dt>a</dt>
                <dd>
                    <strong>Archive items.</strong>
                    Archives all items in the currently-selected feed.
                    Causes this feeds page to reload.
                </dd>
            <dt>p</dt>
                <dd>
                    <strong>Publish/unpublish feed.</strong>
                    Toggles the publish/unpublish default for a feed.
                    Public feeds are marked in blue, private feeds are
                    not. All future items in a published feed are marked
                    "public", though this action has no effect on past
                    items.
                </dd>
            <dt>u</dt>
                <dd>
                    <strong>Update feed</strong>.
                    Causes ReBlog to look for newly-published items in
                    the currently-selected feed. Normally this happens
                    in the background, so this option is rarely used.
                </dd>
        </dl>

	{include file="kb-indicator.tpl"}

	</body>
</html>
