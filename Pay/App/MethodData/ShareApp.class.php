<?php 
/**
 * @name 商家展示
 * @author DanielChan
 */
 class ShareApp{
 
	/**
	 * 显示商家详情
	 */
	public function ShareIndex( $post_data=array()){
		$member = M('member');
		$username 	 = trim( $post_data['uid'] );
		$from_where  = intval( $post_data['type'] );
		$status = intval($post_data['status']);		
		
		if($status == 1){//分享App
			$get_score = $member->where("username='".$username."' AND from_where='".$from_where."'")->setInc('score',15);
		} 
		if($status == 2){//
			$get_score = $member->where("username='".$username."' AND from_where='".$from_where."'")->setInc('score',10);
		}
		if($status == 3){
			$get_score = $member->where("username='".$username."' AND from_where='".$from_where."'")->setInc('score',10);
		}
		
	}

    
 }
 
 ?>