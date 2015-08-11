{*----------------------------------------
$Id: content-out.tpl,v 1.1.14.1 2005/08/08 01:16:09 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

content-out.tpl - content output
----------------------------------------*}
{if $item_select}
    {$item_select.curr_content|balance_tags}
    {include file="comment-out.tpl" comment=$item_select.comment}
{*
    {include file="via-out.tpl" link=$item_select.curr_link via=$item_select.item.link via_name=$item_select.feed.title}
*}
{/if}
