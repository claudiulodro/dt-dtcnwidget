<?php
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
