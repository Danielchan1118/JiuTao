<?php
/**
 * Index 后台管理员登入控制器
 *	@author fumingp
 */
namespace Admin\Controller;
class IndexController extends AdminController {
	/**
	 * 后台首页
	 */
	public function index(){
		$arrAccess_id = $this->haveRole();//当前管理员具有哪些操作权限ID数组

		$ma = M('menu_admin');
		$menu_list = array();
		foreach($arrAccess_id as $k => $v){
			$list = $ma->field('id,name,action,sort')->where('is_show=0 AND pid=0 AND id='.$v)->find();
			if($list){ $menu_list[] = $list;}	//控制器模块
		}
		$menu_list = $this->array_sort($menu_list,'sort');//对数组进行排序
		foreach($menu_list as $kk=>$vv){
			$menu_list_son = $ma->field('name,action,is_show')->where(" is_show=0 AND pid = ".$vv['id'])->order('sort desc')->select();//操作方法模块
			if( $menu_list_son ){ $menu_list[$kk]['sub'] = $menu_list_son; }
		}
		
		$tree =  "[";
			foreach ($menu_list as $v) {
				$tree.="{text:'".$v['name']."',";	
					if($v['sub']){   
						$tree.="items:[";      
						foreach ($v['sub'] as $value) {
			                $tree.="{text : '".$value['name']."',";
			                $url = U($v['action']."/".$value['action']);
			                $tree.='href:"'.$url.'"},';
	              		}
	              		$tree.="]";
					}
		       	 	
	            $tree.="},";
			} 
				
	    $tree.=  "]"; 
		$this->assign("tree",$tree);

		$this->display();
	}


	/**
	 * 后台首页
	 */
	 public function admin_info(){
		date_default_timezone_set('prc');
		$down = M("download_record");
		$user = M('users');
	 	//应用排行榜
		$M =  M('app');
		$applist = $M->field('app_name,app_downloadnum,app_runnum,installcount')->order('installcount desc')->limit('0,10')->select();

		//昨日下载应用量,昨日用户运行量
		$yestime = date("Y-m-d",time()-24*60*60); 
		$startyes = strtotime($yestime);
		$endyes = strtotime($yestime." 23:59:59");
		$where = "add_time between ".$startyes." and ".$endyes;
		$yesdata = $down->field("SUM(move) as move,SUM(nomove) as nomove,SUM(app_money) as money")->where($where)->find();
		//用户积分排行榜
		$userraking = $user->field("username,nickname,goldcount,installcount,taskgold")->order("goldcount desc")->limit("0,10")->select();
		
		//昨日新增用户
		$yescount = $user->where($where)->count();
		
		//昨日商家总充值额
		$pay = M('pay_ok');
		$pay_money = $pay->field('SUM(pay_really_money) as money')->where("pay_time between ".$startyes." and ".$endyes." and order_status = '2,2,2'")->find();

		//今日新增用户
		$starttime = strtotime(date("Y-m-d",time()).' 00:00:00');
		$todaynum = $user->where("add_time between ".$starttime." and ".time())->select();
		
		//昨日商家充值量
		$newarray = array();
        $downarray = array();
        $usercount = 0;

		for($i = 0; $i < 24; $i++ ){
			$times = date('Y-m-d', mktime(0,0,0,date("m"),date('d'),date("Y")))." ".$i.":00:00";  

            $bigtimes = date('Y-m-d', mktime(0,0,0,date("m"),date('d'),date("Y")))." ".$i.":59:59";

            foreach($todaynum as $v){
                if(strtotime($bigtimes) > $v['add_time'] && $v['add_time'] > strtotime($times)){
                    $downarray[$i] += 1;  
                    $usercount++;
                }
            }
            
            if($downarray[$i] <= 0){
            	 $downarray[$i] = 0;
            }
           
            $newarray[$i] = "'".$i.":00'";
		}
		
		$this->title_data = "今日用户统计";
		$this->data_titles = "用户统计";
        $this->categories = "[".implode(",",$newarray)."]";
        $this->downarray = "[".implode(",",$downarray)."]";
		$this->applist = $applist;
		$this->userraking = $userraking;
		$this->yesdata = $yesdata;
		$this->usercount = $yescount;
		$this->display();
	 }

    /**
	 * 管理员登陆
	 */
    public function UserLogin(){
    	if($this->aid > 0){
    		$this->redirect ( 'Admin/Index/index' );	
    	}

		if($_POST){
			$User = M ( 'admin_login' );
			
				$_POST ['password'] = md5 ( 'admin' . md5 ( $_POST ['password'] ) . '91' );
				
				$uinfo = $User->where ( "username = '$_POST[username]' and password = '$_POST[password]'" )->find ();
				//var_dump($_POST ['password']);var_dump($uinfo);exit;
				$is_show = $User->where ( "username = '$_POST[username]' and password = '$_POST[password]'" )->getField('display');
				if( 1 == $is_show ){ $this->error('该账户已被管理员关闭，请联系管理员！');}
				if ($uinfo) {
					session ( 'aid', $uinfo ['id'] );
					session ( 'admin_user', $uinfo ['username'] );

					$data['login_ip'] = $_SERVER["REMOTE_ADDR"];
					$data['login_time'] = time();
					$res = $User->where('id='.$uinfo['id'])->save($data);//记录管理员登录时间及IP
					if($res){
						$this->success ( '91找游管理员登录成功。',U('Index/index'));
					}
				} else {
					$this->error ( '用户名或密码错误。',mysql_error() );
				}
			
		}else{
			$this->time = time();
			$this->display();
		}
    }

    /**
	 * 后台退出
	 * @param int $type 1为退出，2为注销
	 */
	public function UserQuit($type= 2){
		if($this->aid){
			session(null);
			$this->aid = '';
			
			if(!$this->aid){
				if($type == 1){
					$this->success('退出成功。', U('Admin/Admin/close'));
				}else{
					$this->success('注销成功。', U('Admin/Index/UserLogin'));
				}
			}
		}else{
			$this->error('你都没有登录。');
		}
	}
	


}