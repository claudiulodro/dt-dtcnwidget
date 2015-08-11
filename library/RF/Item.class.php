<?php
/*----------------------------------------
$Id: Item.class.php,v 1.22 2005/04/20 21:17:50 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

Item.class.php - RF_Item is a wrapper class for items
----------------------------------------*/

require_once("DBObject.class.php");

    class RF_Item extends RF_DBObject
    {
        var $id = 0;
        var $feed_id = 0;
        var $guid = '';
        var $timestamp = 0;
        var $link = null;
        var $title = null;
        var $content = null;
        var $dcdate = null;
        var $dccreator = null;
        var $dcsubject = null;
        var $xml = '';

        var $feed = null;

        var $db_cols = array("feed_id", "guid", "link", "title", "content", "dcdate", "dccreator", "dcsubject", "xml");
        var $db_table = REF_ITEM_TABLE;
    
        function RF_Item($args)
        {
            foreach($args as $k => $v) {
                $this->$k = $v;
            }
        }

        function links() 
        {
            return find_links($this->content);
        }

        function _retrieve($args)
        {
            if(!is_array($args)) {
                $args = array('where' =>array('id' =>$args));
            }
    
            $res = RF_Item::_retrieve_all($args);
            return (is_array($res) && count($res) > 0 ? $res[0] : 0);
        }

        function _retrieve_all($args)
        {
            $q = sprintf("SELECT it.*, it.timestamp as db_timestamp, UNIX_TIMESTAMP(it.timestamp) as timestamp
                          FROM %s AS it
                          %s
                          ORDER BY it.timestamp DESC
                          %s",
                          REF_ITEM_TABLE,
                          RF_DBObject::_where_clause($args[where]),
                          RF_DBObject::_limit_clause($args[limit]));
                          
            $result = ref_do_query($q);
    
            $items = array();
            
            while($item = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
                $items[] = & new RF_Item($item);
            }
            
            return $items;
        }

        function arrayify($cols = null)
        {
            $i = RF_DBObject::arrayify($cols);
            
            if($i['dcdate']) {
                $i['orig_dcdate'] = $i['dcdate'];
            } else {
                $i['orig_dcdate'] = ref_unix_timestamp2iso8601($i['timestamp']);
            }
            
            return $i;
        }	

    }
    
?>
