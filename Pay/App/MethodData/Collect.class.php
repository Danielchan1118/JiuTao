<?php 
/**
 * @name 收藏
 * @author DanielChan
 */
 class Collect{
	/**
	 * @name 添加收藏，收藏取消
	 */
    public function getCollect( $datas=array()){
		$username 	 = trim( $datas['uid'] );
		$from_where  = intval( $datas['type'] );
		$pay_id 	 = intval( $datas['pay_id'] );
		$status		 = intval( $datas['status'] );
		
		$m = M('member');	
		if( $username && $from_where ){ 			
			$m_info = $m->where("username='".$username."' AND from_where='".$from_where."'")->find();//得到当前用户资料		
			if($m_info){
				$c = M('member_collect');
				$id = $c->where("uid='".$m_info['uid']."' AND pay_id='".$pay_id."' AND status=".$status )->getField('id');//查看当前商品di是否有收藏
				$pay = M('pay');
				$ven = M('vendor');
				
				if( $id ){ //如$id有值，则说明已收藏，下一步需删除此条信息
					$result = $c->delete($id);
					$res['msg'] = 'B';//取消收藏
					if($result){ 
						if( 1 == $status ){
							$pay->where('id='.$pay_id)->setDec('point_like');//收藏数量-1
						}elseif( 2 == $status ){
							$ven->where('id='.$pay_id)->setDec('collect_total');//收藏数量-1
						}												
					}
				}else{ //如$id为null，则说明未收藏，下一步需添加此条信息
					$data['uid']       = $m_info['uid'];
					$data['pay_id']    = $pay_id;
					$data['status']    = $status;
					$data['cadd_time'] = time();
					$result = $c->add($data);
					$res['msg'] = 'A';//收藏成功
					if($result){ 
						if( 1 == $status ){
							$pay->where('id='.$pay_id)->setInc('point_like');//收藏数量+1
						}elseif( 2 == $status ){
							$ven->where('id='.$pay_id)->setInc('collect_total');//收藏数量+1
						}
					}
				}
				if($result){
					$res['res'] = SUCCESS;
				}else{
					$res['res'] = ERROR;
					$res['msg'] = '数据出错';
				}
			}
		}else{
			$res['res'] = KEHUERROR;
			$res['msg'] = '请先登录';
		}
		return json_encode($res);
	}
    
 }
 
 ?>