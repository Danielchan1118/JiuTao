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
	<link rel="stylesheet" href="/Public/Home/style/css/init.css"/>
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
        <img class="release-icon-main" src="/Public/Home/style/image/release-icon.png" alt="">
        <div class="wave-fluid"></div>
        <div class="release-title">发布商品</div>
        <div class="upload-wr">
            <div class="clone-target">
                <div class="photo">
                    <div><img src="" alt="" class="image"></div>
                    <span class="close"></span>
                </div>
            </div>
            <div class="photo-area init-up" id="unique_img">
			<div class="upload-area">
			<input id="upload" name="uploadify" type="file" multiple="true">
					<input type="hidden" id="url" value="/Home/Release">
					<input type="hidden" id="root" value="">
					<input type="hidden" id="public" value="/Public">
			<div id="upload-queue" class="uploadify-queue"></div><div class="up-bg"></div></div>      
			<div class="photo-caution"><span>最多上传九张图片，支持jpg、png、gif格式</span></div>
            </div>
        </div>
        <div class="form-wr">
            <form action="">
                <div class="form-must-wr">
                    <div class="form-item l goods-title">
                        <div class="form-key"><span>商品名称</span></div>
                        <div class="form-value">
                            <div class="form-input-wr">
                                <input type="text" id="title" name="title" placeholder="最多25个字">
                            </div>
                        </div>
                    </div>
                    <div class="form-item xl goods-desc">
                        <div class="form-key"><span>商品详情</span></div>
                        <div class="form-value">
                            <div class="form-input-wr">
                                <textarea name="desc" id="desc" placeholder="建议填写物品用途、新旧程度、原价等信息，至少15个字"></textarea>
                            </div>
                        </div>
                    </div>
					<div class="form-item m goods-discount pay_type">
                        <div class="form-key"><span>交易方式</span></div>
                        <div class="form-value" style="width: 52%;">
                            <div class="form-input-wr">
                                <span class="yes" data-value="1">出售</span>
                                <span class="yes" data-value="2">交换</span>
                                <span class="yes" data-value="3">免费赠送</span>
                                <span class="no" data-value="4">竞拍</span>
                                <input type="hidden" id="pay_type" name="pay_type" value="">
                            </div>
                        </div>
                    </div>
                   
					 <div class="form-item m former_price">
                        <div class="form-key"><span>原价</span></div>
                        <div class="form-value">
                            <div class="form-input-wr">
                                <input class="price" type="text" id="real_price" name="real_price" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-item m transfer_pre">
                        <div class="form-key"><span>转让价</span></div>
                        <div class="form-value">
                            <div class="form-input-wr">
                                <input class="price" type="text" id="pay_price" name="pay_price" value="">
                            </div>
                        </div>
                    </div>
					<div class="form-item m action_price" style="display:none;">
                        <div class="form-key"><span>竞拍价</span></div>
                        <div class="form-value">
                            <div class="form-input-wr">
                                <input class="price" type="text" id="action_price" name="action_price">
                            </div>
                        </div>
                    </div>
					<div class="form-item m add_price" style="display:none;">
                        <div class="form-key"><span>加价幅度</span></div>
                        <div class="form-value">
                            <div class="form-input-wr">
                                <input class="price" type="text" id="add_price" name="add_price">
                            </div>
                        </div>
                    </div>
                    <div class="form-item m goods-cat">
                        <div class="form-key"><span>分类</span></div>
                        <div class="form-value">
                            <div class="form-input-wr"><span>请选择</span>
                            <input type="hidden" id="cat" name="cat" value=""></div>
                            <ul class="select" style="display: none;">
							<?php if(is_array($arr)): $i = 0; $__LIST__ = $arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li value="<?php echo ($vo["id"]); ?>"><span><?php echo ($vo["name"]); ?></span></li><?php endforeach; endif; else: echo "" ;endif; ?>	
							</ul>
                        </div>
                        <div class="form-value-l">
                            <div class="form-input-l-wr">
                                <span>请选择</span>
                                <input type="hidden" id="cat_l" name="cat_l" value="">
                            </div>
							<?php if(is_array($arr)): $i = 0; $__LIST__ = $arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><ul class="select" id="cul<?php echo ($vol["id"]); ?>" style="display: none;">
									<?php if(is_array($vol["sub"])): $i = 0; $__LIST__ = $vol["sub"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s_vol): $mod = ($i % 2 );++$i;?><li value="<?php echo ($s_vol["id"]); ?>"><span><?php echo ($s_vol["name"]); ?></span></li><?php endforeach; endif; else: echo "" ;endif; ?>
									</ul><?php endforeach; endif; else: echo "" ;endif; ?>		
									
                        </div>
                    </div>
                    <div class="form-item m goods-discount user_status">
                        <div class="form-key"><span>使用情况</span></div>
                        <div class="form-value">
                            <div class="form-input-wr">
                                <span class="yes" data-value="1">全新</span>
                                <span class="no" data-value="0">非全新</span>
                                <input type="hidden" id="discount" name="discount" value="">
                            </div>
                        </div>
                    </div>
					<div class="form-item m goods-discount period">
                        <div class="form-key"><span>发布周期</span></div>
                        <div class="form-value" style="width:40%;">
                            <div class="form-input-wr">
                                <span class="yes" data-value="1">7天</span>
                                <span class="yes" data-value="2">15天</span>
                                <span class="no" data-value="3">30天</span>
                                <input type="hidden" id="period" name="period" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-contact">联系方式</div>
                <div class="form-least">（至少选填一项）</div>
                <hr class="form-sep-form clear" size="1" color="#D0E0E2">
                <div class="form-select">
                    <div class="form-item m">
                        <div class="form-key"><span>微信</span></div>
                        <div class="form-value">
                            <div class="form-input-wr">
                                <input type="tel" id="weixin" name="weixin" value="">
                            </div>
                        </div>
                    </div>
					<div class="form-item m">
                        <div class="form-key"><span>手机</span></div>
                        <div class="form-value">
                            <div class="form-input-wr">
                                <input type="tel" id="tel" name="tel" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-item m">
                        <div class="form-key"><span>QQ</span></div>
                        <div class="form-value">
                            <div class="form-input-wr">
                                <input type="text" id="qq" name="qq" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-share-wr">
                    <label for="form-share">
                    <input id="form-share" name="share" type="checkbox" checked="on">
                    <span>我同意&nbsp;<a href="<?php echo U('Release/publish_rule');?>" target="_blank">商品发布规则</a></span>
                </label></div>
                <input type="hidden" id="school_id" value="">
                <input type="hidden" id="user_school_id" value="">
                <button type="button" class="form-submit" onclick="pre_release();">马上发布</button>
            </form>
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