{*----------------------------------------
$Id: via-out.tpl,v 1.1 2004/11/06 22:46:40 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

via-out.tpl - output an item's "via" link
----------------------------------------*}
{if $link && $via && ($link ne $via)}
    <p><a href="{$via|htmlspecialchars}">Via{if $via_name} {$via_name|htmlspecialchars}{/if}</a></p>
{/if}
