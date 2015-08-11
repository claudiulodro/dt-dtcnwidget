{*----------------------------------------
$Id: page-edit.tpl,v 1.5 2005/04/19 22:47:20 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

page-edit.tpl - page for editing an item
----------------------------------------*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>reFeed: Edit</title>
                {include file="head-links.tpl"}
	</head>

	<body>

        <div id="head" class="logo">
        
            {include file="menu-minimal.tpl"}
            
        </div>
        
        <div id="body">
        
            {assign var="item_id" value=$item_select.item_id}
            {assign var="prev_url" value="preview.php?id=$item_id"}
            
            <div class="preview-page">
                <iframe name="preview-frame" class="preview-frame" src="{$prev_url}"></iframe>
    
                {if $item_select}
                    {include file="edit-form.tpl"}
                {/if}
            </div>

        <div id="foot">
        
            {include file="menu-minimal.tpl"}
        
        </div>

	</body>
</html>
