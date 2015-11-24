<?php 
/**
 * 登陆管理接口
 * 完善资料
 * 验证邮箱
 * 进入应用
 */
 class AppSeek{
	
	
	/**
	 *搜索和搜索列表
	 */
	public function SeekList($title,$uid){
		$shop = M('pay');
		$uid = intval($uid);
		$title = trim($title);
		if($title){
			$shop_list = $shop_class->field("id,shop_type")->where("shop_type like '%".$title."%'")->select();
			
		}else{
			if($uid){	       
				$list_info = $M->field('id,content,real_price,pay_price,img_url,add_time,region,point_like,comment_total')->where('status=1 and id='.$uid)->order('add_time desc')->select();
				$list_info['content'] = substr($list_info['content'],0,50);
			}
		}
		return json_encode($shop_list);
	}
	

   
 }
 
 ?>