<?php 
/**
 * 平台管理接口
 * 平台列表
 * 平台活动操作
 */
 class PlatformActivity{
	/**
	 * 平台活动列表
	 */
	public function TaskList($datas = array(), $arr = array()){
		$num = intval($datas['num']);
		$atr = M('activity_taskrule');
		if($num == 0){
			$atrList = $atr->field('atr_id,atr_name,atr_toscore,img_url,intentid')->where('is_on=1 and isdefault=1')->select();
		}else{
			$atrList = $atr->field('atr_id,atr_name,atr_toscore,img_url,intentid')->where('is_on=1')->select();
		}
		
		if($atrList){
			$arr = $atrList;
		}else{
			$arr['res'] = -1;
		}
		foreach($arr as $k=>$v){
			if($arr[$k]['atr_toscore']>0){
				$arr[$k]['atr_toscore'] = "+".$arr[$k]['atr_toscore'];
			}
		}

		return json_encode($arr);
	}
	/**
	 * 摇一摇和签到
	 * @username 用户名
	 * @atr_id   活动ID
	 * @sign_type 签到类型
	 * @sign_type = 1 普通签到 sign_type = 5 分享的签到  sign_type = 3 分享
	 * 返回值: 1.签到成功并给予积分 2.重复签到 4.分享成功 5.分享签到成功 6.重复分享 7.重复操作
	 */
	public function ActivityData($datas = array(), $arrinfos = array()){
		date_default_timezone_set('prc');
		$username = htmlspecialchars($datas['username']);
        $atr_id = intval($datas['atr_id']);
		$sign_type = intval($datas['sign_type']);
		$arr = array();
        if($username && $atr_id>0){
            $starttime = strtotime(date("Y-m-d ",time())."00:00:00");
            $endtime = time();
			$user = M('users');
            $task = M("taskrecords");
            $count = $task->where("username = '".$username."' and add_time between ".$starttime." and ".$endtime." and atr_id=".$atr_id)->count();

            if($sign_type == 3 && $count>0){
				$res = $task->where("username = '".$username."' and add_time between ".$starttime." and ".$endtime." and atr_id=".$atr_id." and is_sign =1")->count();

				if($res > 0){
					$arr['res'] = 7;
					$arr['error'] = "您已经分享";
				}else if($res == 0){
					$data['is_sign'] = 1;
					$atr_toscore = 1000;
				}
			}else if($sign_type == 5 && $count >0){
				$arr['res'] = 6;
				$arr['error'] = "您签到,请分享!";
			}else if($count > 0){
                $arr['res'] = 2;
				$arr['error'] = "您今天已经完成了此活动！";
            }else{
                $activity = M("activity_taskrule");
				if($atr_id == 19){
					$score = "data1";
				}else{
					$score = "atr_toscore";
				}
                $atr_toscore = $activity->where("atr_id=".$atr_id." and is_on=1")->getfield($score);
				
				if($sign_type > 0){
					$atr_toscore = intval($atr_toscore);
				}else{
					$inter = explode(",",$atr_toscore);
					$i=rand(0,count($inter)-1);
					$atr_toscore = intval($inter[$i]);
				}
            }
	
			if($atr_toscore > 0){
				/**连续签到满15天,奖励一万 **/
				if($sign_type > 0){
					$times = date('Y-m-d',time());
					$start_time = strtotime($times) - 14 * 24 * 60 * 60;
					$end_time = strtotime($times." 23:59:59") - 24*60*60;
					$lxsign = $task->where("username = '".$username."' and add_time between ".$start_time." and ".$end_time." and atr_id=".$atr_id." and is_sign=1")->count();
					if($lxsign == 14){
						$atr_toscore = $atr_toscore + 10000;
					}
					$data['taskname'] = "签到";
				}else{
					$data['taskname'] = "摇一摇";
				}
				
				$data['username'] = $username;
				$data['atr_id'] = $atr_id;
				$data['earn_coin'] = $atr_toscore;
				$data['add_time'] = time();
				$res = $task->add($data);
				
				if($res){
					$user->where("username='".$username."'")->setInc('goldcount',$atr_toscore);
					$user->where("username='".$username."'")->setInc('taskgold',$atr_toscore);
					$user->where("username='".$username."'")->setInc('usablegold',$atr_toscore);
					$gold = $user->field("goldcount,usablegold")->where("username='".$username."'")->find();
					if($sign_type == 3){
						$arr['res'] = 4;
					}else if($sign_type == 5){
						$arr['res'] = 5;
					}else{
						$arr['res'] = 1;
					}
					
					$arr['integral'] = $atr_toscore;
					$arr['total_integral'] = intval($gold['goldcount']);
					
					/** 判断用户是否升级VIP **/
/*					if($arrinfos['nowintegral'] <= $gold['usablegold'] && $arrinfos['integral'] > $gold['usablegold']){
						$userdata['level'] = intval($arrinfos['level']);
						$userdata['goldcount'] = $arr['total_integral'] + $arrinfos['getglod'];
						$user->where("username='".$username."'")->save($userdata);
						
						$taskdata['taskname'] = '升级vip'.$arrinfos['level'];
						$taskdata['username'] = $username;
						$taskdata['earn_coin'] = $arrinfos['getglod'];
						$taskdata['atr_id'] = 38;
						$taskdata['add_time'] = time();
						$res = $task->add($taskdata);
					}
*/					
				}else{
					$arr['res'] = '-1';
				}
			}else if(!$arr['res']){
				$arr['res'] = 7;
			}
        }else{
			$arr['res'] = '-2';
		}   
		
		return json_encode($arr);
	}
	/**
	 * 竞猜
	 */
	public function Quiz($datas = array(), $arr = array()){
		date_default_timezone_set('prc');
        $username = trim($datas['username']);
        $atr_id = intval($datas['atr_id']);
        $integral = intval($datas['integral']);
        $num = intval($datas['num']); 
		$arr = array();
        if($username && $atr_id>0 && $integral>=10000 && $num>0 && $num<10){
            $q = M("quiz");
            //限制用户投注时间段
            $starttime = strtotime(date("Y-m-d",time())."00:00:00");
            $endtime = strtotime(date("Y-m-d",time())."17:59:59");
            $stauts = $q->where("username='".$username."' and add_time between ".$starttime." and ".$endtime)->getfield("stauts");

            if($stauts == 1 || time()>$endtime){
                $arr['res'] = 3;
				return json_encode($arr);
                exit;
            }else{
                //查询积分是否超过1万
                $user = M("users");
                $points  = $user->where("username='".$username."' and goldcount > 10000 ")->getfield("goldcount"); 
            }
            
            if($points >= $integral){
                //减去用户押注积分
                $res = $user->where("username='".$username."'")->setDec("goldcount",$integral);
            }

            if($res){
                $data['username'] = $username;
                $data['atr_id'] = $atr_id;
                $data['num'] = $num;
                $data['integral'] = $integral;
                $data['add_time'] = time();
                $re = $q->add($data);
                if($re){
                    $arr['res'] = 1;
					$arr['total_integral'] = $points-$integral;
                }else{
                    $arr['res'] = -1;
                }
            }else{
				$arr['res'] = -2;
			}
        }else{
            $arr['res'] = -3;
        }
		return json_encode($arr);
    }
	/**
	 * 竞猜中奖列表
	 */
	public function QuizList($datas = array(), $arr = array()){
		$q = M('quiz');
		$quiz_list = $q->where("stauts = 3")->select();
		return json_encode($quiz_list);
	}

	
 }
 
 ?>