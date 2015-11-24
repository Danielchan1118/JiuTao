<?php

namespace Web\Controller;
class ArticleDetilController extends WebController{
	/**
	 * 获取提升等级资讯
	 */
	public function infos($aid = 0){
		if($aid>0){
			$article = M("article");
			$articles = $article->where("id=".$aid)->find();
			$this->articles = $articles;
			$this->display();
		}
	}
	
	/**VIP等级图片**/
	public function VipImages(){
		echo "/Public/Uploads/Apk/level_instructions1.jpg";
	}
	
	/**
	 * 获取推广包
	 */
	public function Promotions($prokey = ''){
		if($prokey){
			$username = base64_decode($prokey);
			$android_url = "./Public/Uploads/Apk/extension/".$username.".apk";
			$this->ReturnAsDownFile(realpath($android_url),"91zhaoyou.apk");
		}
		
	}
	
	/**
	 * 下载路径
	 */
	public function ReturnAsDownFile($filepath, $filename_ret){
		ob_clean();
		ob_start();
		if(!file_exists($filepath)){//判断文件是否存在
			echo "文件不存在";
			exit();
		}
		$size = filesize($filepath);
		$size2 = $size-1;

		$range = 0;
		if(isset($_SERVER['HTTP_RANGE'])) {
			header('HTTP /1.1 206 Partial Content');
			$range = str_replace('=','-',$_SERVER['HTTP_RANGE']);
			$range = explode('-',$range);
			$range = trim($range[1]);
			header('Content-Length: '.intval($size-intval($range)) );
			header('Content-Range: bytes '.$range.'-'.$size2.'/'.$size);
		} else {
			header('Content-Length: '.$size);
			header('Content-Range: bytes 0-'.$size2.'/'.$size);
		}
		header('Content-type: application/octet-stream');
		header('Accenpt-Ranges: bytes');
		header("Cache-control: public");
		header("Pragma: public");
		//解决在IE中下载时中文乱码问题
		$ua = $_SERVER['HTTP_USER_AGENT'];
		if(preg_match('/MSIE/',$ua)) {
			$ie_filename = str_replace('+','%20',urlencode($filename_ret));
			header('Content-Disposition:attachment; filename='.$ie_filename);
		}  else {
			header('Content-Disposition:attachment; filename='.$filename_ret);
		}

		$fp = fopen($filepath,'rb+');
		fseek($fp,$range);
		while(!feof($fp)) {
			set_time_limit(0);
			print(fread($fp,4096));
			flush();
			ob_flush();
		}
		fclose($fp);
		ob_end_flush();
		exit();
	}
	
}
?>