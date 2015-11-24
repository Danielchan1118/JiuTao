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




			<div class="private_dialogue_box">
				<!-- 对话列表头部 -->
				<div class="private_dialogue_head S_line1" node-type="header">
					<div class="back">
						<a href="/messages" bpfilter="message" class="S_txt1">
							<em class="W_ficon ficon_back S_ficon">«</em>
						</a>
					</div>
					<p class="title W_f14 S_txt1">
						与<strong class="name W_fb">随缘海豚音</strong>对话中                            
					</p>
				</div>
				<!-- 对话列表头部 -->
				
				<div class="private_dialogue_body S_bg1" node-type="list" style="height: 521px; overflow: hidden;">
					<div node-type="dialog_box" class=" UI_scrollView" style="height: 418px; overflow: hidden; position: relative;">
						<div class="UI_scrollContainer">
							<div class="UI_scrollContent" style="width: 617px;">
								<!-- 滚动内容区 -->
								<div class="private_dialogue_cont" style="top:0;">
									<div class="msg_bubble_list bubble_r " node-type="item" mid="3797428073875361" style="visibility: visible;">
										<div class="bubble_mod clearfix">
											<div class="bubble_user">
												<a href="/2617420207" target="_blank" class="face"><img class="W_face_radius" src="http://tp4.sinaimg.cn/2617420207/50/40060374387/1" width="50" height="50" alt="" usercard="id=2617420207"></a>
											</div>
											<div class="bubble_box SW_fun">
												<div class="bubble_cont">
													<div class="bubble_arrow">
														<div class="W_arrow_bor W_arrow_bor_r"><i></i><em></em></div>
													</div>
													<div class="bubble_main clearfix">
														<div class="cont">
															<!--文本信息-->
															<p class="page">小宋你个大傻逼</p>
															<!--／文本信息-->
														</div>						
													</div>
												</div>
												<div class="space"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="UI_scrollBar W_scroll_y S_bg1" style="visibility: hidden; right: 0px;"><div class="bar S_txt2_bg" style="top: 0%; height: 100%;"></div></div>
					</div>

					<!-- 发布器区 -->
					<div class="private_send_box S_bg2 " style="position:absolute; bottom:0;" node-type="editor">
						<div class="sendbox_mod S_line1 ">
							<div class="sendbox_area">
								<textarea name="" cols="" rows="" class="W_input" style="margin: 0px; padding: 5px 12px 0px; border-style: solid solid none; border-width: 1px 1px 0px; font-size: 12px; word-wrap: break-word; line-height: 18px; overflow: hidden; outline: none; height: 22px;" node-type="textEl" range="0&amp;0"></textarea>
							</div>
							<div class="sendbox_annex S_bg2 S_line3">
								<div class="sendbox_file S_line2" style="display: none;" node-type="files" id="uploadflash_id_142086040855964" filetype="file" swfid="swf_5936" fids="" vfids="" tovfids=""></div>
								<div class="sendbox_img S_line2" style="display: none;" node-type="images" fids="" vfids="" tovfids=""><div class="imgs clearfix" id="uploadflash_id_142086040855963" filetype="img" swfid="swf_5047"></div></div>
							</div>
							<div class="sendbox_bar clearfix">
								<div class="sendbox_menu W_fl" style="position: relative;">
									<a href="javascript:void(0);" class="icon_send" node-type="smileyBtn"><em class="W_ficon ficon_face">o</em></a>
									<a href="javascript:void(0);" class="icon_send" node-type="picBtn" style="position: relative;"><em class="W_ficon ficon_image">p</em><span style="display: inline-block; position: absolute; left: 0px; top: -2px; z-index: 9999;"><embed width="25" height="20" id="swf_5047" src="http://service.weibo.com/staticjs/tools/upload.swf" type="application/x-shockwave-flash" menu="false" scale="noScale" allowfullscreen="true" allowscriptaccess="always" bgcolor="" wmode="transparent" flashvars="swfid=uploadflash_id_142086040855963&amp;maxSumSize=50&amp;maxFileSize=50&amp;maxFileNum=5&amp;multiSelect=0&amp;uploadAPI=http%3A%2F%2Fupload.api.weibo.com%2F2%2Fmss%2Fupload.json%3Fsource%3D209678993%26tuid%3D1949577083&amp;initFun=STK.namespace.v6home.lib.message.upload.init&amp;sucFun=STK.namespace.v6home.lib.message.upload.complete&amp;errFun=STK.namespace.v6home.lib.message.upload.error&amp;beginFun=STK.namespace.v6home.lib.message.upload.start&amp;areaInfo=0-20|10-22&amp;fExt=*.jpg;*.gif;*.jpeg;*.png&amp;fExtDec=选择图片"></span></a>
									<a href="javascript:void(0);" class="icon_send" node-type="attachBtn" style="position: relative;"><em class="W_ficon ficon_file">x</em><span style="display: inline-block; position: absolute; left: 0px; top: -2px; z-index: 9999;"><embed width="25" height="20" id="swf_5936" src="http://service.weibo.com/staticjs/tools/upload.swf" type="application/x-shockwave-flash" menu="false" scale="noScale" allowfullscreen="true" allowscriptaccess="always" bgcolor="" wmode="transparent" flashvars="swfid=uploadflash_id_142086040855964&amp;maxSumSize=50&amp;maxFileSize=50&amp;maxFileNum=5&amp;multiSelect=0&amp;uploadAPI=http%3A%2F%2Fupload.api.weibo.com%2F2%2Fmss%2Fupload.json%3Fsource%3D209678993%26tuid%3D1949577083&amp;initFun=STK.namespace.v6home.lib.message.upload.init&amp;sucFun=STK.namespace.v6home.lib.message.upload.complete&amp;errFun=STK.namespace.v6home.lib.message.upload.error&amp;beginFun=STK.namespace.v6home.lib.message.upload.start&amp;areaInfo=0-20|10-22&amp;fExt=*&amp;fExtDec=选择文件"></span></a>
									<div node-type="widget"></div>
								</div>
								<div class="sendbox_btn W_fr">
									<span class="prompt S_txt1" node-type="num" style="visibility: hidden;">还可以输入<span>10000</span>字</span>
									<a href="javascript:void(0);" class="W_btn_a btn_30px" node-type="submit" action-type="submit" action-data="uid=1949577083">发送</a>
								</div>
							</div>
						</div>
					</div>
				</div>
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
			
				<li ><a href="http://www.07260.com" target="_blank" class="links">旧淘链接</a></li>

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
</body>
</html>