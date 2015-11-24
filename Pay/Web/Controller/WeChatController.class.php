<?php 
/**    
 * @name 关注微信号，发送账户赠送积分
 * @author DanielChan
 */   

namespace Web\Controller;
//define your token  
define("TOKEN", "91zhaoyou20140925");  
class WeChatController extends WebController{
	public function index(){       
		ob_clean();
		ob_start();
		$this->responseMsg();
	}
	public function valid(){                
		if($this->checkSignature()){
			echo trim($_GET["echostr"]);                  
			exit;         
		}     
	}        
	/**
	 * $name 送积分-->并入库
	 *
	 */
	private function sendCoin($fromUsername,$keyword){
		$weixin_id = $fromUsername.''; //$fromUsername是对象，+'' 强制转换成字符串
		$scl = M('sendcoin_logs');
		$logs['weixin_id'] = $weixin_id;
		$logs['username']  = $keyword.'';
		
		$rule = "/^[1-9][0-9]{7,}$/"; //匹配帐户名是否符合规范
		if(!preg_match($rule,$logs['username'])){
			return "您输入找游帐号格式不对,请确认后继续输入(如10000000),谢谢您的关注！";
		}
		$user = M('users');
		$info = $user->where("username='".$logs['username']."'")->find();
		if(!$info){ return "该找游帐号不存在,请确认后继续输入,谢谢您的关注！"; }
		
		$info1 = $scl->where("weixin_id='".$weixin_id."'")->find();
		$info2 = $scl->where("username='".$logs['username']."'")->find();
		if($info1){ $is_b = 1; }
		if($info2){ $is_b = 2; }
		if( 1 == $is_b){
			return "该微信账号已经领取过淘币，请勿重复领取，谢谢您的关注！";
		}
		if( 2 == $is_b){
			return "该91找游账号已经领取过淘币，请勿重复领取，谢谢您的关注！";
		}
		
		//赠送多少积分
		$sc = M('sendcoin');
		$infoArr = $sc->find();
		if( 2 == $infoArr['status'] ){
			return '该找淘币暂不可领取！';
		}
		$user->where("username='".$logs['username']."'")->setField('is_watch',1);	
		$res1 = $user->where("username='".$logs['username']."'")->setInc('goldcount',$infoArr['coin']);		
		if($res1){
			//入库		
			$logs['add_time'] = time();
			$logs['coin'] = $infoArr['coin'];
			$logs['remark'] = "找游账户".$logs['username']."关注微信,赠送".$logs['coin']."淘币";
			$scl->add($logs);
			
			//入任务记录库
			$task = M('taskrecords');
			$data['username']  = $logs['username'];
			$data['atr_id']    = 21;
			$data['earn_coin'] = $logs['coin'];
			$data['add_time']  = time();
			$data['taskname']  = '关注微信';
			$data['winning']   = "关注微信,赠送".$logs['coin']."淘币";
			$task->add($data);
			return '赠送成功,请登录91找游查询！感谢你的关注!';
		}else{
			return '系统错误！'; 
		}	
	}
	 
	/**
	 * $name 一关注马上发送欢迎语
	 *
	 */
	private function sayHello(){
		return "感谢关注91找游微信公众号！更多优惠，敬请期待...";
	}

	
	public function responseMsg(){   
		//get post data, May be due to the different environments     
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];           
		//extract post data   
		if (!empty($postStr)){
			$postObj  	  =  simplexml_load_string($postStr,  'SimpleXMLElement',  LIBXML_NOCDATA);
			$fromUsername = trim($postObj->FromUserName);                 
			$toUsername   = trim($postObj->ToUserName);                 
			$keyword 	  = trim($postObj->Content);

			$time 		  = time();                 
			$textTpl 	  = "<xml> 
								<ToUserName><![CDATA[%s]]></ToUserName> 
								<FromUserName><![CDATA[%s]]></FromUserName>        
								<CreateTime>%s</CreateTime>        
								<MsgType><![CDATA[%s]]></MsgType>        
								<Content><![CDATA[%s]]></Content>        
								<FuncFlag>1</FuncFlag>           
							</xml>";
			if(!empty( $keyword )){                  
				$msgType    = "text";                    
				$contentStr = $this->sendCoin($fromUsername,$keyword);//做业务逻辑的处理并返回输出的内容或不返回               
				$resultStr  = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);                   
				echo $resultStr;                  
			}else{
				echo $this->sayHello(); //关注欢迎语--->这条永远不会输出,因为wechat输入界面已经做js判断，keyword有值才会发送数据过来，这里作判断有备无患
			}          
		}   
	}     
	
	private function checkSignature(){         
		$signature = $_GET["signature"];         
		$timestamp = $_GET["timestamp"];         
		$nonce 	   = $_GET["nonce"];               
		$token 	   = TOKEN;   
		$tmpArr    = array($token, $timestamp, $nonce);   
		sort($tmpArr,SORT_STRING);    
		$tmpStr    = implode( $tmpArr );   
		$tmpStr    = sha1( $tmpStr ); 
		return  $tmpStr == $signature;
	}  
	
	/**
	 * @name 关注微信送找淘币
	 *
	 */
	public function description(){

		$this->display();
	}
	
}  

?>












