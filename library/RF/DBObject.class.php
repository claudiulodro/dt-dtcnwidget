<?php
/*----------------------------------------
$Id: DBObject.class.php,v 1.13 2005/04/20 21:27:19 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

DBObject.class.php - RF_DBObject is a database abstraction class,
extended by other Refeed-specific classes
----------------------------------------*/

  class RF_DBObject 
  {
        var $id = 0;
        var $db_cols = 0;
        var $db_table = 0;
        var $orig_vals = 0;

        function RF_DBObject($args)
        {
            $orig_vals = $args;
        }

        function save($preserve_timestamp = null)
        {
            if(empty($this->db_cols)) die("<B>CANT SAVE INTO THE DB WITH NO COLUMNS DEFINED</b>");
            if(empty($this->db_table)) die("<B>CANT SAVE INTO THE DB WITH NO TABLE NAME</b>");
            
            $dbh =& $GLOBALS['REF_DBH'];
            
            $qk = array();
            foreach($this->db_cols as $k) $qk[] = $dbh->quoteIdentifier($k);

            $vals = array();
            foreach($this->db_cols as $k) $vals[] = $this->$k;
            
            if(!(is_null($preserve_timestamp) || empty($preserve_timestamp))) {
                $qk[] = $dbh->quoteIdentifier('timestamp');
                $vals[] = $this->db_timestamp;

            }

            $q = ($this->id)
                ? $dbh->autoPrepare($this->db_table, $qk, DB_AUTOQUERY_UPDATE, "id = {$this->id}")
                : $dbh->autoPrepare($this->db_table, $qk, DB_AUTOQUERY_INSERT);
            
            $err = $dbh->execute($q, $vals);
            
            if(DB::isError($err)) die(join(":", array($err->getMessage(), $err->getDebugInfo())));
            
            if(!$this->id) $this->id = $dbh->getOne("select last_insert_id()");
        }


        function _where_clause($where, $table)
        {
            $table = !empty($table) ? "{$table}." : '';
            
            if(empty($where)) return '';

            if(is_array($where)) {
                $a = array();
                foreach($where as $column => $value) {
                    #more flexibility for the caller here
                    if($column == '_clause') {
                        if(is_array($value)) {
                            if(count($value) > 0) {
                                $a[] = join(' AND ', $value);
                            }
                        } else {
                            $a[] = $value;
                        }
                    } elseif(is_array($value)) {
                        $a[] = "{$table}`{$column}` {$value[0]} {$value[1]}";
                    } else {
                        $a[] = "{$table}`{$column}` = '".mysql_escape_string($value)."'";
                    }
                }
                $where = join(' AND ', $a);
            } else {
                $where = "{$tableid} = '" . mysql_escape_string($where) . "'";
            }
            
            if(empty($where)) return '';

            return " WHERE {$where} ";
        }

    
        function _order_clause($order)
        {
            if(empty($order) || !is_array($order)) return '';

            $a = array();
            foreach($order as $column => $direction) {
                $direction = (strtolower($direction) == "asc") ? 'ASC' : 'DESC';
                $a[] = "{$column} {$direction}";
            }
            $order = join(', ', $a);
            return " ORDER BY {$order} ";
        }

        function _limit_clause($limit)
        {
            if(empty($limit) || !is_array($limit)) return '';

            $limit = join(" , ", $limit);
            return " LIMIT {$limit} ";
        }


        function arrayify($cols = null)
        {
            $a = array();

            if(!is_array($cols)) {
                $cols = array();
            }

            if(isset($this->db_cols) && is_array($this->db_cols)) {
                foreach($this->db_cols as $c) {
                    array_push($cols, $c);
                }
            }

            foreach($cols as $c) {
                $a[$c] = $this->$c;
            }
            
            if(isset($this->id)) {
                $a['id'] = $this->id;
            }
            
            if(isset($this->timestamp)) {
                $a['timestamp'] = ref_sql_timestamp2unix_timestamp($this->timestamp);
            }
            
            return $a;
        }

    }

?>
