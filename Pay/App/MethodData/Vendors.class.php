<?php 
/**
 * @name 商家展示
 * @author DanielChan
 */
 class Vendors{
 
	/**
	 * 显示商家详情
	 */
	public function vendorShow( $datas=array()){
		$id = intval( $datas['id'] );
		$lon = trim( $datas['lon'] );
		$lat = trim( $datas['lat'] );
		require_once('/GlobalFun.class.php'); 
		$global = new GlobalFun();
		
		$ven = M('vendor');
		$com = M('comment');
		$m 	 = M('member');
		$ven->where('id='.$id )->setInc('click_on_num');
		$venInfo = $ven->field('*,LLTD(lat,lon,'.$lat.','.$lon.') as distance')->where('id='.$id )->find();//得到该商家的信息
		$venInfo['add_time'] = $global->convertUnitsTime( time()-($venInfo['add_time']) );//时间戳转换成字符串
		$venInfo['distance'] = $global->convertUnitsKMeter( $venInfo['distance'] );
		$venInfo['datas'] = $com->where('cat_id='.$id.' AND is_show=0 AND status=2')->order('add_time DESC')->select();//获取该商家下的所有评论内容
		if( $venInfo['datas'] ){			
			foreach( $venInfo['datas'] as $k => $v){			
				$member_info = $m->field('username,nickname,img_url')->where('uid='.$v['uid'])->find();//得到评论人的个人资料
				$venInfo['datas'][$k]['img_url']  = $member_info['img_url'];
				$venInfo['datas'][$k]['nickname'] = $member_info['nickname'];
				$venInfo['datas'][$k]['username'] = $member_info['username'];
				$venInfo['datas'][$k]['com_id']   = ($k+1);
				$venInfo['datas'][$k]['add_time'] = $global->convertUnitsTime( time()-($v['add_time']) );
			}		
		}else{
			$venInfo['datas'] = null;
		}
		return json_encode($venInfo);
	}

    
 }
 
 ?>