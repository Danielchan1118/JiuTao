<?php
/**
 * Web兑换中心控制器
 * @author huyuming
 */
namespace Web\Controller;
class ConvertController extends WebController {
	/**
	 *兑换中心列表
	 */
	public function Index(){
		$username = trim($_GET['username']);
		$cid = intval($_GET['id']);
	
		if($cid > 0){
			$M = M('convert');
			if($cid > 0 ){
				$name = $M->where('id='.$cid)->getfield('convert_name');
				$sub_list = $M->where('pid='.$cid)->field('id,convert_name,image,gold')->select();
				$list['sub_list'] = $sub_list;
				$list['name'] = $name;
				$this->ajaxReturn($list);
				exit;
			}
		} 

		if($username){
			$user = M("users");
			$goldcount = $user->where("username='".$username."'")->getfield("goldcount");

			$M =M('convert');
			$convert_list = $M->where('pid=0')->field('id,convert_name,image,gold')->select();

			$this->assign("goldcount",$goldcount);
			$this->assign("convert_list",$convert_list);
			$this->display();
		}
	}

	/**
	 * 兑换中心提交
	 */
	public function ConvertInfo($id='', $cid=''){
		if($id>0 && $cid>0){
			$M = M('convert');
			$sub_list = $M->where('id='.$cid)->field('convert_name, image, tag, gold')->find();
			$sub_list['id'] = $cid;
			$this->assign("sub_list",$sub_list);
			$this->display();
		}
	}

	/**
	 * 记录兑换
	 */
	public function Convertlog(){
		var_dump($_COOKIE);
		var_dump($_POST);
		$tag = trim($_POST['tag']);
		if($tag){
			$username = $_COOKIE['userid'];
			$gold = intval($_POST['gold'])*10000;
			$user = M("users");
			$goldcount = $user->where("username='".$username."'")->getfield("goldcount");
			if($goldcount >= $gold){
				$data['username'] = $username;
				$data['userdata'] = trim($_POST['number']);
				$data['userdata1'] = trim($_POST['number1']);
				$data['convert_id'] = intval($_POST['convert_id']);
				$data['expend_coin'] = $gold;
				$data['convert_get'] = trim($_POST['convert_name']);
				$data['tag'] = $tag;
				$data['status'] = 2;
				$data['add_time'] = time();

				$c = M("convertrecords");
				$res = $c->add($data);
				if($res){
					$user->where("username='".$username."'")->setDec("goldcount",$gold);
					echo '提交成功';
				}else{
					echo '提交失败';
				}
			}
		}
	}

}