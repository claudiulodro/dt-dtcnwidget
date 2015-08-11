<?php
/*----------------------------------------
$Id: view.php,v 1.21 2005/04/24 04:43:14 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

view.php - list of items based on query parameters
----------------------------------------*/

    require_once('init.php');
    
    $page = new RF_Page();

    $args = $page->view_args($_GET);


    $feed = $args['feed'];
    if(!empty($feed)) {
      $feed = RF_Feed::_retrieve($feed);
    }

    $item_selects = ref_load_items($args);
    
    foreach($item_selects as $is => $item_select)
        $item_selects[$is] = $item_select->arrayify();

    $page->assign('args', $args);
    $page->assign('item_selects', $item_selects);
    $page->assign('edit', ($_GET['noedit'] ? false : true));
    $page->assign('title', RF_Page::view_title($feed, $args));
    $page->assign('links', RF_Page::nav_links($feed, $args));
    $page->assign('what', $args['what']);
    $page->assign('which_page', 'page-items');

    $page->display('page-items.tpl');

?>

