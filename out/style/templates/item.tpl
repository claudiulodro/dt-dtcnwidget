{*----------------------------------------
$Id: item.tpl,v 1.1 2004/11/18 17:37:10 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

item.tpl - a single item
----------------------------------------*}

<div name="item" class="item">

    <div class="header">
        <h3>{link_feed link=$item_select.feed.link title=$item_select.feed.title description=$item_select.feed.description}</h3>
        <h2>{link_item link=$item_select.item.link title=$item_select.curr_title}</h2>
        
        <p>
            {if $item_select.item.dccreator}by <strong>{$item_select.item.dccreator}</strong>{/if}
            {if $item_select.item.dcsubject}on <strong>{$item_select.item.dcsubject}</strong>{/if}
            {if $item_select.item.dcdate} 
                at <strong>
                {assign var="dcdate" value=$item_select.item.dcdate|iso86012unix_timestamp}
                {$dcdate|date_format:"%B %e, %Y, %H:%M"}
                </strong>
            {/if}
        </p>
    </div>

    <div class="body">
        {$item_select.curr_content}
        {include file="comment-out.tpl" comment=$item_select.comment}

        <div style="clear: both;">&nbsp;</div>
    </div>

</div>
