<?php /* Smarty version 2.6.5-dev, created on 2015-08-06 23:50:02
         compiled from feed-stats.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'math', 'feed-stats.tpl', 9, false),array('function', 'view_link', 'feed-stats.tpl', 19, false),)), $this); ?>


<?php if ($this->_tpl_vars['framed']): ?>
    <?php $this->assign('class_framed', 'framed');  else: ?>
    <?php $this->assign('class_framed', 'unframed');  endif; ?>

	<tr id="feed0" class="feed feed_hilight_off private <?php echo $this->_tpl_vars['class_framed']; ?>
 age-<?php echo smarty_function_math(array('equation' => "floor(log(age, 5))",'age' => $this->_tpl_vars['all_stats']['age']), $this);?>
 odd-row" align="left" valign="top">
	<td class="age low-pro">
        	<?php if ($this->_tpl_vars['framed']): ?>
        	    <span title="<?php echo $this->_tpl_vars['all_stats']['agestr']; ?>
"><?php echo $this->_tpl_vars['feed_select']['stats']['agestrabbr']; ?>
</span>
	        <?php else: ?>
        	    <?php echo $this->_tpl_vars['all_stats']['agestr']; ?>

	        <?php endif; ?>
	</td>
	<td class="feed low-pro">
	<?php if ($this->_tpl_vars['all_stats']['unread']): ?>
	<a class="feed" title="new items" href="<?php echo $this->_plugins['function']['view_link'][0][0]->view_link(array('script' => "view.php",'args' => $this->_tpl_vars['args'],'how' => 'paged','what' => 'new'), $this);?>
">All Feeds</a>
	<?php else: ?>
	All Feeds
	<?php endif; ?>
	</td>
	<td class="read-count low-pro">
		<a class="unread" title="new items" href="<?php echo $this->_plugins['function']['view_link'][0][0]->view_link(array('script' => "view.php",'args' => $this->_tpl_vars['args'],'what' => 'new','how' => 'paged'), $this);?>
"><?php echo $this->_tpl_vars['all_stats']['unread'];  if ($this->_tpl_vars['framed']): ?>n<?php else: ?> new<?php endif; ?></a> 
		/ <a href="<?php echo $this->_plugins['function']['view_link'][0][0]->view_link(array('script' => "view.php",'args' => $this->_tpl_vars['args'],'what' => 'public','how' => 'paged'), $this);?>
"><?php echo $this->_tpl_vars['all_stats']['public'];  if ($this->_tpl_vars['framed']): ?>p<?php else: ?> pub<?php endif; ?></a> 
		/ <a class="unread" title="all items" href="<?php echo $this->_plugins['function']['view_link'][0][0]->view_link(array('script' => "view.php",'args' => $this->_tpl_vars['args'],'what' => 'all','how' => 'paged'), $this);?>
"><?php echo $this->_tpl_vars['all_stats']['items'];  if ($this->_tpl_vars['framed']): ?>a<?php else: ?> all<?php endif; ?></a> 

	</td>
    <?php if (! $this->_tpl_vars['framed']): ?>
        <td class="public low-pro">
        </td>
        <td class="actions low-pro">


        </td>
    <?php endif; ?>
	</tr>