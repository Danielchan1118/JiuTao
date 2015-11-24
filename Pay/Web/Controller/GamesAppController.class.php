<?php 
/**    
 * @name 小游戏集锦
 * @author DanielChan
 */   

namespace Web\Controller; 
class GamesAppController extends WebController{
	/**    
	 * @name 小游戏列表
	 */  
	public function index(){       
		//ob_clean(); ob_start();
		//appList
		#code ...
		
	}

	/**    
	 * @name 单个游戏
	 */
	public function gameSingle(){
		$username = trim($_GET['user_name']);
		$this->username = $username;
	
		/*
		$user = array(10000104,10000001,10000107,10000109,10000093);
		if(in_array( $username,$user)){
			$this->display('GamesApp/yibihua/index');
		}else{
			$this->DaZhuanPanTest();
			exit;
		}
		*/
		
		$this->display('GamesApp/yibihua/index');

	}
	
	/**    
	 * @name json消耗淘币入库
	 */
	public function gameJson(){
		$tas = M('taskrecords');
		$user = M('users');		
		$username = intval(trim($_GET['username']));
	
		//检测玩家是否存在
		$is_on = $user->where("username='".$username."'")->getField('username');		
		if($is_on){
			$startTime = strtotime(date('Y-m-d',time()).' 00:00:00');
			$endTime   = strtotime(date('Y-m-d',time()).' 23:59:59');
			//检测玩家已玩几次 
			$count = $tas->where("username='".$username."' AND add_time between '".$startTime."' and '".$endTime."' AND atr_id=37 AND is_sign=3")->count();
			$golds = $user->where("username='".$username."'")->getField('goldcount');

			if( $golds < 10000 ){
				$arr['res'] = 1;
				$arr['msg'] = '淘币不足,请多做任务赚取淘币！';
				$this->ajaxReturn($arr);exit;
			}

			if( $count >= 3)
			{	
				$arr['res'] = 1;
				$arr['msg'] = "今日游戏次数已到,请明天再来！";
				$this->ajaxReturn($arr);exit;
			}
			
			$data['atr_id']    = 37;
			$data['add_time']  = time();
			$data['is_sign']   = 3;
			$data['taskname']  = '一笔画';
			$data['winning']   = '消费1W淘币';
			$data['earn_coin'] = (-10000);
			$data['username']  = $username;
			$result = $tas->add($data);
			$res = $user->where("username='".$username."'")->setInc('goldcount',$data['earn_coin']);
			if($res){
				$arr['res'] = 0;
				$arr['msg'] = '';
			}else{
				$arr['res'] = -1;
				$arr['msg'] = '非法操作';//系统故障
			}
		}else{
			$arr['res'] = -1;
			$arr['msg'] = '该用户不存在';
		}

		$this->ajaxReturn($arr);exit;
	}
	
	/**    
	 * @name json奖励淘币入库
	 */
	public function gameGotCoin(){
		$tas = M('taskrecords');
		$user = M('users');		
		$username = intval(trim($_GET['username']));
		$startTime = strtotime(date('Y-m-d',time()).' 00:00:00');
		$endTime   = strtotime(date('Y-m-d',time()).' 23:59:59');
		//检测玩家已玩几次 
		$payCount = $tas->where("username='".$username."' AND add_time between '".$startTime."' and '".$endTime."' AND atr_id=37  AND is_sign=3")->count();
		$gotCount = $tas->where("username='".$username."' AND add_time between '".$startTime."' and '".$endTime."' AND atr_id=37  AND is_sign=4")->count();
		//检测玩家是否存在
		$is_on = $user->where("username='".$username."'")->getField('username');
		if($is_on){
			if( $payCount >= $gotCount && $gotCount <=3 ){
				$data['atr_id']    = 37;
				$data['is_sign']   = 4;
				$data['add_time']  = time();
				$data['taskname']  = '一笔画';
				$data['winning']   = '赚取20000淘币';
				$data['earn_coin'] = 20000;
				$data['username']  = $username;
				$result = $tas->add($data);
				$res1 = $user->where("username='".$username."'")->setInc('usablegold',$data['earn_coin']);//成长值
				$res = $user->where("username='".$username."'")->setInc('goldcount',$data['earn_coin']);
				if( $res && $res1 ){
					$arr['res'] = 1;
					$arr['msg'] = '您已赚取2W淘币,是否继续游戏？';
				}else{
					$arr['res'] = -1;
					$arr['msg'] = '非法操作';//系统故障
				}
			}else{
				$arr['res'] = -1;
				$arr['msg'] = '非法操作';
			}
		}else{
			$arr['res'] = -1;
			$arr['msg'] = '该用户不存在';
		}

		$this->ajaxReturn($arr);exit;
	}
  

}
?>












