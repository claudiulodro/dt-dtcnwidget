function feeds_delayed_reload()
{
    if(top.frames['feeds']) {
        top.frames['feeds'].clearTimeout(top.frames['feeds'].delayed_reload);
        top.frames['feeds'].delayed_reload = top.frames['feeds'].setTimeout('location.reload();', 25000);
    }
}

function get_item_link_select(item_id, link_index) 
{
  return document.getElementById('linkSelect' + item_id + '-' + link_index);
}

function get_item_link(item_id, link_index) 
{
  return document.getElementById('itemLink' + item_id + '-' + link_index);
}

function link_select(item_id, link) 
{
    var item = document.getElementById('item' + item_id);
    
    if((typeof link == 'string')) {
        link = link.replace(/(http:\/\/[^\/]+)\/$/, '$1'); 
        // it seems to be necessary to drop the trailing slash, at least for Apple's Safari; except that this breaks the whole thing because it can't match links when they are not the same (i.e. the slash is missing)

        item.listItem.selectLink(link);
    	return false;
    } else if(typeof link == 'number') {
        var link = get_item_link_select(item_id, link);
        
        if(link) {
            var href = link.href;
            href = href.replace(/(http:\/\/[^\/]+)\/$/, '$1'); 
            // it seems to be necessary to drop the trailing slash, at least for Apple's Safari; except that this breaks the whole thing because it can't match links when they are not the same (i.e. the slash is missing)
            
            item.listItem.selectLink(href);
            return false;
        }
    }
    
    return true;
}

function link_selected(item_id, link)
{
    var item = document.getElementById('item' + item_id);
    var ancs = item.getElementsByTagName('A');
    
    for(var a = 0; a < ancs.length; a++) {
        if(ancs[a].className.match(/\blink-select\b/)) {
        
            var href = ancs[a].href;
            href = href.replace(/(http:\/\/[^\/]+)\/$/, '$1'); // it seems to be necessary to drop the trailing slash, at least for Apple's Safari; except that this breaks the whole thing because it can't match links when they are not the same (i.e. the slash is missing)

            if(href == link) {
                ancs[a].className = ancs[a].className.replace(/\blink-(un)?selected\b/, 'link-selected');

            } else {
                ancs[a].className = ancs[a].className.replace(/\blink-(un)?selected\b/, 'link-unselected');

            }
        }
    }
}

function toggle_read(item_id, framed)
{
    var a_priori = false;

    if(arguments.length >= 3) {
        if(arguments[2]) {
            a_priori = 'read';
        } else {
            a_priori = 'unread';
        }
    }

    var item = document.getElementById('item'+item_id);
    var imgB = document.getElementById('buttonRead'+item_id);

    imgB.src.search(/^(.+\/images\/).+/);
    imgB.src = RegExp.$1+'loading-item.gif';

    if(item.className.match(/\bunread/) && (!a_priori || (a_priori && (a_priori == 'read')))) {
        item.listItem.toggleRead(true);
        item.className = item.className.replace(/\b(unread|read-but-visible|read)\b/, 'read');

    } else if(item.className.match(/\bread/) && (!a_priori || (a_priori && (a_priori == 'unread')))) {
        item.listItem.toggleRead(false);
        item.className = item.className.replace(/\b(unread|read-but-visible|read)\b/, 'unread');

    } else {
        return true;

    }
    
    if(framed) { feeds_delayed_reload(); }
    
    return false;
}

function toggled_read(item_id, read)
{
    var item = document.getElementById('item'+item_id);
    var imgB = document.getElementById('buttonRead'+item_id);
    var ancC = document.getElementById('controlRead'+item_id);
    
    imgB.src.search(/^(.+\/images\/).+/);
    var imgDir = RegExp.$1;

    if(read) {
        //item.className = item.className.replace(/\b(unread|read-but-visible|read)\b/, 'read');
        imgB.src = imgDir+'read.gif';
        ancC.title = 'Mark this item unread';

    } else {
        //item.className = item.className.replace(/\b(unread|read-but-visible|read)\b/, 'unread');
        imgB.src = imgDir+'unread.gif';
        ancC.title = 'Mark this item read';

    }
}

function toggle_public(which, id, framed)
{

    var thing = document.getElementById(which+id);
    var imgB = document.getElementById('buttonPublic'+id);
    
    imgB.src.search(/^(.+\/images\/).+/);
    imgB.src = RegExp.$1+'loading-'+which+'.gif';

    if(thing.className.match(/\bprivate/)) {
        thing.listItem.togglePublic(true);

    } else if(thing.className.match(/\bpublic/)) {
        thing.listItem.togglePublic(false);

    } else {
        return true;

    }

    if(framed) { feeds_delayed_reload(); }
    
    return false;
}

function toggled_public(which, id, published)
{

    var thing = document.getElementById(which+id);
    var imgB = document.getElementById('buttonPublic'+id);
    var ancC = document.getElementById('controlPublic'+id);
    
    imgB.src.search(/^(.+\/images\/).+/);
    var imgDir = RegExp.$1;

    if(published) {
        thing.className = thing.className.replace(/(public|private)/, 'public');
        imgB.src = imgDir+'public-'+which+'.gif';

        if(which == 'feed') {
            ancC.title = 'Mark future items in this '+which+' private';

        } else {
            ancC.title = 'Mark this '+which+' private';

        }

    } else {
        thing.className = thing.className.replace(/(public|private)/, 'private');
        imgB.src = imgDir+'private-'+which+'.gif';

        if(which == 'feed') {
            ancC.title = 'Mark future items in this '+which+' public';

        } else {
            ancC.title = 'Mark this '+which+' public';

        }

    }
}

function submit_inline_form(item_id) {

    var node = document.getElementById('item'+item_id);    

    var req = {id: item_id};

    var comNode = document.getElementById('comment' + item_id);
    if(comNode) {
        req.comment = comNode.value;
    }
    
    var subNode = document.getElementById('subjects' + item_id);
    if(subNode) {
        req.subjects = subNode.value;
    }

    if(node.className.match(/\bprivate/)) {
        req._public = 1;
    }

    node.listItem.submitValues(req);

    return false;

}

function inline_clicked(item_id) {


}

function toggle_inline_form(item_id, focus_element_name)
{
    var form_node = document.getElementById('commentForm' + item_id);
    var element_names = new Array("comment", "subjects", "submit", "cancel");

    if(!form_node) {
        return;
    }

    if(form_node.style.display != 'block') {
        form_node.style.display = 'block';

        for(var e = 0; e < element_names.length; e += 1) {
            var element_node = document.getElementById(element_names[e] + item_id);
            if(element_node) {
                element_node.onkeypress = function(event)
                {
                    var target = Refeed.App.get_target(Refeed.App.get_event(event));
                    var keycode = Refeed.App.get_keycode(Refeed.App.get_event(event));

                    if(keycode == 27) {
                        // 'escape'
                        toggle_inline_form(item_id);
                        return false;
                    }

                    return true;
                };
            }
        }

        if(focus_element_name != undefined) {
            var input_node = document.getElementById(focus_element_name + item_id);
            if(input_node) {
                input_node.focus();
            }
        }
    } else {
        form_node.style.display = 'none';

        for(var e = 0; e < element_names.length; e += 1) {
            var element_node = document.getElementById(element_names[e] + item_id);
            if(element_node) {
                element_node.blur();
                element_node.onkeypress = null;
            }
        }
    }
}

function toggle_kb_indicator(show) {

    var node = document.getElementById('kb-indicator');
    if(node) {
        if(show) {
            node.style.display = 'block';
        }
        else {
            node.style.display = 'none';
        }
    }
}

function position_kb_indicator() {
    /*
    var node = document.getElementById('kb-indicator');
    if(node) {
        var scroll_coord = Refeed.App.getScrollXY();
        var doc_size = Refeed.App.getDocSize();
        var win_size = Refeed.App.getWindowSize();

        node.style.top = (scroll_coord.y + win_size.y - node.offsetHeight) + 'px';
        node.style.left = (scroll_coord.x + win_size.x - node.offsetWidth) + 'px';
    }
    */
}


function toggle_cheatsheet() {
    var scroll_coord = Refeed.App.getScrollXY();
    var doc_size = Refeed.App.getDocSize();
    var win_size = Refeed.App.getWindowSize();
    
    //    alert("SCROLL: (" + scroll_coord.x + "," + scroll_coord.y + ")" + " DOC: (" + doc_size.x + "," + doc_size.y + ")" + " WIN: (" + win_size.x + "," + win_size.y + ")" );
    
    var sheet = document.getElementById('cheatsheet');
    if(sheet) {
        if(sheet.style.display == 'none') {
            sheet.style.top = (scroll_coord.y + 25 ) + "px";
            sheet.style.display = 'block';
        } else {
            sheet.style.display = 'none';
        }
        return false;
    }
}


function toggle_focus(focus)
{
    var body = document.getElementsByTagName('body')[0];

    if(focus) {
        window.has_focus = true;
        body.className = body.className.replace(/\bbody-(focus|blur)\b/, 'body-focus');
    } else {
        window.has_focus = false;
        body.className = body.className.replace(/\bbody-(focus|blur)\b/, 'body-blur');

    }
}

function added_list_thing(list_item)
{
    var link_selects = list_item.node.getElementsByTagName('a');

    for(var ls = 0; ls < link_selects.length; ls++) {
        if(link_selects[ls].className.match(/\blink-select\b/)) {
            link_selects[ls].onclick = function() {
                if(this.id.match(/^linkSelect(\d+)-(\d+)$/)) {
                    link_select(RegExp.$1, this.href);
                }
                
                return false;
            };
        }
    }
}

window.onfocus = function() { toggle_focus(true); }
window.onblur = function() { toggle_focus(false); }

/*
document.onresize = function(event) { position_kb_indicator(); };
document.onscroll = function(event) { position_kb_indicator(); };
*/