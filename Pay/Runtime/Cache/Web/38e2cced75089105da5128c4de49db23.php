<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    <meta name="robots" content="index,follow"> 
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;">
    <link  href="/Public/web/style/css/activity-style.css" rel="stylesheet" type="text/css" />
	<title>最强眼力</title>	
	<link href="/Public/Plugin/GuessGlod/9.css" media="screen" rel="stylesheet" type="text/css">
	<script src="/Public/jquery/jquery-1.8.3.min.js"></script>
	<script src="/Public/web/style/js/jQuery.editBox.js" type="text/javascript"></script>
	<script>
	/*if(!confirm("进入游戏需要10000淘币,过关奖励20000淘币！是否进入？"))
		   {
				window.Android.ExitGame();
				return;
		   };*/
	
    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
    	WeixinJSBridge.call('showOptionMenu');
    });
	//new Image().src = 'action.php-id=12'/*tpa=http://wx.9ku.com/game/action.php?id=12*/;
	var moreGamesLocation = '';
	function play68_init() {	
	window.user_name = '<?php echo ($user_name); ?>';
	  window.count = '<?php echo ($count_data); ?>';
	  window.find_data = '<?php echo ($find_data); ?>';
	  window.user_name = '<?php echo ($user_name); ?>';
	  window.url = '<?php echo ($url); ?>';
	  window.counts = '<?php echo ($counts); ?>';
	  window.integral = '<?php echo ($earn_coins); ?>';
	updateShare(0);}
	function updateShare(bestScore) {
		imgUrl = 'http://t2.qpic.cn/mblogpic/6c1d5db929f123ac16c0/2000';
		//var domains = ['http://wx.9ku.com/ceshi/50/www.lieqicun.com','http://wx.9ku.com/ceshi/50/www.lieqicun.cn','http://wx.9ku.com/ceshi/50/www.lieqicun.net','http://wx.9ku.com/ceshi/50/115.29.44.52'];
		//var domain = domains[new Date().getTime()%4];
		lineLink = 'index.htm'/*tpa=http://wx.9ku.com/ceshi/50/*/;
		descContent = "考考你的眼力！你的眼睛跟得上吗？";
		updateShareScore(bestScore);
		appid = '';
	}	
	function updateShareScore(bestScore) {
		if(bestScore > 0) {shareTitle = "我玩《最强眼力》过了" + bestScore + "关，眼都花了！";}
		else{shareTitle = "不玩《最强眼力》怎么知道自己的眼力原来那么好？";}
	}
</script>
</head>
  <body class="os-windows osv-6_1 osmv-6" onorientationchange="orentationChanged()">    
  <div id="adTop"><script src="/Public/Plugin/GuessGlod/adTop.js" ></script></div>
    <DIV class="main">
	<div id="inner" style="display:none;"></div>
		<div style="width: 100%;height: 100%;display: none;color: red;font-size: 20px;top: 300px;padding-top: 200px;" id="meseage">您的淘币不够，请继续赚取淘币</div>	
		<div style="width: 100%;height: 100%;display: none;color: red;font-size: 20px;top: 300px;padding-top: 200px;" id="meseage1"></div>	
      <div id="frame">
        <div id="logo" style="display: none; opacity: 0;"></div>
        <div id="playButton" style="display: none; opacity: 1;">
          <div style="padding-top: 64px;width: 200px;"><span style="color:#CCC;font-size:20px;margin-top: 118px;"></span><br/></div>
          <div style="clear: both;position: absolute;bottom: 20%;width: 88%;left: 21px;"><span style="color:red;font-size:15px;margin-top: 118px;float: left;text-align: left;">1.支付1W淘币即可获得一次玩《最强眼力》的机会，每天有3次机会<br/>
2.猜中金币位置即可获得2W淘币的奖励；<br/></span></div>
        </div>
        	
        <div id="level" style="display: none;">
            <span id="levelLabel">关卡：</span>
			<span id="levelNum">1</span>
        </div>
        <div id="lives" style="display: none;">
			<div id="hearts"><div class="heart">&nbsp;</div><div class="heart">&nbsp;</div><div class="heart">&nbsp;</div></div>
        </div>
        <div id="b" style="display: block;">
          <div style="display: block;" id="b1"></div>
          <div style="display: block;" id="b2"></div>
          <div style="display: block;" id="b3"></div>
        </div>
        <canvas height="240" width="320" id="canvas" style="display: block;"></canvas><div id="msg" style="position:relative;display: block; opacity: 1;bottom:50px;"></div>
      </div>
	 <!--<div  style="position:relative; display: block; margin: 0px auto;bottom:120px;z-index:20000">
	 	<a style="font-size: 15px;color: #f00;font-weight: bold;display: block;height: 30px;line-height: 30px;" href="javascript:if(confirm('http://wx.9ku.com/ceshi/51/  \n\nكτݾϞרԃ Teleport Ultra Ђ՘, ӲΪ ̼ˇһٶԲܲ·޶΢ҿѻʨ׃Ϊ̼քǴʼַ֘քַ֘c  \n\nţЫ՚ؾϱǷʏղߪ̼?'))window.location='http://wx.9ku.com/ceshi/51/'" tppabs="http://wx.9ku.com/ceshi/51/">变态考反应游戏《密室逃脱》能通关你就能闪子弹了！</a>
	 </div>-->
   <script type="javascript/text">
   /*
      var datas = {
        okurl : "<?php echo U('/Activity/GuessGold');?>",
        num: "0",
		nums:"<?php echo ($count_data); ?>",
        num1: "<?php echo ($username); ?>"
      };*/
	  
   </script>
   
      <script type="text/javascript" src="/Public/Plugin/GuessGlod/9.js" ></script>
      
    </DIV>
    <script src="/Public/Plugin/GuessGlod/count.js" type="text/javascript" ></script>
</body>
</html>