<?php 
/**
 * @name 关注微信赠送积分
 * @author DanielChan
 */
namespace Admin\Controller;
class WeChatController extends AdminController {
	public function sendCoinList(){
		$sc = M('sendcoin');	
		$this->info = $sc->find();	
		$this->display();
	}

	public function sendCoinEdit(){
		
		if($_POST){
			$sc = M('sendcoin');
			$data['coin'] = intval(trim($_POST['sendcoin']));
			$data['status']   = intval(trim($_POST['status']));

			if( $data['coin'] == "" || $data['status'] == "" ){
				$this->error('数据不能为空,请填写完整!',U('WeChat/sendCoinEdit'));
			}
			$sc->where('1')->delete();
			if($sc->add($data)){
				$this->success('编辑成功！',U('WeChat/sendCoinList'));
			}else{
				$this->error('编辑成功！',U('WeChat/sendCoinList'));
			}	
		}else{
			$sc = M('sendcoin');
			$this->info = $sc->find();
			$this->display();
		}		
	}


}

?>