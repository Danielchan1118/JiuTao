<?php 
/**
 * 登陆管理接口
 * 完善资料
 * 验证邮箱
 * 进入应用
 */
 class AppLogin{
	/**
	 * 用户首次登陆判断
	 */
    public function index($user_eara = array(),$post_data = array()){
		//exit;
    	$mobilephonetype = trim($post_data['mobilephonetype']);
    	$mobilewidth 	 = intval($post_data['mobilewidth']);
    	$mobileheight 	 = intval($post_data['mobileheight']); 
        $Bluetooth_id 	 = trim($post_data['Bluetooth_id']);
		$Mpverinfor 	 = trim($post_data['Mpverinfor']);
        $Mphonemodels 	 = trim($post_data['Mphonemodels']);
        $ProvidersName 	 = trim($post_data['ProvidersName']);
		$promotionuser 	 = trim($post_data['promotionuser']);
		$uid 			 = trim($post_data['uid']);
		$from_where 	 = intval($post_data['type']);

        $email 			 = trim($post_data['email']);
        $password 		 = trim($post_data['password']);
	
    	if($mobilephonetype && $mobilewidth && $mobileheight && $Bluetooth_id){
			$newas = substr($user_eara,0,strrpos($user_eara,'省'));
			$pros  = M("citys");
			$newa  = substr($user_eara,0,strrpos($user_eara,'市'));
		
			if(!$newa){
				$newa = substr($user_eara,0,strrpos($user_eara,'州'));
				if(!$newa){
					$newa = substr($user_eara,0,strrpos($user_eara,'县'));
					if(!$newa){
						$newa = $user_eara;
					}
				}else{
					$newa = substr($newa,strlen($newas)+3);
				}
			}else{
				$newa = substr($newa,strlen($newas)+3);
			}

			$zone_id = $pros->where("city_name like '%".$newa."%'")->getfield("cid");
			if($zone_id){
				$data['cityid'] = $zone_id;
			}
			
			$usreip   =  $_SERVER['REMOTE_ADDR'];
            $User 	  = M("users");
    		$userinfo = $User->field("stauts,username,nickname,level,goldcount")->where("mobilephonetype='".$mobilephonetype."' and mobilewidth=".$mobilewidth." and mobileheight=".$mobileheight." and Bluetooth_id='".$Bluetooth_id."'")->find();
			
			if($userinfo['username']){
				//更新积分,积分墙同步
				$mem  = M('member'); 
				$memScore = $mem->where("username='".$uid."' AND from_where='".$from_where."'")->getField('score');
				$newScore  = intval(intval($memScore)+intval($userinfo['goldcount']));

				$datas['username'] = $userinfo['username'];
				$datas['nickname'] = $userinfo['nickname'];
				$datas['goldcount'] = $newScore;
				$datas['res'] = 1;
				$datas['level'] = $userinfo['level'];
				$datas['levelglod'] = 10000;
				
                setcookie("userid",$userinfo['username']);
    		}else{
    			$username = $User->order("username desc")->getfield("username");
				
	    		if($username){
	    			$data['username'] = intval($username)+1;
	    		}else{
	    			$data['username'] = 10000000;
	    		}
				
	    		$data['mobilephonetype'] = trim($mobilephonetype);
	    		$data['mobilewidth'] 	 = $mobilewidth;
	    		$data['mobileheight'] 	 = $mobileheight;
                $data['Bluetooth_id'] 	 = $Bluetooth_id;
				$data['Mpverinfor'] 	 = $Mpverinfor;
				$data['Mphonemodels'] 	 = $Mphonemodels;
				$data['ProvidersName'] 	 = $ProvidersName;
                $data['goldcount'] 		 = 10000;
	    		$data['stauts'] 		 = 1;
				$data['level'] 			 = 1;
	    		$data['add_time'] 		 = time(); 
				$data['IP'] 			 = $usreip;
	    		$res = $User->add($data);
				$task = M("taskrecords");
/*				
				$grade = M('grade');
				$gradelist = $grade->field("grade,getglod,integral")->order("grade asc")->select();
				$User->where("username='".$data['username']."'")->setInc( 'goldcount',$gradelist[0]['getglod'] );//升级奖励添加积分
				
				$taskdata['taskname']  = '升级vip'.$gradelist[0]['grade'];
				$taskdata['username']  = $data['username'];
				$taskdata['earn_coin'] = $gradelist[0]['getglod'];
				$taskdata['atr_id']    = 38;
				$taskdata['add_time']  = time();
				$task->add($taskdata);
*/
	    		if($res){					
                    $datas['username']  = $data['username'];
                    $datas['goldcount'] = $data['goldcount'];
					$datas['level'] 	= 1;
					$datas['levelglod'] = 10000;
					$datas['res'] 		= 1;
                    setcookie("userid",$data['username']);
					/*
					//推广成功
					if($promotionuser && $promotionuser!='aaaa' ){
						//判断用户是推广用户
						$prouser = $User->where("username='".$promotionuser."'")->getfield("total_channels");
						if($prouser){
							$subdata['total_channels'] = $promotionuser;
							$subdata['sub_channels'] = $prouser;
						}else{
							$subdata['total_channels'] = $promotionuser;
						}
						//奖励用户推广成功
						$User->where("username='".$promotionuser."'")->setInc("goldcount",20000);
						
						$prodata['taskname'] = "推广".$data['username']."成功";
						$prodata['username'] = $promotionuser;
						$prodata['atr_id'] = 5;
						$prodata['earn_coin'] = 20000;
						$prodata['winning'] = $data['username'];
						$prodata['add_time'] = time();
						$task = M("taskrecords");
						$res = $task->add($prodata);
						
						$invit = M("invitedrecords");
						$indata['username'] = $promotionuser;
						$indata['invited_id'] = $data['username'];
						$indata['reward_coin'] = 20000;
						$indata['add_time'] = time();
						$invit->add($indata);
						
						$User->where("username='".$data['username']."'")->save($subdata);
					}
					*/
	    		}else{
					$datas['res'] 	= -1;
					$datas['error'] = '登陆失败';
				}
    		}
			
			//找游账号绑定旧淘账号
			if( $uid && $from_where ){
				if($userinfo['username']){
					$unionid = $userinfo['username'];
				}else{
					$unionid = $data['username'];
				}				
				$mem = M('member');
				$mem->where("username='".$uid."' AND from_where='".$from_where."'")->setField('unionid',$unionid);
			}else{
				$datas['res'] = -1;
				$datas['error'] = '账号绑定失败';
			}			
    	}
		
		$datas['zone_id'] = $zone_id;
		return json_encode($datas);
    }

    /**
     * 完善资料
     * 1.资料完善成功 2.完善失败 3.之前已完善
     */
    public function PerfectInfo($user_eara,$datas = array()){
        $email = trim($datas['email']);
        $password = trim($datas['password']);
        $mobilephone = trim($datas['mobilephone']);
        $nickname = trim($datas['nickname']);
        $weixin_id = trim($datas['weixin_id']);
        $username = trim($datas['username']);
        $arr = array();
        if($email && $password && $mobilephone && $nickname && $username && $weixin_id){
            $User = M("users");
			
			$stauts = $User->where("username = '".$username."'")->getfield("stauts");

			if($stauts != 3){
				$is_email = $User->where("email='".$email."'")->count();
				$is_nickname = $User->where("nickname='".$nickname."'")->count();
	
				if(!preg_match("/^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}$/",$email)){
					$arr['res'] = 10;
					$arr['error'] = '邮箱验证失败';
				}else if(!preg_match("/^0?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/",$mobilephone)){
					$arr['res'] = 5;
					$arr['error'] = '手机验证失败';
				}else if($is_email > 0){
					$arr['res'] = 3;
					$arr['error'] = '邮箱已存在';
				}else if($is_nickname > 0){
					$arr['res'] = 6;
					$arr['error'] = '昵称已存在';
				}else{
					$data['email'] = $email;
					$data['password'] = $password;
					$data['mobilephone'] = $mobilephone;
					$data['nickname'] = $nickname;
					$data['weixin_id'] = $weixin_id;
					$data['stauts'] = 3;
					$res = $User->where("username = '".$username."'")->save($data);

					if($res){
						$arr['res'] = 1;
						$arr['nickname'] = $nickname;
						
						//打包推广包
						$apk = new \Think\ApkRepack("/Public/Uploads/Apk/91zhaoyou.apk",  "/Public/Uploads/Apk/extension/".$username.".apk" );
						$apk->makeApkByUid( $username );
						
					}else{
						$arr['res'] = -1;
						$arr['error'] = '资料完善失败';
					}
				}
			}else if($stauts == 3){
				$arr['res'] = 7;
				$arr['error'] = '你已完善资料了';
			}
        }else{
			$arr['res'] = -2;
			$arr['error'] = '数据出错';
		}
		return json_encode($arr);
    }

    /**
     * 验证邮箱,验证是否完善资料,验证昵称
     */
    public function checkemail($user_eara,$datas = array()){
        $email = trim($datas['email']);
        $username = trim($datas['username']);
		$nickname = trim($datas['nickname']);
        $User = M("users");

        if($username && $email){
			if (! preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/",$email)) {
				$arr['res'] = -1;
				$arr['error'] = '邮箱格式错误';
			}else{
				$count = $User->where("email='".$email."'")->count();

				if($count > 0){
					$arr['res'] = -2;
					$arr['error'] = '邮箱已存在';
				}else{
					$arr['res'] = 1;
				}
			} 
        }else if($nickname){
			$is_nickname = $User->where("nickname='".$nickname."'")->count();
			if($is_nickname > 0){
				$arr['res'] = -2;
				$arr['error'] = '昵称已存在';
			}else{
				$arr['res'] = 1;
			}
		}else if($username){
			$stauts = $User->where("username='".$username."'")->getfield("stauts");
			if($stauts == 3){
                $arr['res'] = 3;
				$arr['error'] = '您已完善资料';
            }else{
				$arr['res'] = -1;
				$arr['error'] = '用户还没完善资料';
			}
		}else{
			$arr['res'] = -1;
			$arr['error'] = '提交数据出错';
		}
		return json_encode($arr);
    }

    /**
     * 验证是否有用户
     */
    public function is_username($user_eara,$datas = array()){
        $mobilephonetype = trim($datas['mobilephonetype']);
        $mobilewidth = intval($datas['mobilewidth']);
        $mobileheight = intval($datas['mobileheight']); 
        $Bluetooth_id = trim($datas['Bluetooth_id']);

        if($mobilephonetype && $mobilewidth && $mobileheight && $Bluetooth_id){
            $User = M("users");
            $count = $User->where("mobilephonetype='".$mobilephonetype."' and mobilewidth=".$mobilewidth." and mobileheight=".$mobileheight." and Bluetooth_id='".$Bluetooth_id."'")->count();
            if($count){
                echo 1;
            }else{
                echo 0;
            }
        }
    }
 }
 
 ?>