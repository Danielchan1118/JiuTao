<?php 
/**
 * 应用管理接口
 * 应用推荐
 * 游戏应用
 * 应用APP
 */
 class AppManage{
	/**
	 * 推荐列表
	 */
	public function AppList($user_eara = '', $datas = array()){
		$app_type = intval($datas['app_type']);
		$is_rec = intval($datas['is_rec']);
		$username = intval($datas['username']);
		
		$where = "u.stauts = 1 and u.is_throw = 2";
		if($app_type > 0){
			$where.=' and u.app_type = '.$app_type;
		}
		
		if($is_rec > 0){
			$where.=' and u.is_tj = '.$is_rec;
		}
		
		$newa = substr($user_eara,0,strrpos($user_eara,'省'));
		$pros = M("pros");
		if(!$newa){
			$newa = substr($user_eara,0,strrpos($user_eara,'市'));
			if(!$newa){
				$newa = substr($user_eara,0,strrpos($user_eara,'州'));
				if(!$newa){
					$newa = substr($user_eara,0,strrpos($user_eara,'县'));
					if(!$newa){
						$newa = $user_eara;
					}
				}
			}
		}
		
		$zone_id = $pros->where("city_name like '%".$newa."%'")->getfield("invisible_throwid");
		if($zone_id){
			$where.= "u.id not in ".$zone_id;
		}
		
		$pages = intval($datas['cid']);
		
		if(!isset($datas['cid'])){
			$p = 1;
			$n = 100;
		}else{
			$p = $pages;
			$pages = $pages + 1;
			$n = 10;
		}
		if($username){
			$record = M("download_record");
			$appkeys = $record->field("APP_KEY")->where("username='".$username."'")->group("APP_KEY")->select();
			$app_key = '';
			foreach($appkeys as $k=>$v){
				$app_key.= "'".$v['APP_KEY']."'";
				if(count($appkeys)-1 > $k ){
					$app_key.= ',';
				}
			}

			if($appkeys){
				$where.=" and u.APP_KEY not in (".$app_key.")";
			}
		}
		
		$M = M('app');
		$applist = $M->table(PREFIX.'app u')
					  ->join(PREFIX.'throw as w on w.app_id = u.id')
					  ->field('w.id as tid,u.id,u.app_explain,u.app_name,u.app_cover,u.app_integral,w.throw_starttime,w.throw_endtime,w.throw_content')
					  ->where($where)
					  ->order("order_id asc,u.app_downloadnum desc")
					  ->limit($p." , ".$n)
					  ->select();
					
		if(!$applist){
			return -1;
			exit;
		}

		foreach ($applist as $k => $v) {
			$applist[$k]['cid'] = $pages;
			$pages++;
		}
		$res = $this->appinfo($applist);

		return $res;
	}
	/**
	 * 应用详情
	 */
	public function AppDetails($user_eara='', $datas = array()){
		$app_id = intval($datas['app_id']);
		$username = trim($datas['username']);
		if($app_id>0){
			$M = M('app');
			if($app_id >0){
				$appinfo = $M->field('remarks,app_name,app_explain,app_integral,app_images,app_intro,app_cover,app_size,add_time,android_url,signdatas,APP_KEY,package_name')->where('id='.$app_id)->find(); 
				$file_name = substr($appinfo['android_url'],strrpos($appinfo['android_url'],"/")+1);
				$appinfo['url'] = "/Web/Method/HandleAction/app_id/".$app_id."/".$file_name;
				$signdata = unserialize($appinfo['signdatas']);
				

				$app_images = explode(",",$appinfo['app_images']);
				$images = array();

				for($i = 0; $i<count($app_images); $i++ ){
					if($app_images[$i] != '/Public/Plugin/mta/style/images/images.png'){
						$img = new img();
						$img->images = $app_images[$i];
						$images[] = $img;
						unset($img);
					}
				}
				
				$appinfo['app_images'] = $images;
				$newsign = array();
				$onesign = new CSign();
				$i =1;
				if(is_array($signdata)){
					foreach($signdata as $k=>$v){
						if($v['inter'] > 0){
							$onesign->checked = false;
							$onesign->is_sign = 0;
							$onesign->num = "/Public/youmi/image/sign/".$i."_w.png";
							$onesign->disption = $v['num']."天签到";
						
							if($k == 1){
								$onesign->checked = true;
								$onesign->num = "/Public/youmi/image/sign/".$i."_y.png";
								$onesign->disption = "首次安装";
							}else if($k == count($signdata)){
								$onesign->disption = "深度使用";
							}
							$onesign->coin = $v['inter'];
							
							$newsign[] = $onesign;
							$onesign = new CSign();
							$i++;
						}
					}
				}else{
					$onesign->coin = 0;
					$onesign->checked = false;
					$newsign[] = $onesign;
				}
	
				//获取用户已签到的
				$sign_log = M("sign_log");
				$signlog = $sign_log->where("APP_KEY='".$appinfo['APP_KEY']."' && is_sign_data>0 && username='".$username."'")->order("add_time desc")->count();

				$j = $signlog;
				while($signlog > 0){
					$signlog--;
					$newsign[$signlog]->checked = true;
					$newsign[$signlog]->is_sign = 1;
					$newsign[$signlog]->num = "/Public/youmi/image/sign/".$j."_y.png"; 
					$j--;
					
				}
				
				$appinfo['signdatas'] = $newsign;
				
				return json_encode($appinfo);
			}
		}
	}
	
	/**
	 * 广告列表
	 */
	public function adsList(){
		//广告列表
		$ads = M('ads');
		$ads_list = $ads->field("ads_name,url,images")->where("is_show = 1 and type_id = 1")->order("order_id asc")->select(); 
		if(!$ads_list){
			$ads_list = '0';
		}
		return json_encode($ads_list);
	}
	 
	/**
	 * 应用处理数据
	 */
	public function appinfo($applist = array()){
		$apprecommend = '';
		foreach($applist as $k=>$v){
			if($v['throw_starttime'] <= time() && time() <= $v['throw_endtime']){
				$apprecommends['id'] = $v['id'];
				$apprecommends['cid'] = $v['cid'];
				$apprecommends['tid'] = $v['tid'];
				$apprecommends['app_explain'] = $v['app_explain'];
				$apprecommends['app_name'] = $v['app_name'];
				$apprecommends['app_cover'] = $v['app_cover'];
				$apprecommends['remarks'] = $v['remarks'];
				$apprecommends['app_downloadnum'] = $v['app_downloadnum'];
				$apprecommends['app_integral'] = $v['app_integral'];
				$apprecommend.=json_encode($apprecommends);
				if(count($applist)-1 != $k ){
					$apprecommend.=",";
				}
			}
		}

		if($apprecommend{strlen($apprecommend)-1} == ','){
			$apprecommend = substr($apprecommend,0,strlen($apprecommend)-1);
		}

		return $apprecommend;
	}
	
 }
 class CSign{
	public $coin;
	public $checked;
	public $num;
	public $disption;
	function CSign(){
		$this->coin = 0;
		$this->checked = false;
		$this->num = '';
		$this->disption = '';
		$this->is_sign = '';
	}
 }
 
class img{
	public $images;
	function img(){
		$this->images = '';
	}
 }
 ?>