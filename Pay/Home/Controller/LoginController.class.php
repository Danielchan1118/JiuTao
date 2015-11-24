<?php
namespace Home\Controller;
/**
 *	@name 首页模块 
 *
 */
class LoginController extends HomeController {
	
	/**
	 * @name sinaweibo登陆回调地址
	 *
	 */
    public function weibo(){
		include_once( $_SERVER['document_root'].'Pay/Home/weiboLogin/config.php' );
		include_once( $_SERVER['document_root'].'Pay/Home/weiboLogin/saetv2.ex.class.php' );
		$o = new\SaeTOAuthV2( WB_AKEY , WB_SKEY );

		if (isset($_REQUEST['code'])) {
			$keys = array();
			$keys['code'] = $_REQUEST['code'];
			$keys['redirect_uri'] = WB_CALLBACK_URL;
			try {
				$token = $o->getAccessToken( 'code', $keys ) ;
			} catch (OAuthException $e) {
					$this->error('授权失败。',U('Index/index')) ;
				}
		}
		
		if ($token) {
			$_SESSION['token'] = $token['access_token'];
			$c = new\SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token'] );
			$uid_get = $c->get_uid();
			$uid = $uid_get['uid'];
			$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息
			setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
			
			//通用入库
			$data['uid'] 		= $user_message['idstr'];
			$data['nickname'] 	= $user_message['screen_name'];
			$data['headimgurl'] = $user_message['avatar_large'];
			$data['province'] 	= $user_message['province'];
			$data['city'] 		= $user_message['location']; 
			$data['type'] 		= 2;
			if( 'm' == $user_message['gender']){ $data['sex'] = 1; }else{ $data['sex'] = 2; }
		
			$res = $this->write_to_member( $data );	
			if( 1 == $res['res'] ){
				$_SESSION['userinfo'] = array('name'=>$data['nickname'],'head_img_url'=>$data['headimgurl'],'uid'=>$data['uid'],'from_where'=>$data['type']);
				$this->redirect('Index/index');	
			}		
		} else {		
			$this->error('授权失败。',U('Index/index')) ;
		}
    }
	
	/**
	 * 用户首次登陆判断
	 */
    public function write_to_member($post_data = array()){
		
		$username 	 = trim( $post_data['uid'] );
		$nickname	 = trim( $post_data['nickname'] );
		$sex		 = intval( $post_data['sex'] );
		$img_url 	 = trim( $post_data['headimgurl'] );
		$province 	 = trim( $post_data['province'] );
		$city 	 	 = trim( $post_data['city'] );
		$from_where  = intval( $post_data['type'] );
		$ip 		 = $_SERVER['REMOTE_ADDR'];		
		$login_time  = time();
		$lon 		 = trim( $post_data['lon'] );
		$lat 		 = trim( $post_data['lat'] );
		
		$m = M('member');	
		if( $username && $from_where ){			
			$info = $m->where("username='".$username."' AND from_where='".$from_where."'")->find();
			if($info){ 
				$data['nickname'] 	 = $nickname;
				$data['sex'] 		 = $sex;			
				$data['province'] 	 = $province;
				$data['city'] 		 = $city;
				$data['img_url'] 	 = $img_url;			
				$data['login_ip'] 	 = $ip;
				$data['login_time']  = $login_time;
				$data['lon']  		 = $lon;
				$data['lat']  		 = $lat;
				$result = $m->where("username='".$username."' AND from_where='".$from_where."'")->save($data);				
			}else{
				$data['username'] 	 = $username;
				$data['nickname'] 	 = $nickname;
				$data['sex'] 		 = $sex;
				$data['qq'] 		 = '';
				$data['mobiephone']  = '';
				$data['pay_address'] = '';				
				$data['province'] 	 = $province;
				$data['city'] 		 = $city;
				$data['img_url'] 	 = $img_url;
				$data['score'] 		 = 0;
				$data['from_where']	 = $from_where;				
				$data['reg_ip'] 	 = $ip;
				$data['login_ip'] 	 = $ip;
				$data['reg_time'] 	 = time();
				$data['login_time']  = $login_time;
				$data['lon']  		 = $lon;
				$data['lat']  		 = $lat;				
				$result = $m->add($data);
			}	
			if($result){
				$res['res'] = SUCCESS;
				$res['msg'] = '登陆成功';
			}else{
				$res['res'] = ERROR;
				$res['msg'] = '登陆失败';
			}
		}else{
			$res['res'] = ERROR;
			$res['msg'] = '无此用户';
		}
		return $res;
		
    }		
	
	/**
	 * @name sina微博登陆
	 */
	public function weiboLogin(){
		//新浪微博授权登陆地址
		include_once( $_SERVER['document_root'].'Pay/Home/weiboLogin/config.php' );
		include_once( $_SERVER['document_root'].'Pay/Home/weiboLogin/saetv2.ex.class.php' );
		$o = new\SaeTOAuthV2( WB_AKEY , WB_SKEY );		
		$url = $o->getAuthorizeURL( WB_CALLBACK_URL );
		header("location:".$url);exit;
	
	}
	
	/**
	 * @name wechat登陆回调地址
	 *
	 */
    public function wechatLogin(){
		include_once( $_SERVER['document_root'].'Pay/Home/weChatLogin/config.php' );
		include_once( $_SERVER['document_root'].'Pay/Home/weChatLogin/WXOAuth.class.php' );
		$o = new\WXOAuth( WX_AKEY , WX_SKEY );		
		$code = $_REQUEST['code'];
		$state = $_REQUEST['state'];
		
		if(isset($code)){
			if(isset($state)){
			if( $state == $_SESSION['wechat_state'] ){
					$datas = json_decode($o->getAccessTokenData($code),true);
					if(empty($datas['errcode'])){
						$data1 = json_decode($o->getuserInfoData( $datas['access_token'], $datas['openid'] ),true);
						
						//通用入库
						$data['uid'] 		= $data1['unionid'];//多个平台公用一个ID
						$data['nickname'] 	= $data1['nickname'];
						$data['headimgurl'] = $data1['headimgurl'];
						$data['province'] 	= $data1['province'];
						$data['city'] 		= $data1['city'];
						$data['sex'] 		= $data1['sex']; 			
						$data['type'] 		= 3;

						$res = $this->write_to_member( $data );
						if( 1 == $res['res'] ){
							$_SESSION['userinfo'] = array('name'=>$data['nickname'],'head_img_url'=>$data['headimgurl'],'uid'=>$data['uid'],'from_where'=>$data['type']);
							$this->redirect('Index/index');
						}						
					}else{
						$this->error($datas['errmsg'].'授权失败。',U('Index/index')) ;
					}
				}else{ $this->error('授权失败。',U('Index/index')) ; }
			}else{
				$this->error('授权失败。',U('Index/index')) ;
			}
		}else{
			$this->error('授权失败。',U('Index/index')) ;
		}
    }
	
	/**
	 * @name wechat登陆
	 *
	 */
    public function wechat(){
		include_once( $_SERVER['document_root'].'Pay/Home/weChatLogin/config.php' );
		include_once( $_SERVER['document_root'].'Pay/Home/weChatLogin/WXOAuth.class.php' );
		$o = new\WXOAuth( WX_AKEY , WX_SKEY );		
		$url = $o->getAuthorizeURL( WX_CALLBACK_URL );
		header("location:".$url);exit;		

    }	

	/**
	 * @name qq登陆
	 *
	 */
/*    public function qq(){
		include_once( $_SERVER['document_root'].'Pay/Home/qqLogin/config.php' );		
		include_once( $_SERVER['document_root'].'Pay/Home/qqLogin/qqAuth.class.php' );		
		$o = new\qqAuth( qq_AKEY , qq_SKEY );		
		$url = $o->getAuthorizeURL( qq_CALLBACK_URL );
		header("location:".$url);exit;	
    }
*/
	/**
	 * @name qq登陆回调地址
	 *
	 */
/*	 
    public function qqLogin(){
		include_once( $_SERVER['document_root'].'Pay/Home/qqLogin/config.php' );		
		include_once( $_SERVER['document_root'].'Pay/Home/qqLogin/qqAuth.class.php' );		
		$o = new\qqAuth( qq_AKEY , qq_SKEY );		
		$code = $_REQUEST['code'];
		$state = $_REQUEST['state'];

		if(isset($code)){
			if(isset($state)){
			if( $state == $_SESSION['qq_state'] ){
					$datas =explode('&',$o->getAccessTokenData($code,qq_CALLBACK_URL));//return str
					//str 转换为array
					$strArr = array();
					foreach( $datas as $k => $v){
						$temp = explode('=',$v);
						$datas[$temp[0]] = $temp[1];
					}
					if(isset($datas['access_token'])){
						//获取opendID
						$openID  = $o->getOpenIDData( $datas['access_token'] );
						$lpos 	  = strpos($openID, "(");
						$rpos 	  = strrpos($openID, ")");
						$openID  = substr($openID, $lpos + 1, $rpos - $lpos -1);
						$user 	  = json_decode($openID,true);
						if( isset($user['openid']) && isset($user['client_id']) ){
							//获取用户资料
							$data1 = json_decode($o->getuserInfoData( $datas['access_token'], $user['client_id'], $user['openid'] ),true);						
							if( 0 != $data1['ret'] ){
								$this->error($data1['msg'].'授权失败。',U('Index/index')) ;
							}else{
								//通用入库
								if( '女' == $data1['gender']){ $data['sex'] = 2; }else{ $data['sex'] = 1; }
								$data['uid'] 		= $user['openid'];
								$data['nickname'] 	= $data1['nickname'];
								$data['headimgurl'] = $data1['figureurl_qq_2'];
								$data['province'] 	= $data1['province'];
								$data['city'] 		= $data1['city'];
								$data['sex'] 		= $data1['sex']; 			
								$data['type'] 		= 1;

								$res = $this->write_to_member( $data );
								if( 1 == $res['res'] ){
									$_SESSION['userinfo'] = array('name'=>$data['nickname'],'head_img_url'=>$data['headimgurl'],'uid'=>$data['uid'],'from_where'=>$data['type']);
									$this->redirect('Index/index');
								}	
							}															
						}else{
							$this->error('授权失败。',U('Index/index')) ;
						}					
					}else{
						$this->error('授权失败。',U('Index/index')) ;
					}
				}else{ $this->error('授权失败。',U('Index/index')) ; }
			}else{
				$this->error('授权失败。',U('Index/index')) ;
			}
		}else{
			$this->error('授权失败。',U('Index/index')) ;
		}
		
    }	
*/	
    /**
	 * @name 用户退出
	 *
	 */
	public function loginQuit(){
		session(null);
		cookie(null);
		$this->redirect ( 'Index/index' );	
		exit();
	}

	

}