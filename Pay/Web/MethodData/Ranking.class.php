<?php 
/**
 * ��������ӿ�
 * ���а�
 */
 class Ranking{
	/**
	 * ��׬����Ӣ�۰�
	 */
	public function HeroRanking($datas = array()){
		$username = trim($datas['username']);
		if($username){
			$M = M('users');
			$integral = $M->field('username,goldcount')->order('goldcount desc')->limit(20)->select();
			$num = '00';
			$arr = array();
			foreach ($integral as  $k=>$v) {
				if($username == $v['username']){
					$arr[0]['num'] = $k+1;
				}
				$arr[$k]['term'] = $k+1;
				$arr[$k]['username'] = $v['username'];
				$arr[$k]['goldcount'] = $v['goldcount'];
			}
		}else{
			$arr['res'] = -1;
			$arr['error'] = '��½ʧ��';
		}
		return json_encode($arr);
	}

	/** 
	 * ����Ӣ�۰�
	 */
	public function TaskHero($datas = array()){
		$username = $datas['username'];
		if($username){
			$M = M('users');
			$integral = $M->field('taskgold,username')->order('taskgold desc')->limit(20)->select();
			$num = '00';
			$arr = array();
			foreach ($integral as  $k=>$v) {
				if($username == $v['username']){
					$arr[0]['num'] = $k+1;
				}
				$arr[$k]['term'] = $k+1;
				$arr[$k]['username'] = $v['username'];
				$arr[$k]['goldcount'] = $v['taskgold'];
			}
		}else{
			$arr['res'] = -1;
			$arr['error'] = '��½ʧ��';
		}
		
		return json_encode($arr);
	}
 }
 
 ?>