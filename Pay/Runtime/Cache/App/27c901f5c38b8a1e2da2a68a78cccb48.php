<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1, initial-scale=no" />
<meta name="apple-mobile-web-app-capable" content="yes"/>
<script src="/Public/jquery/jquery-1.8.3.min.js"></script>
<title>旧淘</title>
</head>
<style type="text/css">
	body{padding: 0px;margin: 0px;background: #292929;}
</style>
<body>
<div class="title">
<img src="/Public/Admin/statics/images/about_us.jpg">

</div>

</body>
</html>




<script type="text/javascript">
/*
$('.content_son img,iframe').each(function(i,e){
			var w = parseInt($(this).css('width'));
			var h = parseInt($(this).css('height'));
			var rate = h/w;
			var new_w = Math.floor(screen.availWidth * 0.45);
			$(this).css({"width":new_w+'px'});
			var new_h = Math.floor(new_w * h/w);
			$(this).css({"height":new_h+'px'});
		});
		
	$('.content img,iframe').each(function (i,e){
				var w = parseInt($(this).css('width'));
				var h = parseInt($(this).css('height'));
				
				$(this).css('width','100%');
				var w2 = parseInt($(this).css('width'));
				var h2 = Math.floor(w2*h/w);
				if(h2> document.body.clientHeight)
					h2 = parseInt(document.body.clientHeight);
				$(this).css('height',h2 + 'px');
	});		
	*/	

$('.title img').each(function (i,e){
				var w = parseInt($(this).css('width'));
				var h = parseInt($(this).css('height'));
				
				$(this).css('width','100%');
				var w2 = parseInt($(this).css('width'));
				var h2 = Math.floor(w2*h/w);
				if(h2> document.body.clientHeight)
					h2 = parseInt(document.body.clientHeight);
				$(this).css('height',h2 + 'px');
	});	

</script>