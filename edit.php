<?php
/*----------------------------------------
$Id: edit.php,v 1.12 2004/12/06 22:57:09 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

edit.php - edit one post
----------------------------------------*/

    require_once('init.php');

    if(empty($_GET['id'])) {
        $FORM = $_POST;

        // "Magic Quotes" is a terrible, terrible feature to have enabled by default.
        if(get_magic_quotes_gpc()) {
            foreach($FORM as $var => $value) {
                if(is_string($value)) {
                    $FORM[$var] = stripslashes($value);
                }
            }
        }
    }

if(!empty($FORM['action']) && !empty($FORM['id']) && is_numeric($FORM['id'])) {
  $item_select = & RF_ItemSelect::_retrieve($FORM['id']);
  $item =& $item_select->item();

  if($item_select) {
    $action = $FORM['action'];
    if($action == "Revert") {
      $item_select->title = "";
      $item_select->link = "";
      $item_select->content = "";
      $item_select->comment = "";
      $item_select->subjects = "";
    }
    else {
      $item_select->title = $FORM['title'];
      $item_select->content = $FORM['content'];
      $item_select->comment = $FORM['comment'];
      $item_select->subjects = $FORM['subjects'];
      if(empty($FORM['link_select'])) {
	$item_select->link = $FORM['link'];
      }
      else {
	$item_select->link = $FORM['link_select'];
      }

      // Don't repeat content
      $compare_cols = array("title", "content", "link");
      foreach($compare_cols as $c) {
	if(!is_null($item_select->$c)) {
	  if(strcmp($item_select->$c, $item->$c) == 0) {
	    $item_select->$c = null;
	  }
	}
      }

      if($action == "Publish") {
	$item_select->public = 1;
      }
      if($action == "Revoke") {
	$item_select->public = null;
      }

    }

    $item_select->save();

    if($action == "Publish" || $action == "Return to Feed") {
      header("Location: " . $FORM['return']);
      exit;
    }

  }
}

if(!isset($FORM)) {
  $FORM = $_GET;
}

    
    $page = new RF_Page();

    $item_select = & RF_ItemSelect::_retrieve($FORM['id']);

    $i_s_a = $item_select->arrayify();

    $page->assign('return', $FORM['return']);
    $page->assign('item_select', $i_s_a);

    $page->display('page-edit.tpl');

?>

