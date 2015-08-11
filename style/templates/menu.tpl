<script language="javascript1.2">
// <![CDATA[
    Refeed.App.items_href = '{view_link script="view.php" args=$args how="paged" what="new"}';
// ]]>
</script>

{if ($which_page == 'page-feeds') || ($which_page == 'frame-feeds')}
    <ul class="menu">
        <li class="label">Feeds:</li>
        <li><a href="add.php">Add Feeds</a></li>
        <li><a href="update.php">Update All</a></li>
        {if $which_page == 'page-feeds'}
            <li><a href="out/">Output HTML</a></li>
            <li><a href="out/rss.php?v=2">Output RSS 2.0</a></li>
        {/if}
    </ul>
{/if}