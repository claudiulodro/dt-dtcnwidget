<?php
/*----------------------------------------
$Id: FeedSelect.class.php,v 1.17 2005/04/20 21:17:50 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

FeedSelect.class.php - RF_FeedSelect is a wrapper class for
user views of feeds
----------------------------------------*/

    require_once("DBObject.class.php");
    require_once("FeedStats.class.php");
    require_once("Feed.class.php");

    class RF_FeedSelect extends RF_DBObject
    {
        var $id = 0;
        var $feed_id = 0;
        var $public = null;
        var $timestamp = 0;

        var $feed = 0;
        var $stats = 0;

        var $db_cols = array("feed_id", "public");
        var $db_table = REF_FEED_SELECT_TABLE;

        function RF_FeedSelect($args) 
        {
            foreach($args as $k => $v) {
                $this->$k = $v;
            }
        }

        function &stats($stats = null)
        {
            if(!(is_null($stats) || empty($stats))) {
                $this->stats = &$stats;
            }
            
            if(empty($this->stats)) {
                $this->stats = & RF_FeedStats::_retrieve($this->feed_id);
            }
            
            return $this->stats;
        }

        function &feed($feed = null)
        {
            if(!(is_null($feed) || empty($feed))) {
                $this->feed = &$feed;
                $this->feed_id = $feed->id;
            }
            
            if(empty($this->feed)) {
                $this->feed = & RF_Feed::_retrieve($this->feed_id);
            }
            
            return $this->feed;
        }

        function _retrieve($args)
        {
            if(!is_array($args)) {
                $args = array('where' =>array('id' =>$args));
            }
            $res = RF_FeedSelect::_retrieve_all($args);

            return (is_array($res) && count($res) > 0 ? $res[0] : 0);
        }

        function _retrieve_all($args) 
        {
            $result = ref_do_query(sprintf("SELECT fst.*, fst.timestamp as db_timestamp, UNIX_TIMESTAMP(fst.timestamp) as timestamp
                                            FROM %s AS fst
                                            INNER JOIN %s AS ft
                                              ON fst.feed_id = ft.id
                                            %s            
                                            %s %s",
                                            
                                            REF_FEED_SELECT_TABLE,
                                            REF_FEED_TABLE,
                                            RF_DBObject::_where_clause($args['where'], "fst"),
                                            RF_DBObject::_order_clause($args['order']),
                                            RF_DBObject::_limit_clause($args['limit'])
                                            ));
            
            $feeds = array();
            
            while($feed = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                $feeds[] = & new RF_FeedSelect($feed);
            }
            
            return $feeds;
        }

        function arrayify($cols = null)
        {
            $feed = & $this->feed();
            $stats = & $this->stats();
            
            $fs = RF_DBObject::arrayify($cols);
            $fs['feed'] = $feed->arrayify();
            $fs['stats'] = $stats->arrayify();
            
            return $fs;
        }	

        function _subscribe($url, $public = null)
        {
            if(!$url) return;
        
            $url = trim($url);
        
            if(substr($url, 0, 7) != 'http://')
            {
              $url = 'http://' . $url;
            }
        
            print "Attempting to subscribe to <a href=\"$url\">$url</a>...<br>";
        
            if($feed = ref_is_subscribed($url))
            {
                print "You are already subscribed to " .  RF_Page::render_feed_link($feed)  . "<br><br>";
                return true;
            }
        
            $rss = fetch_rss( $url );
            
            if(!$rss->channel && !$rss->items)
            {
                echo "&nbsp;&nbsp;<font color=\"darkgoldenrod\">URL is not RSS or is invalid.</font><br>";
                if(!$rss) echo "&nbsp;&nbsp;(error was: <B>" . magpie_error() . "</b>)<br>";
              echo "&nbsp;&nbsp;<a href=\"http://feeds.archive.org/validator/check?url=$url\">The validator may give more information.</a><br>";
        
                echo "<br>Attempting autodiscovery...<br><br>";
        
                $r = _fetch_remote_file ($url);
                $c = $r->results;
        
                if($c && $r->status >= 200 && $r->status < 300)
                {
                    $l = ref_getRSSLocation($c, $url);
                    if($l)
                    {
                        echo "Autodiscovery found <a href=\"$l\">$l</a>.<br>";
        
                        echo "Attempting to subscribe to <a href=\"$l\">$l</a>...<br>";
        
                        if($feed = ref_is_subscribed($l))
                        {
                            print "<br>You are already subscribed to " . RF_Page::render_feed_link($feed) . "<br>";
                            return true;
                        }
        
                        $rss = fetch_rss( $l );
        
                        if(!$rss->channel && !$rss->items)
                        {
                            echo "&nbsp;&nbsp;<font color=\"red\">URL is not RSS, giving up.</font><br>";
                            echo "&nbsp;&nbsp;(error was: <B>" . magpie_error() . "</b>)<br>";
                            echo "&nbsp;&nbsp;<a href=\"http://feeds.archive.org/validator/check?url=$l\">The validator may give more information.</a><br>";
        
                        }
                        else
                        {
                          $url = $l;
                        }
                    }
                    else
                    {
                        echo "<font color=\"red\"><b>Autodiscovery failed.  Giving up.</b></font><br>";
                    }
                }
                else
                {
                    echo "<font color=\"red\"><b>Can't load URL.  Giving up.</b></font><br>";
                }
            }
        
        
            if($rss->channel && $rss->items) {
                $feed = new RF_Feed(array('url' => $url,
                                          'title' => $rss->channel['title'],				  
                                          'link' => $rss->channel['link'],
                                          'description' => $rss->channel['description']));
                $feed->save();
            
                $feed_select = new RF_FeedSelect(array('feed_id' => $feed->id));
                $feed_select->public = $public;
                $feed_select->save();
                
                $feed->update($rss);
                echo "<font color=\"green\"><b>Subscribed.</b></font><br>";
            }
        }

        function _mark_public($feed_select, $public)
        {
            if(!empty($feed_select) && is_numeric($feed_select)) {
                $feed_select = & RF_FeedSelect::_retrieve($feed_select);
                if($feed_select) {
                    $feed_select->public = $public ? 1 : null;
                    $feed_select->save();
                }
            }
        }

        function _delete($feed) 
        {
            if(!empty($feed) && is_numeric($feed)) {
                ref_do_query(sprintf("delete from %s where id = %s",
                    REF_FEED_TABLE,$feed));
                ref_do_query(sprintf("delete from %s where feed_id = %s",
                    REF_FEED_SELECT_TABLE, $feed));
                ref_do_query(sprintf("delete from %s where feed_id = %s",
                    REF_ITEM_TABLE, $feed));
                ref_do_query(sprintf("delete from %s where feed_id = %s",
                    REF_ITEM_SELECT_TABLE, $feed));
            }
        }

    }

?>
