/*----------------------------------------
$Id: item.js,v 1.4 2005/05/10 00:18:21 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

item.js - Refeed.Item represents a single item div
----------------------------------------*/

// namespace
if(window.refeed == null) { window.refeed = {}; }
if(Refeed == null) { var Refeed = window.refeed; }

Refeed.Item = function(id, node, link, new_window) {
  
  this.setNode(node);
  this.link = link;
  this.new_window = new_window;
  this.id = id;
  
  Refeed.App.registerHandler(this, this.node, 'onClick');
  
  //	Refeed.App.registerHandler(this.node, this, 'scrollIntoView');
  
  // actually, can only get from the Refeed.App because the node is a DIV
  //	Refeed.App.registerHandler(this, this.node, 'onFocus');
  //	Refeed.App.registerHandler(this, this.node, 'onBlur');
}

Refeed.Item.prototype = new Refeed.ListItem;

Refeed.Item.prototype.onClick = function(e) {
  //	alert("Refeed.Item::onClick ON " + this + " WITH EVENT: " + e + " FOR ID: " + this.id);

  Refeed.App.select_thing(this);
}

Refeed.Item.prototype.onFocus = function(e) {
  Refeed.App.hilight_node(this.getNode());
}

Refeed.Item.prototype.onBlur = function(e) {
  Refeed.App.unhilight_node(this.getNode());
}

Refeed.Item.prototype.onKeyPress = function(event) {

    var target = Refeed.App.get_target(event);
    var keycode = Refeed.App.get_keycode(event);
    
    if(!(event && target && keycode)) {
        //WTF
        return true;
    }

    if((keycode == 97)) {
        // a: 97, toggle archive
        
        toggle_read(this.id);
        return false;

    } else if(keycode == 99) {
        // c: 99, comment form

        toggle_inline_form(this.id, 'comment');

        return false;
    } else if(0 && keycode == 116) {
        // ALSO F5 ?!??!?!!?
        // t: t, tag form

        toggle_inline_form(this.id, 'subjects');

        return false;

    } else if(keycode == 112) {
        // p: 112, toggle publish
        
        toggle_public('item', this.id);
        return false;
    
    } else if((keycode == 13) || (keycode == 3)) {
        // enter: 13, open link
        // return: 13, open link
        
        return Refeed.App.open_link(this.link, this.new_window);
    
    } else if((keycode >= 48) && (keycode <= 57)) {
        // 0-9: 48-57, select a link
        
      if(event.altKey || event.ctrlKey) {

          var link = get_item_link(this.id, keycode - 48);

          if(link) {
              return Refeed.App.open_link(link.href, this.new_window);
          }
      }
      else {
        return link_select(this.id, (keycode - 48));
      }        
    }
    
    //alert('Refeed.Item::onKeyPress::key code: '+keycode);
    return true;
}

Refeed.Item.prototype.toggleRead = function(read)
{
    if(read) {
        Refeed.ServerComm.queueRequest({action:'mark-item-read', id:this.id}, {object:this, method:'onMarkRead', argument:null});

    } else {
        Refeed.ServerComm.queueRequest({action:'mark-item-unread', id:this.id}, {object:this, method:'onMarkUnread', argument:null});

    }
}

Refeed.Item.prototype.onMarkRead = function() { toggled_read(this.id, true); }
Refeed.Item.prototype.onMarkUnread = function() { toggled_read(this.id, false); }

Refeed.Item.prototype.selectLink = function(link)
{
    Refeed.ServerComm.queueRequest({action:'link-select', id:this.id, link:link}, {object:this, method:'onSelectedLink', argument:link});
}

Refeed.Item.prototype.onSelectedLink = function(link)
{   
    this.link = link;
    link_selected(this.id, this.link);
}

Refeed.Item.prototype.togglePublic = function(publish)
{
    var req = {id:this.id};
    
    if(publish) {
        req.action = 'mark-item-public';
        Refeed.ServerComm.queueRequest(req, {object:this, method:'onMarkPublic', argument:null});

    } else {
        req.action = 'mark-item-private';
        Refeed.ServerComm.queueRequest(req, {object:this, method:'onMarkPrivate', argument:null});
    }
}

Refeed.Item.prototype.submitValues = function(req) {
    req.action = 'submit-item-values';
    Refeed.ServerComm.queueRequest(req, {object:this, method:'onValuesSubmitted', argument:req});
}

Refeed.Item.prototype.onValuesSubmitted = function(req) { 

    toggle_inline_form(this.id); 

    if(req._public) {
        toggled_public('item', this.id, true);
    }

}



Refeed.Item.prototype.onMarkPublic = function() { toggled_public('item', this.id, true); }
Refeed.Item.prototype.onMarkPrivate = function() { toggled_public('item', this.id, false); }
