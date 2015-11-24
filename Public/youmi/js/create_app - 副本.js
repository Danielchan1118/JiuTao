$(function(){
	$('#txtAppName').blur(function(){
		var appName =  $.trim($(this).val());
		if(appName){
			$.ajax({
				type:"post",
				url:data.create_url,
				data:"appname="+appName+"",
				success:function(data){
					if(data == 1){
						$(".app_name_text").attr("check_appname","1");
						$(".app_name_text").html("此应用名称已使用");
					}else{
						$(".app_name_text").removeAttr("check_appname");
						$(".app_name_text").html("此应用名称可用");
					}
				}
			});
		}else{
			$(".app_name_text").attr("check_appname","1");
			$(".app_name_text").html("应用名不能为空！");
		}
    });

	$("#lbClassName").click(function(){
		$(".dropdown").css("display","block");
	});
	
	$("#btnRegister").click(function(){
		var appName = $("#txtAppName").val();
		var app_type = $(".select-list .selected .radio-box").attr("key");
		var app_explain = $("#app_explain").val();
		var app_cover = $("#app_cover img").attr("src");
		var app_images = $("#app_images img").attr("src");
		var check_appname = $(".app_name_text").attr("check_appname");

		if(appName && app_type && app_explain && app_cover && app_images && typeof(check_appname) == 'undefined'){
			$.ajax({
				type:"post",
				url: data.create_frist,
				data:"app_name="+appName+"&app_type="+app_type+"&app_explain="+app_explain+"&app_cover="+app_cover+"&app_images="+app_images,
				success:function(datas){
					if(datas != 1){
						$("#divStep1").css("display","none");	
						$("#divStep2").css("display","block");	
						$("#divAppKey").html("Android app key: "+datas.app_key+"<input type='hidden' id='appid' value='"+datas.app_id+"'/>" );
						$("#spanSuccAppName").html("应用创建成功 ");
						window.parent.adjustFrame();
					}else{
						alert("请完善资料！");
					}
				}
			});	
		}else{
			alert("请完善资料！");
		}
	});
	//初始化分类选中状态
	var className = $.trim($("#lbClassName").html());
	$(".select-list label a").click(function(){
		$(".select-list label").removeClass("selected");
		$(this).parent().addClass("selected");
		$("#lbClassName").html($(this).html()+'<i class="icon-caret"></i><input type="hidden" name="app_type" value="'+$(this).html()+'">');
		$(".dropdown").css("display","none");
	}).each(function(){
		if($(this).html() == className){
			$(this).parent().addClass("selected");
		}
	});
	
	// ajax上传图片
	$(".operation-logo .opt input").change(function(){
		var id = $(this).attr("id");
		var names = $("#"+id).val().split("."); 

		if(names[1]!="gif"&&names[1]!="GIF"&&names[1]!="jpg"&&names[1]!="JPG"&&names[1]!="png"&&names[1]!="PNG") { 
			alert("上传格式不对"); 
			return; 
		} 

		$("#form"+id).submit(); 
	});
	
	//自动上传APP
	$(document).ready(function() { 
     //提交上传
		$('#form').bind('change', function() {
			$('#form').submit();
		});
	}); 
	
	//第三步提交
	$("#btnSaveAppInfo").click(function(){
		var appName = $("#editAppName").val();
		var app_type = $(".dropdown .select-list .selected .radio-box").attr("key");
		var app_explain = $("#app_explain").val();
		var app_cover = $(".app_cover").val();
		var app_images = $(".app_images").val();
		var app_cover = $("#app_cover img").attr("src");
		var app_images = $("#app_images img").attr("src");
		var app_key = $("#app_key").val();
		//var check_appname = $(".app_name_text").attr("check_appname");
		if(typeof(app_type) == 'undefined'){
			app_type = 1;
		}
		if(appName && app_type && app_explain && app_cover && app_images){
			$.ajax({
				type:"post",
				url:data.create_three,
				data:"app_name="+appName+"&app_type="+app_type+"&app_explain="+app_explain+"&app_cover="+app_cover+"&app_images="+app_images+"&app_key="+app_key,
				success:function(datas){
					if(datas.ret == 1){
						alert("应用完成");
						window.location.href=data.create_applist; 
					}else{
						window.location.href=data.create_applist; 
					}
				}
			});
		}else{
			alert("请完善资料！");
		}
	});
	
	$("#btnModifyAppName").click(function(){
		var appname = $("#spanAppName").html();

		if ($("#spanAppName").find("input").length<=0){
			$("#spanAppName").html("<input type='text' value='"+appname+"' id='appnames' >");
			$("#appnames").blur(function(){
				var appname = $("#appnames").val();
				$("#spanAppName").html(appname);
				$("#editAppName").val(appname);
			});
		}
	});
	
	
	var strKey = data.app_key;
	var did = data.did;
	var tm = new Date();
	window.settings = {
		flash_url : "/Public/Plugin/SWFUpload/swfupload.swf",
		upload_url: data.image_upload+"?rnd="+tm.getTime()+"&sessionid="+$.cookie("PHPSESSID"),
		post_params: {"app_key" : strKey , "did" : did},
		file_size_limit : "1000 MB",
		file_types : "*.*",
		file_types_description : "apk",
		file_upload_limit : 1,
		file_queue_limit : 1,
		custom_settings : {
			progressTarget : "fsUploadProgress",
			cancelButtonId : "btnCancel"
		},
		debug: false,

		// Button settings
		//button_image_url: "images/TestImageNoText_65x29.png",	// Relative to the Flash file
		button_width: "50",
		button_height: "30",
		button_placeholder_id: "spanButtonPlaceHolder",
		button_text: '<span class="theFont">浏览</span>',
		button_text_style: ".theFont { font-size: 12; }",
		button_text_left_padding: 10,
		button_text_top_padding: 5,
		
		// The event handler functions are defined in handlers.js
		file_queued_handler : fileQueued,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler :
			function(file, serverData) {
				try {
					if( serverData == "3" ){
						alert("上传失败！");
					}else if(serverData == "4" || serverData == "2" ){
						alert("上传成功");
					}else if(serverData == "5"){
						alert("上传APK包重复");
					}else{
						alert(serverData);
					} 
					var progress = new FileProgress(file, this.customSettings.progressTarget);
					progress.setComplete();
					progress.setStatus("上传成功");
					progress.toggleCancel(false);
					this.debug(serverData);
					$('#divBtn').html("<div id=\"spanButtonPlaceHolder\"></div>");
					window.swfu = new SWFUpload(window.settings);
				} catch (ex) {
					this.debug(ex);
				}
			},
		upload_complete_handler : uploadComplete,
		queue_complete_handler : queueComplete	// Queue plugin event
	};

	window.swfu = new SWFUpload(window.settings);
	
});