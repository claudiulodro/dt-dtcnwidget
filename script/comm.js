/*----------------------------------------
$Id: comm.js,v 1.4 2005/05/13 23:40:32 mfrumin Exp $
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

Refeed.ServerComm = new Object();

Refeed.ServerComm.requests = new Array();
Refeed.ServerComm.request = 0;

Refeed.ServerComm.queueRequest = function(request, callback)
{
    var get_vars = new Array();
    
    for(var key in request) {
        get_vars.push(escape(key)+'='+escape(request[key]));
    }
    
    var script = 'do.php';
    if(document.framed) {
        script = '../'+script;
    }

    script += '?'+get_vars.join('&')+'&c='+(Refeed.ServerComm.request++);

    var request;
    var is_IE = 0;

    if (window.XMLHttpRequest) {
        request = new XMLHttpRequest();

        // branch for IE/Windows ActiveX version
    } else if (window.ActiveXObject) {
        is_IE = 1;
        request = new ActiveXObject("Microsoft.XMLHTTP");
    }

    if(request) {
        request.onreadystatechange = function()
        {
            if(request.readyState == 4) {
                if(request.status == '200') {
                    if(callback.object && callback.method) {
                        callback.object[callback.method](callback.argument);                
                    }
                }
            }
        };

        request.open("GET", script, true);
    }

    if(is_IE) {
        request.send();
    }
    else {
        request.send(null);
    }
    

}

// message broadcasting, not currently used

Refeed.AppComm = function()
{
    this.listeners = new Array();
}

Refeed.AppComm.prototype.addListener = function(listener)
{
    for(var l in this.listeners) {
        if(this.listeners[l] == listener) {
            return false;
        }
    }
    
    this.listeners.push(listener);
    return true;
}

Refeed.AppComm.prototype.removeListener = function(listener)
{
    for(var l in this.listeners) {
        if(this.listeners[l] == listener) {
            this.listeners.splice(l, 1);
            return true;
        }
    }
    
    return false;
}

Refeed.AppComm.prototype.broadcastMessage = function(message)
{
    var args = new Array(); // array of arguments to pass through
    var listeners = this.listeners.concat(); // just in case a listener were to affect this.listeners in any way
    
    for(var a = 1; a < arguments.length; a++) {
        args.push(arguments[a]);
    }

    for(var l in listeners) {
        if(listeners[l][message] instanceof Function) {
            listeners[l][message].apply(listeners[l], args);
        }
    }
}
