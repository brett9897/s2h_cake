/* This file contains global functions and variables for all JS scripts to use. */

//This is a fix for trim not existing in some versions of IE
if(!String.prototype.trim) {
  String.prototype.trim = function () {
    return this.replace(/^\s+|\s+$/g,'');
  };
}


global = {
		//parse url
		base_url: location.href.substr(0, location.href.indexOf('/')) + "//" + location.host + location.pathname.substr(0, location.pathname.indexOf('/', 2))
};