 <?php 


/**
 * @name 发现
 * @author DanielChan
 */
 class DisCover{
	
	//获取当前用户资料
	public function getUserInfo( $username,$from_where ){
		$m = M('member');
		return $m->where("username='".$username."' AND from_where='".$from_where."'")->find();
	}

	/**
	 * 获取当前用户附近商家商品列表
	 */
    public function distanceOfVendors( $datas = array() ){

		$username 	= trim( $datas['uid'] );
		$from_where = intval( $datas['type'] );		
		$lon 		= trim( $datas['lon'] );
		$lat 		= trim( $datas['lat'] );
		$dtc 		= intval( $datas['dtc'] );
		$toTime 	= time();
		$info		= $this->getUserInfo( $username,$from_where );
		require_once('/GlobalFun.class.php'); 
		$global = new GlobalFun();

		$dislen = ' '.($dtc*DISTANCE).' < LLTD(p.lat,p.lon,'.$lat.','.$lon.') AND LLTD(p.lat,p.lon,'.$lat.','.$lon.') <= '.(($dtc+1)*DISTANCE);
		$m 	  = M('member');
		$ven  = M('vendor');
		$col  = M('member_collect');
		$pay  = M('pay');
		$bids = M('bids');
		
		$strVenCol = array();
		$strPayCol = array();		
		if( $username && $from_where ){
			//当前用户收藏商家ID
			$arrVenCol = $col->field('pay_id')->where('uid='.$info['uid'].' AND status=2')->select();
			//当前用户收藏商品ID
			$arrPayCol = $col->field('pay_id')->where('uid='.$info['uid'].' AND status=1')->select();
			foreach( $arrVenCol as $v){
				$strVenCol[] = $v['pay_id'];
			}
			foreach( $arrPayCol as $v){
				$strPayCol[] = $v['pay_id'];
			}			
		}

		$res_pay = $pay->table('oh_pay p')
					->field( 'p.*, LLTD(p.lat,p.lon,'.$lat.','.$lon.') as distance,m.nickname,m.img_url' )
					->JOIN("LEFT JOIN oh_member as m ON p.uid=m.uid")
					->where( $dislen )->select();/*->where( $dislen )->select();*/
					
		foreach( $res_pay as $k => $v ){				
			$res_pay[$k]['add_time'] = $global->convertUnitsTime(($toTime-$v['add_time'])); 
			$res_pay[$k]['choose'] = 1;
			if( in_array( $v['id'],$strPayCol ) ){
				$res_pay[$k]['collect_id'] = 1;
			}else{
				$res_pay[$k]['collect_id'] = 0;
			}				
			$res_pay[$k]['small_image'] = str_replace("\\","",$v['small_image']);
			if( $res_pay[$k]['small_image'] == ""){
				$res_pay[$k]['small_image'] = str_replace("\\","",$v['image_url']);						
			}
			if( 4 == $v['pay_type'] ){//竞拍价格
				$res_pay[$k]['current_price_prc'] = $bids->where('pay_id='.$v['id'])->getField('current_price');
			}
			if( !$v['nickname'] ){//用户昵称为空时,默认'小淘'
				$res_pay[$k]['nickname'] = '小淘';
			}				
		}	
		$res_pay_num = count($res_pay);
		$res_ven = $ven->field( '*, LLTD(lat,lon,'.$lat.','.$lon.') as distance' )->where( $dislen )->select();/*->where( $dislen )->select();*/
		foreach( $res_ven as $k => $v ){
			$res_ven[$k]['choose'] = 2;
			if( in_array( $v['id'],$strVenCol ) ){
				$res_ven[$k]['collect_id'] = 1;
			}else{
				$res_ven[$k]['collect_id'] = 0;
			}
		}
		foreach( $res_ven as $k => $v ){
			$res_pay[$res_pay_num+$k] = $v;
		}
		$distance_order = array();
		foreach( $res_pay as $v ){
			$distance_order[] = $v['distance'];
		}
		
		array_multisort($distance_order, SORT_ASC, $res_pay);
		foreach( $res_pay as $k => $v ){
			$res_pay[$k]['distance'] = $global->convertUnitsKMeter($v['distance']);
		}
	
		if($global->array_is_null($res_pay)){
			$res_pay['res'] = ERROR;
			$res_pay['msg'] = '数据失败';	
		}		
		
		return json_encode($res_pay);
    }
 
    
 }
 
 ?>