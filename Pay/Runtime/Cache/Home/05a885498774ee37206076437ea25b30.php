<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="keywords" content="旧淘,二手,市场,自行车,电动车,教材,手机,电脑,租房,球拍,运动器材,衣物,数码配件,耳机,足球,洗衣机,鼠标,键盘,相机"/>
		<meta name="description" content="旧淘是最安全方便的二手市场。提供自行车,电动车,教材,手机,电脑,租房,洗衣机,球,衣物,数码配件等二手商品信息。充分满足小伙伴们查看/发布二手商品的需求。"/>
		<meta property="qc:admins" content="17066776776072606375" />
		<meta property="wb:webmaster" content="6350b89049aef05c" />
		<title><?php echo ($shop_list["title"]); ?></title>
		<link rel="icon" href="/Public/Home/style/image/jiutao.ico"/>  
		<link rel="stylesheet" href="/Public/Home/style/css/init.css"/>
		<link rel="stylesheet" href="/Public/Home/style/css/main.css"/>
		<link rel="stylesheet" href="/Public/Home/style/css/index.css"/>
		<link rel="stylesheet" href="/Public/Home/style/css/detail.css"/>
		<script type="text/javascript" src="/Public/Home/style/js/jquery-1.7.2.min.js"></script>		
			
		<script type="text/javascript" >	
		window.url = '<?php echo ($url); ?>';
		lxfEndtime();
			function lxfEndtime() {
					$(".lxftime").each(function () {
						var endtime = new Date($(this).attr("endtime")).getTime(); //取结束日期(毫秒值)
						var nowtime = new Date().getTime(); //今天的日期(毫秒值)服务器时间
						var seconds = ((endtime - nowtime)/1000); //还有多久(秒)
						var CDay = Math.floor(seconds / 60 / 60 / 24);
						var CHour = Math.floor(seconds / 60 / 60 % 24);
						var CMinute = Math.floor(seconds / 60 % 60); 
						var CSecond = Math.floor(seconds % 60); //"%"是取余运算，可以理解为60进一后取余数，然后只要余数。
						var CMSecond = Math.floor(seconds*10%10);// 计算100毫秒

						if (endtime <= nowtime) {
							$(this).html("已过期"); //如果结束日期小于当前日期就提示过期啦
						} else {
							$(this).html("<span class='num_bold'>"+CDay + "</span>天<span class='num_bold'>" + (CHour<10?"0"+CHour:CHour) + "</span>小时<span class='num_bold'>" + (CMinute<10?"0"+CMinute:CMinute) + "</span>分<span class='num_bold'>" + (CSecond<10?"0"+CSecond:CSecond) + "."+CMSecond+"</span>秒"); //输出有天数的数据
							//当前时间变化
							$(this).attr("nowtime", zhtime(nowtime+100));
						}
					});
					setTimeout("lxfEndtime()", 100);
			}
			//js时间戳格式转05/20/2014 20:54:40
			function zhtime(needtime) {
				var oks = new Date(needtime);
				var year = oks.getFullYear();
				var month = oks.getMonth() + 1;
				var date = oks.getDate();
				var hour = oks.getHours();
				var minute = oks.getMinutes();
				var second = oks.getSeconds();
				var msecond=oks.getMilliseconds()
				return month + '/' + date + '/' + year + ' ' + hour + ':' + minute + ':' + second+'.'+msecond;
			}
			//时间倒计时end
	   </script>
		<link rel="stylesheet" href="/Public/Home/style/css/rrshare.css"/>    
	</head>
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
		<div class="main center clearfix">
			<div class="ershou-details">
				<div class="ershou-photos-wr">
				<?php if($userinfo["name"] != null): ?><a class="ershou-favorite" href="javascript:void(0);" <?php if($collect_stat == 1): ?>style="background-image:url('/Public/Home/style/image/heart_full.png');"<?php else: ?>style="background-image:url('/Public/Home/style/image/heart.png');"<?php endif; ?>" onclick="favorites();"><?php echo ($shop_list["point_like"]); ?></a>
				<?php else: ?>
					<a class="ershou-favorite" href="javascript:alert('亲，您还没有登入哦！');" <?php if($collect_stat == 1): ?>style="background-image:url('/Public/Home/style/image/heart_full.png');"<?php else: ?>style="background-image:url('/Public/Home/style/image/heart.png');"<?php endif; ?>" onclick="favorites();"><?php echo ($shop_list["point_like"]); ?></a><?php endif; ?>
					<a class="bigger-photo" title="点开看大图" href="http://ershou.u.qiniudn.com/iOS_1419071350_55887_1?imageView2/5/w/800/h/800" target="_blank">
					<?php for($i=0;$i<count($arr['image']);$i++){?>
						<img class="bigger" src="<?php echo $arr['image'][$i]?>" />
					<?php  }?>
						<!--<img class="bigger" src="<?php echo ($shop_list["point_like"]); ?>" alt="出日版5s16g和32g">-->
					</a>
					<div class="ershou-photo-slide">
					<?php for($i=0;$i<count($arr['image']);$i++){?>
						<div class="ershou-small-photos">
							<img class="small cur" src="<?php echo $arr['image'][$i]?>" alt="出日版5s16g和32g" />
						
						</div> 
					<?php  }?>
					</div>
					<div class="ershou-photo-slide-layer"></div>
				</div>
				<?php if($pay_type == 4): ?><div class="ershou-info">
					<div class="ershou-hd">
						<h2 class="ershou-title"><?php echo ($shop_list["title"]); ?></h2>
						<div style="z-index: 9; margin-bottom: 0;" id="now_price" >
							<span style="margin-left: 20px;margin-right: 27px; color: #858E8F; text-decoration: none;">当前价</span>
							<span style="color: #d91615;">
								<span style="font-size: 26px;font-weight: 700;" id="all_price" att="<?php echo ($shop_list["current_price_prc"]); ?>"><?php echo ($shop_list["current_price_prc"]); ?></span>
								<span style="font-weight: 700;margin: 0 3px 0 -5px;font-family: Microsoft YaHei ;">&nbsp;&nbsp;元</span>
							</span>
						</div>
						<div style="margin: 5px 0px 10px; position: relative;">
							<span style="margin-left: 20px; margin-right: 27px; color: #858E8F; text-decoration: none;">距结束</span>
							<span class="lxftime" nowtime="" endtime="<?php echo ($shop_list["period_time"]); ?>" ></span><!--endtime是变量-->
						</div>
						<div style="font-size:20px; color:#d91615; font-weight:bold; text-align:center; " id="jiandi_auction">
						
						
						<?php if($username == null){?>
							<img src='/Public/Home/style/image/login_aut.png' alt='人人分享' class='bids_button'/>
						<?php }else{?>
							<?php if($member_uid == $username){?>
								<img src='/Public/Home/style/image/end_bids_button.png' alt='人人分享' class='bids_button'/>
							<?php }else{?>
								<?php if($shop_list['a_name'] == $username){?>
									<img src='/Public/Home/style/image/end_bids_button.png' alt='人人分享' class='bids_button'/>
								<?php }else{?>
									<img src='/Public/Home/style/image/start_bids_button.png' alt='人人分享' class='bids_button' id='click_auction'/>
								<?php }?>
							<?php }?>
						<?php }?>
						</div>
					</div>
					<ul class="ershou-detail">
						<li class="ershou-place-bids">
							<div class="name_bids"><span>起拍价格</span></div>
							<div class="value"><span><?php echo ($shop_list["starting_price"]); ?>元</span></div>
						</li>
						<li class="ershou-place-bids">
							<div class="name_bids"><span>加价幅度</span></div>
							<div class="value" id="add_pricle" attr="<?php echo ($shop_list["markups"]); ?>"><span><?php echo ($shop_list["markups"]); ?>元/次</span></div>
						</li>
						<li class="ershou-place-bids" id="count_num">
							<div class="name_bids"><span>出价人数</span></div>
							<div class="value"><span>&nbsp;<?php echo ($shop_list["count_num"]); ?>人</span></div>
						</li>
						<li class="ershou-place-bids" id="bids_num">
							<div class="name_bids"><span>出价次数</span></div>
							<div class="value"><span>&nbsp;<?php echo ($shop_list["bids_num"]); ?>次</span></div>
						</li>
						<div style="clear:both;"></div>
						<li class="ershou-seller">					
							<div class="name_bids"><span>卖家</span></div>
							<div class="value">
								<span>&nbsp;<?php if($shop_list["nickname"] == ''): ?>无<?php else: echo ($shop_list["nickname"]); endif; ?></span>
							</div>
						</li>							
						<?php if($shop_list["phone"] != null): ?><li class="ershou-tel">
								<div class="name_bids"><span>手机</span></div>
								<div class="value"><span>&nbsp;<?php echo ($shop_list["phone"]); ?></span></div>
							</li><?php endif; ?>
						<?php if($shop_list["qq"] != null): ?><li class="ershou-phone">
							<div class="name_bids"><span>QQ</span></div>
							<div class="value"><span>&nbsp;<?php echo ($shop_list["qq"]); ?></span></div>
						</li><?php endif; ?>
						<?php if($shop_list["weixin"] != null): ?><li class="ershou-phone">
							<div class="name_bids"><span>微信</span></div>
							<div class="value"><span>&nbsp;<?php echo ($shop_list["weixin"]); ?></span></div>
						</li><?php endif; ?>
						<li class="ershou-place">							
							<div class="name_bids"><span>&nbsp;交易地点</span></div>
							<div class="value"><span>&nbsp;<?php echo ($shop_list["location"]); ?></span></div>
						</li>
						<li class="ershou-place">							
							<div class="name_bids"><span><?php if($shop_list["auction_due_time"] == 2): ?>&nbsp;最新出价人<?php else: ?>&nbsp;最终出价者<?php endif; ?></span></div>
							<div class="value new_Bidders"><span>&nbsp;</span></div>
						</li>
						<div style="clear:both;"></div>
					</ul>
					<!--<a name="xn_share" class="hidden" onclick="shareClick()" href="javascript:void(0);"><span class="xn_share_wrapper xn_share_button_small"></span></a>
					<a class="xn_share_bids" onclick="shareClick()" href="javascript:void(0);">
						<img src="/Public/Home/style/image/renrenshare.png" alt="人人分享">
					</a>-->
					<div style="margin-left:20px;">分享到：<div class="bdsharebuttonbox"><a class="bds_more" href="#" data-cmd="more"></a><a title="分享到QQ空间" class="bds_qzone" href="#" data-cmd="qzone"></a>
						<a title="分享到新浪微博" class="bds_tsina" href="#" data-cmd="tsina"></a><a title="分享到腾讯微博" class="bds_tqq" href="#" data-cmd="tqq"></a>
						<a title="分享到人人网" class="bds_renren" href="#" data-cmd="renren"></a><a title="分享到微信" class="bds_weixin" href="#" data-cmd="weixin"></a>
					</div></div>
					<input type="hidden" id="con_id" value="<?php echo ($shop_list["id"]); ?>">
					<script type="text/javascript">
						function shareClick() {
							var title = $(".ershou-title").text(),
							description = $("#user_cmt").text(),
							pic = $(".bigger").attr('src');
							var rrShareParam = {
								resourceUrl : '',	//分享的资源Url
								srcUrl : '',	//分享的资源来源Url,默认为header中的Referer,如果分享失败可以调整此值为resourceUrl试试
								pic : pic,		//分享的主题图片Url
								title : title,		//分享的标题
								description : description	//分享的详细描述
							};
							rrShareOnclick(rrShareParam);
						}
					</script>
				</div>
				<?php else: ?>
				<div class="ershou-info">
					<div class="ershou-hd">
						<h2 class="ershou-title"><?php echo ($shop_list["title"]); ?></h2>
						<div class="ershou-price discount">
							<span><?php echo ($shop_list["real_price"]); ?></span>
							<span style="text-decoration:line-through;color:gray;margin-left:15px;font-size:22px;">￥<?php echo ($shop_list["pay_price"]); ?></span>		
						</div>					
					</div>
					<ul class="ershou-detail">
						<li class="ershou-place">
							<div class="name_bids"><span>交易地点</span></div>
							<div class="value"><span>&nbsp;<?php echo ($shop_list["location"]); ?></span></div>
						</li>
						<li class="ershou-seller">
							<div class="name_bids"><span>卖家</span></div>
							<div class="value">
								<span>&nbsp;<?php echo ($shop_list["nickname"]); ?></span>
							</div>
						</li>
						<?php if($shop_list["phone"] != null): ?><li class="ershou-tel">
								<div class="name_bids"><span>手机</span></div>
								<div class="value"><span>&nbsp;<?php echo ($shop_list["phone"]); ?></span></div>
							</li><?php endif; ?>
						<?php if($shop_list["qq"] != null): ?><li class="ershou-phone">
							<div class="name_bids"><span>QQ</span></div>
							<div class="value"><span>&nbsp;<?php echo ($shop_list["qq"]); ?></span></div>
						</li><?php endif; ?>
						<?php if($shop_list["weixin"] != null): ?><li class="ershou-phone">
							<div class="name_bids"><span>微信</span></div>
							<div class="value"><span>&nbsp;<?php echo ($shop_list["weixin"]); ?></span></div>
						</li><?php endif; ?>
						<li class="ershou-time">
							<div class="name_bids"><span>发布时间</span></div>
							<div class="value">
							<span class="real-time">&nbsp;<?php echo ($shop_list["dis_time"]); ?></span></div>
						</li>
					</ul>
					
					<input type="hidden" id="con_id" value="<?php echo ($shop_list["id"]); ?>">
					<a name="xn_share" class="hidden" onclick="shareClick()" href="javascript:void(0);"><span class="xn_share_wrapper xn_share_button_small"></span></a>
					<div style="margin-left:20px;">分享到：<div class="bdsharebuttonbox"><a class="bds_more" href="#" data-cmd="more"></a><a title="分享到QQ空间" class="bds_qzone" href="#" data-cmd="qzone"></a>
						<a title="分享到新浪微博" class="bds_tsina" href="#" data-cmd="tsina"></a><a title="分享到腾讯微博" class="bds_tqq" href="#" data-cmd="tqq"></a>
						<a title="分享到人人网" class="bds_renren" href="#" data-cmd="renren"></a><a title="分享到微信" class="bds_weixin" href="#" data-cmd="weixin"></a>
					</div></div>
					<script type="text/javascript">
						function shareClick() {
							var title = $(".ershou-title").text(),
							description = $("#user_cmt").text(),
							pic = $(".bigger").attr('src');
							var rrShareParam = {
								resourceUrl : '',	//分享的资源Url
								srcUrl : '',	//分享的资源来源Url,默认为header中的Referer,如果分享失败可以调整此值为resourceUrl试试
								pic : pic,		//分享的主题图片Url
								title : title,		//分享的标题
								description : description	//分享的详细描述
							};
							rrShareOnclick(rrShareParam);
						}
					</script>
				</div><?php endif; ?>
			</div>
			<div class="ershou-desc">
				<div class="desc clearfix">
					<img id="user_ph" src="<?php echo ($shop_list["img_url"]); ?>" alt="头像">
					<span id="user_cmt"><?php echo ($shop_list["content"]); ?><br></span>
				</div>
			</div>
			<div class="comments">
			<div class="comments-title">评论</div>
				<div class="comments-wr">
					<div class="comment-wr">
					<div class="comment_sun">
						<?php if(is_array($comment_list)): $i = 0; $__LIST__ = $comment_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="comment">
								<img class="avatar" src="<?php echo ($vo["img_url"]); ?>" alt="头像">
								<div class="commentator" ><?php echo ($vo["nickname"]); ?></div>
								<p class="comment"><?php echo ($vo["content"]); ?></p>
								<div class="man">
								<?php if($userinfo["name"] != null): ?><a class="rpl return_pl" href="javascript:void(0);" data="<?php echo ($vo["nickname"]); ?>"><?php if($userinfo["name"] != null): ?>回复<?php endif; ?></a>
								<?php else: ?>
									<a class="rpl return_pl" href="javascript:void(0);"><?php if($userinfo["name"] != null): ?>回复<?php endif; ?></a><?php endif; ?>
									<!-- <a class="del" href="javascript:void(0);">#1</a> -->
								</div>
							
							</div><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
						<div class="post-comment clearfix">
							<input id="goods_id" type="hidden" value="<?php echo ($shop_list["id"]); ?>">
							<img class="avatar" src="/Public/Home/style/image/avatar-unlogin.png" alt="头像">
							<!--<div class="commenting-unlogin clearfix">
								<div class="comment-input-wr-wr">
									<div class="comment-input-wr">
										<textarea class="comment-input" name="comment-input" id="comment" style="color: rgb(133, 141, 142);"></textarea>
									</div>
								</div>
								
								<button class="sub-comment" id="login_show" type="button">登入</button>
								
							     
							</div>-->
							<?php if($userinfo["name"] == null): ?><div class="commenting-unlogin clearfix">
									<div class="comment-input-wr-wr">
										<div class="comment-input-wr">
											<span class="tips">评论总要登录留个名吧</span>
										</div>
									</div>
									<button class="comment-login" data-type="l">登录</button>
								</div>
							<?php else: ?>
								<div class="commenting-unlogin clearfix">
								<div class="comment-input-wr-wr">
									<div class="comment-input-wr">
										<textarea class="comment-input" name="comment-input" id="comment" style="color: rgb(133, 141, 142);"></textarea>
									</div>
								</div>
								
								<button class="sub-comment" id="add_comment" type="button">登入</button>
								
							     
							</div><?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="concerned-goods">
				<div class="concerned-title">相关商品</div>
				<div class="goods-list">
					<ul class="clearfix">
						<?php if(is_array($about_shop)): $i = 0; $__LIST__ = $about_shop;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><li>						
							<a href="<?php echo U('Home/Goods/goodsDetail?id='.$vol['id']);?>" title="<?php echo ($vol["title"]); ?>">
								<img src="<?php echo ($www); echo ($vol["image_url"]); ?>" alt="surface rt 32G">
							</a>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>			
					</ul>
				</div>
			</div>
		</div>
	</div>	
<input type="hidden" value="<?php echo ($userinfo["name"]); ?>" id="user_info_name">
<input type="hidden" value="<?php echo ($userinfo["head_img_url"]); ?>" id="user_info_url">
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

<script type="text/javascript">	
window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
</script>	

<script type="text/javascript">	

$(function(){
//添加评论
/*var  datas = {
	'user_info':"<?php echo ($username); ?>",
	'head_img':"<?php echo ($username); ?>",
	'nickname':"<?php echo ($shop_list["username"]); ?>"
};
	if(datas.user_info == datas.nickname || datas.user_info == ''){
		var htmlss="<img src='/Public/Home/style/image/end_bids_button.png' alt='人人分享' class='bids_button'/>";
		$("#jiandi_auction").html(htmlss);
	}else if(datas.user_info != datas.nickname || datas.user_info != ''){
		var htmlss="<img src='/Public/Home/style/image/start_bids_button.png' alt='人人分享' class='bids_button' id='click_auction'/>";
		$("#jiandi_auction").html(htmlss);
	}*/
	var  datas = {
	'user_info':"<?php echo ($username); ?>",
	'user_name':"<?php echo ($userinfo); ?>",
	'nickname':"<?php echo ($shop_list["username"]); ?>"
	};
	var pay_id = $("#con_id").val();
	$.ajax({
			type : "get",
			url : "<?php echo U('Goods/ajax_auction');?>",
			data : {pay_id:pay_id},
			success:function(data){    // login_aut
					if(data.user_info==null){
						var htmlsss="<img src='/Public/Home/style/image/login_aut.png'  class='bids_button'/>";
						
						var news = "<span>&nbsp;"+data.a_nick+"</span>";
						$(".new_Bidders").html(news);
						$("#jiandi_auction").html(htmlsss);
					}else{
					if(data.member_uid == data.user_info){
						var htmlsss="<img src='/Public/Home/style/image/end_bids_button.png'  class='bids_button'/>";
							var news = "<span>&nbsp;"+data.a_nick+"</span>";
							$(".new_Bidders").html(news);
							$("#jiandi_auction").html(htmlsss);
					}else{
						if(  data.a_name == data.user_info ){
							var htmlsss="<img src='/Public/Home/style/image/end_bids_button.png'  class='bids_button'/>";
							var news = "<span>&nbsp;"+data.a_nick+"</span>";
							$(".new_Bidders").html(news);
							$("#jiandi_auction").html(htmlsss);
						}else{
							var htmlsss="<img src='/Public/Home/style/image/start_bids_button.png'  class='bids_button' id='click_auction_con'/>";
							if(data.a_nick==null){
								var news = "<span>&nbsp;无</span>";
							}else{
								var news = "<span>&nbsp;"+data.a_nick+"</span>";
							}
							$(".new_Bidders").html(news);
							$("#jiandi_auction").html(htmlsss);
						}
					}
						
						
					} 	
					
					$("#click_auction_con").click(function(){
					var add_price = $("#add_pricle").attr("attr");
					var all_price = $("#all_price").attr("att");
					//var window.adds = data.
					var cat_id = $("#con_id").val();
					$.ajax({
						type : "get",
						url : "<?php echo U('Goods/click_auction');?>",
						data : {add_price:add_price,cat_id:cat_id,all_price:all_price},
						success:function(data){
						  $html = '';
							if(data.biddingname == data.user_info){
								var htmlss="<img src='/Public/Home/style/image/end_bids_button.png' class='bids_button'/>";
								 
								$("#jiandi_auction").html(htmlss);
							}else{
								var htmlss="<img src='/Public/Home/style/image/start_bids_button.png'  class='bids_button' id='click_auction'/>";
								
								$("#jiandi_auction").html(htmlss);
							}	
							var html = '';
							html += "<div>";
							html+= "<span style='margin-left: 20px;margin-right: 27px; color: #858E8F; text-decoration: none;'>当前价</span>";
							html+= "<span style='color: #d91615;'>";
							html+= "<span style='font-size: 26px;font-weight: 700;' id='all_price' att='"+data.current_price_prc+"'>"+data.current_price_prc+"</span>";
							html+= "<span style='font-weight: 700;margin: 0 3px 0 -5px;font-family: Microsoft YaHei ;'>&nbsp;&nbsp;元</span>";
							html+= "</span>";
							html+= "</div>";
							var num = '';
							num += "<div>";
							num+= "<div class='name_bids'><span>出价人数</span></div>";
							num+= "<div class='value'><span>"+data.bids_person_num+"人</span></div>";
							num+= "</div>";
							var buttom = '';
							buttom += "<div>";
							buttom+= "<div class='name_bids'><span>出价次数</span></div>";
							buttom+= "<div class='value'><span>"+data.bids_num+"人</span></div>";
							buttom+= "</div>";
							var news = "<span>&nbsp;"+data.biddingname+"</span>";
							$("#now_price").html(html); 
							$("#count_num").html(num); 
							$("#bids_num").html(buttom); 
							$(".new_Bidders").html(news); 

						}
					});
				});	
								
			}
						
		    
		});
		
		
$("#add_comment").click(function(){
		var pl = $("#comment").val();
		var con_id = $("#con_id").val();
		var teshu = /^[^|"'<>=-]*$/;
		if(!teshu.test(pl)){
			alert('不能有特殊字符!');
			$("#comment").val("");
			return;
		}
		if (pl==''){
			alert('请输入要评论的内容!');
			return;
		}else{
			//------------add------------
			var $htmls = '';
			var d = new Date();
			var sconds = ''+d.getSeconds();
			var mins = ''+d.getMinutes();
			var riqi = ''+d.getDate();
			var u_name = $("#user_info_name").val();
			var u_url = $("#user_info_url").val();
			if(sconds.length == 1){ sconds = "0"+sconds;}
			if(mins.length == 1){ mins = "0"+mins;}
			if(riqi.length == 1){ riqi = "0"+riqi;} 
			var str = d.getFullYear()+"-"+(d.getMonth()+1)+"-"+riqi+" "+d.getHours()+":"+mins+":"+sconds;
			$htmls +="<div>"; 
			$htmls +="<div class='comment'>";
			$htmls +="<img class='avatar' src='"+u_url+"' alt='头像'>";
			$htmls +="<div class='commentator'>"+u_name+"</div>";
				$htmls +="<p class='comment'>"+pl+"</p>";
					$htmls +="<div class='man'>";
						$htmls +="<a class='rpl' href='javascript:void(0);' onclick='reply(43460, '龙猫')'>回复</a>";
					$htmls +="</div>"; 
					$htmls+="</div>";
			$htmls +="</div>";
			$($htmls).insertBefore(".comment_sun");
			//---------------post------------
			$.ajax({
				type : "get",
				url : "<?php echo U('Goods/Addcomment');?>",
				data : {com:pl,con_id:con_id},
				success:function(data){
				  $html = '';
				  if (data == 1){
					alert('评论成功');
					$("#comment").val("");
				  }else if(data ==2){
					alert('失败');
				  }

			   }
			});

		}
	
	});
	
	$(".return_pl").each( function(i,e){
		$(e).click( function(){
		$("#comment").val("");
		var comm = $(this).attr("data");
		var a = "回复 "+comm+" :";
			$("#comment").val(a).focus();
		});
	});
	
	
});
</script>