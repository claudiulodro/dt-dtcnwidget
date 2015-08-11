<?php
/*----------------------------------------

$Id: Feed.class.php,v 1.24 2005/06/30 16:38:31 mfrumin Exp $

vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

Feed.class.php - RF_Feed is a wrapper class for feeds
----------------------------------------*/

    require_once("DBObject.class.php");

    class RF_Feed extends RF_DBObject
    {
        var $id = 0;
        var $url = '';
        var $title = '';
        var $link = null;
        var $description = null;
        var $timestamp = 0;
        var $xml = null;
    
        var $db_cols = array("url", "title", "link", "description", "xml");
        var $db_table = REF_FEED_TABLE;
    
        function RF_Feed($args) 
        {
            foreach($args as $k => $v) {
                $this->$k = $v;
            }
        }

        function _retrieve($args)
        {	  
            if(!is_array($args)) {
                $args = array('where' => array('id' => $args));
            }
            
            $res = RF_Feed::_retrieve_all($args);
            return (is_array($res) && count($res) > 0 ? $res[0] : 0);
        }


        function _retrieve_all($args) 
        {
            $result = ref_do_query(sprintf("SELECT ft.*, ft.timestamp as db_timestamp, UNIX_TIMESTAMP(ft.timestamp) as timestamp
                                            FROM %s AS ft            
                                            %s
                                            %s %s",					   
                                            REF_FEED_TABLE,
                                            RF_DBObject::_where_clause($args['where'], "ft"),
                                            RF_DBObject::_order_clause($args['order']),
                                            RF_DBObject::_limit_clause($args['limit'])));
    
            $feeds = array();
        
            while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
	            $feeds[] = & new RF_Feed($row);
            }

            return $feeds;
        }

        function update($rss=null, $nocache=null)
        {
            $url = $this->url;
            
            if(is_null($rss)) {
                $prev_mco = MAGPIE_CACHE_ON;
                if(!(is_null($nocache) || empty($nocache))) {
                    define('MAGPIE_CACHE_ON', 0);
                }
                $rss = fetch_rss( $url );
                define('MAGPIE_CACHE_ON', $prev_mco);
            }
        
            if(!$rss) {
                return array('new' => 0,
                             'del' => $this->purge(),
                             'err' => sprintf('Error: <b>%s</b> <a href="http://feeds.archive.org/validator/check?url=%s">try to validate it?</a>', magpie_error(), $url));
            }
        
            $feed_id = $this->id;
            
            $items = $rss->items;
            
            $feed_select = & RF_FeedSelect::_retrieve(array('where' => array('feed_id' => $this->id)));
            
            $is_public_feed = $feed_select->public;
            
            $update_ids = array();
            
            foreach ($items as $item) {
                $link = $item['link'];
                $title = $item['title'];
                $content = $item['description'];
                
                if($item['content']['encoded']) {
                    $content = $item['content']['encoded'];
                }
            
                /* magpierss makes [content][encoded]==[atom_content]
                if($item['atom_content'])
                {
                    $content = $item['atom_content'];
                }
                */
                
                // it is back, for the distribution
                $content = RF_Page::balance_tags($content);
                
                $dcdate = '';
                $dccreator = '';
                $dcsubject = '';
                $guid = '';
                
                if(isset($item['dc']) && is_array($item['dc'])) {
                    $dc = $item['dc'];
                    $dcdate = (isset($dc['date']) ? $dc['date'] : $dcdate);	      
                    $dccreator = (isset($dc['creator']) ? $dc['creator'] : $dccreator);
                    $dcsubject = (isset($dc['subject']) ? $dc['subject'] : $dcsubject);
                    $guid = (isset($dc['identifier']) ? $dc['identifier'] : $guid);
                }
                
                if(empty($dcdate) && isset($item['pubdate'])) {
                    $dcdate = ref_rfc8222unix_timestamp($item['pubdate']);
                    if(!empty($dcdate)) {
                        $dcdate = ref_unix_timestamp2iso8601($dcdate);
                    }
                }
                
                if(empty($dcdate) && isset($item['issued'])) {
                    $dcdate = $item['issued'];
                }
                
                if(isset($item['guid']) && !empty($item['guid'])) {
                    if(!$link) {
                        $link = $item['guid'];
                    }
                    if(!$guid) {
                        $guid = $item['guid'];
                    }
                }
                
                if(!$guid && isset($item['id']) && !empty($item['id'])) {
                    $guid = $item['id'];
                }
                
                if(!$title) {
                    $title = "[no title]";
                }
                
                if(empty($guid)) {
                    $guid = REF_GUID_TAG_PREFIX . md5(join("", Array($url, $link, $title, $content)));
                }

                # null for link != ''
                $item = RF_Item::_retrieve(array('where' => array('feed_id' => $feed_id, 'guid' => $guid)));
                
                $item_array = array('feed_id' => $feed_id,
                                    'guid' => $guid,
                                    'link' => $link,
                                    'title' => $title,
                                    'content' => $content,
                                    'dcdate' => $dcdate,
                                    'dccreator' => $dccreator,
                                    'dcsubject' => $dcsubject);
                
                
                if(!$item) {	      
                    $item = new RF_Item($item_array);
                    
                    // this item is being encountered for the first time, so plug-in support for a new fetch goes *here*
                    
                    $item->save();
                    
                    $n++;
                    
                    $item_select = new RF_ItemSelect(array('item_id' => $item->id,
                                                           'feed_id' => $feed_id,
                                                           'public' => ($is_public_feed ? " 1 " : null)));
                    
                    $item_select->save();
                    
                    #MARK ALL THE PREVIOUS VERSIONS (BY LINK) AS READ -- CONVENIENCE
                    
                    $prev_items = RF_Item::_retrieve_all(array('where' => array('feed_id' => $item->feed_id, 'link' => $item->link)));
                    $prev_ids = array();
                    for($i = 0; $i < count($prev_items); $i++) {
                        $prev_id = $prev_items[$i]->id;
                        #			  print "PREV ID $i: $prev_id =? {$item->id}<BR>\n";
                        if($prev_id != $item->id) {
                            $prev_ids[] = $prev_id;
                        }
                    }
                    
                    RF_ItemSelect::_mark_all_read(true, null, $prev_ids, true);
                } else {
                    $check_fields = array('link', 'title', 'content');
                    $nDiff = 0;
                    foreach($check_fields as $f) {
                        if(strcmp(trim($item->$f), trim($item_array[$f])) != 0) {
                            $item->$f = $item_array[$f];
                            $nDiff++;
                        }
                    }
                    
                    if($nDiff > 0) {
                        $item->save();
                        $n++;
                        $update_ids[] = $item->id;
                    }
                    
                    $ids[] = $item->id;
                }
                
            }

            $update_ids = RF_ItemSelect::_get_ids_from_item_ids($update_ids);
            
            $update_ids = RF_ItemSelect::_get_ids_from_item_ids($update_ids);

            // mark the items that were updated as unread
            RF_ItemSelect::_mark_all_read(null, null, $update_ids, false);
            
            return array('new' => $n,
                         'del' => $this->purge($ids),
                         'err' => '');
        }
	
        function purge($keep_item_ids = null)
        {
            $del_item_ids = array();
            
            if(defined('REF_KEEP_DAYS')) {
                if(!is_array($keep_item_ids)) {
                    $keep_item_ids = array();
                }
                
                $keep_hash = array();
                foreach($keep_item_ids as $id) {
                    $keep_hash['_' . $id] = 1;
                }
                
                $keep_days = REF_KEEP_DAYS;
                $keep_seconds = $keep_days * 24 * 60 * 60;
                
                $time_clause = " UNIX_TIMESTAMP(it.`timestamp`) <= UNIX_TIMESTAMP(now()) - ($keep_seconds) ";
                
                $idq = sprintf("SELECT it.id FROM
                                %s as it, %s as ist
                                WHERE it.id = ist.item_id
                                AND it.feed_id = %s
                                AND ist.public IS NULL
                                AND %s",
                                REF_ITEM_TABLE,
                                REF_ITEM_SELECT_TABLE,
                                $this->id,
                                $time_clause);
                
                $idq = ref_do_query($idq);
                
                while($row = $idq->fetchRow(DB_FETCHMODE_ASSOC)) {
                    $id = $row['id'];
                    if(!isset($keep_hash['_' . $id])) {
                        $del_item_ids[] = $id;
                    }
                }
                
                if(count($del_item_ids) > 0) {
                    $itsql = sprintf('DELETE FROM %s
                                      WHERE feed_id = %d AND id IN(%s)',
                                      REF_ITEM_TABLE,
                                      $this->id,
                                      join(",", $del_item_ids));
                    
                    ref_do_query($itsql);
                    
                    $istsql = sprintf('DELETE FROM %s
                                       WHERE feed_id = %d AND item_id IN (%s)',
                                       REF_ITEM_SELECT_TABLE,
                                       $this->id,
                                       join(",", $del_item_ids));
                    
                    
                    ref_do_query($istsql);
                    
                    #	      print "PURGE: <pre>$itsql</pre>";
                    
                }
            }

            return count($del_item_ids);
        }	

    }
	
?>
