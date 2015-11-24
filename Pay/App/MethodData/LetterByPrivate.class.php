<?php 
/**
 * @name 私信
 * @author DanielChan
 */
 class LetterByPrivate{
 
	//获取当前用户资料
	public function getUserInfo( $username,$from_where ){
		$m = M('member');
		return $m->where("username='".$username."' AND from_where='".$from_where."'")->find();
	}
	
	/**
	 * @name 私信历史消息
	 */
	public function letterHosShow( $datas=array()){
		header("Content-type: text/html; charset=utf-8");

		$username   = trim( $datas['uid'] );
		$from_where = intval( $datas['type'] );
		$tousername = trim( $datas['to_uid'] );
		$to_where 	= intval( $datas['to_type'] );			
		$pay_id 	= intval( $datas['pay_id'] );
		$info 		= $this->getUserInfo( $username,$from_where );//发私信用户个人资料
		$toInfo 	= $this->getUserInfo( $tousername,$to_where );//被发私信用户个人资料
		$uid  		= $info['uid'];//评论人		
		$time		= time();		
		require_once('/GlobalFun.class.php'); 
		$global = new GlobalFun();//调用公用方法

		$let = M('member_letter');
		$pay = M('pay');
		
		//当前用户私信列表
		$pingList = $let->where('((from_uid='.$uid.' AND to_uid='.$toInfo['uid'].') OR (to_uid='.$uid.' AND from_uid='.$toInfo['uid'].')) AND pay_id='.$pay_id.' AND add_time<'.$time.' AND is_delete=1')->order('add_time')->select();
			
		if( $pingList ){
			foreach( $pingList as $k => $v ){
				$pingList[$k]['add_time'] = date('Y-m-d H:i',$v['add_time']);
			}
			$let->where('(to_uid='.$uid.' AND from_uid='.$toInfo['uid'].') AND pay_id='.$pay_id.' AND is_delete=1')->setField('is_read',2);//被发私信用户私信状态改为已读
			if($global->array_is_null($pingList)){
				$data['res'] = ERROR;
				$data['msg'] = '无数据';
				return json_encode($data);
			}
		}else{
			$data['res'] = ERROR;
			$data['msg'] = '无数据';
			return json_encode($data);
		}
		return json_encode($pingList);
	}

	
	/**
	 * @name 私信添加
	 */
	public function letterAdd( $datas=array()){
		$username   = trim( $datas['uid'] );
		$from_where = intval( $datas['type'] );
		$tousername = trim( $datas['to_uid'] );
		$to_where 	= intval( $datas['to_type'] );		
		$content    = trim( htmlspecialchars($datas['content']) );
		$pay_id 	= intval( $datas['pay_id'] );
		$info 		= $this->getUserInfo( $username,$from_where );
		$toInfo 	= $this->getUserInfo( $tousername,$to_where );

		if( $content ){
			$let = M('member_letter');
			$data['content']  		   		= $content;
			$data['pay_id']   	       		= $pay_id;
			$data['from_uid'] 	  	   		= $info['uid'];;
			$data['from_type'] 	  	   		= $info['from_where'];
			$data['from_user_head_img_url'] = $info['img_url'];
			$data['from_user_nickname'] 	= $info['nickname'];
			$data['from_username'] 	   	    = $info['username'];
			$data['to_uid'] 	  	   		= $toInfo['uid'];
			$data['to_type'] 	  	   		= $toInfo['from_where'];			
			$data['to_user_head_img_url'] 	= $toInfo['img_url'];
			$data['to_user_nickname'] 		= $toInfo['nickname'];
			$data['to_username'] 	   	    = $toInfo['username'];
			$data['add_time'] 		   		= time();
			$result = $let->add($data);
			$data['add_time'] = date('H:i',$data['add_time']);
			$data['uid'] 	  = $info['username'];
			if($result){
				$data['res'] = SUCCESS;
				$data['msg'] = '数据成功';
			}else{
				$data['res'] = ERROR;
				$data['msg'] = '数据失败';
			}		
		}else{
			$data['res'] = KEHUERROR;
			$data['msg'] = '客户端出错,无私信内容';			
		}
		return json_encode($data);
	}
	
	/**
	 * @name 私信列表
	 */
	public function letterList( $datas=array() ){
		$username   = trim( $datas['uid'] );
		$from_where = intval( $datas['type'] );
		$time 		= time();
 
		$info 		= $this->getUserInfo( $username,$from_where );
		require_once('/GlobalFun.class.php'); 
		$global = new GlobalFun();		
		
		if($info){
			$let = M('member_letter');
			$pay = M('pay');
			$letList = $let->where('to_uid='.$info['uid'].' AND is_delete=1')->order('add_time DESC')->group('is_read,pay_id,from_uid')->select();//获取所有用户给当前用户发的所有私信
			foreach( $letList as $k => $v ){
				$pay_img_url = json_decode($pay->where('id='.$v['pay_id'])->getField('image_url'),true);//当前商品的图片路径
				$letList[$k]['payImgUrl'] = $pay_img_url[0]['imgurl'];
				$letList[$k]['add_time']  = $global->convertUnitsTime($time-$v['add_time']);
			}
			if($global->array_is_null($letList)){
				$data['res'] = ERROR;
				$data['msg'] = '无数据';
				return json_encode($data);
			}else{				
				return json_encode($letList);
			}
		}else{
			$res['res'] = ERROR;
			$res['msg'] = '无此用户';
			return json_encode($res);
		}
	}
    
 }
 
 ?>