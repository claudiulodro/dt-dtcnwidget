{*----------------------------------------
$Id: page-addfeed.tpl,v 1.6 2005/06/26 23:56:07 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

page-addfeed.tpl - page for adding feeds from various sources
----------------------------------------*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">

	<head>
		<title>reFeed: add a feed</title>
                {include file="head-links.tpl"}
	</head>

	<body id="panel-page">

        <div id="head" class="logo">
        
            {include file="menu-minimal.tpl"}
            
        </div>
        
        <div id="body">
        
            <div class="announcement">
                <a href="javascript:void(location.href='{$add_url}?rss_url='+escape(location))">reFeed subscribe</a>
                - This bookmarklet will attempt to subscribe to whatever page you are on. 
                <br />
                Drag it to your toolbar and then click on it when you are at a weblog you like. 
            </div>
    
            <form method="post" action="{$add_script}" enctype="multipart/form-data">
                <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
    
                <div class="input-row">
                    <label for="rss_url">Add feed from RSS or weblog URL: </label>
                    <input type="text" name="rss_url" id="rss_url" size="40" value="{$url|htmlspecialchars}" />
                </div>
    
                {if $rss_results} 
                    <div class="announcement">
                        {$rss_results}
                    </div>
                {/if} 
    
                <div class="input-row">
                    <label for="opml_url">Add feeds from OPML file on the internet: </label>
                    <input type="text" name="opml_url" id="opml_url" size="40" value="{$opml}" />
                </div>
    
                {if $opml_results} 
                    <div class="announcement">
                        {$opml_results}
                    </div>
                {/if} 
    
                <div class="input-row">
                    <label for="opml_file">Add feeds from local OPML file: </label>
                    <input type="file" name="opml_file" id="opml_file" size="40" value="{$file}" />
                </div>
    
                {if $file_results} 
                    <div class="announcement">
                        <td colspan="2">{$file_results}
                    </div>
                {/if} 
    
                <div class="input-row">
                    <label for="public">Make feed(s) public: </label>
                    <input type="checkbox" name="public" id="public" value="1" {if $public}checked="checked"{/if} />
                </div>
    
                <div class="input-row">
                    <label for="submit">&nbsp;</label>
                    <input type="submit" name="submit" id="submit" value="Add Feeds" />
                </div>
    
            </form>
        
        </div>

	</body>
</html>
