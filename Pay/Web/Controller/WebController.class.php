<?php
/**
 * 后台控制器
 * @author 付敏平
 */
namespace Web\Controller;
use Think\Controller;
class WebController extends Controller {
	/** 用户达到VIP判断 **/
	public function IsLevel($username = ''){
		if($username){
			$user = M('users');
			$level = $user->where("username='".$username."'")->getField('level');

			$grade = M('grade');
			$gradelist = $grade->field("grade,getglod,integral")->order("grade asc")->select();
			
			$arr = array();
			$arr['nowintegral'] = $gradelist[$level-1]['integral'];
			$arr['level'] = $gradelist[$level]['grade'];
			$arr['integral'] = $gradelist[$level]['integral'];
			$arr['getglod'] = $gradelist[$level]['getglod'];		
			return $arr;
		}
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
	
	/**
     * @name 提示系统正在优化中
     *
     */
	 public function DaZhuanPanTest() {
		$nameWrong =  "<script type='text/javascript'>
    					$(function(){
							window.setTimeout(function(){ window.Android.ExitGame();},2000);
						});
				 </script>";
		$this->nameWrong = $nameWrong;
		$this->display("Web/DaZhuanPanTest");
	 }
}

?>