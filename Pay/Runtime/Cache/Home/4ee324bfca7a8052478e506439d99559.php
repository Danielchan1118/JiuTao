<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="keywords" content="旧淘,二手,市场,自行车,电动车,教材,手机,电脑,租房,球拍,运动器材,衣物,数码配件,耳机,足球,洗衣机,鼠标,键盘,相机"/>
		<meta name="description" content="旧淘是最安全方便的二手市场。提供自行车,电动车,教材,手机,电脑,租房,洗衣机,球,衣物,数码配件等二手商品信息。充分满足小伙伴们查看/发布二手商品的需求。"/>
		<meta property="qc:admins" content="17066776776072606375" />
		<meta property="wb:webmaster" content="6350b89049aef05c" />
		<title>旧淘 - 低碳环保的生活方式 - 最安全方便二手市场</title>
		<link rel="icon" href="/Public/Home/style/image/jiutao.ico"/> 	  	
		<link rel="stylesheet" href="/Public/Home/style/css/init.css?v=201412231400"/>
		<link rel="stylesheet" href="/Public/Home/style/css/main.css?v=201412231400"/>
		<link rel="stylesheet" href="/Public/Home/style/css/index.css?v=201412231400"/>
		<link rel="stylesheet" href="/Public/Home/style/css/lib/animate.css?v=201412231400"/>
		<script type="text/javascript" src="/Public/Home/style/js/jquery-1.7.2.min.js?v=201412231400"></script>	
	</head>
<body >
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
			<div class="label-wr center clearfix">
				<div id="nav-labels">
					<a id="commend" class="labels " href="<?php echo U('/Index/index');?>">最新发布</a> 
					<a id="new_pro" class="labels cur" href="<?php echo U('/Index/nearList');?>">附近</a>
				</div>
			</div>
			<div class="item-list">
				<ul class="items clearfix">
				<!--循环start-->
				<?php if(is_array($arrPayList)): $i = 0; $__LIST__ = $arrPayList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="item">
						<a href="<?php echo U('Home/Goods/goodsDetail?id='.$vo['id']);?>" class="img" title="<?php echo ($vo["title"]); ?>" target="_blank"><img src="<?php echo ($www); echo ($vo["image_url"]); ?>" alt="<?php echo ($vo["title"]); ?>"/></a>
						<div class="info">
							<?php if(($vo["biddata"]) != ""): ?><div class="price"><?php echo ($vo["biddata"]["current_price"]); ?></div>
							<?php else: ?>
							<div class="price"><?php echo ($vo["real_price"]); ?></div><?php endif; ?>
							<div class="name">
								<a href="<?php echo U('Home/Goods/goodsDetail?id='.$vo['id']);?>" title="<?php echo ($vo["title"]); ?>" target="_blank"><?php echo ($vo["title"]); ?></a>
							</div>
							<div class="department">
								<span><?php echo ((isset($vo["nickname"]) && ($vo["nickname"] !== ""))?($vo["nickname"]):"小淘"); ?></span>
							</div>
							<div class="school"><span><?php echo ((isset($vo["location"]) && ($vo["location"] !== ""))?($vo["location"]):"火星"); ?></span></div>
						</div>
					</li>&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
					<!--循环end-->
					<li class="item fixed"></li>
					<li class="item fixed"></li>
					<li class="item fixed"></li>
				</ul>
			</div>
			<div class="pages">
				<?php echo ($page); ?>
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