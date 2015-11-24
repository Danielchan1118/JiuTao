<?php
namespace Home\Controller;
use Think\Controller;
class HomeController extends Controller {
	var $lng,$lat;
	
    public function _initialize(){

		//获取经纬度 
		if($_SESSION['city']){
			$_SESSION['location'] = $this->getLL( trim($_SESSION['city']) );
		}elseif($_GET['city']){
			$_SESSION['location'] = $this->getLL( trim($_GET['city']) );
			$_SESSION['city'] = trim($_GET['city']);
		}else{
			$_SESSION['location'] = $this->getLL();//默认本市,原为空,因内网测试,暂时写深圳
		}		
		
    }
		
	//时间转换
	 public function times($nowtime,$edntime){
		header("Content-type: text/html; charset=utf-8");
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
	
	/**
	 * $name 分类递归
	 */
	public function catDG( &$arr,$pid ){
		$result = array();
		$item = array();
		foreach( $arr as $k=>$v){	
			$item = $v;
			if($pid==$v['pid']){
				$result[] = $item;
				unset($arr[$k]);
			}
		}
		foreach( $result as $k=>$v){
			$arrSub = $this->catDG($arr,$v['id']);
			if(count($arrSub)){
				$result[$k]['sub'] = $arrSub;
			}else{
				$result[$k]['sub'] = '';
			}
			
		}
		return $result;
	}

	/**
	 * @name 获取分类信息
	 */	
	public function getCatList(){
		$cat = M('pay_cat');
		$list = $cat->field('id,name,pid,little_img_url')->where('is_hidden=1')->order('ord_id')->select();
		return $this->catDG($list,0);
	}

	/**
	 * @name 获得百度地图经纬度
	 */	
	public function getLL( $name ){
		if( $name ){
			$addr = $name;
		}else{
			$ip    = $_SERVER['REMOTE_ADDR'];
			$addr  = $this->convertip($ip);
			$start = stripos($addr,'省');
			$len   = stripos($addr,'市') ? stripos($addr,'市') : stripos($addr,'县');	
			$addr  = substr($addr,$start+3,($len-$start));		
		}
		
		$_SESSION['cityname'] = $addr ?  (preg_match_all('/无法获取城市/',$addr) ? '火星' : $addr) : '火星';
		$addr = urlencode($addr);
		//$url="http://maps.useso.com/maps/api/geocode/json?address={$addr}&sensor=false";//google数据
		$url 	= "http://api.map.baidu.com/geocoder?address={".$addr."}&output=json&key=C93319dd1af626cb71e11de3ee036917";
		$return = file_get_contents($url);
		$info 	= json_decode($return);
		if($info->status!='OK'){
			echo 'false';
			exit();
		}
		//$result=$info->results[0]->geometry->location; //google 数据
		$result = $info->result->location;
		$res['lat'] = $result->lat;
		$res['lon'] = $result->lng;
		return $res;
	}	
	
	/**
	 * 功能：IP地址获取真实地址函数
	 * 参数：$ip - IP地址
	 */	
	public function convertip($ip) {
	    //IP数据文件路径
	    $dir = $_SERVER ['DOCUMENT_ROOT'].'/Public/IpData/qqwry.dat';
	    $dat_path = $dir;
		
	    //检查IP地址
	   if(!preg_match("/^(\\d{1,3}\\.){3}\\d{1,3}$/", $ip)) {
	        return 'IP Address Error';
	    }
	    //打开IP数据文件
	    if(!$fd = @fopen($dat_path, 'rb')){
	        return 'IP date file not exists or access denied';
	    }

	    //分解IP进行运算，得出整形数
	    $ip = explode('.', $ip);
	    $ipNum = $ip[0] * 16777216 + $ip[1] * 65536 + $ip[2] * 256 + $ip[3];

	    //获取IP数据索引开始和结束位置
	    $DataBegin = fread($fd, 4);
	    $DataEnd = fread($fd, 4);
	    $ipbegin = implode('', unpack('L', $DataBegin));
	    if($ipbegin < 0) $ipbegin += pow(2, 32);
	    $ipend = implode('', unpack('L', $DataEnd));
	    if($ipend < 0) $ipend += pow(2, 32);
	    $ipAllNum = ($ipend - $ipbegin) / 7 + 1;
	   
	    $BeginNum = 0;
	    $EndNum = $ipAllNum;

	    //使用二分查找法从索引记录中搜索匹配的IP记录
	    while($ip1num>$ipNum || $ip2num<$ipNum) {
	        $Middle= intval(($EndNum + $BeginNum) / 2);

	        //偏移指针到索引位置读取4个字节
	        fseek($fd, $ipbegin + 7 * $Middle);
	        $ipData1 = fread($fd, 4);
	        if(strlen($ipData1) < 4) {
	            fclose($fd);
	            return 'System Error';
	        }
	        //提取出来的数据转换成长整形，如果数据是负数则加上2的32次幂
	        $ip1num = implode('', unpack('L', $ipData1));
	        if($ip1num < 0) $ip1num += pow(2, 32);
	       
	        //提取的长整型数大于我们IP地址则修改结束位置进行下一次循环
	        if($ip1num > $ipNum) {
	            $EndNum = $Middle;
	            continue;
	        }
	       
	        //取完上一个索引后取下一个索引
	        $DataSeek = fread($fd, 3);
	        if(strlen($DataSeek) < 3) {
	            fclose($fd);
	            return 'System Error';
	        }
	        $DataSeek = implode('', unpack('L', $DataSeek.chr(0)));
	        fseek($fd, $DataSeek);
	        $ipData2 = fread($fd, 4);
	        if(strlen($ipData2) < 4) {
	            fclose($fd);
	            return 'System Error';
	        }
	        $ip2num = implode('', unpack('L', $ipData2));
	        if($ip2num < 0) $ip2num += pow(2, 32);

	        //没找到提示未知
	        if($ip2num < $ipNum) {
	            if($Middle == $BeginNum) {
	                fclose($fd);
	                return 'Unknown';
	            }
	            $BeginNum = $Middle;
	        }
	    }

	    //下面的代码读晕了，没读明白，有兴趣的慢慢读
	    $ipFlag = fread($fd, 1);
	    if($ipFlag == chr(1)) {
	        $ipSeek = fread($fd, 3);
	        if(strlen($ipSeek) < 3) {
	            fclose($fd);
	            return 'System Error';
	        }
	        $ipSeek = implode('', unpack('L', $ipSeek.chr(0)));
	        fseek($fd, $ipSeek);
	        $ipFlag = fread($fd, 1);
	    }

	    if($ipFlag == chr(2)) {
	        $AddrSeek = fread($fd, 3);
	        if(strlen($AddrSeek) < 3) {
	            fclose($fd);
	            return 'System Error';
	        }
	        $ipFlag = fread($fd, 1);
	        if($ipFlag == chr(2)) {
	            $AddrSeek2 = fread($fd, 3);
	            if(strlen($AddrSeek2) < 3) {
	                fclose($fd);
	                return 'System Error';
	            }
	            $AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
	            fseek($fd, $AddrSeek2);
	        } else {
	            fseek($fd, -1, SEEK_CUR);
	        }

	        while(($char = fread($fd, 1)) != chr(0))
	            $ipAddr2 .= $char;

	        $AddrSeek = implode('', unpack('L', $AddrSeek.chr(0)));
	        fseek($fd, $AddrSeek);

	        while(($char = fread($fd, 1)) != chr(0))
	            $ipAddr1 .= $char;
	    } else {
	        fseek($fd, -1, SEEK_CUR);
	        while(($char = fread($fd, 1)) != chr(0))
	            $ipAddr1 .= $char;

	        $ipFlag = fread($fd, 1);
	        if($ipFlag == chr(2)) {
	            $AddrSeek2 = fread($fd, 3);
	            if(strlen($AddrSeek2) < 3) {
	                fclose($fd);
	                return 'System Error';
	            }
	            $AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
	            fseek($fd, $AddrSeek2);
	        } else {
	            fseek($fd, -1, SEEK_CUR);
	        }
	        while(($char = fread($fd, 1)) != chr(0)){
	            $ipAddr2 .= $char;
	        }
	    }
	    fclose($fd);

	    //最后做相应的替换操作后返回结果
	    if(preg_match('/http/i', $ipAddr2)) {
	        $ipAddr2 = '';
	    }
	    $ipaddr = "$ipAddr1 $ipAddr2";
	    $ipaddr = preg_replace('/CZ88.Net/is', '', $ipaddr);
	    $ipaddr = preg_replace('/^s*/is', '', $ipaddr);
	    $ipaddr = preg_replace('/s*$/is', '', $ipaddr);
	    if(preg_match('/http/i', $ipaddr) || $ipaddr == '') {
	        $ipaddr = 'Unknown';
	    }

	    return  iconv('GB2312', 'UTF-8', $ipaddr);
	}
	
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