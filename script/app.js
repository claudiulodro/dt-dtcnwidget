/*----------------------------------------
$Id: app.js,v 1.10 2005/06/02 02:13:57 mfrumin Exp $
vim: ts=4 foldcolumn=4 foldmethod=marker

This file is part of Reblog: http://reblog.org
A derivative work of Feed On Feeds: http://feedonfeeds.com

Distributed under the Gnu Public License, see LICENSE

Copyright ©2004 Michael Frumin, Michal Migurski
mike@stamen.com, http://stamen.com
mfrumin@eyebeam.org, http://eyebeam.org

app.js - Refeed.App is a controller object for client-side refeed
----------------------------------------*/

// namespace
if(window.refeed == null) { window.refeed = {}; }
if(Refeed == null) { var Refeed = window.refeed; }

Refeed.App = new Object();

Refeed.App.listed_things = new Array();
Refeed.App.selected_thing = null;

Refeed.App.items_href = null;
Refeed.App.use_kb = true;

Refeed.App.add_list_thing = function(thing) {
  added_list_thing(thing);
  this.listed_things.push(thing);
}

Refeed.App.open_link = function(link, new_window) {

  if(new_window && link) {
    window.open(link);
    return false;
    
  } else if(link && document.framed) {
    top.frames['items'].location.href = link;
    return false;
    
  } else if(link) {
    location.href = link;
    return false;    
  }

  return true;
}


Refeed.App.select_thing = function(thing) {
  
  if(this.selected_thing) {
    if(this.selected_thing.onBlur) {
      this.selected_thing.onBlur(null);
    }
  }
  
  if(thing == null) {
    this.selected_thing = null;
    
    return;
  }
  
  this.selected_thing = thing;
  
  if(this.selected_thing.onFocus) {
    this.selected_thing.onFocus(null);
  }
  
  if(this.selected_thing.scrollIntoView) {
    this.selected_thing.scrollIntoView();
  }
}

Refeed.App.onKeyPress = function(event) {

  var target = Refeed.App.get_target(event);
  var keycode = Refeed.App.get_keycode(event);

  if(!(event && target && keycode)) {
    //WTF
    //alert("NO STUFF");
    return true;
  }
  
  
  if(target.nodeName == 'INPUT' || target.nodeName == 'TEXTAREA') {
    // don't process key events that occur on form inputs
    return true;
  }

  if(keycode == 47) {
    // /: 47, toggle keyboard stuff
    this.toggleKB();
    return false;

  } else if(keycode == 63) {
    // ?: 63, toggle cheat sheet
    toggle_cheatsheet();
    return false;

  }
  
  if(!this.use_kb) {
    return true;
  }
  
  if(this.selected_thing && this.selected_thing.onKeyPress) {
    if(! this.selected_thing.onKeyPress(event)) {
      return false;
    }
  }
  
  return this.handle_keypress(target, keycode);
}


Refeed.App.toggleKB = function() {
    this.use_kb = !this.use_kb;
    Refeed.ServerComm.queueRequest({action:'set-use-kb', flag: (this.use_kb ? 1 : 0)}, {});
    toggle_kb_indicator(this.use_kb)    
}

Refeed.App.handle_keypress = function(target, keycode)
{

  //alert('Refeed.App::onKeyPress::key code: '+keycode);

  if(keycode == 44 || keycode == 46) {
    // ,: 44, jump up one feed/item
    // .: 46, jump down one feed/item
    
    var dPos = 0;
    if(keycode == 44) {
      dPos = -1;
    } else if(keycode == 46) {
      dPos = 1;
    }
    
    return this.doScroll(dPos);

  } else if(keycode == 114) {
    // r: 114, reload page
    
    location.reload(true);
    return false;
    
  } else if(keycode == 102) {
    // f: 102, back to feed list
    
    if(document.framed) {
      if(top.frames['feeds'].has_focus) {
        location.reload(true);
      } else {
        top.frames['feeds'].focus();
      
      }

    } else {
      location.href = './';

    }

    return false;
    
  } else if(keycode == 105) {
    // i: 105, new items, paged
    
    if(document.framed) {
      if(top.frames['items'].has_focus) {
        location.reload(true);
      } else {
        top.frames['items'].focus();
      
      }

    } else if(this.items_href) {
      location.href = this.items_href;

    }
    
    return false;

  } else if(keycode == 32) {
     // space: 32, switch between frames

    if(document.framed) {
        if(!top.frames['items'].has_focus) {
            top.frames['items'].focus();
        
        } else if(!top.frames['feeds'].has_focus) {
            top.frames['feeds'].focus();

        }
        
        return false;
    }

  } else if(keycode == 65) {
     // A: 65, archive all shown items

    this.archiveAll();
    return false;
    
  }
  
  return true;
}

Refeed.App.archiveAll = function() {
    var params = new Array();
    
    for(var i in this.listed_things) {
        if(this.listed_things[i] instanceof Refeed.Item) {
            params.push('ids[]='+this.listed_things[i].id);
        }
    }

    if((params.length > 0) && confirm('Archive everything ('+params.length+' items) -- are you sure?')) {
        params.push('action=mark-items-read');
        params.push('return='+escape(location.href));

        var script = 'do.php';
        if(document.framed) {
            script = '../'+script;
        }

        location.href = script+'?'+params.join('&');
    }
}

Refeed.App.doScroll = function(dPos) {
  
  if(this.listed_things.length == 0) {
    return false;
  }

  var doc_size = Refeed.App.getDocSize();

  var sel_thing = null;

  if((!(this.atBottom() || this.atTop())) && (this.selected_thing == null || (!this.selected_thing.isVisible()))) {

    sel_thing = this.searchForVisible(dPos);
  }
  else {

    var pos = (this.selected_thing ? Refeed.App.array_index_of(this.listed_things, this.selected_thing) : -1);
    
    var new_pos = pos + dPos;
    
    if(new_pos < 0 || new_pos >= this.listed_things.length) {
      if(this.selected_thing == null) {
	if(new_pos < 0) {
	  sel_thing = this.listed_things[this.listed_things.length - 1];
	}
	else {
	  sel_thing = this.listed_things[0];
	}
      }
      else {
	this.select_thing(null);
	if(new_pos < 0) {
	  window.scrollTo(0, 0);
	}
	else {
	  window.scrollTo(0, doc_size.y);
	}
      }
    }
    else {
      sel_thing = this.listed_things[new_pos];
    }
  }

  this.select_thing(sel_thing);
  
  return false;
}

Refeed.App.searchForVisible = function(dir) {

  //  alert("Searching for Visible: " + dir);

  for(var i = (dir > 0 ? 0 : this.listed_things.length - 1); i >= 0 && i <= this.listed_things.length - 1; i += dir) {
    var thing = this.listed_things[i];
    if(thing.isVisible()) {
      return thing;
    }
  } 

  return null;
}

Refeed.App.atTop = function() {
  return (Refeed.App.getScrollXY().y <= 0);
}

Refeed.App.atBottom = function() {
  return (Refeed.App.getScrollXY().y >= Refeed.App.getDocSize().y - Refeed.App.getWindowSize().y);
}



///////////// Static Refeed.App Helpers ///////////////////////

Refeed.App.array_index_of = function(array, thing) {
  for(var i = 0; i < array.length; i++) {
    if(array[i] == thing) {
      return i;
    }
  }
  
  return null;
  
}

Refeed.App.registerHandler = function(to, from, handler) {
//	alert("registerHandler: " + handler + " for " + from + " maps to " + to);
	 
  from[handler.toLowerCase()] = function(e) {
    e = Refeed.App.get_event(e);
    var target = Refeed.App.get_target(e);
    return (to[handler] ? to[handler](e) : true);
  }
  from[handler] = from[handler.toLowerCase()];
}


Refeed.App.get_event = function(e) {
  var event = null;
  
    if(e) {
      event = e;
    } else {
      event = window.event;
    }
  
  return event;
}    

Refeed.App.get_target = function(event) {
  
  if(!event) {
    return null;
  }
  
  var target = null;
  
  if(event.target) {
    //alert('event.target: '+event.target+', node name: '+event.target.nodeName);
    target = event.target;
  } else if(event.srcElement) {
    //alert('event.srcElement: '+event.srcElement+', node name: '+event.srcElement.nodeName);
    target = event.srcElement;
  }
  
  return target;
}

Refeed.App.get_keycode = function(event) {
  
  if(!event || event.ctrlKey || event.metaKey) {
    return null;
  }
  
  var keycode = null;
  
  if(event.keyCode) {
    keycode = event.keyCode;
    //alert('event.keyCode: '+event.keyCode);
    } else if(event.which) {
      keycode = event.which;
      //alert('event.which: '+event.which);
    }
  
  return keycode;
}



Refeed.App.hilight_node = function(node) {
  node.className = node.className.replace(/_hilight_(on|off)\b/, '_hilight_on');
}

Refeed.App.unhilight_node = function(node) {
  node.className = node.className.replace(/_hilight_(on|off)\b/, '_hilight_off');
}


Refeed.App.getWindowSize = function() {
  var W = 0, H = 0;
  
  if( typeof( window.innerWidth ) == 'number' ) {
    //Netscape compliant
    H = window.innerHeight;
    W = window.innerWidth;
  } else if( document.documentElement &&
	     ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
	       //IE6 standards compliant mode
	       H = document.documentElement.clientHeight;
	       W = document.documentElement.clientWidth;
	     } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
	       //DOM compliant
	       H = document.body.clientHeight;
	       W = document.body.clientWidth;
	     }
  return new Refeed.Coord(W, H);
  
  
}

Refeed.App.getDocSize = function() {
  return new Refeed.Coord(document.body.offsetWidth, document.body.offsetHeight);
}

Refeed.App.getScrollXY = function() {
  var scrOfX = 0, scrOfY = 0;
  if( typeof( window.pageYOffset ) == 'number' ) {
    //Netscape compliant
    scrOfY = window.pageYOffset;
    scrOfX = window.pageXOffset;
  } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
    //DOM compliant
    scrOfY = document.body.scrollTop;
    scrOfX = document.body.scrollLeft;
  } else if( document.documentElement &&
	     ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
	       //IE6 standards compliant mode
	       scrOfY = document.documentElement.scrollTop;
	       scrOfX = document.documentElement.scrollLeft;
	     }
  return new Refeed.Coord(scrOfX, scrOfY);
}

Refeed.App.isClickHandled = function(e, container) {

  var target = Refeed.App.get_target(e);

  for(var n = target; (container != null && n != container) && n != null; n = n.parentNode) {
    if(n.nodeName == 'A' || n.nodeName == 'INPUT' || n.onclick || n.onClick) {
      return n;
    }
  }

  return null;

}
