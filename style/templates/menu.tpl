{*----------------------------------------
$Id: menu.tpl,v 1.27 2005/05/12 07:16:54 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

menu.tpl - full top menu, for hub pages
----------------------------------------*}

<script language="javascript1.2">
// <![CDATA[
    Refeed.App.items_href = '{view_link script="view.php" args=$args how="paged" what="new"}';
// ]]>
</script>

{if ($which_page == 'page-feeds') || ($which_page == 'frame-feeds')}
    <ul class="menu">
        <li class="label">Feeds:</li>
        <li><a href="{$refeed_root}/add.php">Add Feeds</a></li>
        <li><a href="{$refeed_root}/update.php">Update All</a></li>
        {if $which_page == 'page-feeds'}
            <li><a href="{$refeed_root}/out/opml.php" target="_blank">Feed List As OPML</a></li>
            <li><a href="{$refeed_root}/out/">Output HTML</a></li>
            <li><a href="{$refeed_root}/out/rss.php?v=1">Output RSS 1.0</a></li>
            <li><a href="{$refeed_root}/out/rss.php?v=2">Output RSS 2.0</a></li>
        {/if}
    </ul>
{/if}


{if $which_page != 'frame-items'}
<!-- IE is fucked --><div></div>
    <ul class="menu">
        <li class="label">More:</li>
        {if $return}
            <li><a href="{$return|htmlspecialchars}">&lt;&lt;&lt;&nbsp;Return</a>
        {/if}
        {if $which_page == 'frame-feeds'}
            <li><a href="{$refeed_root}/" target="_top">No Frames</a></li>
        {elseif $which_page == 'page-items'}
            <li><a href="{view_link script=$refeed_root}" target="_top">Feed List</a></li>
            <li><a href="{$refeed_root}/frames/index.php?{$QUERY_STRING|htmlspecialchars}" target="_top">Frames</a></li>
        {elseif $which_page == 'page-feeds'}
            <li><a href="{$refeed_root}/frames/" target="_top">Frames</a></li>
<li><a id="archive_all" href="do.php?action=mark-items-read&amp;return={$REQUEST_URI|urlencode}&amp;feed=all" onclick="return confirm('Archive everything?');">Archive Everything</a></li>
        {/if}

        <li><a href="http://www.reblog.org" target="_about">About reBlog</a></li>
        <li><a href="README.html">Help</a></li>
    </ul>
{/if}

{if $which_page != 'frame-feeds'}
    <form class="menu-search" action="" method="GET">
        <ul class="menu">

            <li class="label">Filters:</li>

            {if $which_page == "page-items" || $which_page == "frame-items"}
        
                <li><label>New? <input type="radio" onclick="this.form.submit();" name="what" value="new" {if $args.what == "new"}checked="checked"{/if} /></label></li>
                <li><label>Public? <input type="radio" onclick="this.form.submit();" name="what" value="public" {if $args.what == "public"}checked="checked"{/if} /></label></li>
                <li><label>All? <input type="radio" onclick="this.form.submit();" name="what" value="all" {if $args.what == "all"}checked="checked"{/if} /></label></li>
                <li><label>Today? <input type="checkbox" onclick="this.form.submit();" name="when" value="today" {if $args.when == "today"}checked="checked"{/if} /></label></li>

                {if $args.feed}
                    <li><label>Only this feed? <input type="checkbox" onclick="this.form.submit();" name="feed" value="{$args.feed}" checked="checked" /></label></li>
                {/if}

                <input type="hidden" name="howmany" value="{$args.howmany|htmlspecialchars}" />
                <input type="hidden" name="how" value="{$args.how|htmlspecialchars}">
            {/if}        

            <li>
                <label>
                    <!--With word(s):-->
                    <input class="menu-search" type="text" name="search" size="10" value="{$args.search|htmlspecialchars}" />
                    <input class="menu-search-submit" type="Submit" name="action" value="Search" />
                </label>
            </li>

            {if $args.search}
                <li>
                    <label><a href="{view_link script="" args=$args search=""}">Clear Search</a></label>
                </li>
            {/if}

        </ul>
    </form>
{/if}
