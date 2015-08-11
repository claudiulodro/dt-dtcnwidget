<?php /* Smarty version 2.6.5-dev, created on 2015-08-06 23:51:11
         compiled from one-item.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'urlencode', 'one-item.tpl', 33, false),array('modifier', 'hilight_search_terms', 'one-item.tpl', 56, false),array('modifier', 'iso86012unix_timestamp', 'one-item.tpl', 67, false),array('modifier', 'date_format', 'one-item.tpl', 68, false),array('modifier', 'relative_date', 'one-item.tpl', 71, false),array('modifier', 'htmlspecialchars', 'one-item.tpl', 77, false),array('function', 'link_feed', 'one-item.tpl', 54, false),array('function', 'link_item', 'one-item.tpl', 56, false),array('function', 'link_select', 'one-item.tpl', 57, false),array('function', 'content_link_select', 'one-item.tpl', 91, false),)), $this); ?>

<?php if ($this->_tpl_vars['item_select']['read']): ?>
    <?php $this->assign('class_read', "read-but-visible");  else: ?>
    <?php $this->assign('class_read', 'unread');  endif;  if ($this->_tpl_vars['item_select']['public']): ?>
    <?php $this->assign('class_public', 'public');  else: ?>
    <?php $this->assign('class_public', 'private');  endif; ?>

<div name="item" id="item<?php echo $this->_tpl_vars['item_select']['id']; ?>
" class="item item_hilight_off <?php echo $this->_tpl_vars['class_read']; ?>
 <?php echo $this->_tpl_vars['class_public']; ?>
">
    <div class="header">
        <?php if ($this->_tpl_vars['item_select']['read']): ?>
            <a id="controlRead<?php echo $this->_tpl_vars['item_select']['id']; ?>
" class="control control-read"
                title="Mark this item as unread"
                href="<?php echo $this->_tpl_vars['refeed_root']; ?>
/do.php?action=mark-item-unread&id=<?php echo $this->_tpl_vars['item_select']['id']; ?>
&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['REQUEST_URI'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
"
                onclick="return toggle_read(<?php echo $this->_tpl_vars['item_select']['id']; ?>
, <?php if ($this->_tpl_vars['framed']): ?>1<?php else: ?>0<?php endif; ?>);"><img id="buttonRead<?php echo $this->_tpl_vars['item_select']['id']; ?>
" class="button" src="<?php echo $this->_tpl_vars['refeed_root']; ?>
/<?php echo $this->_tpl_vars['style_dir']; ?>
/images/read.gif" border="0" /></a>
        <?php else: ?>
            <a id="controlRead<?php echo $this->_tpl_vars['item_select']['id']; ?>
" class="control control-read"
                title="Mark this item as read"
                href="<?php echo $this->_tpl_vars['refeed_root']; ?>
/do.php?action=mark-item-read&id=<?php echo $this->_tpl_vars['item_select']['id']; ?>
&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['REQUEST_URI'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
"
                onclick="return toggle_read(<?php echo $this->_tpl_vars['item_select']['id']; ?>
, <?php if ($this->_tpl_vars['framed']): ?>1<?php else: ?>0<?php endif; ?>);"><img id="buttonRead<?php echo $this->_tpl_vars['item_select']['id']; ?>
" class="button" src="<?php echo $this->_tpl_vars['refeed_root']; ?>
/<?php echo $this->_tpl_vars['style_dir']; ?>
/images/unread.gif" border="0" /></a>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['item_select']['public']): ?>
            <a id="controlPublic<?php echo $this->_tpl_vars['item_select']['id']; ?>
" class="control control-public"
                title="Mark this item as private"
                href="<?php echo $this->_tpl_vars['refeed_root']; ?>
/do.php?action=mark-item-private&id=<?php echo $this->_tpl_vars['item_select']['id']; ?>
&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['REQUEST_URI'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
"
                onclick="return toggle_public('item', <?php echo $this->_tpl_vars['item_select']['id']; ?>
, <?php if ($this->_tpl_vars['framed']): ?>1<?php else: ?>0<?php endif; ?>);"><img id="buttonPublic<?php echo $this->_tpl_vars['item_select']['id']; ?>
" class="button" src="<?php echo $this->_tpl_vars['refeed_root']; ?>
/<?php echo $this->_tpl_vars['style_dir']; ?>
/images/public-item.gif" border="0" /></a>
        <?php else: ?>
            <a id="controlPublic<?php echo $this->_tpl_vars['item_select']['id']; ?>
" class="control control-public"
                title="Mark this item as public"
                href="<?php echo $this->_tpl_vars['refeed_root']; ?>
/do.php?action=mark-item-public&id=<?php echo $this->_tpl_vars['item_select']['id']; ?>
&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['REQUEST_URI'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
"
                onclick="return toggle_public('item', <?php echo $this->_tpl_vars['item_select']['id']; ?>
, <?php if ($this->_tpl_vars['framed']): ?>1<?php else: ?>0<?php endif; ?>);"><img id="buttonPublic<?php echo $this->_tpl_vars['item_select']['id']; ?>
" class="button" src="<?php echo $this->_tpl_vars['refeed_root']; ?>
/<?php echo $this->_tpl_vars['style_dir']; ?>
/images/private-item.gif" border="0" /></a>
        <?php endif; ?>

        <h3 class="shy"><?php echo $this->_plugins['function']['link_feed'][0][0]->link_feed(array('link' => $this->_tpl_vars['item_select']['feed']['link'],'title' => $this->_tpl_vars['item_select']['feed']['title'],'description' => $this->_tpl_vars['item_select']['feed']['description']), $this);?>
</h3>

        <h2><?php echo $this->_plugins['function']['link_item'][0][0]->link_item(array('link' => $this->_tpl_vars['item_select']['item']['link'],'title' => ((is_array($_tmp=$this->_tpl_vars['item_select']['curr_title'])) ? $this->_run_mod_handler('hilight_search_terms', true, $_tmp) : $this->_plugins['modifier']['hilight_search_terms'][0][0]->hilight_search_terms($_tmp))), $this);?>

            <?php echo $this->_plugins['function']['link_select'][0][0]->link_select(array('item' => $this->_tpl_vars['item_select']['id'],'link_index' => '0','link' => $this->_tpl_vars['item_select']['item']['link'],'curr_link' => $this->_tpl_vars['item_select']['curr_link'],'framed' => $this->_tpl_vars['framed']), $this);?>


            <a class="bold preview-edit" href="<?php if ($this->_tpl_vars['framed']): ?>../<?php endif; ?>edit.php?id=<?php echo $this->_tpl_vars['item_select']['id']; ?>
&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['REQUEST_URI'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
" title="Modify this news item for public consumption">Preview/Edit</a>
            <a class="bold preview-edit" href="#" title="Comment/Tag this item, inline" onclick="toggle_inline_form(<?php echo $this->_tpl_vars['item_select']['id']; ?>
); return false;">Comment/Tag</a>
        </h2>
        <p class="shy">
            <?php if ($this->_tpl_vars['item_select']['item']['dccreator']): ?>by <strong><?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['item']['dccreator'])) ? $this->_run_mod_handler('hilight_search_terms', true, $_tmp) : $this->_plugins['modifier']['hilight_search_terms'][0][0]->hilight_search_terms($_tmp)); ?>
</strong><?php endif; ?>
            <?php if ($this->_tpl_vars['item_select']['item']['dcsubject']): ?>on <strong><?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['item']['dcsubject'])) ? $this->_run_mod_handler('hilight_search_terms', true, $_tmp) : $this->_plugins['modifier']['hilight_search_terms'][0][0]->hilight_search_terms($_tmp)); ?>
</strong><?php endif; ?>
            <?php if ($this->_tpl_vars['item_select']['item']['dcdate']): ?> 
                at <strong>
                <?php $this->assign('dcdate', ((is_array($_tmp=$this->_tpl_vars['item_select']['item']['dcdate'])) ? $this->_run_mod_handler('iso86012unix_timestamp', true, $_tmp) : ref_iso86012unix_timestamp($_tmp))); ?>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['dcdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%B %e, %Y, %H:%M") : smarty_modifier_date_format($_tmp, "%B %e, %Y, %H:%M")); ?>

                </strong>
            <?php endif; ?>
            <em>(cached <?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['item']['timestamp'])) ? $this->_run_mod_handler('relative_date', true, $_tmp) : $this->_plugins['modifier']['relative_date'][0][0]->relative_date($_tmp)); ?>
)</em>
        </p>

        <form name="commentForm<?php echo $this->_tpl_vars['item_select']['id']; ?>
" id="commentForm<?php echo $this->_tpl_vars['item_select']['id']; ?>
" class="comment-form shy" onsubmit="return submit_inline_form(<?php echo $this->_tpl_vars['item_select']['id']; ?>
);" style="display: none;">
            <label>
                Comments
                <input type="text" name="comment<?php echo $this->_tpl_vars['item_select']['id']; ?>
" id="comment<?php echo $this->_tpl_vars['item_select']['id']; ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['comment'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
">
            </label>
            
            <label>
                Tags
                <input type="text" name="subjects<?php echo $this->_tpl_vars['item_select']['id']; ?>
" id="subjects<?php echo $this->_tpl_vars['item_select']['id']; ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['item_select']['subjects'])) ? $this->_run_mod_handler('htmlspecialchars', true, $_tmp) : htmlspecialchars($_tmp)); ?>
">
            </label>
        
            <input id="submit<?php echo $this->_tpl_vars['item_select']['id']; ?>
" type="submit" name="submit" value="Submit/Publish">
            <input id="cancel<?php echo $this->_tpl_vars['item_select']['id']; ?>
" type="button" name="cancel" value="Cancel" onclick="toggle_inline_form(<?php echo $this->_tpl_vars['item_select']['id']; ?>
);">
        </form>
    </div>

    <div class="body shy">
        <?php echo $this->_plugins['function']['content_link_select'][0][0]->content_link_select(array('content' => ((is_array($_tmp=$this->_tpl_vars['item_select']['curr_content'])) ? $this->_run_mod_handler('hilight_search_terms', true, $_tmp) : $this->_plugins['modifier']['hilight_search_terms'][0][0]->hilight_search_terms($_tmp)),'item' => $this->_tpl_vars['item_select']['id'],'curr_link' => $this->_tpl_vars['item_select']['curr_link'],'framed' => $this->_tpl_vars['framed']), $this);?>


        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "comment-out.tpl", 'smarty_include_vars' => array('comment' => $this->_tpl_vars['item_select']['comment'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
</div>

<script type="text/javascript" language="javascript1.2">
// <![CDATA[
    Refeed.App.add_list_thing(new Refeed.Item(<?php echo $this->_tpl_vars['item_select']['id']; ?>
, document.getElementById('item<?php echo $this->_tpl_vars['item_select']['id']; ?>
'), '<?php echo $this->_tpl_vars['item_select']['item']['link']; ?>
', <?php echo $this->_tpl_vars['link_new_windows']; ?>
));
// ]]>
</script>