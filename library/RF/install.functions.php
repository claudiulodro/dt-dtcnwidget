<?php
/*----------------------------------------
$Id: install.functions.php,v 1.14 2005/04/19 21:24:47 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

install.functions.php - functions used to check installation status and
perform database installation actions.
----------------------------------------*/

    define('INSTALL_FATAL', E_USER_ERROR);
    define('INSTALL_WARN', E_USER_WARNING);

    function install_error($errno, $errstr, $file, $line)
    {
        switch($errno) {
            case INSTALL_FATAL:
                print_freakout($errstr);
                exit();
                break;

            case INSTALL_WARN:
                print_note($errstr);
                break;
                
            default:
                //print_mumble($errstr);
                break;
        }
    }
    
    if(false) {
        error_reporting(INSTALL_FATAL|INSTALL_WARN);
        set_error_handler('install_error');
    }
    
    function print_note($string) { printf('<p>%s</p>', htmlspecialchars($string)); }
    function print_freakout($string) { printf('<p style="color: red; font-weight: bold;">%s</p>', htmlspecialchars($string)); }
    function print_mumble($string) { printf('<p style="color: gray;">%s</p>', htmlspecialchars($string)); }

    function is_installed() { return (is_cache_writeable() && is_refeed()); }

    function is_cache_writeable()
    {
        $cache = REF_CACHE_DIR;

        if(!file_exists($cache)) {
            $status = @mkdir($cache, 0755 );

            if(!$status) {
                //print_freakout("Can't create directory {$cache}. You will need to create it yourself, and make it writeable by your PHP process. Then, reload this page.");
                return false;
            }
        }
        
        if(!is_writable($cache)) {
            //print_freakout("The directory {$cache} exists, but is not writable. You will need to make it writeable by your PHP process. Then, reload this page.");
            return false;
        }
            
        return true;
    }

    function describe_table($table_name)
    {
        $res = ref_do_query("SHOW TABLES LIKE '{$table_name}'", null, 1);
        
        $columns = array();

        if($res->numRows()) {
            $res = ref_do_query("SHOW COLUMNS FROM `{$table_name}`", null, 1);
    
            while($res->fetchInto($col, DB_FETCHMODE_ASSOC))
                $columns[$col['Field']] = strtolower(preg_replace('#\(\d+\)#', '', $col['Type']));
        }

        return $columns;
    }
    
    function is_refeed()
    {
        $refeed_item_table = array(
            'id' => 'int',
            'feed_id' => 'int',
            'guid' => 'varchar',
            'timestamp' => 'timestamp',
            'link' => 'text',
            'title' => 'text',
            'content' => 'text',
            'dcdate' => 'varchar',
            'dccreator' => 'varchar',
            'dcsubject' => 'varchar',
            'xml' => 'text'
        );
        
        $refeed_feed_table = array(
            'id' => 'int',
            'url' => 'text',
            'title' => 'varchar',
            'link' => 'varchar',
            'description' => 'varchar',
            'xml' => 'text',
            'timestamp' => 'timestamp'
        );

        $refeed_item_select_table = array(
            'id' => 'int',
            'item_id' => 'int',
            'feed_id' => 'int',
            'read' => 'tinyint',
            'public' => 'tinyint',
            'link' => 'text',
            'title' => 'text',
            'content' => 'text',
            'comment' => 'text',
            'subjects' => 'varchar',
            'timestamp' => 'timestamp'
        );
        
        $refeed_feed_select_table = array(
            'id' => 'int',
            'feed_id' => 'int',
            'public' => 'tinyint',
            'timestamp' => 'timestamp'
        );
        
        return ((describe_table(REF_ITEM_TABLE) == $refeed_item_table)
             && (describe_table(REF_FEED_TABLE) == $refeed_feed_table)
             && (describe_table(REF_ITEM_SELECT_TABLE) == $refeed_item_select_table)
             && (describe_table(REF_FEED_SELECT_TABLE) == $refeed_feed_select_table));
    }
    
    function is_recess()
    {
        $recess_item_table = array(
            'id' => 'int',
            'feed_id' => 'int',
            'timestamp' => 'timestamp',
            'link' => 'text',
            'title' => 'varchar',
            'content' => 'text',
            'dcdate' => 'text',
            'dccreator' => 'text',
            'dcsubject' => 'text',
            'read' => 'tinyint',
            'dcidentifier' => 'varchar',
            'reblog_link' => 'text'
        );
        
        $recess_feed_table = array(
            'id' => 'int',
            'url' => 'varchar',
            'title' => 'varchar',
            'link' => 'varchar',
            'description' => 'varchar'
        );
    
        return ((describe_table(REF_ITEM_TABLE) == $recess_item_table)
             && (describe_table(REF_FEED_TABLE) == $recess_feed_table));
    }
    
    function is_feedonfeeds()
    {
        $fof_item_table = array(
            'id' => 'int',
            'feed_id' => 'int',
            'timestamp' => 'timestamp',
            'link' => 'text',
            'title' => 'varchar',
            'content' => 'text',
            'dcdate' => 'text',
            'dccreator' => 'text',
            'dcsubject' => 'text',
            'read' => 'tinyint'
        );
        
        $fof_feed_table = array(
            'id' => 'int',
            'url' => 'varchar',
            'title' => 'varchar',
            'link' => 'varchar',
            'description' => 'varchar'
        );
        
        return ((describe_table(REF_ITEM_TABLE) == $fof_item_table)
             && (describe_table(REF_FEED_TABLE) == $fof_feed_table));
    }

    function do_upgrade_from_recess() 
    {
        print_note("Upgrading your database from ReceSS.");

        $temp_item_table = REF_ITEM_TABLE . "__TMP";
        $query1 = sprintf('ALTER TABLE %s RENAME TO %s',
                           REF_ITEM_TABLE,
                           $temp_item_table);
        
        $temp_feed_table = REF_FEED_TABLE . "__TMP";
        $query2 = sprintf('ALTER TABLE %s RENAME TO %s',
                           REF_FEED_TABLE,
                           $temp_feed_table);

        if(!(ref_do_query($query1, null, 1) && ref_do_query($query2, null, 1)))
            trigger_error("Can't rename tables.  MySQL says: " . mysql_error(), INSTALL_FATAL);
        
        do_create_tables();
        
        ref_do_query(sprintf('INSERT INTO %s
                                  (id, url, title, link, description)
                                  SELECT id, url, title, link, description
                                      FROM %s',
                              REF_FEED_TABLE,
                              $temp_feed_table));
        
        ref_do_query(sprintf('INSERT INTO %s 
                                  (id, feed_id, public)
                                  SELECT id, id, NULL
                                      FROM %s',
                              REF_FEED_SELECT_TABLE,
                              REF_FEED_TABLE));
        
        ref_do_query(sprintf('INSERT INTO %s
                                  (id, feed_id, guid, `timestamp`, link, title, content, dcdate, dccreator, dcsubject)
                                  SELECT id, feed_id, CONCAT("%s", dcidentifier), `timestamp`, link, title, content, dcdate, dccreator, dcsubject
                                      FROM %s',
                              REF_ITEM_TABLE,
                              REF_GUID_TAG_PREFIX,
                              $temp_item_table));
        
        
        ref_do_query(sprintf('INSERT INTO %s
                                  (id, item_id, feed_id, `read`, public, link, title, content, `timestamp`)
                                  SELECT id, id, feed_id, IF(`read` is NULL, NULL, 1), IF(`read` is NULL or `read` = 1, NULL, 1), IF(link = reblog_link, NULL, reblog_link), NULL, NULL, `timestamp`
                                      FROM %s',
                              REF_ITEM_SELECT_TABLE,
                              $temp_item_table));
        
        $query1 = sprintf('DROP TABLE %s', $temp_feed_table);
        $query2 = sprintf('DROP TABLE %s', $temp_item_table);

        if(!(ref_do_query($query1, null, 1) && ref_do_query($query2, null, 1)))
            trigger_error("Can't drop tables.  MySQL says: " . mysql_error(), INSTALL_WARN);
        
        return true;
    }

    function do_upgrade_from_feedonfeeds() 
    {
        print_note("Upgrading database from Feed On Feeds.");

        $temp_item_table = REF_ITEM_TABLE . "__TMP";
        $query1 = sprintf('ALTER TABLE %s RENAME TO %s',
                           REF_ITEM_TABLE,
                           $temp_item_table);
        
        $temp_feed_table = REF_FEED_TABLE . "__TMP";
        $query2 = sprintf('ALTER TABLE %s RENAME TO %s',
                           REF_FEED_TABLE,
                           $temp_feed_table);

        if(!(ref_do_query($query1, null, 1) && ref_do_query($query2, null, 1)))
            trigger_error("Can't rename tables.  MySQL says: " . mysql_error(), INSTALL_FATAL);
        
        do_create_tables();
        
        ref_do_query(sprintf('INSERT INTO %s
                                  (id, url, title, link, description)
                                  SELECT id, url, title, link, description
                                      FROM %s',
                              REF_FEED_TABLE,
                              $temp_feed_table));
        
        ref_do_query(sprintf('INSERT INTO %s 
                                  (id, feed_id, public)
                                  SELECT id, id, NULL
                                      FROM %s',
                              REF_FEED_SELECT_TABLE,
                              REF_FEED_TABLE));
        
        ref_do_query(sprintf('INSERT INTO %s
                                  (id, feed_id, guid, `timestamp`, link, title, content, dcdate, dccreator, dcsubject)
                                  SELECT i.id, i.feed_id, CONCAT("%s", MD5(CONCAT(f.url,i.link,i.title,i.content))), i.`timestamp`, i.link, i.title, i.content, i.dcdate, i.dccreator, i.dcsubject
                                      FROM %s i
                                      INNER JOIN %s f
                                      ON i.feed_id = f.id',
                              REF_ITEM_TABLE,
                              REF_GUID_TAG_PREFIX,
                              $temp_item_table,
                              REF_FEED_TABLE));
        
        
        ref_do_query(sprintf('INSERT INTO %s
                                  (id, item_id, feed_id, `read`, public, link, title, content, `timestamp`)
                                  SELECT id, id, feed_id, IF(`read` is NULL, NULL, 1), IF(`read` is NULL or `read` = 1, NULL, 1), NULL, NULL, NULL, `timestamp`
                                      FROM %s',
                              REF_ITEM_SELECT_TABLE,
                              $temp_item_table));
        
        $query1 = sprintf('DROP TABLE %s', $temp_feed_table);
        $query2 = sprintf('DROP TABLE %s', $temp_item_table);

        if(!(ref_do_query($query1, null, 1) && ref_do_query($query2, null, 1)))
            trigger_error("Can't drop tables.  MySQL says: " . mysql_error(), INSTALL_WARN);
        
        return true;
    }

    function do_create_tables()
    {
        print_mumble("Creating table ".REF_FEED_TABLE.".");

        $query = sprintf("
            CREATE TABLE %s (
              id                INT(11) NOT NULL AUTO_INCREMENT,
              url               TEXT NOT NULL DEFAULT '',
              title             VARCHAR(255) NOT NULL DEFAULT '',
              link              VARCHAR(255) DEFAULT NULL,
              description       VARCHAR(255) DEFAULT NULL,
              xml               TEXT DEFAULT NULL,
              `timestamp`       TIMESTAMP NOT NULL,
        
              PRIMARY KEY (id),
              FULLTEXT(url, title, link, description)
            ) ENGINE=MyISAM",
            REF_FEED_TABLE);
            
        if(!ref_do_query($query, null, 1) && mysql_errno() != 1050)
            trigger_error("Can't create table.  MySQL says: " . mysql_error(), INSTALL_FATAL);
            
        print_mumble("Creating table ".REF_FEED_SELECT_TABLE.".");

        $query = sprintf("
            CREATE TABLE %s (
              id                INT(11) NOT NULL AUTO_INCREMENT,
              feed_id           INT(11) NOT NULL DEFAULT 0,
              public            TINYINT(4) DEFAULT NULL,
              `timestamp`       TIMESTAMP NOT NULL,
        
              PRIMARY KEY (id),
              UNIQUE KEY feed_id (feed_id)
            ) ENGINE=MyISAM",
            REF_FEED_SELECT_TABLE);
        
        if(!ref_do_query($query, null, 1) && mysql_errno() != 1050)
            trigger_error("Can't create table.  MySQL says: " . mysql_error(), INSTALL_FATAL);
            
        print_mumble("Creating table ".REF_ITEM_TABLE.".");

        $query = sprintf("
            CREATE TABLE %s (
              id                INT(11) NOT NULL AUTO_INCREMENT,
              feed_id           INT(11) NOT NULL DEFAULT 0,
              guid              VARCHAR(255) NOT NULL DEFAULT '',
              `timestamp`       TIMESTAMP NOT NULL,
              link              TEXT,
              title             TEXT,
              content           TEXT,
              dcdate            VARCHAR(255) DEFAULT NULL,
              dccreator         VARCHAR(255) DEFAULT NULL,
              dcsubject         VARCHAR(255) DEFAULT NULL,
              xml               TEXT,
        
              PRIMARY KEY (id),
              UNIQUE KEY feed_id_guid (feed_id, guid),
              FULLTEXT(link, title, content, dccreator, dcsubject)
            ) ENGINE=MyISAM",
            REF_ITEM_TABLE);

        if(!ref_do_query($query, null, 1) && mysql_errno() != 1050)
            trigger_error("Can't create table.  MySQL says: " . mysql_error(), INSTALL_FATAL);

        print_mumble("Creating table ".REF_ITEM_SELECT_TABLE.".");

        $query = sprintf("
            CREATE TABLE %s (
              id                INT(11) NOT NULL AUTO_INCREMENT,
              item_id           INT(11) NOT NULL DEFAULT 0,
              feed_id           INT(11) NOT NULL DEFAULT 0,
              `read`            TINYINT(4) DEFAULT NULL,
              public            TINYINT(4) DEFAULT NULL,
              link              TEXT,
              title             TEXT,
              content           TEXT,
              `comment`         TEXT,
              subjects          VARCHAR(255) DEFAULT NULL,
              `timestamp`       TIMESTAMP NOT NULL,
        
              PRIMARY KEY (id),
              UNIQUE KEY item_id (item_id),
              KEY feed_id (feed_id),
              FULLTEXT(link, title, content, `comment`, subjects)
            ) ENGINE=MyISAM",
            REF_ITEM_SELECT_TABLE);
        
        if(!ref_do_query($query, null, 1) && mysql_errno() != 1050)
            trigger_error("Can't create table.  MySQL says: " . mysql_error(), INSTALL_FATAL);
            
        return true;
    }

?>
