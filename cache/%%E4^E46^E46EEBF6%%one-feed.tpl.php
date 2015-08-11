<?php /* Smarty version 2.6.5-dev, created on 2015-08-06 23:50:02
         compiled from one-feed.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'math', 'one-feed.tpl', 28, false),array('function', 'cycle', 'one-feed.tpl', 28, false),array('function', 'view_link', 'one-feed.tpl', 38, false),array('function', 'title_truncate', 'one-feed.tpl', 38, false),array('modifier', 'escape', 'one-feed.tpl', 43, false),array('modifier', 'urlencode', 'one-feed.tpl', 64, false),)), $this); ?>

<?php if ($this->_tpl_vars['feed_select']['public']): ?>
    <?php $this->assign('class_public', 'public');  else: ?>
    <?php $this->assign('class_public', 'private');  endif;  if ($this->_tpl_vars['framed']): ?>
    <?php $this->assign('class_framed', 'framed');  else: ?>
    <?php $this->assign('class_framed', 'unframed');  endif; ?>

<tr id="feed<?php echo $this->_tpl_vars['feed_select']['feed']['id']; ?>
" class="feed feed_hilight_off <?php echo $this->_tpl_vars['class_public']; ?>
 <?php echo $this->_tpl_vars['class_framed']; ?>
 age-<?php echo smarty_function_math(array('equation' => "floor(log(age, 5))",'age' => $this->_tpl_vars['feed_select']['stats']['age']), $this);?>
 <?php echo smarty_function_cycle(array('name' => $this->_tpl_vars['cycle'],'values' => " odd-row,even-row"), $this);?>
" align="left" valign="top">
    <td class="age">
        <?php if ($this->_tpl_vars['framed']): ?>
            <span class="flag" title="<?php echo $this->_tpl_vars['feed_select']['stats']['agestr']; ?>
"><?php echo $this->_tpl_vars['feed_select']['stats']['agestrabbr']; ?>
</span>
        <?php else: ?>
            <span class="flag"><?php echo $this->_tpl_vars['feed_select']['stats']['agestr']; ?>
</span>
        <?php endif; ?>
    </td>
    <td class="feed">
        <?php if ($this->_tpl_vars['feed_select']['stats']['unread']): ?>
            <a class="feed" title="new items" href="<?php echo $this->_plugins['function']['view_link'][0][0]->view_link(array('script' => "view.php",'args' => $this->_tpl_vars['args'],'how' => 'paged','what' => 'new','feed' => $this->_tpl_vars['feed_select']['feed']['id']), $this);?>
"><?php echo $this->_plugins['function']['title_truncate'][0][0]->title_truncate(array('title' => $this->_tpl_vars['feed_select']['feed']['title']), $this);?>
</a>
        <?php else: ?>
            <?php echo $this->_plugins['function']['title_truncate'][0][0]->title_truncate(array('title' => $this->_tpl_vars['feed_select']['feed']['title']), $this);?>

        <?php endif; ?>

        (<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['feed_select']['feed']['link'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"><?php if ($this->_tpl_vars['framed']): ?>html<?php else: ?>html<?php endif; ?></a>|<a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['feed_select']['feed']['url'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
">feed</a>)
    </td>
    <td class="read-count">
        <?php if ($this->_tpl_vars['feed_select']['stats']['unread']): ?>
            <a class="unread" title="new items" href="<?php echo $this->_plugins['function']['view_link'][0][0]->view_link(array('script' => "view.php",'args' => $this->_tpl_vars['args'],'what' => 'new','feed' => $this->_tpl_vars['feed_select']['feed']['id']), $this);?>
"><?php echo $this->_tpl_vars['feed_select']['stats']['unread'];  if ($this->_tpl_vars['framed']): ?>n<?php else: ?> new<?php endif; ?></a>
        <?php else: ?>
            0<?php if ($this->_tpl_vars['framed']): ?>n<?php else: ?> new<?php endif; ?> 
        <?php endif; ?>/

        <?php if ($this->_tpl_vars['feed_select']['stats']['public']): ?>
            <a class="unread" title="new items" href="<?php echo $this->_plugins['function']['view_link'][0][0]->view_link(array('script' => "view.php",'args' => $this->_tpl_vars['args'],'what' => 'public','feed' => $this->_tpl_vars['feed_select']['feed']['id']), $this);?>
"><?php echo $this->_tpl_vars['feed_select']['stats']['public'];  if ($this->_tpl_vars['framed']): ?>p<?php else: ?> pub<?php endif; ?></a>
        <?php else: ?>
            0<?php if ($this->_tpl_vars['framed']): ?>p<?php else: ?> pub<?php endif; ?>
        <?php endif; ?>/
		<a class="unread" title="all items" href="<?php echo $this->_plugins['function']['view_link'][0][0]->view_link(array('script' => "view.php",'args' => $this->_tpl_vars['args'],'what' => 'all','feed' => $this->_tpl_vars['feed_select']['feed']['id'],'how' => 'paged'), $this);?>
"><?php echo $this->_tpl_vars['feed_select']['stats']['items'];  if ($this->_tpl_vars['framed']): ?>a<?php else: ?> all<?php endif; ?></a>
    </td>
    <?php if (! $this->_tpl_vars['framed']): ?>
        <td class="public">
            <?php if ($this->_tpl_vars['feed_select']['public']): ?>
                <a id="controlPublic<?php echo $this->_tpl_vars['feed_select']['id']; ?>
" class="control control-public"
                    title="Mark this feed as private"
                    href="<?php echo $this->_tpl_vars['refeed_root']; ?>
/do.php?action=mark-feed-private&id=<?php echo $this->_tpl_vars['feed_select']['id']; ?>
&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['REQUEST_URI'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
"
                    onclick="return toggle_public('feed', <?php echo $this->_tpl_vars['feed_select']['id']; ?>
, <?php if ($this->_tpl_vars['framed']): ?>1<?php else: ?>0<?php endif; ?>);">
                    <img id="buttonPublic<?php echo $this->_tpl_vars['feed_select']['id']; ?>
" class="button" src="<?php echo $this->_tpl_vars['refeed_root']; ?>
/<?php echo $this->_tpl_vars['style_dir']; ?>
/images/public-feed.gif" border="0" /></a>
            <?php else: ?>
                <a id="controlPublic<?php echo $this->_tpl_vars['feed_select']['id']; ?>
" class="control control-public"
                    title="Mark this feed as public"
                    href="<?php echo $this->_tpl_vars['refeed_root']; ?>
/do.php?action=mark-feed-public&id=<?php echo $this->_tpl_vars['feed_select']['id']; ?>
&return=<?php echo ((is_array($_tmp=$this->_tpl_vars['REQUEST_URI'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
"
                    onclick="return toggle_public('feed', <?php echo $this->_tpl_vars['feed_select']['id']; ?>
, <?php if ($this->_tpl_vars['framed']): ?>1<?php else: ?>0<?php endif; ?>);">
                    <img id="buttonPublic<?php echo $this->_tpl_vars['feed_select']['id']; ?>
" class="button" src="<?php echo $this->_tpl_vars['refeed_root']; ?>
/<?php echo $this->_tpl_vars['style_dir']; ?>
/images/private-feed.gif" border="0" /></a>
            <?php endif; ?>
        </td>
        <td class="actions">
            <a href="update.php?return=<?php echo ((is_array($_tmp=$this->_tpl_vars['REQUEST_URI'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
&amp;feed=<?php echo $this->_tpl_vars['feed_select']['feed']['id']; ?>
">update</a>
            / <a href="do.php?action=mark-feed-read&amp;return=<?php echo ((is_array($_tmp=$this->_tpl_vars['REQUEST_URI'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
&amp;feed=<?php echo $this->_tpl_vars['feed_select']['feed']['id']; ?>
">archive all</a>
            / <a href="delete.php?return=<?php echo ((is_array($_tmp=$this->_tpl_vars['REQUEST_URI'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
&amp;feed=<?php echo $this->_tpl_vars['feed_select']['feed']['id']; ?>
" onclick="return confirm('Delete feed <?php echo ((is_array($_tmp=$this->_tpl_vars['feed_select']['feed']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
?');">delete</a>
        </td>
    <?php endif; ?>
</tr>

<script type="text/javascript" language="javascript1.2">
// <![CDATA[
    Refeed.App.add_list_thing(new Refeed.Feed(<?php echo $this->_tpl_vars['feed_select']['feed']['id']; ?>
, document.getElementById('feed<?php echo $this->_tpl_vars['feed_select']['feed']['id']; ?>
'), '<?php echo $this->_plugins['function']['view_link'][0][0]->view_link(array('script' => "view.php",'args' => $this->_tpl_vars['args'],'how' => 'paged','what' => 'new','feed' => $this->_tpl_vars['feed_select']['feed']['id']), $this);?>
'));
// ]]>
</script>