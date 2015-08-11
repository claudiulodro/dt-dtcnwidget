<?php
/*----------------------------------------
$Id: init.php,v 1.38 2005/04/19 21:24:47 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright 2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

init.php - initializes Refeed, and contains functions used from other scripts
----------------------------------------*/

    require_once('config.php');
    require_once('library/RF/Page.class.php');
    require_once('library/RF/Item.class.php');
    require_once('library/RF/ItemSelect.class.php');
    require_once('library/RF/Feed.class.php');
    require_once('library/RF/FeedSelect.class.php');
    require_once('library/RF/FeedStats.class.php');
    require_once('library/RF/install.functions.php');
    require_once('util.php');
    
    require_once('session.php');

// {{{1 password setup

    if(empty($SUPPRESS_AUTH) && REF_HTTPAUTH_NAME && REF_HTTPAUTH_PASS) {
        if(($_SERVER['PHP_AUTH_USER'] !== REF_HTTPAUTH_NAME) || ($_SERVER['PHP_AUTH_PW'] !== REF_HTTPAUTH_PASS)) {
            header($_SERVER['SERVER_PROTOCOL'].' 401');
            header('WWW-Authenticate: Basic realm="For your eyes only."');
            exit;
        }
    }

// {{{1 magpie rss setup

    define('MAGPIE_CACHE_AGE', REF_FEED_CACHE_AGE);
    define('MAGPIE_USER_AGENT', REF_HTTP_USER_AGENT);
    define('MAGPIE_CACHE_DIR', REF_CACHE_DIR);
    // Turn GZip on in Magpie
    define('MAGPIE_USE_GZIP', true);



    // surpress magpie's warnings, we'll handle those ourselves
    error_reporting(E_ERROR);
    
    require_once('library/magpierss/rss_fetch.inc');
    require_once('library/magpierss/rss_utils.inc');
    
    $ref_rss_cache = new RSSCache(MAGPIE_CACHE_DIR, MAGPIE_CACHE_AGE);

// {{{1 pear db library setup

    ini_set("include_path", join(":", array(dirname(__FILE__)."/library/PEAR",    ini_get("include_path"))));
    ini_set("include_path", join(":", array(dirname(__FILE__)."/library/PEAR/DB", ini_get("include_path"))));
    require_once("DB.php");

    $ref_dsn = sprintf('mysql://%s:%s@%s/%s', REF_DB_USER, REF_DB_PASS, REF_DB_HOST, REF_DB_DBNAME);

    $REF_DBH = & DB::connect($ref_dsn, array('debug' => REF_DB_DEBUG_LEVEL, 'portability' => DB_PORTABILITY_NONE));

    if(DB::isError($REF_DBH)) {
        die($REF_DBH->getMessage() . ":" . $REF_DBH->getDebugInfo());
    }

// {{{1 check installation

    if(empty($installing) && empty($SUPPRESS_INSTALL_VERIFY) && !is_installed()) {
        exit("I can't find a cache directory, or a current database. Have you tried <a href=\"install.php\">installing Refeed</a>?");
    }

?>
