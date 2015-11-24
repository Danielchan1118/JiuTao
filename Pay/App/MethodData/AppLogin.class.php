<?php 
 /**
 * @name 登陆管理接口
 * @author DanielChan
 */
 class AppLogin{
	/**
	 * 用户首次登陆判断
	 */
    public function index($post_data = array()){
		$m = M('member');		
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
		
		if( 3 != $from_where){
			$username = trim( $post_data['uid'] );			
		}else{
			if( trim($post_data['unionid']) ){
				$memUsername = $m->where("username='".$post_data['uid']."' AND from_where='3'")->getField('username');
				if( $memUsername ){
					$arr['username'] = trim( trim($post_data['unionid']) );
					$m->where("username='".$post_data['uid']."' AND from_where='3'")->save($arr);
				}else{
					$username = trim( trim($post_data['unionid']) );
				}				
			}else{
				$username = trim( $post_data['uid'] );
			}
		}
		
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
		return json_encode($res);
    }
	
    
 }
 
 ?>