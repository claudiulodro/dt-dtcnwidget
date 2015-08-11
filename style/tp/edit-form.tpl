{*----------------------------------------
$Id: edit-form.tpl,v 1.1 2004/11/06 22:46:40 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

edit-form.tpl - form for editing a post
----------------------------------------*}
<form class="preview-form" id="preview-form" name="preview-form" method="POST" action="edit.php">
    <input type="hidden" name="return" value="{$return|htmlspecialchars}" />
    <input type="hidden" name="id" value="{$item_select.item_id}" />

    <label for="title">Title</label>
    <p>
        <input type="text" name="title" id="title" value="{$item_select.curr_title|htmlspecialchars}" size="48" />
    </p>

    <label for="link_select">Link</label>
    <p>
        <input type="radio" name="link_select" id="link_select" value="0" checked="checked" />
        <input name="link" id="link_text" value="{$item_select.curr_link|htmlspecialchars}" onfocus="return edit_link_edit();" size="48" />
        {foreach from=$item_select.links item=link}
            <br />
            <input type="radio" name="link_select" id="link_select" value="{$link|htmlspecialchars}" onclick="return edit_link_select('{$link}');" />
            <a target="{$link|htmlspecialchars}" href="{$link|htmlspecialchars}">{$link|htmlspecialchars}</a>
        {/foreach}
    </p>

    <label for="content">Content</label>
    <p>
        <textarea name="content" id="content" rows="8" cols="48">{$item_select.curr_content|balance_tags}</textarea>
    </p>

    <label for="comment">Comment</label>
    <p>
        <textarea name="comment" id="comment" rows="4" cols="48">{$item_select.comment|balance_tags}</textarea>
    </p>

    <label for="subjects">Subject Tags</label>
    <p>
        <input type="text" name="subjects" id="subjects" value="{$item_select.subjects|htmlspecialchars}" size="48" />
    </p>

    <p>
        <input type="submit" name="action" value="Save/Preview" />
        <input type="submit" name="action" value="{if !$item_select.public}Publish{else}Revoke{/if}" />
        <input type="submit" name="action" value="Revert" />
        <input type="submit" name="action" value="Return to Feed" />
    </p>

</form>
