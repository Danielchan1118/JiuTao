<?php
namespace Home\Controller;
/**
 *	@name 首页模块 
 *
 */
class UserCenterController extends HomeController {

	//获取当前用户资料
	public function getUserInfo( $username,$from_where ){
		$m = M('member');
		return $m->where("username='".$username."' AND from_where='".$from_where."'")->find();
	}	

	/**
	 * @name 个人中心
	 *
	 */
    public function index(){	
		
			//当前网址 
			$this->www = $_SESSION['www'];
			//获取商品分类列表
			$this->catList = $_SESSION['catLists'];
			//热门搜索
			$this->hotCatList = $_SESSION['hotCatLists'];
			//有传城市搜索城市名，默认本市
			$res = $_SESSION['location'];
			//当前城市名
			$this->cityname = $_SESSION['cityname'];
			//帮多少商品找主人
			$this->helpbody = $_SESSION['helpbody'];
			//当前登陆用户
			$this->userinfo = $_SESSION['userinfo'];
		
		if( $_SESSION['userinfo'] ){
			$username 			= trim( $_SESSION['userinfo']['uid'] );
			$from_where 		= intval( $_SESSION['userinfo']['from_where'] );
			$info 				= $this->getUserInfo( $username,$from_where );	
			if( 0 < $info['unionid'] ){
				//更新积分,积分墙同步
				$user = M('users');
				$userScore = $user->where("username='".$info['unionid']."'")->getField('goldcount');
				$newScore  = intval($userScore)+intval($info['score']);							
			}else{
				$newScore  = $info['score'];
			}
			//当前登陆用户
			$this->userinfo 	= $_SESSION['userinfo'];
			$res['nickname'] 	= $info['nickname'];
			$res['score'] 		= $this->vip($newScore);
			$res['qq'] 			= $info['qq'];
			$res['mobiephone']  = $info['mobiephone'];
			$res['uid']			= $info['uid'];
			
		}else{
			$this->error('请先登录',U('Index/index'));
		}
		$blogroll = M('blogroll');
		$this->lists = $blogroll->order('add_time desc')->select();//友情链接
		$this->info = $res;
		$this->display();
	}
	
	/**
	 * @name 当前用户发布商品
	 *
	 */
    public function goods(){
			//当前网址 
			$this->www = $_SESSION['www'];
			//获取商品分类列表
			$this->catList = $_SESSION['catLists'];
			//热门搜索
			$this->hotCatList = $_SESSION['hotCatLists'];
			//有传城市搜索城市名，默认本市
			$res = $_SESSION['location'];
			//当前城市名
			$this->cityname = $_SESSION['cityname'];
			//帮多少商品找主人
			$this->helpbody = $_SESSION['helpbody'];
			//当前登陆用户
			$this->userinfo = $_SESSION['userinfo'];
		
		if( $_SESSION['userinfo'] ){
			//当前登陆用户
			$this->userinfo 	= $_SESSION['userinfo'];
			$username 			= trim( $_SESSION['userinfo']['uid'] );
			$from_where 		= intval( $_SESSION['userinfo']['from_where'] );
			$info 				= $this->getUserInfo( $username,$from_where );
			$res['nickname'] 	= $info['nickname'];
			$res['score'] 		= $this->vip($info['score']);
			$res['uid']			= $info['uid'];
			$datas 				= $this->getPayStatusDatas( $info['uid'] );//在售数据
			foreach( $datas as $k => $v){
				if( 1 == $v['status'] ){					
					$res['selling'][] = $v; 
				}
				if( 2 == $v['status'] ){
					$res['selled'][] = $v; 
				}
				if( 3 == $v['status'] ){
					$res['timeout'][] = $v; 
				}
			}
		}else{
			$this->error('请先登录',U('Index/index'));
		}
		
		$this->info = $res;
		$this->display();		
	}	
	
	/**
	 * @name 当前用户发布商品
	 *
	 */
    public function collect(){		
			//当前网址 
			$this->www = $_SESSION['www'];
			//获取商品分类列表
			$this->catList = $_SESSION['catLists'];
			//热门搜索
			$this->hotCatList = $_SESSION['hotCatLists'];
			//有传城市搜索城市名，默认本市
			$res = $_SESSION['location'];
			//当前城市名
			$this->cityname = $_SESSION['cityname'];
			//帮多少商品找主人
			$this->helpbody = $_SESSION['helpbody'];
			//当前登陆用户
			$this->userinfo = $_SESSION['userinfo'];
		
		if( $_SESSION['userinfo'] ){
			//当前登陆用户
			$this->userinfo 	= $_SESSION['userinfo'];
			$username 			= trim( $_SESSION['userinfo']['uid'] );
			$from_where 		= intval( $_SESSION['userinfo']['from_where'] );
			$info 				= $this->getUserInfo( $username,$from_where );
			$res['nickname'] 	= $info['nickname'];
			$res['score'] 		= $this->vip($info['score']);
			$res['uid']			= $info['uid'];
			$data		 		= $this->getPayCollectDatas( $info['uid'] );//在售数据
			foreach( $data as $k => $v){
				if( 1 == $v['status'] ){					
					$data[$k]['typeStr'] = '出售中'; 
				}elseif( 2 == $v['status'] ){
					$data[$k]['typeStr'] = '已出售'; 
				}elseif( 3 == $v['status'] ){
					$data[$k]['typeStr'] = '已过期'; 
				}
				$image_url = str_replace("\\","",$v['image_url']);
				$pay_img_url = json_decode(($image_url),true);//当前商品的图片路径
				$data[$k]['image_url'] = $pay_img_url[0]['imgurl'];				
			}
			$res['data'] = $data;
		}else{
			$this->error('请先登录',U('Index/index'));
		}
	
		$this->info = $res;
		$this->display();		
	}	
	
	/**
     * @name 获取当前用户发布内容的状态数据
	 * $param $uid.		当前用户ID
     */
	public function getPayStatusDatas($uid){

		$uid 			 = intval($uid);
		$toTime 		 = time();
		$pay 			 = M('pay');
		$where['uid'] 	 = $uid;
		$where['is_show'] 	 = 1;
		$arrPay = $pay->where( $where )->order('add_time DESC')->select();

		if($this->array_is_null($arrPay)){
			return null;
		}else{
			foreach( $arrPay as $k =>$v ){
				if( $v['selled_time']){
						$arrPay[$k]['selled_time'] = $this->failTime($toTime,($v['selled_time']),2); 
				}
				if( $toTime < $v['period_time'] ){
					$arrPay[$k]['failTime'] = $this->failTime(($v['period_time']),$toTime,1); 
				}
				$image_url = str_replace("\\","",$v['image_url']);
				$pay_img_url = json_decode(($image_url),true);//当前商品的图片路径
				$arrPay[$k]['image_url'] = $pay_img_url[0]['imgurl'];
			}
			return $arrPay;
		}		
	}	

	/**
     * @name 获取当前用户发布内容的收藏数据
	 * $param $id
     */
	 public function getPayCollectDatas( $uid ){
		$uid 	= intval($uid);		
		$pc  = M('member_collect');
		$pay = M('pay');
		
		$arrCollect = $pc->table('oh_member_collect c')->field('p.*,m.nickname,m.img_url,c.cadd_time')
					->JOIN('LEFT JOIN oh_pay AS p ON p.id=c.pay_id')
					->JOIN('LEFT JOIN oh_member AS m ON p.uid=m.uid')
					->where( 'c.uid='.$uid.' AND p.is_show=1' )->order('p.add_time DESC')->limit($limit)->select();
		if($this->array_is_null($arrCollect)){
			return null;
		}else{
			foreach( $arrCollect as $k =>$v ){
				if( $v['cadd_time']){
						$arrCollect[$k]['cadd_time'] = $this->convertUnitsTime( time()-($v['cadd_time']) ); 
				}
			}
			return $arrCollect;
		}
	 }	
	 
    /**
     * @name完善资料
     * @param array $datas
     */
    public function modify(){
		$uid 	 	= intval( $_POST['uid'] );		
		$qq 		= trim( $_POST['qq'] );
		$mobiephone = trim( $_POST['mobiephone'] );
		
		$m 	  = M('member');
		$info = $m->where('uid='.$uid)->find();	
		if($info){
			$data['qq'] 		 = $qq;
			$data['mobiephone']  = $mobiephone;
			$result 			 = $m->where('uid='.$uid)->save($data);

			if( 0 == $result || false != $result ){
				$res['code'] = SUCCESS;
				$res['msg'] = '数据成功';
			}else{
				$res['code'] = FUWUERROR;
				$res['msg'] = '服务端失败';
			}
		}else{
			$res['code'] = KEHUERROR;
			$res['msg'] = '无此用户';
		}
		$this->ajaxReturn($res);
    }	 
	
	/**
     * @name 当前用户删除该发布商品
	 * $param $id
     */ 
	public function payDel(){

		$username 	= trim( $_SESSION['userinfo']['uid'] );		
        $from_where = intval( $_SESSION['userinfo']['from_where'] );
		$pay_id		= intval( $_POST['pay_id'] );
		$pay 		= M('pay');
		
		$info 	= $this->getUserInfo( $username,$from_where );
		$payUid = $pay->where('id='.$pay_id)->getField('uid'); 
		if( $info['uid'] == $payUid ){
			$result = $this->paySingleDel( $pay_id ); 
			if($result){
				$res['code'] = SUCCESS;
				$res['msg'] = '数据成功';
			}else{
				$res['code'] = ERROR;
				$res['msg'] = '删除失败';
			}
		}else{
			$res['code'] = ERROR;
			$res['msg'] = '您无权限删除此用户';
		}
		$this->ajaxReturn($res);
	}

	/**
     * @name 当前用户更改为已售状态值
	 * $param $id
     */
	 public function changePayStatus(){
	 
		$username 	= trim( $_SESSION['userinfo']['uid'] );		
        $from_where = intval( $_SESSION['userinfo']['from_where'] );
		$pay_id		= intval( $_POST['pay_id'] );
		$pay = M('pay');		
		$info = $this->getUserInfo( $username,$from_where );
		$payUid = $pay->where('id='.$pay_id)->getField('uid'); 		
		
		if( $info['uid'] == $payUid ){
			$status = $pay->where( 'id='.$pay_id.' AND uid='.$info['uid'] )->getField('status');
			if( 1 == $status){
				$data['status'] = 2;
				$data['selled_time'] = time();
				$result = $pay->where( 'id='.$pay_id.' AND uid='.$info['uid'] )->save($data);
				F('changePayStatus',$pay->getLastSql());
				if($result){
					$res['code'] = SUCCESS;
					$res['msg'] = '数据成功';
				}else{
					$res['code'] = ERROR;
					$res['msg'] = '服务端出错';
				}
			}else{
				$res['code'] = ERROR;
				$res['msg'] = '非在售状态,不能更改为已售';
			}
		}else{
			$res['code'] = ERROR;
			$res['msg'] = '您无权限删除此用户';
		}
		$this->ajaxReturn($res);
	 }
	
	/**
	 * @name 添加收藏，收藏取消
	 */
    public function getCollect(){
		$username 	= trim( $_SESSION['userinfo']['uid'] );		
        $from_where = intval( $_SESSION['userinfo']['from_where'] );
		$pay_id		= intval( $_POST['pay_id'] );
		$status		=1;
		
		$m = M('member');	
		if( $username && $from_where ){ 			
			$m_info = $m->where("username='".$username."' AND from_where='".$from_where."'")->find();//得到当前用户资料		
			if($m_info){
				$c = M('member_collect');
				$id = $c->where("uid='".$m_info['uid']."' AND pay_id='".$pay_id."' AND status=".$status )->getField('id');//查看当前商品di是否有收藏
				$pay = M('pay');
				$ven = M('vendor');
				
				if( $id ){ //如$id有值，则说明已收藏，下一步需删除此条信息
					$result = $c->delete($id);
					$res['msg'] = 'B';//取消收藏
					if($result){ 
						if( 1 == $status ){
							$pay->where('id='.$pay_id)->setDec('point_like');//收藏数量-1
						}elseif( 2 == $status ){
							$ven->where('id='.$pay_id)->setDec('collect_total');//收藏数量-1
						}												
					}
				}else{ //如$id为null，则说明未收藏，下一步需添加此条信息
					$data['uid']       = $m_info['uid'];
					$data['pay_id']    = $pay_id;
					$data['status']    = $status;
					$data['cadd_time'] = time();
					$result = $c->add($data);
					$res['msg'] = 'A';//收藏成功
					if($result){ 
						if( 1 == $status ){
							$pay->where('id='.$pay_id)->setInc('point_like');//收藏数量+1
						}elseif( 2 == $status ){
							$ven->where('id='.$pay_id)->setInc('collect_total');//收藏数量+1
						}
					}
				}
				if($result){
					$res['code'] = SUCCESS;
				}else{
					$res['code'] = ERROR;
					$res['msg'] = '数据出错';
				}
			}
		}else{
			$res['code'] = KEHUERROR;
			$res['msg'] = '客户端出错';
		}
		$this->ajaxReturn($res);
	}	
	
	//获取用户积分进度
	public function vip( $score ){
		$vip = M('grade');
		$vipInfo = $vip->select();
		$vipArr = array();
		foreach( $vipInfo as $k => $v ){
			$vipArr[$v['grade']] = $v['integral'];
		}
		
		$backArr = array();
		for( $i=1; $i<=count($vipArr); $i++){
			if( $vipArr[$i] <= $score && $vipArr[$i+1] >= $score ){
				$backArr['lever'] 	   = $i;
				$backArr['score'] 	   = $score;
				$backArr['need_score'] = intval( $vipArr[$i+1] - $score );	
				return $backArr;
			}			
		}
	}	
	
	/**
	 * @name 消息中心
	 */
    public function message(){
		//当前网址 
		$this->www = $_SESSION['www'];
		//获取商品分类列表
		$this->catList = $_SESSION['catLists'];
		//热门搜索
		$this->hotCatList = $_SESSION['hotCatLists'];
		//有传城市搜索城市名，默认本市
		$res = $_SESSION['location'];
		//当前城市名
		$this->cityname = $_SESSION['cityname'];
		//帮多少商品找主人
		$this->helpbody = $_SESSION['helpbody'];
		//当前登陆用户
		$this->userinfo = $_SESSION['userinfo'];		
	
		$username 	= trim( $_SESSION['userinfo']['uid'] );		
        $from_where = intval( $_SESSION['userinfo']['from_where'] );
		$time 		= time();
		$all 		= intval($_GET['all']);		
		$info 		= $this->getUserInfo( $username,$from_where );
		$res['nickname'] 	= $info['nickname'];
		$res['score'] 		= $this->vip($info['score']);
		$res['uid']			= $info['uid'];	
		
		$let = M('member_letter');
		$pay = M('pay');		
		if($info){		
			if( 0 != $all ){//全部
				$letList['alread'] = $let->where('to_uid='.$info['uid'].' AND is_delete=1 AND is_read=2')->order('add_time DESC')->group('pay_id,from_uid')->select();//已读
				foreach( $letList['alread'] as $k => $v ){
					$letList['alread'][$k]['title'] = $pay->where('id='.$v['pay_id'])->getField('title');
					$letList['alread'][$k]['add_time']  = $this->convertUnitsTime($time-$v['add_time']);
				}
			}
			
			$letList['noread'] = $let->where('to_uid='.$info['uid'].' AND is_delete=1 AND is_read=1')->order('add_time DESC')->group('pay_id,from_uid')->select();//未读
			foreach( $letList['noread'] as $k => $v ){
				$letList['noread'][$k]['title'] = $pay->where('id='.$v['pay_id'])->getField('title');
				$letList['noread'][$k]['payImgUrl'] = $pay_img_url[0]['imgurl'];
				$letList['noread'][$k]['add_time']  = $this->convertUnitsTime($time-$v['add_time']);
			}	
			
			$this->all	   = $all;
			$this->info    = $res;
			$this->letList = $letList;
		}else{
			$this->error('无此信息');
		}		

		$this->display();
	}
	
	/**
	 * @name 对话
	 */
    public function dialogue(){
		//当前网址 
		$this->www = $_SESSION['www'];
		//获取商品分类列表
		$this->catList = $_SESSION['catLists'];
		//热门搜索
		$this->hotCatList = $_SESSION['hotCatLists'];
		//有传城市搜索城市名，默认本市
		$res = $_SESSION['location'];
		//当前城市名
		$this->cityname = $_SESSION['cityname'];
		//帮多少商品找主人
		$this->helpbody = $_SESSION['helpbody'];
		//当前登陆用户
		$this->userinfo = $_SESSION['userinfo'];		
	
	
	
		$this->display();
	}
	 

}