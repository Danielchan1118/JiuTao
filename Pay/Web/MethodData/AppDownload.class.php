<?php 
/**
 * 平台管理接口
 * 平台列表
 * 平台活动操作
 */
 class AppDownload{
	/**
	 * 已下载的应用
	 */
	public function getDownloadedList($datas = array()){
		$username = trim($datas['username']);
		$down = M("download_record");
		$downlist = $down->table(PREFIX.'download_record r')
					  ->join(PREFIX.'app as a on a.APP_KEY = r.APP_KEY')
					  ->field('a.APP_KEY,a.app_name,a.id,a.app_cover,a.app_integral,a.package_name,r.glod,a.app_explain')
					  ->where("r.username='".$username."' and r.nomove=1 ")
					  ->group("a.app_name")
					  ->order("r.add_time desc")
					  ->select();
	
		if($downlist){
			echo json_encode($downlist);
		}else{
			echo 0;
		}
	}
	
	/**
	 * 应用签到得到积分
	 */
	public function showDownloadedList($datas = array()){
		$username = trim($datas['username']);
		$down = M("download_record");
		
		if(!isset($datas['cid'])){
			$p = 0;
			$n = 100;
		}else{
			$pages = intval($datas['cid']);
			$p = $pages;
			$pages = $pages + 1;
			$n = 4;
		}	
		$downlist = $down->table(PREFIX.'download_record r')
					  ->join('LEFT JOIN '.PREFIX.'app as a on a.APP_KEY = r.APP_KEY')
					  ->field('a.app_name,r.add_time,r.glod,a.id')
					  ->where("r.username='".$username."' and r.glod > 0 ")
					  ->order("r.add_time desc")
					  ->limit($p." , ".$n)
					  ->select();
		if($downlist){
			if($pages > 0){
				foreach ($downlist as $k => $v) {
					$downlist[$k]['cid'] = $pages;
					$pages++;
				}
			}

			echo json_encode($downlist);
		}else{
			echo 'no';
		}
	}
 
	/**
     * 处理下载返回值
     */
    public function DealWith($datas = array(),$arrinfo = array(),$userinfo=array()){
        $mobilephonetype = trim($datas['mobilephonetype']);
        $mobilewidth = intval($datas['mobilewidth']);
        $mobileheight = intval($datas['mobileheight']); 
        $Bluetooth_id = trim($datas['Bluetooth_id']);
        $APP_KEY = trim($datas['APP_KEY']);
        $Mpverinfor = trim($datas['Mpverinfor']);
		$Mphonemodels = trim($datas['Mphonemodels']);
		$ProvidersName = trim($datas['ProvidersName']);
		$Network = trim($datas['Network']);
		
        if($mobilephonetype && $mobilewidth && $mobileheight && $Bluetooth_id && $APP_KEY){
			date_default_timezone_set('prc');
			$users = M("users");
			$down = M("download_record");
			$sign_log = M("sign_log");
			//查询应用信息
			$app = M("app");
			$appinfo = $app->field("did,expend_money,app_name,signdatas")->where("APP_KEY='".$APP_KEY."'")->find();
			
		/*	//获取用户账号
			$users = M("users");
            $userinfo = $users->field("username,goldcount,usablegold,installcount")->where("mobilephonetype='".$mobilephonetype."' and mobilewidth=".$mobilewidth." and mobileheight=".$mobileheight." and Bluetooth_id='".$Bluetooth_id."'")->find(); */
			$username = $userinfo['username'];
			
			//判断用户是否已下载
			$isdown = $down->where("APP_KEY='".$APP_KEY."' and username='".$username."' and nomove = 1")->count();
			
			//查询用户今天是否第一次签到
			$start_time = strtotime(date('Y-m-d',time()));
			$downcount = $down->where("APP_KEY='".$APP_KEY."' and username='".$username."' and is_today_sign = 1 and add_time between ".$start_time." and ".time())->count();
		
			if($downcount == 0 && $isdown >=1 ){//if($downcount == 0 && $isdown == 1){
				$data = array();
				//查询用户是否第一次运行
				$downcount = $down->where("username='".$username."' and APP_KEY='".$APP_KEY."' and move=1")->count();
				
				$sign_list = unserialize($appinfo['signdatas']);
				if($downcount == 0 && $appinfo['did'] > 0 && $username){
/*				
					//扣商家余额
					$sj = M("cooperation_user");
					$re = $sj->where('id='.$appinfo['did'])->setDec( 'money',$appinfo['expend_money'] ); 
	
					//一级推广员奖励20% 二级推广员奖励10%
					$prouser = $users->field("total_channels,sub_channels")->where("username='".$username."'")->find();
					
					//判断推广用户第一次下载记录
					$fristnum = $down->where("username='".$username."' and move=1")->count();
					
					if($prouser){
						$task = M("taskrecords");
						if($prouser['total_channels']){
							$prodata['taskname'] = "一级推广奖励20%";
							$prodata['username'] = $prouser['total_channels'];
							$glods = 0;
							if(intval($fristnum) == 0){
								$glods = 40000;
							}
							$promoney = $sign_list[1]['inter'] * 0.2+$glods; 
							$prodata['atr_id'] = 5;
							$prodata['winning'] = $username;
							$prodata['earn_coin'] = $promoney;
							$prodata['add_time'] = time();
							$res = $task->add($prodata);
							$users->where("username='".$prouser['total_channels']."'")->setInc('goldcount',$promoney);
						}
						
						if($prouser['sub_channels']){
							$subdata['taskname'] = "二级推广奖励10%";
							$subdata['username'] = $prouser['sub_channels'];
							$subdata['winning'] = $username;
							$promoney = $sign_list[1]['inter'] * 0.1; 
							$subdata['atr_id'] = 5;
							$subdata['earn_coin'] = $promoney;
							$subdata['add_time'] = time();
							$res = $task->add($subdata);
							$users->where("username='".$prouser['sub_channels']."'")->setInc('goldcount',$promoney);
						}
					}
*/					
					/** 判断用户是否升级VIP **/
/*					if($arrinfo['nowintegral'] <= $userinfo['usablegold'] && $arrinfo['integral'] > $userinfo['usablegold']){
						$userdata['level'] = intval($arrinfo['level']);
						$userdata['goldcount'] = intval($userinfo['goldcount']) + $arrinfo['getglod'];
						$users->where("username='".$username."'")->save($userdata);

						$taskdata['taskname'] = '升级vip'.$arrinfos['level'];
						$taskdata['username'] = $username;
						$taskdata['earn_coin'] = $arrinfo['getglod'];
						$taskdata['atr_id'] = 38;
						$taskdata['add_time'] = time();
						$task = M("taskrecords");
						$res = $task->add($taskdata);
					}
*/
					$signdata['is_sign_data'] = $sign_list[1]['num'];
					$signdata['Integral'] = $sign_list[1]['inter'];
					$signdata['APP_KEY'] = $APP_KEY;
					$signdata['app_name'] = $appinfo['app_name'];
					$signdata['username'] = $username;
					$signdata['add_time'] = time();
					$sign_log->add($signdata);
			
					//添加用户积分,增加安装量
					$user['goldcount'] = intval($sign_list[1]['inter']+$userinfo['goldcount']);
					$user['installcount'] = $userinfo['installcount']+1;
					$user['usablegold'] = intval($sign_list[1]['inter']+$userinfo['usablegold']);
					$res = $users->where("username='".$username."'")->save($user);
					
					//添加软件安装量
					$app->where("APP_KEY='".$APP_KEY."'")->setInc("installcount",1);
					$data['move'] = 1;
					$data['app_do'] = "激活应用";
					$data['glod'] = $sign_list[1]['inter'];
					$data['app_money'] = $appinfo['expend_money'];
					
				}else{
					//应用签到机制
					$newsign = array();
					if(is_array($sign_list)){
						$i = 1;
						foreach($sign_list as $k=>$v){
							if($v['inter'] >0 ){
								$newsign[$i]['num'] = $v['num'];
								$newsign[$i]['inter'] = $v['inter'];
								$i++;
							}
						}
					}
					if(is_array($newsign)){
						//获取用户已签到的
						$signlog = $sign_log->where("APP_KEY='".$APP_KEY."' && is_sign_data>0 && username='".$username."'")->order("add_time desc")->getfield("is_sign_data");
						$signlog = intval($signlog);
						$signnum = 0;
						if($signlog > 0){
							for($j = 1; $j<=count($newsign);$j++){
								if($signlog == $newsign[$j]['num']){
									$signnum = $j;
								}
							}

							if($signnum > 0){
								//查询用户是否连续签到
								$sign_num = $newsign[$signnum+1]['num']-1;
								$times = date('Y-m-d',time());
								$start_time = strtotime($times) - $sign_num * 24 * 60 * 60;
								$end_time = strtotime($times." 23:59:59") - 24*60*60;
								$sign_count = $down->where("username='".$username."' and is_today_sign = 1 and add_time between ".$start_time." and ".$end_time." and APP_KEY='".$APP_KEY."'")->count();

								if($sign_count>0){
									$count = intval($sign_num) - intval($sign_count);

									if($count == 0){
										//添加用户积分
										$inter = $users->where("username='".$username."'")->setInc( 'goldcount', $newsign[$signnum+1]['inter'] );
										$inter = $users->where("username='".$username."'")->setInc( 'usablegold', $newsign[$signnum+1]['inter'] );
/*										
										//一级推广员奖励20% 二级推广员奖励10%
										$prouser = $users->field("total_channels,sub_channels")->where("username='".$username."'")->find();
										if($prouser){
											$task = M("taskrecords");
											if($prouser['total_channels']){
												$prodata['taskname'] = "一级推广奖励20%";
												$prodata['username'] = $prouser['total_channels'];
												$promoney = $newsign[$signnum+1]['inter'] * 0.2; 
												$prodata['atr_id'] = 5;
												$prodata['winning'] = $username;
												$prodata['earn_coin'] = $promoney;
												$prodata['add_time'] = time();
												$res = $task->add($prodata);
												$users->where("username='".$prouser['total_channels']."'")->setInc('goldcount',$promoney);
											}
											
											if($prouser['sub_channels']){
												$subdata['taskname'] = "二级推广奖励10%";
												$subdata['username'] = $prouser['sub_channels'];
												$subdata['winning'] = $username;
												$promoney = $newsign[$signnum+1]['inter'] * 0.1; 
												$subdata['atr_id'] = 5;
												$subdata['earn_coin'] = $promoney;
												$subdata['add_time'] = time();
												$res = $task->add($subdata);
												$users->where("username='".$prouser['sub_channels']."'")->setInc('goldcount',$promoney);
											}
										}
*/										
										/** 判断用户是否升级VIP **/
/*										$gold = $users->field("goldcount,usablegold")->where("username='".$username."'")->find();
										if($arrinfo['nowintegral'] <= $gold['usablegold'] && $arrinfo['integral'] > $gold['usablegold']){
											$userdata['level'] = intval($arrinfo['level']);
											$userdata['goldcount'] = intval($gold['goldcount']) + $arrinfo['getglod'];
											$users->where("username='".$username."'")->save($userdata);
											
											$taskdata['taskname'] = '升级vip'.$arrinfos['level'];
											$taskdata['username'] = $username;
											$taskdata['earn_coin'] = $arrinfo['getglod'];
											$taskdata['atr_id'] = 38;
											$taskdata['add_time'] = time();
											$task = M("taskrecords");
											$res = $task->add($taskdata);
										}
*/										
										$data['app_do'] = "第".$newsign[$signnum+1]['num']."签到应用";
										$signdata['is_sign_data'] = $newsign[$signnum+1]['num'];
										$signdata['Integral'] = $newsign[$signnum+1]['inter'];
										$data['glod'] = $newsign[$signnum+1]['inter'];
										$signdata['APP_KEY'] = $APP_KEY;
										$signdata['app_name'] = $appinfo['app_name'];
										$signdata['username'] = $username;
										$signdata['add_time'] = time();
										$sign_log->add($signdata);
									}
								}
							}
						}
					}
				}
				
				$data['is_today_sign'] = 1;
			
				//添加应用运行次数
				$app->where("APP_KEY='".$APP_KEY."'")->setInc("app_runnum",1);
				$usreip =  $_SERVER['REMOTE_ADDR'];
				
				$data['IP'] = $usreip;
				$data['did'] = $appinfo['did'];
				$data['username'] = $username;
				$data['app_name'] = $appinfo['app_name'];
				$data['mobiletype'] = $mobilephonetype;
				$data['mobilewidth'] = $mobilewidth;
				$data['mobileheight'] = $mobileheight;
				$data['Bluetooth_id'] = $Bluetooth_id;
				$data['APP_KEY'] = $APP_KEY;
				$data['add_time'] = time();
				$data['Mpverinfor'] = $Mpverinfor;
				$data['Mphonemodels'] = $Mphonemodels;
				$data['ProvidersName'] = $ProvidersName;
				$data['Network'] = $Network;
				$se = $down->add($data);
				
				if($se){
					echo 1;
				}else{
					echo -1;
				}
			}else{
				echo 2;
			}
			
        }else{
			echo -2;
		}
    }

    /**
     * 下载路径
     */
    public function down_url($datas,$arr,$userinfo=array(),$get){
		$app_id = $get['app_id'];
        if($app_id){
            $mobilephonetype = trim($datas['mobilephonetype']);
            $mobilewidth = intval($datas['mobilewidth']);
            $mobileheight = intval($datas['mobileheight']); 
            $Bluetooth_id = trim($datas['Bluetooth_id']);
			$Mpverinfor = trim($datas['Mpverinfor']);
			$Mphonemodels = trim($datas['Mphonemodels']);
			$ProvidersName = trim($datas['ProvidersName']);
			$Network = trim($datas['Network']);
			
            $app = M("app");
			//应用下载次数
			$app->where("id=".$app_id)->setInc("app_downloadnum",1);
			
			$appinfo = $app->field("android_url,app_name,did,APP_KEY")->where("id=".$app_id)->find();
            if($mobilephonetype && $mobilewidth && $mobileheight && $Bluetooth_id && $app_id){
			    //查询用户账号
                $users = M("users");
                $username = $users->where("mobilephonetype='".$mobilephonetype."' and mobilewidth=".$mobilewidth." and mobileheight=".$mobileheight." and Bluetooth_id='".$Bluetooth_id."'")->getfield("username");
                if($username){
                    //添加应用下载次数
					$usreip =  $_SERVER['REMOTE_ADDR'];
					$data['app_do'] = "下载";
					$data['IP'] = $usreip;
                    $data['did'] = $appinfo['did'];
                    $data['username'] = $username;
					$data['app_name'] = $appinfo['app_name'];
					$data['APP_KEY'] = $appinfo['APP_KEY'];
                    $data['mobiletype'] = $mobilephonetype;
                    $data['mobilewidth'] = $mobilewidth;
                    $data['mobileheight'] = $mobileheight;
                    $data['Bluetooth_id'] = $Bluetooth_id;
					$data['Mpverinfor'] = $Mpverinfor;
					$data['Mphonemodels'] = $Mphonemodels;
					$data['ProvidersName'] = $ProvidersName;
					$data['Network'] = $Network;
                    $data['add_time'] = time();
                    $data['nomove'] = 1;
                    $down = M("download_record");
                    $se = $down->add($data);
					exit;
                }
            }
			
			$file_name = substr($appinfo['android_url'],strrpos($appinfo['android_url'],"/")+1);
			$this->ReturnAsDownFile(realpath('.'.$appinfo['android_url']),$file_name);
        }
    }
	/**
	 * 下载路径
	 */
	public function ReturnAsDownFile($filepath, $filename_ret){
		ob_clean();
		ob_start();
		if(!file_exists($filepath)){//判断文件是否存在
			echo "文件不存在";
			exit();
		}
		$size = filesize($filepath);
		$size2 = $size-1;

		$range = 0;
		if(isset($_SERVER['HTTP_RANGE'])) {
			header('HTTP /1.1 206 Partial Content');
			$range = str_replace('=','-',$_SERVER['HTTP_RANGE']);
			$range = explode('-',$range);
			$range = trim($range[1]);
			header('Content-Length: '.intval($size-intval($range)) );
			header('Content-Range: bytes '.$range.'-'.$size2.'/'.$size);
		} else {
			header('Content-Length: '.$size);
			header('Content-Range: bytes 0-'.$size2.'/'.$size);
		}
		header('Content-type: application/octet-stream');
		header('Accenpt-Ranges: bytes');
		header("Cache-control: public");
		header("Pragma: public");
		//解决在IE中下载时中文乱码问题
		$ua = $_SERVER['HTTP_USER_AGENT'];
		if(preg_match('/MSIE/',$ua)) {
			$ie_filename = str_replace('+','%20',urlencode($filename_ret));
			header('Content-Disposition:attachment; filename='.$ie_filename);
		}  else {
			header('Content-Disposition:attachment; filename='.$filename_ret);
		}

		$fp = fopen($filepath,'rb+');
		fseek($fp,$range);
		while(!feof($fp)) {
			set_time_limit(0);
			print(fread($fp,4096));
			flush();
			ob_flush();
		}
		fclose($fp);
		ob_end_flush();
		exit();
	}
	
}
 
 ?>