<?php
/*----------------------------------------
$Id: delete.php,v 1.6 2004/12/09 19:54:51 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

delete.php - deletes a feed and all items
----------------------------------------*/

    require_once('init.php');
    
    $feed = $_GET['feed'];
    
    if(!empty($feed) && $feed) {
        RF_FeedSelect::_delete($feed);
    }
    
if(!empty($_GET['return'])) {
    header("Location: {$_GET['return']}");
}
else {
  Header("Location: " . dirname($_SERVER['PHP_SELF']) . "/");
}
?>
