{if $feed_select.public}
    {assign var="class_public" value="public"}
{else}
    {assign var="class_public" value="private"}
{/if}
{if $framed}
    {assign var="class_framed" value="framed"}
{else}
    {assign var="class_framed" value="unframed"}
{/if}

<tr id="feed{$feed_select.feed.id}" class="feed feed_hilight_off {$class_public} {$class_framed} age-{math equation="floor(log(age, 5))" age=$feed_select.stats.age} {cycle name=$cycle values=" odd-row,even-row"}" align="left" valign="top">
    <td class="age">
        {if $framed}
            <span class="flag" title="{$feed_select.stats.agestr}">{$feed_select.stats.agestrabbr}</span>
        {else}
            <span class="flag">{$feed_select.stats.agestr}</span>
        {/if}
    </td>
    <td class="feed">
        {if $feed_select.stats.unread}
            <a class="feed" title="new items" href="{view_link script="view.php" args=$args how="paged" what="new" feed=$feed_select.feed.id}">{title_truncate title=$feed_select.feed.title }</a>
        {else}
            {title_truncate title=$feed_select.feed.title}
        {/if}

        (<a href="{$feed_select.feed.link|escape:"html"}">{if $framed}html{else}html{/if}</a>|<a href="{$feed_select.feed.url|escape:"html"}">feed</a>)
    </td>
    <td class="read-count">
        {if $feed_select.stats.unread}
            <a class="unread" title="new items" href="{view_link script="view.php" args=$args what="new" feed=$feed_select.feed.id}">{$feed_select.stats.unread}{if $framed}n{else} new{/if}</a>
        {else}
            0{if $framed}n{else} new{/if} 
        {/if}/

        {if $feed_select.stats.public}
            <a class="unread" title="new items" href="{view_link script="view.php" args=$args what="public" feed=$feed_select.feed.id}">{$feed_select.stats.public}{if $framed}p{else} pub{/if}</a>
        {else}
            0{if $framed}p{else} pub{/if}
        {/if}/
		<a class="unread" title="all items" href="{view_link script="view.php" args=$args what="all" feed=$feed_select.feed.id how="paged"}">{$feed_select.stats.items}{if $framed}a{else} all{/if}</a>
    </td>
    {if not $framed}
        <td class="public">
            {if $feed_select.public}
                <a id="controlPublic{$feed_select.id}" class="control control-public"
                    title="Mark this feed as private"
                    href="{$refeed_root}/do.php?action=mark-feed-private&id={$feed_select.id}&return={$REQUEST_URI|urlencode}"
                    onclick="return toggle_public('feed', {$feed_select.id}, {if $framed}1{else}0{/if});">
                    <img id="buttonPublic{$feed_select.id}" class="button" src="{$style_dir}/images/public-feed.gif" border="0" /></a>
            {else}
                <a id="controlPublic{$feed_select.id}" class="control control-public"
                    title="Mark this feed as public"
                    href="{$refeed_root}/do.php?action=mark-feed-public&id={$feed_select.id}&return={$REQUEST_URI|urlencode}"
                    onclick="return toggle_public('feed', {$feed_select.id}, {if $framed}1{else}0{/if});">
                    <img id="buttonPublic{$feed_select.id}" class="button" src="{$style_dir}/images/private-feed.gif" border="0" /></a>
            {/if}
        </td>
        <td class="actions">
            <a href="update.php?return={$REQUEST_URI|urlencode}&amp;feed={$feed_select.feed.id}">update</a>
            / <a href="delete.php?return={$REQUEST_URI|urlencode}&amp;feed={$feed_select.feed.id}" onclick="return confirm('Delete feed {$feed_select.feed.title|escape:"javascript"}?');">delete</a>
        </td>
    {/if}
</tr>

<script type="text/javascript" language="javascript1.2">
// <![CDATA[
    Refeed.App.add_list_thing(new Refeed.Feed({$feed_select.feed.id}, document.getElementById('feed{$feed_select.feed.id}'), '{view_link script="view.php" args=$args how="paged" what="new" feed=$feed_select.feed.id}'));
// ]]>
</script>
