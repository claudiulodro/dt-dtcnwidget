/*----------------------------------------
$Id: feed.js,v 1.2 2005/04/19 22:47:20 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

feed.js - Refeed.Feed represents a single feed row
----------------------------------------*/

// namespace
if(window.refeed == null) { window.refeed = {}; }
if(Refeed == null) { var Refeed = window.refeed; }

Refeed.Feed = function(id, node, link) {
  this.id = id;
  this.setNode(node);
  this.link = link;
  
  Refeed.App.registerHandler(this, this.node, 'onClick');
  
  //	Refeed.App.registerHandler(this.node, this, 'scrollIntoView');
  
  // actually, can only get from the Refeed.App because the node is a DIV
  //	Refeed.App.registerHandler(this, this.node, 'onFocus');
  //	Refeed.App.registerHandler(this, this.node, 'onBlur');

}

Refeed.Feed.prototype = new Refeed.ListItem;

Refeed.Feed.prototype.onClick = function(e) {
  //	alert("Refeed.Feed::onClick ON " + this + " WITH EVENT: " + e + " FOR ID: " + this.id);
  Refeed.App.select_thing(this);
}

Refeed.Feed.prototype.onFocus = function(e) {
  Refeed.App.hilight_node(this.getNode());
}

Refeed.Feed.prototype.onBlur = function(e) {
  Refeed.App.unhilight_node(this.node);
}

Refeed.Feed.prototype.onKeyPress = function(event) {
  
  var target = Refeed.App.get_target(event);
  var keycode = Refeed.App.get_keycode(event);
  
  if(!(event && target && keycode)) {
    //WTF
    return true;
  }
  
  if((keycode == 97)) {
    // a: 97, toggle archive
    
    return this.archive();
    
  }else if(keycode == 112) {
    // p: 112, toggle publish

    toggle_public('feed',this.id);
    return false;
    
  } else if(keycode == 117) {
    // u: 117, update feed
    
    return this.update();
    
  } else if((keycode == 13) || (keycode == 3)) {
    // enter: 13, open link
    // return: 13, open link
    
    return Refeed.App.open_link(this.link, false);
  }
  
  //alert('Refeed.Feed::onKeyPress::key code: '+keycode);
  return true;
}

Refeed.Feed.prototype.archive = function()
{
    var script = 'do.php';
    if(document.framed) {
        script = '../'+script;
    }

    location.href = script+'?action=mark-feed-read&return='+escape(location.href)+'&feed='+this.id;
    return false;
}

Refeed.Feed.prototype.update = function()
{
    var script = 'update.php';
    if(document.framed) {
        //script = '../'+script;
        
        return true;
    }

    location.href = script+'?return='+escape(location.href)+'&feed='+this.id;
    return false;
}

Refeed.Feed.prototype.togglePublic = function(publish)
{
    if(publish) {
        Refeed.ServerComm.queueRequest({action:'mark-feed-public', id:this.id}, {object:this, method:'onMarkPublic', argument:null});

    } else {
        Refeed.ServerComm.queueRequest({action:'mark-feed-private', id:this.id}, {object:this, method:'onMarkPrivate', argument:null});

    }
}

Refeed.Feed.prototype.onMarkPublic = function() { toggled_public('feed', this.id, true); }
Refeed.Feed.prototype.onMarkPrivate = function() { toggled_public('feed', this.id, false); }
