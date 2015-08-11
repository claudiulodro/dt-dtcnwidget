

{if $framed}
    {assign var="class_framed" value="framed"}
{else}
    {assign var="class_framed" value="unframed"}
{/if}

	<tr id="feed0" class="feed feed_hilight_off private {$class_framed} age-{math equation="floor(log(age, 5))" age=$all_stats.age} odd-row" align="left" valign="top">
	<td class="age low-pro">
        	{if $framed}
        	    <span title="{$all_stats.agestr}">{$feed_select.stats.agestrabbr}</span>
	        {else}
        	    {$all_stats.agestr}
	        {/if}
	</td>
	<td class="feed low-pro">
	{if $all_stats.unread}
	<a class="feed" title="new items" href="{view_link script="view.php" args=$args how="paged" what="new"}">All Feeds</a>
	{else}
	All Feeds
	{/if}
	</td>
	<td class="read-count low-pro">
		<a class="unread" title="new items" href="{view_link script="view.php" args=$args what="new" how="paged"}">{$all_stats.unread}{if $framed}n{else} new{/if}</a> 
		/ <a href="{view_link script="view.php" args=$args what="public" how="paged"}">{$all_stats.public}{if $framed}p{else} pub{/if}</a> 
		/ <a class="unread" title="all items" href="{view_link script="view.php" args=$args what="all" how="paged"}">{$all_stats.items}{if $framed}a{else} all{/if}</a> 

	</td>
    {if not $framed}
        <td class="public low-pro">
        </td>
        <td class="actions low-pro">

{* not really needed
            <script type="text/javascript" language="javascript1.2">
            // <![CDATA[
                RF_App.add_list_thing(new RF_Feed(0, document.getElementById('feed0'), '{view_link script="view.php" args=$args how="paged" what="new"}'));
            // ]]>
            </script>
*}

        </td>
    {/if}
	</tr>
