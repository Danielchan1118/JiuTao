

Gri = window.Gri || {};

Gri.MultiSelect = function(opts) {
	var itemIndex = 0;
	var selectValue = new Array();
	var selectText = new Array();
	var targetObj = '';
    var isSelectAll = false;
	
	opts = $.extend({}, Gri.MultiSelect.defaultOpts, opts);

	if(opts.targetId === '') {
		return false;
	}else {
		targetObj = $("#" + opts.targetId);
	}
	
	if(!opts.data || opts.data.length <= 0) {
		return false;
	}
	var identify = (new Date().getTime()) + ('' + (Math.random()*(20-10)+10)).substring(3);
	
	var _initPanel = function(type) {
		var pos = targetObj.offset();
		pos.top = pos.top + targetObj.height() + (targetObj.attr('tagName') == 'label' ? 0 : 10);//top:' + pos.top + 'px;left:' + pos.left + 'px;

		//头部信息，包括输入过滤框
		var htmlStr = '<div id="' + identify + '" class="multi-select condition-dropdown large-dropdown" style="display:none;top:' + pos.top + 'px;left:' + pos.left + 'px;">' +
			'<h5>' + opts.title + '<span class="h-tips">(' + (opts.multi == 0 ? '单选' : '多选') + ')</span>' +
				'<span class="more"><label class="search-bar"><input type="text" value="' + opts.wording + '" class="input-search"><a href="#" class="btn-search"><i class="icon-search2"></i></a></label></span>' +
			'</h5>';
		//字母过滤区
		var letterHtml = '';
		if(opts.letterSelect == 1) {
			letterHtml = '<div class="condition-letters"><a href="" class="letter">#</a>';
			for(var i = 65; i < 91; i++) {
				letterHtml += '<a href="" class="disabled">' + String.fromCharCode(i) + '</a>'
			}
			letterHtml += '</div>';
		}
		htmlStr += letterHtml;
		//内容区
		var content = '<div class="content">' +
			'<ul class="list-horizontal">';
        if(opts.multi == 1) {
            content += '<li><label><a href="#" val="all" title="全部" itemFilter="qb">全部</a></label></li>';
        }
		for(var i = 0, len = opts.data.length; i < len; i++) {
			content += '<li><label><a href="#" val="' + opts.data[i][opts.dataValue] + '" title="' + opts.data[i][opts.dataText] + '" ' + 'itemFilter="' + (opts.letterSelect == 1? makePy(opts.data[i][opts.dataText]).join('').toLowerCase(): '') + '">' + opts.data[i][opts.dataText] + '</a></label></li>';
		}
		content += '</ul></div>';
		
		htmlStr += content;
		//已选择区
		if(opts.multi == 1) {
			var selectedContent = '<div class="condition-footer"><div class="content-selected cf">' +
				'<h5>已选择：</h5>' +
					'<ul class="list-horizontal">' +
					'</ul>' +
				'</div>' +
				'<div class="form-actions">'+
					'<button type="button" class="btn btn-primary">确定</button>'+
				'</div></div>';
			htmlStr += selectedContent;	
		}
		htmlStr += '</div>';

        if(type == '1') {
            $("#" + identify).remove();
        }
        $('body').append(htmlStr);

        var width = $(window).width();
        var fact_width = pos.left + $("#" + identify).width();
        if(fact_width > width) {
            pos.left = pos.left - (fact_width - width) - 15;
            $("#" + identify).css('left', pos.left);
        }
	};
	
	var _controlWording = function() {
		$("#" + identify).find('input.input-search').focus(function() {
			var val = $(this).val();
			if(val == opts.wording) {
				$(this).val('');
			}
		});
		$("#" + identify).find('input.input-search').blur(function() {
			var val = $(this).val();
			if(val == '') {
				$(this).val(opts.wording);
			}
		});
	};
	
	var _deleteItem = function(item, type) {
		var itemVal = item.attr('val');
		if(type == 1) {//从内容区删除
			item.parent().removeClass('selected');
			$("#" + identify + " .content-selected li a").each(function() {
				if($(this).attr('val') == itemVal) {
					$(this).parent().parent().remove();
					return ;
				}
			});
		}else {//从已选择区删除
			item.parent().parent().remove();
			$("#" + identify + " .content li a").each(function() {
				if($(this).attr('val') == itemVal) {
					$(this).parent().removeClass('selected');
					return ;
				}
			});
		}

        if (itemVal == 'all'){
            selectValue = [];
            selectText = [];
            itemIndex = 0;
            isSelectAll = false;
        }
		//从记录选择值的数组中删除
		for(var i = 0; i < selectValue.length; i++) {
			if(itemVal === selectValue[i]) {
				selectValue.splice(i, 1);
				selectText.splice(i, 1);
				if(opts.multi == 1) {
					itemIndex--;
				}
				break;
			}
		}
	};
	
	var _selectItem = function(item) {
		item.parent().addClass('selected');
		var itemVal = item.attr('val');
		var selectItemHtml = '<li><label class="' + (itemVal == 'all' ? 'all' : '') + '"><a href="#" val="' + item.attr('val') + '">' + item.html() + '</a><em>&times;</em></label></li>';
		if(opts.multi == 1) {
            if(itemVal == 'all') {
                isSelectAll = true;
                $("#" + identify + " .content-selected li a").each(function() {
                    $(this).click();
                });
            }else {
                isSelectAll = false;
                var all = $("#" + identify + " .content-selected li label.all a");
                if(all.length > 0) {
                    all.eq(0).click();
                }
            }
        }
        $("#" + identify + " .content-selected ul").append(selectItemHtml);

		$("#" + identify + " .content-selected li").last().find("a, em").bind('click', function() {
			var deleteItem = $(this).parent().find('a');
			_deleteItem(deleteItem, 0);
		});
		//将所选添加到选择值记录数组
		selectValue[itemIndex] = item.attr('val');
		selectText[itemIndex] = item.html();
		if(opts.multi == 1) {
			itemIndex++;
		}
	};
	
	var _bindClickEvent = function() {
		//内容区Item绑定点击事件
		$("#" + identify + " .content li a").each(function() {
			var itemFilter = $(this).attr('itemFilter');
			$("#" + identify + " .condition-letters a.disabled").each(function() {
				if($(this).html().toLowerCase() === itemFilter.substring(0, 1)) {
					$(this).removeClass('disabled');
					$(this).addClass('letter');
				}
			});
		}).bind('click', function() {
			var item = $(this);
			if(item.parent().hasClass('selected')) {
				_deleteItem($(this), 1);
			}else if(opts.multi == 0) {
                $("#" + identify + " .content li label.selected").each(function() {
                    $(this).removeClass('selected');
                });
                _selectItem($(this));
                targetObj.attr('tagName') === 'label' ? '' : targetObj.attr('title', selectText.join(';'));
                if(opts.callback !== '') {
                    opts.callback(selectValue, selectText, isSelectAll);
                }
            }else {
                _selectItem($(this));
            }
            if(opts.multi == 0) {
                $("#" + identify).hide();
            }
		});
		//字母选择
		$("#" + identify + " .condition-letters a.letter").bind('click', function() {
			if(!$(this).hasClass('selected')) {
				$("#" + identify + " .condition-letters a.selected").each(function() {
					$(this).removeClass('selected');
				});
				
				$(this).addClass('selected');
				
				var letter = $(this).html().toLowerCase();
				if(letter === '#') {
					$("#" + identify + " .content li a").each(function() {
						$(this).parent().parent().show();
					});
				}else {
					$("#" + identify + " .content li a").each(function() {
						if($(this).attr('itemFilter').substring(0, 1) === letter) {
							$(this).parent().parent().show();
						}else {
							$(this).parent().parent().hide();
						}
					});
				}
			}
		});
		//确定按钮
		$("#" + identify + " .form-actions button").bind('click', function() {
			targetObj.attr('tagName') === 'label' ? '' : targetObj.attr('title', selectText.join(';'));
			if(opts.callback !== '') {
                if(opts.multi == 1 && selectValue[0] == 'all') {
                    for(var i = 0, len = opts.data.length; i < len; i++) {
                        selectValue[i] = opts.data[i][opts.dataValue];
                        selectText[i] = opts.data[i][opts.dataText];
                    }
                }
				opts.callback(selectValue, selectText, isSelectAll);
			}
            $("#" + identify).hide();
		});
	};
	
	var _inputFilter = function(input_text) {
		input_text = input_text.toLowerCase();

		$("#" + identify + " .content li a").each(function() {
			if($(this).html().toLowerCase().indexOf(input_text) >= 0) {
				$(this).parent().parent().show();
			}else if($(this).attr('itemFilter').indexOf(input_text) >= 0) {
				$(this).parent().parent().show();
			}else if(input_text == '') {
				$(this).parent().parent().show();
			}
			else {
				$(this).parent().parent().css('display', 'none');
			}
		});
	};
	
	var _bindKeyEvent = function() {
		var keycode = event.which || event.keyCode;
		if(keycode == 8 || (keycode < 128 && keycode > 31)) {
			var input_text = $(this).val();//$(obj).find('input.input-search').val();
			_inputFilter(input_text);
		}
	};

	_initPanel(0);
	_controlWording();
	_bindClickEvent();
	$("#" + identify).find('input.input-search').bind('keyup', _bindKeyEvent);
	
	$(targetObj).bind('click', function() {
        var pos = targetObj.offset();
        pos.top = pos.top + targetObj.height() + (targetObj.attr('tagName') == 'label' ? 0 : 10);
        $("#" + identify).css('top', pos.top);

        var width = $(window).width();
        var fact_width = pos.left + $("#" + identify).width();
        if(fact_width > width) {
            pos.left = pos.left - (fact_width - width) - 15;
            $("#" + identify).css('left', pos.left);
        }

        //如果选择器是隐藏的，则显示出来
        if ($("#" + identify).is(":hidden")){
    		$(".multi-select").hide();
	    	$("#" + identify).show();
        }else{
            $("#" + identify).hide();
        }
		return false;
	});
	
	$("#" + identify).bind('click', function() {
		return false;
	});
	
	$(document).bind('click', function() {
		$("#" + identify).hide();
	});

    this.setValue = function(value) {
        value = value.split(',');

        $("#" + identify + " .content-selected li a").each(function() {
            $(this).click();
        });
        selectValue.length = 0;
        selectText.length = 0;
        itemIndex = 0;
        var items = $("#" + identify + " .content li a")
        for(var i = 0, len = value.length; i < len; i++) {
            for(var j = 0, l = items.length; j < l; j++) {
                if($(items[j]).attr('val') == value[i]) {
                    $(items[j]).click();
                    break;
                }
            }
        }
        if(opts.multi == 1) {
            if(targetObj.attr('tagName') != 'label') {
                targetObj.attr('title', selectText.join(';'));
                targetObj.val(selectText.join(','));
                targetObj.attr('ids', selectValue.join(','));
            }
        }
    };

    this.setData = function(data) {
        opts.data = data;

        _initPanel(1);
        _controlWording();
        _bindClickEvent();
        $("#" + identify).find('input.input-search').bind('keyup', _bindKeyEvent);

        $(targetObj).bind('click', function() {
            //如果选择器是隐藏的，则显示出来
            if ($("#" + identify).is(":hidden")){
                $(".multi-select").hide();
                $("#" + identify).show();
            }else{
                $("#" + identify).hide();
            }

            return false;
        });

        $("#" + identify).bind('click', function() {
            return false;
        });

        $(document).bind('click', function() {
            $("#" + identify).hide();
        });
    };

    //清除所有选择项
    this.clearSelection = function(){
        $("#" + identify + " .content li label.selected").removeClass('selected');
    }
};

Gri.MultiSelect.defaultOpts = {
	'targetId'     : '',
	'letterSelect' : 1,
	'multi'        : 1,
	'title'        : '选择器',
	'wording'      : '请输入任意值搜索',
	'data'         : new Array(),
	'dataValue'    : 'value',
	'dataText'     : 'text',
	'filterSelect' : 0,
	'filter'       : new Array(),
	'dataFilter'   : 'filter',
	'callback'     : ''
};
