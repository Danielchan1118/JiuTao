<?php
namespace Home\Controller;

/**
 *	@name 商品模块
 *
 */
class GoodsController extends HomeController {
	/**
	 *	@name 商品详情
	 *
	 */
    public function goodsDetail(){
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
		$M = M('pay');
		$comment= M('comment');
		$auction = M('auction_record');
        $type = 2;
		$c_id = intval($_GET['id']);
		
		$member_col = M('member_collect');
		$member = M('member');
		$username 	= trim( $_SESSION['userinfo']['uid'] );	
        $from_where = intval( $_SESSION['userinfo']['from_where'] );
		$status = 1;
		$where.= ' and status='.$status;
		$where.= ' and pay_id='.$c_id;
		if($username && $from_where){//是否收藏
			$get_uid = $member->where("username='".$username."' AND from_where='".$from_where."'")->find();
			if($get_uid){
				$g_id = $member_col->where("uid=".$get_uid['uid'].$where )->getField('id');
				if($g_id){
					$collect_stat = 1;//收藏1
				}else{
					$collect_stat = 2;//没收藏2
				}
			}
		}
		$this->collect_stat = $collect_stat;//是否收藏
		$shop_list = $M->table('oh_pay as p') //商品详情
							   ->join('oh_member as m on  p.uid = m.uid')
							   ->field('p.*,m.img_url,m.nickname,m.from_where,m.username')
							   ->where("p.id=".$c_id)
							   ->find();
		//F('shop_list',$M->getLastSql());					   
		$shop_list['nickname'] = trim($shop_list['nickname']);
		if($shop_list['pay_type'] == 4){
				$today = time();	
				if($today>$shop_list['period_time']){
					$shop_list['auction_due_time'] = 1;//竞拍已过期
				}else{
					$shop_list['auction_due_time'] = 2;//竞拍还没过期
				}
				$time = time();
				if($shop_list['period_time']>$time){
					$status = 1;
				}else{
					$status = 2;
				}
				$bids = M('bids');
				
				$shop_list['count_num'] = intval(count($auction->where('pay_id='.$c_id)->group('uid')->select()));//竞价的人数
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
		$this->pay_type = $shop_list['pay_type'];//是否是竞价商品		
		
			if($c_id >0){//详情页
				$M->where('id='.$c_id)->setInc('browse',1);//点击浏览次数加1
				
				$comment_list = $comment->table('oh_comment c') //评论列表
							->join('oh_member as m on c.uid = m.uid')
							->field('c.content,c.add_time,c.uid,m.nickname,m.img_url')
							->where("c.is_show = 0 and c.status=1 and c.cat_id=".$c_id)
							->order('add_time desc')
							->select();
				$about_shop = $M->order('add_time desc')->limit(4)->select();//相关商品
				foreach( $about_shop as $kk => $vv ){
					$image_url = str_replace("\\","",$vv['image_url']);
					$pay_img_url = json_decode(($image_url),true);//当前商品的图片路径
					$about_shop[$kk]['image_url'] = $pay_img_url[0]['imgurl'];
				}
				$a_id = $auction->where('pay_id='.$c_id)->MAX(id);
				$a_name= $auction->where('id='.$a_id)->getField('did_username');
				$shop_list['a_name'] = $a_name;
				$images = explode(',',$shop_list['image_url']);
				$arr = array();
				foreach($images as $k=>$v){
					$i = explode(":",$v);
					$c = array("}","\\","]",'"');
					$arr['image'][] = trim(str_replace($c," ",$i[1]));		
					
				}
				$p_uid = $M->where('id='.$c_id)->getField('uid');
				$member_uid = $member->where('uid='.$p_uid)->getField('username');
				$this->member_uid = $member_uid;
				$nowtime = date("Y-m-d H:i:s",time() ); 
				$edntime = date("Y-m-d H:i:s",$shop_list['add_time']); 
				$shop_list['dis_time'] = $this->times($nowtime,$edntime);
				$shop_list['con'] = $this->times($nowtime,$edntime);
				$shop_list['period_time'] = date("m/d/Y H:i:s",$shop_list['period_time']);
			
			}
			$blogroll = M('blogroll');
			$this->lists = $blogroll->order('add_time desc')->select();//友情链接
			$this->arr = $arr;
			$this->shop_list = $shop_list;
			$this->comment_list = $comment_list;
			$this->about_shop = $about_shop;
			$this->username = $username;
			$this->display();		
		
    }
	/**
	 *登入
	 *
	 **/
	public function ajax_auction(){
		$auction = M('auction_record');
		$pay = M('pay');
		$member = M('member');
		$pay_id = intval($_GET['pay_id']);
		$a_id = $auction->where('pay_id='.$pay_id)->MAX(id);
		$p_uid = $pay->where('id='.$pay_id)->getField('uid');
		$member_uid = $member->where('uid='.$p_uid)->getField('username');
		$a_id = $auction->where('pay_id='.$pay_id)->MAX(id);
		$a_name= $auction->where('id='.$a_id)->getField('did_username');
		$a_nick= $auction->where('id='.$a_id)->getField('nickname');
		$datas['a_name'] = $a_name;
		$datas['a_nick'] = $a_nick;
		$datas['user_info'] = $_SESSION['userinfo']['uid'];
		$datas['member_uid'] = $member_uid;
		$this->ajaxReturn($datas);
		
	}
	
	//点击竞拍
	public function click_auction(){
		$bids = M('bids');
		$member = M('member');
		$auction = M('auction_record');
		$username 	= trim( $_SESSION['userinfo']['uid'] );	
		$this->username = $username;
        $from_where = intval( $_SESSION['userinfo']['from_where'] );
		$pay_id = intval( $_GET['cat_id']);//商品id
		$price = intval( $_GET['all_price']);
		$markups = intval( $_GET['add_price']);
		$get_uid = $member->where("username='".$username."' AND from_where='".$from_where."'")->find();
		if($price){
			$bids_uid = $auction->where('uid='.$get_uid['uid'])->find();
			$bids->where('pay_id='.$get_uid['uid'])->setInc('current_price',$markups);
			$bids->where('pay_id='.$pay_id)->setInc('current_price',$markups);
			$data['uid'] =  $get_uid['uid'];
			$data['add_time'] =  time();
			$data['price'] =  $price + $markups;
			$data['bids_num'] =  1;
			$data['pay_id'] =  $pay_id;
			$data['nickname'] =  $get_uid['nickname'];
			$data['did_username'] =  $get_uid['username'];
			$one_id = $auction->add($data);
			if($one_id){
				$arr['biddingname'] =$get_uid['nickname'];// $b[0]['nickname'];
				$arr['biddinguid'] = $get_uid['username'];//$b[0]['username'];
				$count_user = $auction->where('pay_id='.$pay_id)->group('uid')->select();
				$arr['bids_person_num'] = count($count_user);
				$arr['current_price_prc'] = intval($bids->where('pay_id='.$pay_id)->getField('current_price'));
				$arr['bids_num'] = intval($auction->where('pay_id='.$pay_id)->sum('bids_num'));
				$arr['user_info'] = $_SESSION['userinfo']['name'];
			}
		}
		
		$this->ajaxReturn($arr);
		
	} 
	
	
	/**
	 *评论
	 *@name
	 * com:内容
	 */
	 public function Addcomment(){
		$member = M('member');
		$comment = M('comment');
		$pay = M('pay');
		$c_id = intval($_GET['con_id']);
		$com = trim($_GET['com']);
		$username 	= trim( $_SESSION['userinfo']['uid'] );		
        $from_where = intval( $_SESSION['userinfo']['from_where'] );
		if($com){
			$get_uid = $member->field('uid,nickname,img_url')->where("username='".$username."' AND from_where='".$from_where."'")->find();
			$data['content'] = $com;
			$data['cat_id'] =  $c_id;
			$data['add_time'] = time();
			$data['uid'] = $get_uid['uid'];
			$data['status'] = 1; 
			$comm_data = $comment->add($data);
			if($comm_data){
				$pay->where("id=".$c_id)->setInc('comment_total',1);
				$res = 1;
			}else{
				$res = 2;
			}
			
		}
		$this->ajaxReturn($res);
	 }

	/**
	 * @name 搜索信息
	 *
	 */	
	public function search(){
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
		
		if( $res['lat'] ){
			$localtion = "LLTD(p.lat,p.lon,".$res['lat'].",".$res['lon']."),";
		}	
		
		$word = trim(htmlspecialchars($_GET['keyword']));

		if( $word ){
			$pay  = M('pay');	
			$bid  = M('bids');
			$n	  = 10;//每页显示的条数 

			//默认根据时间排序
			$count = $pay->field('p.id,p.title,p.content,p.image_url,p.real_price,p.location,p.add_time,m.nickname,c.name')
							->table('oh_pay p')
							->join('LEFT JOIN oh_member as m on m.uid=p.uid')
							->join('LEFT JOIN oh_pay_cat as c on c.id=p.cat_id')
							->where("(p.title like '%".$word."%') OR (p.content like '%".$word."%') OR (c.name like '%".$word."%') AND p.is_show=1")
							->order($localtion.'p.add_time DESC')
							->count();
			$Page       = new \Think\Page($count,$n);// 实例化分页类 传入总记录数和每页显示的记录数(20)
			$show       = $Page->show();// 分页显示输出
			$arrPayList = $pay->field('p.id,p.title,p.content,p.image_url,p.real_price,p.location,p.add_time,m.nickname,c.name')
							->table('oh_pay p')
							->join('LEFT JOIN oh_member as m on m.uid=p.uid')
							->join('LEFT JOIN oh_pay_cat as c on c.id=p.cat_id')
							->where("(p.title like '%".$word."%') OR (p.content like '%".$word."%') OR (c.name like '%".$word."%') AND p.is_show=1")
							->order($localtion.'p.add_time DESC')
							->limit($Page->firstRow.','.$Page->listRows)->select();//order这里在add_time后面还需要加一个距离LLDT()
					
			if( 0< count($arrPayList) ){
				foreach( $arrPayList as $k => $v ){
					$image_url = str_replace("\\","",$v['image_url']);
					$pay_img_url = json_decode(($image_url),true);//当前商品的图片路径
					$arrPayList[$k]['image_url'] = $pay_img_url[0]['imgurl'];
					if( 4 == $v['pay_type'] ){
						$bidInfo = $bid->where('pay_id='.$v['id'])->find();
						if( 0< count($bidInfo) ){
							$arrPayList[$k]['biddata'] = $bidInfo;
						}else{
							$arrPayList[$k]['biddata'] = '';
						}
					}
				}						
			}
			
			$this->assign('page',$show);// 赋值分页输出
			$this->assign('word',$word);
			$this->arrPayList = $arrPayList;
			$this->display();
		}
	}	
	
	/**
	 *	@name 商品列表
	 *
	 */	
	public function goodsList(){
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
		
		if( $res['lat'] ){
			$localtion = "LLTD(p.lat,p.lon,".$res['lat'].",".$res['lon']."),";
		}	
		
        $type 		= trim(htmlspecialchars($_GET['type']));
		$cat_id 	= intval($_GET['id']);
		$goodsType  = intval($_GET['goodstype']);
		
		$cat 	= M('pay_cat');
		$pay 	= M('pay');
		$bid	= M('bids');
		$n		= 10;//每页显示的条数
		
		if( $goodsType ){
			$count		= $pay->field('p.*,m.nickname')->table('oh_pay p')
							->join('LEFT JOIN oh_member as m on m.uid=p.uid')
							->where('p.pay_type='.$goodsType.' AND p.is_show=1')
							->order($localtion.'p.add_time DESC')->count();
			$Page       = new \Think\Page($count,$n);// 实例化分页类 传入总记录数和每页显示的记录数(20)
			$show       = $Page->show();// 分页显示输出				
			$arrPayList = $pay->field('p.*,m.nickname')->table('oh_pay p')
							->join('LEFT JOIN oh_member as m on m.uid=p.uid')
							->where('p.pay_type='.$goodsType.' AND p.is_show=1')
							->order($localtion.'p.add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();//order这里在add_time前面还需要加一个距离LLDT()
			
			if( 0< count($arrPayList) ){
				foreach( $arrPayList as $k => $v ){
					$image_url = str_replace("\\","",$v['image_url']);
					$pay_img_url = json_decode(($image_url),true);//当前商品的图片路径
					$arrPayList[$k]['image_url'] = $pay_img_url[0]['imgurl'];
				}
			}else{
				$arrPayList = '';
			}
			switch($goodsType){
				case 1:
					$word['name'] 		 = '出售';	
					$word['cat_img_url'] = '/Public/Home/style/image/search-icon-big.png';
					break;
				case 2:
					$word['name'] = '交换';	
					$word['cat_img_url'] = '/Public/Home/style/image/search-icon-big.png';
					break;	
				case 3:
					$word['name'] = '赠送';	
					$word['cat_img_url'] = '/Public/Home/style/image/search-icon-big.png';
					break;					
			}
		}else{
			//是否是一级分类
			$arrCatId = $cat->field('id')->where('pid='.$cat_id)->select();
			if( 0 < count($arrCatId) ){			
				//一级子类ID
				$arrNewCatId = array();
				foreach($arrCatId as $v){ $arrNewCatId[] = $v['id']; }
				array_push($arrNewCatId,$cat_id.'');
				$strCatId 	= implode(',',$arrNewCatId);
				//加分页
				$count 		= $pay->field('p.id,p.title,p.content,p.image_url,p.real_price,p.location,p.add_time,m.nickname')->table('oh_pay p')
								->join('LEFT JOIN oh_member as m on m.uid=p.uid')
								->where('p.cat_id IN ('.$strCatId.') AND p.is_show=1')
								->order($localtion.'p.add_time DESC')->count();					
				$Page       = new \Think\Page($count,$n);// 实例化分页类 传入总记录数和每页显示的记录数(20)
				$show       = $Page->show();// 分页显示输出
				$arrPayList = $pay->field('p.id,p.title,p.content,p.image_url,p.real_price,p.location,p.add_time,m.nickname')->table('oh_pay p')
								->join('LEFT JOIN oh_member as m on m.uid=p.uid')
								->where('p.cat_id IN ('.$strCatId.') AND p.is_show=1')
								->order($localtion.'p.add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();//order这里在add_time前面还需要加一个距离LLDT()
				
				if( 0< count($arrPayList) ){
					foreach( $arrPayList as $k => $v ){
						$image_url = str_replace("\\","",$v['image_url']);
						$pay_img_url = json_decode(($image_url),true);//当前商品的图片路径
						$arrPayList[$k]['image_url'] = $pay_img_url[0]['imgurl'];
						if( 4 == $v['pay_type'] ){
							$bidInfo = $bid->where('pay_id='.$v['id'])->find();
							if( 0< count($bidInfo) ){
								$arrPayList[$k]['biddata'] = $bidInfo;
							}else{
								$arrPayList[$k]['biddata'] = '';
							}
						}
					}						
				}else{
					$arrPayList = '';
				}
				//标题,图标
				$word = $cat->field('name,cat_img_url')->where('id='.$cat_id)->find();	
			}else{
				$count		= $pay->field('p.*,m.nickname')->table('oh_pay p')
								->join('LEFT JOIN oh_member as m on m.uid=p.uid')
								->where('p.cat_id='.$cat_id.' AND p.is_show=1')
								->order($localtion.'p.add_time DESC')->count();
				$Page       = new \Think\Page($count,$n);// 实例化分页类 传入总记录数和每页显示的记录数(20)
				$show       = $Page->show();// 分页显示输出				
				$arrPayList = $pay->field('p.*,m.nickname')->table('oh_pay p')
								->join('LEFT JOIN oh_member as m on m.uid=p.uid')
								->where('p.cat_id='.$cat_id.' AND p.is_show=1')
								->order($localtion.'p.add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();//order这里在add_time前面还需要加一个距离LLDT()
				
				if( 0< count($arrPayList) ){
					foreach( $arrPayList as $k => $v ){
						$image_url = str_replace("\\","",$v['image_url']);
						$pay_img_url = json_decode(($image_url),true);//当前商品的图片路径
						$arrPayList[$k]['image_url'] = $pay_img_url[0]['imgurl'];
					}
				}else{
					$arrPayList = '';
				}
				//标题
				if($type){
					$word = $cat->field('name,cat_img_url')->where('id='.$cat_id)->find();			
				}else{
					$Info 	 = $cat->field('name,cat_img_url')->where('id='.$cat_id)->find();	
					$wordPar = $cat->query('select name from oh_pay_cat where id=(select pid from oh_pay_cat where id='.$cat_id.')');
					if($Info){ $word = array('name'=>$wordPar[0]['name'].($Info['name'] ? '-'.$Info['name'] : $Info['name']),'cat_img_url'=>$Info['cat_img_url']) ; }
				}			
			}		
		}
		
		//标题
		if($word){ $this->assign('word',$word); }	
		$this->assign('page',$show);// 赋值分页输出
		$this->arrPayList = $arrPayList;
		$this->display();
    }
	
	//收藏
	public function favorites(){
		$pay_id = intval($_POST['goods_id']);
		$member_col = M('member_collect');
		$member = M('member');
		$username 	= trim( $_SESSION['userinfo']['uid'] );	
        $from_where = intval( $_SESSION['userinfo']['from_where'] );
		$status = 1;
		$where.= ' and status='.$status;
		$where.= ' and pay_id='.$pay_id;
		
		if($username && $from_where){
			$get_uid = $member->where("username='".$username."' AND from_where='".$from_where."'")->find();
			$pay = M('pay');
			$ven = M('vendor');
			if($get_uid){
				$g_id = $member_col->where("uid=".$get_uid['uid'].$where )->getField('id');
				if($g_id){
					$result = $member_col->where('id='.$g_id)->delete();
						if($result){
							$arr['msg'] = '取消收藏成功';//取消收藏
							$arr['action'] = 3;
							if( 1 == $status ){
								$pay->where('id='.$pay_id)->setDec('point_like');//收藏数量-1
							}elseif( 2 == $status ){
								$ven->where('id='.$pay_id)->setDec('collect_total');//收藏数量-1
							}												
						}
				}else{
					$data['uid'] = $get_uid['uid'];
					$data['pay_id'] = $pay_id;
					$data['cadd_time'] = time();
					$data['status'] = $status;
					$result = $member_col->add($data);
					if($result){
						$arr['action'] = 1;
						$arr['code'] = SUCCESS;
						if( 1 == $status ){
							$pay->where('id='.$pay_id)->setInc('point_like');//收藏数量+1
						}elseif( 2 == $status ){
							$ven->where('id='.$pay_id)->setInc('collect_total');//收藏数量+1
						}
					}else{
						$arr['action'] = 2;
						$arr['code'] = ERROR;
						$arr['mes'] ="数据出错！";
					}

				}
			
			}
		}else{
			$arr['code'] = KEHUERROR;
			$arr['msg'] = '客户端出错！';
		}
		
		 
		$this->ajaxReturn($arr);
	
	}
	
	/**
	 *	@name 商品列表
	 *
	 */	
	public function getType(){
		
	
	}	
	
	
	
}