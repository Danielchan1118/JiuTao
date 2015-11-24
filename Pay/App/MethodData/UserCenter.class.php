<?php 
/**
 * @name 用户中心
 * @author DanielChan
 */
 class UserCenter{
	var $intPayId;
	//获取当前用户资料
	public function getUserInfo( $username,$from_where ){
		$m = M('member');
		return $m->where("username='".$username."' AND from_where='".$from_where."'")->find();
	}
	/**
	 * 用户首次登陆判断
	 */
    public function index($post_data = array()){
	
		$username 	 = trim( $post_data['uid'] );
		$from_where  = intval( $post_data['type'] );
		$status 	 = intval( $post_data['state'] );
		$pay_id		 = intval( $post_data['pay_id'] );
		$this->intPayId = $pay_id;
		if( $username && $from_where ){ 			
			$info = $this->getUserInfo( $username,$from_where );  
			if($info){ 
				//更新积分,积分墙同步
				$user = M('users');
				$mem  = M('member'); 
				$userScore = $user->where("username='".$info['unionid']."'")->getField('goldcount');
				$newScore  = intval($userScore)+intval($info['score']);

				$res['nickname'] 	= $info['nickname'];
				$res['img_url'] 	= $info['img_url'];
				$res['score'] 		= $newScore;
				$res['qq'] 			= $info['qq'];
				$res['mobiephone']  = $info['mobiephone'];
				$res['pay_address'] = $info['pay_address'];
				$res['unionid'] 	= $info['unionid'];
				$res['priletternum']= $this->getUserLetterNumStatus( $info['uid'] ); 	//当前用户私信状态
				$res['sellingnum'] 	= $this->getPayStatusNum( 1,$info['uid'] );	//在售数量
				$res['sellednum'] 	= $this->getPayStatusNum( 2,$info['uid'] );	//已售售数量
				$res['timeoutnum'] 	= $this->getPayStatusNum( 3,$info['uid'] );	//已过期数量;
				$res['collectnum'] 	= $this->getPayCollectNum( $info['uid'] );	//已收藏数量;
				
				//1 获取用户的在售信息 2 ：获取用户的已售信息 3：获取用户的已过期信息 ，4获取用户的收藏信息
				if( 1 == $status ){
					$res['datas'] 	= $this->getPayStatusDatas( 1,$info['uid'] );//在售数据
				}
				if( 2 == $status ){
					$res['datas'] 	= $this->getPayStatusDatas( 2,$info['uid'] );//已售售数据
				}
				if( 3 == $status ){
					$res['datas'] 	= $this->getPayStatusDatas( 3,$info['uid'] );//已过期数据;
				}
				if( 4 == $status ){
					$res['datas'] 	= $this->getPayCollectDatas( $info['uid'] );//已收藏数据;
				}
			}
		}
		return json_encode($res);
    }	
	
    /**
     * @name完善资料
     * @param array $datas
     */
    public function changeInfo( $datas = array() ){
		$username 	 = trim( $datas['uid'] );		
        $from_where  = intval( $datas['type'] );
		$qq 		 = trim( $datas['qq'] );
		$mobiephone  = trim( $datas['mobiephone'] );
		$pay_address = trim( $datas['pay_address'] );
	
		$info = $this->getUserInfo( $username,$from_where );
		$m = M('member');	
		if($info){
			$data['qq'] 		 = $qq;
			$data['mobiephone']  = $mobiephone;
			$data['pay_address'] = $pay_address;
			$result 			 = $m->where("username='".$username."' AND from_where='".$from_where."'")->save($data);

			if( 0 == $result || false != $result ){
				$res['res'] = SUCCESS;
				$res['msg'] = '数据成功';
			}else{
				$res['res'] = FUWUERROR;
				$res['msg'] = '服务端失败';
			}
		}else{
			$res['res'] = KEHUERROR;
			$res['msg'] = '无此用户';
		}
		return json_encode($res);
    }

    /**
     * @name 获取当前用户发布内容的状态数量
	 * $param $id: ,1，在售；2，已售；3，已过期。
	 * $param $uid.
     */
	 public function getPayStatusNum( $id,$uid ){
		$id  = intval($id);
		$uid = intval($uid);
		$pay = M('pay');
		
		return $pay->where( 'status='.$id.' AND uid='.$uid )->count();
	 }
	 
	/**
     * @name 获取当前用户发布内容的状态数据
	 * $param $id: ,1，在售；2，已售；3，已过期。
	 * $param $uid.		当前用户ID
	 * $param $pay_id : 商品ID	 
     */
	 public function getPayStatusDatas($id,$uid){

		$id  	= intval($id);
		$uid 	= intval($uid);
		$pay_id = $this->intPayId;
		$limit	= 3; //返回几条记录
		$toTime = time();
		require_once('/GlobalFun.class.php'); 
		$global = new GlobalFun();		
		$pay = M('pay');
		$bids = M('bids');
		
		$where['status'] = $id;
		$where['uid'] 	 = $uid;
		if( 0 < $pay_id ){
			if( 1 == $id ){
				$arrPay = $pay->where( $where )->where( 'id < '.$pay_id  )->order('add_time DESC')->limit($limit)->select();
			}elseif( 2 == $id ){
				$arrPay = $pay->where( $where )->where( 'id < '.$pay_id  )->order('selled_time DESC')->limit($limit)->select();
			}else{
				$arrPay = $pay->where( $where )->where( 'id < '.$pay_id  )->order('period_time DESC')->limit($limit)->select();
			}
		}else{
			if( 1 == $id ){
				$arrPay = $pay->where( $where )->order('add_time DESC')->limit($limit)->select();
			}elseif( 2 == $id ){
				$arrPay = $pay->where( $where )->order('selled_time DESC')->limit($limit)->select();
			}else{
				$arrPay = $pay->where( $where )->order('period_time DESC')->limit($limit)->select();
			}			
		}
		if($global->array_is_null($arrPay)){
			return null;
		}else{
			foreach( $arrPay as $k =>$v ){
				if( 4 == $v['pay_type'] ){//竞拍价格
					$arrPay[$k]['current_price_prc'] = $bids->where('pay_id='.$v['id'])->getField('current_price');
				}
				if( !$v['nickname'] ){//用户昵称为空时,默认'小淘'
					$arrPay[$k]['nickname'] = '小淘';
				}
				if( $v['selled_time']){
						$arrPay[$k]['selled_time'] = $global->failTime($toTime,($v['selled_time']),2); 
				}
				if( $toTime < $v['period_time'] ){
					$arrPay[$k]['failTime'] = $global->failTime(($v['period_time']),$toTime,1); 
				}
				$arrPay[$k]['small_image'] = str_replace("\\","",$v['small_image']);
				if( $arrPay[$k]['small_image'] == ""){
					$arrPay[$k]['small_image'] = str_replace("\\","",$v['image_url']);						
				}				
			}
			return $arrPay;
		}		
	 }
	 
	/**
     * @name 获取当前用户发布内容的收藏数量
	 * $param $id
     */
	 public function getPayCollectNum( $uid ){
		$uid = intval($uid);
		$pc = M('member_collect');
		return $pc->where( 'uid='.$uid )->count();
	 }
	 
	/**
     * @name 获取当前用户发布内容的收藏数据
	 * $param $id
     */
	 public function getPayCollectDatas( $uid ){
		$uid 	= intval($uid);
		$limit	= 3; //返回几条记录
		$pay_id = $this->intPayId;
		require_once('/GlobalFun.class.php'); 
		$global = new GlobalFun();
		
		$pc  = M('member_collect');
		$pay = M('pay');
		$bids = M('bids');	
		
		if( 0 < $pay_id ){ $where = " AND p.id < ".$pay_id; }
		$arrCollect = $pc->table('oh_member_collect c')->field('p.*,m.nickname,m.img_url,c.cadd_time')
					->JOIN('LEFT JOIN oh_pay AS p ON p.id=c.pay_id')
					->JOIN('LEFT JOIN oh_member AS m ON p.uid=m.uid')
					->where( 'c.uid='.$uid.$where )->order('p.add_time DESC')->limit($limit)->select();
		if($global->array_is_null($arrCollect)){
			return null;
		}else{
			foreach( $arrCollect as $k =>$v ){
				if( 4 == $v['pay_type'] ){//竞拍价格
					$arrCollect[$k]['current_price_prc'] = $bids->where('pay_id='.$v['id'])->getField('current_price');
				}
				if( !$v['nickname'] ){//用户昵称为空时,默认'小淘'
					$arrCollect[$k]['nickname'] = '小淘';
				}				
				if( $v['cadd_time']){
						$arrCollect[$k]['cadd_time'] = $global->convertUnitsTime( time()-($v['cadd_time']) ); 
				}
				$arrCollect[$k]['small_image'] = str_replace("\\","",$v['small_image']);
				if( $arrCollect[$k]['small_image'] == ""){
					$arrCollect[$k]['small_image'] = str_replace("\\","",$v['image_url']);						
				}				
			}
			return $arrCollect;
		}
	 }
	 
	/**
     * @name 当前用户更改为已售状态值
	 * $param $id
     */
	 public function changePayStatus( $datas=array() ){
		$username 	 = trim( $datas['uid'] );		
        $from_where  = intval( $datas['type'] );
		$pay_id		 = intval( $datas['pay_id'] );
		$info = $this->getUserInfo( $username,$from_where );

		if($info){
			$pay = M('pay');
			$status = $pay->where( 'id='.$pay_id.' AND uid='.$info['uid'] )->getField('status');
			if( 1 == $status){
				$data['status'] = 2;
				$data['selled_time'] = time();
				$result = $pay->where( 'id='.$pay_id.' AND uid='.$info['uid'] )->save($data);
				if($result){
					$res['res'] = SUCCESS;
					$res['msg'] = '数据成功';
				}else{
					$res['res'] = FUWUERROR;
					$res['msg'] = '服务端出错';
				}
			}else{
				$res['res'] = ERROR;
				$res['msg'] = '非在售状态,不能更改为已售';
			}
		}else{
			$res['res'] = KEHUERROR;
			$res['msg'] = '无此用户';
		}
		return json_encode($res);
	 }
	 
	/**
     * @name 当前用户删除该发布商品
	 * $param $id
     */ 
	public function payDel($datas=array()){
		$username 	= trim( $datas['uid'] );		
        $from_where = intval( $datas['type'] );
		$pay_id		= intval( $datas['pay_id'] );
		require_once('/GlobalFun.class.php'); 
		$global = new GlobalFun();
		$pay = M('pay');
		
		$info 	= $this->getUserInfo( $username,$from_where );
		$payUid = $pay->where('id='.$pay_id)->getField('uid'); 
		if( $info['uid'] == $payUid ){
			$result = $global->paySingleDel( $pay_id ); 
			if($result){
				$res['res'] = SUCCESS;
				$res['msg'] = '数据成功';
			}else{
				$res['res'] = ERROR;
				$res['msg'] = '数据失败';
			}
		}else{
			$res['res'] = ERROR;
			$res['msg'] = '您无权限删除此用户';
		}
		return json_encode($res);
	}
	
	/**
     * @name 当前用户私信状态
	 * $param $id
     */
	public function getUserLetterNumStatus( $uid ){
		$let = M('member_letter');
		$num = $let->where('to_uid='.$uid.' AND is_read=1')->order('add_time DESC')->group('pay_id,from_uid')->select();	
		return intval(count($num));
	}
    
 }
 
 ?>