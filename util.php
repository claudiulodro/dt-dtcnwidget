<?php
/*----------------------------------------
$Id: util.php,v 1.69 2005/05/09 23:58:55 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

util.php - utility functions used from other scripts
----------------------------------------*/

    function ref_do_query($q, $params = null, $live = 0)
    {
        global $REF_DBH;
        
        $res = $REF_DBH->query($q, $params);
        
        if (DB::isError($res)) {
            $err = $res->getMessage() . ":" . $res->getDebugInfo();
            if($live) {
                print "<B>MYSQL ERROR: $err</B><BR>\n";
                return 0;
            } else{
                die($err);
            }
        }
        
        return $res;
    }

    function ref_can_boolean_search() 
    {
        if(isset($GLOBALS['REF_MYSQL_SUPPORTS_BOOLEAN_SEARCH']))
            return $GLOBALS['REF_MYSQL_SUPPORTS_BOOLEAN_SEARCH'];
    
        $q = sprintf("SELECT *
                      FROM %s AS it
                      WHERE id = 1
                        AND MATCH (it.title, it.link, it.content, it.dccreator, it.dcsubject) AGAINST ('test' IN BOOLEAN MODE)",
                      REF_ITEM_TABLE);
        
        $res = $GLOBALS['REF_DBH']->query($q);
        $GLOBALS['REF_MYSQL_SUPPORTS_BOOLEAN_SEARCH'] = (DB::isError($res) ? false : true);
        
        return $GLOBALS['REF_MYSQL_SUPPORTS_BOOLEAN_SEARCH'];
    }


    function ref_is_subscribed($url)
    {
        return RF_Feed::_retrieve(array('where' => array( 'url' => $url)));
    }



// CDATAFY
    function ref_cdata_escape($s)
    {
        return str_replace("]]>", " ] ] >", $s);
    }

// ARRAYIFYING


// HELPER
    
    function ref_find_links($content) 
    {
        $n = preg_match_all("/<a [^\>]*href\=[\'\"]*([^\"\'\s]+)[\'\"]*[^\>]*\>/i", $content, $matches, PREG_SET_ORDER);
        
        $res = array();
        
        foreach($matches as $m) {
            $res[] = $m[1];
        }
        
        return $res;
    }


// DATE/TIME CONVERSIONS
    function ref_unix_timestamp2iso8601($ts)
    {
        return date("Y-m-d\TH:i:sO",$ts);
    }

    function ref_unix_timestamp2rfc822($ts)
    {
        return date("r",$ts);
    }

    function ref_rfc8222unix_timestamp($rfc822)
    {
        return strtotime($rfc822);
    }

    function ref_iso86012unix_timestamp($iso8601)
    {
        return parse_w3cdtf($iso8601) - (REF_TIME_OFFSET * 60 * 60);
    }


    function ref_sql_timestamp2unix_timestamp($ts)
    {
      // just a pass thru because now always use UNIX_TIMESTAMP(timestamp) in the SQL
      return $ts;
    }

    function ref_sql_timestamp2iso8601($ts)
    {
        return (unix_timestamp2iso8601(sql_timestamp2unix_timestamp($ts)));
    }
// FOR LOADING FEEDS WITH STATS, FOR VIEW PAGE

    function ref_load_feeds($args)
    {

        if(isset($args['search']) && !empty($args['search'])) {

            $search_test = sprintf("(MATCH (it.title, it.link, it.content, it.dccreator, it.dcsubject) AGAINST ('%s' %s)
                                     OR
                                     MATCH (ist.title, ist.content, ist.link, ist.comment, ist.subjects) AGAINST ('%s' %s))",
                                  
                                     mysql_escape_string($args['search']),
                                     (ref_can_boolean_search() ? 'IN BOOLEAN MODE' : ''),
                                  
                                     mysql_escape_string($args['search']),
                                     (ref_can_boolean_search() ? 'IN BOOLEAN MODE' : ''));
                                     
            $search_join = sprintf("LEFT JOIN %s AS it
                                    ON it.id = ist.item_id",
                                    REF_ITEM_TABLE);

        } else {

            $search_test = '1'; // true because everything matches when no search is specified
            $search_join = '';  // no need to join onto items table if there's no search

        }

        if($_SESSION['feed_sort'] == 'age') {

            $order = 'ORDER BY feedstats_last_update DESC,
                               feed_title ASC';
        
        } elseif($_SESSION['feed_sort'] == 'items') {

            $order = 'ORDER BY feedstats_unread DESC,
                               feed_title ASC';
        
        } else {

            $order = 'ORDER BY feed_title ASC';
        
        }

        $q = sprintf("SELECT

                      #### Feed columns
                          ft.id                         AS feed_id,
                          ft.url                        AS feed_url,
                          ft.title                      AS feed_title,
                          ft.link                       AS feed_link,
                          ft.description                AS feed_description,
                          ft.xml                        AS feed_xml,
                          UNIX_TIMESTAMP(ft.timestamp)  AS feed_timestamp,
                          
                      #### Feed Select columns
                          fst.id                        AS feedselect_id,
                          fst.feed_id                   AS feedselect_feed_id,
                          fst.public                    AS feedselect_public,
                          UNIX_TIMESTAMP(fst.timestamp) AS feedselect_timestamp,

                      #### Feed Stats columns
                          ft.id                         AS feedstats_id,

                          #UNIX_TIMESTAMP(
                          #MAX(IF(it.id IS NOT NULL,
                          #       it.timestamp, 0)))    AS feedstats_last_update,   # newest item, read or not (unused)
                      
                          UNIX_TIMESTAMP(
                          MAX(IF(ist.read IS NULL
                                 AND ist.id IS NOT NULL,
                                 ist.timestamp, 0)))    AS feedstats_last_update,   # timestamp of newest unread item
                      
                          SUM(IF(ist.id IS NOT NULL
                                 AND {$search_test},
                                 1, 0))                 AS feedstats_items,         # count of all items
                      
                          SUM(IF(ist.read IS NULL
                                 AND ist.id IS NOT NULL
                                 AND {$search_test},
                                 1, 0))                 AS feedstats_unread,        # count of unread items
                      
                          SUM(IF(ist.public = 1
                                 AND ist.id IS NOT NULL
                                 AND {$search_test},
                                 1, 0))                 AS feedstats_public         # count of public items
                      
                      ## Feed tables
                      FROM %s AS fst,
                           %s AS ft

                      ## Item Select table
                      LEFT JOIN %s AS ist
                          ON ist.feed_id = ft.id
                          
                      ## Item table, if any fulltext search is needed
                      {$search_join}

                      WHERE fst.feed_id = ft.id
                      GROUP BY feedselect_id
                      
                      {$order}
                      ",
                      
                      REF_FEED_SELECT_TABLE,
                      REF_FEED_TABLE,
                      REF_ITEM_SELECT_TABLE
                      );
                      
        $result = ref_do_query($q);
        $feedSelects = array();

        while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            $feedSelect = array();
            $feed = array();
            $feedStats = array();
            
            foreach(array_keys($row) as $col) {
                
                // split up the response rows, creating RF_Feed, RF_FeedSelect, and RF_FeedStats objects based on column name
                
                if(substr($col, 0, 5) == 'feed_') {
                    $feed[substr($col, 5)] = $row[$col];

                } elseif(substr($col, 0, 11) == 'feedselect_') {
                    $feedSelect[substr($col, 11)] = $row[$col];

                } elseif(substr($col, 0, 10) == 'feedstats_') {
                    $feedStats[substr($col, 10)] = $row[$col];

                }

                unset($row[$col]);
            }
            
            $feedSelect = new RF_FeedSelect($feedSelect);
            $feedSelect->stats(new RF_FeedStats($feedStats));
            $feedSelect->feed(new RF_Feed($feed));

            $feedSelects[] = $feedSelect;
        }
        
        return $feedSelects;
        
        /*------------+---------------+    +-----------+---------------+
        | Feeds                       |    | Feeds Select              |
        +-------------+---------------+    +-----------+---------------+
        | id          | int(11)       |    | id        | int(11)       |
        | url         | text          |    | feed_id   | int(11)       |
        | title       | varchar(255)  |    | public    | tinyint(4)    |
        | link        | varchar(255)  |    | timestamp | timestamp(14) |
        | description | varchar(255)  |    +-----------+---------------+
        | xml         | text          |
        | timestamp   | timestamp(14) |
        +-------------+--------------*/

        /*----------+---------------+    +-----------+---------------+
        | Items                     |    | Items Select              |
        +-----------+---------------+    +-----------+---------------+
        | id        | int(11)       |    | id        | int(11)       |
        | feed_id   | int(11)       |    | item_id   | int(11)       |
        | guid      | varchar(255)  |    | feed_id   | int(11)       |
        | timestamp | timestamp(14) |    | read      | tinyint(4)    |
        | link      | text          |    | public    | tinyint(4)    |
        | title     | text          |    | link      | text          |
        | content   | text          |    | title     | text          |
        | dcdate    | varchar(255)  |    | content   | text          |
        | dccreator | varchar(255)  |    | comment   | text          |
        | dcsubject | varchar(255)  |    | subjects  | varchar(255)  |
        | xml       | text          |    | timestamp | timestamp(14) |
        +-----------+---------------+    +-----------+--------------*/
    }
    

// FOR LOADING ITEMS, PARAMETERIZED
    
    function ref_load_items($args, $sql=null)
    {
        if(empty($sql))
            $sql = RF_ItemSelect::args_to_sql($args);

        //echo '<pre>'.print_r($sql, 1).'</pre>';
    
        $where = RF_DBObject::_where_clause($sql['where'], 'ist');
        $order = RF_DBObject::_order_clause($sql['order']);
        $limit = RF_DBObject::_limit_clause($sql['limit']);
        
        $q = sprintf("SELECT

                      #### Item Select columns
                          ist.id                        AS itemselect_id,
                          ist.item_id                   AS itemselect_item_id,
                          ist.feed_id                   AS itemselect_feed_id,
                          ist.read                      AS itemselect_read,
                          ist.public                    AS itemselect_public,
                          ist.link                      AS itemselect_link,
                          ist.title                     AS itemselect_title,
                          ist.content                   AS itemselect_content,
                          ist.comment                   AS itemselect_comment,
                          ist.subjects                  AS itemselect_subjects,
                          ist.timestamp                 AS itemselect_db_timestamp,
                          UNIX_TIMESTAMP(ist.timestamp) AS itemselect_timestamp,

                      #### Item columns
                          it.id                         AS item_id,
                          it.feed_id                    AS item_feed_id,
                          it.guid                       AS item_guid,
                          it.link                       AS item_link,
                          it.title                      AS item_title,
                          it.content                    AS item_content,
                          it.dcdate                     AS item_dcdate,
                          it.dccreator                  AS item_dccreator,
                          it.dcsubject                  AS item_dcsubject,
                          it.xml                        AS item_xml,
                          it.timestamp                  AS item_db_timestamp,
                          UNIX_TIMESTAMP(it.timestamp)  AS item_timestamp,

                      #### Feed columns
                          ft.id                         AS feed_id,
                          ft.url                        AS feed_url,
                          ft.title                      AS feed_title,
                          ft.link                       AS feed_link,
                          ft.description                AS feed_description,
                          ft.xml                        AS feed_xml,
                          ft.timestamp                  AS feed_db_timestamp,
                          UNIX_TIMESTAMP(ft.timestamp)  AS feed_timestamp

                      FROM %s AS ist

                      INNER JOIN %s as it
                        ON ist.item_id = it.id

                      INNER JOIN %s AS ft
                        ON ist.feed_id = ft.id

                      {$where}
                      {$order}
                      {$limit}
                      ",
                      REF_ITEM_SELECT_TABLE,
                      REF_ITEM_TABLE,
                      REF_FEED_TABLE
                      );
    
        //echo "<pre>{$q}</pre>";

        $result = ref_do_query($q);
        $itemSelects = array();

        while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            $itemSelect = array();
            $item = array();
            $feed = array();
            
            foreach(array_keys($row) as $col) {
                
                // split up the response rows, creating RF_Feed, RF_Item and RF_ItemSelect objects based on column name
                
                if(substr($col, 0, 5) == 'feed_') {
                    $feed[substr($col, 5)] = $row[$col];

                } elseif(substr($col, 0, 5) == 'item_') {
                    $item[substr($col, 5)] = $row[$col];

                } elseif(substr($col, 0, 11) == 'itemselect_') {
                    $itemSelect[substr($col, 11)] = $row[$col];

                }

                unset($row[$col]);
            }
            
            $itemSelect = new RF_ItemSelect($itemSelect);
            $itemSelect->item(new RF_Item($item));
            $itemSelect->feed(new RF_Feed($feed));

            $itemSelects[] = $itemSelect;
        }
        
        return $itemSelects;

        /*------------+---------------+    +-----------+---------------+
        | Feeds                       |    | Feeds Select              |
        +-------------+---------------+    +-----------+---------------+
        | id          | int(11)       |    | id        | int(11)       |
        | url         | text          |    | feed_id   | int(11)       |
        | title       | varchar(255)  |    | public    | tinyint(4)    |
        | link        | varchar(255)  |    | timestamp | timestamp(14) |
        | description | varchar(255)  |    +-----------+---------------+
        | xml         | text          |
        | timestamp   | timestamp(14) |
        +-------------+--------------*/

        /*----------+---------------+    +-----------+---------------+
        | Items                     |    | Items Select              |
        +-----------+---------------+    +-----------+---------------+
        | id        | int(11)       |    | id        | int(11)       |
        | feed_id   | int(11)       |    | item_id   | int(11)       |
        | guid      | varchar(255)  |    | feed_id   | int(11)       |
        | timestamp | timestamp(14) |    | read      | tinyint(4)    |
        | link      | text          |    | public    | tinyint(4)    |
        | title     | text          |    | link      | text          |
        | content   | text          |    | title     | text          |
        | dcdate    | varchar(255)  |    | content   | text          |
        | dccreator | varchar(255)  |    | comment   | text          |
        | dcsubject | varchar(255)  |    | subjects  | varchar(255)  |
        | xml       | text          |    | timestamp | timestamp(14) |
        +-----------+---------------+    +-----------+--------------*/
    }
    
    
/************** RSS UTILITY STUFF ****************/

    function ref_opml_to_array($opml)
    {
        $rx = "/xmlurl=\"(.*?)\"/mi";
        
        if(preg_match_all($rx, $opml, $m)) {
            for($i = 0; $i < count($m[0]) ; $i++) {
                $r[] = $m[1][$i];
            }
        }
        
        return $r;
    }


    function ref_getRSSLocation($html, $location)
    {
        if(!$html or !$location) {
            return false;
        } else {
            #search through the HTML, save all <link> tags
            # and store each links attributes in an associative array
            preg_match_all('/<link\s+(.*?)\s*\/?'.'>/si', $html, $matches);
            $links = $matches[1];
            $final_links = array();
            $link_count = count($links);
            for($n=0; $n<$link_count; $n++) {
                $attributes = preg_split('/\s+/s', $links[$n]);
                foreach($attributes as $attribute) {
                    $att = preg_split('/\s*=\s*/s', $attribute, 2);
                    if(isset($att[1])) {
                        $att[1] = preg_replace('/([\'"]?)(.*)\1/', '$2', $att[1]);
                        $final_link[strtolower($att[0])] = $att[1];
                    }
                }
                $final_links[$n] = $final_link;
            }
            #now figure out which one points to the RSS file
            for($n=0; $n<$link_count; $n++) {
                if(strtolower($final_links[$n]['rel']) == 'alternate') {
                    if(strtolower($final_links[$n]['type']) == 'application/rss+xml') {
                        $href = $final_links[$n]['href'];
                    }
                    if(!$href and strtolower($final_links[$n]['type']) == 'text/xml') {
                        #kludge to make the first version of this still work
                        $href = $final_links[$n]['href'];
                    }
                    if($href) {
                        if(strstr($href, "http://") !== false) { #if its absolute
                            $full_url = $href;
                        } else { #otherwise, 'absolutize' it
                            $url_parts = parse_url($location);
                            #only made it work for http:// links. Any problem with this?
                            $full_url = "http://$url_parts[host]";
                            if(isset($url_parts['port'])) {
                                $full_url .= ":$url_parts[port]";
                            }
                            if($href {0} != '/') { #its a relative link on the domain
                                $full_url .= dirname($url_parts['path']);
                                if(substr($full_url, -1) != '/') {
                                    #if the last character isnt a '/', add it
                                    $full_url .= '/';
                                }
                            }
                            $full_url .= $href;
                        }
                        return $full_url;
                    }
                }
            }
            return false;
        }
    }



function merge_hash($h1, $h2) {

  $res = $h1;

  foreach($h2 as $k => $v) {
    $res[$k] = $v;
  }

  return $res;
}

?>
