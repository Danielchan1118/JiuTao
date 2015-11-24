<?php
namespace Home\Controller;
/**
 *	@name 发布模块 
 *
 */
class ReleaseController extends HomeController {
	
	public function index(){
		//获取商品分类列表
		
	}
	
	public function publish_rule(){
	//当前登陆用户
		$this->userinfo = $_SESSION['userinfo'];
		$this->catList = $_SESSION['catLists'];
		$blogroll = M('blogroll');
		$this->lists = $blogroll->order('add_time desc')->select();//友情链接
		$this->display();
	}
	 public function release(){
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
		$a = $this->GoodsCat();
		$this->arr = $a;
		if($_SESSION['userinfo'] == null){
			//$a = $this->redirect('Index/index');
			header("Content-type: text/html; charset=utf-8"); 
			echo "未登录不能发布商品哦，亲！";exit();
		}
		$blogroll = M('blogroll');
		$this->lists = $blogroll->order('add_time desc')->select();//友情链接
		$this->display();
	}
	

	//商品发布
	 public function ajax_release(){
		
		$M = M('pay');
		$member = M('member');
		$username 	= trim( $_SESSION['userinfo']['uid'] );	
        $from_where = intval( $_SESSION['userinfo']['from_where'] );
		$res = $_SESSION['location'];//有传城市搜索城市名，默认本市
		if($username && $from_where){
			$get_uid = $member->where("username='".$username."' AND from_where='".$from_where."'")->find();
			$data['uid'] 	       = $get_uid['uid'];
			$data['lat'] 	       = trim( $res['lat'] );//纬度
			$data['lon'] 	       = trim( $res['lon']);//经度
			$data['cat_id'] 	   = intval($_POST['cat_id']);//分类id
			$data['title'] 	       = trim( $_POST['title']);
			$data['content'] 	   = trim( $_POST['content']);
			$data['real_price']    = intval( $_POST['pay_price']);
			$data['pay_price'] 	   = intval($_POST['real_price']);
			$data['use_status']    = intval($_POST['use_status']);
			
			$data['pay_type'] = trim($_POST['pay_type']);
			$data['is_show']       = 1;
			$data['weixin']        = trim($_POST['weixin']);//微信账号
			$data['qq']            = trim($_POST['qq']);
			$data['phone']         = trim($_POST['phone']);
			$data['period'] 	   = intval($_POST['period']);//发布周期
			$ip    = $_SERVER['REMOTE_ADDR'];
			$addr  = $this->convertip($ip);
			$start = stripos($addr,'省');
			$len   = stripos($addr,'市');	
			$addr  = substr($addr,$start+3,($len-$start));	
			$data['location'] 	   = $addr;//所在地址
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
			
			$data['period_time'] = $period_time;

			$data['status']  = 1;			
			$data['image_url']  = $_POST['img_url'];
			$data['small_image'] = $_POST['former_url'];

				$result = $M->add($data);
				$arr['current_price'] = intval( $_POST['current_price']);//当前价格
				$arr['starting_price'] = intval( $_POST['current_price']);//加价幅度
				$arr['markups'] = trim( $_POST['markups']);//加价幅度
				//$pay_type_id = $M->where('id='.$result)->getField('pay_type');
				if(4 == $data['pay_type']){//是否是竞拍
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
					
					$resScore = $member->where('uid='.$get_uid['uid'])->setInc('score',$score);//发布加5积分
					if($resScore){
						$arr['uid'] = $get_uid['uid'];
						$arr['dowhaht'] = $get_uid['nickname'].'发布商品赠送'.$score.'积分';
						$arr['score'] = $score;
						$this->userGetScoreLog($arr);				
					}
					*/
					$srule = M('activity_taskrule');
					$score = $srule->where('atr_id=40')->getField('atr_toscore');//发布获得的积分额					
					$resScore = $member->where('uid='.$get_uid['uid'])->setInc('score',$score);//发布加5积分
					
					if($resScore){
						$arr['username']   = $username;
						$arr['from_where'] = $from_where;
						$arr['pay_id']	   = $result;
						$arr['atr_id'] 	   = 40;
						$arr['remark']     = '发布商品';
						$arr['getscore']   = $score;
						$arr['usablegold'] = $score;
						$arr['taskgold']   = $score;
						$global->userGetScoreLog($arr);					
					}					
					$res['res'] = SUCCESS;
					$res['msg'] = '发布成功';
					$res['url'] = 'http://www.07260.com/Goods/goodsDetail?id='.$result;
					//$this->redirect('Index/index');
				}else{
					unset($res);
					$res['res'] = ERROR;
					$res['msg'] = '发布失败';
					$res['url'] = '';
				}
		}else{
				$res['res'] = ERROR;
				$res['msg'] = '数据出错2';
		}
		$this->ajaxReturn($res);
		
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
		return  $arr;
		//$this ->arr = $arr;
			
	}
	//图片上传
    public function uploadify(){
    	$targetFolder = $_POST['url']; // Relative to the root
    	$targetPath = "http://www.07260.com";
		//echo $_POST['token'];
		$verifyToken = md5($_POST['timestamp']);
		//var_dump($_POST['token']);
		//var_dump($_FILES);exit;
		
		
		if($_FILES['Filedata']['size'] > 0 ){
			 $config = array(    
				'maxSize'    =>    3971520,    
				'savePath'   =>    '/images/',    
				'saveName'   =>    array('uniqid',''),    
				'exts'       =>    array('jpg', 'png', 'jpeg'),    
				'autoSub'    =>    true,    
				'subName'    =>    array('date','Ymd'),
            );

			$upload = new \Think\Upload($config);// 实例化上传类
			$info   =   $upload->upload($_FILES);
			if(!$info) {    // 上传错误提示错误信息    
				$arr['res'] = ERROR;
				$arr['msg'] = 'upload faild';
				$arr['url'] = '';
				$arr['bre_url'] = '';
			}else{
				$image = new \Think\Image(); 
				foreach($info as $file) {
                    $thumb_file = './Uploads'.$file['savepath'].$file['savename'];
                    $save_path = './Uploads'.$file['savepath'].'m_'.$file['savename'];
                    $image->open( $thumb_file )->thumb(100, 100,\Think\Image::IMAGE_THUMB_SCALE)->save( $save_path );
                     
                }
				$arr['res'] = SUCCESS;
				$arr['msg'] = '上传成功';
				$arr['url'] = substr($thumb_file,1);
				$arr['bre_url'] = substr($save_path,1);
			}
			//if(!$info) {    // 上传错误提示错误信息    
			//	echo $info ='请重新上传图片';
			//}else{
			//	echo $info= $targetPath.'/uploads'.$info['Filedata']['savepath'].$info['Filedata']['savename'];
			//}
			$this->ajaxReturn($arr);
		}

    }
	
	//删除图片
    public function del(){
		if($_POST['name']!=""){
			$info = explode("/", $_POST['name']);
			//var_dump($_POST['name']);
			//count($info)
			$url='/uploads/images/'.$info[5].'/'.$info[count($info)-1];
			//unlink(substr($url,1));
			if(unlink(substr($url,1))){
				$arr['meg'] = "删除成功";
				$arr['res'] = "1";
			}else{
				$arr['meg'] = "删除失败";
				$arr['res'] = "-1";
			}
		}else{
			$arr['meg'] = "服务器错吴";
			$arr['res'] = "-2";
		}
		$this->ajaxReturn($arr);
	
	}
	
}
	

	
	

?>