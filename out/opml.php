<?php
/*----------------------------------------
$Id: opml.php,v 1.2 2004/12/06 22:57:09 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

ompl.php - exports subscription list as OPML
----------------------------------------*/

    header("Content-Type: text/xml");

    $SUPPRESS_AUTH = 1;
    ini_set("include_path", join(":", array(ini_get("include_path"), dirname(__FILE__)."/..")));
    require_once('init.php');
    
    $feed_selects = ref_load_feeds();

    foreach($feed_selects as $fs => $feed_select)
        $feed_selects[$fs] = $feed_select->arrayify();

    $page = new RF_Page(array('template_dir' => 'out/style/templates'));

    $page->assign('feed_selects', $feed_selects);

    $page->display('opml.tpl');

?>