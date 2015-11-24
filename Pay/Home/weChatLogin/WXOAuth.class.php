<?php
/**
 * @name wechats登录接口授权
 *
 */
class WXOAuth {
	//获取code的值的URL(2)
	function getAuthorizeURL( $url, $response_type = 'code', $scope = 'snsapi_login', $display = NULL ) {
		$state = md5(uniqid(rand(), true));
		$_SESSION['wechat_state'] = $state;
		$params = array();
		$params['appid'] 		 = WX_AKEY;
		$params['redirect_uri']  = $url;//回调/重定向地址
		$params['response_type'] = $response_type;
		$params['scope'] 		 = $scope;
		$params['state'] 		 = $state;
		return $this->authorizeURL() . "?" . http_build_query($params) . '#wechat_redirect';
	}
	
	//获取access_token的值的URL(2)
	function getAccessTokenURL( $code, $grant_type='authorization_code' ){
		$params['appid'] 	  = WX_AKEY;
		$params['secret'] 	  = WX_SKEY;
		$params['code'] 	  = $code;
		$params['grant_type'] = $grant_type;
		return $this->accessTokenURL() . "?" . http_build_query($params);
	}
	
	//获取weChat用户的个人资料的URL(2)
	function getUserInfoURL( $access_token, $openid ){
		$params['access_token'] = $access_token;
		$params['openid'] 	  	= $openid;
		return $this->userInfoURL() . "?" . http_build_query($params);
	}	
	
	//获取code的值的URL(1)
	function authorizeURL() { return 'https://open.weixin.qq.com/connect/qrconnect'; }
	
	//获取access_token的值的URL(1)
	function accessTokenURL() { return 'https://api.weixin.qq.com/sns/oauth2/access_token'; }
	
	//获取weChat用户的个人资料的URL(1)
	function userInfoURL() { return 'https://api.weixin.qq.com/sns/userinfo'; }
	
	//获取access_token的值的URL(3)
	function getAccessTokenData( $code ) { 
		$url = $this->getAccessTokenURL( $code );
		return file_get_contents($url);exit;	 
	}
	
	//获取weChat用户的个人资料的URL(13
	function getuserInfoData( $access_token, $openid ) { 
		$url = $this->getUserInfoURL( $access_token, $openid );
		return file_get_contents($url);exit;	 
	}	



}