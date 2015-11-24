<?php
/**
 * 平台活动控制器
 * @author danielchan
 */
namespace Admin\Controller;
class ActivityController extends AdminController {

	/**
	 * 顶级栏目活动设置
	 */
	public function ActivityEdit(){
		$this->checkRole();
		$atr = M('activity_taskrule');
		$edit_id = intval($_POST['edit_id']);
		$editid = intval($_POST['editid']);
		$data['atr_name'] = trim($_POST['name']);

		if($editid >0 || $data['atr_name']){
			$data['atr_detail']  = trim($_POST['detail']);
			$data['atr_toscore'] = intval(trim($_POST['score']));
			$data['is_on'] 	     = intval(trim($_POST['on']));
			
			if($_POST['data1'] == "" && "" == $_POST['data3'] ){
				$data['data1'] = intval($_POST['data2']);
			}elseif($_POST['data1'] == "" && "" == $_POST['data2'] ){
				$data['data1'] = trim($_POST['data3']);
			}elseif( $_POST['data3'] == "" && "" == $_POST['data2'] ){
				$data['data1'] 	= intval($_POST['data1']);
			}			
			$data['add_time']    = time();	

			if($_FILES['imgFile']['size'] > 0  ){
				$appPath = './Public/Uploads/Web/images';
				$this->MakeDir($appPath);
				$appth =  $appPath . '/'; 
				$upload = new \Think\Upload();// 实例化上传类    
				$upload->maxSize = 3145728;
				$upload->rootPath = $appth;
				$upload->savePath = '';
				$upload->saveName = array();
				$upload->exts     = array('jpg', 'gif', 'png', 'jpeg');
				$upload->autoSub  = true;
				$upload->subName  = array('date','Ymd');

				$info   =   $upload->uploadOne($_FILES['imgFile']);    
				if(!$info) {// 上传错误提示错误信息        
					$this->error($upload->getError(),U('Activity/ActivityList'));    
				}else{// 上传成功 获取上传文件信息     
					$data['img_url'] =  substr($appPath."/".$info['savepath'].$info['savename'],1); 
					unlink(substr($_POST['img_url1'], 1));
				}
			}
			if($data['atr_name']==''){
				$this->error('任务名不能为空！');
			}

			if($editid > 0){
				$ret = $atr->where('atr_id='.$editid)->save($data);
				if($ret){
					$log_str = $this->admin_user.'修改平台活动'.$edit_id.'积分,现在积分'.$data['atr_toscore'];
					$arr['res'] = 1;
					$arr['mess'] = "修改成功";
				}else{
					$arr['res'] = -1;
					$arr['mess'] = "修改失败";
				}
			}else{
				$ret = $atr->add($data);
				if($ret){
					$log_str = $this->admin_user.'平台活动'.$editid.'积分,现在积分'.$data['atr_toscore'];
					$arr['res'] = 1;
					$arr['mess'] = "添加成功";
				}else{
					$arr['res'] = -1;
					$arr['mess'] = "添加失败";
				}
			}
			$this->success($arr['mess'],U('Activity/ActivityList'));
			$this->admin_log($log_str); 	
		}else if($edit_id > 0){
			$atrinfo =  $atr->where('atr_id='.$edit_id)->find();
			$this->ajaxReturn($atrinfo);
		}
	}

	/**
	 * 活动列表
	 */
	public function ActivityList(){
		$this->checkRole();
		$atr = M('activity_taskrule');
		$n = 20;
		$counts = $atr->count();
		$Page  = new \Think\Page($counts,$n);// 实例化分页类 传入总记录数和每页显示的记录数
		$task_list = $atr->order("add_time desc")->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach($task_list as $k => $v){
			$task_list[$k]['par_name'] = $atr->where('atr_id='.$v['atr_pid'])->getField('atr_name');
		}
		$this->task_list = $task_list;
		$this->Page  = $Page->show();
		$this->display();
	}

	/**
	 * 删除活动
	 */
	public function delTaskRule($id){
		$this->checkRole();
		$arrId = array(5,6,14,16,20,21,38);
		if(in_array($id,$arrId)){ $this->error('系统活动,不可删除!',U('Activity/firstMenuList')); exit();}
		$atr = M('activity_taskrule');
		$img_url = $atr->field('atr_pid,img_url')->where('atr_id='.$id)->find();
		unlink(substr($img_url['img_url'], 1));
		$count = $atr->where('atr_pid='.$id)->count();
		if($count > 0){
			$this->error('该活动下有子活动,请确认无子活动后进行删除!');
		}else{			
			if($atr->delete($id)){
				$log_str = '平台活动栏目一级菜单删除';
				$this->success('删除成功!',U('Activity/firstMenuList'));
			}else{
				$this->error('删除失败!',U('Activity/firstMenuList'));
			}
		$this->admin_log($log_str); 	
		}
				
	}
	
	/**
	 * $name 添加平台活动
	 */
	public function firstMenu(){	
		$this->checkRole();
		if($_POST){
			$data['atr_name']    = $_POST["name"];
			$data['atr_detail']  = $_POST["detail"];
			$data['atr_toscore'] = $_POST["score"];
			$data['add_time'] 	 = time();
			if($data['atr_name']==''){ $this->error('任务名不能为空！'); }
			$atr = M('activity_taskrule');
			if($_FILES['imgFile']['size'] > 0  ){
				$appPath = './Public/Uploads/Web/images';
				$this->MakeDir($appPath);
				$appth 	 =  $appPath . '/'; 
				$upload  = new \Think\Upload();// 实例化上传类    
				$upload->maxSize = 3145728;
				$upload->rootPath = $appth;
				$upload->savePath = '';
				$upload->saveName = array();
				$upload->exts     = array('jpg', 'gif', 'png', 'jpeg');
				$upload->autoSub  = true;
				$upload->subName  = array('date','Ymd');

				$info   =   $upload->uploadOne($_FILES['imgFile']);    
				if(!$info) {// 上传错误提示错误信息        
					$this->error($upload->getError(),U('Activity/ActivityList'));    
				}else{// 上传成功 获取上传文件信息     
					$data['img_url'] =  substr($appPath."/".$info['savepath'].$info['savename'],1); 
					//unlink(substr($_POST['img_url1'], 1));
				}
			}
			$res = $atr->add($data);
			if($res){
				$atr->where('atr_id='.intval($res))->setField('intentid',intval($res));
				$this->success('添加成功！',U('Activity/ActivityList'));
			}else{
				$this->error('添加失败！',U('Activity/ActivityList'));
			}
		}else{
			$this->display();
		}
	}
	
	/**
	 * @name 大转盘添加规则
	 */
	public function roleWheelAdd(){
		$this->checkRole();
		$id = $_GET['id'];
		if($_POST){
			$wheel = M("activity_wheel");
			$arr['wheel_name'] 	  = trim($_POST["name"]);
			$arr['wheel_v'] 	  = intval($_POST["gliva"]);
			$arr['wheel_coin'] 	  = intval($_POST["getcoin"]);
			$arr['num_return'] 	  = intval($_POST["return_id"]);
			$arr['wheel_content'] = trim($_POST["role_content"]);

			if(empty($arr['wheel_name'])){ $this->error("轮盘奖励名不能为空"); }
			if(empty($arr['wheel_v'])){ $this->error("倍率不能为空"); }
			if(empty($arr['wheel_coin'])){ $this->error("奖励积分不能为空"); }
			if(empty($arr['num_return'])){ $this->error("前端返回值不能为空"); }

			if($id){
				$res = $wheel->where('wheel_id='.$id)->save($arr);
			}else{
				$count = $wheel->count();
				if( 7 <= $count ){ $this->error("规则添加已到上限,如需添加请联系技术人员");exit; }
				$res = $wheel->add($arr);
			}
			if($res){
				$this->success('编辑成功',U('Activity/roleWheelList'));
			}else{
				$this->error('编辑失败',U('Activity/roleWheelList'));
			}						
		}else{
			$wheel = M("activity_wheel");
			$this->info = $wheel->where('wheel_id='.$id)->find();
			$this->display();
		}	
	}

	/**
	 * @name 大转盘规则列表
	 */
	public function roleWheelList(){
		$this->checkRole();
		$wheel = M("activity_wheel");
		$this->list = $wheel->select();
		$this->display();
	}



}


?>