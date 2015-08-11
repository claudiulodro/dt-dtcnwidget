<?php
/*----------------------------------------
$Id: preview.php,v 1.7 2004/12/06 22:57:09 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

preview.php - preview one post
----------------------------------------*/

    require_once('init.php');
    
    $page = new RF_Page();

    $item_select =  & RF_ItemSelect::_retrieve($_GET['id']);
    $i_s_a = $item_select->arrayify();

    $page->assign('item_select', $i_s_a);

    $page->display('page-preview.tpl');

?>

