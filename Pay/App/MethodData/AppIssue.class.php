<?php 
/**
 * 商品发布接口
 * 商品详情页
 * 推荐列表
 * 最新列表
 * 搜索和搜索列表
 * 产品列表
 * 评论列表
 * 产品分类详情页列表
 */
 class AppIssue{
	/**
	 * 商品详情页
	 * $c_id   产品id
	 */
	 
    public function index($post_data = array()){
		header("Content-type: text/html; charset=utf-8");
		require_once('/GlobalFun.class.php'); 
		$global = new GlobalFun();     //公共方法
		$M = M('pay');
		$member = M('member');
		$com = M('comment');
		$collect = M('member_collect');
		$seek_city 	 = trim( $post_data['seek_city'] );//搜索城市
		if($seek_city){
			$where.= " and p.location = '".$seek_city."'";
		}
		$username 	 = trim( $post_data['uid'] );
		$from_where  = intval( $post_data['type'] );
		$c_id = intval($post_data['c_id']);
		$lat = trim($post_data['lat']);
		$lon = trim($post_data['lon']);
		$dtc = 100;;//距离
		$new_id = intval($post_data['new_id']);//更新和加载id		
		$state = intval($post_data['state']);//state == 上拉更新 1；下拉加载2  ；进来默认：0
		if($state==1){ // state 上拉更新 1；下拉加载2  ；进来默认：0
			$where.="id>".$new_id;
		}
		if($state==2){
			$where.="id<".$new_id;
		}
		if($c_id >0){//详情页
			$M->where('id='.$c_id)->setInc('browse',1);//点击浏览次数加1
			$shop_list = $M->table('oh_pay as p')
						   ->join('oh_member as m on  p.uid = m.uid')
						   ->field('p.*,m.img_url,m.nickname,m.from_where,LLTD(p.lat,p.lon,'.$lat.','.$lon.') as distance')
						   ->where("p.id=".$c_id)
						   ->find();
			$today = time();	
			if($today>$shop_list['period_time']){
				$shop_list['auction_due_time'] = 1;//竞拍已过期
			}else{
				$shop_list['auction_due_time'] = 2;//竞拍还没过期
			}			   
			if($shop_list['pay_type'] == 4){
				$bids = M('bids');
				$auction = M('auction_record');
				$count_user = $auction->field('uid')->group('uid')->select();
				$shop_list['count_num'] = intval($auction->where('pay_id='.$c_id)->count());//竞价的人数
				$shop_list['bids_num'] = intval($auction->where('pay_id='.$c_id)->sum('bids_num'));//竞价的次数
				$shop_list['starting_price'] = $bids->where('pay_id='.$c_id)->getField('starting_price');//竞拍价
				$shop_list['current_price_prc'] = $bids->where('pay_id='.$c_id)->getField('current_price');//总价
				$shop_list['markups'] = $bids->where('pay_id='.$c_id)->getField('markups');//加价幅度
				$shop_list['pai_now_time'] = date('Y-m-d H:i:s',time());//当前时间
				$shop_list['pai_end_time'] = date('Y-m-d H:i:s',$shop_list['period_time']);//结束时间
				$b = $auction->where('pay_id='.$c_id)->order('id desc')->select();
				
				$shop_list['biddingname'] = $b[0]['nickname'];//结束时间
				$shop_list['biddinguid'] =  $b[0]['did_username'];//结束时间
			}			   
			//距离多少米
			require_once('/GlobalFun.class.php'); 
			$global = new GlobalFun();
			$count_shop = $shop_list['distance'];
			$shop_list['distance'] = $global->convertUnitsKMeter($count_shop);
			$nowtimes =  date("Y-m-d H:i:s",time() ); 
			if($shop_list['period'] == 1){//发布周期7天
				$addtimes =  date("Y-m-d H:i:s",$shop_list['add_time']+3600*24*7);
				$time_data = round( (strtotime($addtimes)-strtotime($nowtimes))/3600/24);
			}
			if($shop_list['period'] == 2){//发布周期15天
				$settime = $shop_list['add_time'];
				$addtimes =  date("Y-m-d H:i:s",$shop_list['add_time']+3600*24*15);
				$time_data = round( (strtotime($addtimes)-strtotime($nowtimes))/3600/24);
			}
			if($shop_list['period'] == 3){//发布周期30天
				$addtimes =  date("Y-m-d H:i:s",$shop_list['add_time']+3600*24*30);
				$time_data = round( (strtotime($addtimes)-strtotime($nowtimes))/3600/24);
			}
			//评论列表信息
			$comment = $com->table('oh_comment c')
							->join('oh_member as m on c.uid = m.uid')
							->field('c.id,c.content,c.uid,c.add_time,m.nickname,m.img_url')
							->where('c.is_show = 0 and c.cat_id='.$c_id)
							->order('c.add_time desc')
							->select();
			$i=1;
			foreach($comment as $kk=>$vv){
				$nowtime = date("Y-m-d H:i:s",time() ); 
				$edntime = date("Y-m-d H:i:s",$vv['add_time']); 
				$comment[$kk]['com_time'] = $this->times($nowtime,$edntime);
				$comment[$kk]['com_id'] = $vv['id'];
				$comment[$kk]['username'] =  $member->where('uid='.$vv['uid'])->getField('username');
				$i++;
			}
			
			$get_uid = $member->where("username='".$username."' AND from_where='".$from_where."'")->getField('uid');
			$get_name = $member->where("uid=".$shop_list['uid'])->getField('username');
			$shop_list['username'] = $get_name;
			$collect_pay_id = $collect->field('pay_id')->where('uid='.$get_uid)->select();
			$arr_collect_pay_id = array();
			foreach( $collect_pay_id as $vo ){
				$arr_collect_pay_id[] = $vo['pay_id'];
			}
			if($username && $from_where){
				if( in_array($shop_list['id'],$arr_collect_pay_id) ){//是否收藏 收藏collect_id：1 没收藏 collect_id：0
						$shop_list['collect_id'] = 1;
					}else{
						$shop_list['collect_id'] = 0;
				}
			}else{
				$shop_list['collect_id'] = 0;
			}
			
			$shop_list['comm_data'] = $comment;  //评论通过数组
			$shop_list['period_time'] = $time_data."天";
			$nowtime = date("Y-m-d H:i:s",time() ); 
			$edntime = date("Y-m-d H:i:s",$shop_list['add_time']); 
			$shop_list['add_time'] = $this->times($nowtime,$edntime);
		}else{//首页进入
		$bids = M('bids');
			$shop_list = $M->table('oh_pay as p')
						   ->join('oh_member as m on  p.uid = m.uid')
						   ->field('p.*,m.img_url,m.nickname,LLTD(p.lat,p.lon,'.$lat.','.$lon.') as distance')
						   ->where($where)
						   ->order('p.add_time desc')
						   ->limit('20')
						   ->select();	
			if($shop_list){
				$get_uid = $member->where("username='".$username."' AND from_where='".$from_where."'")->getField('uid');
				$collect_pay_id = $collect->field('pay_id')->where('uid='.$get_uid)->select();
				
				$arr_collect_pay_id = array();
				foreach( $collect_pay_id as $vo ){
					$arr_collect_pay_id[] = $vo['pay_id'];
				}

					foreach($shop_list as $k=>$v){//getField
						if($username && $from_where){
							if( in_array($v['id'],$arr_collect_pay_id) ){//是否收藏
								$shop_list[$k]['collect_id'] = 1;
							}else{
								$shop_list[$k]['collect_id'] = 0;
							}	
						}else{
							$shop_list[$k]['collect_id'] = 0;
						}
						if( 4 == $v['pay_type'] ){ //竞拍
							$shop_list[$k]['current_price_prc'] = $bids->where('pay_id='.$v['id'])->getField('current_price');
						}
						if($v['nickname'] == ''){
							$shop_list[$k]['nickname'] = '小淘';
						}
						$count_shop = $v['distance'];
						$shop_list[$k]['distance'] = $global->convertUnitsKMeter($count_shop);//算经纬度距离
						if($v['image_url'] == ''){
							$shop_list[$k]['small_image'] = $v['image_url'];//算经纬度距离
						}
						
						$nowtime = date("Y-m-d H:i:s",time() ); 
						$edntime = date("Y-m-d H:i:s",$v['add_time']); 
						$shop_list[$k]['add_time'] = $this->times($nowtime,$edntime);
					}
			}
			
			
		}
	
		if($global->array_is_null($shop_list)){
				$shop_list['res'] = ERROR;
				$shop_list['msg'] = '数据失败';	
		}		
		return json_encode($shop_list);	
		
    } 
	
	//详情页
	public function indexShow($post_data = array()){
	header("Content-type: text/html; charset=utf-8");
		require_once('/GlobalFun.class.php'); 
		$global = new GlobalFun();     //公共方法
		$M = M('pay');
		$member = M('member');
		$com = M('comment');
		$collect = M('member_collect');
		$seek_city 	 = trim( $post_data['seek_city'] );//搜索城市
		if($seek_city){
			$where.= " and p.location = '".$seek_city."'";
		}
		$username 	 = trim( $post_data['uid'] );
		$from_where  = intval( $post_data['type'] );
		$c_id = intval($post_data['c_id']);
		$lat = trim($post_data['lat']);
		$lon = trim($post_data['lon']);
		$dtc = 100;;//距离
		$new_id = intval($post_data['new_id']);//更新和加载id		
		$state = intval($post_data['state']);//state == 上拉更新 1；下拉加载2  ；进来默认：0
		if($state==1){ // state 上拉更新 1；下拉加载2  ；进来默认：0
			$where.="id>".$new_id;
		}
		if($state==2){
			$where.="id<".$new_id;
		}
		
		if($c_id >0){//详情页
			$M->where('id='.$c_id)->setInc('browse',1);//点击浏览次数加1
			$shop_list = $M->table('oh_pay as p')
						   ->join('oh_member as m on  p.uid = m.uid')
						   ->field('p.*,m.img_url,m.nickname,m.from_where,LLTD(p.lat,p.lon,'.$lat.','.$lon.') as distance')
						   ->where("p.id=".$c_id)
						   ->find();
			if($shop_list){
				//距离多少米
				require_once('/GlobalFun.class.php'); 
				$global = new GlobalFun();
				$count_shop = $shop_list['distance'];
				$shop_list['distance'] = $global->convertUnitsKMeter($count_shop);
				//dump($shop_list['distance']);
				$nowtimes =  date("Y-m-d H:i:s",time() ); 
				if($shop_list['period'] == 1){//发布周期7天
					$addtimes =  date("Y-m-d H:i:s",$shop_list['add_time']+3600*24*7);
					$time_data = round( (strtotime($addtimes)-strtotime($nowtimes))/3600/24);
				}
				if($shop_list['period'] == 2){//发布周期15天
					$settime = $shop_list['add_time'];
					$addtimes =  date("Y-m-d H:i:s",$shop_list['add_time']+3600*24*15);
					$time_data = round( (strtotime($addtimes)-strtotime($nowtimes))/3600/24);
				}
				if($shop_list['period'] == 3){//发布周期30天
					$addtimes =  date("Y-m-d H:i:s",$shop_list['add_time']+3600*24*30);
					$time_data = round( (strtotime($addtimes)-strtotime($nowtimes))/3600/24);
				}
				//评论列表信息
				$comment = $com->table('oh_comment c')
								->join('oh_member as m on c.uid = m.uid')
								->field('c.id,c.content,c.uid,c.add_time,m.nickname,m.img_url')
								->where('c.is_show = 0 and c.cat_id='.$c_id)
								->order('c.add_time desc')
								->select();
				$i=1;
				foreach($comment as $kk=>$vv){
					$nowtime = date("Y-m-d H:i:s",time() ); 
					$edntime = date("Y-m-d H:i:s",$vv['add_time']); 
					$comment[$kk]['com_time'] = $this->times($nowtime,$edntime);
					$comment[$kk]['com_id'] = $vv['id'];
					$comment[$kk]['username'] =  $member->where('uid='.$vv['uid'])->getField('username');
					$i++;
				}
				
				$get_uid = $member->where("username='".$username."' AND from_where='".$from_where."'")->getField('uid');
				$get_name = $member->where("uid=".$shop_list['uid'])->getField('username');
				$shop_list['username'] = $get_name;
				$collect_pay_id = $collect->field('pay_id')->where('uid='.$get_uid)->select();
				$arr_collect_pay_id = array();
				foreach( $collect_pay_id as $vo ){
					$arr_collect_pay_id[] = $vo['pay_id'];
				}
				if($username && $from_where){
					if( in_array($shop_list['id'],$arr_collect_pay_id) ){//是否收藏 收藏collect_id：1 没收藏 collect_id：0
							$shop_list['collect_id'] = 1;
						}else{
							$shop_list['collect_id'] = 0;
					}
				}else{
					$shop_list['collect_id'] = 0;
				}
				$shop_list['comm_data'] = $comment;  //评论通过数组
				$shop_list['period_time'] = $time_data."天";
				$nowtime = date("Y-m-d H:i:s",time() ); 
				$edntime = date("Y-m-d H:i:s",$shop_list['add_time']); 
				$shop_list['add_time'] = $this->times($nowtime,$edntime);
			}else{
				if($global->array_is_null($shop_list)){
					$shop_list['res'] = ERROR;
					$shop_list['msg'] = '数据失败';	
				}
			}
			
		}
				
		return json_encode($shop_list);	
	}
		
	/** 
	 *产品分类详情页列表
	 *cat_id:分类id
	 */
	 public function ProductCatPar($post_data = array()){
		$M = M('pay');
		$cat_id = intval($post_data['cat_id']);
		if($cat_id){
			$pay_list = $M->field('id,title,content,real_price,pay_price,image_url,add_time,comment_total,address,point_like')->where('cat_id='.$cat_id)->select();
			foreach($pay_list as $k=>$v){
				$nowtime = date("Y-m-d H:i:s",time() ); 
				$edntime = date("Y-m-d H:i:s",$v['add_time']); 
				$pay_list[$k]['add_time'] = $this->times($nowtime,$edntime);
				
			}
		}
		
		return json_encode($pay_list);
	} 
	
	//产品分类
	public function GoodsCat(){
		$M = M('pay_cat');
		$cat_list = $M->where('pid=0')->order('ord_id')->select();
		$i = 1;
		if($cat_list){
			$arr = array();
			foreach ($cat_list as $k => $v) {
				$cat_lists = $M->where('pid=0')->count();
				$arr[$k]['index'] = $i;
				$arr[$k]['name'] = $v['name'];
				$arr[$k]['id'] = $v['id'];
				$arr[$k]['pid'] = $v['pid'];
				$i++;
				$next = $M->where('pid='.$v['id'])->order('ord_id')->select();	
				$arr[$k]['sub'] = $next;
			}
		}
		return json_encode($arr);
			
	}
	
	//时间转换
	 public function times($nowtime,$edntime){
		header("Content-type: text/html; charset=utf-8");
			$minute = round((strtotime($nowtime)-strtotime($edntime))/60);
			if($minute<=1){
				$Days = '刚刚';
			}
			if($minute>1 && $minute<60){
				$Days = round($minute).'分钟';
			}
			if($minute>60 && $minute<=60*24){
				$Days = round($minute/60).'小时前';	
			}
			if($minute>60*24 && $minute<60*24*30){
				$Days = round($minute/(60*24)).'天前';	
			}
			if($minute>60*24*30 && $minute=60*24*30*365){
				$Days = round($minute/(60*24*30)).'月前';
			}
				 
		return $Days;
		
	}
	
	 
	//附近列表
	public function NearbyShop($post_data = array()){
		require_once('/GlobalFun.class.php'); 
		$global = new GlobalFun();     //公共方法
		
		$M = M('pay');
		$member = M('member'); 
		$collect = M('member_collect');
		$lat = trim($post_data['lat']);
		$lon = trim($post_data['lon']);
		$dtc = 1;//intval( $post_data['dtc'] );//距离
		$username 	 = trim( $post_data['uid'] );
		$from_where  = intval( $post_data['type'] );
		$new_id = intval($post_data['new_id']);//更新和加载id		
		$_GET['p'] = intval($post_data['p']);//state == 上拉更新 1；下拉加载2  ；进来默认：0
		$seek_city 	 = trim( $post_data['seek_city'] );//搜索城市
		if($seek_city){
			$where.= " and p.location = '".$seek_city."'";
		}
		$M = M('pay');
		$n = 10;
        $counts = $M->table('oh_pay as p') 
						   ->join('oh_member as m on  p.uid = m.uid')
						   ->field('*,m.img_url,m.nickname,LLTD(p.lat,p.lon,'.$lat.','.$lon.') as distance')
						   ->where("LLTD(p.lat,p.lon,$lat,$lon) >".$dtc.$where)->count();              
        $Page  = new \Think\Page($counts,$n); // 实例化分页类 传入总记录数和每页显示的记录数
		$shop_list = $M->table('oh_pay as p')
						   ->join('oh_member as m on  p.uid = m.uid')
						   ->field('*,m.img_url,m.nickname,LLTD(p.lat,p.lon,'.$lat.','.$lon.') as distance')
						   ->where("LLTD(p.lat,p.lon,$lat,$lon) >".$dtc.$where)
						   ->order("LLTD(p.lat,p.lon,$lat,$lon)")
						   ->limit($Page->firstRow.','.$Page->listRows)
						   ->select();	
			$get_uid = $member->where("username='".$username."' AND from_where='".$from_where."'")->getField('uid');
			$collect_pay_id = $collect->field('pay_id')->where('uid='.$get_uid)->select();
			$arr_collect_pay_id = array();
			foreach( $collect_pay_id as $vo ){
				$arr_collect_pay_id[] = $vo['pay_id'];
			}
			$bids = M('bids');
			
			foreach($shop_list as $k=>$v){//getField
				if($username && $from_where){
					if( in_array($v['id'],$arr_collect_pay_id) ){//是否收藏
						$shop_list[$k]['collect_id'] = 1;
					}else{
						$shop_list[$k]['collect_id'] = 0;
					}
				}else{
					$shop_list[$k]['collect_id'] = 0;
				}
				
				if( 4 == $v['pay_type'] ){ //竞拍
					$shop_list[$k]['current_price_prc'] = $bids->where('pay_id='.$v['id'])->getField('current_price');
				}
				
				$count_shop = $v['distance'];
				$shop_list[$k]['distance'] = $global->convertUnitsKMeter($count_shop);//算经纬度距离
				$nowtime = date("Y-m-d H:i:s",time() ); 
				$edntime = date("Y-m-d H:i:s",$v['add_time']); 
				$shop_list[$k]['add_time'] = $this->times($nowtime,$edntime);
			}
		require_once('/GlobalFun.class.php'); 
		$global = new GlobalFun();
		if($global->array_is_null($shop_list)){
				$shop_list['res'] = ERROR;
				$shop_list['msg'] = '数据失败';	
		}
		return json_encode($shop_list);
	}
	
	//最新列表
	public function Recommend(){
		$M = M('pay');        
		$Recommend_list = $M->field('id,content,real_price,pay_price,image_url,add_time,region,point_like,comment_total')->where('status=1')->order('add_time desc')->select();
		foreach($Recommend_list as $k=>$v){
			$nowtime = date("Y-m-d H:i:s",time() ); 
			$edntime = date("Y-m-d H:i:s",$v['add_time']); 
			$Recommend_list[$k]['add_time'] = $this->times($nowtime,$edntime);
		}
		return json_encode($Recommend_list);
		
	}
	//商品发布
	public function ShopEdit($post_data = array()){
		require_once('/GlobalFun.class.php'); 
		$global = new GlobalFun();     //公共方法
		
		$M = M('pay');
		$member = M('member');
		$username = trim( $post_data['uid']);
		$from_where = trim( $post_data['type']);
		ini_set("display_error","On");
		ini_set("error_reporting","E_ALL & ~E_NOTICE");		
		if($username && $from_where){
			$get_uid = $member->where("username='".$username."' AND from_where='".$from_where."'")->find();
			$data['uid'] 	       = $get_uid['uid'];
			$data['lat'] 	       = trim( $post_data['lat']);//纬度
			$data['lon'] 	       = trim( $post_data['lon']);//经度
			$data['cat_id'] 	   = intval($post_data['shop_type']);//分类id
			$data['title'] 	       = trim( $post_data['title']);
			$data['content'] 	   = trim( $post_data['content']);
			$data['real_price']    = intval( $post_data['real_price']);
			$data['pay_price'] 	   = intval($post_data['pay_price']);
			$use_status    = intval($post_data['use_status']);
			if($use_status =='全新'){
				$data['use_status'] = 1;
			}else if($use_status =='非全新'){
				$data['use_status'] = 2;
			}
			$pay_type = trim($post_data['pay_type']);
			if($pay_type == '出售'){
				$data['pay_type']      = 1;
			}
			if($pay_type == '交换'){
				$data['pay_type']      = 2;
			}
			if($pay_type == '免费赠送'){
				$data['pay_type']      = 3;
			}
			if($pay_type == '竞拍'){
				$data['pay_type']      = 4;
			}
			$data['is_show']       = 1;
			$data['weixin']        = trim($post_data['weixin']);//微信账号
			$data['qq']            = trim($post_data['qq']);
			$data['phone']         = trim($post_data['phone']);
			$data['period'] 	   = intval($post_data['period']);//发布周期
			$data['location'] 	   = trim($post_data['location']);//所在地址
			$data['add_time']      = time();

			if($data['period'] == 1){//发布周期7天
				$period_time = $data['add_time']+3600*24*7;
			}
			if($data['period'] == 2){//发布周期15天
				$period_time = $data['add_time']+3600*24*15;
			}
			if($data['period'] == 3){//发布周期30天
				$period_time = $data['add_time']+3600*24*30;
			}
			if($data['period'] == 4){//发布周期30天
				$period_time = $data['add_time']+3600*24;
			}
			$data['period_time'] = $period_time;

			$data['status']  = 1;			
			$img_url = trim($post_data['img_url']);
			
			$former_url = trim($post_data['former_url']);
			$data['small_image'] =  $former_url;
			if($img_url!="[]"){
				$data['image_url'] =  $img_url; 
				 
			}else{
				$res['res'] = ERROR;
				$res['msg'] = '数据出错';
			}
				$result = $M->add($data);
				$arr['current_price'] = trim( $post_data['current_price']);
				$arr['starting_price'] = trim( $post_data['current_price']);
				$arr['markups'] = trim( $post_data['markups']);
				$pay_type_id = $M->where('id='.$result)->getField('pay_type');
				if(4 == $pay_type_id){
					$bids = M('bids');
					$arr['pay_id'] = $result;
					$arr['bids_status'] = 1;
					$bids ->add($arr);
				}
				if($result){								
					//赠送积分记录
					/*
					$srule = M('score_rule');
					$score = $srule->where('id=1')->getField('score');//发布获得的积分额					
					*/
					$srule = M('activity_taskrule');
					$score = $srule->where('atr_id=40')->getField('atr_toscore');//发布获得的积分额
					
					$resScore = $member->where('uid='.$get_uid['uid'])->setInc('score',$score);//发布加5积分
					if($resScore){
						/*
						$arr['uid'] = $get_uid['uid'];
						$arr['dowhaht'] = $get_uid['nickname'].'发布商品赠送'.$score.'积分';
						$arr['score'] = $score;
						*/
						$arr['username']   = $username;
						$arr['from_where'] = $from_where;
						$arr['pay_id']	   = $result;
						$arr['atr_id']	   = 40;
						$arr['remark']     = '发布商品';
						$arr['getscore']   = $score;
						$arr['usablegold'] = $score;
						$arr['taskgold']   = $score;
						$global->userGetScoreLog($arr);					
					}
					$res['res'] = SUCCESS;
					$res['msg'] = '登陆成功';
				}else{
					unset($res);
					$res['res'] = ERROR;
					$res['msg'] = '登陆失败';
				}
		}else{
				$res['res'] = ERROR;
				$res['msg'] = '数据出错';
		}
		
		return json_encode($res);	
	}
	
	//上传图片
	public function UploadImg($post_data = array()){		
		if($_FILES['uploadedfile']['size'] > 0 ){
			 $config = array(    
				'maxSize'    =>    3145728,    
				'savePath'   =>    '/images/',    
				'saveName'   =>    array('uniqid',''),    
				'exts'       =>    array('jpg', 'png', 'jpeg'),    
				'autoSub'    =>    true,    
				'subName'    =>    array('date','Ymd'),
            );

			$upload = new \Think\Upload();// 实例化上传类
			$info   =   $upload->upload();
			if(!$info) {    // 上传错误提示错误信息    
				$arr['res'] = ERROR;
				$arr['msg'] = 'upload faild';
				$arr['url'] = '';
				$arr['bre_url'] = '';
			}else{
				$image = new \Think\Image(); 
				foreach($info as $file) {
                    $thumb_file = './Uploads/'.$file['savepath'].$file['savename'];
                    $save_path = './Uploads/'.$file['savepath'].'m_'.$file['savename'];
                    $datas = $image->open( $thumb_file )->thumb(150, 150,\Think\Image::IMAGE_THUMB_FILLED)->save( $save_path );
                     
                }
				
				
				$arr['res'] = SUCCESS;
				$arr['msg'] = '上传成功';
				$arr['url'] = substr($thumb_file,1);
				$arr['bre_url'] = substr($save_path,1);
			}
		}
		return json_encode($arr);
		
		
		
 }
	
	/**
	 *搜索列表和搜索分类列表
	 *uid:分类id
	 *content:搜索内容
	*/ 
	public function SeekList($post_data = array()){
	
		$pay = M('pay_cat');
		$M = M('pay');
		$member = M('member');
		$collect = M('member_collect');
		$all_title = trim($post_data['all_title']);
		$c_id = intval($post_data['c_id']);
		$content = iconv('GB2312','UTF-8',trim($post_data['content']));
		$all_title = iconv('GB2312','UTF-8',trim($post_data['all_title']));
		$status  = intval($post_data['status']);
		$username 	 = trim( $post_data['uid'] );
		$from_where  = intval( $post_data['type'] );
		$lat = trim($post_data['lat']);
		$lon = trim($post_data['lon']);
		
		if(empty($content)){
			$content = trim($post_data['content']);
		}
		if(empty($all_title)){
			$all_title = trim($post_data['all_title']);
		}

		if($content){//模糊匹配搜索的内容
			$shop_list = $M->where("title like '%".$content."%'")->group('id')->select();//or "content like '%".$content."%'"		
			foreach($shop_list as $k=>$v){
				$shop_list[$k]['name'] = mb_substr($v['title'],0,50);
			}
			
		}else{				
			if($all_title){//点击搜索的关键字
				//$get_id = $pay->where('id='.$c_id)->getField('pid');
					if($status == 1){//按照时间顺序查询(顺序)
					$shop_list = $M->where("title like '%".$all_title."%' or content like '%".$all_title."%'")->order('add_time desc')->select();
					}
					if($status == 2){//按照价格顺序查询(顺序)
					$shop_list = $M->where("title like '%".$all_title."%' or content like '%".$all_title."%'")->order('real_price')->select();
					}
					if($status == 3){//按照价格顺序查询(降序)
					$shop_list = $M->where("title like '%".$all_title."%' or content like '%".$all_title."%'")->order('real_price desc')->select();
					}
					if($status == 4){//按照距离顺序查询(顺序)
					$shop_list = $M->where("title like '%".$all_title."%' or content like '%".$all_title."%'")->order('LLTD(lat,lon,'.$lat.','.$lon.')')->select();
					}

			}else if($c_id>0){
				$get_id = $pay->field('id')->where('pid='.$c_id)->select();
				$get_arr = array();
				foreach($get_id as $v){
					$get_arr[] = $v['id'];
				}
				$get_arr = implode(',',$get_arr);
				if($c_id ==15 ){
					if($status == 1){//按照时间顺序查询(顺序)
						$shop_list = $M->where('cat_id='.$c_id)->order('add_time desc')->select();
					}
					if($status == 2){//按照价格顺序查询(顺序)
						$shop_list = $M->where('cat_id='.$c_id)->order('real_price')->select();
					}
					if($status == 3){//按照价格顺序查询(降序)
						$shop_list = $M->where('cat_id='.$c_id)->order('real_price desc')->select();
					}
					if($status == 4){//按照距离顺序查询(顺序)
						$shop_list = $M->where('cat_id='.$c_id)->order('LLTD(lat,lon,'.$lat.','.$lon.')')->select();
					}
				}else{
					$where['cat_id']  = array('in',$get_arr);
					if($status == 1){//按照时间顺序查询(顺序)
							$shop_list = $M->where($where)->order('add_time desc')->select();
					}                                                             
					if($status == 2){//按照时间顺序查询(顺序)
							$shop_list = $M->where($where)->order('real_price')->select();
					}
					if($status == 3){//按照时间顺序查询(顺序)
							$shop_list = $M->where($where)->order('real_price desc')->select();
					}
					if($status == 4){//按照时间顺序查询(顺序)
							$shop_list = $M->where($where)->order('LLTD(lat,lon,'.$lat.','.$lon.')')->select();
					}
				}
				
				
			}
			$get_uid = $member->where("username='".$username."' AND from_where='".$from_where."'")->getField('uid');
			$collect_pay_id = $collect->field('pay_id')->where('uid='.$get_uid)->select();
			$arr_collect_pay_id = array();
			foreach( $collect_pay_id as $vo ){
				$arr_collect_pay_id[] = $vo['pay_id'];
			}
			foreach($shop_list as $k=>$v){
				if( in_array($v['id'],$arr_collect_pay_id) ){//是否收藏
					$shop_list[$k]['collect_id'] = 1;
				}else{
					$shop_list[$k]['collect_id'] = 0;
				}
				$nowtime = date("Y-m-d H:i:s",time() ); 
				$edntime = date("Y-m-d H:i:s",$v['add_time']); 
				$shop_list[$k]['add_time'] = $this->times($nowtime,$edntime);
			}
		}
		require_once('/GlobalFun.class.php'); 
		$global = new GlobalFun();
		if($global->array_is_null($shop_list)){
				$shop_list['res'] = ERROR;
				$shop_list['msg'] = '数据失败';	
		}
		return json_encode($shop_list);
		
	}
	/**
	 *删除评论
	 **/
	public function CommentDel($post_data = array()){
		$com = M('comment');
		$pay = M('pay');
		$id = intval($post_data['id']);
		$p_id = intval($post_data['p_id']);
		if($id){
			$del = $com->where('id='.$id)->delete();
			if($del){
				$pay->where('id='.$p_id)->setDec('comment_total',1);//评论数量+1
				$del_list['res'] = SUCCESS;
				$del_list['msg'] = '删除成功';	
			}else{
				$del_list['res'] = ERROR;
				$del_list['msg'] = '删除失败';	
			}
		}
		return  json_encode($del_list);
	}
	
	/**
	 *评论列表
	 *cat_id:产品id
	 */
	public function comment_list($post_data = array()){
		$com = M('comment');
		$member = M('member');
		$cat_id = intval($post_data['cat_id']);
		if($cat_id>0){
			$res = $com->table('oh_comment c')
							->join('oh_member as m on c.uid = m.uid')
							->field('c.content,c.add_time,c.uid,m.nickname,m.img_url')
							->where("c.is_show = 0 and c.status=1 and c.cat_id=".$cat_id)
							->select();
			foreach($res as $k=>$v){
				$nowtime = date("Y-m-d H:i:s",time() ); 
				$edntime = date("Y-m-d H:i:s",$v['add_time']); 
				$res[$k]['add_time'] = $this->times($nowtime,$edntime);
			}
		}else{
			$res['res'] = ERROR;
			$res['msg'] = '数据出错';
		}	
		return json_encode($res);
	}
	
	/**
	 *添加评论   
	 * cat_id：产品id 
	 * 
	 */
	public function AddComment($post_data = array()){
		$com = M('comment');
		$pay = M('pay');
		$vendor = M('vendor');
		$member = M('member');
		$content = trim($post_data['content']);
		$cat_id = intval($post_data['cat_id']);
		$username = trim($post_data['uid']);
		$from_where = intval($post_data['type']);
		$status = intval($post_data['status']);
		$id = intval($post_data['id']);//评论的id
		if($username && $from_where){
				$get_uid = $member->field('uid,nickname,img_url')->where("username='".$username."' AND from_where='".$from_where."'")->find();
		}
		$arr = array();
		if($content){
			$arr['content'] = $content;
			$arr['cat_id'] = $cat_id;
			$arr['uid'] = $get_uid['uid'];
			$arr['is_show'] = 0;
			$arr['add_time'] = time();
			$arr['status'] = $status;
			$arr['com_id'] = $id;
			if($id>0){
				$get_com_uid = $com->where("id=".$id)->getField('uid');
				if($get_com_uid>0){
					$get_user_name = $member->where("uid=".$get_com_uid)->getField('nickname');
				}
				$arr['content'] = "回复".$get_user_name.":".$content;
				
			}
			$add_com = $com->add($arr);
			if($add_com){
				$arr['com_id'] = $add_com;
				$arr['id'] = $add_com;
				$arr['com_time'] = "刚刚";
			}
			if($add_com){
				if($status==1){
					$pay->where('id='.$cat_id)->setInc('comment_total',1);//评论数量+1
				}else if($status==2){
					$vendor->where('id='.$cat_id)->setInc('comment_total',1);//评论数量+1
				}
				$arr['res'] = SUCCESS;
				$arr['msg'] = '添加成功';
			}else{
				unset($res);
				$arr['res'] = ERROR;
				$arr['msg'] = '添加失败';
			}
		}else{
			$arr['res'] = ERROR;
			$arr['msg'] = '内容不能为空！';
		}
			$arr['username'] = $username;
			$arr['nickname'] = $get_uid['nickname'];
			$arr['img_url'] = $get_uid['img_url'];
			
		return json_encode($arr);
		
	}
	/**
	 *筛选列表
	 * 
	 */
	public function Filtrate($post_data = array()){
	F('111',$post_data);
		$P = M('pay');
		$pay = M('pay_cat');
		$member = M('member');
		$collect = M('member_collect');
		require_once('/GlobalFun.class.php'); 
		$global = new GlobalFun();     //公共方法
		$cat_id = intval($post_data['cat_id']);//所在类目
		$real_price = intval($post_data['real_price']);//价格
		$real_start = intval($post_data['real_start']);//自定义价格
		$real_end = intval($post_data['real_end']);
		$use_status =  trim($post_data['use_status']);//使用情况
		$location = trim($post_data['city']);//所在地
		$pay_type = trim($post_data['pay_type']);//交易方式
		$status = intval($post_data['status']);//排序状态值
		$username 	 = trim( $post_data['uid'] );
		$from_where  = intval( $post_data['type'] );
		$lat = trim($post_data['lat']);
		$lon = trim($post_data['lon']);
	
				if($cat_id>0){
					$where.=" and cat_id=".$cat_id;  
				}
				if($real_price>0){
					$where.=" and real_price < ".$real_price;
				}
				if($real_start>0 && $real_end==0){
					$where.=" and real_price > ".$real_start;
				}
				if($real_end>0 && $real_start==0){
					$where.=" and real_price < ".$real_end;
				}
				if($real_start>0 && $real_end>0){
					$where.=" and real_price between '".$real_start."' and '".$real_end."'";
				}
				if($use_status > 0){
						$where.=" and use_status=".$use_status;
					
				}
				if($location == '全国'){
					$where.="";
				}else if($location){
					$where.=" and location='".$location."'";
				}
				if($pay_type >0){
					$where.=" and pay_type=".$pay_type;
				}
		
				
				if($status == 1){//按照时间顺序查询(顺序)
					$filtrate_list = $P->where('status = 1'.$where)->order('add_time desc')->select();		
				}
				if($status == 2){//按照价格顺序查询(顺序)
				
					$filtrate_list = $P->where('status = 1'.$where)->order('real_price')->select();				
				}
				if($status == 3){//按照价格顺序查询(降序)
				
					$filtrate_list = $P->where('status = 1'.$where)->order('real_price desc')->select();				
				}
				if($status == 4){//按照距离顺序查询(顺序)
					$filtrate_list = $P->where('status = 1'.$where)->order('LLTD(lat,lon,'.$lat.','.$lon.')')->select();				
				}			
			F('222',$P->getLastSql());
			$get_uid = $member->where("username='".$username."' AND from_where='".$from_where."'")->getField('uid');
			$collect_pay_id = $collect->field('pay_id')->where('uid='.$get_uid)->select();
			$arr_collect_pay_id = array();
			foreach( $collect_pay_id as $vo ){
				$arr_collect_pay_id[] = $vo['pay_id'];
			}
			foreach($filtrate_list as $k=>$v){                                                                                                                                                                                                     
				if( in_array($v['id'],$arr_collect_pay_id) ){//是否收藏
					$filtrate_list[$k]['collect_id'] = 1;
				}else{
					$filtrate_list[$k]['collect_id'] = 0;
				}
				$nowtime = date("Y-m-d H:i:s",time() ); 
				$edntime = date("Y-m-d H:i:s",$v['add_time']); 
				$filtrate_list[$k]['add_time'] = $this->times($nowtime,$edntime);
			}		
		
		if($global->array_is_null($filtrate_list)){
				$filtrate_list['res'] = ERROR;
				$filtrate_list['msg'] = '数据失败';	
		}
		return json_encode($filtrate_list);
		
	}
	
	
	
	
 }
 
 ?>