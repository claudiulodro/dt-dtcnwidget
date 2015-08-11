<?php
/*----------------------------------------
$Id: config.php,v 1.27 2005/05/24 20:29:16 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

config.php - modify this file with your database settings
----------------------------------------*/


// Difference, in hours, between your server and your local time zone.

define('REF_TIME_OFFSET', 0);

// are keyboard shortcuts/navigation enabled

define('REF_USE_KEYBOARD', 1);

// Database connection information.  Host, username, password, database name.

define('REF_DB_HOST', "localhost");
define('REF_DB_USER', "root");
define('REF_DB_PASS', "root");
define('REF_DB_DBNAME', "wordpress_default");

// HTTP authentication information. Username, password.

define('REF_HTTPAUTH_NAME', '');
define('REF_HTTPAUTH_PASS', '');

// for the generated RSS/Atom feeds

define('REF_FEED_TITLE', 'My reFeed feed');
define('REF_FEED_DESCRIPTION', 'This is a reFeed feed');
define('REF_GUID_TAG_PREFIX', 'tag:refeed/');

// open new windows when clicking links in the Item View page
define('REF_LINK_NEW_WINDOWS', 1);

// The rest you should not need to change


// How many posts to show by default in paged mode

define('REF_HOWMANY', 50);


// How long to keep posts
// if this is defined, FoF will delete posts after:
// A) they are read
// 2) they were cached more than this number of days ago
// if this is not defined, it will keep them forever.

define('REF_KEEP_DAYS', 30);

// how long to trust your feed caches for, in seconds
define('REF_FEED_CACHE_AGE', 60 * 15);

// DB table names

define('REF_FEED_TABLE', "rf_feeds");
define('REF_ITEM_TABLE', "rf_items");
define('REF_ITEM_SELECT_TABLE', "rf_items_select");
define('REF_FEED_SELECT_TABLE', "rf_feeds_select");

// default RSS to use if not specified
define('REF_DEFAULT_RSS_VERSION', 1.0);

// Magpie should change everything to UTF-8, for foreign-character happiness
define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');

// Our own User Agent
define('REF_HTTP_USER_AGENT', 'reFeed 1.0 (+http://www.reblog.org)');

// How long do session cookies last?
define('REF_SESSION_LIFETIME', 60 * 60 * 24 * 365);

// Find ourselves and the cache dir

if(!defined('DIR_SEP'))
	define('DIR_SEP', DIRECTORY_SEPARATOR);

if(!defined('REF_DIR'))
    define('REF_DIR', dirname(__FILE__) . DIR_SEP);

if(!defined('REF_CACHE_DIR'))
    define('REF_CACHE_DIR', REF_DIR . 'cache');

// Database debugging level.  Leave at 0 unless you know what you're doing.

define('REF_DB_DEBUG_LEVEL', 0);

define('REF_SOURCEFORGE_PROJECT_NEWS_FEED', "http://sourceforge.net/export/rss2_projnews.php?group_id=105823&rss_fulltext=1");

?>
