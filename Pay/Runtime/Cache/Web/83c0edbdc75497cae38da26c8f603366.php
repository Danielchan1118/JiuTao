<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html> 
<html lang="en"> 
<head> 
  <title>一笔画 </title> 
    <meta charset="utf-8" />
    <meta name="viewport" content="user-scalable=no, width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0,target-densitydpi=device-dpi"/>     
    <meta name="apple-mobile-web-app-capable" content="yes" /> 
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" /> 
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>    
    <meta name="description" content="一笔画 Pathuku 手机游戏，免下载，即点即玩。安卓手机游戏,苹果手机小游戏" /> 
    <meta name="keywords" content=""/>  
    <script src="/Public/jquery/jquery-1.8.3.min.js"></script> 
	<script type="text/javascript">
		window.username = "<?php echo ($username); ?>";
	</script>
    <script type="text/javascript" src="/Pay/Web/View/GamesApp/yibihua/main.js?4"></script>   
    <link type="text/css" rel="StyleSheet" href="/Pay/Web/View/GamesApp/yibihua/style.css" />

  </head>
  <body  scroll="no" >
    <div id="content" class="clsConatiner">    
    </div>
	<div id="inner"></div>
    <div id="adds" class="clsAdd" style="background-color:#080808;position:absolute;width:100%;z-index:234;display:none;">    
    </div>
  </body>
</html>