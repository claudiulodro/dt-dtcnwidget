<?php
/*----------------------------------------
$Id: ItemSelect.class.php,v 1.29.4.1 2005/08/08 12:22:10 mfrumin Exp $

vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

ItemSelect.class.php - RF_ItemSelect is a wrapper class for
user views of items
----------------------------------------*/

    require_once("DBObject.class.php");
    require_once("Item.class.php");
    require_once("Feed.class.php");

    class RF_ItemSelect extends RF_DBObject
    {
        var $id = 0;
        var $item_id = 0;
        var $feed_id = 0;
        var $read = null;
        var $public = null;
        var $link = null;
        var $title = null;
        var $content = null;
        var $comment = null;
        var $subjects = null;
        var $timestamp = 0;
	
        var $item = 0;
        var $feed = 0;

        var $db_cols = array("item_id", "feed_id", "read" ,"public" ,"link","title","content","comment", "subjects");
        var $db_table = REF_ITEM_SELECT_TABLE;

        function RF_ItemSelect($args = null) 
        {
    	    $this->orig_vals = $args;

            foreach($args as $k => $v) {
                $this->$k = $v;
            }
        }
        
        function links() 
        {
            $item = &$this->item();
            $links = ref_find_links($item->content);
            array_unshift($links, $item->link);
            $sel_links = ref_find_links($this->content);
            $linkHash = array();

            foreach($links as $l) {
                $linkHash[$l] = 1;
            }
            
            foreach($sel_links as $l) {
                if(!isset($linkHash[$l])) {
                    $links[] = $l;
                    $linkHash[$l] = 1;
                }
            }
            
            if(!empty($this->link) && !isset($linkHash[$this->link])) {
                array_unshift($links, $this->link);
            }
            
            return $links;
        }

        function curr_link()
        {
            if(empty($this->link)) {
                $item = &$this->item();
                return $item->link;
            }

            return $this->link;
        }

        function curr_title()
        {
            if(empty($this->title)) {
                $item = &$this->item();
                return $item->title;
            }

            return $this->title;
        }

        function curr_content()
        {
            if(empty($this->content)) {
                $item = &$this->item();
                return $item->content;
            }

            return $this->content;
        }

        
        function &item($item = null)
        {
            if(!(is_null($item) || empty($item))) {
                $this->item = &$item;
                $this->item_id = $item->id;
            }
            
            if(empty($this->item)) {
                $this->item = & RF_Item::_retrieve($this->item_id);
            }
            
            return $this->item;
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

        function guid()
        {
            $guid = "tag:";
            
            
            $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
            $url = parse_url($url);
            $host = $url['host'];
            $path = dirname($url['path']) . '/';
            
            $guid .= "$host$path" . $this->id;
            
            return $guid;
        }
        
    	function _retrieve($args)
        {	  
            if(!is_array($args)) {
                $args = array('where' =>array('id' =>$args));
            }
            
            $res = RF_ItemSelect::_retrieve_all($args);
            return (is_array($res) && count($res) > 0 ? $res[0] : 0);
        }


        function _retrieve_all($args) 
        {
            $q = sprintf("SELECT ist.*, ist.timestamp as db_timestamp, UNIX_TIMESTAMP(ist.timestamp) as timestamp

                          FROM %s AS ist

                          INNER JOIN %s AS fst
                            ON ist.feed_id = fst.feed_id

                          INNER JOIN %s as it
                            ON ist.item_id = it.id and it.feed_id = fst.feed_id

                          %s
                          %s 
                          %s 
                          ",
                          REF_ITEM_SELECT_TABLE,
                          REF_FEED_SELECT_TABLE,
                          REF_ITEM_TABLE,

			  RF_DBObject::_where_clause($args['where'], "ist"),
                          RF_DBObject::_order_clause($args['order']),
                          RF_DBObject::_limit_clause($args['limit']));
	    
#	    print "<pre>$q</pre>";

            $result = ref_do_query($q);
	    
            $items = array();
            
            while($item = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                $items[] = & new RF_ItemSelect($item);
            }

            return $items;
        }

        function arrayify($cols = null)
        {
            $feed = & $this->feed();
            $item = & $this->item();
            
            $is = RF_DBObject::arrayify($cols);
            $is['feed'] = $feed->arrayify();
            $is['item'] = $item->arrayify();
            
            $is['curr_title'] = $this->curr_title();
            $is['curr_link'] =  $this->curr_link();
            $is['curr_content'] =  $this->curr_content();
            
            $is['links'] = $this->links();
            
            $is['guid'] = $this->guid();
            
            return $is;
        }	

        function _mark_read($item_select, $read)
        {
            if(!empty($item_select) && is_numeric($item_select)) {
                $item_select = & RF_ItemSelect::_retrieve($item_select);
                if($item_select) {
                    $item_select->read = $read ? 1 : null;
                    $item_select->save(true);
                }
            }
        }

        function _mark_all_read($read, $feed, $ids = null, $preserve_timestamp = null)
        {
            if(empty($ids) || !is_array($ids)) {
                $ids = array();
            }
        
            if(!empty($feed)) {
                if(is_numeric($feed) && $feed != 0) {
                    $sql = sprintf('SELECT id FROM %s ist
                                    WHERE ist.feed_id = %s
                                    AND ist.read IS NULL',
                                    REF_ITEM_SELECT_TABLE,
                                    $feed);
                
                    $res = ref_do_query($sql);
                    while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) {
                        $ids[] = $row['id'];
                    }
                
                } elseif($feed === 'all') {
                    $sql = sprintf('SELECT id FROM %s ist
                                    WHERE ist.read IS NULL',
                                    REF_ITEM_SELECT_TABLE);
                
                    $res = ref_do_query($sql);
                    while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) {
                        $ids[] = $row['id'];
                    }
                
                }
            }
        
            $ids = array_filter($ids, 'is_numeric');
            if(count($ids) > 0) {        
          
                $pts = (is_null($preserve_timestamp) || empty($preserve_timestamp)
                    ? ""
                    : ', `timestamp` = `timestamp`');
    
                # dont update the timestamp on mass changes
                ref_do_query(sprintf('UPDATE %s SET `read` = %s %s
                                      WHERE id IN (%s) and `read` %s',
                                      REF_ITEM_SELECT_TABLE, 
                                      (empty($read) ? 'NULL' : 1),
                                      $pts,
                                      join(",", $ids),
                                      (empty($read) ? 'IS NOT NULL' : 'IS NULL')));
            }
        
        }
        
        function _mark_public($item_select, $public)
        {
            if(!empty($item_select) && is_numeric($item_select)) {
                $item_select = & RF_ItemSelect::_retrieve($item_select);
                if($item_select) {
                    $item_select->public = $public ? 1 : null;
                    $item_select->save(false);
                }
            }
        }

        function _select_link($item_select, $link)
        {
            if(!empty($item_select) && is_numeric($item_select)) {
                $item_select = & RF_ItemSelect::_retrieve($item_select);
                if($item_select) {
                    $item = & $item_select->item();
                    $item_select->link = (strcmp($item->link, $link) == 0 ? null : $link);
                    $item_select->save(true);
                }
            }
        }

        function _submit_values($item_select, $args)
        {
            if(!empty($item_select) && is_numeric($item_select)) {
                $item_select = & RF_ItemSelect::_retrieve($item_select);
                if($item_select) {
                    foreach($args as $k => $v) {
                        $item_select->$k = $v;
                    }
                    $item_select->save();
                }
            }            

        }
	

        function _get_ids_from_item_ids($item_ids) 
        {
            $ids = array();
            
            if(is_array($item_ids) && count($item_ids) > 0) {
                
                $sql = sprintf('SELECT id, item_id FROM %s ist
                               WHERE ist.item_id in (%s)',
                               REF_ITEM_SELECT_TABLE,
                               join(",", $item_ids));
                
                $res = ref_do_query($sql);
                while($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) {

                    $ids[] = $row['id'];
                }
                
            }
            
            return $ids;
        }

    	function args_to_sql($args)
        {
            extract($args);
            $sql = array();
            
            if($how == 'paged') {
                $sql['limit'] = array((is_numeric($offset) ? $offset : 0),
                                      (is_numeric($howmany) ? $howmany : REF_HOWMANY));
            }
            
            
            $sql['where'] = array('_clause' => array());
            
            if(is_numeric($feed)) {
                $sql['where']['feed_id'] = $feed;
            }
            
            switch($what) {
                case 'new':
                    $sql['where']['read'] = array('IS' , 'NULL');
                    break;
                case 'public':
                    $sql['where']['public'] = array('IS NOT' , 'NULL');
                    break;
            }
    
            if(!empty($when)) {
    
                switch($when) {
                    case 'todau':
                        $when_date = date("Y/m/d", time() - (REF_TIME_OFFSET * 60 * 60));	  
                        break;
                    default:
                        $when_date = $when;
                        break;
                }
            
                $begin = strtotime($when_date);
                $begin += (REF_TIME_OFFSET * 60 * 60);
                $end = $begin + (24 * 60 * 60);
                
                $tomorrow = date("Y/m/d", $begin + (24 * 60 * 60));
                $yesterday = date("Y/m/d", $begin - (24 * 60 * 60));
                
                $sql['where']['_clause'][] = "UNIX_TIMESTAMP(ist.`timestamp`) > {$begin}";
                $sql['where']['_clause'][] = "UNIX_TIMESTAMP(ist.`timestamp`) < {$end}";
            }
            
            if(!empty($search)) {
                $sql['where']['_clause'][] = sprintf('(MATCH (it.title, it.link, it.content, it.dccreator, it.dcsubject) AGAINST (\'%s\' %s) 
                                                       OR
                                                       MATCH (ist.title, ist.content, ist.link, ist.comment, ist.subjects) AGAINST (\'%s\' %s))',
    
                                                      mysql_escape_string($search), 
                                                      (ref_can_boolean_search() ? 'IN BOOLEAN MODE' : ''),
    
                                                      mysql_escape_string($search), 
                                                      (ref_can_boolean_search() ? 'IN BOOLEAN MODE' : ''));
            }
            
            $sql['order'] = array('ist.`timestamp`' => 'desc', 'ist.id' => 'asc');
            
            return $sql;
        }


        
    }

?>
