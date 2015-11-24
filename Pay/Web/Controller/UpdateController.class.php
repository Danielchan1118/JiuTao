<?php
namespace Web\Controller;
use Think\Controller;
class UpdateController extends Controller{
	public function index(){
		echo $this->ShareAndUpdate($_POST["ext_id"]);
	}

	public function ShareAndUpdate($ext_id){
		if(isset($ext_id)){
			$share = M('share_center');
			$shareinfo = $share->where("id=".intval($ext_id))->find();
			//时间参数
			$shareinfo['times'] = time();
			return json_encode($shareinfo);
		}
	}
}
?>