{*----------------------------------------
$Id: menu-minimal.tpl,v 1.5 2005/04/19 22:47:20 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

menu-minimal.tpl - minimal top menu, for spoke pages
----------------------------------------*}

<script language="javascript1.2">
// <![CDATA[
    Refeed.App.items_href = '{view_link script="view.php" args=$args how="paged" what="new"}';
// ]]>
</script>

<ul class="menu">
    <li class="label">Back:</li>
    {if $return}
        <li><a href="{$return|htmlspecialchars}">&lt;&lt;&nbsp;Return</a></li>
    {/if}
    <li><a href="{$refeed_root}/" target="_top">To Feed List</a></li>
    <li><a href="{$refeed_root}/frames/" target="_top">To Frames</a></li>
</ul>
