<?php
/*----------------------------------------
$Id: FeedStats.class.php,v 1.15 2004/12/20 19:06:50 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

FeedStats.class.php - wrapper class for feed statistics, like
read/unread and public/private item counts
----------------------------------------*/

    require_once("DBObject.class.php");

    class RF_FeedStats extends RF_DBObject
    {
        var $id = 0;
        var $items = 0;
        var $unread = 0;
        var $public = 0;
        var $last_update = 0;
        var $age = 0;
        var $agestr = '';
        var $agestrabbr = '';
	
        var $db_cols = array('last_update', 'unread', 'public', 'items', 'age', 'agestr', 'agestrabbr');

        function RF_FeedStats($args) 
        {
            foreach($args as $k => $v) {
                $this->$k = $v;
            }

            if(is_null($this->last_update)) {
                $this->last_update = 0;
            }
            
            $now = time();
            
            $this->age = ($now - $this->last_update);
            
            if($this->age == $now) {
                $this->agestr = "never";
                $this->agestrabbr = "&infin;";
            
            } else {
                if($seconds = $this->age)
                    $this->agestr = sprintf('%d second%s ago', $seconds, (($seconds != 1) ? 's' : ''));
                
                if($minutes = round($this->age / 60))
                    $this->agestr = sprintf('%d minute%s ago', $minutes, (($minutes != 1) ? 's' : ''));
                
                if($hours = round($this->age / 60 / 60))
                    $this->agestr = sprintf('%d hour%s ago', $hours, (($hours != 1) ? 's' : ''));
                
                if($days = round($this->age / 60 / 60 / 24))
                    $this->agestr = sprintf('%d day%s ago', $days, (($days != 1) ? 's' : ''));
                
                $this->agestrabbr = '&nbsp;';
            }
        
        }

        function _retrieve($args)
        {	  
            if(!is_array($args)) {
                $args = array('where' =>array('id' =>$args));
            }
            
            $res = RF_FeedStats::_retrieve_all($args);
            return (is_array($res) && count($res) > 0 ? $res[0] : 0);
        }

        function _retrieve_all($args) 
        {

	    $filter = (isset($args['_filter']) && is_array($args['_filter']) ? $args['_filter'] : array());
	    $search = (isset($filter['search']) && !empty($filter['search']) ? $filter['search'] : '');
	    if($search) {
	      $bool = (ref_can_boolean_search() ? "IN BOOLEAN MODE" : "");
	      
	      $search = mysql_escape_string($search);

	      $search = sprintf('AND (MATCH (it.title, it.link, it.content, it.dccreator, it.dcsubject) AGAINST (\'%s\' %s)
                                           OR
                                           MATCH (ist.title, ist.content, ist.link, ist.comment, ist.subjects) AGAINST (\'%s\' %s))',
				$search, $bool,
				$search, $bool
				);
	    }
	    
            $q = sprintf('SELECT ft.id,
                                                MAX(UNIX_TIMESTAMP(it.timestamp)) AS last_update,
                                                SUM(IF(ist.item_id %s, 1, 0)) as items,
                                                SUM(IF(ist.item_id is not null and ist.read is null %s, 1, 0)) AS unread,
                                                SUM(IF(ist.item_id is not null and ist.public is not null %s, 1, 0)) AS public
                                            FROM %s AS ft
            
                                            LEFT JOIN %s AS it
                                                ON it.feed_id = ft.id

                                            LEFT JOIN %s AS ist
                                                ON ist.item_id = it.id

                                            %s 
                                            %s
                                            %s %s',
			 $search,$search,$search,
					   
			 REF_FEED_TABLE,			 
			 REF_ITEM_TABLE,
			 REF_ITEM_SELECT_TABLE,
			 RF_DBObject::_where_clause($args['where'], "ft"),
			 RF_DBObject::_order_clause($args['order']),
			 'GROUP BY ft.id',
			 RF_DBObject::_limit_clause($args['limit'])
			 );
	
#  	    print "<pre>$q</pre><br>\n";

	    $result = ref_do_query($q);

            $feeds = array();
        
            while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
	            $feeds[] = & new RF_FeedStats($row);
            }

            return $feeds;
        }

	function sumStats($stats) {
	  $sum_cols = array('items', 'unread', 'public');

	  $all_stats = array();

	  foreach($stats as $stat) {
	    foreach($sum_cols as $col) {
	      $all_stats[$col] += $stat->$col;
	    }
	    if(is_null($all_stats['last_update']) || $stat->last_update > $all_stats['last_update']) {
	      $all_stats['last_update'] = $stat->last_update;
	    }
	  }

	  return $all_stats;
	}

    }

?>
