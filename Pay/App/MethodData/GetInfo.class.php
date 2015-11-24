<?php 
/**
 * @name 商家展示
 * @author DanielChan
 */
 class GetInfo{
 
	/**
	 * 显示商家详情
	 */
	public function index( $post_data=array()){
		$member = M('member');
		$username = trim( $post_data['uid']);
		$from_where = trim( $post_data['type']);
		$get_uid = $member->field('qq,mobiephone')->where("username='".$username."' AND from_where='".$from_where."'")->find();
		if($get_uid){
			$get_uid['res'] = SUCCESS;
			$get_uid['msg'] = "成功";
		}else{
			$get_uid['res'] = ERROR;
			$get_uid['msg'] = "数据有错";
		}
		return json_encode($get_uid);
	}

    
 }
 
 ?>