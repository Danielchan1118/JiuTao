<?php
/**
 *后台菜单控制器
 * @author huyuming
 */
namespace Admin\Controller;
class MenusController extends AdminController {

    /**
     *编辑菜单
     */
    public function menuEdit(){
        $this->checkRole();
        $secondid   = intval($_POST['secondid']);
        $edit_id = intval($_POST['editid']);
        $editids = intval($_POST['editids']);
		$arr['name'] = trim($_POST["name"]);
        if($editids >0 || $arr['name']){
            $Menu = M('menu_admin');
			$pid = intval($_POST["pid"]);
			if($editids != $pid){
				$arr['pid'] = $pid;
			}
			 
            $arr['action'] = trim($_POST["action"]);
            $arr['is_show'] = intval($_POST["is_show"]);
            $arr['sort'] = intval($_POST["order_id"]);
            $arr['author'] = trim($_POST["authority"]);

            if(!$arr['action']){
                $this->error('请完善数据再进行提交');exit();
            }
            if($editids >0){
                $res = $Menu->where('id='.$editids)->save($arr);
                $mess = "修改成功";
            }else{
                $res = $Menu->add($arr);
                $mess = "添加成功";
            }
            if($res){
                $log_str = "编辑功能：栏目名为:".$arr['name'].";栏目方法为:".$arr['action'].";";
                $this->success($mess,U('Menus/MenuList'));
            }else{
                $this->error('操作失败!',U('Menus/MenuList'));
            }
            $this->admin_log($log_str);     
        }else if($secondid>0 || $edit_id > 0){
            $Menu = M('menu_admin');
			if($secondid>0){
				$second_id = $Menu->where('id='.$secondid)->getField("id");
				$this->ajaxReturn($second_id);
			}else if($edit_id > 0){
				 $edit_info = $Menu->where('id='.$edit_id)->find();
				 $this->ajaxReturn($edit_info);
			}else{
				$this->lists = $Menu->field("id,name")->where('pid=0') ->select();//查询一级栏目名
			}
        }else{
            $this->error('操作失败！');
        } 
    }

    /**
     *菜单列表
     */
    public function MenuList(){
        $this->checkRole();
        $Menu = M('menu_admin');
        $n = 7;
        $count = $Menu->where('pid=0')->count();
        $Page = new \Think\Page($count,$n);
		$Page->setConfig ( 'prev', '上一页' );
		$Page->setConfig ( 'next', '下一页' );
        $list = $Menu->where('pid=0') ->limit($Page->firstRow.','.$Page->listRows)->order('sort ')->select();
        if($list){
            foreach ($list as $k => $v) {
                $list[$k]['listSon'] = $Menu->where('pid='.$v['id'])->order('sort')->select();
            }
        }
		//查询一级栏目名
		$this->lists = $Menu->field("id,name")->where('pid=0') ->select();
		
        $this->Page = $Page->show();
        $this ->list =$list;
        $this->display();
    }

    /**
     *删除菜单
     */
    public function menuDel(){
        $this->checkRole();
		$del_id = intval($_POST['orderid']);
    	if($del_id > 0){
			$Menu = M('menu_admin');
			$info = $Menu->where("id=".$del_id)->find();
			if($info){
				if( 0 == $info['pid']){
					$count = $Menu->where('pid='.$del_id)->count();
					if( $count > 0 ){
						$this->error('下面还有子栏目,不能删除',U('Menus/MenuList'));
					}else{
					   $res = $Menu->where("id=".$del_id)->delete();
					}
				}else{
					$res = $Menu->where("id=".$del_id)->delete();
				}
				if($res){
					$arr['ret'] = 1;
					$arr['message'] = "删除成功";
                    $log_str = "删除功能：栏目名为:".$info['name'].";栏目方法为:".$info['action'].";";
                    $this->admin_log($log_str);     
				}else{
					$arr['ret'] = -1;
					$arr['message'] = "删除失败";
				}
			}else{
				$arr['ret'] = -1;
			 	$arr['message'] = "没有此栏目";	
			}
	     	$this->ajaxReturn($arr);
    	}
    }

    /**
     *权限设置
     * @author DanielChan
     */
    public function rolePriv(){
        $this->checkRole();
        $role_id = $_GET['id'];
        if(IS_POST){
            $arr = $_POST['menu_id'];   
            if(empty($arr)){ $this->error('数据不能为空!',U('AdminLogin/roleList')); exit();}

            $log_str = '权限设置,为角色分配功能';
            $this->admin_log($log_str); //加监控日志

            $ra = M('role_access');
            $ra->where('role_id='.$role_id)->delete();//删除数据
            $data['access_id'] = json_encode($arr);
            $data['role_id']   = $role_id;
            $insert = $ra->add($data);
            if (!$insert) { die ( mysql_error() ); }
            $this->success('添加成功!',U('AdminLogin/roleList'));

        }else{
            $ra = M('role_access');
            $access_id = $ra->where('role_id='.$role_id)->getField('access_id');//这个角色分配哪些权限
            $raList = json_decode($access_id);
            
            $Menu = M('menu_admin');
            $list = $Menu->where('pid=0') ->order('sort ')->select();//所有功能；
            if($list){
                foreach ($list as $k => $v) {
                    foreach($raList as $vol){
                        if( $v['id'] == $vol ){ $list[$k]['flag'] = 1;}//判断是否已经选择过
                    } 
                    $list[$k]['listSon'] = $Menu->where('pid='.$v['id'])->order('sort')->select();
                    foreach ($list[$k]['listSon'] as $kk => $vv) {
                       foreach($raList as $value){
                            if( $vv['id'] == $value ){ $list[$k]['listSon'][$kk]['flag'] = 1;}//判断是否已经选择过
                        }
                    }
                }
            }
            $this ->list =$list;
            $this->role_id = $role_id;
            $this->display();
        }
    }
    

    /**
     *操作日志显示
     * @author DanielChan
     */
    public function adminLog(){
        $this->checkRole();
        $log = M ( 'admin_exec_log' );
        $n = 30;
        $count = $log->count();
        $Page = new \Think\Page($count,$n);
		$Page->setConfig ( 'prev', '上一页' );
		$Page->setConfig ( 'next', '下一页' );
        $this->logList = $log->limit($Page->firstRow.','.$Page->listRows)->order('time DESC')->select();
        $this->Page = $Page->show();

        $this->display();
    }




}