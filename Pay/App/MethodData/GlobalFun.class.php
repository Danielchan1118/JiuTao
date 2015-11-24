<?php
/*
 * @name 公共方法
 * @author DanielChan
 */
class GlobalFun{

	//时间单位的转换
	public function convertUnitsTime($time){
		if( 60*60*24 <= $time ){
			$strTime = ceil($time/(60*60*24)).'天前';
		}elseif( 60*60 <= $time ){
			$strTime = ceil($time/(60*60)).'小时前';
		}elseif( 60 <= $time ){
			$strTime = ceil($time/60).'分钟前';
		}else{
			$strTime = '刚刚';
		}
		return $strTime;
	}
	
	//里程单位转换
	public function convertUnitsKMeter($meters){
		if( 1000 <= $meters ){
			$strKMeter = sprintf('%.2f',($meters/1000)).'公里';
		}else{
			$strKMeter = sprintf('%.2f',$meters).'米';
		}
		return $strKMeter;
	}
	
	//判断一个数组是否为空
	public function array_is_null($arr = null){  
        if(is_array($arr)){  
            foreach($arr as $k=>$v){  
				if($v&&!is_array($v)){ return false; }  
				$t = $this->array_is_null($v);  
				if(!$t){ return false; }  
            }  
            return true;  
        }elseif(!$arr){  
           return true;  
        }else{  
           return false;  
        }  
    }
	
	//失效时间单位的转换  proTime到期时间 toTime当前时间 type 1为在售 2为已售
	public function failTime($proTime,$toTime,$type){
		$time = $proTime-$toTime;
		if( 60*60*24 <= $time ){
			$strTime = ceil($time/(60*60*24)).'天';
		}elseif( 60*60 <= $time ){
			$strTime = ceil($time/(60*60)).'小时';
		}elseif( 60 <= $time ){
			$strTime = ceil($time/60).'分钟';
		}else{
			$strTime = $time.'秒';
		}
		if( 1 == $type ){
			return $strTime.'后失效';	
		}elseif( 2 == $type ){
			return $strTime.'前';
		}
	}
	
	//对象转数组
	function object_to_array($obj){
		$_arr = is_object($obj) ? get_object_vars($obj) :$obj;
		foreach ($_arr as $key=>$val){
			$val = (is_array($val) || is_object($val)) ? $this->object_to_array($val):$val;
			$arr[$key] = $val;
		}
		return $arr;
	}
	
	/**
	 * @name 删除发布商品数据
	 *
	 */
	public function paySingleDel( $pay_id ){
		$id = intval($pay_id);
		$pay = M('pay');
		$pco = M('member_collect');
		$pcm = M('comment');
		$pml = M('member_letter');
		$arr_img_url = $pay->where('id='.$id)->getField('image_url');
		$arr_img_url = json_decode($arr_img_url,true);
		foreach( $arr_img_url as $v){
			unlink(substr($v['imgurl'], 1));
		}
		$result = $pay->delete($id);
		if($result){
			$pco->where('pay_id='.$id)->delete();
			$pcm->where('cat_id='.$id)->delete();
			$pml->where('pay_id='.$id)->setField('is_delete',2);
		}
		return $result;
	}
	/**
	 * @name 删除发布评论数据
	 *
	 */
	public function CommentDel( $com_id ){
		$id = intval($com_id);
		$pcm = M('comment');
		if($id){
			$pcm->where('id='.$id)->delete();
		}
		return $result;
	}
	
	/**
	 * @name 用户积分获得记录
	 * @param int $uid 用户
	 * @param int $type
	 */
/*	public function userGetScoreLog($arr){
		$mc = M('member_score');
		$data['uid'] 	  = $arr['uid'];
		$data['dowhaht']  = $arr['dowhaht'];
		$data['score'] 	  = $arr['score'];
		$data['add_time'] = time();	
		$result = $mc->add($data);
		return $result;
	}
*/	
	/**
	 * @name 用户积分获得记录
	 * @param int $uid 用户
	 * @param int $type
	 */
	public function userGetScoreLog($arr){

		$data['username']   = $arr['username'];
		$data['from_where'] = $arr['from_where'];
		$data['pay_id']	    = $arr['pay_id'];
		$data['atr_id'] 	= $arr['atr_id'];
		$data['remark']     = $arr['remark'];
		$data['getscore']   = $arr['getscore'];
		$data['usablegold'] = $arr['usablegold'];
		$data['taskgold']   = $arr['taskgold'];
		$data['add_time']   = time();
		$task = M("pay_log");
		return $task->add($data);
	}	
	
	
	
	
	
	


}









?>