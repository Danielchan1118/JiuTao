<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="keywords" content="旧淘,二手,市场,自行车,电动车,教材,手机,电脑,租房,球拍,运动器材,衣物,数码配件,耳机,足球,洗衣机,鼠标,键盘,相机"/>
		<meta name="description" content="旧淘是最安全方便的二手市场。提供自行车,电动车,教材,手机,电脑,租房,洗衣机,球,衣物,数码配件等二手商品信息。充分满足小伙伴们查看/发布二手商品的需求。"/>
		<meta property="qc:admins" content="17066776776072606375" />
		<meta property="wb:webmaster" content="6350b89049aef05c" />
		<title>旧淘 - 低碳环保的生活方式 - 最安全方便二手市场</title>
		<!--<link rel="icon" href="/Public/Home/style/image/jiutao.ico"/> 	 
		<link rel="stylesheet" href="/Public/Home/style/css/init.css"/>
		<link rel="stylesheet" href="/Public/Home/style/css/main.css"/>
		<link rel="stylesheet" href="/Public/Home/style/css/index.css"/>
		<link rel="stylesheet" href="/Public/Home/style/css/detail.css"/>
		<link rel="stylesheet" href="/Public/Home/style/css/release.css"/>
		<link rel="stylesheet" href="/Public/Home/style/css/uploadify.css"/>
		<script type="text/javascript" src="/Public/Home/style/js/jquery-1.7.2.min.js"></script>	
			

		<link rel="stylesheet" href="/Public/Home/style/css/rrshare.css"/>  -->
    
	<link rel="stylesheet" href="/Public/Home/style/css/init.css"/>
	<link rel="stylesheet" href="/Public/Home/style/css/periphery.css"/>
	<link rel="stylesheet" href="/Public/Home/style/css/main.css"/>
	<link rel="stylesheet" href="/Public/Home/style/css/release.css"/>
	<link rel="stylesheet" href="/Public/Home/style/css/uploadify.css"/>		
	<script src="/Public/Home/style/js/jquery.min.js" type="text/javascript"></script>
	<script src="/Public/Home/style/js/jquery.uploadify.min.js" type="text/javascript"></script>
		<script type="text/javascript">			
			$(function(){
				$("#address").blur(function(){
					var ares = $(this).val();
					if(ares == ''){
						alert('商家地址不能为空');
						return false;
					}
					$('#er_ads').html('');
					// 百度地图API功能
					// 创建地址解析器实例
					var myGeo = new BMap.Geocoder();
					// 将地址解析结果显示在地图上,并调整地图视野
					myGeo.getPoint(ares, function(point){
						if (point) {
							$('#lon').val(point.lng);
							$('#lat').val(point.lat);
						}else{
							$('#er_ads').html('请用输入规范地址,如：广东省深圳市xx区xx路');
						}
					});	
				});
			})		
		</script>
		
	</head>
	<style>	
.image_css{float:left;}
	</style>
<body>
	<!--左侧分类展示start  固定-->
		<nav class="ease2">
		<ul>
			<li class="blank-head"><a href="javascript:void(0);"></a></li>
			<li class="area">
				<a href="javascript:void(0);">
					<i class="nav-icons"></i>
					<div id="college"><span><?php echo ($cityname); ?></span></div>
				</a>
			</li>		
			<?php if(is_array($catList)): $i = 0; $__LIST__ = $catList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="catg">
				<a href="<?php echo U('/Goods/goodsList?type=par&id='.$vo['id']);?>" title="<?php echo ($vo["name"]); ?>">
					<i class="nav-icons"><img src="<?php echo ($vo["little_img_url"]); ?>"/></i>
					<h3><?php echo ($vo["name"]); ?></h3>
				</a>
				<?php if(($vo["sub"]) != ""): ?><div class="sub-nav">
					<span>
						<?php if(is_array($vo["sub"])): $i = 0; $__LIST__ = $vo["sub"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vs): $mod = ($i % 2 );++$i;?><a href="<?php echo U('/Goods/goodsList?id='.$vs['id']);?>"><?php echo ($vs["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
					</span>
				</div><?php endif; ?>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</nav>
	<!--左侧分类展示end 固定-->
	<!--内容展示页start 动态-->
    <div class="container">
    <div class="main center">
        <div class="rule-wrapper center">
            <div class="rule-hd center">
                <div class="l-triangle"></div>
                <h2>商品发布规则</h2>
                <div class="r-triangle"></div>
            </div>
            <table class="rules center">
                <thead>
                <tr>
                    <td class="r-order"></td>
                    <th>发布规则</th>
                    <th>惩罚措施</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="r-order"><span>1</span></td>
                    <td class="r-rule">您发布的商品30天后将自动过期</td>
                    <td class="r-punishment"></td>
                </tr>
                <tr>
                    <td class="r-order"><span>2</span></td>
                    <td class="r-rule">同一类型的商品不得多次发布，建议发在一个商品当中。每张图片可以对应一件商品，在商品详情中描述每个商品的价格。</td>
                    <td class="r-punishment">一经发现将删除重复商品，只保留一个</td>
                </tr>
                <tr>
                    <td class="r-order"><span>3</span></td>
                    <td class="r-rule">不得在本平台上发布商品图片与实物不一致的商品，若引用网上图片第一张必须为实物拍摄</td>
                    <td class="r-punishment">一经发现将删除发布商品</td>
                </tr>
                <tr>
                    <td class="r-order"><span>4</span></td>
                    <td class="r-rule">不得在本平台上发布带有虚假诈骗信息的商品</td>
                    <td class="r-punishment">一经查证将删除发布内容，并且永久封号</td>
                </tr>
                <tr>
                    <td class="r-order"><span>5</span></td>
                    <td class="r-rule">不得在本平台上密集发布新商品</td>
                    <td class="r-punishment">一经发现将视作广告，删除全部商品并封号</td>
                </tr>
                <tr>
                    <td class="r-order"><span>6</span></td>
                    <td class="r-rule">不得在本平台上发布违法商品</td>
                    <td class="r-punishment">一经查证将删除发布内容，并且永久封号</td>
                </tr>
                <tr>
                    <td class="r-order"><span>7</span></td>
                    <td class="r-rule">不得在本平台上发布与商品无关信息</td>
                    <td class="r-punishment">一经发现将删除发布内容，并且永久封号</td>
                </tr>
                </tbody>
            </table>
            <div class="end-line"></div>
        </div>
    </div>
</div>

	<!--内容展示页end  动态-->
		<!--右侧统计资料客户端start 固定-->
	<aside>
		<?php if($userinfo["name"] == null): ?><a class="release-button" href="javascript:void(0);" onclick="alert('登录后才可以发布商品哦');">我要发布</a>
		<?php else: ?>
			<a class="release-button" href="<?php echo U('Release/release');?>" >我要发布</a><?php endif; ?>
		<div class="helped">
			<span class="helpers"><?php echo ($helpbody); ?></span>
		</div>
		<div class="qrcode-wr">
			<img src="/Public/Home/style/image/new_web_qrcode.png" alt="下载APP二维码"/>
		</div>
		<h2 class="qqgroup">用户交流群: 241357698</h2>
		<div class="fl-wrapper clearfix">
			<div class="wx-follow">
				<a href="javascript:void(0);" class="fl-icon">
					<img src="/Public/Home/style/image/weixin-fl.png"/>
				</a>
				<div class="wx-fl-qrcode">
					<p>关注我</p><img src="/Public/Home/style/image/wx-fl-qrcode.png" /><p>旧淘</p>
					<div class="dc-dot"></div>
				</div>
			</div>
			<div class="sina-follow">
				<a href="http://weibo.com/u/5093741186?topnav=1&wvr=6&topsug=1" class="fl-icon" target="_blank" title="旧淘官方微博">
					<img src="/Public/Home/style/image/sina-fl.png"/>
				</a>
			</div>
		</div>
	</aside>
	<!--右侧统计资料客户端end 固定-->
	<!--顶部搜索框 start 固定-->
	<header class="ease2">
		<a href="<?php echo ($www); ?>"><img class="logo ease2" src="/Public/Home/style/image/logo.png" alt="旧淘"/></a>
		<div class="header-main center ease2">
			<a href="<?php echo ($www); ?>" class="slogan">
				<h1 class="s-main">旧淘</h1>
				<div class="s-submain">最安全方便的二手市场</div>
				<img src="/Public/Home/style/image/slogan.png" alt="旧淘最安全方便的二手市场"/>
			</a>
			<div class="search-box-wr ease2">
				<form class="search-box center" action="<?php echo U('/Goods/search');?>" method="get">
					<button type="submit" class="search-submit">搜索</button>
					<div class="input-wr">
						<img class="search-icon" src="/Public/Home/style/image/search-icon.png" alt="search"/>
						<div class="search-input">
							<input name="keyword" id="keyword" x-webkit-speech type="text" placeholder="搜索你想要的旧货"/>
						</div>
					</div>
				</form>
				<div class="search-hots center ease2">
					<span>热门：</span>
					<?php if(is_array($hotCatList)): $i = 0; $__LIST__ = $hotCatList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a class="hots" href="<?php echo U('/Goods/goodsList?id='.$vo['id']);?>" title="<?php echo ($vo["name"]); ?>"><?php echo ($vo["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
					<a class="hots" href="<?php echo U('/Goods/goodsList?goodstype=3');?>" title="赠送">赠送</a>
				</div>
			</div>
				
				<?php if(($userinfo) != ""): ?><div class="log-reg ease2">
						<div id="have_login" class="clearfix">
							<div id="person_info" class="clearfix">
								<a href="/UserCenter"><img class="avatar" src="<?php echo ($userinfo["head_img_url"]); ?>" alt="头像"></a>
								<div class="person_name"><?php echo ($userinfo["name"]); ?></div>
							</div>
							
							<img class="login_border" src="/Public/Home/style//image/login_border.png"  style="display: none;">
							<div class="login_slider" style="display: none;">
							<h3>嗨，<span><?php echo ($userinfo["name"]); ?></span></h3>
							<ul>
								<li><a href="/UserCenter">个人中心</a></li>
								<li><a href="/UserCenter/collect">我的收藏</a></li>
								<li><a href="/Login/loginQuit">退出登录</a></li>
							</ul>
							</div>
							
						</div>
					</div>
				<?php else: ?>
					<div class="log-reg ease2">
						<div class="button" data-type="l">登录</div>
					</div><?php endif; ?>	
		</div>
	</header>
	<!--顶部搜索框 end 固定-->	
	<!--底部start 固定-->
	<footer>
		<img class="footer-tri" src="/Public/Home/style/image/footer-tri.png" alt=""/>
		<div class="friend-links">
			<div class="links-title center">友情链接</div>
			<ul class="links-wr center">
				<?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><li ><a href="<?php echo ($vol["links"]); ?>" target="_blank" class="links"><?php echo ($vol["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
		<div class="site-msg line1">
			<span class="report">粤ICP备14029663号-2</span>
			<span class="power">&nbsp;Powered by <a href="javascript:void(0);" >W.Y.R</a></span>
		</div>
		<div class="site-msg line2">
			<a class="contact" href="javascript:void(0);" >联系我们</a>
			<a class="contact" href="javascript:void(0);" >加入我们</a>
		</div>
	</footer>
	<!--底部end 固定-->
	<!--登陆窗口start 固定-->	
	<div class="login-cover">
		<div class="login-wr">
			<div style="margin-top: 320px">
				<a href="/Home/Login/weiboLogin"><div class="webo login_css"></div></a>
				<a href="/Home/Login/wechat"><div class="wechat login_css"></div></a>
				<div style="clear:both;"></div>
			</div>
		</div>
	</div>
	<!--登陆窗口end 固定-->
	<script src="/Public/Home/style/js/common.js?v=201412231400"></script>
	<script src="/Public/Home/style/js/add.js?v=201412231400"></script>
	<script type="text/javascript" src="http://tajs.qq.com/stats?sId=25658961" charset="UTF-8"></script>
</body>
</html>	
<script src="/Public/Home/style/js/jquery-1.7.2.min.js"></script>
        <script src="/Public/Home/style/js/uploadify.js"></script>
        <script src="/Public/Home/style/js/release.js"></script>