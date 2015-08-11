<?php
/*----------------------------------------
$Id: feeds.php,v 1.14 2004/12/20 19:06:50 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

feeds.php - feed list for frames mode
----------------------------------------*/

// Is this a dirty hack?
    ini_set("include_path", join(":", array(ini_get("include_path"), dirname(__FILE__)."/..")));

    require_once('init.php');


    $page = new RF_Page();

    $args = $page->view_args($_GET);

    if(isset($args['search']))
        unset($args['search']);

    $feed_selects = ref_load_feeds($args);


    $all_stats = array();

    foreach($feed_selects as $fs => $feed_select) {
      $feed_selects[$fs] = $feed_select->arrayify();
      $all_stats[] = &$feed_select->stats();
    }

    $all_stats = RF_FeedStats::sumStats($all_stats);

    $unread = 0;

    foreach($feed_selects as $fs)
        $unread += $fs['stats']['unread'];  

    $page->assign('args', $args);
    $page->assign('all_stats', $all_stats);
    $page->assign('title', $title);
    $page->assign('feed_selects', $feed_selects);

    $page->assign('unread_count', $unread);
    $page->assign('feed_count', count($feed_selects));
    $page->assign('framed', true);
    $page->assign('which_page', 'frame-feeds');
    
    $page->display('frame-feeds.tpl');

?>
