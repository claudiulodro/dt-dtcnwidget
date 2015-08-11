<?php
/*----------------------------------------
$Id: rss.php,v 1.4 2005/04/24 04:43:14 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

rss.php - exports public items as RSS
----------------------------------------*/

    header('Content-type: text/xml');

    $SUPPRESS_AUTH = 1;
    ini_set("include_path", join(":", array(ini_get("include_path"), dirname(__FILE__)."/..")));
    require_once('init.php');
    
    $v = (isset($_GET['v']) && !empty($_GET['v']) ? $_GET['v'] : REF_DEFAULT_RSS_VERSION);
    
    $item_selects = ref_load_items(null,
                                   array('where' => array('_clause' => 'UNIX_TIMESTAMP(now()) - UNIX_TIMESTAMP(ist.`timestamp`) <= (24 * 60 * 60)',
                                                          'public' => 1),
                                         'order' => array ('ist.`timestamp`' => 'desc')));

    foreach($item_selects as $is => $item_select)
        $item_selects[$is] = $item_select->arrayify();
    
    $page = new RF_Page(array('template_dir' => 'out/style/templates'));

    $page->assign('item_selects', $item_selects);
    $page->assign('debugging',1);
    $page->assign('feed_title',REF_FEED_TITLE);
    $page->assign('feed_description',REF_FEED_DESCRIPTION);
    $page->assign('feed_url','http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    $page->assign('now', gmmktime());
    
    if($v == 2) {
        $page->display('page-rss2.tpl');
    } else {
        $page->display('page-rss1.tpl');
    }

?>