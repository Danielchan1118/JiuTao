<?php
namespace App\Controller;
use Think\Controller;
/**
 * @name 版本升级接口 
 * @method POST 
 * @param $ext_id
 * @author DanielChan
 */
class UpdateController extends Controller{
	public function index(){
		echo $this->ShareAndUpdate($_POST["ext_id"]);
	}

	public function ShareAndUpdate($ext_id){
		if(isset($ext_id)){
			$share = M('upversion');
			$shareinfo = $share->where("id=".intval($ext_id))->find();
			//时间参数
			$shareinfo['times'] = time();
			return json_encode($shareinfo);
		}
	}
}
?>