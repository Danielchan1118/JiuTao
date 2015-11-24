<?php 
/**
 * 91推广管理
 */
 class AppExtension{
	//推广包
	public function Extension($datas = array()){
		$username = trim($datas['username']);
		$arr = array();
		
		if($username){
			$user = M("users");
			$stauts = $user->where("username='".$username."'")->getfield("stauts");
			if($stauts == 3){
				//发送包链接
				//$username = base64_encode($username);
				//$arr['package_url'] = "/Web/ArticleDetil/Promotions/prokey/".$username;
				$arr['package_url'] = "/Public/Uploads/Apk/extension/".$username.".apk";
				//二维码
				$arr['images'] = $this->scewm("http://d.91zhaoyou.com".$arr['package_url']);
			}
		}
		return json_encode($arr);		
	}
	
	/*生成二维码*/
	public function scewm($android_url){
		include "/ThinkPHP/Library/ORG/Phpqrcode/qrlib.php"; 
		$PNG_TEMP_DIR = $_SERVER ['DOCUMENT_ROOT'].'/Public/Uploads/temp'.DIRECTORY_SEPARATOR;//url  
		if (!file_exists($PNG_TEMP_DIR))
		mkdir($PNG_TEMP_DIR);
		$imagename =md5($android_url).'.png';//图片名称
		$errorCorrectionLevel = 'H';//'L','M','Q','H' 错误处理级别
		$matrixPointSize = 4;//1-10 每个黑点的像素
		$filename = $PNG_TEMP_DIR.md5($imagename).'.png';	
		QRcode::png($android_url, $PNG_TEMP_DIR.$imagename, $errorCorrectionLevel, $matrixPointSize, 2);    
		return '/Public/Uploads/temp/'.$imagename;
	}
	
 }
 