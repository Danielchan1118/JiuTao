/**
 * SWFUpload: http://www.swfupload.org, http://swfupload.googlecode.com
 *
 * mmSWFUpload 1.0: Flash upload dialog - http://profandesign.se/swfupload/,  http://www.vinterwebb.se/
 *
 * SWFUpload is (c) 2006-2007 Lars Huring, Olov Nilz閚 and Mammon Media and is released under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 *
 * SWFUpload 2 is (c) 2007-2008 Jake Roberts and is released under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 *
 */


/* ******************* */
/* Constructor & Init  */
/* ******************* */
var SWFUpload;

/*	SWFObject v2.2 <http://code.google.com/p/swfobject/>
 is released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
 */
var swfobject = function(){var D="undefined",r="object",S="Shockwave Flash",W="ShockwaveFlash.ShockwaveFlash",q="application/x-shockwave-flash",R="SWFObjectExprInst",x="onreadystatechange",O=window,j=document,t=navigator,T=false,U=[h],o=[],N=[],I=[],l,Q,E,B,J=false,a=false,n,G,m=true,M=function(){var aa=typeof j.getElementById!=D&&typeof j.getElementsByTagName!=D&&typeof j.createElement!=D,ah=t.userAgent.toLowerCase(),Y=t.platform.toLowerCase(),ae=Y?/win/.test(Y):/win/.test(ah),ac=Y?/mac/.test(Y):/mac/.test(ah),af=/webkit/.test(ah)?parseFloat(ah.replace(/^.*webkit\/(\d+(\.\d+)?).*$/,"$1")):false,X=!+"\v1",ag=[0,0,0],ab=null;if(typeof t.plugins!=D&&typeof t.plugins[S]==r){ab=t.plugins[S].description;if(ab&&!(typeof t.mimeTypes!=D&&t.mimeTypes[q]&&!t.mimeTypes[q].enabledPlugin)){T=true;X=false;ab=ab.replace(/^.*\s+(\S+\s+\S+$)/,"$1");ag[0]=parseInt(ab.replace(/^(.*)\..*$/,"$1"),10);ag[1]=parseInt(ab.replace(/^.*\.(.*)\s.*$/,"$1"),10);ag[2]=/[a-zA-Z]/.test(ab)?parseInt(ab.replace(/^.*[a-zA-Z]+(.*)$/,"$1"),10):0}}else{if(typeof O.ActiveXObject!=D){try{var ad=new ActiveXObject(W);if(ad){ab=ad.GetVariable("$version");if(ab){X=true;ab=ab.split(" ")[1].split(",");ag=[parseInt(ab[0],10),parseInt(ab[1],10),parseInt(ab[2],10)]}}}catch(Z){}}}return{w3:aa,pv:ag,wk:af,ie:X,win:ae,mac:ac}}(),k=function(){if(!M.w3){return}if((typeof j.readyState!=D&&j.readyState=="complete")||(typeof j.readyState==D&&(j.getElementsByTagName("body")[0]||j.body))){f()}if(!J){if(typeof j.addEventListener!=D){j.addEventListener("DOMContentLoaded",f,false)}if(M.ie&&M.win){j.attachEvent(x,function(){if(j.readyState=="complete"){j.detachEvent(x,arguments.callee);f()}});if(O==top){(function(){if(J){return}try{j.documentElement.doScroll("left")}catch(X){setTimeout(arguments.callee,0);return}f()})()}}if(M.wk){(function(){if(J){return}if(!/loaded|complete/.test(j.readyState)){setTimeout(arguments.callee,0);return}f()})()}s(f)}}();function f(){if(J){return}try{var Z=j.getElementsByTagName("body")[0].appendChild(C("span"));Z.parentNode.removeChild(Z)}catch(aa){return}J=true;var X=U.length;for(var Y=0;Y<X;Y++){U[Y]()}}function K(X){if(J){X()}else{U[U.length]=X}}function s(Y){if(typeof O.addEventListener!=D){O.addEventListener("load",Y,false)}else{if(typeof j.addEventListener!=D){j.addEventListener("load",Y,false)}else{if(typeof O.attachEvent!=D){i(O,"onload",Y)}else{if(typeof O.onload=="function"){var X=O.onload;O.onload=function(){X();Y()}}else{O.onload=Y}}}}}function h(){if(T){V()}else{H()}}function V(){var X=j.getElementsByTagName("body")[0];var aa=C(r);aa.setAttribute("type",q);var Z=X.appendChild(aa);if(Z){var Y=0;(function(){if(typeof Z.GetVariable!=D){var ab=Z.GetVariable("$version");if(ab){ab=ab.split(" ")[1].split(",");M.pv=[parseInt(ab[0],10),parseInt(ab[1],10),parseInt(ab[2],10)]}}else{if(Y<10){Y++;setTimeout(arguments.callee,10);return}}X.removeChild(aa);Z=null;H()})()}else{H()}}function H(){var ag=o.length;if(ag>0){for(var af=0;af<ag;af++){var Y=o[af].id;var ab=o[af].callbackFn;var aa={success:false,id:Y};if(M.pv[0]>0){var ae=c(Y);if(ae){if(F(o[af].swfVersion)&&!(M.wk&&M.wk<312)){w(Y,true);if(ab){aa.success=true;aa.ref=z(Y);ab(aa)}}else{if(o[af].expressInstall&&A()){var ai={};ai.data=o[af].expressInstall;ai.width=ae.getAttribute("width")||"0";ai.height=ae.getAttribute("height")||"0";if(ae.getAttribute("class")){ai.styleclass=ae.getAttribute("class")}if(ae.getAttribute("align")){ai.align=ae.getAttribute("align")}var ah={};var X=ae.getElementsByTagName("param");var ac=X.length;for(var ad=0;ad<ac;ad++){if(X[ad].getAttribute("name").toLowerCase()!="movie"){ah[X[ad].getAttribute("name")]=X[ad].getAttribute("value")}}P(ai,ah,Y,ab)}else{p(ae);if(ab){ab(aa)}}}}}else{w(Y,true);if(ab){var Z=z(Y);if(Z&&typeof Z.SetVariable!=D){aa.success=true;aa.ref=Z}ab(aa)}}}}}function z(aa){var X=null;var Y=c(aa);if(Y&&Y.nodeName=="OBJECT"){if(typeof Y.SetVariable!=D){X=Y}else{var Z=Y.getElementsByTagName(r)[0];if(Z){X=Z}}}return X}function A(){return !a&&F("6.0.65")&&(M.win||M.mac)&&!(M.wk&&M.wk<312)}function P(aa,ab,X,Z){a=true;E=Z||null;B={success:false,id:X};var ae=c(X);if(ae){if(ae.nodeName=="OBJECT"){l=g(ae);Q=null}else{l=ae;Q=X}aa.id=R;if(typeof aa.width==D||(!/%$/.test(aa.width)&&parseInt(aa.width,10)<310)){aa.width="310"}if(typeof aa.height==D||(!/%$/.test(aa.height)&&parseInt(aa.height,10)<137)){aa.height="137"}j.title=j.title.slice(0,47)+" - Flash Player Installation";var ad=M.ie&&M.win?"ActiveX":"PlugIn",ac="MMredirectURL="+O.location.toString().replace(/&/g,"%26")+"&MMplayerType="+ad+"&MMdoctitle="+j.title;if(typeof ab.flashvars!=D){ab.flashvars+="&"+ac}else{ab.flashvars=ac}if(M.ie&&M.win&&ae.readyState!=4){var Y=C("div");X+="SWFObjectNew";Y.setAttribute("id",X);ae.parentNode.insertBefore(Y,ae);ae.style.display="none";(function(){if(ae.readyState==4){ae.parentNode.removeChild(ae)}else{setTimeout(arguments.callee,10)}})()}u(aa,ab,X)}}function p(Y){if(M.ie&&M.win&&Y.readyState!=4){var X=C("div");Y.parentNode.insertBefore(X,Y);X.parentNode.replaceChild(g(Y),X);Y.style.display="none";(function(){if(Y.readyState==4){Y.parentNode.removeChild(Y)}else{setTimeout(arguments.callee,10)}})()}else{Y.parentNode.replaceChild(g(Y),Y)}}function g(ab){var aa=C("div");if(M.win&&M.ie){aa.innerHTML=ab.innerHTML}else{var Y=ab.getElementsByTagName(r)[0];if(Y){var ad=Y.childNodes;if(ad){var X=ad.length;for(var Z=0;Z<X;Z++){if(!(ad[Z].nodeType==1&&ad[Z].nodeName=="PARAM")&&!(ad[Z].nodeType==8)){aa.appendChild(ad[Z].cloneNode(true))}}}}}return aa}function u(ai,ag,Y){var X,aa=c(Y);if(M.wk&&M.wk<312){return X}if(aa){if(typeof ai.id==D){ai.id=Y}if(M.ie&&M.win){var ah="";for(var ae in ai){if(ai[ae]!=Object.prototype[ae]){if(ae.toLowerCase()=="data"){ag.movie=ai[ae]}else{if(ae.toLowerCase()=="styleclass"){ah+=' class="'+ai[ae]+'"'}else{if(ae.toLowerCase()!="classid"){ah+=" "+ae+'="'+ai[ae]+'"'}}}}}var af="";for(var ad in ag){if(ag[ad]!=Object.prototype[ad]){af+='<param name="'+ad+'" value="'+ag[ad]+'" />'}}aa.outerHTML='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"'+ah+">"+af+"</object>";N[N.length]=ai.id;X=c(ai.id)}else{var Z=C(r);Z.setAttribute("type",q);for(var ac in ai){if(ai[ac]!=Object.prototype[ac]){if(ac.toLowerCase()=="styleclass"){Z.setAttribute("class",ai[ac])}else{if(ac.toLowerCase()!="classid"){Z.setAttribute(ac,ai[ac])}}}}for(var ab in ag){if(ag[ab]!=Object.prototype[ab]&&ab.toLowerCase()!="movie"){e(Z,ab,ag[ab])}}aa.parentNode.replaceChild(Z,aa);X=Z}}return X}function e(Z,X,Y){var aa=C("param");aa.setAttribute("name",X);aa.setAttribute("value",Y);Z.appendChild(aa)}function y(Y){var X=c(Y);if(X&&X.nodeName=="OBJECT"){if(M.ie&&M.win){X.style.display="none";(function(){if(X.readyState==4){b(Y)}else{setTimeout(arguments.callee,10)}})()}else{X.parentNode.removeChild(X)}}}function b(Z){var Y=c(Z);if(Y){for(var X in Y){if(typeof Y[X]=="function"){Y[X]=null}}Y.parentNode.removeChild(Y)}}function c(Z){var X=null;try{X=j.getElementById(Z)}catch(Y){}return X}function C(X){return j.createElement(X)}function i(Z,X,Y){Z.attachEvent(X,Y);I[I.length]=[Z,X,Y]}function F(Z){var Y=M.pv,X=Z.split(".");X[0]=parseInt(X[0],10);X[1]=parseInt(X[1],10)||0;X[2]=parseInt(X[2],10)||0;return(Y[0]>X[0]||(Y[0]==X[0]&&Y[1]>X[1])||(Y[0]==X[0]&&Y[1]==X[1]&&Y[2]>=X[2]))?true:false}function v(ac,Y,ad,ab){if(M.ie&&M.mac){return}var aa=j.getElementsByTagName("head")[0];if(!aa){return}var X=(ad&&typeof ad=="string")?ad:"screen";if(ab){n=null;G=null}if(!n||G!=X){var Z=C("style");Z.setAttribute("type","text/css");Z.setAttribute("media",X);n=aa.appendChild(Z);if(M.ie&&M.win&&typeof j.styleSheets!=D&&j.styleSheets.length>0){n=j.styleSheets[j.styleSheets.length-1]}G=X}if(M.ie&&M.win){if(n&&typeof n.addRule==r){n.addRule(ac,Y)}}else{if(n&&typeof j.createTextNode!=D){n.appendChild(j.createTextNode(ac+" {"+Y+"}"))}}}function w(Z,X){if(!m){return}var Y=X?"visible":"hidden";if(J&&c(Z)){c(Z).style.visibility=Y}else{v("#"+Z,"visibility:"+Y)}}function L(Y){var Z=/[\\\"<>\.;]/;var X=Z.exec(Y)!=null;return X&&typeof encodeURIComponent!=D?encodeURIComponent(Y):Y}var d=function(){if(M.ie&&M.win){window.attachEvent("onunload",function(){var ac=I.length;for(var ab=0;ab<ac;ab++){I[ab][0].detachEvent(I[ab][1],I[ab][2])}var Z=N.length;for(var aa=0;aa<Z;aa++){y(N[aa])}for(var Y in M){M[Y]=null}M=null;for(var X in swfobject){swfobject[X]=null}swfobject=null})}}();return{registerObject:function(ab,X,aa,Z){if(M.w3&&ab&&X){var Y={};Y.id=ab;Y.swfVersion=X;Y.expressInstall=aa;Y.callbackFn=Z;o[o.length]=Y;w(ab,false)}else{if(Z){Z({success:false,id:ab})}}},getObjectById:function(X){if(M.w3){return z(X)}},embedSWF:function(ab,ah,ae,ag,Y,aa,Z,ad,af,ac){var X={success:false,id:ah};if(M.w3&&!(M.wk&&M.wk<312)&&ab&&ah&&ae&&ag&&Y){w(ah,false);K(function(){ae+="";ag+="";var aj={};if(af&&typeof af===r){for(var al in af){aj[al]=af[al]}}aj.data=ab;aj.width=ae;aj.height=ag;var am={};if(ad&&typeof ad===r){for(var ak in ad){am[ak]=ad[ak]}}if(Z&&typeof Z===r){for(var ai in Z){if(typeof am.flashvars!=D){am.flashvars+="&"+ai+"="+Z[ai]}else{am.flashvars=ai+"="+Z[ai]}}}if(F(Y)){var an=u(aj,am,ah);if(aj.id==ah){w(ah,true)}X.success=true;X.ref=an}else{if(aa&&A()){aj.data=aa;P(aj,am,ah,ac);return}else{w(ah,true)}}if(ac){ac(X)}})}else{if(ac){ac(X)}}},switchOffAutoHideShow:function(){m=false},ua:M,getFlashPlayerVersion:function(){return{major:M.pv[0],minor:M.pv[1],release:M.pv[2]}},hasFlashPlayerVersion:F,createSWF:function(Z,Y,X){if(M.w3){return u(Z,Y,X)}else{return undefined}},showExpressInstall:function(Z,aa,X,Y){if(M.w3&&A()){P(Z,aa,X,Y)}},removeSWF:function(X){if(M.w3){y(X)}},createCSS:function(aa,Z,Y,X){if(M.w3){v(aa,Z,Y,X)}},addDomLoadEvent:K,addLoadEvent:s,getQueryParamValue:function(aa){var Z=j.location.search||j.location.hash;if(Z){if(/\?/.test(Z)){Z=Z.split("?")[1]}if(aa==null){return L(Z)}var Y=Z.split("&");for(var X=0;X<Y.length;X++){if(Y[X].substring(0,Y[X].indexOf("="))==aa){return L(Y[X].substring((Y[X].indexOf("=")+1)))}}}return""},expressInstallCallback:function(){if(a){var X=c(R);if(X&&l){X.parentNode.replaceChild(l,X);if(Q){w(Q,true);if(M.ie&&M.win){l.style.display="block"}}if(E){E(B)}}a=false}}}}();

if (SWFUpload == undefined) {
    SWFUpload = function (settings) {
        this.initSWFUpload(settings);
    };
}

SWFUpload.prototype.initSWFUpload = function (settings) {
    try {
        this.customSettings = {};	// A container where developers can place their own settings associated with this instance.
        this.settings = settings;
        this.eventQueue = [];
        this.movieName = "SWFUpload_" + SWFUpload.movieCount++;
        this.movieElement = null;


        // Setup global control tracking
        SWFUpload.instances[this.movieName] = this;

        // Load the settings.  Load the Flash movie.
        this.initSettings();
        this.loadFlash();
        this.displayDebugInfo();
    } catch (ex) {
        delete SWFUpload.instances[this.movieName];
        throw ex;
    }
};

/* *************** */
/* Static Members  */
/* *************** */
SWFUpload.instances = {};
SWFUpload.movieCount = 0;
SWFUpload.version = "2.2.0 2009-03-25";
SWFUpload.QUEUE_ERROR = {
    QUEUE_LIMIT_EXCEEDED	  		: -100,
    FILE_EXCEEDS_SIZE_LIMIT  		: -110,
    ZERO_BYTE_FILE			  		: -120,
    INVALID_FILETYPE		  		: -130
};
SWFUpload.UPLOAD_ERROR = {
    HTTP_ERROR				  		: -200,
    MISSING_UPLOAD_URL	      		: -210,
    IO_ERROR				  		: -220,
    SECURITY_ERROR			  		: -230,
    UPLOAD_LIMIT_EXCEEDED	  		: -240,
    UPLOAD_FAILED			  		: -250,
    SPECIFIED_FILE_ID_NOT_FOUND		: -260,
    FILE_VALIDATION_FAILED	  		: -270,
    FILE_CANCELLED			  		: -280,
    UPLOAD_STOPPED					: -290
};
SWFUpload.FILE_STATUS = {
    QUEUED		 : -1,
    IN_PROGRESS	 : -2,
    ERROR		 : -3,
    COMPLETE	 : -4,
    CANCELLED	 : -5
};
SWFUpload.BUTTON_ACTION = {
    SELECT_FILE  : -100,
    SELECT_FILES : -110,
    START_UPLOAD : -120
};
SWFUpload.CURSOR = {
    ARROW : -1,
    HAND : -2
};
SWFUpload.WINDOW_MODE = {
    WINDOW : "window",
    TRANSPARENT : "transparent",
    OPAQUE : "opaque"
};

// Private: takes a URL, determines if it is relative and converts to an absolute URL
// using the current site. Only processes the URL if it can, otherwise returns the URL untouched
SWFUpload.completeURL = function(url) {
    if (typeof(url) !== "string" || url.match(/^https?:\/\//i) || url.match(/^\//)) {
        return url;
    }

    var currentURL = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ":" + window.location.port : "");

    var indexSlash = window.location.pathname.lastIndexOf("/");
    if (indexSlash <= 0) {
        path = "/";
    } else {
        path = window.location.pathname.substr(0, indexSlash) + "/";
    }

    return /*currentURL +*/ path + url;

};


/* ******************** */
/* Instance Members  */
/* ******************** */

// Private: initSettings ensures that all the
// settings are set, getting a default value if one was not assigned.
SWFUpload.prototype.initSettings = function () {
    this.ensureDefault = function (settingName, defaultValue) {
        this.settings[settingName] = (this.settings[settingName] == undefined) ? defaultValue : this.settings[settingName];
    };

    // Upload backend settings
    this.ensureDefault("upload_url", "");
    this.ensureDefault("preserve_relative_urls", false);
    this.ensureDefault("file_post_name", "Filedata");
    this.ensureDefault("post_params", {});
    this.ensureDefault("use_query_string", false);
    this.ensureDefault("requeue_on_error", false);
    this.ensureDefault("http_success", []);
    this.ensureDefault("assume_success_timeout", 0);

    // File Settings
    this.ensureDefault("file_types", "*.*");
    this.ensureDefault("file_types_description", "All Files");
    this.ensureDefault("file_size_limit", 0);	// Default zero means "unlimited"
    this.ensureDefault("file_upload_limit", 0);
    this.ensureDefault("file_queue_limit", 0);

    // Flash Settings
    this.ensureDefault("flash_url", "swfupload.swf");
    this.ensureDefault("prevent_swf_caching", true);

    // Button Settings
    this.ensureDefault("button_image_url", "");
    this.ensureDefault("button_width", 1);
    this.ensureDefault("button_height", 1);
    this.ensureDefault("button_text", "");
    this.ensureDefault("button_text_style", "color: #000000; font-size: 16pt;");
    this.ensureDefault("button_text_top_padding", 0);
    this.ensureDefault("button_text_left_padding", 0);
    this.ensureDefault("button_action", SWFUpload.BUTTON_ACTION.SELECT_FILES);
    this.ensureDefault("button_disabled", false);
    this.ensureDefault("button_placeholder_id", "");
    this.ensureDefault("button_placeholder", null);
    this.ensureDefault("button_cursor", SWFUpload.CURSOR.ARROW);
    this.ensureDefault("button_window_mode", SWFUpload.WINDOW_MODE.WINDOW);

    // Debug Settings
    this.ensureDefault("debug", false);
    this.settings.debug_enabled = this.settings.debug;	// Here to maintain v2 API

    // Event Handlers
    this.settings.return_upload_start_handler = this.returnUploadStart;
    this.ensureDefault("swfupload_loaded_handler", null);
    this.ensureDefault("file_dialog_start_handler", null);
    this.ensureDefault("file_queued_handler", null);
    this.ensureDefault("file_queue_error_handler", null);
    this.ensureDefault("file_dialog_complete_handler", null);

    this.ensureDefault("upload_start_handler", null);
    this.ensureDefault("upload_progress_handler", null);
    this.ensureDefault("upload_error_handler", null);
    this.ensureDefault("upload_success_handler", null);
    this.ensureDefault("upload_complete_handler", null);

    this.ensureDefault("debug_handler", this.debugMessage);

    this.ensureDefault("custom_settings", {});

    // Other settings
    this.customSettings = this.settings.custom_settings;

    // Update the flash url if needed
    if (!!this.settings.prevent_swf_caching) {
        this.settings.flash_url = this.settings.flash_url + (this.settings.flash_url.indexOf("?") < 0 ? "?" : "&") + "preventswfcaching=" + new Date().getTime();
    }

    if (!this.settings.preserve_relative_urls) {
        //this.settings.flash_url = SWFUpload.completeURL(this.settings.flash_url);	// Don't need to do this one since flash doesn't look at it
        this.settings.upload_url = SWFUpload.completeURL(this.settings.upload_url);
        this.settings.button_image_url = SWFUpload.completeURL(this.settings.button_image_url);
    }

    delete this.ensureDefault;
};

// Private: loadFlash replaces the button_placeholder element with the flash movie.
SWFUpload.prototype.loadFlash = function () {
    var targetElement, tempParent;

    // Make sure an element with the ID we are going to use doesn't already exist
    if (document.getElementById(this.movieName) !== null) {
        throw "ID " + this.movieName + " is already in use. The Flash Object could not be added";
    }

    // Get the element where we will be placing the flash movie
    targetElement = document.getElementById(this.settings.button_placeholder_id) || this.settings.button_placeholder;

    if (targetElement == undefined) {
        throw "Could not find the placeholder element: " + this.settings.button_placeholder_id;
    }

    // Append the container and load the flash
    tempParent = document.createElement("div");
    tempParent.innerHTML = this.getFlashHTML();	// Using innerHTML is non-standard but the only sensible way to dynamically add Flash in IE (and maybe other browsers)
    targetElement.parentNode.replaceChild(tempParent.firstChild, targetElement);

    // Fix IE Flash/Form bug
    if (window[this.movieName] == undefined) {
        window[this.movieName] = this.getMovieElement();
    }

};

// Private: getFlashHTML generates the object tag needed to embed the flash in to the document
SWFUpload.prototype.getFlashHTML = function () {
    // Flash Satay object syntax: http://www.alistapart.com/articles/flashsatay
    return ['<object id="', this.movieName, '" type="application/x-shockwave-flash" data="', this.settings.flash_url, '" width="', this.settings.button_width, '" height="', this.settings.button_height, '" class="swfupload">',
        '<param name="wmode" value="', this.settings.button_window_mode, '" />',
        '<param name="movie" value="', this.settings.flash_url, '" />',
        '<param name="quality" value="high" />',
        '<param name="menu" value="false" />',
        '<param name="allowScriptAccess" value="always" />',
        '<param name="flashvars" value="' + this.getFlashVars() + '" />',
        '</object>'].join("");
};

// Private: getFlashVars builds the parameter string that will be passed
// to flash in the flashvars param.
SWFUpload.prototype.getFlashVars = function () {
    // Build a string from the post param object
    var paramString = this.buildParamString();
    var httpSuccessString = this.settings.http_success.join(",");

    // Build the parameter string
    return ["movieName=", encodeURIComponent(this.movieName),
        "&amp;uploadURL=", encodeURIComponent(this.settings.upload_url),
        "&amp;useQueryString=", encodeURIComponent(this.settings.use_query_string),
        "&amp;requeueOnError=", encodeURIComponent(this.settings.requeue_on_error),
        "&amp;httpSuccess=", encodeURIComponent(httpSuccessString),
        "&amp;assumeSuccessTimeout=", encodeURIComponent(this.settings.assume_success_timeout),
        "&amp;params=", encodeURIComponent(paramString),
        "&amp;filePostName=", encodeURIComponent(this.settings.file_post_name),
        "&amp;fileTypes=", encodeURIComponent(this.settings.file_types),
        "&amp;fileTypesDescription=", encodeURIComponent(this.settings.file_types_description),
        "&amp;fileSizeLimit=", encodeURIComponent(this.settings.file_size_limit),
        "&amp;fileUploadLimit=", encodeURIComponent(this.settings.file_upload_limit),
        "&amp;fileQueueLimit=", encodeURIComponent(this.settings.file_queue_limit),
        "&amp;debugEnabled=", encodeURIComponent(this.settings.debug_enabled),
        "&amp;buttonImageURL=", encodeURIComponent(this.settings.button_image_url),
        "&amp;buttonWidth=", encodeURIComponent(this.settings.button_width),
        "&amp;buttonHeight=", encodeURIComponent(this.settings.button_height),
        "&amp;buttonText=", encodeURIComponent(this.settings.button_text),
        "&amp;buttonTextTopPadding=", encodeURIComponent(this.settings.button_text_top_padding),
        "&amp;buttonTextLeftPadding=", encodeURIComponent(this.settings.button_text_left_padding),
        "&amp;buttonTextStyle=", encodeURIComponent(this.settings.button_text_style),
        "&amp;buttonAction=", encodeURIComponent(this.settings.button_action),
        "&amp;buttonDisabled=", encodeURIComponent(this.settings.button_disabled),
        "&amp;buttonCursor=", encodeURIComponent(this.settings.button_cursor)
    ].join("");
};

// Public: getMovieElement retrieves the DOM reference to the Flash element added by SWFUpload
// The element is cached after the first lookup
SWFUpload.prototype.getMovieElement = function () {
    if (this.movieElement == undefined) {
        this.movieElement = document.getElementById(this.movieName);
    }

    if (this.movieElement === null) {
        throw "Could not find Flash element";
    }

    return this.movieElement;
};

// Private: buildParamString takes the name/value pairs in the post_params setting object
// and joins them up in to a string formatted "name=value&amp;name=value"
SWFUpload.prototype.buildParamString = function () {
    var postParams = this.settings.post_params;
    var paramStringPairs = [];

    if (typeof(postParams) === "object") {
        for (var name in postParams) {
            if (postParams.hasOwnProperty(name)) {
                paramStringPairs.push(encodeURIComponent(name.toString()) + "=" + encodeURIComponent(postParams[name].toString()));
            }
        }
    }

    return paramStringPairs.join("&amp;");
};

// Public: Used to remove a SWFUpload instance from the page. This method strives to remove
// all references to the SWF, and other objects so memory is properly freed.
// Returns true if everything was destroyed. Returns a false if a failure occurs leaving SWFUpload in an inconsistant state.
// Credits: Major improvements provided by steffen
SWFUpload.prototype.destroy = function () {
    try {
        // Make sure Flash is done before we try to remove it
        this.cancelUpload(null, false);


        // Remove the SWFUpload DOM nodes
        var movieElement = null;
        movieElement = this.getMovieElement();

        if (movieElement && typeof(movieElement.CallFunction) === "unknown") { // We only want to do this in IE
            // Loop through all the movie's properties and remove all function references (DOM/JS IE 6/7 memory leak workaround)
            for (var i in movieElement) {
                try {
                    if (typeof(movieElement[i]) === "function") {
                        movieElement[i] = null;
                    }
                } catch (ex1) {}
            }

            // Remove the Movie Element from the page
            try {
                movieElement.parentNode.removeChild(movieElement);
            } catch (ex) {}
        }

        // Remove IE form fix reference
        window[this.movieName] = null;

        // Destroy other references
        SWFUpload.instances[this.movieName] = null;
        delete SWFUpload.instances[this.movieName];

        this.movieElement = null;
        this.settings = null;
        this.customSettings = null;
        this.eventQueue = null;
        this.movieName = null;


        return true;
    } catch (ex2) {
        return false;
    }
};


// Public: displayDebugInfo prints out settings and configuration
// information about this SWFUpload instance.
// This function (and any references to it) can be deleted when placing
// SWFUpload in production.
SWFUpload.prototype.displayDebugInfo = function () {
    this.debug(
        [
            "---SWFUpload Instance Info---\n",
            "Version: ", SWFUpload.version, "\n",
            "Movie Name: ", this.movieName, "\n",
            "Settings:\n",
            "\t", "upload_url:               ", this.settings.upload_url, "\n",
            "\t", "flash_url:                ", this.settings.flash_url, "\n",
            "\t", "use_query_string:         ", this.settings.use_query_string.toString(), "\n",
            "\t", "requeue_on_error:         ", this.settings.requeue_on_error.toString(), "\n",
            "\t", "http_success:             ", this.settings.http_success.join(", "), "\n",
            "\t", "assume_success_timeout:   ", this.settings.assume_success_timeout, "\n",
            "\t", "file_post_name:           ", this.settings.file_post_name, "\n",
            "\t", "post_params:              ", this.settings.post_params.toString(), "\n",
            "\t", "file_types:               ", this.settings.file_types, "\n",
            "\t", "file_types_description:   ", this.settings.file_types_description, "\n",
            "\t", "file_size_limit:          ", this.settings.file_size_limit, "\n",
            "\t", "file_upload_limit:        ", this.settings.file_upload_limit, "\n",
            "\t", "file_queue_limit:         ", this.settings.file_queue_limit, "\n",
            "\t", "debug:                    ", this.settings.debug.toString(), "\n",

            "\t", "prevent_swf_caching:      ", this.settings.prevent_swf_caching.toString(), "\n",

            "\t", "button_placeholder_id:    ", this.settings.button_placeholder_id.toString(), "\n",
            "\t", "button_placeholder:       ", (this.settings.button_placeholder ? "Set" : "Not Set"), "\n",
            "\t", "button_image_url:         ", this.settings.button_image_url.toString(), "\n",
            "\t", "button_width:             ", this.settings.button_width.toString(), "\n",
            "\t", "button_height:            ", this.settings.button_height.toString(), "\n",
            "\t", "button_text:              ", this.settings.button_text.toString(), "\n",
            "\t", "button_text_style:        ", this.settings.button_text_style.toString(), "\n",
            "\t", "button_text_top_padding:  ", this.settings.button_text_top_padding.toString(), "\n",
            "\t", "button_text_left_padding: ", this.settings.button_text_left_padding.toString(), "\n",
            "\t", "button_action:            ", this.settings.button_action.toString(), "\n",
            "\t", "button_disabled:          ", this.settings.button_disabled.toString(), "\n",

            "\t", "custom_settings:          ", this.settings.custom_settings.toString(), "\n",
            "Event Handlers:\n",
            "\t", "swfupload_loaded_handler assigned:  ", (typeof this.settings.swfupload_loaded_handler === "function").toString(), "\n",
            "\t", "file_dialog_start_handler assigned: ", (typeof this.settings.file_dialog_start_handler === "function").toString(), "\n",
            "\t", "file_queued_handler assigned:       ", (typeof this.settings.file_queued_handler === "function").toString(), "\n",
            "\t", "file_queue_error_handler assigned:  ", (typeof this.settings.file_queue_error_handler === "function").toString(), "\n",
            "\t", "upload_start_handler assigned:      ", (typeof this.settings.upload_start_handler === "function").toString(), "\n",
            "\t", "upload_progress_handler assigned:   ", (typeof this.settings.upload_progress_handler === "function").toString(), "\n",
            "\t", "upload_error_handler assigned:      ", (typeof this.settings.upload_error_handler === "function").toString(), "\n",
            "\t", "upload_success_handler assigned:    ", (typeof this.settings.upload_success_handler === "function").toString(), "\n",
            "\t", "upload_complete_handler assigned:   ", (typeof this.settings.upload_complete_handler === "function").toString(), "\n",
            "\t", "debug_handler assigned:             ", (typeof this.settings.debug_handler === "function").toString(), "\n"
        ].join("")
    );
};

/* Note: addSetting and getSetting are no longer used by SWFUpload but are included
 the maintain v2 API compatibility
 */
// Public: (Deprecated) addSetting adds a setting value. If the value given is undefined or null then the default_value is used.
SWFUpload.prototype.addSetting = function (name, value, default_value) {
    if (value == undefined) {
        return (this.settings[name] = default_value);
    } else {
        return (this.settings[name] = value);
    }
};

// Public: (Deprecated) getSetting gets a setting. Returns an empty string if the setting was not found.
SWFUpload.prototype.getSetting = function (name) {
    if (this.settings[name] != undefined) {
        return this.settings[name];
    }

    return "";
};



// Private: callFlash handles function calls made to the Flash element.
// Calls are made with a setTimeout for some functions to work around
// bugs in the ExternalInterface library.
SWFUpload.prototype.callFlash = function (functionName, argumentArray) {
    argumentArray = argumentArray || [];

    var movieElement = this.getMovieElement();
    var returnValue, returnString;

    // Flash's method if calling ExternalInterface methods (code adapted from MooTools).
    try {
        returnString = movieElement.CallFunction('<invoke name="' + functionName + '" returntype="javascript">' + __flash__argumentsToXML(argumentArray, 0) + '</invoke>');
        returnValue = eval(returnString);
    } catch (ex) {
        throw "Call to " + functionName + " failed";
    }

    // Unescape file post param values
    if (returnValue != undefined && typeof returnValue.post === "object") {
        returnValue = this.unescapeFilePostParams(returnValue);
    }

    return returnValue;
};

/* *****************************
 -- Flash control methods --
 Your UI should use these
 to operate SWFUpload
 ***************************** */

// WARNING: this function does not work in Flash Player 10
// Public: selectFile causes a File Selection Dialog window to appear.  This
// dialog only allows 1 file to be selected.
SWFUpload.prototype.selectFile = function () {
    this.callFlash("SelectFile");
};

// WARNING: this function does not work in Flash Player 10
// Public: selectFiles causes a File Selection Dialog window to appear/ This
// dialog allows the user to select any number of files
// Flash Bug Warning: Flash limits the number of selectable files based on the combined length of the file names.
// If the selection name length is too long the dialog will fail in an unpredictable manner.  There is no work-around
// for this bug.
SWFUpload.prototype.selectFiles = function () {
    this.callFlash("SelectFiles");
};


// Public: startUpload starts uploading the first file in the queue unless
// the optional parameter 'fileID' specifies the ID
SWFUpload.prototype.startUpload = function (fileID) {
    this.callFlash("StartUpload", [fileID]);
};

// Public: cancelUpload cancels any queued file.  The fileID parameter may be the file ID or index.
// If you do not specify a fileID the current uploading file or first file in the queue is cancelled.
// If you do not want the uploadError event to trigger you can specify false for the triggerErrorEvent parameter.
SWFUpload.prototype.cancelUpload = function (fileID, triggerErrorEvent) {
    if (triggerErrorEvent !== false) {
        triggerErrorEvent = true;
    }
    this.callFlash("CancelUpload", [fileID, triggerErrorEvent]);
};

// Public: stopUpload stops the current upload and requeues the file at the beginning of the queue.
// If nothing is currently uploading then nothing happens.
SWFUpload.prototype.stopUpload = function () {
    this.callFlash("StopUpload");
};

/* ************************
 * Settings methods
 *   These methods change the SWFUpload settings.
 *   SWFUpload settings should not be changed directly on the settings object
 *   since many of the settings need to be passed to Flash in order to take
 *   effect.
 * *********************** */

// Public: getStats gets the file statistics object.
SWFUpload.prototype.getStats = function () {
    return this.callFlash("GetStats");
};

// Public: setStats changes the SWFUpload statistics.  You shouldn't need to
// change the statistics but you can.  Changing the statistics does not
// affect SWFUpload accept for the successful_uploads count which is used
// by the upload_limit setting to determine how many files the user may upload.
SWFUpload.prototype.setStats = function (statsObject) {
    this.callFlash("SetStats", [statsObject]);
};

// Public: getFile retrieves a File object by ID or Index.  If the file is
// not found then 'null' is returned.
SWFUpload.prototype.getFile = function (fileID) {
    if (typeof(fileID) === "number") {
        return this.callFlash("GetFileByIndex", [fileID]);
    } else {
        return this.callFlash("GetFile", [fileID]);
    }
};

// Public: addFileParam sets a name/value pair that will be posted with the
// file specified by the Files ID.  If the name already exists then the
// exiting value will be overwritten.
SWFUpload.prototype.addFileParam = function (fileID, name, value) {
    return this.callFlash("AddFileParam", [fileID, name, value]);
};

// Public: removeFileParam removes a previously set (by addFileParam) name/value
// pair from the specified file.
SWFUpload.prototype.removeFileParam = function (fileID, name) {
    this.callFlash("RemoveFileParam", [fileID, name]);
};

// Public: setUploadUrl changes the upload_url setting.
SWFUpload.prototype.setUploadURL = function (url) {
    this.settings.upload_url = url.toString();
    this.callFlash("SetUploadURL", [url]);
};

// Public: setPostParams changes the post_params setting
SWFUpload.prototype.setPostParams = function (paramsObject) {
    this.settings.post_params = paramsObject;
    this.callFlash("SetPostParams", [paramsObject]);
};

// Public: addPostParam adds post name/value pair.  Each name can have only one value.
SWFUpload.prototype.addPostParam = function (name, value) {
    this.settings.post_params[name] = value;
    this.callFlash("SetPostParams", [this.settings.post_params]);
};

// Public: removePostParam deletes post name/value pair.
SWFUpload.prototype.removePostParam = function (name) {
    delete this.settings.post_params[name];
    this.callFlash("SetPostParams", [this.settings.post_params]);
};

// Public: setFileTypes changes the file_types setting and the file_types_description setting
SWFUpload.prototype.setFileTypes = function (types, description) {
    this.settings.file_types = types;
    this.settings.file_types_description = description;
    this.callFlash("SetFileTypes", [types, description]);
};

// Public: setFileSizeLimit changes the file_size_limit setting
SWFUpload.prototype.setFileSizeLimit = function (fileSizeLimit) {
    this.settings.file_size_limit = fileSizeLimit;
    this.callFlash("SetFileSizeLimit", [fileSizeLimit]);
};

// Public: setFileUploadLimit changes the file_upload_limit setting
SWFUpload.prototype.setFileUploadLimit = function (fileUploadLimit) {
    this.settings.file_upload_limit = fileUploadLimit;
    this.callFlash("SetFileUploadLimit", [fileUploadLimit]);
};

// Public: setFileQueueLimit changes the file_queue_limit setting
SWFUpload.prototype.setFileQueueLimit = function (fileQueueLimit) {
    this.settings.file_queue_limit = fileQueueLimit;
    this.callFlash("SetFileQueueLimit", [fileQueueLimit]);
};

// Public: setFilePostName changes the file_post_name setting
SWFUpload.prototype.setFilePostName = function (filePostName) {
    this.settings.file_post_name = filePostName;
    this.callFlash("SetFilePostName", [filePostName]);
};

// Public: setUseQueryString changes the use_query_string setting
SWFUpload.prototype.setUseQueryString = function (useQueryString) {
    this.settings.use_query_string = useQueryString;
    this.callFlash("SetUseQueryString", [useQueryString]);
};

// Public: setRequeueOnError changes the requeue_on_error setting
SWFUpload.prototype.setRequeueOnError = function (requeueOnError) {
    this.settings.requeue_on_error = requeueOnError;
    this.callFlash("SetRequeueOnError", [requeueOnError]);
};

// Public: setHTTPSuccess changes the http_success setting
SWFUpload.prototype.setHTTPSuccess = function (http_status_codes) {
    if (typeof http_status_codes === "string") {
        http_status_codes = http_status_codes.replace(" ", "").split(",");
    }

    this.settings.http_success = http_status_codes;
    this.callFlash("SetHTTPSuccess", [http_status_codes]);
};

// Public: setHTTPSuccess changes the http_success setting
SWFUpload.prototype.setAssumeSuccessTimeout = function (timeout_seconds) {
    this.settings.assume_success_timeout = timeout_seconds;
    this.callFlash("SetAssumeSuccessTimeout", [timeout_seconds]);
};

// Public: setDebugEnabled changes the debug_enabled setting
SWFUpload.prototype.setDebugEnabled = function (debugEnabled) {
    this.settings.debug_enabled = debugEnabled;
    this.callFlash("SetDebugEnabled", [debugEnabled]);
};

// Public: setButtonImageURL loads a button image sprite
SWFUpload.prototype.setButtonImageURL = function (buttonImageURL) {
    if (buttonImageURL == undefined) {
        buttonImageURL = "";
    }

    this.settings.button_image_url = buttonImageURL;
    this.callFlash("SetButtonImageURL", [buttonImageURL]);
};

// Public: setButtonDimensions resizes the Flash Movie and button
SWFUpload.prototype.setButtonDimensions = function (width, height) {
    this.settings.button_width = width;
    this.settings.button_height = height;

    var movie = this.getMovieElement();
    if (movie != undefined) {
        movie.style.width = width + "px";
        movie.style.height = height + "px";
    }

    this.callFlash("SetButtonDimensions", [width, height]);
};
// Public: setButtonText Changes the text overlaid on the button
SWFUpload.prototype.setButtonText = function (html) {
    this.settings.button_text = html;
    this.callFlash("SetButtonText", [html]);
};
// Public: setButtonTextPadding changes the top and left padding of the text overlay
SWFUpload.prototype.setButtonTextPadding = function (left, top) {
    this.settings.button_text_top_padding = top;
    this.settings.button_text_left_padding = left;
    this.callFlash("SetButtonTextPadding", [left, top]);
};

// Public: setButtonTextStyle changes the CSS used to style the HTML/Text overlaid on the button
SWFUpload.prototype.setButtonTextStyle = function (css) {
    this.settings.button_text_style = css;
    this.callFlash("SetButtonTextStyle", [css]);
};
// Public: setButtonDisabled disables/enables the button
SWFUpload.prototype.setButtonDisabled = function (isDisabled) {
    this.settings.button_disabled = isDisabled;
    this.callFlash("SetButtonDisabled", [isDisabled]);
};
// Public: setButtonAction sets the action that occurs when the button is clicked
SWFUpload.prototype.setButtonAction = function (buttonAction) {
    this.settings.button_action = buttonAction;
    this.callFlash("SetButtonAction", [buttonAction]);
};

// Public: setButtonCursor changes the mouse cursor displayed when hovering over the button
SWFUpload.prototype.setButtonCursor = function (cursor) {
    this.settings.button_cursor = cursor;
    this.callFlash("SetButtonCursor", [cursor]);
};

/* *******************************
 Flash Event Interfaces
 These functions are used by Flash to trigger the various
 events.

 All these functions a Private.

 Because the ExternalInterface library is buggy the event calls
 are added to a queue and the queue then executed by a setTimeout.
 This ensures that events are executed in a determinate order and that
 the ExternalInterface bugs are avoided.
 ******************************* */

SWFUpload.prototype.queueEvent = function (handlerName, argumentArray) {
    // Warning: Don't call this.debug inside here or you'll create an infinite loop

    if (argumentArray == undefined) {
        argumentArray = [];
    } else if (!(argumentArray instanceof Array)) {
        argumentArray = [argumentArray];
    }

    var self = this;
    if (typeof this.settings[handlerName] === "function") {
        // Queue the event
        this.eventQueue.push(function () {
            this.settings[handlerName].apply(this, argumentArray);
        });

        // Execute the next queued event
        setTimeout(function () {
            self.executeNextEvent();
        }, 0);

    } else if (this.settings[handlerName] !== null) {
        throw "Event handler " + handlerName + " is unknown or is not a function";
    }
};

// Private: Causes the next event in the queue to be executed.  Since events are queued using a setTimeout
// we must queue them in order to garentee that they are executed in order.
SWFUpload.prototype.executeNextEvent = function () {
    // Warning: Don't call this.debug inside here or you'll create an infinite loop

    var  f = this.eventQueue ? this.eventQueue.shift() : null;
    if (typeof(f) === "function") {
        f.apply(this);
    }
};

// Private: unescapeFileParams is part of a workaround for a flash bug where objects passed through ExternalInterface cannot have
// properties that contain characters that are not valid for JavaScript identifiers. To work around this
// the Flash Component escapes the parameter names and we must unescape again before passing them along.
SWFUpload.prototype.unescapeFilePostParams = function (file) {
    var reg = /[$]([0-9a-f]{4})/i;
    var unescapedPost = {};
    var uk;

    if (file != undefined) {
        for (var k in file.post) {
            if (file.post.hasOwnProperty(k)) {
                uk = k;
                var match;
                while ((match = reg.exec(uk)) !== null) {
                    uk = uk.replace(match[0], String.fromCharCode(parseInt("0x" + match[1], 16)));
                }
                unescapedPost[uk] = file.post[k];
            }
        }

        file.post = unescapedPost;
    }

    return file;
};

// Private: Called by Flash to see if JS can call in to Flash (test if External Interface is working)
SWFUpload.prototype.testExternalInterface = function () {
    try {
        return this.callFlash("TestExternalInterface");
    } catch (ex) {
        return false;
    }
};

// Private: This event is called by Flash when it has finished loading. Don't modify this.
// Use the swfupload_loaded_handler event setting to execute custom code when SWFUpload has loaded.
SWFUpload.prototype.flashReady = function () {
    // Check that the movie element is loaded correctly with its ExternalInterface methods defined
    var movieElement = this.getMovieElement();

    if (!movieElement) {
        this.debug("Flash called back ready but the flash movie can't be found.");
        return;
    }

    this.cleanUp(movieElement);

    this.queueEvent("swfupload_loaded_handler");
};

// Private: removes Flash added fuctions to the DOM node to prevent memory leaks in IE.
// This function is called by Flash each time the ExternalInterface functions are created.
SWFUpload.prototype.cleanUp = function (movieElement) {
    // Pro-actively unhook all the Flash functions
    try {
        if (this.movieElement && typeof(movieElement.CallFunction) === "unknown") { // We only want to do this in IE
            this.debug("Removing Flash functions hooks (this should only run in IE and should prevent memory leaks)");
            for (var key in movieElement) {
                try {
                    if (typeof(movieElement[key]) === "function") {
                        movieElement[key] = null;
                    }
                } catch (ex) {
                }
            }
        }
    } catch (ex1) {

    }

    // Fix Flashes own cleanup code so if the SWFMovie was removed from the page
    // it doesn't display errors.
    window["__flash__removeCallback"] = function (instance, name) {
        try {
            if (instance) {
                instance[name] = null;
            }
        } catch (flashEx) {

        }
    };

};


/* This is a chance to do something before the browse window opens */
SWFUpload.prototype.fileDialogStart = function () {
    this.queueEvent("file_dialog_start_handler");
};


/* Called when a file is successfully added to the queue. */
SWFUpload.prototype.fileQueued = function (file) {
    file = this.unescapeFilePostParams(file);
    this.queueEvent("file_queued_handler", file);
};


/* Handle errors that occur when an attempt to queue a file fails. */
SWFUpload.prototype.fileQueueError = function (file, errorCode, message) {
    file = this.unescapeFilePostParams(file);
    this.queueEvent("file_queue_error_handler", [file, errorCode, message]);
};

/* Called after the file dialog has closed and the selected files have been queued.
 You could call startUpload here if you want the queued files to begin uploading immediately. */
SWFUpload.prototype.fileDialogComplete = function (numFilesSelected, numFilesQueued, numFilesInQueue) {
    this.queueEvent("file_dialog_complete_handler", [numFilesSelected, numFilesQueued, numFilesInQueue]);
};

SWFUpload.prototype.uploadStart = function (file) {
    file = this.unescapeFilePostParams(file);
    this.queueEvent("return_upload_start_handler", file);
};

SWFUpload.prototype.returnUploadStart = function (file) {
    var returnValue;
    if (typeof this.settings.upload_start_handler === "function") {
        file = this.unescapeFilePostParams(file);
        returnValue = this.settings.upload_start_handler.call(this, file);
    } else if (this.settings.upload_start_handler != undefined) {
        throw "upload_start_handler must be a function";
    }

    // Convert undefined to true so if nothing is returned from the upload_start_handler it is
    // interpretted as 'true'.
    if (returnValue === undefined) {
        returnValue = true;
    }

    returnValue = !!returnValue;

    this.callFlash("ReturnUploadStart", [returnValue]);
};



SWFUpload.prototype.uploadProgress = function (file, bytesComplete, bytesTotal) {
    file = this.unescapeFilePostParams(file);
    this.queueEvent("upload_progress_handler", [file, bytesComplete, bytesTotal]);
};

SWFUpload.prototype.uploadError = function (file, errorCode, message) {
    file = this.unescapeFilePostParams(file);
    this.queueEvent("upload_error_handler", [file, errorCode, message]);
};

SWFUpload.prototype.uploadSuccess = function (file, serverData, responseReceived) {
    file = this.unescapeFilePostParams(file);
    this.queueEvent("upload_success_handler", [file, serverData, responseReceived]);
};

SWFUpload.prototype.uploadComplete = function (file) {
    file = this.unescapeFilePostParams(file);
    this.queueEvent("upload_complete_handler", file);
};

/* Called by SWFUpload JavaScript and Flash functions when debug is enabled. By default it writes messages to the
 internal debug console.  You can override this event and have messages written where you want. */
SWFUpload.prototype.debug = function (message) {
    this.queueEvent("debug_handler", message);
};


/* **********************************
 Debug Console
 The debug console is a self contained, in page location
 for debug message to be sent.  The Debug Console adds
 itself to the body if necessary.

 The console is automatically scrolled as messages appear.

 If you are using your own debug handler or when you deploy to production and
 have debug disabled you can remove these functions to reduce the file size
 and complexity.
 ********************************** */

// Private: debugMessage is the default debug_handler.  If you want to print debug messages
// call the debug() function.  When overriding the function your own function should
// check to see if the debug setting is true before outputting debug information.
SWFUpload.prototype.debugMessage = function (message) {
    if (this.settings.debug) {
        var exceptionMessage, exceptionValues = [];

        // Check for an exception object and print it nicely
        if (typeof message === "object" && typeof message.name === "string" && typeof message.message === "string") {
            for (var key in message) {
                if (message.hasOwnProperty(key)) {
                    exceptionValues.push(key + ": " + message[key]);
                }
            }
            exceptionMessage = exceptionValues.join("\n") || "";
            exceptionValues = exceptionMessage.split("\n");
            exceptionMessage = "EXCEPTION: " + exceptionValues.join("\nEXCEPTION: ");
            SWFUpload.Console.writeLine(exceptionMessage);
        } else {
            SWFUpload.Console.writeLine(message);
        }
    }
};

SWFUpload.Console = {};
SWFUpload.Console.writeLine = function (message) {
    var console, documentForm;

    try {
        console = document.getElementById("SWFUpload_Console");

        if (!console) {
            documentForm = document.createElement("form");
            document.getElementsByTagName("body")[0].appendChild(documentForm);

            console = document.createElement("textarea");
            console.id = "SWFUpload_Console";
            console.style.fontFamily = "monospace";
            console.setAttribute("wrap", "off");
            console.wrap = "off";
            console.style.overflow = "auto";
            console.style.width = "700px";
            console.style.height = "350px";
            console.style.margin = "5px";
            documentForm.appendChild(console);
        }

        console.value += message + "\n";

        console.scrollTop = console.scrollHeight - console.clientHeight;
    } catch (ex) {
        alert("Exception: " + ex.name + " Message: " + ex.message);
    }
};

SWFUpload.prototype.support = {
    loading : swfobject.hasFlashPlayerVersion("9.0.28")
};





/**
 * 上传组件
 */
 
;(function($) {
    var upload_index = 1;
	var swfu = null;
	var file_info = {};
	var upload_id;
    $.fn.griUpload = function(options) {
        var $this = $(this);

		var is_form = 0;
		// serialize
		
		// 动态添加样式文件
		if ($('#gri_uploadt_css').length < 1) {
			var css_text = '<style id="gri_uploadt_css" type="text/css">';	
			
			css_text += '.fileList {width:430px;list-style:none;margin:0;padding:0;text-align:left;}';
			css_text += '.fileList li {border-bottom:1px dashed #E3E3E3;padding:5px 0;}';
			css_text += '.fileList li p {width:100%;clear:both;overflow:hidden;zoom:-1;margin:5px auto;}';
			css_text += '.fileList li span {display:block;float: left;}';
			css_text += '.fileList li s {text-decoration:none;color:#F00;margin:0 3px;}';
			css_text += '.progress {width:350px;text-align:left;border:1px solid #D5D5D5;height:12px;font-size:5px;margin-right:10px;}';
			css_text += '.fileList li .delFile {color:#C00;margin-left:10px;}';
			css_text += '.fileList li .progress s {display:block;background-color:#9C0;width:0%;height:12px;margin:0;}';
			css_text += '.upload_file{border:#ccc solid 1px; padding-left:5px; width:250px;vertical-align:top; height:18px; margin-right:5px}';
			css_text += '.swfupload{vertical-align:top;}';
			
			css_text += '</style>';
			$('head').before(css_text);
		}
		
		var preLoad = function() {
			if (!this.support.loading) {
				if (!is_form) {
					alert("需要安装9.028以上的flashPlayer");
				}
				return false;
			}
		};
		var loadFailed = function() {
			function loadFailed() {
				alert("加载失败");
			}
		};

		var fileQueued = function(file) {
			
			try {
				file_info.file_type = file.type.replace(/\./,'');
				file_info.file_size = file.size;
				file_info.file_name = file.name;
				file_info.file_id = file.id;
				welcome = $('#'+upload_id+'_notice');
				var fileList = (is_form == 0) ? "<ul class='fileList'>" : "<ul class='fileList' style='display:none;'>";
				fileList += "<li id='" + file.id + "'>";
				if (is_form == 0) {
					fileList += "<p class='fileName'>" + file.name + "</p>";
				}
				fileList += "<p><span class='progress'><s></s></span><span class='jdNum'>0%</span> <a href='#' class='delFile'>取消</a></p>";
				fileList += "<p class='info'>等待上传...</p>";
				fileList += "</li>";
				fileList += "</ul>";
				
				welcome.html(fileList);

				$("a.delFile").click(function(event) {
					event.preventDefault();
					var p = $(this).parent().parent(),
						fid = p.attr("id");

					swfu.cancelUpload(fid, false);
					p.remove();
				});
				return false;

			} catch (ex) {
				this.debug(ex);
			}
		};
		var fileQueueError = function(file, errorCode, message) {
			var welcome = $('#'+upload_id+'_notice');
			try {
				if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
					alert("你一次上传的文件超过设置");
					return;
				}

				switch (errorCode) {
				case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
					welcome.text("错误提示：文件太大，文件名： " + file.name + ", 文件大小： " + file.size + ", Message: " + message);
					this.debug("错误提示：文件太大，文件名： " + file.name + ", 文件大小： " + file.size + ", Message: " + message);
					break;
				case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
					welcome.text("错误提示：零字节文件，文件名：" + file.name + ", 文件大小： " + file.size + ", Message: " + message);
					this.debug("错误提示：零字节文件，文件名：" + file.name + ", 文件大小： " + file.size + ", Message: " + message);
					break;
				case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
					welcome.text("错误提示：无效的文件类型，文件名：" + file.name + ", 文件大小：" + file.size + ", Message: " + message);
					this.debug("错误提示：无效的文件类型，文件名：" + file.name + ", 文件大小：" + file.size + ", Message: " + message);
					break;
				default:
					if (file !== null) {
						welcome.text("未处理的错误");
					}
					this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
					break;
				}
			} catch (ex) {
				this.debug(ex);
			}
		};
		
		var fileDialogStart = function() {
			if (is_form == 1) {
				$('#'+upload_id+'_file').val('');
				$this.find("a.delFile").click();
				//file_info = {};
				this.cancelUpload();
			}
		}
		var fileDialogComplete = function(numFilesSelected, numFilesQueued) {
			if (is_form == 1) {
				$('#'+upload_id+'_file').val(file_info.file_name);
			} else  {
				if (numFilesQueued == 1) {
					var data = file_info;
					data.check_mode = 1;
					var self = this;
					data = $.extend(data, self.settings['post_params']);
					$.post(self.settings['upload_url'], data, function(json){
						 if (json!=null && (typeof(json.code) == 'undefined' || json.code=='-1')) {
							var text = typeof(json.code) == 'undefined' ? '上传发生错误' : json.msg;
							var stats = $("#" + file_info.file_id).find("p.info");
							stats.html("<s>"+text+"</s>");
							
							swfu.cancelUpload(file_info.file_id, false);
							//file_info = {};
						} else {
							try {
								self.startUpload();
							} catch (ex) {
								self.debug(ex);
							}
						}
					}, 'json').error(function () {
						var stats = $("#" + file_info.file_id).find("p.info");
						stats.html("<s>上传发生错误</s>");
						//file_info = {};
						swfu.cancelUpload(file_info.file_id, false);
					});
				} else {
					try {
						this.startUpload();
					} catch (ex) {
						this.debug(ex);
					}		
				}
			}
		};
		var uploadStart = function(file) {
			try {
				var stats = $("#" + file.id).find("p.info");
				stats.html("已上传<s class='yscSize'>0</s>M");
			} catch (ex) {}
			return true;
		};
		var uploadProgress = function(file, bytesLoaded, bytesTotal) {
			try {
				var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);
				var fileList = $("#" + file.id),
					progress = fileList.find(".progress"),
					jdNum = fileList.find(".jdNum"),
					yscSize = fileList.find("s.yscSize");

				progress.find("s").css("width", percent + "%");
				
				if (percent != 100) {
					jdNum.html(percent + "%");
				} else {
					jdNum.html("计算中...");
				}
				yscSize.text(Math.ceil(bytesLoaded*100/(1024*1024))/100);
				
			} catch (ex) {
				this.debug(ex);
			}
		};
		var uploadSuccess = function(file, serverData) {
			swfu.debug(serverData);
			try {
				var data = {};
				if (serverData !='') {
					eval("data="+serverData);
				} else {
					data.code = 0;
				}
				if (typeof (data.code) != 'undefined' && data.code == '0') {
					var stats = $("#" + file.id).find("p.info");
					stats.html("<s>上传成功</s>");
					if (typeof(options.callback) != 'undefined') {
						options.callback(data);
					}
				} else {
					var text = typeof (data.msg) != 'undefined' ? data.msg : '服务器错误';
					var stats = $("#" + file.id).find("p.info");
					stats.html("<s>上传失败,"+text+"</s>");
				
				}
				$("#" + file.id).find(".jdNum").html('');

			} catch (ex) {
				this.debug(ex);
			}
		};
		var uploadError = function(file, errorCode, message) {
			try {
				var stats = $("#" + file.id).find("p.info");

				switch (errorCode) {
				case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
					if (message == '502') {
						stats.text("网关错误(502): 请清除浏览器缓存重试");
					} else {
						stats.text("上传错误: " + message);
					}
					this.debug("错误提示：http错误，文件名：" + file.name + ", 信息： " + message);
					break;
				case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
					stats.text("上传失败");
					this.debug("错误提示：上传失败，文件名称: " + file.name + ", 文件大小：" + file.size + ", 信息：" + message);
					break;
				case SWFUpload.UPLOAD_ERROR.IO_ERROR:
					stats.text("服务器错误");
					this.debug("错误提示：服务器错误, 文件名称: " + file.name + ", 信息： " + message);
					break;
				case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
					progress.setStatus("安全性错误");
					this.debug("错误提示： 安全性错误, 文件名称: " + file.name + ", 信息： " + message);
					break;
				case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
					progress.setStatus("上传超过限制。");
					this.debug("错误提示：上传超过限制,文件名称:  " + file.name + ", 文件大小： " + file.size + ", 信息：" + message);
					break;
				case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
					progress.setStatus("验证失败。上传跳过。");
					this.debug("错误提示： 验证失败，上传跳过。文件名称: " + file.name + ", 文件大小： " + file.size + ", 信息：" + message);
					break;
				case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
					break;
				case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
					stats.text("停止");
					break;
				default:
					stats.text("未知错误: " + errorCode);
					this.debug("错误提示： " + errorCode + ", 文件名称: " + file.name + ", 文件大小：" + file.size + ", 信息： " + message);
					break;
				}
			} catch (ex) {
				this.debug(ex);
			}
		};
		var uploadComplete = function(file) {
			//console.log(this);
			var self = this;
			if (file.filestatus == -5) {
				self.startUpload();
			} else {
				self.startUpload();
			}
		};
		
		var bindEvent = function() {
			if (swfu.support.loading) {
				if (is_form == 1) {
					$this.find("input[type='submit']").unbind('click').click(function(event){
						event.stopPropagation();
						var data = file_info;
						data.check_mode = 1;
						data = $.extend(data, swfu.settings['post_params']);
						//var self = this;
						$('.fileList').show();
						var str = serialize($this);
						for (var i in data) {
							str += '&'+i+'='+data[i];
						}
						$.post(swfu.settings['upload_url'], str, function(json){
							 if (json!=null && (typeof(json.code) == 'undefined' || json.code=='-1')) {
								var text = typeof(json.code) == 'undefined' ? '上传发生错误' : json.msg;
								if ($(".fileList").length>0 && $(".fileList").find("p.info").length>0) {
									var stats = $(".fileList").find("p.info");
									stats.html("<s>"+text+"</s>");
								} else {
									alert(text);
								}
								$('#'+upload_id+'_file').val('');
								//file_info = {};
								swfu.cancelUpload();
							} else {
								try {
									var arr = str.split('&');
									var data = {};
									for (var i in arr) {
										var li_pos = arr[i].indexOf("=");
										if (li_pos > 0) {
											var name = arr[i].substring(0, li_pos);
											var value = arr[i].substr(li_pos + 1);
											if (name != 'check_mode') {
												data[name] = value;
											}
										}
									}
									swfu.setPostParams(data);
									swfu.startUpload();
								} catch (ex) {
									swfu.debug(ex);
								}
							}
						}, 'json').error(function () {
								var stats = $("#" + file_info.file_id).find("p.info");
								stats.html("<s>上传发生错误</s>");
								//file_info = {};
								swfu.cancelUpload(file_info.file_id, false);
						});
						return false;
					});
				}
			} else {
				var no_flash_url = settings['upload_url'].indexOf('?') != -1 ? settings['upload_url']+'&ifm_init=1' : settings['upload_url']+'?ifm_init=1'
				$('#'+upload_id+'_file').replaceWith('<iframe name="'+upload_id+'_ifm" id="'+upload_id+'_ifm" frameborder="0" src="'+no_flash_url+'" style="height:22px;width:400px;vertical-align:middle;"></iframe>');
				$this.find("input[type='submit']").unbind('click').click(function(){
					var obj = document.getElementById(upload_id+'_ifm');
					if (typeof(obj.contentWindow) != 'undefined') {
						obj = obj.contentWindow;
					}
					if (typeof(obj.smt) != 'undefined') {
						var str = serialize($this);
						obj.smt(str);
					}
					return false;
				});
				window.ifm_callback = function(json) {
					if (json!=null && (typeof(json.code) == 'undefined' || json.code=='-1')) {
						var text = typeof(json.code) == 'undefined' ? '提交错误' : json.msg;
						alert(text);
					} else {
						if (typeof(settings.callback) != 'undefined') {
							settings.callback(json);
						} else {
							alert('提交成功');
						}
					}
				};
			}
		}
		
		if (swfu != null && $this.attr('init')) {		
			var settings = {
				swfupload_preload_handler: preLoad,
				swfupload_load_failed_handler: loadFailed,
				file_dialog_start_handler: fileDialogStart,
				file_queued_handler: fileQueued,
				file_queue_error_handler: fileQueueError,
				file_dialog_complete_handler: fileDialogComplete,
				upload_start_handler: uploadStart,
				upload_progress_handler: uploadProgress,
				upload_error_handler: uploadError,
				upload_success_handler: uploadSuccess,
				upload_complete_handler: uploadComplete,
				button_placeholder_id: upload_id
			};
			settings = $.extend(settings, $.fn.griUpload.defaults, options);
			// settings.post_params.file_types = settings.file_types;		
			swfu = new SWFUpload(settings);
			if ($this.get(0).tagName == 'FORM') {
				is_form = 1;
				options.file_queue_limit = 1;
			}
			bindEvent();
			return;
		} else {
			$this.attr('init', '1');
			upload_id = 'mul_id_' + upload_index++;
			if ($this.get(0).tagName == 'FORM') {
				if (typeof (options.button_id) == 'undefined') {
					return ;
				} else {
					upload_id = options.button_id;
				}
				is_form = 1;
				options.file_queue_limit = 1;
				$('#'+upload_id).before('<input id="'+upload_id+'_file" type="text" disabled="true" value="" class="upload_file" />');
			} else {
				if ($this.attr('id') == '') {
					$this.attr('id', upload_id);
				} else {
					upload_id = $this.attr('id');
				}
			}

			// 如果传入多个对象
			if ($this.length>1) {
				/*$this.each(function(){
					$(this).griUpload(options);
				});*/
				return;
			}
		}

		if ($('#'+upload_id+'_notice').length < 1) {
			$('#'+upload_id).after('<p id="'+upload_id+'_notice"></p>');
		}
		
		var settings = {
			swfupload_preload_handler: preLoad,
			swfupload_load_failed_handler: loadFailed,
			file_dialog_start_handler: fileDialogStart,
			file_queued_handler: fileQueued,
			file_queue_error_handler: fileQueueError,
			file_dialog_complete_handler: fileDialogComplete,
			upload_start_handler: uploadStart,
			upload_progress_handler: uploadProgress,
			upload_error_handler: uploadError,
			upload_success_handler: uploadSuccess,
			upload_complete_handler: uploadComplete,
			button_placeholder_id: upload_id
		};
		
        settings = $.extend(settings, $.fn.griUpload.defaults, options);
		settings.post_params.file_types = settings.file_types;
		
		if (!settings.show_loading) {
			settings.file_queued_handler = function(file) {
				
				try {
					file_info.file_type = file.type.replace(/\./,'');
					file_info.file_size = file.size;
					file_info.file_name = file.name;
					file_info.file_id = file.id;
				
					return false;

				} catch (ex) {
					this.debug(ex);
				}
			};
			settings.file_queue_error_handler = function(file, errorCode, message){alert(message);}
			settings.file_dialog_complete_handler = function(numFilesSelected, numFilesQueued) {
				if (is_form == 1) {
					$('#'+upload_id+'_file').val(file_info.file_name);
				} else  {
					if (numFilesQueued == 1) {
						var data = file_info;
						data.check_mode = 1;
						var self = this;
						data = $.extend(data, self.settings['post_params']);
						$.post(self.settings['upload_url'], data, function(json){
							 if (json!=null && (typeof(json.code) == 'undefined' || json.code=='-1')) {
								var text = typeof(json.code) == 'undefined' ? '上传发生错误' : json.msg;
								alert(text);
								swfu.cancelUpload(file_info.file_id, false);
								//file_info = {};
							} else {
								try {
									self.startUpload();
								} catch (ex) {
									self.debug(ex);
								}
							}
						}, 'json').error(function () {
							alert('上传发生错误');
							//file_info = {};
							swfu.cancelUpload(file_info.file_id, false);
						});
					} else {
						try {
							this.startUpload();
						} catch (ex) {
							this.debug(ex);
						}		
					}
				}	
			};
			settings.upload_success_handler = function(file, serverData) {
				try {
					var data = {};
					if (serverData !='') {
						eval("data="+serverData);
					} else {
						data.code = 0;
					}
					if (typeof (data.code) != 'undefined' && data.code == '0') {
						if (typeof(options.callback) != 'undefined') {
							options.callback(data);
						} else {
							alert('上传成功');
						}
					} else {
						var text = typeof (data.msg) != 'undefined' ? data.msg : '服务器错误';
						alert(text);
					}

				} catch (ex) {
					this.debug(ex);
				}
			};
			settings.uploadError = function(file, errorCode, message) {
				try {
					alert(message);
				} catch (ex) {
					this.debug(ex);
				}
			};
		}
		
		//初始化swfupland组件
		swfu = new SWFUpload(settings);
		
		bindEvent();
    }
	
	// 把编码decodeURIComponent反转之后，再escape
	function serialize(obj) {
		var parmString = obj.serialize();
		var parmArray = parmString.split("&");
		var parmStringNew = "";
		$.each(parmArray, function (index, data) {
			var li_pos = data.indexOf("=");
			if (li_pos > 0) {
				var name = decodeURIComponent(data.substring(0, li_pos));
				var value = (decodeURIComponent(data.substr(li_pos + 1)));
				var parm = name + "=" + value;
				parmStringNew = parmStringNew == "" ? parm : parmStringNew + '&' + parm;
			}
		});
		return parmStringNew;
	}
    
    
    // 获得元素的绝对位置
    function getElementAbsPos(e) {  
        var t = e.offsetTop;  
        var l = e.offsetLeft; 
        while (e = e.offsetParent) {  
            t += e.offsetTop;  
            l += e.offsetLeft;  
        }  
        return {left:l,top:t};  
    }  
            
    // 默认参数
    $.fn.griUpload.defaults = {
		flash_url: "/mta/resource/thirdpart/swfupload/swfupload.swf",
		flash9_url: "/mta/resource/thirdpart/swfupload/swfupload_fp9.swf",
		upload_url: "",                               //PHP上传程序
		post_params: {},
		file_size_limit: 0,
		file_types: "*.*",
		file_types_description: "All Files",
		file_upload_limit: 100,
		file_queue_limit : 0,
		debug: false,

		// Button settings
		button_image_url: "/mta/resource/thirdpart/swfupload/XPButtonNoText_61x22.png",
		button_width: "61",
		button_height: "22",
		button_text: '浏览',
		button_text_left_padding: 15,
		button_text_top_padding: 0,
		
		// other
		show_loading: true
    };
})(jQuery);
