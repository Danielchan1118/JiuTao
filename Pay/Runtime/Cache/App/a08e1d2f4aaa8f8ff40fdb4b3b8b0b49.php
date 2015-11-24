<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1, initial-scale=no" />
<meta name="apple-mobile-web-app-capable" content="yes"/>
<script src="/Public/jquery/jquery-1.8.3.min.js"></script>
<title>旧淘</title>
</head>
<style type="text/css">
	body{padding: 0px;margin: 0px;}
	.jiu_con{margin-left:5px;}
	.jiu_tit{width:100%;height:55px;;margin-bottom:10px; background:url(/Public/App/image/title.gif);background-size: 100% 55px;}
	.jiu_tit1{width:100%;height:86px;margin-bottom:10px; background-color:#FFac1b;background-size: 100% 55px;}
	.img_1,.img_3,.img_2{float:left;height:86px;}
	.jiu_tit1 .img_1{width:6%;margin-left: -14px;}
	.jiu_tit1 .img_3{width:88%;line-heigh:86px;text-align: center;}
	.jiu_tit1 .img_2{width:6%;}
	.jiu_tit_t{width:100%;height: 70px; background-size: 100% 55px;position: fixed;z-index: 999;bottom: 0;}
	.jiu_tit_i{background:url(/Public/App/image/xiazai.gif) no-repeat;}
	.jiu_con_t,.jiu_con_c,.jiu_con_p,.jiu_con_img,.jiu_con_star{width:100%;heihgt:40px;margin-bottom:10px;}
	.jiu_con_p span{margin-right:20px;}
	.jiu_con_star span{margin-right:20px;color:#939393;font-size: 12px;}
	.jiu_user_t{margin-left:30px;line-heigh:100px;float: right;margin-right: 10px;}
	.jiu_user_n{float: right;line-height: 70px;margin-left: 20px;}
	.title_info_l{line-height: 20px;}
	.period{border-radius: 10px;background:#feac1c;padding: 4px 1px;color: #000000;font-size: 13px;font-weight: bold;}
	.jiu_image_l,.jiu_image_r{float:left;}
	.jiu_image_l{width:4%;}
	.jiu_image_r{width:84%;position: absolute;left: 12%;top:10%;}
</style>
<body>
<?php if($mobile == 1): ?><div class="jiu_tit"></div>
<?php else: ?>
<div class="jiu_tit1">
	<div class="img_1"><img src="/Public/Admin/statics/images/left_l.png"/></div>
	<div class="img_3"><div style="line-height: 86px;font-size: 33px;">查看宝贝详情，在浏览器中打开</div></div>
	<div class="img_2"><img src="/Public/Admin/statics/images/left_r.gif"/></div>
	<div style="clear:both;"></div>
</div><?php endif; ?>
<div class="jiu_con">
	<div class="jiu_con_t" style="height: 70px;position: relative;">
		<div class="title_info_l">
		<?php if($status == 1): ?><div class="jiu_image_l"><img style="width: 60px;height:60px;border-radius: 34px;vertical-align: middle;" src="<?php echo ($article["img_url"]); ?>" /></div>
			<div class="jiu_image_r">
			<div style="margin-left:30px;">
				<div><span class="" style=""><?php echo ($article["nickname"]); ?></span></div>
				<div><span class="" style="color:#939393;font-size:13px;margin-left:3px;"><?php echo ($article["location"]); ?></span><span class="" style="float: right;margin-right:px;color:#939393;font-size:13px;"><?php echo ($article["add_time"]); ?></span></div>
			</div>
			</div><?php endif; ?>
		<?php if($status == 2): ?><img style="width: 60px;height:60px;border-radius: 34px;vertical-align: middle;" src="<?php echo ($article["ven_img_url"]); ?>" />
			<span class=""><?php echo ($article["name"]); ?></span>
			<span class="" style="float: right;margin-right:20px;color:#939393;"><?php echo ($article["add_time"]); ?></span><?php endif; ?>
		</div>		
	</div>
	<div style="clear:both;"></div>
<div class="jiu_con_c">
	<span style="color:#666666;font-size:14px;"><?php echo ($article["content"]); ?></span>
</div>
<?php if($status == 1): ?><div class="jiu_con_p">
	<span class="period">
					<?php switch($article["pay_type"]): case "1": ?><font>想卖</font><?php break;?>
								<?php case "2": ?><font>交换</font><?php break;?>
								<?php case "3": ?><font>免费赠送</font><?php break; endswitch;?>
	</span>

	<span style="color:red;font-size: 13px;font-size: 17px;">￥<?php echo ($article["pay_price"]); ?></span><span style="color:#939393;font-size: 13px;"><s>￥<?php echo ($article["real_price"]); ?></s></span>
</div><?php endif; ?>

<div class="jiu_con_img">
<?php if($status == 1): for($i=0;$i<count($arr['image']);$i++){?>
	<img style="margin-right:10px;" src="<?php echo $arr['image'][$i]?>" />
<?php  } endif; ?>
	
<?php if($status == 2): ?><img style="margin-right:10px;" src="<?php echo ($article["ven_img_url"]); ?>" /><?php endif; ?>
</div>
<script type="text/javascript">
$('.jiu_con_img img').each(function(i,e){
		var w = parseInt($(this).css('width'));
		var h = parseInt($(this).css('height'));
		var rate = h/w;
		var new_w = Math.floor(screen.availWidth * 0.12);
		$(this).css({"width":new_w+'px'});
		//var new_h = Math.floor(new_w * h/w);
		$(this).css({"height":new_w+'px'});
});

</script>	
<div class="jiu_con_star"><span ><?php echo ($article["point_like"]); ?>&nbsp;收藏</span><span><?php echo ($article["comment_total"]); ?>&nbsp;评论</span><span><?php echo ($article["browse"]); ?>&nbsp;浏览</span></div>
</div>  
<?php if($is_weixin != 1): ?><div class="jiu_tit_t jiu_tit_tt"><a id="openApp"  href="http://jiutao.91zhaoyou.com/Index/upLoadApk"><img style="width:100%;height: 55px;" src="/Public/App/image/xiazai.gif" /></a></div><?php endif; ?>
<!--<else condition="$mobile eq 1"/>
<div class="jiu_tit_t" style="background-color:#E6EAEF;text-align:center;line-heigh:55px;"><div style="line-height: 70px;font-size: 38px;color: #959799;"><a id="openApp"  href="http://s.91zhaoyou.com/Public/Uploads/Apk/jiutao.apk"></a>下载旧淘客户端</div></div>




<!--http://s.91zhaoyou.com/Public/Uploads/Apk/jiutao.apk   <a href=“index.jsp” id=“openApp” style=“display: none”>APK客户端下载链接</a>   wyrshare://demo.wyrshare?status=<?php echo ($status); ?>&shop_id=<?php echo ($shop_id); ?>-->

</body>
</html>




<script type="text/javascript">

$(function(){
	/*if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {
       document.getElementById('openApp').onclick = function(e) {
           // 通过iframe的方式试图打开APP，如果能正常打开，会直接切换到APP，并自动阻止a标签的默认行为
           // 否则打开a标签的href链接
           var ifrSrc = 'wyrshare://platformapi/startApp?name=tom&=11';
		    e.initEvent('click', true, true);
           document.getElementById("openApp").dispatchEvent(e);
       }
    }*/
	var datas = {
		status:"<?php echo ($status); ?>",
		shop_id:"<?php echo ($shop_id); ?>",
		wei_qq:"<?php echo ($wei_qq); ?>",
		mobile:"<?php echo ($mobile); ?>"
      };
	  if(datas.mobile == 2){
		//$(".jiu_tit_tt").css("display","none");
	  }
	  if (navigator.userAgent.match(/android/i) || navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {
	  if(datas.wei_qq ==1){
	     document.getElementById('openApp').onclick = function(e) {
	   
			//alert(navigator.userAgent.match(/android/i));
           // 通过iframe的方式试图打开APP，如果能正常打开，会直接切换到APP，并自动阻止a标签的默认行为
           // 否则打开a标签的href链接
		  // window.location.href ="wyrshare:?statue=1&=11";
		
			   var ifrSrc = "wyrshare://demo.wyrshare?status="+datas.status+"&shop_id="+datas.shop_id;
			   if(!ifrSrc){
					return;
			   }
			   var ifr = document.createElement('iframe');
				ifr.src = ifrSrc;
				ifr.style.display = 'none';
			    document.body.appendChild(ifr);
			    setTimeout(function() {
				  document.body.removeChild(ifr);
			   }, 1000);
		   };
		   if (document.all) {
				document.getElementById('openApp').click();
			}else {
			   var e = document.createEvent("MouseEvents");
			   e.initEvent("click",true,true);
			   document.getElementById("openApp").dispathchEvent(e);
			}
		   
		
	  }else{
			
	//alert(navigator.userAgent.match(/android/i));
	
       var ifrSrc = "wyrshare://demo.wyrshare?status="+datas.status+"&shop_id="+datas.shop_id;
			   if(!ifrSrc){
					return;
			   }
			   var ifr = document.createElement('iframe');
				ifr.src = ifrSrc;
				ifr.style.display = 'none';
			    document.body.appendChild(ifr);
			    setTimeout(function() {
				  document.body.removeChild(ifr);
			   }, 1000);
		   
		
	  }
	  
	}
	  
    
    
	
	
        /*   if (!ifrSrc) {
              return;
           }
           var ifr = document.createElement('iframe');
           ifr.src = ifrSrc;
           ifr.style.display = 'none';
           document.body.appendChild(ifr);
           setTimeout(function() {
              document.body.removeChild(ifr);
           }, 1000);
       
       if (document.all) {
           document.getElementById('openApp').click();
       }
       // 其它浏览器
       else {
           var e = document.createEvent("MouseEvents");
		   e.initEvent("click",true,true);
		   document.getElementById().dispathchEvent(e);
		}*/

});
	



</script>