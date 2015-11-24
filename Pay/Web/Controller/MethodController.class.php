<?php
/**
 * 接受方法处理控制器
 * @author 付敏平
 */
// data = {action:"xxx",xxxx}
namespace Web\Controller;
use Think\Controller;
class MethodController extends WebController{

	private function Decoding(){
		$key = "MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBALYOQDAdBceLlhZGHVWSg7lDR6sGuFppvhjqfCMBgmSvjC9+HxB8Ho5+K4bTzTGCsmKB7CBCL0MtPGA8ocFAwbpaLtuh3NEpQwR68pVgkLsD5KkRodnZfPv8byDGK0+gt49VZD8ePXka+5gLotEZWXuMprv5Umpx6DA0tqn5TLUDAgMBAAECgYEAiKR3juUpolTlaIBlogWe8l1KHFal5c56DK9qTsfiO3n7COZroG7YbHDMcJzl5ORIyWDkfm3OlWgNadn4OllFTToW9ivUighm0NjeZRqqiXslPLZLtIm1sAoSnQ0QbVgx1wjel5EJSeM1tLKkpHqmXx2urzqPxTxscUeYWM7MhWkCQQDdjF7rpe3mXy672dTaXkBCJTCoRmnI7L3x2h6D/uKS2ulF/krtdKfpm3ED9358FCsbaRLVBFR6WmYZ0zSPfnSfAkEA0l2280TXa+rMErb7ZsUDp8ouiYytdtg7K3R4XS1AWaXMUxQTY0SdcASfdVRnM5SMJv7msB3PijNKm2iF5m8hHQJABZ1yJmzNK8KLz60ErQgofsSsiAdI1RPS+Jc7oMLMAUbVFLYONhh3zP7ojV4vcXudYBN4q7dxYKx72/mzYlOlJwJBAJ22DovRB6PrcrVxI4dHmtb3V+5dXkrkD3AjsH1CiKTtDQMX4PUiItoxTQ7ciUZ9TpmJro9IuiiFDaD3OrOoiu0CQF6FUQ/jNoUeEnCUfzgG1cYeglsLMewsiFV59eUgSS9B+WdJdzGmAYQB6CAPbTW1P+b6HI7J68xQELxEBcQAhwk=";
		$m = new \Think\Rsa($key);  
		$y = $m->decrypt($datas);
		$dataCount = $_POST["datacount"];
		$allstr = "";
		for($i=0;$i<=$dataCount;$i++){
			$strenc = $_POST['data'.$i];
			unset($_POST['data'.$i]);
			$allstr .= $m->decrypt($strenc);
		}
		$keypair = json_decode($allstr,true);
		foreach($keypair as $pair){
			$_POST[$pair['name']] = $pair['value'];
		}

		return $_POST;
	}
	
	public function HandleAction(){
		$rsadarta = $this->Decoding();
		//$rsadarta = $_REQUEST;
		$action = trim($rsadarta['action']);
		$method = trim($rsadarta['method']);
		
		if(!$rsadarta){
			$action = 'AppExtension';
			$method = 'Extension';
			$rsadarta['username'] = "10000001";
			$rsadarta['type'] = 1;
			$rsadarta['times'] = '2014-8-24 16:00:00';
		} 
		
		if($_GET['app_id']>0){
			$action = 'AppDownload';
			$method = 'down_url';
		}

		if($action && $method){
			$import = import ( "@.MethodData.".$action."");
			if (!$import) {
				$arr['res'] = -1;
				$arr['error'] = '您访问接口出错';
				$res = json_encode($arr);
			}else{
				$way = new $action();
				if (!method_exists($way,$method)) {
					$arr['res'] = -1;
					$arr['error'] = '您访问的方法不存在';
					$res = json_encode($arr);
				}else{
					switch($action){
						//应用管理
						case 'AppManage':
							$usreip =  $_SERVER['REMOTE_ADDR'];
							$user_eara = trim($this->convertip($usreip));
							$res = $way -> $method($user_eara,$rsadarta);
						break;
						//登陆和完善资料
						case 'AppLogin':
							$usreip =  $_SERVER['REMOTE_ADDR'];
							$user_eara = trim($this->convertip($usreip));
							$res = $way -> $method($user_eara,$rsadarta);
						break;
						//平台活动
						case 'PlatformActivity':
							$atr_id = intval($rsadarta['atr_id']);
						
							if($atr_id == 20){							
								//大转盘
								echo "/Web/Method/bigWheel?user_name=".$rsadarta['username'];
								
								exit;
							}else if($atr_id ==39){
								//最强眼力								
								echo "/Web/Activity/GuessGold?user_name=".$rsadarta['username'];
								exit;
							}else if($atr_id ==37){
								//一笔画								
								echo "/Web/GamesApp/gameSingle?user_name=".$rsadarta['username'];
								exit;
							}else{
								$ActivityArr = $this->IsLevel($rsadarta['username']);
								$res = $way -> $method($rsadarta,$ActivityArr);
							}	
						break;
						
						//个人中心
						case 'UserCenter':
							$res = $way -> $method($rsadarta);
						break;
						//排名
						case 'Ranking':
							$res = $way -> $method($rsadarta);
						break;
						//下载
						case 'AppDownload':
							$mobilephonetype = trim($rsadarta['mobilephonetype']);
							$mobilewidth = intval($rsadarta['mobilewidth']);
							$mobileheight = intval($rsadarta['mobileheight']); 
							$Bluetooth_id = trim($rsadarta['Bluetooth_id']);
							
							//获取用户账号
							$users = M("users");
							$userinfo = $users->field("username,goldcount,usablegold,installcount")->where("mobilephonetype='".$mobilephonetype."' and mobilewidth=".$mobilewidth." and mobileheight=".$mobileheight." and Bluetooth_id='".$Bluetooth_id."'")->find();
							$downarr = $this->IsLevel($userinfo['username']);
							$res = $way -> $method($rsadarta,$downarr,$userinfo,$_GET);
						break;
						//兑换中心
						case 'AppConvert':
							$res = $way -> $method($rsadarta);
						break;
						//分享中心
						case 'AppExtend':
							$res = $way -> $method($rsadarta);
						break;
						//应用修改，删除更新
						case 'DelUpdates':
							$usreip =  $_SERVER['REMOTE_ADDR'];
							$user_eara = trim($this->convertip($usreip));
							$res = $way -> $method($user_eara,$rsadarta);
						break;
						//获取推广包路径
						case 'AppExtension':
							$res = $way -> $method($rsadarta);
						break;
					}
				}	
			}
		}else{
			$arr['res'] = -1;
			$arr['error'] = '数据出错';
			$res = json_encode($arr);
		}
		echo $res;
	}

	/**
     * @name 大转盘
     *
     */
    public function bigWheel(){
    	header("Content-type: text/html; charset=utf-8"); 
  		//判断玩家等级，vip3以下不能玩
    	$username = trim($_GET['user_name']);	

		$this->username = $username;   	
		$actr = M('activity_taskrule');
		$roleContent = $actr->where('atr_id=20')->getField('data1');//大转盘说明规则
		$this->roleContent = $roleContent; 
		
    	$date = date("Y-m-d");
    	$startTime = strtotime($data." 00:00:00");
    	$endTime = strtotime($data." 23:59:59");
    	$wheel_logs = M("taskrecords");
    	$user = M("users");
    	$level = $user->where("username='".$username."'")->getField('level');//查询用户等级
	
    	if(!isset($level)){      	
    		$nameWrong =  "<script type='text/javascript'>
    					$(function(){
							$('#inner').pointMsg({
								width:'98%',height:100,
								msg:'用户名错误！',  
								color:'green',
								autoClose:true
							});
							window.setTimeout(function(){ window.Android.ExitGame();},5000);
						});
				 </script>";
			$this->nameWrong = $nameWrong;
			$this->display();
    		exit;
    	}
    	if( 3 > $level ){
    		$notEnough =  "<script type='text/javascript'>
    					$(function(){
							$('#inner').pointMsg({
								width:'98%',height:100,
								msg:'您VIP等级不足，请努力多做任务赚取淘币提升VIP等级！',  
								color:'green',
								autoClose:true
							});
							window.setTimeout(function(){ window.Android.ExitGame();},5000);
						});
				 </script>";
			$this->notEnough = $notEnough;	 
    		$this->display();
    		exit;
    	}
    	$logs['username'] = $username;
		$logs['is_sign'] = 3;
    	$logs['is_agian'] = 1;
		$logs['atr_id']   = 20;
    	$logs['add_time'] = array('between',array($startTime,$endTime));
    	$count = $wheel_logs->where($logs)->count();//查询用户当前转盘数
    	if( (3 == $level && 1 <= $count) || (4 == $level && 2 <= $count) || (5 == $level && 3 <= $count) ){
    		$rollCount 	 = 0;
    	}else{
    		$rollCount 	 = 'undefined';
    	}

    	$this->rollCount = $rollCount;
    	
        $this->display();
    }

    //json返回值并入库
    public function dataWheel(){

    	$username   = trim($_GET['username']);
    	$date 		= date("Y-m-d");
    	$startTime  = strtotime($data." 00:00:00");
    	$endTime 	= strtotime($data." 23:59:59");
    	$wheel_logs = M("taskrecords");
    	$user 		= M("users");  
    	$level 		= $user->where("username='".$username."'")->getField('level');//查询用户等级
    	if(empty($level)){ 
			$resStr['error'] = "nameWrong";
    		$resStr['str'] = "用户名错误！";
    		$this->ajaxReturn($resStr);exit;
    	}
    	if( 3 > $level ){ 
    		$resStr['error'] = "levelNotEnough";
    		$resStr['str']   = "您VIP等级不足，请努力多做任务赚取淘币提升VIP等级！";
    		$this->ajaxReturn($resStr);exit;
    	}
    	
    	$logs['username'] = $username;
    	$logs['is_sign'] = 3;
		$logs['atr_id']   = 20;
    	$logs['add_time'] = array('between',array($startTime,$endTime));
    	$count = $wheel_logs->where($logs)->count();//查询用户当前转盘数
    	if( (3 == $level && 1 <= $count) || (4 == $level && 2 <= $count) || (5 == $level && 3 <= $count) ){
    		$resStr['error'] = "invalid";
    		$resStr['str'] 	 = "您今天抽奖次数已到,请明天再来！";
    		$this->ajaxReturn($resStr);exit;
    	}  
		
		$actr = M('activity_taskrule');
		$coin = $actr->where('atr_id=20')->getField('atr_toscore');//每次扣多少积分，后台可控制

    	$user_gold = $user->where("username='".$username."'")->getField('goldcount');//查询当前金币数
    	if( $user_gold > $coin ){
			if( $coin > 0 ){ //如应扣找淘币大于0 sql语句执行--;小于0 sql语句执行++
				$res = $user->where("username='".$username."'")->setDec('goldcount',$coin); 
			}else{
				$res = $user->where("username='".$username."'")->setInc('goldcount',$coin); //$coin必须为负数
			}
    		
    		if($res){
    			$wheel = M("activity_wheel");
				
				//消耗淘币入库
				if( $coin > 0 ){ $money = $coin; }else{ $money = -$coin; }
				$data['is_sign']  = 3;
				$data['is_agian'] = 1;  
				$data['winning']  = '消费'.$money.'淘币';
				$data['username'] = $username;
				$data['earn_coin']= $coin;
				$data['taskname'] = '大转盘';	
				$data['atr_id']	 = 20;
				$data['add_time'] = time();
				$wheel_logs->add($data);

    			$prize_arr = $wheel->select();
		    	foreach ($prize_arr as $key => $val) {   
				    $arr[$val['wheel_id']] = $val['wheel_v'];   
				}

				$rid 	 = $this->get_rand($arr); //根据概率获取奖项id  
				$return  = $prize_arr[$rid]['num_return']; //前端返回值 				
				$nowCoin = $prize_arr[$rid]['wheel_coin']; //应得积分
				$winning = $prize_arr[$rid]['wheel_name']; //中奖项返回的栏目名

				if( 0 >= $return ){
					$resStr['success']   = false;
				}else{
					$resStr['prizetype'] = $prize_arr[$rid]['num_return']; //中奖项返回的下标
					$resStr['success']   = true;
				}
				
				if( 0 < $nowCoin ){ $user->where("username='".$username."'")->setInc('usablegold',$nowCoin); }
				$user->where("username='".$username."'")->setInc('goldcount',$nowCoin);

				//大转盘用户奖励记录入库
				unset($arr);
	
				if( 0 != $nowCoin ){
					if( 2 == $return){//判断是否再来一次
						$arr['is_agian'] = 2;  	
					}else{
						$arr['is_agian'] = 1;  						
					}						
					$arr['is_sign']  = 4;
					$arr['winning']  = $winning;
					$arr['username'] = $username;
					$arr['earn_coin']= $nowCoin;
					$arr['taskname'] = '大转盘';	
					$arr['atr_id']	 = 20;
					$arr['add_time'] = time();
					$wheel_logs->add($arr);					
				}

  				$resStr['str'] = $winning;
				$this->ajaxReturn($resStr);exit;
    		}
    	}else{
    		$resStr['error'] = "coinNotEnough";
    		$resStr['str'] 	 = "淘币不足，请努力多做任务赚取淘币！";
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
	    $randNum = mt_rand(1, $proSum);
	    $arrLine = Array();
	    
	    $sumLine = 0;
	    $arrLine[] = 0;
	
	    foreach($proArr as $k=>$v){ 
			if( 0 < $v ){
				$sumLine += $v;
				$arrLine[]= $sumLine;
			}			
	    }   
	    //概率数组循环   
	    for($i=0;$i<count($arrLine)-1;$i++){    
	        if ($randNum > $arrLine[$i] && $randNum<=$arrLine[$i+1]) {
				$result = $i;
	        	break;
	        }    
	    }
	    unset ($proArr);
	    return $result;   
	}
	
	/**
     * @name 客服联系方式
     *
     */
    public function contact(){

    	$this->display();
    }
	

}

?>