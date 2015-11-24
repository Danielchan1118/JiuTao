<?php
/**
 * 兑换中心
 */
 class AppConvert{
	/**
	 * 兑换列表
	 */
	public function ConvertList($datas = array()){
		$pid = intval($datas['pid']);
		$where = "is_on = 1";
		if($pid>0){
			$where.= ' and pid='.$pid;
		}else{
			$where.= ' and pid=0';
		}
		$M = M('convert');
		$convert_list = $M->where($where)->field('id,convert_name,tag,image,gold')->order("order_id asc")->select();
	
		if($convert_list){
			$arr = $convert_list;
		}else{
			$arr['ret'] = -1;
		} 
		return json_encode($arr);
	}
	
	/**
	 * @name 兑换提交
	 * @param string $username 积分墙帐号
	 * @param string $uid 旧淘帐号
	 * @param int $type 旧淘号来源路径
	 * @param int $cid 类型:forxam:Q币,QQ会员,支付宝,财富通充值等
	 * @param string $data1 //需要充值的帐号
 	 */
	public function ConvertSubmit($datas = array()){
		$username 	= trim($datas['username']);
		$uid 		= trim($datas['uid']);
		$from_where = trim($datas['type']);
		$cid 		= intval($datas['cid']);
		$data1 		= trim($datas['data1']);

		if($username && $cid && $data1){
			$user = M("users");
			$goldcount = $user->where("username='".$username."'")->getfield("goldcount");//积分帐号积分数 
		
			$convert = M("convert");
			$cinfo = $convert->field("gold,tag,convert_name")->where("id=".$cid)->find();//兑换表单条信息
			$cinter = intval($cinfo['gold'])*10000;//兑换需要多少积分
			$count = intval($goldcount) - $cinter; //相差
			if($count >= 0){
				$res = $user->where("username='".$username."'")->setDec( 'goldcount',$cinter); 
				if($res){
					$data['username'] 	 = $username;
					$data['convert_id']  = $cid;
					$data['userdata'] 	 = $data1;
					$data['expend_coin'] = $cinter;
					$data['convert_get'] = $cinfo['convert_name'];
					$data['status'] 	 = 2;
					$data['tag'] 		 = $cinfo['tag'];
					$data['add_time'] 	 = time();
					$log = M("convertrecords");
					$res1 = $log->add($data);
					if($res1){
						$arr['ret'] = 1;
					}else{
						$arr['ret'] = -1;
					}			
				}else{
					$arr['ret'] = -3;
				}
			}else{
				//当积分墙帐户金币不足时，取旧陶用户积分	
				$mem = M('member');
				$score = $mem->where("username='".$uid."' AND from_where='".$from_where."'")->getField('score');
				$newScore = $goldcount+$score;
				$newCount = $newScore-$cinter;
				if( 0 <= $newCount ){
					$resJF = $user->where("username='".$username."'")->setField( 'goldcount',0);
					$resJT = $mem->where("username='".$uid."' AND from_where='".$from_where."'")->setField('score',$newCount);
					if( $resJF && $resJT ){
						$data['username'] 	 = $username;
						$data['convert_id']  = $cid;
						$data['userdata'] 	 = $data1;
						$data['expend_coin'] = $cinter;
						$data['convert_get'] = $cinfo['convert_name'];
						$data['status'] 	 = 2;
						$data['tag'] 		 = $cinfo['tag'];
						$data['add_time'] 	 = time();
						$log = M("convertrecords");
						$res = $log->add($data);
						if($res){
							$arr['ret'] = 1;
						}else{
							$arr['ret'] = -1;
						}			
					}else{
						$arr['ret'] = -3;
					}					
				}else{
					$arr['ret'] = 2;
				}		
			}
		}else{
			$arr['ret'] = -2;
		}
		return json_encode($arr);
	}
	
 }
 ?>