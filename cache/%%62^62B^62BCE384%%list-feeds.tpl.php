<?php /* Smarty version 2.6.5-dev, created on 2015-08-06 23:50:02
         compiled from list-feeds.tpl */ ?>
<table class="feeds" border="0" cellspacing="0" cellpadding="0">
    <tr class="head" align="left" valign="top">
        <th class="age"><a href="<?php echo $this->_tpl_vars['PHP_SELF']; ?>
?feed_sort=age" target="_self"><?php if (! $this->_tpl_vars['framed']): ?>Age<?php else: ?>A<?php endif; ?></a></th>
        <th class="feed"><a href="<?php echo $this->_tpl_vars['PHP_SELF']; ?>
?feed_sort=title" target="_self">Feed</a></th>
        <th class="read-count"><a href="<?php echo $this->_tpl_vars['PHP_SELF']; ?>
?feed_sort=items" target="_self">Items</a></th>
        <?php if (! $this->_tpl_vars['framed']): ?>
            <th class="public">Public?</th>
            <th class="actions">Actions</th>
        <?php endif; ?>
    </tr>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "feed-stats.tpl", 'smarty_include_vars' => array('all_stats' => $this->_tpl_vars['all_stats'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php ob_start(); ?>
            <tr class="sub-head" align="left" valign="top">
                <th colspan="5">New Content</th>
            </tr>
        <?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('sub_section_header', ob_get_contents());ob_end_clean(); ?>

    <?php if (count($_from = (array)$this->_tpl_vars['feed_selects'])):
    foreach ($_from as $this->_tpl_vars['feed_select']):
?>
        <?php if ($this->_tpl_vars['feed_select']['stats']['unread']): ?>
            <?php echo $this->_tpl_vars['sub_section_header']; ?>

            <?php $this->assign('sub_section_header', ""); ?>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "one-feed.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php endif; ?>
    <?php endforeach; unset($_from); endif; ?>

    <?php ob_start(); ?>
        <tr class="sub-head" align="left" valign="top">
            <?php if (! $this->_tpl_vars['framed']): ?>
                <th colspan="5">No New Content</th>
            <?php else: ?>
                <th colspan="3">No New Content</th>
            <?php endif; ?>
        </tr>
    <?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('sub_section_header', ob_get_contents());ob_end_clean(); ?>

    <?php if (count($_from = (array)$this->_tpl_vars['feed_selects'])):
    foreach ($_from as $this->_tpl_vars['feed_select']):
?>
        <?php if (! $this->_tpl_vars['feed_select']['stats']['unread']): ?>
            <?php echo $this->_tpl_vars['sub_section_header']; ?>

            <?php $this->assign('sub_section_header', ""); ?>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "one-feed.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php endif; ?>
    <?php endforeach; unset($_from); endif; ?>

</table>