<?php
/*----------------------------------------
$Id: index.php,v 1.18 2005/04/19 21:24:47 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

index.php - the 'control panel', a list of all feeds
----------------------------------------*/
error_reporting(E_ALL);
    require_once('init.php');

    $page = new RF_Page();

    $args = $page->view_args($_GET);

    $feed_selects = ref_load_feeds($args);

    $all_stats = array(
		       'last_update' => null,
		       'items' => 0,
		       'unread' => 0,
		       'public' => 0
		       );



    $all_stats = array();

    foreach($feed_selects as $fs => $feed_select) {
      $feed_selects[$fs] = $feed_select->arrayify();
      $all_stats[] = &$feed_select->stats();
    }

    $all_stats = RF_FeedStats::sumStats($all_stats);


    $all_stats = new RF_FeedStats($all_stats);
    $all_stats = $all_stats->arrayify();

    $page->assign('args', $args);
    $page->assign('all_stats', $all_stats);
    $page->assign('feed_selects', $feed_selects);
    $page->assign('which_page', 'page-feeds');

    $page->display('page-feeds.tpl');

?>
