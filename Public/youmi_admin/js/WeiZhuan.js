// 包括框架初始化文件和公共的方法

var WeiZhuan = {

	//初始化方法,会自动初始化参数
	init:function(config){
		con = config['init'];
		con = con.split(",");
		for(i=0;i < con.length;i++){
			eval('WeiZhuan.init'+con[i]+"(config[con[i]])");
		}
	},

	//2个加载按钮，加载左部菜单，加载右部内容
	initLoadContent:function(){
		$('*[target]').live('click',function(){
			e = this;
			Id = $(this).attr('target');
			Url = $(this).attr('href');
			//加载内容
			$.get(Url,function(data){
				$(e).parent('li').siblings().removeClass('active');
				$(e).parent('li').addClass('active');
				$('#'+Id).html(data);
			});
			return false;
		})
	},
	
	//检查Form的值是否符合规范
	isForm:function(name){
		//防止多次检查
		if(WeiZhuan.isFormStatus == null){
			WeiZhuan.isFormStatus = 1;
			WeiZhuan.Submit = null;
			$("form[name='"+name+"'] input[data-check]").each(function(index, element) {
	            type = $(this).attr('data-check');
				val = $(this).val();
				if(!eval('WeiZhuan.is'+type+"(val)")){
					WeiZhuan.InputBorderColor = $(this).css('border-color');
					$(this).css('border-color','#F00');
					WeiZhuan.Submit = 1;
					$(this).focus();
					return false;
				}else{
					$(this).css('border-color',WeiZhuan.InputBorderColor);
				}
	        });
	        WeiZhuan.isFormStatus = null;
	    }
	},
	
	//初始化登录注册用提交按钮
	initSubmit:function(){
		$('#submit').click(function(){
			name = $(this).attr('data');
			WeiZhuan.isForm(name);
			if(WeiZhuan.Submit == null){
				$("form[name='"+name+"']").submit();
			}
		})
	},

	//登录注册回车事件
	LoginOrReg:function(name){
		WeiZhuan.isForm(name);
        if(WeiZhuan.Submit == 1){
			return false;
		}
	},

	//检查input框的值是否符合规范
	initInputCheck:function(name){
		$('input[data-check]').focusout(function(){
			WeiZhuan.isForm(name);
		});
	},
	
	//初始化刷新按钮
	//发进来的类名是点击按钮
	initRefreshButtom:function(cl){
		$('.'+cl).click(function(){
			alert('img.'+cl);
			$('img.'+cl).attr('src',AjaxUrl.VerifyUrl+'?'+WeiZhuan.getLocalTime());
			return false;
		})
	},
	
	//检查用户名
	isUserNmae:function(s){
		if(s){
			$.get(AjaxUrl.checkuser,{'username':s},function(data){
				if(data.error){
					alert(data.content);
				}
			},'json');
			return true;
		}else{
			$("#MessUsername").css("color","red");
			$("#MessUsername").html("由6-16位的字母/数字组成！");
			return false;
		}
	},
	
	//检查用户名
	initUserName:function(){
		$( "#UserName" ).blur( function(){
			var username = $(this).val();
			
			if(username){
				var reg =  /^([a-zA-Z0-9]|[_]){4,16}$/;
				if(!reg.test(username) || username =='' || username.length<6 || username.length>17){
					$("#MessUsername").css("color","red");
					$("#MessUsername").html("由6-16位的字母/数字组成！");
				}else{
					$.ajax({
						type:"get",
						url:AjaxUrl.checkuser,
						data:"username="+username,
						success:function(data){
							if(data == 1){
								$("#MessUsername").css("color","green");
								$("#MessUsername").html("用户名可以使用");
							}else{
								$("#MessUsername").css("color","red");
								$("#MessUsername").html("用户名已被占用");
							}
						}
					})
				}
			}else{
				$("#MessUsername").css("color","red");
				$("#MessUsername").html("由6-16位的字母/数字组成！");
			}
		});
	},
	
	//获取客户端时间
	getLocalTime:function(){
		return Date.parse( new Date());
	},
	
	//验证IP地址
	isIP:function(strIP) { 
		if (WeiZhuan.isNull(strIP)) return false; 
		var re=/^(\d+)\.(\d+)\.(\d+)\.(\d+)$/g //匹配IP地址的正则表达式 
		if(re.test(strIP)){ 
			if( RegExp.$1 <256 && RegExp.$2<256 && RegExp.$3<256 && RegExp.$4<256) return true; 
		} 
		return false; 
	},
	
	//检查输入字符串是否为空或者全部都是空格
	isNull:function ( str ){ 
		if ( str == "" ) return true; 
		var regu = "^[ ]+$"; 
		var re = new RegExp(regu); 
		return re.test(str); 
	},
	
	//检查输入对象的值是否符合整数格式
	isInteger:function( str ){  
		var regu = /^[-]{0,1}[0-9]{1,}$/; 
		if (regu.test(str)) { 
			return true; 
		}else{ 
			alert( '您输入的不是纯数字!' );
			return false; 
		}
	},
	
	//检查输入对象的值是否符合E-Mail格式
	isEmail:function ( str ){  
		var myReg =  /^[A-Za-z0-9_\-]+@[A-Za-z0-9_\-]+\.[A-Za-z0-9_\-]+$/; 
		if(myReg.test(str)) return true;
		$("#MessEmail").css("color","red");
		$("#MessEmail").html("您输入的Email地址格式不正确！"); 
		return false; 
	},
	initEmail:function(){
		$("#Email").blur(function(){
			var email = $(this).val();
			
			if(email){
				var reg_email =  /^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$/;
				if(!reg_email.test(email) || email ==''){
					$("#MessEmail").css("color","red");
					$("#MessEmail").html("您输入的Email地址格式不正确！");
				}else{		
					$.ajax({
						type:"get",
						url:AjaxUrl.checkemail,
						data:"email="+email,
						success:function(data){
							if(data == 1){
								$("#MessEmail").css("color","green");
								$("#MessEmail").html("邮箱可以使用");
							}else{
								$("#MessEmail").css("color","red");
								$("#MessEmail").html("邮箱已使用");
							}
						}
					})
				}
			}else{
				$("#MessEmail").css("color","red");
				$("#MessEmail").html("您输入的Email地址格式不正确！!");
			}
		});
	},
	
	//检查输入字符串是否符合金额格式
	isMoney:function ( s ){   
		var regu = "^[0-9]+[\.][0-9]{0,3}$"; 
		var re = new RegExp(regu); 
		if (re.test(s)) { 
			return true; 
		} else { 
			return false; 
		} 
	},
	
	//检查输入字符串是否只由7至16位英文字母或数字组成
	isNumberOrLetter:function ( s ){
		var regu = "^[0-9a-zA-Z]+$"; 
		var re = new RegExp(regu); 
		if (re.test(s) && s.length >= 6 && s.length <= 16) { 
			return true; 
		}else{ 
			$("#MessPassword").css("color","red");
			$("#MessPassword").html("由6-16位的字母/数字组成！"); 
			$("#MessPassword2").css("color","red");
			$("#MessPassword2").html("由6-16位的字母/数字组成！"); 
			return false; 
		} 
	},
	initPassWord:function(){
		$("#password").blur(function(){
			var password = $(this).val();
			var reg = /^[0-9a-zA-Z]+$/;
			if(password == ''|| password.length < 6 || password.length>16||!reg.test(password)){
				$("#MessPassword").css("color","red");
				$("#MessPassword").html("由6-16位的字母/数字组成！"); 
				return false; 
			}else{
				$("#MessPassword").css("color","green");
				$("#MessPassword").html("格式正确"); 
				return true; 
			}

		});
	},
	
	//检查输入字符串是否只由汉字、字母、数字组成
	isChinaOrNumbOrLett:function ( s ){//判断是否是汉字、字母、数字组成 
		var regu = "^[0-9a-zA-Z\u4e00-\u9fa5]+$";   
		var re = new RegExp(regu); 
		if (re.test(s)) { 
			return true; 
		}else{ 
			return false; 
		} 
	},
	
	//判断是否是日期 
	isDate:function ( date, fmt ) { 
		if (fmt==null) fmt="yyyyMMdd"; 
		var yIndex = fmt.indexOf("yyyy"); 
		if(yIndex==-1) return false; 
		var year = date.substring(yIndex,yIndex+4); 
		var mIndex = fmt.indexOf("MM"); 
		if(mIndex==-1) return false; 
		var month = date.substring(mIndex,mIndex+2); 
		var dIndex = fmt.indexOf("dd"); 
		if(dIndex==-1) return false; 
		var day = date.substring(dIndex,dIndex+2); 
		if(!isNumber(year)||year>"2100" || year< "1900") return false; 
		if(!isNumber(month)||month>"12" || month< "01") return false; 
		if(day>WeiZhuan.getMaxDay(year,month) || day< "01") return false; 
		return true; 
	},
	
	//获取当前月最大天数
	getMaxDay:function (year,month) { 
		if(month==4||month==6||month==9||month==11) return "30"; 
		if(month==2) {
			if(year%4==0&&year%100!=0 || year%400==0){
				return "29"; 
			}else{
				return "28"; 
			} 
		}
		return "31"; 
	},
	
	//检查输入的起止日期是否正确，规则为两个日期的格式正确， 且结束如期>=起始日期
	isTwoDate:function ( startDate,endDate ) { 
		if( !WeiZhuan.isDate(startDate) ) { 
			alert("起始日期不正确!"); 
			return false; 
		} else if( !WeiZhuan.isDate(endDate) ) { 
			alert("终止日期不正确!"); 
			return false; 
		} else if( startDate > endDate ) { 
			alert("起始日期不能大于终止日期!"); 
			return false; 
		} 
		return true; 
	},
	
	/**
	  * 全选、反选、全不选
	  * 全选或者反选或者全不选按钮添加属性 data-check
	  * 如果只有一个按钮，可以使用uncheck值
	  * 如果有3个按钮，则全选使用checkall值，反选使用checkoff值，全不选使用uncheck值
	  * 可以根据需求来组装。
	  * 数据的复选框统一加上 data-check-data属性
	  */
	 initCheck:function(){
		 $("*[data-check]").live('click',function(){
			 mode = $(this).attr('data-check');
			 $target = $("*[data-check-data]");
			 switch(mode){
	            case 'checkall':
	            	$target.attr('checked',true);
	                break;
	            case 'checkoff':
	            	$target.attr('checked',false);
	                break;
	            case 'uncheck':
	            	$target.each(function(){
	            	     this.checked=!this.checked;
	            	 });
	                break;
	        }
		 })
	 },
	
	//批量删除
	initAllDel:function(){
		$("#alldel").click(function(){
			if(!confirm("确认操作吗，操作之后就不能恢复了。")){
				return;
			}else{
				var chk_value =[];    
				$('input[name="ordercheck"]:checked').each(function(){    
				   chk_value.push($(this).val());    
				}); 
				$.ajax({
				  type: 'POST',
				  url: AjaxUrl.OrderDel,
				  data:{orderid:chk_value},
				  dataType:'json',
				  success:function(data){
						if(data.ret==1){
							for(i =0; i<chk_value.length; i++){
								$("#hidd"+chk_value[i]).css("display","none");
							}
						}else if(data.ret==3){
							for(i =0; i<chk_value.length; i++){
								$("#hidd"+chk_value[i]).html("终止");
							}
						}
						alert(data.message);
						
					}
				}); 
			}
		})
	},
	
	//单条数据删除
	initOneDel:function(){
		$("span #onedel").click(function(){
			if(!confirm("确认操作吗，操作之后就不能恢复了。")){
				return;
			}else{
				var delid = $(this).attr("delid");

				$.ajax({
				  type: 'POST',
				  url: AjaxUrl.OrderDel,
				  data:{orderid:delid},
				  dataType:'json',
				  success:function(data){
						if(data.ret == 1){
							$("#hidd"+delid).css("display","none");
						}else if(data.ret==3){
							$("#hidd"+delid).html("终止");
						}else{
							alert(data.message);
						}
					}
				}); 
			}
		})
	},
	
};