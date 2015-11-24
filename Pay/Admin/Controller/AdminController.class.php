<?php
/**
 * 后台控制器
 * @author 付敏平
 */
namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller {
	/**
	 * 登陆后获取用户资料
	 */
	public function _initialize(){
		if (session('aid')) {
			$this->aid = session('aid');
			$this->admin_user = session('admin_user');
		}else{
			$this->CheckUsers();
		}
	}

	/**
	 * 检查是否需要用户登录操作
	 */
	public function CheckUsers(){
		$noUserAct = array('UserLogin','UserReg','Verify','CheckVerify','close');
		if(!in_array(ACTION_NAME, $noUserAct)){
			$this->redirect('Admin/Index/UserLogin');
		}
	}

	/**
	 * 验证码图片
	 */
	public function Verify($id = ''){
		$_vc = new \Think\ValidateCode();  //实例化一个对象

		$_vc->showImg();  
		$_SESSION['authnum_session'] = $_vc->getCode();//验证码保存到SESSION中
	}

	/**
	 * 检测输入的验证码是否正确
	 * @param string $code 用户输入的验证码字符串
	 * @param int $id
	 * @return boolean
	 */
	function CheckVerify($code, $id = ''){    
		if($code){
			if($code == $_SESSION['authnum_session']){
				return true;
			}else{
				return false;
			}
		}
	}

	/**
	 * 递归目录,并创建目录
	 */
	public function MakeDir($dir){
		if(!is_dir($dir)&& !is_file($dir)){
			if(strlen($dir)<=1){
				return;
			}
			$dirs = explode('/',$dir);
			$curdir = $dirs[count($dirs)-1];
			$curnamelength = strlen($curdir);
			$parentdir = substr($dir,0,strlen($dir)-$curnamelength-1);
			if(!is_dir($parentdir)&& !is_file($dir))	{
				$this->MakeDir($parentdir);
			}
			mkdir($dir);
		}
	}

	/**
	 * 上传文件
	 */
	public function uploadfile($files){
		 $config = array(    
            'maxSize'    =>    3145728,    
            'savePath'   =>    '/Uploads/images/',    
            'saveName'   =>    array('uniqid',''),    
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),    
            'autoSub'    =>    true,    
            'subName'    =>    array('date','Ymd'),
            );

        $upload = new \Think\Upload($config);// 实例化上传类
        $info   =   $upload->upload($files);
        if(!$info) {    // 上传错误提示错误信息    
            return 1;
        }else{
           return 'Public'.$info['image']['savepath'].$info['image']['savename'];	   
        }
	}

	/**
	 * @name 管理员日志记录
	 * 
	 * @param array $arr        	
	 */
	public function admin_log($arrs) {
		$log = M ( 'admin_exec_log' );
		$arr ['user'] = $this->admin_user;
		$arr ['ip'] = get_client_ip ();
		$arr ['time'] = time ();
		$arr ['remark'] = $arrs;
		$log->add ($arr);
	}

	/**
	 * 二维数组排序函数    	
	 */
	public function array_sort($arr,$keys,$type='asc'){ 
		$keysvalue = $new_array = array();
		foreach ($arr as $k=>$v){
			$keysvalue[$k] = $v[$keys];
		}
		if($type == 'asc'){
			asort($keysvalue);
		}else{
			arsort($keysvalue);
		}
		reset($keysvalue);
		foreach ($keysvalue as $k=>$v){
			$new_array[$k] = $arr[$k];
		}
		return $new_array; 
	} 

	/**
	 * 检测当前操作方法操作权限  	
	 */
	public function checkRole(){ 
		$arrAccess_id = $this->haveRole();//当前管理员具有哪些操作权限ID数组

		$ma = M('menu_admin');
		$menu_list = array();
		foreach($arrAccess_id as $k => $v){
			$list = $ma->where(' pid<>0 AND id='.$v)->getField('action');
			if($list){ $menu_list[] = $list;}
		}
		if(!in_array(ACTION_NAME, $menu_list)){
			$this->error('您无权限此操作！请联系超级管理员',U('Admin/Index/index'));
		}

	}

	/**
	 * @name 当前管理员具有哪些操作权限的ID数组
	 *       	
	 */
	public function haveRole(){ 
		$al = M('admin_login');
		$roleid = $al->where("display=0 AND username='".$_SESSION ['admin_user']."'")->getField('role_id');
		$r = M('role');
		$access_id = $r->table(PREFIX.'role r')->where("r.display=0 AND r.id=".$roleid)
				->join(PREFIX."role_access ra ON ra.role_id=r.id")->getField('ra.access_id');
		 return json_decode($access_id);//得到功能Id
	}
	
	/**
	 * 验证注册/修改用户名
	 */
	public function check_username(){
		$M = M('cooperation_user');
		$user = htmlspecialchars(I('username'));
		if($user){
			if($M->where("username='".$user."'")->find()){
				echo 2;
			}else if(! preg_match ( "/^([a-zA-Z0-9]|[_]){4,16}$/", $user )) {
				echo 3;
			}else{
				echo 1;
			}

		}
	}

	/**
	 * 验证注册邮箱
	 */
	public function email_check(){
		$M = M('cooperation_user');
		$email = I('email');
		$info = $M->where("email='".$email."'")->find();
		if($info){
			echo 2;
		}else{
			echo 1;
		}
	}
	
	/**
	 * $name 分类递归
	 */
	public function catDG( &$arr,$pid ){
		$result = array();
		$item = array();
		foreach( $arr as $k=>$v){	
			$item = $v;
			if($pid==$v['pid']){
				$result[] = $item;
				unset($arr[$k]);
			}
		}
		foreach( $result as $k=>$v){
			$arrSub = $this->catDG($arr,$v['id']);
			if(count($arrSub)){
				$result[$k]['sub'] = $arrSub;
			}else{
				$result[$k]['sub'] = '';
			}
			
		}
		return $result;
	}

}

?>