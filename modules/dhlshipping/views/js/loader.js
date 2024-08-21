/**
*  @author   DHL Italy <dhlecommerceshipping.it@dhl.com>
*  @copyright 2018 DHL Italy
*  @license  http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

GspedLoader = function() {
    this.initialize.apply(this, arguments);
};

GspedLoader.prototype = {

    initialize : function(externalJsUrl) {
        this.urlJs = externalJsUrl;
        this.platform = null;
        this.loadJs();
    },

    loadJs: function() {
        var url = this.generateUniqueUrl(this.urlJs);
        this.addScriptInPage(url, this.afterLoadExternalJs.bind(this));
    },

    generateUniqueUrl : function(url) {
        var uniqueId = Date.now();
        return url + '?' + uniqueId;
    },

    addScriptInPage : function(url, callback) {
        var script = document.createElement("script");
        script.id = "gsped_script_src";
        script.type = "text/javascript";

        if (script.readyState){  //IE
            script.onreadystatechange = function() {
                if (script.readyState == "loaded" ||
                    script.readyState == "complete") {
                    script.onreadystatechange = null;
                    callback();
                }
            };
        } else {  //Others
            script.onload = callback;
        }
        script.src = url;
        document.getElementsByTagName("head")[0].appendChild(script);
    },

    // Here we can use the external library
    afterLoadExternalJs: function(){
        if (typeof GspedJs != 'undefined' && typeof GspedJs.Platform != 'undefined' ) {
            var GspedData = document.GspedData ||  {};
            this.platform = new GspedJs.Platform(GspedData);
        }
    }
};

$(document).ready(function() {
  var endpoint = 'https://plugin-ecommerce.gsped.it/v2/prestashop/bundle.js';
  var match = document.cookie.match(new RegExp('OVERRIDE_GSPED_ENDPOINT=([^;]+)'));
  if (match) {
    endpoint = match[1];
  }
  var gspedLoader = new window.GspedLoader(endpoint);
});
