/**
 * ===========================================
 * GRI 前台JS框架
 * 描述： 主要包含一些公用类库函数，工具函数的抽取。
 * 使用统一的命名空间管理  GRI
 * @author johnnyzheng(johnnyzheng@tecent.com)
 * @modifiation 2013-04-16 第一版本发布 
 * 				2013-05-21 增加dropdownlist组件
 * 				2013-06-24 修复dropdownlist组件的位置不准确的问题
 * 				2013-07-03 为支持多窗口联动，增加changeContent接口 
 * ===========================================
 */

/**
 * @description GRI 全局对象，负责前端的交互组织
 * @namespace 全局的命名空间
 */
GRI = window.GRI || {};

/**
 * @namespace GRI JS框架工具类型，里面会累积一下大家常用的工具类函数和对象方法
 */
GRI.Util = {
	
	/**
	 * @description 将传入的url参数对象解析组装成字符串做为queryString中的一部分
	 * @param {Object} params 请求参数的数组
	 * @param {string} cgi 请求串
	 * @return {String} queryString部分字符串
	 * @example ： param1=value1&param2=value2&param3=value3......
	 */
	convert_params : function(params, cgi){
	    var paramsArray = [];
	    for (var name in params) {
	        if (paramsArray.length == 0) {
	            cgi && cgi.indexOf('?') != -1 ? paramsArray.push("&") : paramsArray.push("?");
	        }
	        else {
	            paramsArray.push("&");
	        }
	        paramsArray.push(name);
	        paramsArray.push("=");
	        paramsArray.push(params[name]);
	    }
	    return paramsArray.join("");
	},
	
	/**
	 * @description 页面内指定按钮统计
	 * @param {string} hottag 指定按钮编码
	 * @param {string} loc 点击后的跳转url
	 * @return  
	 */
	hotClick : function(hottag, loc) {
		if ('https:' == document.location.protocol)	
		{
			loc && (window.location.href = loc);
			return false;
		}
		var base = 'http://pinghot.' + (new RegExp(/qq.com/).test(GRI.Util.parse_url().host) ? 'qq' : 'oa') + '.com/pingd?';
		var url = ['dm=' + GRI.Util.parse_url().host + '.hot', 'url=' + GRI.Util.parse_url().path, 'hottag=' + escape(hottag), 'hotx=9999&hoty=9999', 'rand=' + Math.round(Math.random() * 100000)].join('&');
		(new Image(1, 1)).src = base + url;
		//如果有跳转 ， 延迟200ms
		loc && function() {
			setTimeout(function() {
				window.location.href = loc;
				return false;
			}, 200);
		}();

	},
	
	/**
	 * 判断一个对象是否为空对象
	 */
	isEmptyObj : function(obj){
		for(var name in obj) { 
			return false; 
		} 
			return true; 
	},

	/**
	 * @description 解析url
	 * @param {String} 请求url串
	 * @return
	 * @type Object
	 * @example GRI.Util.parse_url('http://mGRI.oa.com/base/ctr_portrait?app_id=110000011')
	 */
	parse_url : function(url) {
		var host, path, search, hash, param = {};
		if(url === undefined) {
			var loc = window.location;
			host = loc.host;
			path = loc.pathname;
			search = loc.search.substr(1);
			hash = loc.hash;
		} else {
			var ret = url.match(/\w+:\/\/((?:[\w-]+\.)+\w+)(?:\:\d+)?(\/[^\?\\\"\'\|\:<>]*)?(?:\?([^\'\"\\<>#]*))?(?:#(\w+))?/i) || [];
			host = ret[1];
			path = ret[2];
			search = ret[3];
			hash = ret[4];
		}
		search && function() {
			var arr = search.split('&');
			for(var i = 0, l = arr.length; i < l; i++) {
				//var p=arr[i].split('=');
				//param[p[0]]=p[1];
				if(arr[i].indexOf('=') != -1) {
					var pos = arr[i].indexOf('=');
					var k = arr[i].slice(0, pos);
					var v = arr[i].slice(pos + 1);
					param[k] = v;
				}
			}
		}();
		return {
			host : host,
			path : path,
			search : search,
			hash : hash,
			param : param
		}
	},
	
	/**
	 * @description cookie存储的工具类函数
	 */
	cookie : {
		getTopDomain : function() {
			var top = window.location.host, list = {
				'com.cn' : 1,
				'net.cn' : 1,
				'gov.cn' : 1,
				'com.hk' : 1
			}, arr = top.split('.');
			//配置最常用的地区域名名单
			arr.length > 2 && function() {
				top = (list[arr.slice(-2).join('.')] ? arr.slice(-3) : arr.slice(-2)).join('.');
			}();
			return top;
		},
		get : function(key) {
			var ret = document.cookie.match(new RegExp("(?:^|;\\s)" + key + "=(.*?)(?:;\\s|$)"));
			return ret ? ret[1] : "";
		},
		save : function(key, value, expires) {
			document.cookie = key + "=" + value + ";path=/;domain=" + this.getTopDomain() + ( expires ? ";expires=" + expires : '');
		}
	},
	
	/**
	 * @description 为某一个元素增加数据加载中的遮罩层
	 * example GRI.Util.loading.show('conGRIiner');
	 */
	loading : {
		prefix : 'mask4',
		/**
		 * 显示遮罩层
		 * id : 容器ID
		 * extra : 额外配置数据
		 */
		show : function(id, extra) {
			if(id && $('#' + this.prefix + id).length > 0) {
				return false;
			}
			var that = this;
			var style = function() {
				if($('#' + id).length > 0) {
					return {
						width : $('#' + id).width(),
						height : $('#' + id).height(),
						offset : $('#' + id).offset(),
						padding : $('#' + id).css('padding')
					};
				}
				return null;
			}();
			if(style) {
				$('<div id="' + that.prefix + id + '"><i class="icon-loading"></i>&nbsp;数据加载中...</div>').css({
					height : style.height + 'px',
					left : style.offset.left + 'px',
					position : 'absolute',
					padding : style.padding,
					'padding-top' : '25px',
					top : style.offset.top + 'px',
					'text-align' : 'center',
					width : style.width + 'px',
					background : '#FFF',
					'opacity' : 0.4,
					'z-index' : 98
				}).appendTo('body');
			}
		},
		/**
		 * 清除遮罩层
		 * id : 容器ID
		 */
		clear : function(id) {
			if(id && $('#' + this.prefix + id).length > 0) {
				$('#' + this.prefix + id).remove();
			} else {
				$('div[id^="' + this.prefix + '"]').each(function() {
//					$(this).remove();
				});
			}
		}
	},
	
	/**
	 * @description 页面悬浮显示tips
	 * @author alexmiao
	 * @example GRI.Util.tool_tips.show('测试tooltips', 'conGRIinerId');
	 */
	tool_tips:{
		 show:function(title,elem){
			 var tipsConGRIiner='<div class="tips-small" style="display:none" > '+
			                                 '<p>'+title+'</p>'+
			                           '</div>';
			    var divoffset=10;
		        var tips=$(tipsConGRIiner);
		        $("body").append(tips);
		        
		        var leftpos,toppos;
			 
	             $("#"+elem).bind('mouseover',function(e){
	            	  Mouse(e);
	            	  tips.show().css({ top: toppos ,left: leftpos });
		           }).bind('mousemove',function(e){
		        	   Mouse(e);
		               tips.show().css({ top: toppos ,left: leftpos });
		           }).bind('mouseout',function(){
		        	   tips.hide();
				  });
			
			      
		      
			     //计算坐标函数
			     var Mouse = function(e){
			         mouse = new MouseEvent(e);
			         leftpos = mouse.x + divoffset;
			         toppos = mouse.y + divoffset;
			     }
			     //获取鼠标坐标函数
			     var MouseEvent = function(e) {
			         this.x = e.pageX
			         this.y = e.pageY
			     }
			 
		 }

	},
	
	/**
	 * @description 全屏遮罩层管理器
	 * @author johnnyzheng(johnnyzheng@tencent.com)
	 * @version 2013-01-08 init
	 * @example GRI.Util.mask.create();
	 */
	mask : {
		self : '',
		isIE6 : $.browser.msie && $.browser.version < 7,
		create : function() {
			if(this.self && this.self.parent().length) {
				return;
			}
			$(window).bind('resize.overlay', this.resize);
			return (this.self = (this.self || $('<div></div>').css({
				height : '100%',
				left : 0,
				position : 'absolute',
				top : 0,
				width : '100%',
				background : '#000',
				'opacity' : 0.3,
				'z-index' : 2001
			})).appendTo('body').css({
				width : this.width(),
				height : this.height()
			}));
		},
		destroy : function() {
			if(this.self && !this.self.parent().length) {
				return;
			}
			$([document, window]).unbind('resize.overlay');
			this.self.animate({
				opacity : 'hide'
			}, function() {
				$(this).remove().show();
			});
		},
        resize: function() {
            var _mask = GRI.Util.mask;
            _mask.self.css({
                width: 0,height: 0
            }).css({
                width: _mask.width(),height: _mask.height()
            });
        },
		height : function() {
			var scrollHeight, offsetHeight;
			if(this.isIE6) {
				scrollHeight = Math.max(document.documentElement.scrollHeight, document.body.scrollHeight);
				offsetHeight = Math.max(document.documentElement.offsetHeight, document.body.offsetHeight);
				if(scrollHeight < offsetHeight) {
					return $(window).height() + 'px';
				} else {
					return scrollHeight + 'px';
				}
			} else {
				return $(document).height() + 'px';
			}
		},
		width : function() {
			var scrollWidth, offsetWidth;
			if(this.isIE6) {
				scrollWidth = Math.max(document.documentElement.scrollWidth, document.body.scrollWidth);
				offsetWidth = Math.max(document.documentElement.offsetWidth, document.body.offsetWidth);
				if(scrollWidth < offsetWidth) {
					return $(window).width() + 'px';
				} else {
					return scrollWidth + 'px';
				}
			} else {
				return $(document).width() + 'px';
			}
		}
	}
}

/**
 * @description 弹出窗口
 * @param {Object} json 配置数组
 * @param {Object} callback 回调函数
 * @expample  var dialog = new GRI.Dialog( {
				 type: 1,
				 title: '选择渠道',
				 content: 'aaaaaaaaaaa',
				 deGRIil: '',
				 btnType: 1,
				 extra: {top: 250},
				 winSize : 2
				 }, function(){});
 */
GRI.Dialog = function(json, callback) {
	var defaults = {
		type : 1, //对话框类型，1：通用类型，接收html内容,	2：控件，
		//			3：纯文本 -- 提示信息，绿色，	4：纯文本 -- 警告信息，橙色
		//			5：纯文本 -- 警告信息，红色		6：纯文本 -- 错误信息，红色
		title : '温馨提示',
		hideCloseIcon : false, //是否显示右上角的关闭图标
		content : '',
		detail : '',
		tips : '',
		btnType : 1, //按钮类型，1：确定，取消  2：是，否  3，确定  false，4：继续，false，5：不显示按钮，6，自定义按钮
		buttons : {
			text1 : '',
			text2 : ''
		},
		winSize : 1, //窗体大小，1：小窗体，样式为min，2：大窗体，样式为 mid
		extra : {//扩展信息，如控制对话框宽度，显示层次，位置等
			top : '',
			left : '',
			width : '',
			zIndex : 2002,
			heatmap : '', //是否是热区图页面，兼容旧版
			noPrompt : '', //是否显示“下次不再显示”复选框，待实现
			autoMask : true,
			autoDestory : true,
			autoClose : true
		}
	}; !json.extra && (json.extra = defaults.extra);
	var opts = $.extend(true, defaults, json);
	var self = this;
	self.dialogId = '';

	var create = function() {

		var extra = opts.extra;
		var zIndex = extra['zIndex'];

		while($('#fwin_dialog_fs_100' + zIndex)[0]) {
			zIndex++;
		}
		var message_id = 'fs_100' + zIndex;
		var dialogId = 'fwin_dialog_' + message_id;
		var contentId = dialogId + '_content';
		var closeIconId = dialogId + '_closeIcon';
		var tipsId = dialogId + '_tips';
		var btnId1 = dialogId + '_btn1', btnId2 = dialogId + '_btn2', btnContainer1 = dialogId + '_btnCtn1';
		self.dialogId = dialogId;
		self.btnId1 = btnId1;
		self.btnContainer1 = btnContainer1;
		self.contentId = contentId;
		self.callback = callback;

		var dialogPosition = ($.browser.msie && $.browser.version < 7) ? 'absolute' : 'fixed';
		extra['heatmap'] && ( dialogPosition = 'absolute');
		//热区图
		var btnText1, btnText2, tips = opts.tips, btnType = opts.btnType;
		var typeList = {
			1 : ['确定', '取消'],
			2 : ['是', '否'],
			3 : ['确定', ''],
			4 : ['继续', ''],
			5 : ['', '']
		};
		if(btnType != 6) {
			btnType = typeList[btnType] ? btnType : 1;
			//默认取第一个
			btnText1 = typeList[btnType][0];
			btnText2 = typeList[btnType][1];
		} else {
			btnText1 = opts.buttons.text1;
			btnText2 = opts.buttons.text2;
		}

		//footer
		var footerHtml = '';
		if(tips || btnText1 || btnText2) {
			footerHtml = '	<div class="float_footer"> ';
			if(btnText1 || btnText2) {
				footerHtml += '		<div class="form-actions"> ';
				btnText1 && function() {
					var rawHtml = '<input type="button" id="' + btnId1 + '"  value="' + btnText1 + '"  class="btn  btn-primary"/> '; 
                    footerHtml += rawHtml;
				}();
				btnText2 && (footerHtml += '			<input type="button" id="' + btnId2 + '" value="' + btnText2 + '"  class="btn"/> ');
				footerHtml += '</div>';
			}
            footerHtml += '			<div class="form-message"> ' + '				<div id="' + tipsId + '" class=" help-inline">' + tips + '</div> ' + '			</div> ';
			footerHtml += '</div>';
		}

		var winSizeClass = {1: 'min', 2: 'mid'}[opts.winSize] || 'min';
		var contentClass = {1: '', 2: 'form-horizontal', 3: 'confirm success', 4: 'confirm attent', 5: 'confirm warn', 6: 'confirm error'}[opts.type] || '';
		var strHtml = 
            ' <div id="' + dialogId + '" style="position: ' + dialogPosition + '; z-index: ' + zIndex + '" class="float cf ' + winSizeClass + '">' 
            + '		<div class="float_header"> ' 
            + '			<h3><a id="' + closeIconId + '" href="javascript:void(0);" class="close">&times;</a>' + opts.title + '</h3>' 
            + '		</div>' 
            + '		<div class="float_cont cf"> ' 
            + '			<div class="' + contentClass + '" id="' + contentId + '"> ' + '			</div> ' 
            + '		</div> ' 
            + footerHtml 
            + '	</div> ';

		if(!$('#' + dialogId)[0]) {
			$(strHtml).appendTo("body");
		}

		//填充内容
		var content = opts.content;
		var cssInfo = {3: 'success', 4:'attent', 5:'warn', 6:'error'}[opts.type] || '';
		cssInfo && ( content = 
              ' 	<i class="icon-confirm"></i> ' 
            + '	    <div class="confirm-cont"> ' 
            + '			<h4>' + opts.content + '</h4> ' 
            + '			<p>' + opts.detail + '</p> ' 
            + '		</div> ');

		$('#' + contentId).html(content);

		$("#" + dialogId).show();

		//处理对话框宽度
		var dialogWidth = extra['width'] ? parseInt(extra['width']) + 'px' : '';
		$('#' + contentId).css({
			"width" : dialogWidth
		});
		$('#' + dialogId).css({
			"width" : dialogWidth
		});
		//处理对话框位置
		dialogLeft = extra['left'] || ($(window).width() - $('#' + dialogId).width()) / 2;
		dialogTop = extra['top'] || ($(window).height() - $('#' + dialogId).height()) / 2;
		$("#" + dialogId).css({
			"top" : dialogTop + "px",
			"left" : dialogLeft + "px"
		});

		//点击回调函数
		$('#' + btnId1).click(function() {
			buttonClick('btn1');
		});
		$('#' + btnId2).click(function() {
			buttonClick('btn2');
		});
		$('#' + closeIconId).click(function() {
			buttonClick('btnClose');
		});

		opts.hideCloseIcon && $('#' + closeIconId).css('display', 'none');

		var noPrompt = (extra && typeof (extra['noPrompt']) != 'undefined') ? extra['noPrompt'] : false;
		if(noPrompt) {
			$('#' + 'promptOff').html('<input type="checkbox" id="noDataPromptOff" name="noDataPromptOff" value="1" style="position:relative;top:2px;"/> 不再提醒 ');
		}
		
		opts.extra.autoMask && GRI.Util.mask.create();
		//自动遮盖

		// 解决IE6select控件bug
		var hidIframeId = "frm_100_" + dialogId;
		//如果已经存在，那么删除
		if($("#" + hidIframeId)) {
			$("#" + hidIframeId).remove();
		}
		hidIframe = "<iframe id=\"" + hidIframeId + "\"></iframe>";
		$(hidIframe).appendTo("body");
		zIndex = parseInt(zIndex);
		zIndex--;
		$("#" + hidIframeId).css({
			"width" : dialogWidth,
			"height" : $("#" + dialogId).height(),
			"position" : dialogPosition,
			"top" : $("#" + dialogId).css("top"),
			"left" : $("#" + dialogId).css("left"),
			"z-index" : zIndex,
			"scrolling" : "no",
			"border" : "0"
		});
	}, buttonClick = function(btnName) {
		//仅支持第一个按钮的点击调用回调函数
		(btnName == 'btn1' && self.callback) ? function() {
			self.callback();
			if(opts.extra.autoClose) {
				self.hideWindows();
			}
		}() : self.hideWindows();
	};

	this.hideWindows = function() {
		var dialogId = self.dialogId;
		$("#" + dialogId).hide();
		$("#" + dialogId).remove();
		$("#frm_100_" + dialogId).remove();
		//解决IE浏览器下a标签不向上冒泡的问题
		if($("div[id^='calendar_']")) {
			$("div[id^='calendar_']").css('display', 'none');
		}
		
		opts.extra.autoMask && opts.extra.autoDestory && GRI.Util.mask.destroy();
		//从集合中清除指定对话框
		return false;
	};
	
	this.changeContent = function(content, hdl, extra){
		$('#'+self.contentId).html(content);
		self.callback = hdl;
		extra.btnText1 && $('#'+self.btnId1).val(extra.btnText1);	
		extra.initHdl &&  extra.initHdl();	
	};

	this.closeWindows = this.hideWindows; 
    this.showTips = function(msg) {
		var tipsId = self.dialogId + '_tips';
        if (msg.length > 50){
            msg = '服务器繁忙，请刷新重试';
        }

		$("#" + tipsId).html(msg);
	}, this.clearTips = function() {
		var tipsId = self.dialogId + '_tips';
		$("#" + tipsId).html('');
	}
	create();
	return this;
};
/*
 对话框常量
 对话框类型，1：通用类型，接收html内容,	2：控件，
 3：纯文本 -- 提示信息，绿色，	4：纯文本 -- 警告信息，橙色
 5：纯文本 -- 警告信息，红色		6：纯文本 -- 错误信息，红色
 */
GRI.Dialog.DIALOG_TYPE = {
	COMMON : 1,
	CONTROL : 2,
	TEXT_INFO : 3,
	TEXT_WARN : 4,
	TEXT_WARN_RED : 5,
	TEXT_ERROR : 6
};
/*
 对话框常量
 按钮类型，1：确定，取消  2：是，否  3，确定  false，4：继续，false，5：不显示按钮，6，自定义按钮
 */
GRI.Dialog.BUTTON_TYPE = {
	OK_CANCEL : 1,
	YES_NO : 2,
	OK : 3,
	CONTINUE : 4,
	NONE : 5,
	CUSTOMIZE : 6
};
/*
 对话框常量
 对话框尺寸，1：小窗体，2：大窗体
 */
GRI.Dialog.WIN_SIZE = {
	MIN : 1, //小窗体
	MID : 2
};


(function(GRI){
        var cache = {};
        GRI.Tmpl = function tmpl(str, data){
            // Figure out if we're getting a template, or if we need to
            // load the template - and be sure to cache the result.
            var fn = !/\W/.test(str) ?
                    cache[str] = cache[str] || tmpl(document.getElementById(str).innerHTML) :

                // Generate a reusable function that will serve as a template
                // generator (and which will be cached).
                    new Function("obj",
                            "var p=[],print=function(){p.push.apply(p,arguments);};" +
                                // Introduce the data as local variables using with(){}
                                    "with(obj){p.push('" +
                                // Convert the template into pure JavaScript
                                    str
                                            .replace(/[\r\t\n]/g, " ")
                                            .split("<%").join("\t")
                    .replace(/((^|%>)[^\t]*)'/g, "$1\r")
                    .replace(/\t=(.*?)%>/g, "',$1,'")
                    .split("\t").join("');")
                    .split("%>").join("p.push('")
                    .split("\r").join("\\'")
                + "');}return p.join('');");

            // Provide some basic currying to the user
            return data ? fn( data ) : fn;
        };
})(GRI);


/**
 * 带搜索的下拉框
 * @param {string} 呼出的ID
 * @param {object} json  
 * 		  例如： {'key1':'名将三国','key2':'QQ仙侠之剑灵'}数据源的下拉框体的数据源
 * @param {boolean} needSearch 是否需要搜索框
 * @param {object} extra 额外的配置数组 defaultId: 默认选中
 * 		 例如：{'footer_link' : 'www.qq.com', 'footer_text':'添加更多自定义事件', 'left':'100px', 'top':'90px', 'defaultId' : {key:0, name:'哈哈','isCheckBox':true}} TODO 待扩展
 * 		 defaultKey:['key1', 'key2'] 默认选中的key
 * @param callback 回调函数 如果isCheckBox 则callback中包含参数{all:10,checked:1,list:[{name:选项1,value:1}]}
 * @example var drop1 = new GRI.DropdownList('div_month_picker_test', json, true, {'footer_link' : 'http://www.qq.com'}, function(){
				alert(drop1.selected);//这就返回了选中的绑定的ID
			});
 */
GRI.DropdownList = function(target, json, needSearchBox, extra, callback){
	/**
	 * 控件ID 随机算法有点问题，优化
	 */
	this.id = 'gri_dropdown_list_' + (Math.round((Math.random()||0.5) * 2147483647) * (+new Date())) % 10000000000;
	/**
	 * 当前选中的值
	 */
	this.selected = '';
	/**
	 * 数据源
	 */
	this.dtSource = json;
	/**
	 * 是否需要搜索框
	 */
	this.needSearchBox = needSearchBox == undefined ? true : needSearchBox;

	var time_out = 300, TIME_OUT = null, self = this;
	var hide_pop = function(){
		$('#' + self.id).length > 0 && $('#'+self.id).hide();
		show_all();
	},
	alter_position = function(){
			//调整位置
			if($('#'+ target).length > 0){
				$('#'+ target).css('position') == 'fixed' ? function(){
					$('#'+self.id).css({'left': $('#'+ target).position().left, 'top' : $('#'+ target).position().top + $('#'+ target).height() + 10});
				}() : function(){
					$('#'+self.id).css({'left': $('#'+ target).offset().left, 'top' : $('#'+ target).offset().top + $('#'+ target).height() + 10});
				}(); 
			}
		},
		show_pop = function(){
		$('#' + self.id).length > 0 && $('#'+self.id).show();
		!(extra && extra['container_id'])&&alter_position();
	},
		show_all = function(){
            if (extra['isCheckBox']){
                $('#'+self.id).find('ul li').each(function(){
                    $(this).show();
                });
            }else{
			$('#'+self.id).find('ul li a').each(function(){
                    $(this).parent().show();
			});
            }
		},
		init = function(){
			//气泡弹层
			$('#'+target).click(function(){
				$('#'+self.id).is(':visible') ? hide_pop() : show_pop();
			}).mouseover(function(){
				clearTimeout(TIME_OUT);
			}).mouseout(function(){
				TIME_OUT = setTimeout(hide_pop, time_out);
			});
			$('#'+self.id).mouseover(function(){
				clearTimeout(TIME_OUT);
			}).mouseout(function(){
				TIME_OUT = setTimeout(hide_pop, time_out);
			});
			//列表a标签的事件绑定
			$('#'+self.id).find('ul li a').each(function(){
				$(this).click(function(){
					self.selected = {key:$(this).attr('id'), name:$(this).text()};
					hide_pop();
					callback && callback(self);
				});
			});
			//查询按钮点击查询 TODO

            var noResultTips;
			$('#btn_search_'+self.id).length > 0 && $('#btn_search_'+self.id).click(function(){
                if (extra['isCheckBox']){
                    $('#'+self.id).find('ul li label').each(function(){
                        if($('#txt_search_'+self.id).val() != ''){
                            $(this).text().toLowerCase().indexOf($('#txt_search_'+self.id).val().toLowerCase()) != -1 ? $(this).parent().show() : $(this).parent().hide();
                        }
                        else show_all();
                    });
                } else{
					$('#'+self.id).find('ul li a').each(function(){
						if($('#txt_search_'+self.id).val() != ''){
							$(this).text().toLowerCase().indexOf($('#txt_search_'+self.id).val().toLowerCase()) != -1 ? $(this).parent().show() : $(this).parent().hide();
						}
						else show_all();
					});
                }
                if ($('#'+self.id).find('ul li:visible').size() == 1) {
                	$('#'+self.id).find('ul li a:visible').click();
                }

                if ($('#'+self.id).find('ul li:visible').size() == 0) {
                    if(! noResultTips){
                        noResultTips = $('#'+self.id).append("<span class='noResultTips'>　　没有相关条目<br />　</span>").find(".noResultTips");
                    }else{
                        noResultTips.show();
                    }
                }else{
                    noResultTips && noResultTips.hide();
                }
			});
			
			//回车按钮的捕捉
			$('#txt_search_'+self.id).keydown(function(event){
				if(event.keyCode === 13){
					$('#btn_search_'+self.id).click();
				}
			});
			
		},
		//创建框体
		create = function(){
			var li_list = [], count = 1;

            //先对key进行排序
            var keys = [];
			for(var o in self.dtSource){
                keys.push(o);
            }
            keys = keys.sort();

            for(var i = 0; i < keys.length; i++){
                var o = keys[i];
                if (extra['isCheckBox']){
                    var checked = '';
                    if($.inArray(o, extra['defaultKey']) > -1)
                    {
                        checked = 'checked';
                    }
                    li_list.push('<li' + (count==1?' class="first"' : (count==self.dtSource.length?' class="last"':'')) + '><label><input type="checkbox" value="'+o+'"' + checked + '>' + self.dtSource[o] + '</label></li>');
                }else{
				li_list.push('<li' + (count==1?' class="first"' : (count==self.dtSource.length?' class="last"':'')) + '><a href="javascript:;" id="'+ o +'" title="' + o + '">' + self.dtSource[o] + '</a></li>');
			}
			}
            if (extra['isCheckBox']){
			var search_box = [
				'<span class="ui_search">',
					'<input type="text" placeholder="输入关键词.." id="txt_search_'+self.id+'"><button type="submit" id="btn_search_'+self.id+'"></button>',
				'</span>'
			],
			footer = [
				'<div class="footer_bar">',
                        '<div class="buttons">',
                        '<button class="button button_small button_primary">确定</button>',
                        '<button class="button button_small button_link">取消</button>',
                        '</div>',
                        '<label><input type="checkbox">全选</label>'
                    ],
                    panel = [
                        '<div id=' + self.id + ' class="ui_datalist" style="display:none;">',
                        '<div class="header_bar">',
                        (self.needSearchBox ? search_box.join('') : ''),
                        '</div>',
                        '<ul class="list" id="ul_'+self.id+'">',
                        li_list.join(''),
                        '</ul>',
                        footer.join(''),
                        '</div>',
                    ];
            }else{
                var search_box = [
                        '<span class="ui_search">',
                        '<input type="text" placeholder="输入关键词.." id="txt_search_'+self.id+'"><button type="submit" id="btn_search_'+self.id+'"></button>',
                        '</span>'
                    ],
                    footer = [
                        '<div class="footer_bar">',
					'<a target="_blank" href="'+(extra && extra['footer_link'] ? extra['footer_link'] : 'javascript:;' )+'">'+(extra && extra['footer_text'] ? extra['footer_text'] : '请添加配置...' )+'<i class="icon_newtab"></i></a>',
				'</div>',
			],
			panel = [
				'<div id=' + self.id + ' class="ui_datalist" style="display:none;">',
					'<div class="header_bar">',
					(self.needSearchBox ? search_box.join('') : ''),
					'</div>',
					'<ul class="list" id="ul_'+self.id+'">',
					li_list.join(''),
					'</ul>',
					(extra && extra['footer_link'] ? footer.join('') : ''),
				'</div>',
			];
            }
	
			//追加到页面
			$('#'+self.id).length == 0 && function(){
				if(extra && extra['container_id']){
					$(panel.join('')).appendTo($('#'+extra['container_id']));
				}
				else{
					$(panel.join('')).appendTo('body');
					//调整位置
					alter_position();
				}
			}();
			
			//初始化
			init();
			//赋默认值
			!GRI.Util.isEmptyObj(extra) && extra['default'] && (this.selected = extra['default']);

            if (extra['isCheckBox']){
                 $('#'+self.id).find(".button.button_small.button_link").click(function(){
                    setTimeout(hide_pop, time_out);
                });
                 $('#'+self.id).find(".footer_bar :checkbox[text:全选]").click(function(){
                    if ("checked" == $(this).attr("checked")){
                        $('#'+self.id).find('ul li:visible :checkbox').attr("checked", true);
                    }else{
                        $('#'+self.id).find('ul li :checkbox').attr("checked", false);
                    }
                });
                 $('#'+self.id).find(".button.button_small.button_primary").click(function(){
                    var data = {};
                    data['all'] =  $('#'+self.id).find('ul li').length;
                    data['checked'] = 0;
                    data['list'] = [];
                    $('#'+self.id).find('ul li:visible :checkbox:checked').each(function(){
                        data['checked']++;
                        data['list'].push({'name':$(this).parent().text(),'value':$(this).val()});
                    });
                    callback && callback(data);
                    setTimeout(hide_pop, time_out);
                });
                self.getSelectedItem = function(){
                    var selectItem = [];
                    $('#'+self.id).find('ul :checkbox:checked').each(function(){
                        selectItem.push({'name':$(this).parent().text(),'value':$(this).val()});
                    });
                    return selectItem;
                };
            }
		}();
	return this;
}


/**
 * @description 异常处理对象函数
 * @author zacharycai
 */
GRI.Exception = {
    /**
     * 异步请求完成后处理函数
     */
    griCompleteHandler : function(event, XMLHttpRequest, ajaxOptions){

        //内网应用登录超时，则页面刷新，自动跳转到登录页面
        if (XMLHttpRequest.status === 401) {
            var currentWindow = window;
            if (window.top != window.self) {
                currentWindow = window.top;
            }
            currentWindow.location.reload();
            return;
        }

        //外网应用登录超时，检测返回的页面里是否有“未登录”字样，有则显示ptlogin登录框
        if(XMLHttpRequest.responseText && (XMLHttpRequest.responseText.indexOf('请先登录') !== -1 || XMLHttpRequest.responseText.indexOf('未登录') !== -1))
        {
            $(document).unbind('ajaxComplete');
            //GRI.PTLogin.open(url, isHideClose)
            //打开ptlogin登录框，url表示登陆后跳转的url，isHideClose表示是否隐藏关闭按钮
            //该方法由各业务系统自己实现，如GRI.PTLogin = MTA.login;
            GRI.PTLogin && GRI.PTLogin.open && GRI.PTLogin.open(location.href, true);
        }
    }
};

//监听全局的ajax complete句柄
$(document).ajaxComplete(GRI.Exception.griCompleteHandler);

$.ajaxSetup({
    data: {'ajax': 1}
});
