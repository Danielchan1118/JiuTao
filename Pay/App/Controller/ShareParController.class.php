<?php 
/**
 * $name 分享详情
 * @author 
 */
namespace App\Controller;
class ShareParController extends AppController
{
	
		
		
	
	function is_mobile(){
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		if(trim($user_agent) == '')return true;//如果客户端信息为空，我们也认为该设备为手机设备
		$mobile_agents = Array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi","android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio","au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu","cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly","fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi","htc","huawei","hutchison","inno","ipad","ipaq","ipod","jbrowser","kddi","kgt","kwc","lenovo","lg","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo","mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-","moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia","nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-","playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo","samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank","sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte",'Opera Mini','Kindle','Silk/','Mobile','baidu Transcoder');
		$is_mobile = false;
		foreach($mobile_agents as $device){
		if(stristr($user_agent,$device) !== FALSE){
		$is_mobile = true;
		break;
		}
		}
		return $is_mobile;
	}
	
	
	 public function articleShow(){
		//<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1, initial-scale=no" />
		//<meta name="apple-mobile-web-app-capable" content="yes"/>
		$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
		$iphone = (strpos($agent, 'iphone')) ? true : false;
		$ipad = (strpos($agent, 'ipad')) ? true : false;
		$android = (strpos($agent, 'android')) ? true : false;
		//if($iphone || $ipad){
			//echo "<script>window.location.href='http://www.1.com'</script>";
		//} 
		//if($android){
			//echo "<script>window.location.href='wyrshare:/status/shop_id/2'</script>";  
		//}  
		//F('datas',$_REQUEST);
		if($this->wp_is_mobile()){
			$this->mobile = 1;//移动浏览器
		}else{
			$this->mobile = 2;//不是移动浏览器
		}  
		/*var_dump($_SERVER['HTTP_USER_AGENT']);
		if($this->is_weixin()){
			echo "是微信";
		 }else{
			echo "请使用微信访问本网址。";
		}*/
		if($this->is_weixin()){
			$this->is_weixin = 1;
		 }
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'QQ') || strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')){
			$this->wei_qq = 1;
		}
		$M = M('pay');
		$manager = M('manager');
		$shop_id = intval($_REQUEST['shop_id']);
		$status = intval($_REQUEST['status']);
		
		if($status ==1){
			$article = $M->table('oh_pay as p')
							   ->join('oh_member as m on  p.uid = m.uid')
							   ->field('*,m.img_url,m.nickname')
							   ->where("p.id=".$shop_id)
							   ->find();
			//echo $M->getLastSql(); 
			$images = explode(',',$article['image_url']);
			$arr = array();
			foreach($images as $k=>$v){
				$i = explode(":",$v);
				$c = array("}","\\","]",'"');
				$arr['image'][] = trim(str_replace($c," ",$i[1]));			
				
			}		
			
		}else if($status == 2){
			$article = $M->table('oh_vendor')->where("id=".$shop_id)->find();
		}
		$M->where("id=".$shop_id)->setInc('browse',1);//发布加5积分
		$nowtime = date("Y-m-d H:i:s",time() ); 
		$edntime = date("Y-m-d H:i:s",$article['add_time']); 
		$article['add_time'] = $this->times($nowtime,$edntime);
		$this->arr = $arr;
		$this->shop_id = $shop_id;
		$this->status = $status;
		$this->article = $article;
		$this->display();

	}
	//时间转换
	 public function times($nowtime,$edntime){
		header("Content-type: text/html; charset=utf-8");
		//$nowtime =  "2009-07-08 15:20:23";
		//$edntime = "2009-07-08 15:15:23";
		$count_data = explode(" ",$nowtime);
		$count_data1 = explode(" ",$edntime);
		$Date_1 = $count_data[0];
		$Date_3 = $count_data[1];
		$Date_2 = $count_data1[0];
		$Date_4 = $count_data1[1];
			$Date_List_a1=explode("-",$Date_1);
			$Date_List_a3=explode(":",$Date_3);
			$Date_List_a2=explode("-",$Date_2);
			$Date_List_a4=explode(":",$Date_4);
 
			$d1=mktime(0,0,0,$Date_List_a1[1],$Date_List_a1[2],$Date_List_a1[0]);
			$d3=mktime($Date_List_a3[0],$Date_List_a3[1],$Date_List_a3[2],0,0,0);

			$d2=mktime(0,0,0,$Date_List_a2[1],$Date_List_a2[2],$Date_List_a2[0]);
			$d4=mktime($Date_List_a4[0],$Date_List_a4[1],$Date_List_a4[2],0,0,0);
			$Days=round((($d1-$d2)/3600/24)*24)+round(($d3-$d4)/3600);
			$minute = round((strtotime($nowtime)-strtotime($edntime))/60);
			if($minute<=1){
				$Days = '刚刚';
			}
			if($minute>1 && $minute<60){
				$Days = round($minute).'分钟';
			}
			if($minute>60 && $minute<=60*24){
				$Days = round($minute/60).'小时前';	
			}
			if($minute>60*24 && $minute<60*24*30){
				$Days = round($minute/(60*24)).'天前';	
			}
			if($minute>60*24*30 && $minute=60*24*30*365){
				$Days = round($minute/(60*24*30)).'月前';
			}
				 
		return $Days;
		
	}
	
	public function wp_is_mobile() {
    static $is_mobile;
 
    if ( isset($is_mobile) )
        return $is_mobile;
 
    if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
        $is_mobile = false;
    } elseif ( strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false 
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false ) {
            $is_mobile = true;
    } else {
        $is_mobile = false;
    }
 
    return $is_mobile;
	}

	public function is_weixin(){ 
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
		  return true;
		}else{
		  return false;
		}
	}
	public function is_qq(){ 
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'QQ') !== false ) {
		  return true;
		}else{
		  return false;
		}
	}


	



}











?>