<?php 
/**
 * 应用更新,删除
 * 用户记录添加更新
 */
 class DelUpdates{
	/**
	 * 应用删除，添加及时更新
	 */
	public function DelUpDate($user_eara = '', $datas = array()){
		$times = $datas['times'];
		
		if($times > 0){
			$type = intval($datas['type']);
		
			$where = "w.add_time > ".$times;
			if($type == 0){
				$where.=' and u.is_tj = 1';
				$types =' and u.is_tj = 1';
			}else if($type == 1){
				$where.=' and u.app_type = '.$type;
				$types =' and u.app_type = '.$type;
			}else if($type == 2){
				$where.=' and u.app_type = '.$type;
				$types =' and u.app_type = '.$type;
			}

			$newa = substr($user_eara,0,strrpos($user_eara,'省'));
			$pros = M("pros");
			if(!$newa){
				$newa = substr($user_eara,0,strrpos($user_eara,'市'));
				if(!$newa){
					$newa = substr($user_eara,0,strrpos($user_eara,'州'));
					if(!$newa){
						$newa = substr($user_eara,0,strrpos($user_eara,'县'));
						if(!$newa){
							$newa = $user_eara;
						}
					}
				}
			}
			
			$zone_id = $pros->where("city_name like '%".$newa."%'")->getfield("invisible_throwid");
			if($zone_id){
				$zone = " and u.id not in ".$zone_id;
				$zones = " and u.id not in ".$zone_id;
			}
			
			$del = M("delapp");
			$add = M("app");
			$list = array();
			$del_list = $del->field("app_id")->where("delete_time > ".$times)->select();

			$add_list = $add->table(PREFIX.'app u')
					  ->join(PREFIX.'throw as w on w.app_id = u.id')
					  ->field('w.id as tid,u.id,u.app_explain,u.app_name,u.app_cover,u.app_integral')
					  ->where($where." and u.stauts = 1 and u.is_throw = 2".$zone)
					  ->order("u.order_id asc,u.app_downloadnum desc")
					  ->select();
			
			if(count($add_list)>0){
				$applist = $add->table(PREFIX.'app u')
					  ->join(PREFIX.'throw as w on w.app_id = u.id')
					  ->field('u.id')
					  ->where("u.stauts = 1 and u.is_throw = 2 ".$types.$zones)
					  ->order("u.order_id asc,u.app_downloadnum desc")
					  ->select();
				$p = 1;
				foreach ($applist as $key => $value) {
					$applist[$key]['cid'] = $p;
					$p++;
				}	
				
				foreach($add_list as $k=>$v){
					foreach ($applist as $key => $value) {
						if($v['id'] == $value['id']){
							$add_list[$k]['cid'] = $value['cid'];
						}
					}	
				}
			}

			$list['times'] = time();

			if($del_list && count($add_list)>0){
				$list['del_list'] = $del_list;
				$list['add_list'] = $add_list;
				$list['type'] = 4;
				return json_encode($list);
				exit;
			}
			
			if($del_list){
				$list['del_list'] = $del_list;
				$list['type'] = 2;
				return json_encode($list);
				exit;
			}
			
			if(count($add_list)>0){
				$list['add_list'] = $add_list;
				$list['type'] = 3;
				return json_encode($list);
				exit;
			}
			
			if(!$del_list && count($add_list) == 0){
				$list['type'] = 1;
				return json_encode($list);
				exit;
			}
			
			return json_encode($list);
		}
	}
	
	/**
	 * 用户记录添加及时更新
	 */
	public function UserRecord($datas = array()){
		$username = $datas['username'];
		$times = $datas['times'];
		$task_type = $datas['task_type'];
		
		if($username && $task_type && $times){
		
			switch($task_type){
				case 'task':
					$M = M('taskrecords');
					$record = $M->table(PREFIX.'taskrecords u')
							  ->join(PREFIX.'activity_taskrule as w on u.atr_id = w.atr_id')
							  ->field('u.id,u.username,u.earn_coin,u.add_time,w.atr_name')
							  ->where("u.username='".$username."' and u.add_time>".$times)
							  ->order("u.add_time desc")
							  ->select();
				break;
				case 'convert':
					$M = M('convertrecords');
					$record = $M->table(PREFIX.'convertrecords u')
							  ->join(PREFIX.'convert as w on w.id = u.convert_id')
							  ->field('u.id,u.username,u.add_time,u.status,w.convert_name')
							  ->where("u.username='".$username."' and u.add_time>".$times)
							  ->order("u.add_time desc")
							  ->select();
				break;
				case 'invite':
					$M = M('invitedrecords');
					$record = $M->table(PREFIX.'invitedrecords u')
							  ->join(PREFIX.'activity_taskrule as w on w.id = u.invited_id')
							  ->field('u.id,u.username,u.invited_id,u.add_time,u.realtime_coin,u.reward_coin,w.atr_name')
							  ->where("u.username='".$username."' and u.add_time>".$times)
							  ->order("u.add_time desc")
							  ->select();
				break;
			}

			if($record){
				$arr = $record;
			}else{
				$arr['res'] = -2;
				$arr['error'] = '数据为空';
			}
			
		}else{
			$arr['res'] = -1;
			$arr['error'] = '数据出错';
		}
		return json_encode($arr);
	
	}
	
 }
 ?>