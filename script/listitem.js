// namespace
if(window.refeed == null) { window.refeed = {}; }
if(Refeed == null) { var Refeed = window.refeed; }

Refeed.ListItem = function() {
  this.node = null;
  this.node_x = null;
  this.node_y = null;
}

Refeed.ListItem.prototype.getNode = function() {
  return this.node;
}

Refeed.ListItem.prototype.setNode = function(node) {
  this.node = node;
  node.listItem = this;
}

Refeed.ListItem.prototype.isVisible = function() {
  var scroll_coord = Refeed.App.getScrollXY();
  var node_coord = this.getNodeOffset();
  
  
  var max_y = scroll_coord.y + Refeed.App.getWindowSize().y;
  var node_max_y = node_coord.y + this.getNodeSize().y;
  
  return (node_coord.y >= scroll_coord.y && node_coord.y <= max_y
	  || node_max_y >= scroll_coord.y && node_max_y <= max_y
	  );
} 

Refeed.ListItem.prototype.isFullyVisible = function() {
  var scroll_coord = Refeed.App.getScrollXY();
  var node_coord = this.getNodeOffset();
  
  var max_y = scroll_coord.y + Refeed.App.getWindowSize().y;
  var node_max_y = node_coord.y + this.getNodeSize().y;
  
  return (node_coord.y >= scroll_coord.y && node_max_y <= max_y);
}

Refeed.ListItem.prototype.getNodeSize = function()
{
    var height = 0;
    var width = 0;

    if(this.getNode().nodeName == 'TR') {
        // in Safari, table rows have no offsetWidth/Height/Left/Right defined, 
        // so we will have to base these values on the contained table cells.
        for(var startingNode = this.getNode().firstChild; startingNode.nodeName != 'TD'; startingNode = startingNode.nextSibling) { continue; }

        for(var TD = startingNode; TD; TD = TD.nextSibling) {
            if(TD.nodeName == 'TD') {
                height = Math.max(height, TD.offsetHeight);
                width += TD.offsetWidth;
            }
        }
    } else {
        height = this.getNode().offsetHeight;
        width = this.getNode().offsetWidth;
    }
    
    return new Refeed.Coord(width, height);
}

Refeed.ListItem.prototype.getNodeOffset = function()
{
    /*
    if(this.node_x != null && this.node_y != null) {
        return new Refeed.Coord(this.node_x, this.node_y);
    }
    */
    
    var x = 0;
    var y = 0;
    
    if(this.getNode().nodeName == 'TR') {
        // in Safari, table rows have no offsetWidth/Height/Left/Right defined, 
        // so we will have to base these values on the contained table cells.
        for(var startingNode = this.getNode().firstChild; startingNode.nodeName != 'TD'; startingNode = startingNode.nextSibling) { continue; }
        
        for(var node = startingNode; node; node = node.offsetParent) {
            x += node.offsetLeft;
            y += node.offsetTop;
        }
    } else {
        for(var node = this.getNode(); node; node = node.offsetParent) {
            x += node.offsetLeft;
            y += node.offsetTop;
        }
    }
    
    /*
    this.node_x = x;
    this.node_y = y;
    */
    
    return new Refeed.Coord(x,y);
}

Refeed.ListItem.prototype.scrollIntoView = function() {
	if(!this.isFullyVisible()) {
	  var scroll_coord = Refeed.App.getScrollXY();
	  var win_size = Refeed.App.getWindowSize();
	  var node_coord = this.getNodeOffset();
	  var node_size = this.getNodeSize();
	  
	  var max_y = scroll_coord.y + win_size.y;
	  var node_max_y = node_coord.y + node_size.y;
	  
	  if(node_max_y > max_y) {
	    var scroll_to = node_coord.y - (win_size.y - node_size.y);
	    window.scrollTo(0, (scroll_to <= node_coord.y ? scroll_to : node_coord.y) );
	  } else if(node_coord.y < scroll_coord.y) {
	    window.scrollTo(0, node_coord.y);
	  }
	}
}

Refeed.ListItem.prototype.togglePublic = function()
{
    alert('calling listItem stub togglePublic');
}
