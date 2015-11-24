<?php
/**
 * 后台管理员控制器
 * @author huyuming
 */
namespace Admin\Controller;
class AdminLoginController extends AdminController {
	/**
	 * 添加/修改管理员  
	 */
	public function AddAdmin($id = ''){
		$this->checkRole();
		$edit_id = intval($_POST['edit_id']);
		$M = M('admin_login');
		$data['username'] = trim($_POST['username']);
		if($data['username']){
			$data['password']   = md5 ( 'admin' . md5 ( $_POST ['password'] ) . '91' );
			$data['role_id']    = trim($_POST['role']);
			$data['display']    = trim($_POST['is_show']);
			$data['login_ip']   = get_client_ip();
			$data['login_time'] = time();

			if($_POST['username'] =='' || $_POST ['password'] ==''){
				$this->error('用户名或密码不能为空',U('AdminLogin/AddAdmin'));
			}
			if (strlen ( $_POST ['password'] ) < 6 || strlen ( $_POST ['password'] ) > 22) {
				$this->error ( '您提交的数据有误:密码长度为6到22位的字符,请检查您的输入!' );
			}


			if($edit_id >0 ){
				$log_str = '修改管理员为'.$data['username'];
        		$this->admin_log($log_str); //加监控日志
				$res = $M->where('id='.$edit_id)->save($data);
				$mess = '修改成功';		
			}else{
				$user_find =  $M->where("username='".$data['username']."'")->find(); 
				if($user_find){
					$this->error('管理员已存在！');
				}
				$log_str = '添加管理员为'.$data['username'];
        		$this->admin_log($log_str); //加监控日志
				$res = $M->add($data);
				var_dump($res['id']);
				$mess = '添加成功';	
			}

			if($res){
				$this->success($mess,U('AdminLogin/ListAdmin'));
			}else{
				$this->error('操作失败'.mysql_error(),U('AdminLogin/ListAdmin'));
			}
		}else if($edit_id > 0){
			$managerinfo = $M->where('id='.$edit_id)->find();
			$this->ajaxReturn($managerinfo);
		}else{
			$this->error('操作失败',U('AdminLogin/ListAdmin'));
		}
	}
	
	public function test(){
		$user = M('admin_login');
		$edit_id = intval($_POST['edit_id']);
		
		
	}

	/**
	 * 管理员列表
	 */
	public function ListAdmin($eid = ''){
	
		$this->checkRole();
		
		$M = M('admin_login');
		//角色列表
		$r = M('role');
		$this->roleList = $r->where('display=0')->order('id DESC')->select();
		
		$n      = 30;
		$counts = $M->count();
		$Page   = new \Think\Page($counts,$n);// 实例化分页类 传入总记录数和每页显示的记录数
		$admin_list = $M->table('oh_role as a')->join('oh_admin_login as u on a.id = u.role_id')->field('a.role_name,u.username,u.display,u.login_ip,u.login_time,u.id')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->admin_list  = $admin_list; 
		$this->Page  = $Page->show(); 
		$this->display();
		
}

	/**
	 * 管理员删除
	 */
	public function adminDEl(){
		$this->checkRole();
		$log_str = '删除管理员';
        $this->admin_log($log_str); //加监控日志
		
		$del_id = $_POST['orderid'];
		$arr = array();
    	if($del_id){
			$M = M('admin_login');
			$nowId = $M->where("username='".$_SESSION ['admin_user']."'")->getField('id');
			if(is_array($del_id)){
				if(in_array('1', $del_id)){
					if ( "admin1" != $_SESSION ['admin_user'] ) {
						$arr['ret'] = -1;
						$arr['message'] = "您没有权限,不能删除管理员账户";	
					}
				}else if(in_array($nowId, $del_id)){
					$arr['ret'] = -1;
					$arr['message'] = "不能删除当前管理员账户";	
				}
				$this->ajaxReturn($arr);
				exit;
			}
			
			if( $nowId == $del_id){
				$arr['ret'] = -1;
				$arr['message'] = "不能删除当前管理员账户";	
				$this->ajaxReturn($arr);
				exit;
			}else if(!$del_id){
				$arr['ret'] = -1;
				$arr['message'] = "请选择删除管理员";	
				$this->ajaxReturn($arr);
				exit;
			}
		
	    	if(is_array($del_id)){
				$cids = implode ( ',', $del_id ); 

				$map ['id'] = array (
					'in',
					$cids 
				);
			}else{
				$map ['id'] = $del_id;
			}

			$res = $M->where($map)->delete();
			
			if($res){
			 	$arr['ret'] = 1;
			 	$arr['message'] = "删除成功";	
			}else{
	     		$arr['ret'] = -1;
			 	$arr['message'] = "删除失败";	
	     	}
	     	$this->ajaxReturn($arr);
    	}

	}

	/**
	 * 角色列表
	 * @author DanielChan
	 */
	public function roleList(){
		$this->checkRole();
		$r = M('role');
		$n      = 20;
		$counts = $r->count();
		$Page   = new \Think\Page($counts,$n);// 实例化分页类 传入总记录数和每页显示的记录数
		$rList = $r->limit($Page->firstRow.','.$Page->listRows)->select();
		$P = $Page->firstRow;
            if($P == 0){
                $P = 1;
            }
            foreach ($rList as $k => $v) {
                $rList[$k]['cid'] = $P;
                $P++;
            }
        $this->rList = $rList;
		$this->Page  = $Page->show(); 
		$this->display();
	}

	/**
	 * 角色编辑
	 * @author DanielChan
	 */
	public function roleEdit(){
		$this->checkRole();
		$edit_id = intval($_POST['edit_id']);
		$editid = intval($_POST['editid']);
		$data['role_detail'] = trim($_POST["detail"]);
		if($editid> 0 || $data['role_detail']){
			$data['role_name']   = trim($_POST["name"]);
			$data['display'] 	 = intval($_POST["display"]);
			if( empty($_POST["name"]) ){ $this->error('角色名不能为空!',U('AdminLogin/roleList')); }
			$r = M('role');
			if($editid){
				$res = $r->where('id='.$editid)->save($data);//修改数据
				$mes = '修改成功!';
				$log_str = '修改角色名为'.$data['role_name'];
			}else{
				$res = $r->add($data);//添加数据
				$mes = '添加成功!';
				$log_str = '添加角色名为'.$data['role_name'];
			}
			if($res){			
        		$this->admin_log($log_str); //加监控日志
				$this->success($mes,U('AdminLogin/roleList'));
			}else{
				$this->error('操作失败!');
			}			
		}else if($edit_id>0){
			$r = M('role');
			$rInfo = $r->where('id='.$edit_id)->find();
			$this->ajaxReturn($rInfo);
		}else{
	        $this->error('操作失败',U('AdminLogin/roleList'));
	    }
		
	}

	/**
	 * 角色删除
	 * @author DanielChan
	 */
	public function roleDel(){
		$this->checkRole();
		$del_id = intval($_POST['orderid']);
		$r         = M('role');
		$role_name = $r->where('id='.$del_id)->getField('role_name');
		$log_str   = '删除角色名'.$role_name;
        $this->admin_log($log_str); //加监控日志
		if($del_id > 0){
			$ra = M('role_access');
			$ra->where('role_id='.$del_id)->delete();//删除角色权限数据
			$result = $r->where('id='.$del_id)->delete();
			if( $result ){
				$arr['ret'] = 1;
			 	$arr['message'] = "删除成功";	
			}else{
				$arr['ret'] = -1;
			 	$arr['message'] = "删除失败";	
			}
			$this->ajaxReturn($arr);
		}
	}
	
}

?>