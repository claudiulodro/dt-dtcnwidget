<?php
/*----------------------------------------
$Id: rss-reblog-0.9.php,v 1.2 2004/12/06 22:57:09 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

rss-reblog-0.9.php - exports public items as RSS
----------------------------------------*/

header('Content-type: text/xml');

$SUPPRESS_AUTH = 1;
ini_set("include_path", join(":", array(ini_get("include_path"), dirname(__FILE__)."/..")));
require_once('init.php');

$v = (isset($_GET['v']) && !empty($_GET['v']) ? $_GET['v'] : REF_DEFAULT_RSS_VERSION);

$item_selects = ref_load_items_from_sql(array( 'where' => array(
							       '_clause' => 'UNIX_TIMESTAMP(now()) - UNIX_TIMESTAMP(timestamp) <= (24 * 60 * 60)',
							       'public' => 1
							       ),
					      'order' => array ('timestamp' => 'desc')
					      ));

$item_selects_arrays = array();

for($i = 0; $i < count($item_selects); $i++) {
  # old-school reBlog 0.9 GUID
  $a = $item_selects[$i]->arrayify();
  $guid = $a['item']['guid'];
  if(strpos($guid, "tag:refeed/") === false) {
    $guid = md5(join("", Array($a['item']['feed']['url'], $a['item']['link'], $a['item']['title'], $a['item']['content'])));
  }
  else {
    $guid = str_replace("tag:refeed/", "", $guid);
  }
  $a['guid'] = $guid;

  $item_selects_arrays[] = $a;


}

$page = new RF_Page(array('template_dir' => 'out/style/templates'));
$page->assign('feed_title',REF_FEED_TITLE);
$page->assign('feed_description',REF_FEED_DESCRIPTION);
$page->assign('feed_url','http://' . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI]);
$page->assign('now', gmmktime());
$page->assign('item_selects', $item_selects_arrays);

$page->display('page-rss1.tpl');


?>