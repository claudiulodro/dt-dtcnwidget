{if $_CONSTANTS.REF_USE_KEYBOARD}
<div id="kb-indicator" class="kb-indicator" style="display: {if $_SESSION.use_kb}block{else}none{/if};">
    <a href="#" onclick="toggle_cheatsheet(); return false;"><img src="{$refeed_root}/{$style_dir}/images/keyboard-switch.gif" border="0" /></a>
</div>
<script type="text/javascript" language="javascript1.2">
// <![CDATA[
    position_kb_indicator();
// ]]>
</script>
{/if}
