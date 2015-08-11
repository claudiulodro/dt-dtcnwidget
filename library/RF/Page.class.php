<?php
/*----------------------------------------
$Id: Page.class.php,v 1.67.2.1 2005/08/08 12:49:50 mfrumin Exp $

vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

Page.class.php - RF_Page is an extension of the Smarty template class,
with some Refeed-specific logic for generating links and such.
----------------------------------------*/

    require_once(dirname(__FILE__).'/../Smarty/libs/Smarty.class.php');

    class RF_Page extends Smarty
    {

       /** RF_Page
        * Constructor method for RF_Page
        *
        * @param    mixed   arg     if arg is a string, this is taken to be
        *                           the name of the style directory.
        *
        *                           if arg is an array, this is taken to be an
        *                           associative arrays of named parameters, and
        *                           is extracted.
        */
        function RF_Page($arg=false)
        {

            $this->error_reporting = E_ALL ^ E_NOTICE;

            if($arg && is_array($arg)) {
                extract($arg);

            } elseif($arg && is_string($arg)) {
                $style_dir = $arg;

            }
        
            $this->Smarty();

            // root-level refeed directory
            $parent_dir = basename(dirname(dirname(dirname(__FILE__))));
            
            $this->refeed_root = preg_match("#/{$parent_dir}/frames/\S*#", $_SERVER['REQUEST_URI'])
                ? preg_replace("#(/{$parent_dir})/frames/\S*#", '\1', $_SERVER['REQUEST_URI'])
                : preg_replace("#(/{$parent_dir})/\S*#", '\1', $_SERVER['REQUEST_URI']);
                
            $this->assign('refeed_root', $this->refeed_root);

            // main directory that contains stylesheets, images, templates
            $this->style_dir = $style_dir
                ? $style_dir
                : 'style';
                
            $this->assign('style_dir', $this->style_dir);

            $this->assign('_CONSTANTS', get_defined_constants());

            // main directory that contains templates, inside style_dir by default
            $this->template_dir = $template_dir
                ? dirname(__FILE__)."/../../{$template_dir}"
                : dirname(__FILE__)."/../../{$this->style_dir}/templates";

            $this->compile_dir = REF_CACHE_DIR;
            $this->config_dir = dirname(__FILE__)."/../../{$this->config_dir}";
            $this->cache_dir = REF_CACHE_DIR;

            $this->register_function('link_read',               array($this, 'link_read'));
            $this->register_function('link_do_not_read',        array($this, 'link_do_not_read'));
            $this->register_function('link_all_read',           array($this, 'link_all_read'));
            $this->register_function('link_item',               array($this, 'link_item'));
            $this->register_function('link_feed',               array($this, 'link_feed'));

            $this->register_function('title_truncate',          array($this, 'title_truncate'));
            $this->register_function('link_select',             array($this, 'link_select'));
            $this->register_function('content_link_select',     array($this, 'content_link_select'));

            $this->register_function('view_link',     array($this, 'view_link'));

            $this->register_modifier('balance_tags',            array($this, 'balance_tags')); 
            $this->register_modifier('hilight_search_terms',    array($this, 'hilight_search_terms')); 
            $this->register_modifier('relative_date',           array($this, 'relative_date')); 
            $this->register_modifier('cdata_escape',              'ref_cdata_escape'); 

            $this->register_modifier('iso86012unix_timestamp',  'ref_iso86012unix_timestamp'); 
            $this->register_modifier('unix_timestamp2iso8601',  'ref_unix_timestamp2iso8601'); 
            $this->register_modifier('unix_timestamp2rfc822',  'ref_unix_timestamp2rfc822');
            
            foreach($_SERVER as $var => $value)
                $this->assign($var, $value);

            $this->assign("_SESSION", $_SESSION);
                
            $this->assign('link_new_windows', ((!defined('REF_LINK_NEW_WINDOWS') || REF_LINK_NEW_WINDOWS) ? 1 : 0));
        }

        function link_read($p) {
            if(!empty($p['item']) && is_numeric($p['item'])) {
    
                $link = sprintf('<a href="%s/read.php?item=%d" onclick="toggle_off(%d, %d); return true;">read</a>',
                                (preg_match('#/frames/[^/]+.php$#', $_SERVER['SCRIPT_NAME'])
                                    ? dirname($_SERVER['SCRIPT_NAME']).'/..'
                                    : dirname($_SERVER['SCRIPT_NAME'])),
                                $p['item'],
                                $p['item'],
                                ($p['framed'] ? 1 : 0));
                return $link;
            }
            
            return '';
        }
    
        function link_do_not_read($p) {
            if(!empty($p['item']) && is_numeric($p['item'])) {
    
                $link = sprintf('<a href="#" onclick="toggle_off(%d, %d); return false;">do not read</a>',
                                $p['item'],
                                ($p['framed'] ? 1 : 0));
                return $link;
            }
            
            return '';
        }

        function link_all_read($p)
        {
            $ids = ((!empty($p['ids'])) && is_array($p['ids']))
                ? $p['ids']
                : array();

            if((!empty($p['item_selects'])) && is_array($p['item_selects'])) {
                foreach($p['item_selects'] as $item_select) {
                    $ids[] = $item_select['id'];
                }
            }
            
            $img = !empty($p['refeed_root']) ? "{$p['refeed_root']}/{$this->style_dir}/images/read-all.gif" : 'skin/images/read-all.gif';
            $url = !empty($p['refeed_root']) ? "{$p['refeed_root']}/do.php" : 'do.php';
        
            $return = empty($p['return'])
                ? $_SERVER['REQUEST_URI']
                : $p['return'];
            
            $url .= "?action=mark-items-read&amp;return=".urlencode(empty($p['return'])
                ? $_SERVER['REQUEST_URI']
                : $p['return']);

            foreach(array_filter($ids, 'is_numeric') as $id) {
                $url .= "&amp;ids[]={$id}";
            }

            return $url;
        }

        function link_target($p)
        {
            $target = (!defined('REF_LINK_NEW_WINDOWS') || REF_LINK_NEW_WINDOWS ? 
            sprintf(' target="%s" ', htmlspecialchars($p['link'])) : '');
            
            return $target;
        }
    
        function link_item($p) {
            if(empty($p['link']) && !empty($p['title'])) {
    
                return sprintf('%s', $p['title']);
            }
            
            return sprintf('<a class="headline" %s href="%s">%s</a>',
			    RF_Page::link_target($p),
                            htmlspecialchars($p['link']),
                            strip_tags(empty($p['title'])
                                ? $p['link']
                                : $p['title']));
        }

        function link_feed($p)
        {
            if(empty($p['link'])) return '';
        
            $link = sprintf('<a class="feed" %s href="%s" title="%s">%s</a>',
                             RF_Page::link_target($p),
                             $p['link'],
                             htmlentities(empty($p['description']) ? '' : $p['description']),
                             strip_tags(RF_Page::title_truncate($p)));
            return $link;
        }
	
        function title_truncate($p)
        {
            $p['title'] = ((strlen($p['title']) > 64)
                ? preg_replace('/^(.{40}\S*)\s.+\s(\S*.{16})$/', '$1 ... $2', $p['title'])
                : $p['title']);

			return preg_replace('/(\S{16})/', '$1 ', $p['title']);
            
        }

        function link_select($p)
        {
            $sel = ($p['curr_link'] == $p['link']) ? 'selected' : 'unselected';

            $id = "{$p['item']}-{$p['link_index']}";
            
            // How the F did this get back in the code?  it needs to have the real link
            // because that is what gets put into the DB
#            $href = sprintf('%s/do.php?action=link-select&id=%s&link=%s&return=%s',
#                            $this->refeed_root,
#                            $p['item'],
#                            urlencode($p['link']),
#                            urlencode($_SERVER['REQUEST_URI']));


            // This is what works.
            $href = $p['link'];

            return sprintf('<a class="link-select link-%s" id="linkSelect%s" class="bold" href="%s" title="Make this hyperlink the public feed link">%d</a>',
                           $sel,
                           $id,
                           $href,
                           $p['link_index']);
        }
        
        function content_link_select($p)
        {
            preg_match_all('#<a[^>]+href=[\'\"]([^\'\"]+)[\'\"][^>]*>(.*)</a>#Uis', $p['content'], $matches);
    
            $links = array_unique($matches[0]);
            $hrefs = $matches[1];
            $texts = $matches[2];
            
            for($i = 0; $i < count($links); $i++) {
    	        $link = $links[$i];
	            $url = $hrefs[$i];

                $link_id = "itemLink{$p['item']}-" . ($i + 1);

                // open in-post links in new windows
                $new_link = preg_replace('/<a /Uis', sprintf('<a id="%s" %s', 
                                                             $link_id,
                                                             RF_Page::link_target(array('link' => $url))), $link);

                $p['content'] = str_replace($link,
                                            "{$new_link} " . $this->link_select(array('item' => $p['item'], 'link' => $url, 'curr_link' => $p['curr_link'], 'framed' => $p['framed'], 'link_index' => ($i + 1))),
                                            $p['content']);
            }
            
            return RF_Page::balance_tags($p['content']);
        }


	function view_arg_defaults() {
	  return  array(
			'feed' => null,
			'what' => null,
			'when' => null,
			'offset' => 0,
			'howmany' => REF_HOWMANY,
			'how' => null,
			'search' => (isset($_SESSION['search']) ? $_SESSION['search'] : null)
#			'search' => null
			);
	}

	function view_args($args, $type = ''){ 

	  $res = array();

	  if(!is_array($args)) {
	    $args = array();
	  }

	  $defaults = RF_Page::view_arg_defaults();
	  
	  foreach($defaults as $k => $v) {
	    if(isset($args[$k])) {
	      if(($type != 'sparse') || $args[$k] != $v) {
		$res[$k] = $args[$k];
	      }
	    }
	    elseif($type != 'sparse') {
	      $res[$k] = $v;
	    }
	  }
	  
	  return $res;
	}

	function view_link($p) {
	  $args = array();

	  if(!empty($p['args']) && is_array($p['args'])) {
	    $args = $p['args'];
	  }

	  $url_args = $this->view_args($args, 'sparse');

	  foreach($p as $k => $v) {
	    if($k != 'args' && $k != 'script' && $v != $args[$k]) {
	      $url_args[$k] = $v;
	    }
	  }

	  $tmp = array();

	  foreach($url_args as $k => $v) {
	      $tmp[] = urlencode($k) . "=" . urlencode($v);
	  }

	  $url = $p['script'] . (count($tmp) > 0 ? "?" . join("&", $tmp) : '');
       
	  return $url;

	}


        function view_title($feed_obj=NULL, $args)
        {
	    extract(RF_Page::view_args($args));

            $title = '';
            
            $title .= !empty($when) ? " - {$when}" : '';
            
            if(!empty($feed_obj)) {
	      $title .= " - {$feed_obj->title}";
            }
            
            $end = $offset + $howmany;
            
            $title .= (!empty($how) && $how == 'paged') ? " - items {$offset} to {$end}" : '';

            $title .= " - {$what} items";

	    if(isset($args['search']) && !empty($args['search'])) {
	      $title .= " [search: $args[search]]";
	    }
            
            return htmlspecialchars(substr($title, 3));
        }
        
        function link_page($text, $p)
        {
            $href = 'view.php?';

            if(isset($p['feed']) && is_object($p['feed'])) {
                $p['feed'] = $p['feed']->id;
            }

            foreach($p as $name => $value) {
                $href .= !empty($value) ? sprintf('%s=%s&amp;', urlencode($name), urlencode($value)) : '';
            }
            
            $href = (substr($href, -5) == '&amp;')
                ? substr($href, 0, -5)
                : $href;
                
            return sprintf('<a href="%s">%s</a>', $href, htmlspecialchars($text));
        }
	
        function nav_links($feed_obj=NULL, $args)
        {
            extract(RF_Page::view_args($args));

            $all_text = empty($search) ? (in_array($what, array('new', 'public')) ? "all {$what}" : 'all items')
                                       : "all with '{$search}'";
            $all_text .= empty($feed) ? '' : ', '.RF_Page::title_truncate(array('title' => $feed_obj->title));
            $all_text = ucwords($all_text);
            
            $links = array();

            if(!empty($when)) {

                $whendate = ($when == 'today')
                    ? date('Y/m/d', time() - (REF_TIME_OFFSET * 60 * 60))
                    : $when;
                
                $begin = strtotime($whendate) + (REF_TIME_OFFSET * 60 * 60);
                $end = $begin + (24 * 60 * 60);
                
                $tomorrow = date('Y/m/d', $begin + (24 * 60 * 60));
                $yesterday = date('Y/m/d', $begin - (24 * 60 * 60));
                
                $links[] = RF_Page::link_page("<< {$yesterday}", merge_hash($args, array('when' => $yesterday)));
                $links[] = RF_Page::link_page("{$all_text}", merge_hash($args, array($when => '')));
                                    
                if($when != "today") {
                    $links[] = RF_Page::link_page("Today", merge_hash($args, array('when' => 'today')));
                    $links[] = RF_Page::link_page("{$tomorrow} >>", merge_hash($args, array('when' => $tomorrow)));
                }
                
            } elseif(!empty($how) && $how == "paged") {

                $limit = $howmany;
                $start = $offset;
                
                $earlier = $start + $limit;
                $later = $start - $limit;
 
                $links[] = RF_Page::link_page("<< Older {$limit}", merge_hash($args, array('offset' => $earlier, 'howmany' => $limit)));
                $links[] = RF_Page::link_page("{$all_text}", merge_hash($args, array('how' => '', 'offset' => '', 'limit' => '')));
                                    
                if($later >= 0) {
                    $links[] = RF_Page::link_page("Newest {$limit}", merge_hash($args, array('offset' => $which, 'howmany' => $limit)));
                    $links[] = RF_Page::link_page("Newer {$limit} >>", merge_hash($args, array('offset' => $later, 'howmany' => $limit)));
                }
                
            } else {

                return '';

            }
            
            return join(' ', array_map(create_function('$l', 'return "<li>$l</li>";'), $links));
        }
        
        function relative_date($timestamp)
        {
            $diff = time() - $timestamp;
            $diffstr = '???';

            if($seconds = $diff)
                $diffstr = sprintf('%d second%s ago', $seconds, (($seconds != 1) ? 's' : ''));
            
            if($minutes = round($diff / 60))
                $diffstr = sprintf('%d minute%s ago', $minutes, (($minutes != 1) ? 's' : ''));
            
            if($hours = round($diff / 60 / 60))
                $diffstr = sprintf('%d hour%s ago', $hours, (($hours != 1) ? 's' : ''));
            
            if($days = floor($diff / 60 / 60 / 24))
                $diffstr = date('F j, Y, H:i', $timestamp);
        
            return $diffstr;
            // date_format:"%b %e, %Y, %H:%M"
        }

        function hilight_search_terms($content)
        {
            if(!empty($_SESSION['search']) && preg_match_all('/\b[\-\+]?\S+\b/', $_SESSION['search'], $matches)) {
                foreach($matches[0] as $term) {
                    $term = preg_quote($term);
                    $content = preg_replace("/\b({$term})\b/Uis", '<span class="search-term">\1</span>', $content);

                    // if we accidentally dropped any span's inside a tag, they ought to be removed
                    while(preg_match('#(<[^>]+)<span class="search-term">([^<]+)</span>#', $content))
                        $content = preg_replace('#(<[^>]+)<span class="search-term">([^<]+)</span>#', '\1\2', $content);
                }
            }

            return $content;
        }

        function balance_tags($text)
        {

# commented out because this was an experiment
#
#            return strip_tags($text,  '<a><img>'
#                                    . '<b><i><u><big><small><strike>'
#                                    . '<p><h1><h2><h3><h4><h5><h6><blockquote>'
#                                    . '<strong><em>'
#                                   . '<code><cite><abbr><acronym><tt><pre><address>'
#                                    . '<br><hr>');
        
            $tagstack = array();
            $stacksize = 0;
            $tagqueue = '';
            $newtext = '';
            
            # WP bug fix for comments - in case you REALLY meant to type '< !--'
            $text = str_replace('< !--', '<    !--', $text);
            # WP bug fix for LOVE <3 (and other situations with '<' before a number)
            $text = preg_replace('#<([0-9]{1})#', '&lt;$1', $text);
            
            while(preg_match("/<(\/?\w*)\s*([^>]*)>/",$text,$regex)) {
                $newtext = $newtext . $tagqueue;
                
                $i = strpos($text,$regex[0]);
                $l = strlen($tagqueue) + strlen($regex[0]);
                
                // clear the shifter
                $tagqueue = '';
                // Pop or Push
                if($regex[1][0] == "/") { // End Tag
                    $tag = strtolower(substr($regex[1],1));
                    // if too many closing tags
                    if($stacksize <= 0) {
                        $tag = '';
                        //or close to be safe $tag = '/' . $tag;
                    }
                    // if stacktop value = tag close value then pop
                    elseif($tagstack[$stacksize - 1] == $tag) { // found closing tag
                        $tag = '</' . $tag . '>'; // Close Tag
                        // Pop
                        array_pop($tagstack);
                        $stacksize--;
                    } else { // closing tag not at top, search for it
                        for($j=$stacksize-1;$j>=0;$j--) {
                            if($tagstack[$j] == $tag) {
                                // add tag to tagqueue
                                for($k=$stacksize-1;$k>=$j;$k--) {
                                    $tagqueue .= '</' . array_pop($tagstack) . '>';
                                    $stacksize--;
                                }
                                break;
                            }
                        }
                        $tag = '';
                    }
                } else { // Begin Tag
                    $tag = strtolower($regex[1]);
                    
                    // Tag Cleaning
                    
                    // Push if not img or br or hr
                    if($tag != 'br' && $tag != 'img' && $tag != 'hr') {
                        $stacksize = array_push($tagstack, $tag);
                    }
                    
                    // Attributes
                    // $attributes = $regex[2];
                    $attributes = $regex[2];
                    if($attributes) {
                        $attributes = ' '.$attributes;
                    }
                    $tag = '<'.$tag.$attributes.'>';
                }
                $newtext .= substr($text,0,$i) . $tag;
                $text = substr($text,$i+$l);
            }
            
            // Clear Tag Queue
            $newtext = $newtext . $tagqueue;
            
            // Add Remaining text
            $newtext .= $text;
            
            // Empty Stack
            while($x = array_pop($tagstack)) {
                $newtext = $newtext . '</' . $x . '>'; // Add remaining tags to close
            }
            
            // WP fix for the bug with HTML comments
            $newtext = str_replace("< !--","<!--",$newtext);
            $newtext = str_replace("<    !--","< !--",$newtext);
            
            return $newtext;
        }

	function render_feed_link($feed)
	{
	  $link = htmlspecialchars($feed->link);
	  $description = htmlspecialchars($feed->description);
	  $title = htmlspecialchars($feed->title);
	  $url = htmlspecialchars($feed->url);
	  
	  $s = "<b><a href=\"$link\" title=\"$description\">$title</a></b> ";
	  $s .= "<a href=\"$url\">(rss)</a>";
	  
	  return $s;
	}



    }

?>
