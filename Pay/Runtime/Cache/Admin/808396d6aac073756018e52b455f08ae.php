<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>91找游网-总后台</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link href='/Public/youmi/style/css/css.css' rel="stylesheet" type="text/css" />
    <script src="/Public/jquery/jquery-1.8.3.min.js"></script> 
    <script type="text/javascript">
    var data = {
     titles: <?php echo ($tree); ?>,
    };
    </script>
	<script src='/Public/youmi/js/index.js' type="text/javascript"></script>
</head>
<body>
	<!-- logo -->
	<div id="divtop">
		<div class="toplogo"> <a href="/"><img style="height:68px;width:68px;" src="/Public/youmi/image/webLogo.png" style="border:none"/></a></div>
		<div class="topwelcome">
			<span style="color:#3689D7"><?php echo $_SESSION['admin_user']; ?></span>&nbsp;   <span style="color:#A0A0A0">欢迎回来</span><br>
			<ul>
				<li><a href="<?php echo U('Index/Index');?>">首页</a></li>	<li>|</li>
				<li><a href="<?php echo U('Index/UserQuit');?>">注销帐号</a></li>
			</ul>
		</div>
	</div>
	
	<!-- nav -->
	<div id="divnav">
		<div class="header_inner">
			<ul>
				<li class="curnav" data="all"><a href="#">数据分析</a></li>
			</ul>
		</div>
	</div>
	
	<!-- body width:1440 -->
	<div id="divbody">
		<!-- menu width:200 -->
		<div id="divmenu">
			<div id="m2"> </div>
		</div>
		
		<!-- body right -->
		<div class="bodyright">
		<iframe name="menu_lists" frameborder="0" src="/index/index_info"  id="menu_lists" scrolling=no width="100%" > </iframe>
			
		</div>
	</div>
    
    <script type="text/javascript" language="javascript"> 
		function adjustFrame(){
			//setTimeout("$('#menu_lists').height($('#menu_lists').contents().height()); ",2000);
			$('#menu_lists').height($('#menu_lists').contents().height());
			var headbor_height = 0;
			
			headbor = $(window.frames["menu_lists"].document).find(".bodytitle");
			if(headbor.length>0){
				headbor_height += headbor.height();
			}
			
			var subbox_height = 0;
			var subboxes = $(window.frames["menu_lists"].document).find(".subbox");
			if(subboxes.length>0){
				subbox_height += subboxes.height();
			}
			//alert(headbor_height);
			//alert(subbox_height);
			if(headbor_height>0 ||subbox_height>0 ){
				var sum = headbor_height+subbox_height+30;
				if($('#divmenu').height()>sum)
					sum = $('#divmenu').height();
				$('#menu_lists').height(sum);
			}
		}
		$("#menu_lists").load(function() {
			adjustFrame();
			//以防万一
			setTimeout("adjustFrame()",500);
		});


		function hook_link(obj){
			if(typeof($(obj).attr('link'))!='undefined')
				return;
			var url = $(obj).attr('href');
			$(obj).attr('link',url);
			$(obj).attr('href','javascript:void(0);');
			$(obj).click(function(){
				window.open($(this).attr('link'));
				//navigate($(this).attr('link'));
			});
		}
	    $(function(){
	    	var strIsFirst = "<?php echo ($isapp); ?>";
	    	if(strIsFirst.length>0){
	    		//document.getElementById("menu_lists").src = strIsFirst;
	    		//window.location.href = strIsFirst;
	    		window.open(strIsFirst,"menu_lists");
	    		$("#menu_lists").attr("height","900px");
	    	}
	    });

	    
	</script>
	
 	
	<!-- footer -->
	<div id="divfoot">
		Copyright © 2014 Shenzhen W.Y.R Technology Co., Ltd<br />
		深圳微游人科技有限公司&nbsp;版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;粤ICP备14029663号-3 <br/>
		网络文化经营许可证：粤网文[2014]0603-203号&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;增值电信业务经营许可:粤B2-20140348
	</div>
</body>
</html>