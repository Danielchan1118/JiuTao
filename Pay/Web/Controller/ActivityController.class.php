<?php
/**
 * 平台活动控制器
 * @author danielchan
 */
namespace Web\Controller;
class ActivityController extends WebController {
    
    /**
     * 大转盘
     */
    public function bigWheel(){
        header("Content-type: text/html; charset=utf-8"); 
        //判断玩家等级，vip3以下不能玩
        $username = trim($_GET['username']);
		
        $user = M("users");  
        $level = $user->where("username='".$username."'")->getField('level');//查询用户等级
        if(empty($level)){ $resStr['error'] = "nameWrong";
            echo "<script type='text/javascript'>alert('用户名错误！')</script>";
            exit;
        }
        if( 3 > $level ){ 
            echo "<script type='text/javascript'>alert('您VIP等级不足，请努力多做任务赚取淘币提升VIP等级！')</script>";
            exit;
        }
        $this->username = $username;
        $this->display();
    }

    //json返回值并入库
    public function dataWheel(){
        $username = trim($_GET['username']);
        $date = date("Y-m-d");
        $startTime = strtotime($data." 00:00:00");
        $endTime = strtotime($data." 23:59:59");
        $wheel_logs = M("activity_wheel_logs");
        $user = M("users");  
        $level = $user->where("username='".$username."'")->getField('level');//查询用户等级
        if(empty($level)){ $resStr['error'] = "nameWrong";
            $resStr['str'] = "用户名错误！";
            $this->ajaxReturn($resStr);exit;
        }
        if( 3 > $level ){ 
            $resStr['error'] = "levelNotEnough";
            $resStr['str'] = "您VIP等级不足，请努力多做任务赚取淘币提升VIP等级！";
            $this->ajaxReturn($resStr);exit;
        }

        $logs['username'] = $username;
        $logs['add_time'] = array('between',array($startTime,$endTime));
        $count = $wheel_logs->where($logs)->count();//查询用户当前转盘数
        if( (3 == $level && 1 <= $count) || (4 == $level && 2 <= $count) || (5 == $level && 3 <= $count) ){
            $resStr['error'] = "invalid";
            $resStr['str'] = "您今天抽奖次数已到,请明天再来！";
            $this->ajaxReturn($resStr);exit;
        }  
        
        $coin = 1000;//每次扣多少积分，后台可控制，功能未做
        $user_gold = $user->where("username='".$username."'")->getField('goldcount');//查询当前金币数
        if( $user_gold > $coin ){
            $res = $user->where("username='".$username."'")->setDec('goldcount',$coin);
            if($res){
                $wheel = M("activity_wheel");
                $prize_arr = $wheel->select();
                foreach ($prize_arr as $key => $val) {   
                    $arr[$val['wheel_id']] = $val['wheel_v'];   
                }   
                $rid = $this->get_rand($arr); //根据概率获取奖项id                  
                $nowCoin = $prize_arr[$rid-1]['wheel_coin']; //应得积分
                $winning = $prize_arr[$rid-1]['wheel_name']; //中奖项返回的栏目名
                if( 0 >= $nowCoin ){
                    $resStr['success'] = false;
                }else{
                    $resStr['prizetype'] = $prize_arr[$rid-1]['num_return']; //中奖项返回的下标
                    $resStr['success'] = true;
                }
                $user->where("username='".$username."'")->setInc('goldcount',$nowCoin);
                $user->where("username='".$username."'")->setInc('usablegold',$nowCoin);
                //大转盘用户记录入库
                unset($arr);
                $arr['winning'] = $winning;
                $arr['username'] = $username;
                $arr['coin'] = $nowCoin;
                $arr['add_time'] = time();
                $wheel_logs->add($arr);
              
                /** 判断用户是否升级VIP **/
/*              $arrinfos = $this->IsLevel($username);
                $usablegold = $user->where("username='".$username."'")->getField('usablegold');//查询当前金币数
                if($arrinfos['nowintegral'] <= $usablegold && $arrinfos['integral'] > $usablegold){
                    $userdata['level'] = intval($arrinfos['level']);
                    $userdata['goldcount'] = $arr['total_integral'] + $arrinfos['getglod'];
                    $user->where("username='".$username."'")->save($userdata);
                    
                    $data['taskname'] = '升级vip'.$arrinfos['level'];
                    $data['username'] = $username;
                    $data['earn_coin'] = $arrinfos['getglod'];
                    $data['atr_id'] = 38;
                    $data['add_time'] = time();
                    $task = M("taskrecords");
                    $res = $task->add($data);
                }
*/                
                //入库
                $resStr['str'] = $winning;
                $this->ajaxReturn($resStr);exit;
            }
        }else{
            $resStr['error'] = "coinNotEnough";
            $resStr['str'] = "淘币不足，请努力多做任务赚取淘币！";
            $this->ajaxReturn($resStr);exit;
        }

    }

    /**
     * @name 概率
     *
     */
    public function get_rand($proArr) {   
        $result = '';    
        //概率数组的总概率精度   
        $proSum = array_sum($proArr);    
        //概率数组循环   
        foreach ($proArr as $key => $proCur) {   
            $randNum = mt_rand(1, $proSum);   
            if ($randNum <= $proCur) {   
                $result = $key;   
                break;   
            } else {   
                $proSum -= $proCur;   
            }         
        }   
        unset ($proArr);    
        return $result;   
    } 

	
	/**
	 *猜金币
	 **/
	
	public function GuessGold(){
		header("Content-type: text/html; charset=utf-8"); 
		$M = M('users');
		$task = M('taskrecords');
		$user_name = trim($_GET['user_name']); //手机传参 
		$this->user_name = $user_name;
		$this->url = "/Web/Activity/json_glod";
		$starttime = strtotime( date("Y-m-d",time() ).'00:00:00');
		$endtime = strtotime( date("Y-m-d",time() ).'23:59:59');
		$is_on = $M->where("username=".$user_name)->find();
		if($is_on){
			
			$find_data = $M->field('SUM(goldcount) as goldcounts')->where("username='".$user_name."'")->find();
			$count_integral = $task->field('SUM(earn_coin) as earn_coins')->where("username=".$user_name." and atr_id=39 and is_sign=4 and add_time between ".$starttime." and ".$endtime)->find();
			$count_data = $task->where("username=".$user_name." and atr_id=39 and is_sign=3 and add_time between ".$starttime." and ".$endtime)->count();
			$counts = $task->where("username=".$user_name." and atr_id=39 and is_sign=4 and add_time between ".$starttime." and ".$endtime)->count();
			$this->find_data = $find_data['goldcounts'];//用户总共有多少积分
			$this->earn_coins = intval($count_integral['earn_coins']);//总共奖励多少分
			$this->counts = $counts; //猜中几次 
			$this->count_data = $count_data;//当天猜的次数
			//$user = array(10000104,10000001,10000107,10000109,10000093,10000016);
			//if(in_array( $user_name,$user)){
				$this->display();
			//}else{
			//	$this->DaZhuanPanTest();
			//	exit;
			//}
		}
		
	}
	/**
	 *json 返回
	 */
	public function json_glod(){
		$M = M('users');
        $task = M('taskrecords');
		$username = trim($_GET['username']);
        $data = trim( $_GET['data'] );
		$starttime = strtotime( date("Y-m-d",time() ).'00:00:00');
		$endtime = strtotime( date("Y-m-d",time() ).'23:59:59');	
			if($data!=''){
				$taskdata['taskname'] = "猜淘币";
				$taskdata['username'] = $username;
				$taskdata['atr_id'] = 39;
				$taskdata['add_time'] = time();
				$goldcount = 10000;
				$M->where("username=".$username)->setDec("goldcount",$goldcount);
				$M->where("username=".$username)->setInc("usablegold",$goldcount);
				$taskdata['earn_coin'] = -10000;
				$taskdata['winning'] = "消耗1W淘币";
				$taskdata['is_sign'] = 3;
				$datas['returns'] = '很遗憾，您没猜中,扣除1W淘币!';
				$task->add($taskdata);
				$count_data = $task->where("username=".$username." and atr_id=39 and is_sign=3 and add_time between ".$starttime." and ".$endtime)->count();
				$find_data = $M->field('SUM(goldcount) as goldcounts')->where("username='".$username."'")->find();			
				$datas['find_data'] = $find_data['goldcounts'];
				if($data == 'ok'){
					$goldcount = 20000;
					$M->where("username=".$username)->setInc("goldcount",$goldcount);
					$M->where("username=".$username)->setInc("usablegold",$goldcount);
					$taskdata['earn_coin'] = 20000;
					$taskdata['winning'] = "奖励2W淘币";
					$taskdata['is_sign'] = 4;
					$datas['returns'] = '恭喜，您猜中,奖励2W淘币!';
					$test = $task->add($taskdata);
					
				}
				$data_count = $task->where("username=".$username." and atr_id=39 and is_sign=4 and add_time between ".$starttime." and ".$endtime)->count();
				$count_integral = $task->field('SUM(earn_coin) as earn_coins')->where("username=".$username." and atr_id=39 and is_sign=4 and add_time between ".$starttime." and ".$endtime)->find();
				$datas['data_count'] = $data_count;
				$datas['count_integral'] = intval($count_integral['earn_coins']);
				
			}
			
			$datas['count_data'] = $count_data;
            $this->ajaxReturn($datas); 
	}
	

}
?>