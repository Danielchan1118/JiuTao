<?php
namespace Home\Controller;
/**
 *	@name 首页模块 
 *
 */
class IndexController extends HomeController {
	
	//app下载链接
	public function upLoadApk(){ 
        header("Location:http://s.91zhaoyou.com/Public/Uploads/Apk/jiutao.apk");
      	exit();
    }
	/**
	 * @name 首页
	 *
	 */
    public function index(){
		/*
		if(isset($_REQUEST['state'])){//qq登录回调地址
			$this->redirect('Login/qqLogin/state/'.$_REQUEST['state'].'/code/'.$_REQUEST['code']);
		}else{
		*/
		//当前网址 
		$_SESSION['www'] = 'http://'.$_SERVER['HTTP_HOST'];
		//获取商品分类列表
		$_SESSION['catLists'] = $this->getCatList();
		//热门搜索
		$cat = M('pay_cat');
		$_SESSION['hotCatLists'] = $cat->field('id,name')->where('is_status=2')->order('ord_id')->select(); 
		//帮助多少闲置物品找到了主人
		$pay = M('pay');
		$_SESSION['helpbody'] = $pay->count();	
		
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
			$localtion = ",LLTD(p.lat,p.lon,".$res['lat'].",".$res['lon'].")";
		}
		
		
		$pay 	= M('pay');
		$bid	= M('bids');		
		$n		= 24;//每页显示的条数
		//加分页
		$count 		= $pay->field('p.*,m.nickname')->table('oh_pay p')
						->join('LEFT JOIN oh_member as m on m.uid=p.uid')
						->where('p.is_show=1')
						->order('p.add_time DESC'.$localtion)->count();					
		$Page       = new \Think\Page($count,$n);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		$show       = $Page->show();// 分页显示输出
		$arrPayList = $pay->field('p.*,m.nickname')->table('oh_pay p')
						->join('LEFT JOIN oh_member as m on m.uid=p.uid')
						->where('p.is_show=1')						
						->order('p.add_time DESC'.$localtion)->limit($Page->firstRow.','.$Page->listRows)->select();
		
		if( 0< count($arrPayList) ){
			foreach( $arrPayList as $k => $v ){
				$image_url = str_replace("\\","",$v['image_url']);
				$pay_img_url = json_decode(($image_url),true);//当前商品的图片路径
				$arrPayList[$k]['image_url'] = $pay_img_url[0]['imgurl'];
				$time = time();
				if($time<$v['period']){//判断是否竞拍介绍
					$arrPayList[$k]['period_status'] = 1;
				}else{
					$arrPayList[$k]['period_status'] = 2;
				}
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
		$blogroll = M('blogroll');
		$this->lists = $blogroll->order('add_time desc')->select();//友情链接
		$this->assign('page',$show);// 赋值分页输出
		$this->arrPayList = $arrPayList;
		$this->display();
		//}
    }
	
	/**
	 *	@name 商品列表
	 *
	 */	
	public function nearList(){
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
		
		$pay 	= M('pay');
		$bid	= M('bids');
		$n		= 24;//每页显示的条数
	
		//加分页
		$count 		= $pay->field('p.*,m.nickname')->table('oh_pay p')
						->join('LEFT JOIN oh_member as m on m.uid=p.uid')
						->where('p.is_show=1')						
						->order('p.add_time DESC')->count();					
		$Page       = new \Think\Page($count,$n);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		$show       = $Page->show();// 分页显示输出
		$arrPayList = $pay->field('p.*,m.nickname')->table('oh_pay p')
						->join('LEFT JOIN oh_member as m on m.uid=p.uid')
						->where('p.is_show=1')						
						->order($localtion.'add_time DESC')->limit($Page->firstRow.','.$Page->listRows)->select();

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
		$this->arrPayList = $arrPayList;
		$this->display();
    }

	public function test(){
		
	}
	

}