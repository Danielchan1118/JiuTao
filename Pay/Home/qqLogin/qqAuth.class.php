<?php
/**
 * @name wechats登录接口授权
 *
 */
class qqAuth {
	//获取code的值的URL(2)
	function getAuthorizeURL( $url, $response_type = 'code', $scope = 'get_user_info', $display = NULL ) {
		$state = md5(uniqid(rand(), true));
		$_SESSION['qq_state'] = $state;
		$params = array();
		$params['client_id'] 	 = qq_AKEY;
		$params['redirect_uri']  = urlencode($url);//回调/重定向地址
		$params['response_type'] = $response_type;
		$params['scope'] 		 = $scope;
		$params['state'] 		 = $state;
		return $this->authorizeURL() . "?" . http_build_query($params);
	}

	//获取access_token的值的URL(2)
	function getAccessTokenURL( $code, $url, $grant_type='authorization_code' ){
		$params['client_id'] 	 = qq_AKEY;
		$params['client_secret'] = qq_SKEY;
		$params['code'] 	  	 = $code;
		$params['grant_type'] 	 = $grant_type;
		$params['redirect_uri']  = urlencode($url);//回调/重定向地址
		return $this->accessTokenURL() . "?" . http_build_query($params);
	}
	
	//获取qq用户的个人资料的URL(2)
	function getUserInfoURL( $access_token, $appID, $openid ){
		$params['access_token'] 	  = $access_token;
		$params['oauth_consumer_key'] = $appID;
		$params['openid'] 	  		  = $openid;
		return $this->userInfoURL() . "?" . http_build_query($params);
	}	
	
	//获取用户openID的值的URL(1)(2)
	function getOpenIDURL( $access_token ){
		$params['access_token'] = $access_token;
		return $this->openIDURL() . "?" . http_build_query($params);
	}	
	
	//获取code的值的URL(1)
	function authorizeURL() { return 'https://graph.qq.com/oauth2.0/authorize'; }
	
	//获取access_token的值的URL(1)
	function accessTokenURL() { return 'https://graph.qq.com/oauth2.0/token'; }
	
	//获取用户openID的值的URL(1)
	function openIDURL() { return 'https://graph.qq.com/oauth2.0/me'; }	
	
	//获取qq用户的个人资料的URL(1)
	function userInfoURL() { return 'https://graph.qq.com/user/get_user_info'; }
	
	//获取access_token的值的URL(3)
	function getAccessTokenData( $code , $url ) { 
		$url = $this->getAccessTokenURL( $code , $url );
		return file_get_contents($url);exit;	 
	}
	
	//获取用户openID的值的URL(3)
	function getOpenIDData( $access_token) { 
		$url = $this->getOpenIDURL( $access_token );
		return file_get_contents($url);exit;	 
	}	
	
	//获取qq用户的个人资料的URL(3)
	function getuserInfoData( $access_token, $appID, $openid ) { 
		$url = $this->getUserInfoURL( $access_token, $appID, $openid );
		return file_get_contents($url);exit;	 
	}	



}