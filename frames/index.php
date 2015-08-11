<?php
/*----------------------------------------
$Id: index.php,v 1.7 2004/12/09 19:54:51 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

index.php - frameset for framesview
----------------------------------------*/

// Is this a dirty hack?
    ini_set("include_path", join(":", array(ini_get("include_path"), dirname(__FILE__)."/..")));

    require_once('init.php');

    $page = new RF_Page();

    $args = $page->view_args($_GET);

    $page->assign('args', $args);
    $page->display('frameset.tpl');

?>
