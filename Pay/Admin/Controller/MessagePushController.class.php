<?php
/**
 * 推送消息控制器
 */
namespace Admin\Controller;
class MessagePushController extends AdminController {
	/**
	 * 消息列表
	 */
	public function MessageList(){
		$mess = M('message');
		$res = $mess->order("add_time desc")->select();
		
		
		//vip等级列表
		$grade = M('grade');
		$vips = $grade->field("id,grade")->order("grade asc")->select();
		
		$this->vips = $vips;
		$this->lists = $res;
		$this->display();
	}

    /**
     * 发送消息
     */
    public function send(){
		$n_title = trim($_POST['title']);
		$n_content = trim($_POST['content']);
		
		if($n_title && $n_content){
			$msg_content = json_encode(array('n_builder_id'=>0, 'n_title'=>$n_title, 'n_content'=>$n_content)); 
			$receiver_value = '';			
			$senduser = intval($_POST['senduser']);
			$vip = intval($_POST['vip']);
			$startglod = intval($_POST['startglod']);
			$endglod = intval($_POST['endglod']);
			
			date_default_timezone_set('prc');
			if($senduser > 0){     //没有签到的用户
				$type = 3;
				$task = M("taskrecords");
				$starttime = strtotime(date("Y-m-d",time()).' 00:00:00');

				$userid = $task->field("username")->where("atr_id = 16 and add_time between ".$starttime." and ".time())->group("username")->select();
				$user_id = '';
				foreach($userid as $k=>$v){
					$user_id.= "'".$v['username']."'";
					if(count($userid)-1 > $k ){
						$user_id .= ",";
					}
				}
				
				$user = M("users");
				$signcount = $user->where("username not in(".$user_id.")")->count();
				$n = intval($signcount['tp_count']/1000);
				if($n<1){
					$n = 1;
				}
				$pages = 0;
				for($i=0; $i<$n; $i++){
					if($pages > 0){
						$pages = $i*1000+1;
					}
					$signusers = $user->field("username")->where("username not in(".$user_id.")")->group("username")->limit($pages.",1000")->select();
					foreach($signusers as $k=>$v){
						$userids.= $v['username'];
						if(count($signusers)-1 > $k ){
							$userids .= ",";
						}
					}
		
					$receiver_value = $userids;	
				}
			}else if($vip>0 || $startglod>0 || $endglod>0){    //筛选条件发送消息
				$where = "1=1";
				if($vip>0){
					$where.= " and level=".$vip;
				}
				
				if($startglod >0 && $endglod>0){
					$where.= " and goldcount between ".$startglod." and ".$endglod;
				}
				if($where != "1=1"){
					$user = M("users");
					$messuser = $user->field("username")->where($where)->select();
					$messids = '';
					foreach($messuser as $k=>$v){
						$messids.= $v['username'];
						if(count($messuser)-1 > $k ){
							$messids .= ",";
						}
					}
					$receiver_value = $messids;	
					$type = 3;
				}

			}else{     //发消息给所有用
				$type = 4; 	
			}
			
			$sendno = 2;
			$obj = new \Think\jpush();	
			$res = $obj->send($sendno, $type, $receiver_value, 1, $msg_content);
			
		}

		$this->success($res,U('MessagePush/MessageList'));
	}
	
}
?>