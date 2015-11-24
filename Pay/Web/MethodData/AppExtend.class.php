<?php 
/**
 * 91分享接口
 */
 class AppExtend{
	public function Extension($datas = array()){
		$share = M('share_center');
		$shareinfo = $share->where("id=1")->find();
		$shareinfo['VipImages'] = "/Public/Uploads/Apk/level_instructions1.jpg";
		//时间参数
		$shareinfo['times'] = time();
		//联系客服网页地址
		$shareinfo['service_url'] = "/web/method/contact";
		
		//关注微信地址
		$shareinfo['weixin_url'] = "/Web/WeChat/description";
		
		//分享链接
		$shareinfo['fenx_url'] = "http://a.app.qq.com/o/simple.jsp?pkgname=com.wyr.integralwall";

		echo json_encode($shareinfo);
		
	}
	
 }
 ?>