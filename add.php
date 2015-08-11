<?php
/*----------------------------------------
$Id: add.php,v 1.9 2004/12/06 22:57:09 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

add.php - displays form to add a feed
----------------------------------------*/

    require_once('init.php');

    $url = (empty($_POST['rss_url']) ? $_GET['rss_url'] : $_POST['rss_url']);
    $public = (empty($_POST['public']) ? $_GET['public'] : $_POST['public']);
    $opml = (empty($_POST['opml_url']) ? $_GET['opml_url'] : $_POST['opml_url']);

    $public = (is_null($public) || empty($public) ? null : 1);

    ob_start(); {
    
        if(!empty($url)) {
            RF_FeedSelect::_subscribe($url, $public);
        }
    
        $rss_result_html = ob_get_contents();
        ob_clean();

        if(!empty($opml)) {
            if(!$content_array = file($opml)) {
                echo "Cannot open $opml<br>";
                //return false;
            } else {
                $content = implode("", $content_array);
                $feeds = ref_opml_to_array($content);
                foreach($feeds as $feed) {
                    RF_FeedSelect::_subscribe($feed, $public);
                    echo '<hr size="1">';
                    flush();
                }
            }
        }
    
        $opml_result_html = ob_get_contents();
        ob_clean();

        if($_FILES['opml_file']['tmp_name']) {
            if(!$content_array = file($_FILES['opml_file']['tmp_name'])) {
                echo "Cannot open uploaded file<br>";
                //return false;
            } else {
                $content = implode("", $content_array);
                $feeds = ref_opml_to_array($content);
            
                foreach($feeds as $feed) {
                    RF_FeedSelect::_subscribe($feed, $public);
                    echo '<hr size="1">';
                    flush();
                }

            }
        }
    
        $file_result_html = ob_get_contents();
        ob_clean();

    } ob_end_clean();

    $page = new RF_Page();

    $page->assign('add_script', "{$_SERVER['SCRIPT_NAME']}");
    $page->assign('add_url', "http://{$_SERVER['HTTP_HOST']}{$_SERVER['SCRIPT_NAME']}");
    $page->assign('url', $url);
    $page->assign('public', $public);
    $page->assign('opml', $opml);
    $page->assign('rss_results', $rss_result_html);
    $page->assign('opml_results', $opml_result_html);
    $page->assign('file_results', $file_result_html);

    $page->display('page-addfeed.tpl');

?>
