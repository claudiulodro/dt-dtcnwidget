<?php
/*----------------------------------------
$Id: update.php,v 1.11 2004/12/06 22:57:09 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

update.php - updates all feeds with feedback
----------------------------------------*/

    $SUPPRESS_AUTH = 1;
    require_once('init.php');

    $feed = $_GET['feed'];

    $sql = array('order' => 'title');

    $nocache = null;
    if($feed) {
      $sql['where'] = array('id' => $feed);
      $nocache = 1;
    }

    $feeds = RF_Feed::_retrieve_all($sql);
    
    $results = array();

    foreach($feeds as $f => $feed) {
    
        $counts = $feeds[$f]->update(null, $nocache);
    
        $result = array('title'     => $feed->title,
                        'updated'   => true,
                        'new_items' => sprintf('%d', $counts['new']),
			'del_items' => sprintf('%d', $counts['del']),
			'err'       => $counts['err']
			);
                        
        $results[] = $result;
    }
    
    $page = new RF_Page();
    $page->assign('results', $results);
    $page->display('page-update.tpl');

?>
