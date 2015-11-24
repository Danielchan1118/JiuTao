<?php 
/**
 * $name 后台
 * @author DanielChan
 */
namespace Admin\Controller;
class CommentController extends AdminController
{
	
	
	/**
	 * $name 首页
	 * 
	 */
	 public function Comment_list($id = ''){
		//echo 'HELLO GUYS !';
		$M = M('comment');
		if($id>0){
			$del = $M->where('id='.$id)->delete();
			if($del){
				$this->success('删除成功');
			}else{
				$this->error("删除失败");
			}
		}else{
			$com = $M->table('oh_comment as c')->field('c.id,c.content,c.add_time,m.nickname')->join('oh_member as m on c.uid = m.uid')->where('c.is_show = 0')->limit('20')->select();
			$this->com = $com;
			$this->display();
		}
		
		
	 }

}



















?>