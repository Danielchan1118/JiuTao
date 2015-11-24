<?php
/**
 * Convert 兑换中心控制器
 * @ author huyuming
 */
namespace Admin\Controller;
class ConvertController extends AdminController{
	/**
	 * 兑换中心列表
	 */
	public function ConvertIndex(){
		$M =M('convert');
		$test = $M->where('pid=0')->field('id,convert_name,image,gold,tag,order_id')->select();
		if($test){
			$array = array();
			foreach ($test as $k => $v) {
				$array[$k]['id'] = $v['id'];
				$array[$k]['convert_name'] = $v['convert_name'];
				$array[$k]['image'] = $v['image']; 
				$array[$k]['gold'] = $v['gold']; 
				$array[$k]['tag'] = $v['tag']; 
				$array[$k]['order_id'] = $v['order_id']; 
				$next = $M->where('pid='.$v['id'])->select();	
				$array[$k]['sub'] = $next;
			}
		}
		$this->test = $array;
		$this->display();
	}

	/**
	 * 删除兑换中心数据
	 */
	public function ConvertDel(){
		$del_id = intval($_POST['orderid']);

    	if($del_id){
			$M =M('convert');
			$rest = $M->where('id='.$del_id)->find();
			if($rest){
				$one = $M->where('id='.$del_id.' and pid=0')->find();
				if($one){
					$ones = $M->where('pid='.$del_id)->find();
					
					if($ones){
						$arr['ret'] = -1;
						$arr['message'] = "下面还有子栏目，不能删除";	
					}else{
						$Convert_succ = $M->where('id='.$del_id)->delete();
						if($Convert_succ){
							$arr['ret'] = 1;
							$arr['message'] = "删除成功";	
						}else{
							$arr['ret'] = -1;
							$arr['message'] = "删除失败";	
						}
					}
				}else{
					$two = $M->where('id='.$del_id.' and pid>0')->find();
					
					if($two){
						$Convert_succ = $M->where('id='.$del_id)->delete();
						if($Convert_succ){
							$arr['ret'] = 1;
							$arr['message'] = "删除成功";	
						}else{
							$arr['ret'] = -1;
							$arr['message'] = "删除失败";	
						}
					}else{
						$arr['ret'] = -1;
						$arr['message'] = "删除数据出错";	
					}
				}	
			}
			
	     	$this->ajaxReturn($arr);
    	}
	}

	/**
	 * 添加兑换中心的数据
	 */
	public function ConvertAdd(){	
		$edit_id = intval($_POST['edit_id']);
		$editid = intval($_POST['editid']);
		$M = M('convert');
		$arr['convert_name'] = trim( $_POST['convert_name'] );
		if($editid > 0 || $arr['convert_name']){
			$arr['convert_goods'] = trim($_POST['shop']);
			$arr['remarks'] = trim(htmlspecialchars( $_POST['content'] ));
			$arr['add_time'] = time();
			$arr['tag'] = trim( $_POST['tag'] );
			$arr['order_id'] = intval($_POST['order_id']);
			$arr['gold'] =  trim( $_POST['golds'] )."万";

			if($arr['tag']){
				$pid = intval($_POST['pid']);
				if($_FILES['image']['size'] > 0 ){
					$res = $this->uploadfile($_FILES);
					if($res == 1){
						$this->error("上传文件出错");
					}else{
						$arr['image'] = "/".$res;
						unlink($_POST['image1']);
					}      
				}else{
					$arr['image'] = $_POST['image1'];
				}
				
				if($editid > 0){
					
					$Convert_s = $M->where('id='.$editid)->save($arr);
					if($Convert_s){
						$this->success('修改成功',U('Convert/ConvertIndex'));
					}else{
						$this->error('修改失败',U('Convert/ConvertIndex'));
					}
				}else{
					if($pid > 0){
						$arr['pid'] = $pid;
					}else{
						$arr['pid'] = 0;
					}
					$one = $M->add($arr);
					if($one){
						$this->success('添加成功',U('Convert/ConvertIndex'));
					}else{
						$this->error('添加失败',U('Convert/ConvertIndex'));
					}
				}
			}else{
				$this->error('请完善数据',U('Convert/ConvertIndex'));
			}

		}elseif($edit_id > 0){
				$convert_list = $M->where('id='.$edit_id)->find();
				$convert_list['gold'] = str_replace('万',' ',$convert_list['gold']); 
				$this->ajaxReturn($convert_list);
			}else{
				$this->error('操作失败！');
		}
				
	}
	
}
?>