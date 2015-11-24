/*
Copyright 2011, KISSY UI Library v1.1.5
MIT Licensed
build time: Sep 11 10:29
*/define("bui/uploader/button/swfButton/ajbridge",["bui/common","bui/swf"],function(e){function i(e){i.superclass.constructor.call(this,e)}var t=e("bui/common"),n=e("bui/swf"),r={};return t.mix(i,{eventHandler:function(e,t){var n=r[e];n&&n.__eventHandler(e,t)},augment:function(e,n){t.isString(n)&&(n=[n]);if(!t.isArray(n))return;t.each(n,function(t){e.prototype[t]=function(){try{return this.callSWF(t,Array.prototype.slice.call(arguments,0))}catch(e){this.fire("error",{message:e})}}})}}),t.extend(i,n),t.augment(i,{initializer:function(){i.superclass.initializer.call(this);var e=this,t=e.get("attrs"),n=t.id;r[n]=e,e.set("id",n)},__eventHandler:function(e,n){var r=this,i=n.type;n.id=e;switch(i){case"log":t.log(n.message);break;default:r.fire(i,n)}},destroy:function(){i.superclass.destroy.call(this);var e=this.get("id");r[e]&&delete r[e]}}),i.augment(i,["activate","getReady","getCoreVersion","setFileFilters","filter","setAllowMultipleFiles","multifile","browse","upload","uploadAll","cancel","getFile","removeFile","lock","unlock","setBtnMode","useHand","clear"]),t.AJBridge=i,i}),define("bui/uploader/button/filter",["bui/common"],function(e){var t=e("bui/common"),n={msexcel:{type:"application/msexcel",ext:".xls,.xlsx"},msword:{type:"application/msword",ext:".doc,.docx"},gif:{type:"image/gif",ext:".gif"},jpeg:{type:"image/jpeg",ext:".jpg"},bmp:{type:"image/x-ms-bmp",ext:".bmp"},png:{type:"image/png",ext:".png"}};return{_getValueByDesc:function(e,r){var i=[];return t.isString(e)&&(e=e.split(",")),t.isArray(e)&&t.each(e,function(e,t){var s=n[e];s&&s[r]&&i.push(s[r])}),i.join(",")},getTypeByDesc:function(e){return this._getValueByDesc(e,"type")},getExtByDesc:function(e){return this._getValueByDesc(e,"ext")},getTypeByExt:function(e){var r=[];return t.isString(e)&&(e=e.split(",")),t.isArray(e)&&t.each(e,function(e){t.each(n,function(n,i){t.Array.indexOf(e,n.ext.split(","))>-1&&r.push(n.type)})}),r.join(",")}}}),define("bui/uploader/button/base",["bui/common","./filter"],function(e){function a(e){return e.replace(/.*(\/|\\)/,"")}function f(e){var t=/\.[^\.]+$/.exec(e)||[];return t.join("").toLowerCase()}function l(e){var t=-1;do e/=1024,t++;while(e>99);return Math.max(e,.1).toFixed(1)+["KB","MB","GB","TB","PB","EB"][t]}function c(e){return e.id||t.guid("bui-uploader-file")}var t=e("bui/common"),n=t.Component,r=e("bui/uploader/button/filter"),i=t.prefix,s=i+"uploader",o=s+"-button",u=o+"-text",h=n.View.extend({_uiSetText:function(e){var t=this,n=t.get("text"),r=t.get("textCls"),i=t.get("el").find("."+r);i.text(n)}},{ATTRS:{}},{xclass:"uploader-button-view"}),p=n.Controller.extend({getExtFileData:function(e){var t=a(e.name),n=l(e.size||0),r=f(e.name),i={name:t,size:e.size,type:e.type,textSize:n,ext:r,id:c(e)};return i},_getFile:function(e){var n=this,r=n.getExtFileData(e);return t.mix(e,r),e.attr=r,e},getFilter:function(e){if(e){var t=[],n=[],i=[];return e.desc&&(t.push(e.desc),n.push(r.getExtByDesc(e.desc)),i.push(r.getTypeByDesc(e.desc))),e.ext&&(n.push(e.ext),i.push(r.getTypeByExt(e.ext))),e.type,{desc:t.join(","),ext:n.join(","),type:i.join(",")}}}},{ATTRS:{buttonCls:{value:o+"-wrap",view:!0},textCls:{value:u,view:!0},text:{view:!0,value:"\u4e0a\u4f20\u6587\u4ef6"},name:{value:"fileData"},tpl:{view:!0,value:'<a href="javascript:void(0);" class="'+o+"-wrap"+'"><span class="'+u+'">{text}</span></a>'},disabled:{value:!1},multiple:{value:!0},filter:{shared:!1,value:[]},events:{value:{change:!1}},xview:{value:h}}},{xclass:"uploader-button"});return p.View=h,p}),define("bui/uploader/button/htmlButton",["bui/uploader/button/base"],function(e){var t=e("bui/common"),n=t.Component,r=e("bui/uploader/button/base"),i=t.UA,s=r.extend({renderUI:function(){var e=this;e._createInput()},_createInput:function(){var e=this,n=e.get("buttonCls"),r=e.get("el").find("."+n),s=e.get("inputTpl"),o=e.get("name"),u;s=t.substitute(s,{name:o}),r.append(s),u=r.find("input"),i.ie==6&&u.css("fontSize","400px"),e._bindChangeHandler(u),e.set("fileInput",u),e._uiSetMultiple(e.get("multiple")),e._uiSetDisabled(e.get("disabled")),e._uiSetFilter(e.get("filter"))},_bindChangeHandler:function(e){var n=this;$(e).on("change",function(r){var i=$(this).val(),s=r.target.files,o=[];s?t.each(s,function(t){o.push(n._getFile({name:t.name,type:t.type,size:t.size,file:t,input:e}))}):o.push(n._getFile({name:i,input:e})),n.fire("change",{files:o,input:this}),n.reset()})},reset:function(){var e=this,t=e.get("fileInput");return t.parent().remove(),e.set("fileInput",null),e._createInput(),e},_uiSetMultiple:function(e){var t=this,n=t.get("fileInput");return!n||!n.length?!1:(e?n.attr("multiple","multiple"):n.removeAttr("multiple"),e)},_uiSetDisabled:function(e){var t=this,n=t.get("fileInput");e?n.hide():n.show()},_uiSetFilter:function(e){var t=this,n=t.get("fileInput"),r=t.getFilter(e);return!n||!n.length?!1:(r.type&&n.attr("accept",r.type),r)},_uiSetName:function(e){$(this.get("fileInput")).attr("name",e)}},{ATTRS:{inputTpl:{view:!0,value:'<div class="file-input-wrapper"><input type="file" name="{name}" hidefocus="true" class="file-input" /></div>'},fileInput:{}}},{xclass:"uploader-htmlButton"});return s}),define("bui/uploader/button/swfButton",["bui/common","./base","./swfButton/ajbridge"],function(e){function o(){if(window.seajs)return seajs.pluginSDK?seajs.pluginSDK.util.loaderDir:seajs.data.base;if(window.KISSY)return KISSY.Config.packages.bui.base}var t=e("bui/common"),n=t.Component,r=e("bui/uploader/button/base"),i=o(),s=e("bui/uploader/button/swfButton/ajbridge"),u=r.extend({renderUI:function(){var e=this;e._initSwfUploader()},bindUI:function(){var e=this,n=e.get("swfUploader");n.on("contentReady",function(r){e.fire("swfReady",{swfUploader:n}),n.on("fileSelect",function(n){var r=n.fileList,i=[];t.each(r,function(t){i.push(e._getFile(t))}),e.fire("change",{files:i})})})},syncUI:function(){var e=this,t=e.get("swfUploader");t.on("contentReady",function(t){e._uiSetMultiple(e.get("multiple")),e._uiSetFilter(e.get("filter"))})},_initSwfUploader:function(){var e=this,n=e.get("buttonCls"),r=e.get("el").find("."+n),i=e.get("flash"),o=e.get("flashUrl"),u=e.get("swfTpl"),a=$(u).appendTo(r),f;t.mix(i,{render:a,src:o}),f=new s(i),e.set("swfEl",a),e.set("swfUploader",f)},_uiSetMultiple:function(e){var t=this,n=t.get("swfUploader");return n&&n.multifile(e),e},_uiSetDisabled:function(e){var t=this,n=t.get("swfEl");return e?n.hide():n.show(),e},_convertFilter:function(e){var n=e.desc,r=[];return t.each(e.ext.split(","),function(e){e&&r.push("*"+e)}),e.ext=r.join(";"),e},_uiSetFilter:function(e){var t=this,n=t.get("swfUploader"),r=t._convertFilter(t.getFilter(e));return n&&n.filter([r]),e}},{ATTRS:{swfEl:{},swfUploader:{},flashUrl:{value:i+"uploader/uploader.swf"},flash:{value:{params:{allowscriptaccess:"always",bgcolor:"#fff",wmode:"transparent",flashvars:{hand:!0,btn:!0,jsEntry:"BUI.AJBridge.eventHandler"}}},shared:!1},swfTpl:{view:!0,value:'<div class="uploader-button-swf"></div>'}}},{xclass:"uploader-swfButton"});return u}),define("bui/uploader/type/base",["bui/common"],function(e){function n(e){var t=this;n.superclass.constructor.call(t,e)}var t=e("bui/common");return n.ATTRS={file:{},url:{},data:{},fileDataName:{value:"Filedata"},events:{value:{start:!1,cancel:!1,success:!1,error:!1}}},t.extend(n,t.Base,{upload:function(e){},cancel:function(){},_processResponse:function(e){var n=this,r=n.get("file"),i;if(t.isString(e))try{i=t.JSON.parse(e)}catch(s){i=e}else t.isObject(e)&&(i=n._fromUnicode(e));return t.log("\u670d\u52a1\u5668\u7aef\u8f93\u51fa\uff1a"+t.JSON.stringify(i)),i},_fromUnicode:function(e){function n(e){t.each(e,function(r,i){t.isObject(e[i])?n(e[i]):e[i]=t.isString(r)&&t.fromUnicode(r)||r})}return t.isObject(e)?(n(e),e):e},reset:function(){}}),n}),define("bui/uploader/type/ajax",["./base"],function(e){function i(e){var t=this;i.superclass.constructor.call(t,e)}var t="",n="[uploader-Ajax]:",r=e("bui/uploader/type/base");return BUI.extend(i,r,{upload:function(e){if(!e||!e.file)return BUI.log(n+"upload()\uff0cfileData\u53c2\u6570\u6709\u8bef\uff01"),!1;var t=this;return t.set("file",e),t.fire("start",{file:e}),t._setFormData(),t._addFileData(e.file),t.send(),t},cancel:function(){var e=this,t=e.get("xhr"),n=e.get("file");return t&&(t.abort(),e.fire("cancel",{file:n})),e.set("file",null),e},send:function(){var e=this,t=e.get("url"),n=e.get("formData"),r=e.get("file"),i=new XMLHttpRequest;return i.upload.addEventListener("progress",function(t){e.fire("progress",{loaded:t.loaded,total:t.total})}),i.onload=function(t){var n=e._processResponse(i.responseText);e.fire("complete",{result:n,file:r})},i.onerror=function(t){e.fire("error",{file:r})},i.open("POST",t,!0),i.send(n),e._setFormData(),e.set("xhr",i),e},reset:function(){},_setFormData:function(){var e=this;try{e.set("formData",new FormData),e._processData()}catch(t){BUI.log(n+"something error when reset FormData."),BUI.log(t,"dir")}},_processData:function(){var e=this,t=e.get("data"),n=e.get("formData");BUI.each(t,function(e,t){n.append(t,e)}),e.set("formData",n)},_addFileData:function(e){if(!e)return BUI.log(n+"_addFileData()\uff0cfile\u53c2\u6570\u6709\u8bef\uff01"),!1;var t=this,r=t.get("formData"),i=t.get("fileDataName");r.append(i,e),t.set("formData",r)}},{ATTRS:{formData:{},xhr:{},events:{value:{progress:!1}}}}),i}),define("bui/uploader/type/flash",["./base"],function(e){function s(e){var t=this;s.superclass.constructor.call(t,e)}var t="[uploader-Flash]:",n=e("bui/uploader/type/base"),r=new RegExp("^([^?#]+)?(?:\\?([^#]*))?(?:#(.*))?$"),i=new RegExp("^(?:([\\w\\d+.-]+):)?(?://([\\w\\d\\-\\u0100-\\uffff.+%]*))?.*$");return BUI.extend(s,n,{_initSwfUploader:function(){var e=this,n=e.get("swfUploader");if(!n)return BUI.log(t+"swfUploader\u5bf9\u8c61\u4e3a\u7a7a\uff01"),!1;e.fire("swfReady"),e._hasCrossdomain(),n.on("uploadStart",function(t){var n=e.get("file");e.fire("start",{file:n})}),n.on("uploadProgress",function(n){BUI.mix(n,{loaded:n.bytesLoaded,total:n.bytesTotal}),BUI.log(t+"\u5df2\u7ecf\u4e0a\u4f20\u5b57\u8282\u6570\u4e3a\uff1a"+n.bytesLoaded),e.fire("progress",{loaded:n.loaded,total:n.total})}),n.on("uploadCompleteData",function(t){var n=e.get("file"),r=e._processResponse(t.data);e.fire("complete",{result:r,file:n}),e.set("file",null)}),n.on("uploadError",function(){var t=e.get("file");e.fire("error",{file:t}),e.set("file",null)})},upload:function(e){var t=this,n=t.get("swfUploader"),r=t.get("url"),i="POST",s=t.get("data"),o=t.get("fileDataName");if(!e)return;return t.set("file",e),n.upload(e.id,r,i,s,o),t},cancel:function(){var e=this,t=e.get("swfUploader"),n=e.get("file");return n&&(t.cancel(n.id),e.fire("cancel",{file:n}),e.set("file",null)),e},_hasCrossdomain:function(){var e=this,t=e.get("url").match(i)||[],n=e.get("swfUploader").get("src").match(i)||[],r=t[2],s=n[2];r&&s&&r!==s&&$.ajax({url:t[1]+"://"+r+"/crossdomain.xml",dataType:"xml",error:function(){BUI.log("\u7f3a\u5c11crossdomain.xml\u6587\u4ef6\u6216\u8be5\u6587\u4ef6\u4e0d\u5408\u6cd5\uff01")}})}},{ATTRS:{uploader:{setter:function(e){var t=this;if(e&&e.isController){var n=e.get("button");n.on("swfReady",function(e){t.set("swfUploader",e.swfUploader),t._initSwfUploader()})}}},url:{setter:function(e){var t=/^http/;if(!t.test(e)){var n=location.href.match(r)||[],i=n[1]||"",s=i.split("/"),o;o=BUI.Array.filter(s,function(e,t){return t<s.length-1}),e=o.join("/")+"/"+e}return e}},swfUploader:{},uploadingId:{},events:{value:{swfReady:!1,progress:!1}}}}),s}),define("bui/uploader/type/iframe",["./base"],function(e){function r(e){var t=this;r.superclass.constructor.call(t,e)}var t="bui-uploader-iframe-",n=e("bui/uploader/type/base");return BUI.extend(r,n,{upload:function(e){var t=this,n=e.input,r;if(!e)return!1;t.fire("start",{file:e}),t.set("file",e),t.set("fileInput",n),t._create(),r=t.get("form"),r&&r[0].submit()},cancel:function(){var e=this,t=e.get("iframe");return e.reset(),e.fire("cancel"),e},dataToHidden:function(e){if(!$.isPlainObject(e)||$.isEmptyObject(e))return"";var t=this,n=[],r=t.get("tpl"),i=r.HIDDEN_INPUT;if(!BUI.isString(i))return"";for(var s in e)n.push(BUI.substitute(i,{name:s,value:e[s]}));return n.join()},_createIframe:function(){var e=this,n=t+BUI.guid(),r=e.get("tpl"),i=r.IFRAME,s=e.get("iframe"),o;return $.isEmptyObject(s)?(o=$(BUI.substitute(r.IFRAME,{id:n})),$("body").append(o),o.on("load",function(t){e._iframeLoadHandler(t)}),e.set("id",n),e.set("iframe",o),o):s},_iframeLoadHandler:function(e){var t=this,n=e.target,r=n.contentDocument||window.frames[n.id].document,i;if(!r||!r.body)return t.fire("error",{msg:"\u670d\u52a1\u5668\u7aef\u8fd4\u56de\u6570\u636e\u6709\u95ee\u9898\uff01"}),!1;var s=r.body.innerHTML;if(s==""){t.fire("error");return}i=t._processResponse(s),t.fire("complete",{result:i,file:t.get("file")}),t.reset()},_createForm:function(){var e=this,t=e.get("id"),n=e.get("tpl"),r=n.FORM,i=e.get("data"),s=e.get("url"),o=e.get("fileInput"),u,a;return BUI.isString(r)?BUI.isString(s)?(u=e.dataToHidden(i),u+=e.dataToHidden({type:"iframe"}),a=BUI.substitute(r,{action:s,target:t,hiddenInputs:u}),a=$(a).append(o),$("body").append(a),e.set("form",a),a):!1:!1},_create:function(){var e=this,t=e._createIframe(),n=e._createForm();e.fire("create",{iframe:t,form:n})},_remove:function(){var e=this,t=e.get("form");if(!t)return!1;t.remove(),e.set("form",null),e.fire("remove",{form:t})},reset:function(){var e=this;e._remove(),e.set("file",null)}},{ATTRS:{tpl:{value:{IFRAME:'<iframe src="javascript:false;" name="{id}" id="{id}" border="no" width="1" height="1" style="display: none;" />',FORM:'<form method="post" enctype="multipart/form-data" action="{action}" target="{target}" style="visibility: hidden;">{hiddenInputs}</form>',HIDDEN_INPUT:'<input type="hidden" name="{name}" value="{value}" />'}},id:{value:t+BUI.guid()},iframe:{value:{}},form:{},fileInput:{},events:{value:{create:!1,remove:!1}}}}),r}),define("bui/uploader/queue",["bui/common","bui/list"],function(e){var t=e("bui/common"),n=e("bui/list/simplelist"),r=t.prefix+"queue",i=r+"-item",s=n.extend({bindUI:function(){var e=this,t=e.get("el"),n=e.get("delCls");t.delegate("."+n,"click",function(t){var n=$(t.target).parents(".bui-queue-item"),r=e.get("uploader"),i=e.getItemByElement(n);r&&r.cancel&&r.cancel(i),e.removeItem(i)})},updateFileStatus:function(e,n,r){var i=this,s=i.get("itemStatusFields");r=r||i.findElement(e),t.each(s,function(t,n){i.setItemStatus(e,n,!1,r)}),i.setItemStatus(e,n,!0,r),i._setResultTpl(e,n),i.updateItem(e)},_setResultTpl:function(e,n){var r=this,i=r.get("resultTpl"),s=i[n]||i["default"],o=t.mix({},e.attr,e.result);e.resultTpl=t.substitute(s,o)},status:function(e){var n=this,r=n.get("itemStatusFields"),i;return t.each(r,function(t,n){if(e[t])return i=t,!1}),i}},{ATTRS:{itemTpl:{value:'<li>{resultTpl} <span class="action"><span class="'+i+'-del">\u5220\u9664</span></span></li>'},resultTpl:{value:{"default":'<div class="default">{name}</div>',success:'<div data-url="{url}" class="success">{name}</div>',error:'<div class="error"><span title="{name}">{name}</span><span class="uploader-error">{msg}</span></div>',progress:'<div class="progress"><div class="bar" style="width:{loadedPercent}%"></div></div>'},setter:function(e){return t.mix({},this.get("resultTpl"),e)}},itemCls:{value:i},delCls:{value:i+"-del"},itemStatusFields:{value:{add:"add",wait:"wait",start:"start",progress:"progress",success:"success",cancel:"cancel",error:"error"}}}},{xclass:"queue"});return s}),define("bui/uploader/theme",["bui/common"],function(e){var t=e("bui/common"),n={},r={addTheme:function(e,t){n[e]=t},getTheme:function(e){return t.cloneObject(n[e])}};return r.addTheme("default",{elCls:"defaultTheme"}),r.addTheme("imageView",{elCls:"imageViewTheme",queue:{resultTpl:{success:'<div class="success"><img src="{url}" /></div>'}}}),r}),define("bui/uploader/validator",["bui/common"],function(e){function n(e){n.superclass.constructor.call(this,e)}var t=e("bui/common");n.ATTRS={rules:{},queue:{}},t.extend(n,t.Base),t.augment(n,{valid:function(e){return this._validItem(e)},_validItem:function(e){var n=this,r=n.get("rules"),i=!0;return t.each(r,function(t,r){return i=i&&n._validRule(e,r,t),i}),i},_validRule:function(e,r,i,s){t.isArray(i)&&(s=t.substitute(i[1],i),i=i[0]);var o=n.getRule(r),u=o&&o.call(this,e,i,s),a=this._getResult(u);return a?(e.result=a,!1):!0},_getResult:function(e){if(e)return{msg:e}}});var r={};return n.addRule=function(e,t){r[e]=t},n.getRule=function(e){return r[e]},n.addRule("maxSize",function(e,t,n){if(e.size>t*1024)return n}),n.addRule("minSize",function(e,t,n){if(e.size<t*1024)return n}),n.addRule("max",function(e,t,n){var r=this.get("queue").getCount();if(r>t)return n}),n.addRule("min",function(e,t,n){var r=this.get("queue").getCount();if(r<t)return n}),n.addRule("ext",function(e,t,n){var r=e.ext,t=t.split(",");if($.inArray(r,t)===-1)return n}),n}),define("bui/uploader/factory",["bui/common","./queue","./button/htmlButton","./button/swfButton","./type/ajax","./type/flash","./type/iframe"],function(e){function a(){}var t=e("bui/common"),n=e("bui/uploader/queue"),r=e("bui/uploader/button/htmlButton"),i=e("bui/uploader/button/swfButton"),s=e("bui/uploader/type/ajax"),o=e("bui/uploader/type/flash"),u=e("bui/uploader/type/iframe");return a.prototype={createUploadType:function(e,t){return e==="ajax"?new s(t):e==="flash"?new o(t):new u(t)},createButton:function(e,t){return e==="ajax"||e==="iframe"?new r(t):new i(t)},createQueue:function(e){return new n(e)}},new a}),define("bui/uploader/uploader",["bui/common","./theme","./factory","./validator"],function(e){function u(e){return o[e]&&o[e]()}function a(e,n,r){t.isFunction(e.set)?e.set(n,r):e[n]=r}var t=e("bui/common"),n=t.Component,r=e("bui/uploader/theme"),i=e("bui/uploader/factory"),s=e("bui/uploader/validator"),o={ajax:function(){return!!window.FormData},flash:function(){return!0},iframe:function(){return!0}},f=n.Controller.extend({initializer:function(){var e=this;e._initTheme(),e._initType()},renderUI:function(){var e=this;e._renderButton(),e._renderUploaderType(),e._renderQueue(),e._initValidator()},bindUI:function(){var e=this;e._bindButton(),e._bindUploaderCore(),e._bindQueue()},_initTheme:function(){var e=this,n=r.getTheme(e.get("theme")),i=e.getAttrVals();t.each(n,function(n,r){i[r]===undefined?e.set(r,n):$.isPlainObject(n)&&(t.mix(n,i[r]),e.set(r,n))})},_initType:function(){var e=this,n=e.get("types"),r=e.get("type");r||t.each(n,function(e){if(u(e))return r=e,!1}),e.set("type",r)},_initValidator:function(){var e=this,t=e.get("validator");t||(t=new s({queue:e.get("queue"),rules:e.get("rules")}),e.set("validator",t))},_renderUploaderType:function(){var e=this,t=e.get("type"),n=e.get("uploaderType"),r=i.createUploadType(t,n);r.set("uploader",e),e.set("uploaderType",r)},_renderButton:function(){var e=this,t=e.get("type"),n=e.get("el"),r=e.get("button");r.isController||(r.render=n,r.autoRender=!0,r=i.createButton(t,r),e.set("button",r)),r.set("uploader",e)},_renderQueue:function(){var e=this,t=e.get("el"),n=e.get("queue");n.isController||(n.render=t,n.autoRender=!0,n=i.createQueue(n),e.set("queue",n)),n.set("uploader",e)},_bindButton:function(){var e=this,t=e.get("button"),n=e.get("queue");t.on("change",function(t){var r=t.files;n.addItems(r),e.fire("change",{items:r})})},_bindQueue:function(){var e=this,t=e.get("queue"),n=e.get("validator");t.on("itemrendered",function(r){var i=r.item,s=t.status(i)||"add";n.valid(i)||(s="error"),t.updateFileStatus(i,s),e.get("autoUpload")&&e.upload()}),t.on("itemupdated",function(t){e.uploadFiles()})},_bindUploaderCore:function(){var e=this,n=e.get("queue"),r=e.get("uploaderType");r.on("start",function(t){var n=t.file;delete n.result,e.fire("start",{item:n})}),r.on("progress",function(r){var i=e.get("curUploadItem"),s=r.loaded,o=r.total;t.mix(i.attr,{total:o,loaded:s,loadedPercent:s*100/o}),n.updateFileStatus(i,"progress"),e.fire("progress",{item:i,total:o,loaded:s})}),r.on("error",function(r){var i=e.get("curUploadItem"),s=e.get("error"),o=e.get("complete");n.updateFileStatus(i,"error"),s&&t.isFunction(s)&&s.call(e),e.fire("error",{item:i}),o&&t.isFunction(o)&&o.call(e),e.fire("complete",{item:i}),e.set("curUploadItem",null)}),r.on("complete",function(r){var i=e.get("curUploadItem"),s=r.result,o=e.get("isSuccess"),u=e.get("success"),a=e.get("error"),f=e.get("complete");e.set("curUploadItem",null),i.result=s,o.call(e,s)?(t.mix(i,s),n.updateFileStatus(i,"success"),u&&t.isFunction(u)&&u.call(e,s),e.fire("success",{item:i,result:s})):(n.updateFileStatus(i,"error"),a&&t.isFunction(a)&&a.call(e,s),e.fire("error",{item:i,result:s})),f&&t.isFunction(f)&&f.call(e,s),e.fire("complete",{item:i,result:s})})},uploadFile:function(e){var t=this,n=t.get("queue"),r=t.get("uploaderType"),i=t.get("curUploadItem");e&&!i&&(t.set("curUploadItem",e),n.updateFileStatus(e,"start"),r.upload(e))},uploadFiles:function(){var e=this,t=e.get("queue"),n=t.getItemsByStatus("wait");n&&n.length&&e.uploadFile(n[0])},upload:function(){var e=this,n=e.get("queue"),r=n.getItemsByStatus("add");t.each(r,function(e){n.updateFileStatus(e,"wait")})},cancel:function(e){var t=this,n=t.get("uploaderType");e=e||t.get("curUploadItem"),t.fire("cancel",{item:e}),n.cancel(),t.set("curUploadItem",null)},isValid:function(){var e=this,t=e.get("queue");return t.getItemsByStatus("success").length===t.getItems().length}},{ATTRS:{types:{value:["ajax","flash","iframe"]},type:{},theme:{value:"default"},button:{value:{},shared:!1},text:{setter:function(e){return a(this.get("button"),"text",e),e}},name:{setter:function(e){return a(this.get("button"),"name",e),a(this.get("uploaderType"),"fileDataName",e),e}},disabled:{value:!1,setter:function(e){return a(this.get("button"),"disabled",e),e}},multiple:{value:!0,setter:function(e){return a(this.get("button"),"multiple",e),e}},filter:{setter:function(e){return a(this.get("button"),"filter",e),e}},uploaderType:{value:{},shared:!1},url:{setter:function(e){return a(this.get("uploaderType"),"url",e),e}},data:{setter:function(e){return a(this.get("uploaderType"),"data",e),e}},queue:{value:{},shared:!1},resultTpl:{setter:function(e){return a(this.get("queue"),"resultTpl",e),e}},autoUpload:{value:!0},uploadStatus:{},isSuccess:{value:function(e){return e&&e.url?!0:!1}},validator:{},events:{value:{change:!1,start:!1,progress:!1,success:!1,error:!1,complete:!1,cancel:!1}}}},{xclass:"uploader"});return f}),define("bui/uploader",["bui/common","bui/uploader/uploader","bui/uploader/queue","bui/uploader/theme","bui/uploader/factory"],function(e){var t=e("bui/common"),n=t.namespace("Uploader");return t.mix(n,{Uploader:e("bui/uploader/uploader"),Queue:e("bui/uploader/queue"),Theme:e("bui/uploader/theme"),Factory:e("bui/uploader/factory")}),n});
