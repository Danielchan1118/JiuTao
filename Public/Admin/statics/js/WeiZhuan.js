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