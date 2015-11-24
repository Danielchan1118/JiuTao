<?php
namespace App\Controller;
use Think\Controller;
/**
 * @name 版本升级接口 
 * @method POST 
 * @param $ext_id
 * @author DanielChan
 */
class TestController extends Controller{
	public function index(){
		//echo $this->ShareAndUpdate($_POST["ext_id"]);
		$this->display();
	}


}
?>