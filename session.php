<?php
/*----------------------------------------
$Id: session.php,v 1.5 2005/06/02 19:06:04 migurski Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright 2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

session.php -- any and all session handling nonsense
----------------------------------------*/


if(!defined('REF_SESSION_LIFETIME')) {
    define('REF_SESSION_LIFETIME', 60 * 60 * 24 * 365);
}

$session_path = dirname($_SERVER['SCRIPT_NAME']);

for($current_path = dirname($_SERVER['SCRIPT_FILENAME']);
    $current_path != '/' && strtolower($current_path) != strtolower(dirname(__FILE__));
    $current_path = dirname($current_path)) {

    $session_path = dirname($session_path);
}

session_name('ReBlogSessionID');
session_save_path(REF_CACHE_DIR);
session_set_cookie_params(REF_SESSION_LIFETIME, $session_path);
session_start();

if(isset($_GET['search'])) {
    $_SESSION['search'] = $_GET['search'];
} elseif(isset($_POST['search'])) {
    $_SESSION['search'] = $_POST['search'];
}

if(isset($_GET['feed_sort'])) {
    $_SESSION['feed_sort'] = $_GET['feed_sort'];
} elseif(isset($_POST['feed_sort'])) {
    $_SESSION['feed_sort'] = $_POST['feed_sort'];
}

if(!isset($_SESSION['use_kb'])) {
    $_SESSION['use_kb'] = (defined('REF_USE_KEYBOARD') ? REF_USE_KEYBOARD : 0);
}

?>