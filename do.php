<?php
/*----------------------------------------
$Id: do.php,v 1.6 2005/05/13 23:40:32 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

...
----------------------------------------*/

    $SUPPRESS_INSTALL_VERIFY = 1;
    require_once('init.php');
    
    function respond($response)
    {
        if(!empty($_GET['return']))
            header("Location: {$_GET['return']}");

        print($response);
        exit;
    }

    if(!empty($_GET['id']) || !empty($_GET['ids']) || !empty($_GET['feed']) || !is_null($_GET['flag']))
        switch($_GET['action']) {
        
            case 'mark-feed-private':
                RF_FeedSelect::_mark_public($_GET['id'], false);
                respond('ok');
        
            case 'mark-feed-public':
                RF_FeedSelect::_mark_public($_GET['id'], true);
                respond('ok');
        
            case 'mark-item-private':
                RF_ItemSelect::_mark_public($_GET['id'], false);
                respond('ok');
        
            case 'mark-item-public':
                RF_ItemSelect::_mark_public($_GET['id'], true);    
                respond('ok');
        
            case 'mark-item-read':
            case 'mark-items-read':
                if(!empty($_GET['ids'])) {
                    RF_ItemSelect::_mark_all_read(true, null, $_GET['ids'], true);
                } elseif(!empty($_GET['id'])) {
                    RF_ItemSelect::_mark_read($_GET['id'], true);
                } else {
                    RF_ItemSelect::_mark_all_read(true, 'all', null, true);
                }

                respond('ok');
        
            case 'mark-item-unread':
                RF_ItemSelect::_mark_read($_GET['id'], false);
                respond('ok');
        
            case 'mark-feed-read':
                RF_ItemSelect::_mark_all_read(true, $_GET['feed'], null, true);
                respond('ok');
        
            case 'link-select':
                RF_ItemSelect::_select_link($_GET['id'], $_GET['link']);
                respond('ok');

            case 'submit-item-values':
                $args = array();
                foreach(array('_public', 'comment', 'subjects') as $f) {
                    if(isset($_GET[$f])) {
                        $args[preg_replace('/^\_+/', '', $f)] = $_GET[$f];
                    }
                }
                
                RF_ItemSelect::_submit_values($_GET['id'], $args);
                                                  
                respond('ok');

             case 'set-use-kb':
                 $_SESSION['use_kb'] = $_GET['flag'];
                 respond('ok');
     
            default:
                respond('unknown action');

        }
        
    respond('no ID');

?>
