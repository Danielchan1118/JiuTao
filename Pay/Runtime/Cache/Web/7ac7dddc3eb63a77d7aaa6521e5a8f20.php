<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<meta name="description" content="幸运大转盘抽奖">
	<title>幸运大转盘抽奖</title>
	<link  href="/Public/web/style/css/activity-style.css" rel="stylesheet" type="text/css" />
</head>

<body class="activity-lottery-winning">
	<div class="main">
		<div id="outercont">
			<div id="outer-cont">
				<div id="outer"><img src="/Public/web/style/images/activity-lottery-1.png" width="310px"></div>
			</div>
			<div id="inner-cont">
				<div id="inner"><img src="/Public/web/style/images/activity-lottery-2.png"></div>
			</div>
		</div>

		<div class="content">
			<div class="boxcontent boxyellow">
				<div class="box">
					<div class="title-orange"><span>规则说明：</span></div>
					<div class="Detail">    
						<?php echo ($roleContent); ?>
					</div>
				</div>
			</div>
		</div>

	</div>
<script src="/Public/web/style/js/jquery.js" type="text/javascript"></script>
<script src="/Public/web/style/js/jQuery.publicBox.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	window.requestAnimFrame=(function(){ return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(callback){window.setTimeout(callback,1000/60)}})();
	var totalDeg=360*3+0;
	var steps=[];

	var lostDeg=[30,90,150,210,270,330]; 
	var prizeDeg=[360,60,120,180,240,300];
	var prize;
	var count=0;
	var now=0;
	var a=0.01;
	var outter,inner,timer,running=false;
	var str;
	var roll='<?php echo ($rollCount); ?>';
	var name = <?php echo ($username); ?>;//用户名
	if (typeof(eval(roll)) == "number"){
		window.rollCount = roll;
	}
	function countSteps(){
		var t=Math.sqrt(2*totalDeg/a);
		var v=a*t;
		for(var i=0;i<t;i++){steps.push((2*v*i-a*i*i)/2)}
		steps.push(totalDeg)
	}

	function step(){
		outter.style.webkitTransform='rotate('+steps[now++]+'deg)';
		outter.style.MozTransform='rotate('+steps[now++]+'deg)';
		if(now<steps.length){
			requestAnimFrame(step)
		}else{
			setTimeout(function(){
					if(prize!=null){
						$('#inner').pointMsg({
							width:'98%',height:100,
							msg:"恭喜您将获得"+str+" !",  
							color:"green",
							autoClose:true
						});
					}else{
						$('#inner').pointMsg({
							width:'98%',height:100,
							msg:"谢谢您的参与，下次再接再厉",  
							color:"green",
							autoClose:true
						});	
					}					
					running=false;
				},200);
		}
	}
	function start(deg){
		deg=deg||lostDeg[parseInt(lostDeg.length*Math.random())];
		running=true;
		clearInterval(timer);
		totalDeg=360*2+deg; 
		steps=[];
		now=0;
		countSteps();
		requestAnimFrame(step)
	}
	window.start=start;
	outter=document.getElementById('outer');
	inner=document.getElementById('inner');
	i=10;
	function getDataSuccess(data){	//次数已到									
		if(data.error=="invalid"){
			$('#inner').pointMsg({
				width:'98%',height:100,
				msg:data.str,  
				color:"green",
				autoClose:true
			});			
			count=3;
			clearInterval(timer);
			window.setTimeout(function(){ window.Android.ExitGame();},5000);
			return;
			
		}
		if(data.error=="coinNotEnough") {  //淘币不足
			//
			$('#inner').pointMsg({
				width:'98%',height:100,
				msg:data.str,  
				color:"green",
				autoClose:true
			});				
			count=3;
			clearInterval(timer);
			window.setTimeout(function(){ window.Android.ExitGame();},5000);
			return;
		}
		if(data.error=="levelNotEnough"){ //等级不够
			//
			$('#inner').pointMsg({
				width:'98%',height:100,
				msg:data.str,  
				color:"green",
				autoClose:true
			});				
			count=3;
			clearInterval(timer);
			window.setTimeout(function(){ window.Android.ExitGame();},5000);
			return;
		}
		if(data.error=="nameWrong") { //
			$('#inner').pointMsg({ //用户名错误
				width:'98%',height:100,
				msg:data.str,  
				color:"green",
				autoClose:true
			});				
			count=3;
			clearInterval(timer);
			window.setTimeout(function(){ window.Android.ExitGame();},5000);
			return;
		}

		if(data.success){
			prize=data.prizetype;
			str = data.str;
			start(prizeDeg[data.prizetype-1])
		}else{
			prize=null;
			start()
		}
		count++;
		console.log("success");
	}
	window.getDataSuccess = getDataSuccess;
	$("#inner").click(function(){
		if(running)return;
		if (typeof(eval(<?php echo ($rollCount); ?>)) == "number"){
			if(window.rollCount<=0){
				$('#inner').pointMsg({
					width:'98%',height:100,
					msg:"亲，您今天抽奖次数已到,不能再参加本次活动了喔！下次再来吧~",  
					color:"green",
					autoClose:true
				});	
				window.setTimeout(function(){ window.Android.ExitGame();},5000);	
				return;
			}
		}
		
		$.ajax({
			url:"<?php echo U('Web/Method/dataWheel');?>",
			dataType:"json",
			data:{username:name},
			beforeSend:function(){
							running=true;
							timer=setInterval(function(){i+=5;outter.style.webkitTransform='rotate('+i+'deg)';outter.style.MozTransform='rotate('+i+'deg)'},1)},
			success: function(data){
				window.ajaxData = data;	
				setTimeout("getDataSuccess(window.ajaxData);",2000);
			},
			error:function(){
					prize=null;
					start();
					running=false;
					console.log("err");
					count++},
			timeout:4000
		})
	})
});
					
</script>
<?php echo ($nameWrong); ?>
<?php echo ($notEnough); ?>

</body>
</html>