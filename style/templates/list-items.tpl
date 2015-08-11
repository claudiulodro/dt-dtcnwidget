{*----------------------------------------
$Id: list-items.tpl,v 1.2 2004/11/11 03:07:51 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

list-items.tpl - list of items
----------------------------------------*}

{foreach from=$item_selects item=item_select}
	{include file="one-item.tpl"}
{/foreach}
