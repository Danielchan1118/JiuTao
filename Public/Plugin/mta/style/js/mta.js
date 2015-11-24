/**===================================================================
 * @fileoverview MTA JS框架、工具、站点选择器条件选择器
 * @author hunkhu johnnyzheng
 * @version v1.0.1 2013-01-01
 *          v1.0.2 进行设计优化，公用类库抽取出来到gri.js中
 * ===================================================================
 */

/**
 * @description MTA 全局对象，负责前端的交互组织
 * @namespace 全局的命名空间
 */
MTA = window.MTA || {};

/**
 * @description MTA 页面的环境变量的命名空间
 */
MTA.Page = MTA.Page || {};

MTA.Function = MTA.Function || {};

/**
 * @description MTA页面渠道，版本，错误码，浏览器等选择器命名空间
 */
MTA.Page.Condition = MTA.Page.Condition || {};
//渠道、版本等选择器
MTA.Page.Options = MTA.Page.Options || {};
//设置图例，设置表格等选择器
MTA.Page.Params = MTA.Page.Params || {};
//页面需要额外传递的url参数
MTA.Page.Variable = MTA.Page.Variable || {};
//某些页面需要定义的局部变量的命名空间

/*
 * MTA常量配置
 */
MTA.Constant = {
    DOMAIN_TYPE_INTRANET: 1,        //内网环境
    DOMAIN_TYPE_INTERNET: 2         //外网环境
};

/**
 * @namespace MTA配置对象,定义全局变量
 */
MTA.Config = {
	RootPath : '',
    	DomainType: MTA.Constant.DOMAIN_TYPE_INTRANET,  //网站类型，为内网或外网
	//全部渠道，全部版本，全部浏览器等selector的选项的值是0，对应关系配置
	Selector : {
		allSuffix : '0',
		map : {
			'channel' : '渠道',
			'version' : '版本'
		}
	},
	//设置图例 & 设置表格 选择器
	optsGroup : {
		'channel' : {
			'chart' : {
				'chart_channel_group' : {
					main : 'split',
					minor : 'other'
				},
				main_name : 'chart_channel_group_split',
				minor_name : 'chart_channel_group_other'
			},
			'table' : {
				'table_channel_group' : {
					main : 'split',
					minor : 'other'
				},
				main_name : 'table_channel_group_split',
				minor_name : 'table_channel_group_other'
			}
		},
		'version' : {
			'chart' : {
				'chart_version_group' : {
					main : 'split',
					minor : 'other'
				},
				main_name : 'chart_version_group_split',
				minor_name : 'chart_version_group_other'
			},
			'table' : {
				'table_version_group' : {
					main : 'split',
					minor : 'other'
				},
				main_name : 'table_version_group_split',
				minor_name : 'table_version_group_other'
			}
		},
		//需要激活的选择器ID
		need_trigger : 'chart_calc_sum'
	},
	//菜单样式对应关系配置
	menuClaMap : {
		0 : 'icon_overview',
		1 : 'icon_app',
		2 : 'icon_channel',
		3 : 'icon_run',
		4 : 'icon_user',
		5 : 'icon_setting',
        6 : 'icon_netspeed',
        7 : 'icon_develop',
        8 : 'icon_admin'
	},
	//平台编码与样式的对应关系配置
	platformMap : {
		11 : {
            'icon_css': 'icon-platform-android',
            'icon_class': 'icon_android',
			'css' : 'android',
			'desc' : 'Android',
            'sdkPath': '/resource/download/mta-android-sdk-1.6.2.zip'
		},
		12 : {
            'icon_css': 'icon-platform-iphone',
            'icon_class': 'icon_ios',
			'css' : 'ios',
			'desc' : 'iOS',
            'sdkPath': '/resource/download/mta-ios-sdk-1.2.7.zip'
		},
		13 : {
            'icon_css': 'icon-platform-windows',
            'icon_class': 'icon_windows',
			'css' : 'windows',
			'desc' : 'Windows Phone',
            'sdkPath': ''
		},

		31 : {
            'icon_css': 'icon-platform-android',
            'icon_class': 'icon_android',
			'css' : 'android',
			'desc' : 'Android',
            'sdkPath': '/resource/download/mta-android-sdk-1.6.2.zip'
		},
		32 : {
            'icon_css': 'icon-platform-iphone',
            'icon_class': 'icon_ios',
			'css' : 'ios',
			'desc' : 'iOS',
            'sdkPath': '/resource/download/mta-ios-sdk-1.2.7.zip'
		},
		33 : {
            'icon_css': 'icon-platform-windows',
            'icon_class': 'icon_windows',
			'css' : 'windows',
			'desc' : 'Windows Phone',
            'sdkPath': ''
		}
	},
	loadPath : function(path) {
		this.RootPath = path;
	},
	systemInfo : [
        {
			seq : '20130907',
			msg : '云标签功能即将开放，请您关注！',
			valid : 1
		},
        {
			seq : '20130905',
			msg : '9.5-9.7实时数据算法优化，将影响活跃用户与QQ用户分布，请您关注。',
			valid : 0
		},
		{
			seq : '20130722',
			msg : '新功能上线！渠道概况，效果跟踪功能发布，欢迎体验！',
			valid : 0
		},
		{
			seq : '20130314',
			msg : '新功能上线！页面分析，用户画像功能发布，欢迎体验。',
			valid : 0
		},
		{
			seq : '2013005',
			msg : '腾讯分析移动统计新鲜出炉，欢迎体验。',
			valid : 0
		}
	],
	wording : {
		staffSelector : '请输入英文名查找'

	}
};

/**
 * @namespace MTA工具类，获取相关的全局数据变量
 */
MTA.Util = {
	
	/**
	 * @description 增加面包线接口
	 * @param array entity 是一个面包条导航的层级对象数组
	 * @example MTA.Util.navigation([{'name':'自定义事件', 'href':''},{....}]);
	 */
	navigation : function(entity){
		var id = 'sp_navigation', doc ='';
		var first = '<a href="#"><i class="icon_customevt"></i>自定义事件</a>';
		$('#'+id).length > 0 && function(){
			for(var i = 0; i<entity.length; i++){
				if(entity[i].href){
					doc += '<a href="' + entity[i].href +'" id=lnk_event><i class="icon_customevt"></i>'+entity[i].name+'</a>&gt;';
				}
				else
					doc += '&nbsp;<span>'+entity[i].name+'</span>';
			}
			$('#'+id).html(doc).show();
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
	 * @description 设置图例/设置表格选择器的值拼接成参数。
	 */
	getOptions : function(params, caller) {
		var _opts = MTA.Page.Options, opts = [];
		for(var o in _opts) {
			if(_opts[o].current && _opts[o].bind == caller) {
				opts = _opts[o].optsList;
				break;
			}
			if(_opts[o].bind == caller) {
				opts = _opts[o].optsList;
			}
		}opts.length > 0 && function() {
			for(var i = 0; i < opts.length; i++) {
				var pair = opts[i].split(':');
				params[pair[0]] = pair[1];
			}
		}();
		return params;
	},
	/**
	 * @description 渠道/版本/浏览器等选择器的选中
	 */
	getConditions : function(params) {
		MTA.Page.Condition && function() {
			for(var o in MTA.Page.Condition) {
				params[o + '_list'] = encodeURIComponent(MTA.Page.Condition[o].getValue());
				params[o + '_show'] = encodeURIComponent(MTA.Page.Condition[o].show);
			}
		}();
		return params;
	},
	/**
	 * @description 获取当前appid
	 */
	getAppId : function() {
		//前台接口已经写好
		return (MTA.Page.app && MTA.Page.app.getAppInfo().appId);
		//return '';
	},
    /*
     * @description 判断当前App是否为演示App
     */
    isDemoApp: function(){
        var appId = this.getAppId();
        return appId <= 100;
    },
	/**
	 * @description 获取当前去掉值
	 */
	getPortalId : function() {
		return '';
	},
	/**
	 * @description 点击指定按钮，弹出或隐藏浮层
	 * @param {Object} btn 按钮
	 * @param {Object} ctn 浮层容器（包括按钮+浮层）
	 * @param {Object} wrap 浮层
	 * @example
	 MTA.Util.popup('i_pop_user', 'div_pop_user', 'wrap_pop_user');
	 */
	popup : function(btn, ctn, wrap, css) {
		css = css || 'open';
		var ITEMS_TIMEOUT = null, time_out = 500;

		function hidePop() {
			$('#' + ctn).removeClass(css);
		}

		function showPop() {
			$('#' + ctn).addClass(css);
		}

		function isPopShow() {
			return $('#' + ctn).attr('class') == css;
		}


		$("#" + btn).click(function() {isPopShow() ? hidePop() : showPop();
		}).mouseover(function() {
			clearTimeout(ITEMS_TIMEOUT);
		}).mouseout(function() {
			ITEMS_TIMEOUT = setTimeout(hidePop, time_out);
		});

		$('#' + wrap).mouseover(function() {
			clearTimeout(ITEMS_TIMEOUT);
		}).mouseout(function() {
			ITEMS_TIMEOUT = setTimeout(hidePop, time_out);
		});
	},
	
	/**
	 *  @description 页面内指定按钮统计
	 */
	hotClick : function(hottag, loc) {
		var base = 'http://pinghot.' + (new RegExp(/qq.com/).test(MTA.Util.parse_url().host) ? 'qq' : 'oa') + '.com/pingd?';
		var url = ['dm=' + MTA.Util.parse_url().host + '.hot', 'url=' + MTA.Util.parse_url().path, 'hottag=' + escape(hottag), 'hotx=9999&hoty=9999', 'rand=' + Math.round(Math.random() * 100000)].join('&');
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
	 * @description 设置额外的url参数接口
	 */
	setParams : function(key, value) {
		// if(MTA.Page.Params[key])
			// MTA.Page.Params[key] = '';
		MTA.Page.Params[key] = value;
	},

	clearParams : function(id){
		if(id){
			delete MTA.Page.Params[id];
			return true;
		}
		MTA.Page.Params = {};
		//MTA.Page.Variable = {};
	},
	
	array2UrlParams : function(params){
	    var paramsArray = [];
	    for (var name in params) {
	        if (paramsArray.length == 0) {
	            paramsArray.push("?");
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
	 * @description 消息提示小黄条的内容接口接口
	 */
	tips : {
		conf : {
			container : 'sp_tips_info',
			close : 'a_tips_close',
			close_cla : 'message-close',
			timeout : 1000
		},
		show : function(cont, id) {
			$('#' + this.conf.container).html(cont).parent().show();
			$('#' + this.conf.close).attr('sequence', id).bind('click', this.hide);

		},
		hide : function() {
			$(this).parent().fadeOut(500);
			//$(this).parent().addClass(MTA.Util.tips.conf.close_cla);
			GRI.Util.cookie.save('_mta_closed_sysmsg', $(this).attr('sequence'), 'Sun, 18 Jan 2038 00:00:00 GMT;');
		}
	},

	/**
	 * @description 所有需要大小图切换的页面使用初始化和事件绑定类
	 * @author johnnyzheng(johnnyzheng@tencent.com)
	 */
	view_switcher : {
		cgi : {},
		hdl : null,
		container : 'div_item_tabs',
		/**
		 * 初始化视图切换初始化方法
		 * @param {Object} 加载视图的cgi地址
		 * @param {Object} 回调函数
		 * @return 
		 */
		init : function(cgi_conf, hdl) {
			this.cgi = cgi_conf; 
			this.hdl = hdl;
			this.tabInit();
			    //点击查看大图,初始化选中状态:默认选中第一个
				MTA.Page.Variable.tab_url = cgi_conf[1];
				MTA.Page.Variable.tab_id = 1;
			//eval(this.hdl + '()');
			$('#' + this.container).find('a').first().addClass("current").siblings().removeClass('current');
		},
		
		/**
		 * 图上的小title进行点击切换 老版本中大小图切换的clickAction
		 */
		clickAction : function(id){
			this.tabInit();
			MTA.Page.Variable.tab_url = this.cgi[id];
			eval(this.hdl + '()');
			$('#div_item_tabs a[id="tab_'+ id +'"]').parent().addClass('current').siblings().removeClass('current');
		},
		
		/**
		 * tab标签的点击事件初始化
		 */
		tabInit : function(){
			var self = this;
			$('#'+ self.container).find('a').each(function() {
				var id = $(this).attr('id').match(/tab_(\d{1,2})/i)[1];
				$(this).bind('click', function() {
					MTA.Page.Variable.tab_url = self.cgi[id];
					MTA.Page.Variable.tab_id = id;
                    $(this).addClass('current').siblings().removeClass('current');
					eval(self.hdl + '()');
				});
			});
		}	
		
	},
	/**
	 * 创建用户群下拉选择框
	 */
	createUserGroup : function(id, json, callback, extra){
		var source = {}, target = id || 'btn_user_group';
		json && function(){
			for(var o in json){
				source[json[o].value] = json[o].name;
			}
		}();
		$('#'+ target).parent().show();
		var user_group = new GRI.DropdownList(target, 
											  source, 
											  true, 
											  {
											   'footer_link': MTA.Config.RootPath + '/custom/ctr_group/list_all?app_id='+MTA.Page.app.appId, 
											   'footer_text' : '添加更多用户群',
											   'default':{key : 0, name: '全部用户'}
											  }, 
											  function(){
												  	$('#'+target).length > 0 && $('#'+target+' span').text(user_group.selected.name);
												  	MTA.Util.clearParams('group_id');
												  	MTA.Util.setParams('group_id', user_group.selected.key);
												  	callback && callback();
											  }
		);	
	
		MTA.Util.setParams('group_id', user_group.selected.key);	
		$('#'+target).parent().show();
	},
	
	/**
	 * @description 页面的指标信息的展示对象
	 * @author johnnyzheng(johnnyzheng@tencent.com)
	 */
	items_info : {
		conf :{
			container : 'wrap_items_info',
			icon : 'icon_items_info',
			popup : 'pop_items_info',
			footer : 'footer_items_info',
            showType: 'dialog',              //指标说明显示的位置
            dialogWrap: 'wrap_items_info_help',
            dialogIcon: 'icon_items_info_help'
		},
		init : function(items, theme, footerInfo){
			if(!items){
                return;
            }

            if ('wechat' == theme){
                this.showInLayer(items, theme, footerInfo);
            }else if (this.conf.showType == 'dialog'){
                this.showInDialog(items, theme, footerInfo);
            }else{
                this.showInLayer(items, theme, footerInfo);
            }
		},
        getFooterInfo: function(theme, footerInfo){
            return ('wechat' == theme)? '<span class="wechat_data_range">数据从2013年7月1日开始统计。</span>由于服务器缓存，以及指标计算方法和统计时间的差异，数据可能出现微小误差，一般在1%以内。':
            ('game' == theme)? '游戏分析使用游戏内帐号ID而不是设备来判断账号的唯一性。':
            ('qc' == theme)? footerInfo :
            (MTA.Page.app.portalId == 11 || MTA.Page.app.portalId == 31)? '腾讯云分析使用IMEI+网卡MAC地址判断Android用户设备的唯一性。': '腾讯云分析使用IFA(iOS6以下版本使用OpenUDID)+网卡MAC地址判断iOS用户设备的唯一性。';
        },
        showInLayer: function(items, theme, footerInfo){
            $('#'+this.conf.dialogWrap).hide();
 			if(items){
				$('#'+this.conf.container).show();
				var doc = "";
				for(var o in items){
					doc += '<dt>'+ o +'</dt><dd>'+items[o]+'</dd>';
				}
				if ('wechat' == theme){
                    doc += '<div style="margin-top:6px;color: #000;"><b>数据由专业移动应用分析工具<br/><a href="http://mta.qq.com" target="_blank">腾讯云分析</a>&nbsp;合作提供</b></div>';
                }
				$('#'+this.conf.popup).html(doc);
                footerInfo = this.getFooterInfo(theme, footerInfo);     //获取备注说明
                footerInfo && $('#'+this.conf.footer).html(footerInfo);

				MTA.Util.popup('icon_items_info', 'wrap_items_info', 'pop_items_info');
			}                    
        },
        showInDialog: function(items, theme, footerInfo){
            var _self = this;
            $('#'+this.conf.container).hide();
            $('#'+this.conf.dialogWrap).show();
            $('#' + this.conf.dialogIcon).click(function(){
                var doc = '';
                for (var o in items){
                    doc += '<dt>' + o + '</dt>'
                        + ' <dd><ul class="mod_list_disc">'
                        + '         <li>' + items[o] + '</li>'
                        + '     </ul>'
                        + '</dd>';
                }
                doc = '<dl class="mod_idx_desc">' + doc + '</dl>';

                footerInfo = _self.getFooterInfo(theme, footerInfo);     //获取备注说明
                footerInfo && (doc += '<div class="mod_mark">' + footerInfo + '</div>');
                doc = '<div class="mod_float_ctn">' + doc + '</div>';

                var dialog = new MTA.Dialog({
                    title: '指标说明',
                    btnType: 3,
                    content: doc
                    }); 
            });
        }
	},
	
	/**
	 * @description 页面上出现的功能提示类
	 */
	noticeInfo : {
		/**
		 * 属性初始化
		 */
		closeId : '_info_close',
		contentId : '_info_content',
		wrapperId : '_info_wrapper',
		triggerId : '_info_trigger',
		triggerWrapperId :'_info_trigger_wrapper',
		/**
		 * @param tpl 提示的信息内容html片段
		 * @return null
		 */
		init : function(tpl){
			var that = this;
			$('#'+this.contentId).length>0 && ($('#'+this.contentId).html(tpl));
			$('#'+this.closeId).click(function(){
				that.hide();
			});
			$('#'+this.triggerId).click(function(){
				that.show();
			});
			$('#'+that.wrapperId).show();
			$('#'+that.triggerWrapperId).hide();
		},
		show : function(){
			var that = this;
				$('#'+that.triggerWrapperId).slideUp(200, function(){
					$('#'+that.wrapperId).show();
				});
		},
		hide : function(){
			var that = this;
			$('#'+that.wrapperId).slideUp(200, function(){
				$('#'+that.triggerWrapperId).show();
			});
			
        }
	}
}

//模板方法
MTA.Util.tmpl = function(){
        
        // Simple JavaScript Templating
        // John Resig - http://ejohn.org/ - MIT Licensed
//        (function(){
            var cache = {};

            this.tmpl = function tmpl(str, data){
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
 //       })();
    };

MTA.Util.tmpl();    //初始化模板函数

/**
 * @description 横向单选择器
 * @param string target 容器ID
 * @param string name 参数名称
 * @param array arr 数据源 形如： [{name:'111', value:'1111'}]
 * @param object callback 回调函数
 * @return null
 */
MTA.singleSelector = function(target, name, arr, callback){
    this.target = target;
    this.source = arr;
    this.hdl = callback;
    /**
     * new选择器
     */
    var doc = '', self = this;
    arr.length>0 && function(){
        doc = '<div class="ui_buttons">';
        for(var i = 0; i<arr.length; i++){
            doc += '<button id="'+ arr[i].value +'" class="button button_small '+(i==0? 'first current' : (i==arr.length-1 ? 'last': ''))+'">'+ arr[i].name +'</button>';
        }
        doc += '</div>';
        //默认选中第一个
        MTA.Util.setParams(name, arr[0].value);
    }();
    $('#'+ this.target).html(doc).parent().show();

    $('#'+ this.target).find('div[class="ui_buttons"] button').each(function(index){
        $(this).bind('click', function(){
            var v = $(this).attr('id');
            MTA.Util.clearParams();
            MTA.Util.setParams(name, v);
            $(this).addClass('current').siblings().removeClass('current');
            self.hdl && self.hdl();
        });
    });
}

MTA.DropList = function(container, groupName, data, callback, showSearchBox){
    this.show = '';
    var value = data.defaultValue ? data.defaultValue : -1;
    showSearchBox = showSearchBox == undefined ? true : showSearchBox;

    this.getValue = function(){
        return value;
    }

    this.changeValue = function(data){
        /*
        if (data.selected.key == 0){
            data.selected.key = -1;
        }
        */
        if (value == data.selected.key){//选中项无改变
            return;
        }
        value = data.selected.key;
        $('#'+container).length > 0 && $('#'+container+' span').text(data.selected.name);
        callback && callback();
    }

    /*
    //因为控件缺陷，将-1的索引改为0，否则-1索引的项会被排列到最后
    var d = {};
    for (var o in data['data']){
        if (-1 == o){
            d[0] = data['data'][o];
        }else{
           d[o] = data['data'][o];
        }
    }
    data['data'] = d;
    */

    new GRI.DropdownList(container, data['data'],showSearchBox, {},this.changeValue);

    $('#'+container).parent().show();
}

/**
 * @description 业务报表页面的选择器对象
 * @param {String} 选择器容器
 * @param {String} 选择器的名称
 * @param {Object} 数据源
 * @param {Object} 回调函数
 * @author johnnyzheng(johnnyzheng@tencent.com)
 * @version  2013-01-04 init
 * 			 2013-05-21 前台大重构，选择器由多选变为单选  by johnnyzheng
 * @example MTA.Page.Condition.version = new MTA.Selector('#div_version', 'version', initParams.version, 'buildData');
 * @注 对象示例名称一定要和groupName同名
 */
MTA.Selector = function(target, groupName, json, callback) {
	this.config = {
		threshold : 5,      // 阈值
        selectorType: 1     //其它选项的展现形式，1： 选择器，2：下拉框，即原有样式
	};
	//成员属性初始化
	this._target = target;
	this._groupName = groupName;
	this._json = json;
	this.show = '';
	this.multi = false;
    this._otherSelector = null;   //其它选项的选择器
    this._selectedValue = '';   //选中的当前值，
	
	var self = this;

	/**
	 * @description获取当前选中checkbox的值，多个值用','分割
	 *
	 */
	this.getValue = function() {
        if (self._selectedValue != ''){
            return self._selectedValue.join(',');
        }

		var values = [];
		$('button[name=' + this._groupName + ']').each(function() {
			$(this).hasClass('current') && values.push($(this).attr('value'));
		});
		return values.join(',');
	};
	/**
	 * @descriprion 获取当前选择器的groupName
	 */
	this.getGroupName = function() {
		return this._groupName;
	}
	/**
	 * @descriprion 获取当前选择器的数据源
	 */
	this.getJson = function() {
		return this._json;
	}
	//清空容器
	$(this._target).empty();
	var html = '<div class="ui_buttons">';
	
	var j = 0;
	for(var i = 0; i <= this._json.seg0.length - 1; i++) {
		html += '<button class="button '+ (this._json.seg0[i].isDefault ? ' current' : '')+'" value="' + this._json.seg0[i].value + '" title="' + this._json.seg0[i].name + '" name="' + this._groupName + '" id="' + this._groupName + '_' + j + '">' + this._json.seg0[i].name + '</button>';
		this._json.seg0[i].isDefault && MTA.Selector.Util.showSelected({
			groupName : MTA.Config.Selector.map[this._groupName],
			name : this._json.seg0[i].name,
			parentId : this._groupName + '_' + j
		});
		j++;
	}

	var tmp_container = '';
	var tmp_show = [];
    var has_otherGroup = true;// this._groupName == 'channel' || this._groupName == 'version';
	for(var i = 0; i <= this._json.seg1.length - 1; i++) {
		if(has_otherGroup && j > self.config.threshold){
			tmp_container += '<button class="button ' + (this._json.seg1[i].isDefault ? ' current' : '') + '" value="' + this._json.seg1[i].value + '" title="' + this._json.seg1[i].name + '" name="' + this._groupName + '" id="' + this._groupName + '_' + j + '">' + this._json.seg1[i].name + '</button>';
		}
		else{
			html += '<button class="button ' + (this._json.seg1[i].isDefault ? ' current' : '') + '" value="' + this._json.seg1[i].value + '" title="' + this._json.seg1[i].name + '" name="' + this._groupName + '" id="' + this._groupName + '_' + j + '">' + this._json.seg1[i].name + '</button>';
			tmp_show.push(this._json.seg1[i].value);
		}
		this._json.seg1[i].isDefault && MTA.Selector.Util.showSelected({
			groupName : MTA.Config.Selector.map[this._groupName],
			name : this._json.seg1[i].name,
			parentId : this._groupName + '_' + j
		});
		j++;
	}
	this.show = tmp_show.join(',');
    var divWrapMoreId = 'wrap_' + this._groupName + '_more'; 
	if(j > self.config.threshold && has_otherGroup && this._json.seg1.length > self.config.threshold) {
        //如果是下拉框形式，则加上pop层
        var dropDownHtml = self.config.selectorType == 1 ? '': '<div class="dropdown" id="pop_' + this._groupName + '_more">' + tmp_container + '</div>';
		html += '<div class="condition-append">' + '<div class="btn-group" id="' + divWrapMoreId + '">' + '<button class="button " id="trig_' + this._groupName + '_more" value="others" href="javascript:void(0);">其它 <i class="icon_menu"></i></button>' + dropDownHtml + '</div></div>';
	}
	
	html += '</div>';
	$(this._target).html(html).parent().show();
	
	MTA.Selector.Util.initPanel();

	//为每一个a标签增加点击事件
	$(this._target).find('button').click(function() {
		if($(this).attr('value') != 'others') {
			_arr = self.getValue().split(',');
			//改变groupName;
			MTA.Selector.Util.groupName = self._groupName;
			MTA.Selector.Util.isAll = false;
			
			//如果点击了其它
			if($(this).parent().attr('id') === "pop_" + self._groupName + "_more"){
				$('#trig_' + self._groupName + '_more').html($(this).text()+' <i class="icon_menu"></i>').addClass('current');
            }
			else{
                self._selectedValue = '';
                self._otherSelector && self._otherSelector.clearSelection();

				$('#trig_' + self._groupName + '_more').html('其它 <i class="icon_menu"></i>').removeClass('current');
			}

			MTA.Selector.Util.clickAction(this, callback, json, _arr, self);
		}
	}); 
	//如果有'其它'选项的时候，点击弹出层弹开。
	if ($('#' + divWrapMoreId).length > 0){
        if (self.config.selectorType == 1){
            var targetId = 'trig_' + self._groupName + '_more';
            var data = self._json.seg1.slice(self.config.threshold);
            self._otherSelector = new Gri.MultiSelect({
                'targetId': targetId,
                'letterSelect': false,
                'multi': false,
                'data': data,
                'dataValue': 'value',
                'dataText': 'name',
                'callback': function(selectedValue, selectedText){
                    self._selectedValue = selectedValue;

                    $(self._target).find('button[name="'+self._groupName+'"]').each(function(idx){
                        $(this).removeClass('current');
                    });

                    $('#trig_' + self._groupName + '_more').html(selectedText + ' <i class="icon_menu"></i>').addClass('current');
                    eval(callback + '()');
                }
            }); 
        }else{
            (MTA.Util.popup('trig_' + this._groupName + '_more', divWrapMoreId, 'pop_' + this._groupName + '_more'));
        }
    }
};

/**
 * Selector 的辅助 函数
 */
MTA.Selector.Util = {
	groupName : '',
	isAll : true,
	selectedContainer : 'dd_selected',
	ctrlPanelTrigger : 'btn_ctrlPanel',
	conditionList : 'list_condition',
	selectedList : 'selected_condition',

	/**
	 * @description 删除已选中的tips
	 * @param {String} 元素ID
	 */
	deleteShow : function(ele) {
		$('#' + ele).click();
	},
	/**
	 * @description 展示已经选中的渠道/版本等
	 * @param {Object}
	 */
	showSelected : function(obj) {
		var self = this;
		var doc = ['<label class="delete" id="lb_' + obj.parentId + '">', '<a href="javascript:void(0);">', '<em>' + obj.groupName + '：</em>' + obj.name + '<i class="close" pid="' + obj.parentId + '">×</i>', '</a>', '</label>'];
		$('#' + this.selectedContainer).append(doc.join(''));
		$('#' + this.selectedContainer).find('label a i').each(function(index) {
			$(this).unbind('click').bind('click', function() {
				$('#' + $(this).attr('pid')).click();
			});
		});
	},
	/**
	 * @description 清除已选中的标识
	 */
	clearSelected : function(groupName, result, obj, showObj) {
		if(result == '0') {
			$('#' + this.selectedContainer).find("label").each(function() {$(this).attr('id').match(/lb_(\w+)_\d{1}/i)[1] == groupName && $(this).remove();
			});
		} else {
			aId = groupName + '_' + MTA.Config.Selector.allSuffix;
			if($(obj).parent().hasClass('selected')) {$('#lb_' + aId).length > 0 && $('#lb_' + aId).remove();
			} else {$('#lb_' + $(obj).attr('id')).length > 0 && $('#lb_' + $(obj).attr('id')).remove();
				this.isAll && this.showSelected({
					groupName : MTA.Config.Selector.map[groupName],
					name : $('#' + aId).attr('title'),
					parentId : aId
				});
				return '';
			}
		}
		this.showSelected(showObj);
	},
	/**
	 * @description 标识是否是收起 还是展开面板
	 * @param {boolean} is_open
	 * @modification 20130521 大改版重构
	 */
	ctrPanel : function(is_open) {
		var self = this;
		if(is_open) {
			// $('#' + this.selectedList).hide();
			$('#' + this.conditionList).fadeIn(200, function() {
				$('#' + self.ctrlPanelTrigger).unbind('click').bind('click', function() {
					MTA.Selector.Util.ctrPanel();
				}).parent().addClass('switch');
				});
		} else {
			$('#' + this.conditionList).fadeOut(300, function() {
				$('#' + self.ctrlPanelTrigger).unbind('click').bind('click', function() {
					MTA.Selector.Util.ctrPanel(true);
				}).parent().removeClass('switch');
				// $('#' + self.selectedList).show();
				});
		}
	},
	/**
	 * 初始化操作
	 */
	initPanel : function() {
		//$('#' + this.selectedList).hide();
		$('#' + this.ctrlPanelTrigger).bind('click', function() {
			MTA.Selector.Util.ctrPanel(true);
		});
	},
	/**
	 * @description 点击checkbox处理函数
	 */
	clickMore : function(callback) {
		//这里会统一处理选中等状态。
		eval(callback + '()');
	},
	/**
	 * @description <a>标签的点击响应
	 * @param {Object}
	 * @param {Object}
	 * @param {Object}
	 * @param {String} current 字符串数字
	 */
	clickAction : function(obj, callback, json, current, ref) {
	
		var result = MTA.Selector.Util.indexOf($(obj).attr('value'), json.seg0), self = this;
		if(!$(obj).hasClass('current')) {
			//因为要单选，所以全部button元素都要取消current样式
			$(ref._target).find('button[name="'+this.groupName+'"]').each(function(idx){
				$(this).removeClass('current');
			});
			$(obj).addClass('current');
			// if(result == 0) {
				// MTA.Selector.Util.cleanOf(json.seg1, obj.name);
// 
			// } else {
				// MTA.Selector.Util.cleanOf(json.seg0, obj.name);
			// }
			
		MTA.Selector.Util.clearSelected(this.groupName, result, obj, {
			groupName : MTA.Config.Selector.map[this.groupName],
			name : $(obj).attr('title'),
			parentId : $(obj).attr('id')
		});
		//这里要控制【设置图例】&【设置表格】的checkbox的可选
			//this.ctrlOpts($(obj).attr('id'), ref);
		
		eval(callback + '()');
		} 
		// else {
			// if(result == 0) {
				// return '';
			// }
			// $(obj).removeClass('current');
			// //如果当期小子项全部都被未选中，则全部渠道要被选中
			// if($.inArray($(obj).attr('value'), current) != -1) {
				// current.splice($.inArray($(obj).attr('value'), current), 1); current.length == 0 && function() {
					// if( ret = $(obj).attr('id').match(/(\w+)_(\d{1})/i)) {
						// $('#' + ret[1] + '_' + MTA.Config.Selector.allSuffix).parent().addClass('current');
						// self.isAll = true;
					// }
				// }();
			// }
		// }
	},
	
	/**
	 * @description选中渠道和版本，控制设置图例 和 设置表格的可选性
	 */
	ctrlOpts : function(id, obj) {
		var opts = MTA.Page.Options, condition = MTA.Page.Condition, optsGroup = MTA.Config.optsGroup;
		var type = id.match(/(\w+)_\d/i)[1];
		if(opts && !MTA.Util.isEmptyObj(opts)){
		for(var o in optsGroup) {
			if(o == type) {
				for(var p in optsGroup[o]) {
					var _k = p + '_' + type + '_group';
					if(condition[type].getValue().indexOf(',') == -1 && condition[type].getValue() != '-1') {
						var _p = $.inArray(_k + ':1,' + ($('#' + _k + '_' + optsGroup[type][p][_k].minor).attr('checked') ? 1 : 0), opts['chart'].optsList); 
						_p != -1 && function() {
								opts['chart'].optsList.splice(-p, 1);
							}();
						$('input[type="checkbox"][name="' + _k + '_' + optsGroup[type][p][_k].main + '"]').each(function() {
							$(this).attr('disabled', 'disabled');
							if($(this).attr('checked')) {
								//如果是要不可以进行细分的情况下，如果当前已经选中了其中的值，则要将其取消掉。
								$(this).removeAttr('checked').click();
							}
						});
						//联动disabled ‘汇总小数据项为其它’  johnnyzheng 2013-02-18
						$('input[type="checkbox"][name="'+_k+'_'+ optsGroup[type][p][_k].minor+'"]').each(function(){
							$(this).attr('disabled', 'disabled').removeAttr('checked');
						});
						
						obj.multi = false;
						var judge = 0, cur = '';
							
							for(var co in MTA.Page.Condition){
								if(MTA.Page.Condition[co].multi){
									judge++;
									cur = co;
								}
							}
							if(judge>0){
							switch(judge){
								case 1 : $('input[type="checkbox"][name="' + p + '_' + cur + '_group' + '_' + optsGroup[cur][p][p + '_' + cur + '_group'].main + '"]').removeAttr('disabled').attr('checked', 'checked').click().attr('checked','checked');
										break;
								default : $('#chart_channel_group_split').removeAttr('checked').click().removeAttr('checked');
										  $('#chart_version_group_split').removeAttr('checked').click().removeAttr('checked');
										  break;
								}
							}
						
					} else {
						//联动 active ‘汇总小数据项为其它’ johnnyzheng 2013-02-18
						$('input[type="checkbox"][name="'+_k+'_'+ optsGroup[type][p][_k].minor+'"]').each(function(){
							$(this).removeAttr('disabled');
						});
						$('input[type="checkbox"][name="' + _k + '_' + optsGroup[type][p][_k].main + '"]').each(function() {
							$(this).removeAttr('disabled');
							//当选中多余1个的时候，默认选中细分 added by johnnyzheng 2013-02-26
							obj.multi = condition[type].getValue() != '-1' ? true : false;
							
							var judge = 0, cur = '';
							for(var co in MTA.Page.Condition){
								if(MTA.Page.Condition[co].multi){
									judge++;
									cur = co;
								}
							}
							switch(judge){
								case 0 : $(this).removeAttr('checked').click().removeAttr('checked');break;
								case 1 : $('input[type="checkbox"][name="' + p + '_' + cur + '_group' + '_' + optsGroup[cur][p][p + '_' + cur + '_group'].main + '"]').removeAttr('disabled').attr('checked', 'checked').click().attr('checked','checked');
										break;
								default : $('#chart_channel_group_split').removeAttr('checked').click().removeAttr('checked');
										  $('#chart_version_group_split').removeAttr('checked').click().removeAttr('checked');
										  break;
								}
						});
					}
				}
			}
			}	
		}
	},
	indexOf : function(value, json) {
		for(o in json) {
			if(json[o].value == value) {
				return 0;
			}
		}
		return -1;
	},
	/**
	 * @description 全部渠道或者版本 与 单个渠道 版本的排他操作
	 */
	cleanOf : function(json, group) {
		for(o in json) {
			$('button[name="' + group + '"][value="' + json[o].value + '"]').removeClass("current");
		}
	}
}

/**
 * @namespace MTA管理器，用于页面初始化、创建查询条件区域
 */
MTA.Report = {

	condition : {},

	initialize : function(dateObj, func) {
		//初始化APP选择器对象
		//MTA.Page.app = new MTA.Applist(MTA.Page.app_list, 'app_list', func);
		//页面全局使用的app对象
		this.condition = new MTA.Condition();
		this.condition.createQueryRange(dateObj, func);
	},

    /**
     * 初始化报表下拉列表：小时报、日报、周报、月报
     * @param data  可选选项，如[{'name':'日报','value':'day'},{'name':'小时报','value':'hour'}];
     * @param defaultValue 默认值，如hour
     */
    initReportList : function(data, defaultValue){
        var id = "report_list";
        var opts = {'data':data,'container':id,'callback':MTA.Report.changeReportType,'defaultValue':defaultValue};
        new MTA.HoverDownList(opts);
    },

    changeReportType : function(selected){
        var url = location.href;
        url = url.replace(/&time_type=(hour|day|week|month)/,"");
        url = url.replace(/time_type=(hour|day|week|month)&*/,"");
        url +=  GRI.Util.convert_params({'time_type':selected['value']}, url);
        location.href = url;
	}
}

/*
 * @namespace 报表展示页面的条件选择区域抽象对象
 */
MTA.Condition = function() {

	/**
	 * 查询条件: 日期对象
	 */
	this._date = {};

	/**
	 * 查询条件: 版本
	 */
	this._version = {};

	/**
	 * 查询条件: 渠道
	 */
	this._channel = {};
}

MTA.Condition.prototype = {

	/**
	 * @description 根据用户选择的版本、日期、平台等构造查询参数对象
	 */
	getQueryParams : function(caller) {
		//表格数据查询
		var params = {};

		params.start_date = this._dateObj.startDate;
		//日期选择器的开始日期
		params.end_date = this._dateObj.endDate;
		//日期寻择期的结束
		params.need_compare = this._dateObj.needCompare;
		params.start_compare_date = this._dateObj.startCompareDate;
		params.end_compare_date = this._dateObj.endCompareDate;
		params.app_id = MTA.Util.getAppId();
		//获取当前的appId
		//params.portalId = MTA.Util.getPortalId(); //获得当前平台名称
		// params.channel = encodeURIComponent(MTA.Page.Condition.channel.getValue()); // 获得当前渠道
		// params.version = MTA.Page.Condition.version.getValue(); //版本

		params = MTA.Util.getConditions(params);

		params = MTA.Util.getOptions(params, caller);

		return params;
	},
	//构造查询表单、包括版本、平台等
	createQueryRange : function(dateObj, func) {
		var self = this;
		//将版本和渠道的选择放到页面上去，由各个自主完成初始化
		// this._version = new MTA.Selector('#div_version','version',jsonVer,func);
		// this._channel = new MTA.Selector('#div_channel','channel',jsonChl,func);
		this._date = new pickerDateRange(dateObj.inputId, {
			theme : 'ta', // 日期选择器TA主题
			autoCommit : true, //自动提交，完成日期初始化，以及图表的展示拉取
			isTodayValid : dateObj.isTodayValid,
			startDate : dateObj.startDate,
			endDate : dateObj.endDate,
			needCompare : dateObj.needCompare,
			startCompareDate : dateObj.startCompareDate,
			endCompareDate : dateObj.endCompareDate,
			singleCompare : dateObj.singleCompare,
			defaultText : dateObj.defaultText,
			autoSubmit : dateObj.autoSubmit || false ,
			shortOpr : dateObj.shortOpr || false,
			target : dateObj.target,
			calendars : dateObj.calendars || 2,
			inputTrigger : dateObj.inputTrigger || 'input_trigger',
			validStartTime : dateObj.validStartTime,
            minValidDate:dateObj.minValidDate,
			success : function(obj) {
				self._dateObj = obj;
				//在 MTA.Page的命名空间内 增加 DatePicker 属性 方便在页面周期内取得自主控制权
				MTA.Page.DatePicker = obj;
				if(obj.needCompare == '1') {
					MTA.Options.Util.ctrlAllActive();
					$('#short_opt').hide();
				} else {
					MTA.Options.Util.ctrlAllActive(true);
					$('#short_opt').show();
				}
				func && eval(func + '()');
			}
		});
	}
}

/**=======================================================
 * @description 页面上设置图例/设置表格的选项的对象
 * @param {Array}
 * @param {String}
 * @param {String}
 * @author johnnyzheng(johnnyzheng@tencent.com)
 * @version 2013-01-06 init
 *========================================================
 */

MTA.Options = function(arr, con, nam, type, noSelect) {
	//已经选中的optslist
	this.optsList = [];
	this.type = type || 'table';
	this.container = con;
	this.target = 'wrap_' + con;
	this.trigger = 'trig_' + con;
	this.pop = 'pop_' + con;
	this.nam = nam || '设置图例';
	this.clicked = false;

	//options选择器可能存在的特殊指标
	this.splOpts = {
		chart : {
			'line' : '线图',
			'column' : '柱图'
		}
	};

	//同组联动元素的配置
	//key:这一组元素的组名，后面组装url参数的参数名称，
	//value: 这一组元素的触发全选的元素name

	var self = this;
	//组件的初始化
	(arr.length > 0 ) && function() {
		var _c = function() {
			con = [];
			for(var o in MTA.Page.Condition) {
				con.push(o);
			}
			return con
		}();

		var doc = '<div class="btn-group" id="' + self.target + '"><button class="btn" id="' + self.trigger + '"><i class="icon-ipt"></i>' + self.nam + '</button><div class="dropdown" id="' + self.pop + '">';
		//如果是图的设置，则增加chartType的选择
		if('chart' == self.type && !noSelect) {
			doc += '<div class="view-kind cf"><div class="kind-group">';
			for(var o in self.splOpts.chart) {
				doc += '<a hidefocus="true" id="' + o + '" href="javascript:void(0);" ' + (o == 'area' ? ' class="selected"' : '') + '><i class="icon-chart-' + o + '">' + self.splOpts.chart[o] + '</i></a>';
			}
			doc += '</div></div>';
		}
		doc += '<dl class="view-list">';
		//生成图例代码。但是这里需要根据界面上已有的选择器的情况来决定有多少图例的选择器
		for(var i = 0; i < arr.length; i++) {
			_continue = false;
			if(!arr[i].group || (arr[i].group && $.inArray(arr[i].group, _c) != -1)) {
				for(var o in MTA.Config.optsGroup[arr[i].group]) {
					if(arr[i].key == MTA.Config.optsGroup[arr[i].group][o].minor_name) {
						doc += '<dd><label><input level="minor" type="checkbox" id="' + arr[i].key + '" name="' + arr[i].key + '" ' + (arr[i].group ? "group=" + arr[i].group : '') + ' value="1"></input>' + arr[i].value + '</label></dd>';
						_continue = true;
					}
				}
				if(_continue)
					continue;
				doc += '<dt><label><input level="main" type="checkbox"' + (MTA.Config.optsGroup.need_trigger == arr[i].key ? ' disabled = disabled ' : '') + 'id="' + arr[i].key + '" name="' + arr[i].key + '" ' + (arr[i].group ? "group=" + arr[i].group : 'group="none"') + ' value="1"></input>' + arr[i].value + '</label></dt>';
			}
		}
		doc += '</dl></div></div>';
		$('#' + self.container).html(doc);
		//弹出层次处理
		MTA.Util.popup(self.trigger, self.target, self.pop);
	}();

	/**
	 * @description 选中同组元素，并且将值push到相应的数组中
	 * @param {Object} 被点击元素对象
	 * @param {String} 被点击元素的name
	 */
	this.checkGroup = function(obj) {
		var _r = false, _gs = $(obj).attr('group');
		if(_gs && _gs != 'none') {
			var _g = MTA.Config.optsGroup[_gs][this.type], self = this;
			for(var o in _g) {
				var _n = o + '_' + _g[o].main, _m = o + '_' + _g[o].minor;
				//如果是汇总小数据项目为其它发生点击事件
				(function() {
					$('#' + self.target).find('input[type="checkbox"][name^="' + o + '"]').each(function() {
						_v = o + ':1,1';
						//如果点击的是细分版本/渠道
						if(_n == $(obj).attr('name')) {
							_p = $.inArray(_v, self.optsList);
							if($(obj).attr('checked')) {
								$(this).attr('checked', 'checked');
								//这里注视掉是是一期没有联动，后续解注就可以了。
								_p == -1 && self.optsList.push(_v);
								//排除有group下的选中情况
								for(var p in MTA.Config.optsGroup) { gr = MTA.Config.optsGroup[p][self.type], _vp = '';
									for(var q in gr) {
										_vp = q + ':1,1';
										break;
									}
									if(_v != _vp && $.inArray(_vp, self.optsList) != -1)
										self.optsList.splice($.inArray(_vp, self.optsList), 1);
								}
								MTA.Options.Util.clearOthers($(obj).attr('id'), self);
							} else {
								$(this).removeAttr('checked'); _p != -1 && self.optsList.splice(_p, 1); $.inArray(o + ':1,0', self.optsList) != -1 && self.optsList.splice($.inArray(o + ':1,0', self.optsList), 1);
							}
							_r = true;
						}
						//如果点击的是 汇总小数据项为其他
						if(_m == $(obj).attr('name')) {
							$('#' + self.target).find('input[type="checkbox"][id="' + _n + '"]').each(function() {
								if(!$(this).attr('checked') && $(obj).attr('checked')) {
									$(this).attr('checked', 'checked');
									//added by johnnyzheng 2013-01-26 点击汇总的时候汇总其它数据项也联动
									MTA.Options.Util.clearOthers($(this).attr('id'), self);
								}
							});
							_vm = o + ':1,' + ($(obj).attr('checked') ? 1 : 0); $.inArray(_v, self.optsList) != -1 ? self.optsList.splice($.inArray(_v, self.optsList), 1, _vm) : function() {$.inArray(o + ':1,0', self.optsList) == -1 ? self.optsList.push(_vm) : self.optsList.splice($.inArray(o + ':1,0', self.optsList), 1, _vm);
							}();
							_r = true;
						}
					});
				})();
			}
		}
		return _r;
	};
	/**
	 * @description 获得当前实例名称并标识是当前操作的选择器
	 */
	this.getInstanceName = function(bind) {
		for(var o in MTA.Page.Options) {
			if(MTA.Page.Options[o] == this) {
				MTA.Page.Options[o].current = true;
				MTA.Page.Options[o].bind = bind;
				continue;
			}
			MTA.Page.Options[o].current = false;
		}
	};
	/**
	 * @description 暴露一个接口给外面，让每个自定义的多个options选择器自己去组参数
	 */
	this.setParams = function() {

	}

	this.bindClick = function(callback) {

		//如果是图例设置
		if(this.type == 'chart') {
			$('#' + this.target).find('div[class="kind-group"] a').each(function() {
				$(this).bind('click', function() {
					//柱图的时候不显示小计 0124 added by johnnyzheng
					$(this).attr('id') == 'column' ? $('#chart_calc_sum').parent().hide() : $('#chart_calc_sum').parent().show();
					$(this).addClass('selected').siblings().removeClass('selected');
					self.getInstanceName(callback);
					var _e = 'chart_type:' + $(this).attr('id');
					for(var o in self.splOpts.chart) {$.inArray('chart_type:' + o, self.optsList) != -1 && self.optsList.splice($.inArray('chart_type:' + o, self.optsList), 1);
					}
					self.optsList.push(_e);
					callback && eval(callback + '()');
				});
			});
		}

		$('#' + this.target).find('input[type="checkbox"]').each(function() {
			$(this).bind('click', function() {
				self.getInstanceName(callback);
				if(!self.checkGroup(this)) {
					var _v = $(this).attr('name') + ':' + $(this).attr('value');
					if($(this).attr('checked')) {
						self.optsList.push(_v);
					} else {
						self.optsList.splice($.inArray(_v, self.optsList), 1);
					}
				}
				//调用回调函数
				callback && eval(callback + '()');
				//标识已点击
				this.clicked = true;
			})
		});
	};
};
/**
 * @description 设置图例，设置表格的工具对象
 * @author johnnyzheng(johnnyzheng@tencent.com) 点击按时间对比的时候，要把设置图例和设置表格的选择全部disabled掉
 */
MTA.Options.Util = {

	/**
	 * @description disabled所有的checkbox的选项
	 */
	ctrlAllActive : function(active) {
		var opts = MTA.Page.Options, optsGroup = MTA.Config.optsGroup;
		for(var o in MTA.Page.Options) {
			$('#' + MTA.Page.Options[o].pop).find('input[type="checkbox"]').each(function() {
				active ? $(this).removeAttr('disabled') : function(obj) {
					$(obj).attr('disabled', 'disabled').removeAttr('checked');
					MTA.Page.Options[o].optsList = [];
				}(this);
			});
		}
	},
	/**
	 * @description 清楚其他checkbox的选项
	 * @param {String} 元素ID
	 * @param {Object} 设置图例的控件对象
	 */
	clearOthers : function(id, options) {
		var opts = MTA.Page.Options, optsGroup = MTA.Config.optsGroup;
		for(var o in opts) {
			if(options == opts[o]) {
				$('#' + MTA.Page.Options[o].pop).find('input[type="checkbox"]').each(function() {$(this).attr('level') == 'main' && $(this).attr('id') != id && $(this).attr('group') != 'none' && function(obj) {
						$(obj).removeAttr('checked');
						opts[o].checkGroup(obj);
					}(this);
				});
			}
		}
	}
};

/** =======================================================
 * @description Applist的构造函数，初始化
 * @param {Array} arr applist数组
 * @param {String} target 绑定的容器
 * @param {Object} extra 附加参数
 * @author johnnyzheng(johnnyzheng@tencent.com)
 * @version 2013-01-05 init
 */
MTA.Applist = function(arr, target, defaultAppId) {
	// appId 初始值
	this.appId = '';
	this.appName = '';
	this.appLogo = '';
	this.appList = [];
	this.portalId = '';
	this.portalDesc = '';
	this.TIME_OUT = null;
	this.frontAppList = [];
	//控件内容填充
	var self = this, subMenu = {}; 
	(arr.length > 0) && function() {
		self.appList = arr;
		var doc = '';
		for(var i = 0; i < arr.length; i++) {
			if($.inArray(arr[i].AppName +'##'+ arr[i].RegAccount, self.frontAppList) === -1){
				self.frontAppList.push($.trim(arr[i].AppName)+'##'+arr[i].RegAccount);
			}
		}
		//这里有一个负责的操作，先按照创建人和应用名称分组，然后再追加html代码段
		for(var j= 0 ; j < self.frontAppList.length; j++){
			var name = self.frontAppList[j].split('##')[0];
			var author = self.frontAppList[j].split('##')[1];
			doc += '<li id="'+ self.frontAppList[j].replace(/#/g, '') +'">'+ name +'<div class="sub_menu">';

			for(var i = 0; i < arr.length; i++) {
				if(name == arr[i].AppName && author === arr[i].RegAccount){
					doc += '<a class="'+MTA.Config.platformMap[arr[i].Portal].css+'" href="#" id="' + arr[i].AppId + '">' + arr[i].AppName+ '</a>';
				}
				(defaultAppId == arr[i].AppId) && function() {
				self.appId = arr[i].AppId;
				self.appName = arr[i].AppName;
				self.appLogo = arr[i].AppLogo;
				self.portalId = arr[i].Portal;
				self.portalDesc = MTA.Config.platformMap[arr[i].Portal].desc;
			}();
			}
			doc += '</li></div>';
		}
		
		$('#' + target).length > 0 && ($('#' + target).html(doc));
		
		$('#' + target).find('li a').each(function(index) {
			$(this).bind('click', function() {
				self.changeApp(this);
			}).hover(function() {index == 0 ? $('#i_selector').addClass('ib-first-hover') : $('#i_selector').removeClass('ib-first-hover');
			}).mouseout(function() {
				$('#i_selector').removeClass('ib-first-hover');
            });
		});
        
        //信息初始化
        self.appLogo && $('#app_logo').length > 0&&$('#app_logo').html('<img src="' + self.appLogo + '">');
        self.portalId && $('#app_name').length > 0&&$('#app_name').html(self.appName)&&$('<i class="icon_'+MTA.Config.platformMap[self.portalId].css+'"></i>').insertAfter($('#app_name'));
	
	}();

	//$('#app_platform').length >0&& $('#app_platform').html(this.portalDesc);
	
	//调用公共气泡层接口
	MTA.Util.popup('btn_pop_app', 'wrap_pop_app', 'ctn_pop_app', 'show');
	//绑定查询接口
	$('#btn_app_search').length > 0 && function(){
		$('#btn_app_search').click(function(){
			var str = ($('#txt_app_search').length > 0 && $('#txt_app_search').val()) || '';
			for(var i=0; i<self.frontAppList.length;i++){
				var id = self.frontAppList[i].replace(/#/g, '');
				$('#' + id).hide();
				if($.trim(str) !== ''){
					self.frontAppList[i].substr(0, self.frontAppList[i].indexOf('##')).indexOf(str) != -1 && $('#'+ id ).show();
				}
				else {
					$('#'+ id).show();
                }
			}
	    });
        $("#txt_app_search").keydown(function(event){
            if (13 == event.keyCode){
                $('#btn_app_search').click();
            }
        });
	}();
	//绑定切换函数
	this.bindChange = function(callback) {
		return true;
	};
	//获取app信息
	this.getAppInfo = function() {
		return {
			'appId' : this.appId,
			'appName' : this.appName,
			'appLogo' : this.appLogo,
			'appPortal' : this.portalDesc
		};
	};
	/**
	 * 根据 AppId 获取应用对象
	 */
	this.getAppObject = function(appId) {
		for(var o in this.appList) {
			if(this.appList[o].AppId === appId) {
				return this.appList[o];
			}
		}
	}

	this.getAppList = function() {
		return this.appList;
	}
	/**
	 * @description 切换应用和平台
	 * @param {Object}
	 * @param {Object} callback 回调函数
	 */
	this.changeApp = function(obj, callback) {
		//切换站点，改变全局变量的属性值
		for(var i = 0; i < this.appList.length; i++) {
			if(obj.id == this.appList[i].AppId) {
				this.appId = this.appList[i].AppId;
				this.appName = this.appList[i].AppName;
				this.appLogo = this.appList[i].AppLogo;
				this.portalId = this.appList[i].Portal;
				this.portalDesc = MTA.Config.platformMap[this.appList[i].Portal].desc
				parse_r = GRI.Util.parse_url();
				parse_r.param['app_id'] = this.appId;
				window.location.href = parse_r.path + GRI.Util.convert_params(parse_r.param);
				return false;
			}
		}
		//改变界面的值
		$('#app_name').html('<img width="20" height="20" src="' + this.appLogo + '">' + this.appName + '_' + this.portalDesc + '版');
		//如果有回调函数，调用回调函数
		callback && eval(callback + '()');
	}
}


/**==============================================
 * @description MTA的菜单对象
 * @param {Obj} arr 菜单
 * @param {String} target 菜单容器
 * @author johnnyzheng(johnnyzheng@tencent.com)
 * @version 2013-01-05 init
 */
MTA.Menu = function(arr, target) {

	this.menuList = {};

	var self = this;
	/**
	 * @description 通过url返回菜单配置信息
	 * @param {String} url
	 */
	this.getMenuInfo = function(url) {

        var matchUrl = function(url, m_url){
			//如果配置中加了参数，则去掉问号后的参数再比较
        	var pos = m_url.indexOf('?');
			if (pos >= 0){
				pos && (m_url = m_url.substring(0, pos));
			}

            return url == m_url;
        };

		//如果是数据概览，则处理相应的菜单状态
		if(this.menuList.main['0'] && matchUrl(url, this.menuList.main['0'].m_url)){
				return {
					'm_id' : this.menuList.main['0'].m_id,
					'm_name' : this.menuList.main['0'].m_name,
					'p_name' : '腾讯云分析'
				};
		}
		for(var o in this.menuList.sub) {
			if(matchUrl(url, this.menuList.sub[o].m_url)) {
				//获得父级菜单的名称
				var p_name = function() {
					if(self.menuList.sub[o].m_is_child) {
						return self.menuList.sub[self.menuList.sub[o].p_id].m_name;
					}
					return self.menuList.main[self.menuList.sub[o].p_id].m_name;
				}();
				//将其与子菜单信息合并成一个对象
				return $.extend(true, this.menuList.sub[o], {
					'p_name' : p_name
				});
			}
		}
	};
	/**
	 * @description 菜单点击切换功能时，传递appId
	 * @param {String} appId 应用ID
	 */
	this.changeFuc = function(loc, appId) {
		//执行数据统计
		// window.location.href = loc + (appId ? '?app_id=' + appId : '');
		 window.location.href = loc;
		return false;
	};
	
	arr && function() {
		self.menuList = arr;
		//构造html代码
		var html = '';
		var appId =  MTA.Util.getAppId();
		for(var o in arr.main) {

				arr.main[o].m_display && function() {
					html += '<div class="mod_sidemenu' + (arr.main[o].m_is_expanded == 0 ? ' hide':'') + '">'+
								'<h3 class="title" id="parent_menu_'+arr.main[o].m_id+'">'+
									'<a href="javascript:;">'+
                    							'<i class="' + arr.main[o].m_icon_css + '"></i>'+ arr.main[o].m_name +
									'<i id="i_menu_'+arr.main[o].m_id+'" class="icon_menu"></i></a>'+
								'</h3><div id="child_menu_'+arr.main[o].m_id+'" style="position:relative;zoom:1' + (arr.main[o].m_is_expanded == 0 ? ';display:none':'') + '">';
					for(var p in arr.sub) {
						if(arr.sub[p].p_id == arr.main[o].m_id && arr.sub[p].m_display) {
                            var url = '/mta' + arr.sub[p].m_url;
                            appId && (url += GRI.Util.convert_params({app_id: appId}, url));
							html += '<ul class="content"><li>'+
									'<a id="menu_' + arr.sub[p].m_id + '" href="' + url + '">' + arr.sub[p].m_name +(arr.sub[p].m_is_new ? '<i class="icon_new">新</i>' : '')+'</a>'+
									'</li></ul>';
						}
					}
					html += '</div></div>';
				}();

		}
		$('#' + target).html(html);
	}();

	//子菜单的点击事件
	$('#' + target).find('a[id^="menu_"]').each(function() {
		$(this).bind('click', function() {
			var appId =  MTA.Util.getAppId();
			//如果有自定义函数，则依赖此回调。
			if (typeof (MTA.Function.setMenuParams) == 'function'){
                var href = $(this).attr("href");
                params = MTA.Function.setMenuParams();
                //href += GRI.Util.convert_params(params, href) + "&app_id=" + appId;
                href += GRI.Util.convert_params(params, href);
                window.location.href = href;
                return false;
            }
            
			return self.changeFuc($(this).attr('href'), appId);
		})
	});
	//菜单的收折效果
	$('#' + target).find('h3[id^="parent_menu_"]').each(function() {
		$(this).unbind('click').bind('click', function() {
			child = 'child_menu_' + $(this).attr('id').match(/parent_menu_(\d{1})/i)[1];
			if($('#' + child).is(':hidden')) {
				$(this).parent().removeClass('hide');
				$('#' + child).slideDown(300, function(){
                    self.saveMenuStatus();
                });
			} else {
				$('#' + child).slideUp(300, function(){
                    $(this).parent().addClass('hide');
                    self.saveMenuStatus();
                });
			}
		});
	});

    //记录闭合的菜单id到cookie
    this.saveMenuStatus = function(){
        var closeMenuId = '';
        $('div[id^=child_menu_]').each(function(){
            if($(this).is(':hidden')) {
                var menuId = $(this).attr('id').replace('child_menu_', '');
                closeMenuId += menuId + ',';
            }
        });
        //#表示没有闭合菜单
        (closeMenuId.length == 0) && (closeMenuId = '#');
        GRI.Util.cookie.save('mtaCloseMenuId', closeMenuId);
    };
    //从cookie恢复菜单状态
    this.recoverMenuStatus = function(){
        var closeMenuId = GRI.Util.cookie.get('mtaCloseMenuId');
        if(closeMenuId){
            $('div[id^=child_menu_]').each(function(){
                var menuId = $(this).attr('id').replace('child_menu_', '');
                if(closeMenuId.indexOf(menuId) > -1){
                    $(this).parent().addClass('hide');
                    $(this).hide();
                }
                else
                {
                    $(this).parent().removeClass('hide');
                    $(this).show();
                }
            });
        }
    };
}
/**
 * MTA的菜单对象 ： END
 * ========================================================
 */

/**
 * @namespace MTA管理器，用于页面初始化、创建查询条件区域
 */
MTA.Data = {
	/**
	 * 图的拉取数据的地址
	 */
	chartCgi : '',
	/**
	 * 表拉取数据的地址
	 */
	tableCgi : '',

	/**
	 * @description 拉取基础数据
	 * @param {String} cgi 地址
	 * @param {Object} 回调函数
	 * @param {Boolean} 是否使用日期
	 * @param {Object} 待扩展的参数
	 */
	loadBasic : function(cgi, hdl, useDate, extra){
		var params =  {
			'app_id' : MTA.Util.getAppId()
		},
		_extra = {
			useMask : true // 是否使用遮罩层
		};
		_extra = $.extend(true, _extra, extra);
		//如果默认使用类库提供的日期拼接，则设置为true
		useDate && function(){
			params.start_date = MTA.Report.condition._dateObj.startDate;
            params.end_date = MTA.Report.condition._dateObj.endDate;
		}();
		
		params = $.extend(true, params, MTA.Page.Params);
		//added by johnnyzheng 2013-07-12追加其它信息
		var _conditions = {};
		!MTA.Util.isEmptyObj(MTA.Report.condition) && (_conditions = MTA.Report.condition.getQueryParams());
		params = $.extend(true, params, _conditions);
		var url = MTA.Config.RootPath + cgi + GRI.Util.convert_params(params, cgi)+"&rnd="+(+new Date());
		if(_extra['useMask']){
			GRI.Util.loading.show('main');
		}
		return $.getJSON(url, function(data){
			//调用回调函数
			hdl(data);
			GRI.Util.loading.clear('main');
		});
	},
	
	/**
	 * @description 加载图的数据
	 * @params {String} cgi webservice 地址
	 * @params {Obj} 配置对象
	 * @params {String} 容器ID
	 */
	loadChart : function(cgi, chartOpt, container, height, callback) {
		var caller = MTA.Data.loadChart.caller.toString().match(/function\s(\w+)\(\s*|\w*\)/i)[1];
		var params = MTA.Report.condition.getQueryParams(caller);
		params = $.extend(true, params, MTA.Page.Params);
		var url = MTA.Config.RootPath + cgi + GRI.Util.convert_params(params, cgi)+"&rnd="+(+new Date());

		GRI.Util.loading.show('main');
		$.getJSON(url, function(data) {
            if (data['is_session_expire'] && data['type']=='wechat'){
                MTA.Weixin.Util.expire();
                return;
            }
			var containerId = '#' + container;
			$(containerId).empty();

			if(height == undefined) {
				height = 300;
			}
			var options = {};
			if(data.chartOptions != null) {
				options = {
					chartOptions : data.chartOptions
				};
			}

			if(data.enableLegend != null) {
				options['enableLegend'] = data.enableLegend;
			}
			options = $.extend(true, options, chartOpt);
			//如果自定义title
			if(chartOpt.title){
				options.title = {text : data.title + chartOpt.title, useHTML : true};
			}
            var isCompare = url.indexOf("need_compare=1") >= 0  ? 1 : 0;
			var _opt = {
				chartType : data.chartType || 'line',
				categories : data.categories,
				series : data.series,
				title : data.title,
				height : height,
                isCompareSeries:isCompare,
				dataFormat: data.dataFormat || '1'
			};

			_opt = $.extend(true, _opt, options);
			$(containerId).createChart(_opt);
			GRI.Util.loading.clear('main');

            callback && callback();
		});
	},
	/**
	 * @description 加载图的数据
	 * @params {String} cgi webservice 地址
	 * @params {Obj} 配置对象
	 * @params {String} 容器ID
	 */
	loadBar : function(cgi, chartOpt, container) {
		var caller = MTA.Data.loadBar.caller.toString().match(/function\s(\w+)\(\s*|\w*\)/i)[1];
		var params = MTA.Report.condition.getQueryParams(caller);
		params = $.extend(true, params, MTA.Page.Params);
		var url = MTA.Config.RootPath + cgi + GRI.Util.convert_params(params, cgi)+"&rnd="+(+new Date());

		$.getJSON(url, function(data) {
			var containerId = '#' + container;
			$(containerId).empty();
			data.chartOptions = data.chartOptions || {};
			data.chartOptions.chart = data.chartOptions.chart || {};
			data.chartOptions.chart.marginright = 150;
            var cateLen = data.categories ? data.categories.length + 1 : 1;
			//只显示一个图
			var _opt = {
				chartType : 'bar',
				height : cateLen * 45 + 50,
				xAxisLabelStep : 1,
				enableLegend : false,
				labelFormat : 2,
				categories : data.categories,
				series : data.series,
				title : data.title,
				chartOptions : data.chartOptions
			};
			_opt = $.extend(true, _opt, chartOpt);
			$(containerId).createChart(_opt);
		});
	},
	/**
	 * @description 加载图的数据
	 * @params {String} cgi webservice 地址
	 * @params {Obj} 配置对象
	 * @params {String} 容器ID
	 */
	loadTable : function(cgi, container, hdl) {

		var caller = MTA.Data.loadTable.caller.toString().match(/function\s(\w+)\(\s*|\w*\)/i)[1];
		var params = MTA.Report.condition.getQueryParams(caller);
		params = $.extend(true, params, MTA.Page.Params);
		var url = MTA.Config.RootPath + cgi + GRI.Util.convert_params(params, cgi)+"&rnd="+(+new Date());
		GRI.Util.loading.show('main');
		$.getJSON(url, {}, function(result) {
            if (result['is_session_expire'] && result['type']=='wechat'){
                MTA.Weixin.Util.expire();
                return;
            }
			var spanColIndex = result.spanColIndex == false ? null : '0';
			var dt = Gri.initDataTable({
				tableId : container,
				data : result.data,
				allFields : result.fields,
                complexHeader:result.complexHeader,
				layout : 'auto',
				spanColIndex : spanColIndex,
				page : result.page || false,
				noPage : result.noPage,
				fixedRow : result.fixedRow,
				//cssSetting:result.cssSetting,
				callback : function() {
					hdl && hdl();
				}
			});
			GRI.Util.loading.clear('main');
		});
	},
    /**
     *
     * @param data_url
     * @param container
     * @param chartOpts
     */
    loadKeyIndex : function(data_url,container, chartOpts) {
        if (undefined === chartOpts){
            chartOpts = {'theme':'wechat'};
        }
        var caller = MTA.Data.loadKeyIndex.caller.toString().match(/function\s(\w+)\(\s*|\w*\)/i)[1];
        var params = MTA.Report.condition.getQueryParams(caller);
        params = $.extend(true, params, MTA.Page.Params);
        var url = MTA.Config.RootPath + data_url + GRI.Util.convert_params(params, data_url)+"&rnd="+(+new Date());

        $.getJSON(url, {}, function(result) {
            if (result['is_session_expire'] && result['type']=='wechat'){
                MTA.Weixin.Util.expire();
                return;
            }
            if (result['data'].length == 0){
                return;
            }
            var obj = $("#"+container).parent().parent().children(".title");
            obj.children(".key_index_title").remove();
            //obj.append('<span class="key_index_title text">'+result.end_day.substr(5)+'</span>');

            var con = $("#" + container);
            con.addClass("ui_trendgrid_" + result['data'].length);
		
            html = "<tbody><tr>";
            for (var i = 0; i < result['data'].length; i++){
                var v = result['data'][i];
                var c = 0 == i ? "class='first'" : (result['data'].length-1 == i ? "class='last'" : "");
                var chart_con = "key_index_chart_"+v['key'];
                html += "<td "+c+"><div class='ui_trendgrid_item'>";
                html += "<div class='ui_trendgrid_chart' id='"+chart_con+"'></div>";
                html += "<dl>";
                html += "<dt><b>"+v['name']+"</b></dt>";

                var is_qc_page = chartOpts.isQc || 0;

                if(is_qc_page){
                    html += formatNum(v, 1);
                }else{
                    html += formatNum(v);
                }
                for (var j = 0; j < v['rate'].length; j++){
                    html += "<dd>"+v['rate'][j]['name']+formatRate(v['rate'][j]['num'])+"</dd>";
                }
                html += "</dl>";
                //html += "<div class='ui_trendgrid_time'>"+result.begin_day+"至"+result.end_day+"</div>";
                html += "</div></td>";

            }
            html += "</tr></tbody>";
            con.html(html);

            var margin = 0;
            switch (result['data'].length){//左右两边空隙的补丁
                case 2:
                    margin = -13;
                    break;
                case 3:
                    margin = -8;
                    break;
                case 4:
                    margin = -6;
                    break;
                case 5:
                    margin = -5;
                    break;
            }
            chartOpts = $.extend({chartOptions:{chart:{spacingLeft:margin-1,spacingRight:margin}}},chartOpts);
            if (chartOpts['theme'] != 'wechat'){
                for (var k in result['chart']){
                    var chart_con = "key_index_chart_"+k;
                    MTA.Data.showKeyIndexChart(result['chart'][k], chartOpts, chart_con);
                }
            }
            if (typeof(MTA.key_index_ad) == 'function'){
                MTA.key_index_ad();
            }
        });

        function formatRate(rate){
            if (null == rate || isNaN(rate)){
                return "&nbsp;&nbsp;&nbsp;-- ";
            }
            var html = "";
            if (rate < 0){
                html += "<i class='icon_down' title='下降'></i>";
                rate = -rate;
            }else{
                html += "<i class='icon_up' title='上升'></i>";
            }
            rate = accMul(rate, 100);
            html += rate + "%";
            return html;
        }

        function addCommas(nStr) {
            nStr += '';
            var x = nStr.split('.');
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(d+)(d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }

            return x1 + x2;
        }

        function formatNum(v, ignore){
            v['num'] += "";
            if(v['format'] && v['format'] == "percent"){
                v['num'] = Math.round(v['num'] * 10000) / 100 + "%";
            }

            if ( null == v['num'] || (v['num'].indexOf("%") < 0 && isNaN(v['num'])) ){
                return "<dd class='ui_trendgrid_number' style='font-size:12px;'>无数据或计算中...</dd>";
            }
            if (v['num'].indexOf("%") >= 0){//如果是百分比，原样输出
                num = v['num'];
                var unit = v['unit'] || "";
            }else{
                if(ignore){
                    var num = parseInt(v['num']);
                    var unit = v['unit'] || "";
                }else{
                    var num = parseFloat(v['num']);
                    var unit = v['unit'] || "";
                    if (num >= 1000000000){
                        num = parseInt(num / 1000000);
                        unit = "M" + unit;
                    }else if (num >= 1000000){
                        num = parseInt(num / 1000);
                        unit = "K" + unit;
                    }else if (num >= 1000){
                        //num = parseInt(num);
                        num = v['num'];
                    }
                }

                num += '';
                var n = num.split('.');
                var n1 = n[0];
                var n2 = n.length > 1 ? '.' + n[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(n1)) {
                    n1 = n1.replace(rgx, '$1' + ',' + '$2');
                }
                num = n1 + n2;
            }

            var html = "<strong>"+num+"</strong><em class='ui_trendgrid_unit'>"+unit+"</em>";
            html = "<dd class='ui_trendgrid_number'>"+html+"</dd>";
            return html;
        }

        function accMul(arg1,arg2)
        {
            var m=0,s1=arg1.toString(),s2=arg2.toString();
            try{m+=s1.split(".")[1].length}catch(e){}
            try{m+=s2.split(".")[1].length}catch(e){}
            return Number(s1.replace(".",""))*Number(s2.replace(".",""))/Math.pow(10,m)
        }
    },
    /**
     *
     * @param data 图的数据
     * @param chartOpt 图的特殊配置，暂时未用
     * @param container 容器id
     * @param height 高度
     */
    showKeyIndexChart:function(data, chartOpt, container, height){
        height = height ? height : 75;
        var min = false;
        for (var i = 0; i < data['series'][0]['data'].length; i++){
            if (data['series'][0]['data'][i]['y'] === null){
                continue;
            }
            //data['series'][0]['data'][i]['y'] *= 100;
            if (false===min  || data['series'][0]['data'][i]['y'] < min){
                min = data['series'][0]['data'][i]['y'];
            }
        }
        min = false===min ? 0 : min;
        //min -= min > 10 ? min/10 : 1;

        var elem = $("#"+container);
        var color = chartOpt['theme'] == 'wechat' ? '#F7F7F7' : '#FFFFFF';
        elem.empty();
        var _opt = {
            chartType: 'line',
            chartOptions:
            {
                chart:{
                    'height':height,
                    marginBottom: -1,
                    borderWidth:0,
                    spacingLeft:0,
                    spacingRight:0,
                    spacingBottom:0,
                    backgroundColor:color
                },
                xAxis: {
                    labels : {
                        enabled : false
                    }
                },
                yAxis:{
                    labels : {
                        enabled : false
                    },
                   // 'min': min,
                    gridLineWidth :0
                },
                legend : {
                    enabled : false
                },
                tooltip :{
                    enabled : false
                },
                plotOptions:{
                    series: {
                        lineWidth:1,
                        enableMouseTracking: false,
                        animation: false,
                        marker: {
                            enabled: false,
                            states: {
                                hover: {
                                    enabled: false
                                }
                            }
                        }
                    }
                }
            },
            enableLegend:false,
            categories: data.categories,
            series : data.series,
            title : data.title,
            'height':height+"px"
        };
        _opt = $.extend(true, {}, _opt, chartOpt);
        elem.createChart(_opt);
    },
    /**
     * @description 加载图的数据
     * @params {String} cgi webservice 地址
     * @params {Obj} 配置对象
     * @params {String} 容器ID
     */
    exportTable : function(cgi) {
        var caller = MTA.Data.exportTable.caller.toString().match(/function\s(\w+)\(\s*|\w*\)/i)[1];
        var params = MTA.Report.condition.getQueryParams('buildDataTable');
        params['export'] = 1; // 标识导出
        params = $.extend(true, params, MTA.Page.Params);
        var url = MTA.Config.RootPath + cgi + GRI.Util.convert_params(params, cgi)+"&rnd="+(+new Date());
        window.open(url,'new');
    },
	/**
	 * @description 加载表的数据，分页
	 * @params {String} cgi webservice 地址
	 * @params {Obj} 配置对象
	 * @params {String} 容器ID
	 */
	loadPageTable : function(cgi, container, hdl) {
		var caller = MTA.Data.loadPageTable.caller.toString().match(/function\s(\w+)\(\s*|\w*\)/i)[1];
		var params = MTA.Report.condition.getQueryParams(caller);
		params = $.extend(true, params, MTA.Page.Params);
		var url = MTA.Config.RootPath + cgi + GRI.Util.convert_params(params, cgi)+"&rnd="+(+new Date());

		GRI.Util.loading.show('main');
		$.getJSON(url, {}, function(result) {
            var spanColIndex = result.spanColIndex == false ? null : '0';
			var dt = Gri.initDataTable({
				tableId : container,
				data : result.data,
				allFields : result.fields,
				complexHeader:result.complexHeader,
				//layout:'auto',
				spanColIndex : spanColIndex,
				page : {
					ifRealPage : 0,
					size : result.size,
                    autoHide:false
				},
				callback : function() {
					hdl && hdl(result);
				}
			});
			GRI.Util.loading.clear('main');
		});
	},
    /**
     * @description 加载表的数据，分页
     * @params {String} cgi webservice 地址
     * @params {Obj} 配置对象
     * @params {String} 容器ID
     */
    loadSimpleTable : function(cgi, container) {
        GRI.Util.loading.show('main');
        $.getJSON(cgi, {}, function(result) {
            var dt = Gri.initDataTable({
                tableId : container,
                data : result.data,
                allFields : result.fields,
                //layout:'auto',
                spanColIndex : "0",
                page : {
                    ifRealPage : 0,
                    size : result.size,
                    autoHide: false
                },
                callback : function() {

                }
            });
            GRI.Util.loading.clear('main');
        });
    }
}

MTA.Dialog = GRI.Dialog;

/*
 * 下拉选择器
 * data : {
    container: '',  //容器id
    defaultValue: '', //默认选项,支持默认选择某一value对应的项，如：10 或者默认的text，如：'请选择你的学历'
    items: [{id:10, name:'大学', desc:'关于大学的描述'}]
    }
    size:large medium
    callback:响应change事件如：function(){console.log('hello');}
 */
MTA.DropDownList = function(data, size, callback){
    var ulId = 'ul_' + data.container;
    var btnId = 'btn_' + data.container;
    var divListId = 'div_list_' + data.container;
    var divDropDownListId = 'div_drop_down_list_' + data.container;
    var lbId = 'lb_title_' + data.container;
    var html =
        ' <div class="select-append select-' + size + '" name="div_drop_down_list" id="' + divDropDownListId + '"> '
            + '     <div id="' + divListId + '" class="btn-group" name="div_select_list"><!--open 为显示浮层--> '
            + '         <label id="' + lbId + '" class="select-label"></label> '
            + '         <button class="btn btn-mini" id="' + btnId + '"><i class="icon-caret"></i></button> '
            + '         <!--下拉菜单--> '
            + '         <div class="dropdown"> '
            + '             <ul class="list-menu" id="' + ulId + '"> '
            + '             </ul> '
            + '         </div> '
            + '     </div> '
            + ' </div><!-- end of select- append --> ';

    var itemsHtml = '';
    var selectItem = '';
    for(var i in data.items){
        var item = data.items[i];
        if (undefined == data.defaultValue){
            data.defaultValue = item.id;
        }
        itemsHtml += '<li title="' + (item.desc?item.desc:item.name) + '"><a href="javascript:void(0);" value="' + item.id + '" text="' + item.name + '">' + item.name + '</a></li>';
        item.id == data.defaultValue && (selectItem = item);
    }

    $('#' + data.container).html(html);
    $('#' + ulId).html(itemsHtml);

    //处理默认值
    selectItem ? $('#' + lbId).html(selectItem.name).attr('value', selectItem.id).attr('text', selectItem.name):$('#' + lbId).html(data.defaultValue).attr('value', '').attr('text', data.defaultValue);

    $('#' + btnId + ',#' + lbId).click(function(){
        $('#' + divListId).toggleClass('open');
    });
    $('#' + ulId).find('a').click(function(){
        var oldValue = $('#' + lbId).attr('value');
        var newValue = $(this).attr('value');
        $('#' + lbId).html($(this).html()).attr('value', $(this).attr('value')).attr('text', $(this).attr('text'));
        $('#' + divListId).removeClass('open');
        if(oldValue != newValue){
            callback && callback(data.container);
        }
    });

    this.selectedValue = function(){
        return $('#' + lbId).attr('value');
    }
    this.selectedText = function(){
        return $('#' + lbId).attr('text');
    }
    this.selectValue = function(itemValue){
        var value = this.selectedValue();
        var text = this.selectedText();

        for(var i=0; i<data.items.length; i++){
            if(data.items[i].id == itemValue){
                value = itemValue;
                text = data.items[i].name;
                break;
            }
        }
        $('#' + lbId).attr('value', value);
        $('#' + lbId).attr('text', text);
        $('#' + lbId).text(text);
    }
    $('body').click(function(){
        $('#' + divListId).removeClass('open');
    });
    $('#' + divDropDownListId).click(function(){
        $('div[name=div_select_list][id!='+ divListId+ ']').removeClass('open');
        return false;
    });
};

/**
 *
 * @param opts
 * container  容器id
 * data [{'name':k1,'value':v1},{'name':k2,'value':v2}]格式数组 下拉列表选项
 * callback 回调函数，组件会给该回调函数传递选中项对象，选中项格式：{'name':k1,'value':v1}
 * defaultValue 字符串或者数字，默认值，可选
 * autoTrigger 初始化时是否默认触发调用一次回调函数，可选，默认false
 * @constructor
 */
MTA.HoverDownList = function(opts){
    var defaultOpts = {'autoTrigger':false,'hoverTrigger':true};
    opts = jQuery.extend({}, defaultOpts, opts);
    opts.defaultValue = undefined==opts.defaultValue ? opts.data[0].value:opts.defaultValue;
    opts.defaultName = "";
    for (var i = 0; i < opts.data.length; i++){
        var item = opts.data[i];
        if (item.value == opts.defaultValue){
            opts.defaultName = item.name;
        }
    }

    var id = opts['container'];
    var obj = $("#"+id);
    obj.addClass("ui_menu");

    var html = "<button class='button button_link'>"+opts.defaultName+"<i class='icon_menu'></i></button><ul class='ui_menu_list' role='menu' aria-labelledby='dropdownMenu' style='display:none;'>";
    for (var i = 0; i < opts.data.length; i++){
        var item = opts.data[i];
        var c1 = 0==i ? "class='first'" : ((opts.data.length-1)==i ? "class='last'":"");
        var c2 = item.value==opts.defaultValue ? "class='current'" : "";
        html += "<li "+c1+"><a "+c2+"href='javascript:void(0);' value='"+item.value+"' tadindex='-1'>"+item.name+"</a></li>";
    }
    html += "</ul></span>";
    obj.html(html);

    if (opts['hoverTrigger']){
        obj.hover(function(){
            obj.children(".ui_menu_list").show();
        },function(){
            obj.children(".ui_menu_list").hide();
        });
    }else{
        obj.children(".button.button_link").click(function(){
            if (obj.children(".ui_menu_list").css("display") == 'none'){
                obj.children(".ui_menu_list").show();
            }else{
                obj.children(".ui_menu_list").hide();
            }
            return false;
        });
        $("body").click(function(){
            obj.children(".ui_menu_list").hide();
        });
    }

    obj.find(".ui_menu_list li").each(function(){
        $(this).click(function(){
            var v = $(this).find("a").attr("value");
            var name = $(this).find("a").html();
            if (v != opts.defaultValue){
                $(this).parent().find("a").removeClass("current");
                $(this).find("a").addClass("current");
                opts.defaultValue = v;
                if (undefined != opts.callback){
                    opts.callback({'value':v,'name':name,'id':id});
                }
            }
            $(this).parent().parent().children("button.button_link").html(name+"<i class='icon_menu'></i>");
            $(this).parent().hide();
            return false;
        });
    });

    if (opts['autoTrigger']){
        for (var x in opts.data){
            if (opts.data[x].value == opts.defaultValue){
                if (undefined != opts.callback){
                    var d = $.extend(opts.data[x],{'id':id});
                    opts.callback(d);
                }
                break;
            }
        }
    }

    this.getSelected = function(){
        if ($("#"+id+" .ui_menu_list").find("a.current").length == 0){
            return false;
        }
        var v = $("#"+id+" .ui_menu_list").find("a.current").attr("value");
        var name =  $("#"+id+" .ui_menu_list").find("a.current").html();
        return {'value':v,'name':name};
    }
}

/**
 * @description 微信公众平台命名空间
 */
MTA.Weixin = {
    Util: {
        lastHeight:-1,
        /**
        * @description 自适应iframe高度调整
        */
        recalcHeight :  function() {
			MTA.Weixin.Util.setHeight();
			setInterval(function(){
				MTA.Weixin.Util.setHeight();
			},200);
        },
        expire : function(){
            if ((typeof(Iframe) != "undefined") && Iframe.post){
                Iframe.post({ type: 'expire' }, location.hostname);
            }
        },		
		setHeight : function(){
			var height;
			var browser;

			var ua = navigator.userAgent.toLowerCase();
			var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
				/(webkit)[ \/]([\w.]+)/.exec( ua ) ||
				/(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
				/(msie) ([\w.]+)/.exec( ua ) ||
				ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
				[];
			browser = match[ 1 ] || "";

			if (browser == 'mozilla') {
				height = document.documentElement.offsetHeight;
			} else if (browser == 'msie') {
				var body = document.body;
				height = document.body.scrollHeight + parseInt(body.currentStyle.marginTop) + parseInt(body.currentStyle.marginTop);
			} else {
				height = document.documentElement.scrollHeight;
			}
            if (height == MTA.Weixin.Util.lastHeight){
                return;
            }
            MTA.Weixin.Util.lastHeight = height;
			if ((typeof(Iframe) != "undefined") && Iframe.post){
				Iframe.post({
					type: 'setHeight',
					height: height
				}, location.hostname);
			}
		}
    }
}


//MTA类型转换函数
MTA.Converter = {
    toInt: function(val){
        result = isNaN(val)? 0 : parseInt(val);
    },
    toFloat: function(val){
        result = isNaN(val)? 0 : parseFloat(val);
    },
    toDate: function(val){
        var sDate = strDate.replace(/(^\s+|\s+$)/g,''); //去两边空格;   
        if(sDate==''){
            return null;   
        }

        var s = sDate.replace(/[\d]{4,4}[\-/]{1}[\d]{1,2}[\-/]{1}[\d]{1,2}/g, '');   
        if (s == '')    
        {   
            var t=new Date(sDate.replace(/\-/g,'/'));   
            var ar = sDate.split(/[-/:]/);   
            if(ar[0] == t.getFullYear() && ar[1] == t.getMonth() + 1 && ar[2] == t.getDate())   
            {   
                return t;   //返回转化成功的日期对象   
            }   
        }   

        return null;   

    }
};


/* MTA校验类 
    对指定的juery对象应用相关的校验规则，下面是检验规则的定义：
    rule = {
        elem: '#txtAppName',    //jquery选择器
        title: '应用名称',      //检验的名称
        required: true,         //是否必填
        dataType: 'int',        //数据类型，比如int, number, url等等
        regExpress: '',         //自定义的正则表达式验证
        min: '',                //最小值
        max: '',                //最大值
        minLength: '',          //最小长度
        maxLength: '',          //最小长度
        fn: null,               //自定义检验函数
        fail: null,             //检验错误时的回调函数
        succ: null,             //检验成功时的回调函数
    }

    示例：
    MTA.Validation.init([
            {elem: '#txtAppName',
                title: '应用名称',
                required: true,                 
                fail: function(obj, msg){
                    var name = obj.attr('tag');
                    $('#tr' + name).attr('class', 'error');
                    $('#span' + name).html(msg);
                },
                succ: function(obj){
                    var name = obj.attr('tag');
                    $('#tr' + name).attr('class', 'success');
                    $('#span' + name).html('');
                }
            }        
    ]);

 */
MTA.Validation = MTA.Validation || {};
MTA.Validation = (function(opts){
    var rules = [];
    var regs = {
        'int': /^\d*$/,
        'number': /^(-?\d+)(\.\d+)?$/,
        'date': /^(([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})-(((0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)-(0[1-9]|[12][0-9]|30))|(02-(0[1-9]|[1][0-9]|2[0-8]))))|((([0-9]{2})(0[48]|[2468][048]|[13579][26])|((0[48]|[2468][048]|[3579][26])00))-02-29)$/,
        'uin': /^(-?\d+)(\.\d+)?$/, ///^\d{5,11}$/,
        'telephone': /^\d{3}-\d{8}$|^\d{4}-\d{8}$/, 
        'mobile': /^(130|131|132|133|134|135|136|137|138|139|150|153|157|158|159|180|187|188|189)\d{8}$/,
        'idcard15': /^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$/,
        'idcard18': /^((11|12|13|14|15|21|22|23|31|32|33|34|35|36|37|41|42|43|44|45|46|50|51|52|53|54|61|62|63|64|65)[0-9]{4})(([1|2][0-9]{3}[0|1][0-9][0-3][0-9][0-9]{3}[X0-9])|([0-9]{2}[0|1][0-9][0-3][0-9][0-9]{3}))$/,  
        'ip': /^(([1-9]|([1-9]\d)|(1\d\d)|(2([0-4]\d|5[0-5])))\.)(([1-9]|([1-9]\d)|(1\d\d)|(2([0-4]\d|5[0-5])))\.){2}([1-9]|([1-9]\d)|(1\d\d)|(2([0-4]\d|5[0-5])))$/,
        'url': /^(http|https|ftp)\:\/\/[a-zA-Z0-9\-\._]+\.[a-zA-Z]{2,3}(:[a-zA-Z0-9]*)?\/?([a-zA-Z0-9\-\._\?\,\'/\\\+&%\$#\=~])*$/,
        'email': /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/,
        'chn': /^[a-zA-Z0-9_\u4e00-\u9fa5]+$/,      //仅包含数字，字母和中文的字符串
        'safechar': /^[^\\^'^"]+$/,                 //除去/,',",\之外的字符串
        'all': ''
    };

    var bindEvent = function(rule){
        $(rule.elem).live('keyup',
            function(event){
            
                /*
                //检查最大长度限制
                var maxLen = rule.maxLength || $(this).attr('maxLength');
                if (!maxLen) return true;

                if ($(this).val().length >= maxLen){
                    $(this).val($(this).val().substring(0, maxLen));
                    return false;
                }
                */
                
                isValid(rule, $(this));
            }
        ).live('keydown',
            function(event){

                //设置最大长度
                if (!$(rule.elem).attr('maxlength')){
                    rule.dataType == 'uin' && (rule.maxLength = 12);
                    rule.maxLength && $(rule.elem).attr('maxlength', rule.maxLength);    
                }

                //按下ctrl、shift、alt 等功能键
//                if(event.ctrlKey || event.shiftKey || event.altKey) return true; 

                //方向键 && F1..F12
                var key = event.keyCode;
                if(key >= 33 && key <= 47) return true;
                if(key >= 112 && key <=137) return true;

                var arrKeyCode = {8: 'BackSpace', 
                    9: 'Tab', 
                    12: 'Clear', 
                    13: 'Enter', 
                    16: 'Shift_L', 
                    17: 'Control_L', 
                    18: 'Alt_L',
                    19: 'Pause',
                    20: 'Caps_Lock',
                    27: 'Escape'
                };
                if (arrKeyCode[key]) return true;

                var dataType = rule.dataType || $(this).attr('dataType') || '';
                switch(dataType.toLowerCase())
                {
                    case "number":
                        if(!((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || key == 190 || key==189 || key==109 || key==110))
                        return false;
                        else return !event.shiftKey;
                        break;
                    case "uin": 
                    case "int":
                        if(!((key >= 48 && key <= 57) || (key >= 96 && key <= 105)))
                        return false;
                        else return !event.shiftKey;
                        break;
                    case "telphone":
                        if(!((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || key == 189 || key == 109))
                        return false;
                        else return !event.shiftKey;
                        break;
                    case "mobile":
                        if(!((key >= 48 && key <= 57) || (key >= 96 && key <= 105)))
                        return false;
                        else return !event.shiftKey;
                        break;
                    case "date":
                        if(!((key >= 48 && key <= 57) || (key >= 96 && key <= 105) || (key >= 189 && key<=191) || key == 32 || key==109 || key==110))
                        return false;
                        else return !event.shiftKey;
                        break;
                }

                //检查最大长度限制
                var maxLen = rule.maxLength || $(this).attr('maxLength');
                if (!maxLen) return true;

                if ($(this).val().length >= maxLen){
                //    $(this).val($(this).val().substring(0, maxLen));
                //    return false;
                }
                return true;
            }
        ).live('blur', function(e){
            isValid(rule, $(this));
        });
    }

    var init = function(rs){
        rules = rs;

        for(var id in rules){
            bindEvent(rules[id]);
        }
    
    };

    function isValid(rule, obj){

        obj = obj || $(rule.elem);      //如果不指定jquery对象，则从rule中获取
        var val = obj.val();
        var dataType = rule.dataType;
        var title = rule.title;

        var onFail = function(msg){
            rule.fail && rule.fail(obj, msg);
        }
        var onSucc = function(){
            rule.succ && rule.succ(obj);
        }

        //对于隐藏控件、只读控件、已禁用的控件 不进行前端校验
        if (obj.attr("display") == "none" || obj.attr("readonly") == true || obj.attr("disabled") == true) return true;

        //检验非空值
        var isEmptyValue = !val || val.replace(/\ /gi,'') == '';
        if(rule.required  && isEmptyValue)
        {
            onFail('请输入' + title + '');
            return false;
        }

        //允许为空，且无值则不校验
        if (isEmptyValue) return true; 


        //检验正则表达式，如数字，日期，url等
        if (regs[dataType] && !regs[dataType].test(val)){ 
            onFail(title +   '的数据格式不合法 ！');
            return false;
        }
        
        if (rule.regExpress){
            if (!rule.regExpress.test(val)){
                onFail(title +   '的数据格式不合法 ！');
                return false;
            };
        }

        var checkRange = function(val, min, max){
            var result = false;
            if (min && val >= min){
                result = true; 
            }
            if (max && val <= max){
                result = true;
            }

            return result;
        }

        var converter = {
            'int': function(val){
                return MTA.Converter.toInt(val);
            },
            'number': function(val){
                return MTA.Converter.toFloat(val);
            },
            'date': function(val){
                return MTA.Converter.toDate(val);
            }
        };

        //检验最大最小值
        if (rule.min || rule.max){
            //转换数据类型
            var minVal = converter[dataType]? converter[dataType](rule.min): rule.min;
            var maxVal = converter[dataType]? converter[dataType](rule.max): rule.max;
            val = converter[dataType]? converter[dataType](val): val;

            if (!checkRange(val, minVal, maxVal)){

                var msg = (minVal && maxVal) ? title +   '的数据应在' + rule.min + '和' + rule.max + '之间 ！'
                : (minVal) ? title + '不能小于' + rule .min : title + '不能大于' + rule.max;

                onFail(msg);
                return false;
            }
        }

        //检验最小长度
        if (rule.minLength && val.length < rule.minLength){
            onFail(title + '的长度不能少于' + rule.minLength + '个字符');
            return false;
        }

        //自定义函数验证
        if (rule.fn){
            var r = rule.fn(obj);
            if (r == false) return false;   //如果验证不成功直接退出，否则进行下一步验证
        }

        onSucc();                         //验证成功
        return true;
    }


    return {
        init: init,
        addRule: function(rule){
            rules.push(rule);
            bindEvent(rule);
        },
        clearRule: function(){
            rules = [];   
        },
        validate: function(){
            var result = true;
            for(var i in rules){
                var r = rules[i];
                $(r.elem).each(function(){
                    result = isValid(r, $(this)) && result;
                });
            }               

            return result;
        }
    };
})();


 
/*
 * 下拉列表， 
 */
(function($){
    $.fn.extend({
        DropDownList:function(opts) {
            var id = $(this).attr("id");
            var html = "<a class='ui_menu_link' href='javascript:void(0);'><i class='icon_datepicker'></i></a><ul class='ui_menu_list'>";
            opts.defaultValue = undefined==opts.defaultValue ? opts.data[0].value:opts.defaultValue;
            for (var i = 0; i < opts.data.length; i++){
                var item = opts.data[i];
                var c1 = 0==i ? "class='first'" : ((opts.data.length-1)==i ? "class='last'":"");
                var c2 = item.value==opts.defaultValue ? "class='current'" : "";
                html += "<li "+c1+"><a "+c2+"href='javascript:void(0);' value='"+item.value+"'>"+item.name+"</a></li>";
            }
            html += "</ul>";
            $(this).parent(".title").css("z-index", 999);
            $(this).html(html);

            $(this).find(".ui_menu_link").click(function(){
                var obj = $(this).next();
                if (obj.css("display") == "none"){
                    obj.show();
                }else{
                    obj.hide();
                }
                return false;
            });

            $(this).find(".ui_menu_list li").each(function(){
                $(this).click(function(){
                    var v = $(this).find("a").attr("value");
                    if (v != opts.defaultValue){
                        $(this).parent().find("a").removeClass("current");
                        $(this).find("a").addClass("current");
                        opts.defaultValue = v;
                        if (undefined != opts.callback){
                            opts.callback(v);
                        }
                    }
                    $(this).parent().hide();
                    return false;
                });
            });

            $("body").click(function(){
                $(".ui_menu_list").hide();
            });
        }
    })
})(jQuery);


