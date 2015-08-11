<?php
/*----------------------------------------
$Id: install.php,v 1.23 2005/05/31 04:45:46 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

install.php - creates tables and cache directory, if they don't exist
----------------------------------------*/
?>
<?php
        $INSTALLING = true;
        $SUPPRESS_INSTALL_VERIFY = true;
        require_once('init.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>reFeed: installation</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="style/font.css" media="screen" />
    <link rel="stylesheet" href="style/layout.css" media="screen" />
    <link rel="stylesheet" href="style/color.css" media="screen" />
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
</head>
<body id="panel-page">
    <p>Installing Refeed...</p>
    <?php
        
        if(is_cache_writeable()) {
            print_note("Your cache directory exists, and is writeable.");
            
        } else {
            trigger_error("Your cache directory does not exist, or is not writeable.", INSTALL_FATAL);
        
        }
    
        if(is_feedonfeeds()) {
            print_mumble("You seem to have Feed On Feeds installed.");
            
            if(do_upgrade_from_feedonfeeds())
                print_note("Upgraded your Feed On Feeds database.");
        
        } elseif(is_recess()) {
            print_mumble("You seem to have ReceSS installed.");
            
            if(do_upgrade_from_recess())
                print_note("Upgraded your ReceSS database.");
        
        } elseif(is_refeed()) {
            print_note("You already have a complete Refeed database, silly goose.");
        
        } elseif(do_create_tables()) {
            print_note("Installed your Refeed Tables.");        
        }


        if(defined('REF_SOURCEFORGE_PROJECT_NEWS_FEED')) {
            RF_FeedSelect::_subscribe(REF_SOURCEFORGE_PROJECT_NEWS_FEED, 0);
        }

        
    ?>
    <p>If you got this far, Refeed was successfully installed.</p>
    <p>Head over the <a href="index.php">front page</a> and start <a href="add.php">adding some feeds</a>.</a>
</body>
</html>