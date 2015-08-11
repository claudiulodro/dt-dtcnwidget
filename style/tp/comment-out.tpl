{*----------------------------------------
$Id: comment-out.tpl,v 1.1 2004/11/06 22:46:40 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

comment-out.tpl - comment output
----------------------------------------*}
{if $comment}
    <p><em>{$comment|balance_tags}</em></p>
{/if}
    
