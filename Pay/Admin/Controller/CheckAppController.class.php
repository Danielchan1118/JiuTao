<?php
/**
 * 创建应用
 */
namespace Admin\Controller;
class CheckAppController extends AdminController {
	/**
	 * 创建应用 第一步保存
	 */
	public function CreateAppFrist(){
		$app_name = trim($_POST['app_name']);
		$app_type = trim($_POST['app_type']);
		$app_explain = trim($_POST['app_explain']);
		$app_cover = trim($_POST['app_cover']);
		$app_images = trim($_POST['app_images']);
		if($app_name && $app_type && $app_explain && $app_cover && $app_images){
			$app_key = $this->getRandChar();
			$data['app_name'] = $app_name;
			$data['app_type'] = $app_type;
			$data['app_explain'] = $app_explain;
			$data['app_cover'] = $app_cover;
			$data['app_images'] = $app_images;
			$data['APP_KEY'] = $app_key;
			$data['did'] = $this->did;
			$data['add_time'] = time();
			$app = M("app");
			$res = $app->add($data);
			if($res){
				$arr['app_key'] = $app_key;
				$arr['app_id'] = $res;
				$this->ajaxReturn($arr);
			}else{
				echo 1;
			}
		}else{
			echo 1;
		}
	}
	/**
	 * 创建应用第三步
	 */
	public function CreateAppThree($app_id = ''){
		$app = M('app');
		$app_key = trim($_POST['app_key']);
		
		if($app_key){
			$app_name = trim($_POST['app_name']);
			$app_type = intval($_POST['app_type']);
			$app_explain = trim($_POST['app_explain']);
			$app_cover = trim($_POST['app_cover']);
			$app_images = trim($_POST['app_images']);

			$data['app_name'] = $app_name;
			$data['app_type'] = $app_type;
			$data['app_explain'] = $app_explain;
			$data['app_cover'] = $app_cover;
			$data['app_images'] = $app_images;
			
			$res = $app->where("APP_KEY='".$app_key."'")->save($data);
			
			if($res){
				$arr['ret'] = 1;
 			}else{
				$arr['ret'] = -1;
			}

			$this->ajaxReturn($arr);
		}else if($app_id){
			$app_info = $app->field('APP_KEY,did,package_name,app_name,app_explain,app_cover,app_images,app_type,stauts,add_time,android_url')->where("id=".$app_id)->find();
			if($app_info['package_name']){
				$this->dotype = 1;
			}else{
				$this->dotype = 2;
			}
			
			$app_images = explode(",",$app_info['app_images']);
			$this->app_images = $app_images;
			$this->appinfo = $app_info; 
			$this->app_id = $app_id;
			$this->display('Index/create_app');
		}
	}

	/**
	 * 检测应用是否重名
	 */
	public function is_AppName(){
		$appname = trim($_POST['appname']);

		if($appname){
			$APP = M("app");
			$res = $APP->where("app_name='".$appname."' and is_delete=1")->find();

			if($res){
				echo 1;
			}else{
				echo 2;
			}
		}
	}
	/**
	 * 生成随机APP_KEY
	 */
	function getRandChar(){
	   $str = null;
	   $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	   $max = strlen($strPol)-1;

	   for($i=0;$i<5;$i++){
		$str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
	   }
		return strtoupper(MD5($str.time()));
	}
	
	/**
	 * ajax下载图片
	 */
	public function image_upload(){
		if($_FILES['app_cover']['size'] > 0){
			$app_name = "app_cover";
		}else if($_FILES['app_images']['size'] > 0){
			$app_name = "app_images";
		}else if($_FILES['app_images2']['size'] > 0){
			$app_name = "app_images2";
		}else if($_FILES['app_images3']['size'] > 0){
			$app_name = "app_images3";
		}else if($_FILES['app_images4']['size'] > 0){
			$app_name = "app_images4";
		}

		if($_FILES[$app_name]['size'] > 0 ){
			$uploadPath ="Public/Uploads/images/APP"; 
			if ($_FILES[$app_name]["size"] < 1024 * 1024 * 2) { 
				if ($_FILES[$app_name]["error"] > 0) { 
					echo "<script>parent.callback('2',false)</script>";
					exit;
				}else{ 
					$suffix = substr($_FILES[$app_name]["name"], strrpos($_FILES[$app_name]["name"], '.') + 1); 
					$imgDate=date("YmdHis"); 
					$name = $imgDate . rand("1000", "9999") . "." . $suffix; 

					if (move_uploaded_file($_FILES[$app_name]["tmp_name"], $uploadPath."/".$name)) { 
						$res = "/".$uploadPath."/".$name;; 
						echo "<script>parent.callback('1','".$app_name."','".$res."')</script>"; 
						unlink(substr($_POST[$app_name], 1));  
						exit;
					}else{
						echo "<script>parent.callback('2',false)</script>";
						exit;
					}
				} 
			}else{ 
				echo "<script>parent.callback('图片大小不能超过2M',false)</script>"; 
			} 
		}else if($_FILES['Filedata']['size'] > 0 ){
			$did = intval($_POST['did']);
			$app_key = trim($_POST['app_key']);
			$dotype = trim($_POST['dotype']);

			$appPath = './Public/Uploads/App/'.$did;
			$this->MakeDir($appPath);
			$appth =  $appPath . '/'; 
			$upload = new \Think\Upload();// 实例化上传类    
			$upload->maxSize = 0;
			$upload->rootPath = $appth;
			$upload->savePath = '';
			$upload->saveName = array('uniqid','');
			$upload->exts     = array('apk');
			$upload->autoSub  = true;
			$upload->subName  = array();
			$info   =   $upload->uploadOne($_FILES['Filedata']);    
			if(!$info) {// 上传错误提示错误信息        
				echo $upload->getError(); 					
			}else{// 上传成功 获取上传文件信息         
				$data['android_url'] =  substr($appth,1).$info['savename'];  
			}
			//获取apk信息
			$dataapk = $_SERVER ['DOCUMENT_ROOT'].$data['android_url'];
			$p = new \Think\ApkParser();// 实例化上传类    
			$res = $p->open($dataapk);
			$xml = $p->getXML();
			preg_match('~android:versionName="(.*?)"~',$xml,$matches);
			$version='';if(count($matches)>1){$version=$matches[1];}
			preg_match('~android:minSdkVersion="(.*?)"~',$xml,$matches);
			$minsys='';if(count($matches)>1){$minsys=$this->get_android($matches[1]);}
			$version='';if(count($matches)>1){$version=$matches[1];}
			preg_match('~package="(.*?)"~',$xml,$matches);
			$packname='';if(count($matches)>1){$packname=$matches[1];}
			$mainActivityName = $this->getMainActivityName($xml);

			$data['package_name'] = $packname;
			$data['main_activity_name'] = $mainActivityName; 
			$data['app_size'] = $this->getBagSize($dataapk);
			
			$app = M('app');
			if($dotype == 2){
				$pagecount = $app->where("package_name='".$packname."'")->count();
				if($pagecount['tp_count'] > 0 && $packname){
					echo 5;
				}else if($pagecount['tp_count'] == 0){
					$re = 1;
				}
			}else if($dotype == 1){
				$pagecount = $app->where("package_name='".$packname."' and did=".$did)->getfield("android_url");
				if($pagecount && $packname){
					$re = 1;
					unlink(".".$pagecount);	
				}else{
					echo 6;
					unlink($appth.$info['savename']);	
				}
			}

			if($re == 1){
				$res = $app->where("APP_KEY='".$app_key."'")->save($data);
	
				if($res){
					$user = M('cooperation_user');
					if($did>0){
						$datas['status'] = 4;
						$user->where("id=".$did)->save($datas);
					}
					echo 4;
					
				}else{
					echo 2;
				}
			}
		}else{
			echo 3;
		}
	}
	
	//获取sdk包的大小
    public function getBagSize($fileName){
    	$f = fopen($fileName,'r');
    	fseek($f,0,SEEK_END);
    	$size = ftell($f); 
    	fclose($f);
    	return $this->chSize($size);
    }
	
	//字节转换
    public function chSize($size){
    	if($size){
    		if(((1024*1024) > $size && $size >= 1024)){
    			return sprintf("%.2f KB", ($size/1024) );
    		}elseif((1024*1024*1024) > $size && $size >= (1024*1024)){
    			return sprintf("%.2f MB", ($size/(1024*1024)) );
    		}
    	}else{
    		return 0;
    	}
    }
	//获取安卓版本
	public function get_android($i){
		$a=array(
			1=>'1.0',
			2=>'1.1',
			3=>'1.5',
			4=>'1.6',
			5=>'2.0',
			6=>'2.0.1',
			7=>'2.1.x',
			8=>'2.2.x',
			9=>'2.3.0-2.3.2',
			10=>'2.3.3,2.3.4',
			11=>'3.0.x',
			12=>'3.1.x',
			13=>'3.2',
			14=>'4.0,4.0.1,4.0.2',
			15=>'4.0.3,4.0.4',
			16=>'4.1,4.1.1',
			17=>'4.2',
		);
		foreach($a as $k=>$v){
			if($k==$i){return 'Android '.$v;}
		}
		return "";
	}
	
	function getMainActivityName($xml){
		$ret = '';
		preg_match_all('~(<activity.*?</activity>)~is',$xml,$matches);

		foreach($matches as $k){
			if(is_array($k)){
				foreach($k as $v){
					preg_match('~android:name="(.*?)".*?android:name="android.intent.action.MAIN"~is',$v,$submatches);
					if(count($submatches)>1){
						$ret = $submatches[1];
						break;
					}
				}
			}else{
				preg_match('~android:name="(.*?)".*?android:name="android.intent.action.MAIN"~is',$k,$submatches);
				if(count($submatches)>1){
					$ret = $submatches[1];
					break;
				}
			}
		}
		return $ret;
	}

}
?>