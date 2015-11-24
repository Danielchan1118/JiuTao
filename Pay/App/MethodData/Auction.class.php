<?php 
/**
 * @name 竞拍
 * @author 
 */
 class Auction{
 
	/**
	 * 商家竞拍
	 */
	public function AuctionShow( $post_data=array()){
		require_once('/GlobalFun.class.php'); 
		$global = new GlobalFun();
		$bids = M('bids');
		$member = M('member');
		$auction = M('auction_record');
		$username = trim( $post_data['uid']);
		$from_where = trim( $post_data['type']);
		$pay_id = intval( $post_data['cat_id']);//商品id
		$price = intval( $post_data['price']);
		$markups = intval( $post_data['markups']);
		$get_uid = $member->where("username='".$username."' AND from_where='".$from_where."'")->find();
		
		$bids_uid = $auction->where('uid='.$get_uid['uid'])->find();
				$bids->where('pay_id='.$get_uid['uid'])->setInc('current_price',$markups);
				$bids->where('pay_id='.$pay_id)->setInc('current_price',$markups);
				$data['uid'] =  $get_uid['uid'];
				$data['add_time'] =  time();
				$data['price'] =  $price + $markups;
				$data['bids_num'] =  1;
				$data['pay_id'] =  $pay_id;
				$data['nickname'] =  $get_uid['nickname'];
				$data['did_username'] =  $get_uid['username'];
				$one_id = $auction->add($data);
		
		$arr['biddingname'] =$get_uid['nickname'];// $b[0]['nickname'];
		$arr['biddinguid'] = $get_uid['username'];;//$b[0]['username'];
		$count_user = $auction->where('pay_id='.$pay_id)->group('uid')->select();
		$arr['bids_person_num'] = count($count_user);
		$arr['current_price_prc'] = $bids->where('pay_id='.$pay_id)->getField('current_price');
		$arr['bids_num'] = $auction->where('pay_id='.$pay_id)->sum('bids_num');
		
		return json_encode($arr);
		
	}

    
 }
 
 ?>