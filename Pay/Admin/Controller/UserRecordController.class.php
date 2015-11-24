<?php
/**
 *用户记录管理控制器
 */
namespace Admin\Controller;
class UserRecordController extends AdminController {
    /**
     * 任务记录
     */
    public function TaskRecord($id = ''){
        $M = M("taskrecords");
        $activity = M("activity_taskrule");
        $where= "1=1";
        $username =  trim( $_POST['username'] );
        $username_s =  trim( $_GET['username'] );
        $active_type =   trim($_POST['active_type']);
        $where = "1=1";
        
        if($active_type){
             $where.= " and u.taskname like '%".$active_type."%'";
        }
        
        if($username || $username_s){
            if($username_s){
                $where.=" and u.username like '%".$username_s."%'";
                $this->username = $username_s;
            }else{
                $where.=" and u.username like '%".$username."%'";
                $this->username = $username_s;
                $_GET['username'] = $username;
            }
            
        }
        $n = 20;
        $count =  $M->table('sw_taskrecords u')->join('sw_activity_taskrule as w on u.atr_id = w.atr_id')->where($where)->count();
        $Page  = new\Think\Page($count,$n);
        $Page->setConfig ( 'prev', '上一页' );
        $Page->setConfig ( 'next', '下一页' );
        
        $tasks  = $M->table('sw_taskrecords u')
                      ->join('sw_activity_taskrule as w on u.atr_id = w.atr_id')
                      ->field('u.id,u.username,u.earn_coin,u.add_time,u.taskname as atr_name')
                      ->where($where)
                      ->order("add_time desc")
                      ->limit($Page->firstRow.','.$Page->listRows)
                      ->select();
    
        $task_count = $M->table('sw_taskrecords u')
                      ->join('sw_activity_taskrule as w on u.atr_id = w.atr_id')
                      ->field('SUM(earn_coin) as coin')
                      ->find();  
        $activity_list = $activity->select();
        $earn_coins_count = $task_count['coin']/10000;
        
        $P = $Page->firstRow+1;
        $earn_coins = 0; 
        foreach ($tasks as $k => $v) {
            $tasks[$k]['cid'] = $P;
            $earn_coins+= $v['earn_coin']/10000; 
            $P++;
        }            
        $this->tasks = $tasks;
        $this->earn_coins_count = $earn_coins_count;
        $this->Page = $Page->show();
        $this->earn_coins = $earn_coins; 
        $this->active_type = $active_type; 
        $this->activity_list = $activity_list; 
        $this->username = $username; 
        $this->display();
    }

    /**
     *删除记录
     */

    public function DeleteTask(){
        $del_id = $_POST['orderid'];
        if($del_id){
            if(is_array($del_id)){
                $cids = implode ( ',', $del_id ); 

                $map ['id'] = array (
                    'in',
                    $cids 
                );
            }else{
                $map ['id'] = $del_id;
            }


            $arr = array();
            $M = M("taskrecords");
            $res = $M->where($map)->delete();
            if($res){
                $arr['ret'] = 1;
                $arr['message'] = "删除成功";   
            }else{
                $arr['ret'] = -1;
                $arr['message'] = "删除失败";   
            }
            $this->ajaxReturn($arr);
        }
    }

    /**
     * 邀请记录
     */
    public function InvitedRecords(){
        $M = M("invitedrecords");
        $where = "1=1";
        $username = trim( $_POST['username'] );
        if($username){
            $where=" username like '%".$username."%'"; 
        }
        $n = 10;
        $count = $M->where($where)->count();
        $Page = new \Think\Page($count,$n);
        $Page->setConfig ( 'prev', '上一页' );
        $Page->setConfig ( 'next', '下一页' );
        $Invitation = $M->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
        $Invitation_count = $M->where($where)->select();
        foreach ($Invitation_count as $k => $v) {
            $reward_coin_count+= $v['reward_coin'];
        }
        $P = $Page->firstRow+1;
        $reward_coins = 0;
        foreach ($Invitation as $k => $v) {
            $Invitation[$k]['cid'] = $P;
            $reward_coins+= $v['reward_coin'];
            $P++;
        } 
        $this->reward_coins = $reward_coins;
        $this->Invitation = $Invitation;
        $this->Invitation_count = $Invitation_count;
        $this->reward_coin_count = $reward_coin_count;
        $this->username = $username;
        $this->display();
    }

    /**
     * 兑换记录
     */
    public function ConvertRecords(){
        $M = M("convertrecords");
        $where= "1=1";
        $username =  trim( $_POST['username'] );
        $status =  intval( $_POST['status'] );
        $status_type = intval( $_GET['status'] );
        $username_s = intval( $_GET['username'] );
        if($username || $username_s){
            if($username_s){
                $where.=" and u.username = '".$username_s."'";
                $this->username = $username_s;
            }else{
                $where.=" and u.username = '".$username."'";
                $this->username = $username;
                $_GET['username'] = $username;
            }
            
        }
        
        if($status > 0 ||  $status_type>0){
            if($status_type > 0){
                $where.=" and u.status = ".$status_type;
                $this->status = $status_type;
            }else{
                $where.=" and u.status = ".$status;
                $this->status = $status;
                $_GET['status'] = $status;
            }
             
        }
    
        $n = 10;
        $count = $M->table('sw_convertrecords u')->join('sw_convert as w on w.id = u.convert_id')->where($where)->count();
        $Page = new \Think\Page($count,$n);
        $Page->setConfig ( 'prev', '上一页' );
        $Page->setConfig ( 'next', '下一页' );
        $convert = $M->table('sw_convertrecords u')
                      ->join('sw_convert as w on w.id = u.convert_id')
                      ->field('u.id,u.username,u.expend_coin,u.add_time,u.convert_get,u.status,w.convert_name')
                      ->where($where)
                      ->order("add_time desc")
                      ->limit($Page->firstRow.','.$Page->listRows)
                      ->select();
        $convert_count = $M->table('sw_convertrecords u')
                      ->join('sw_convert as w on w.id = u.convert_id')
                      ->where('u.status=1')
                      ->field('u.id,u.expend_coin')
                      ->select();  
        
        foreach ($convert_count as $key => $v) {//统计总金币
             $convert_counts += $v['expend_coin']/10000;
        }            
        $P = $Page->firstRow+1;
        $expend_coins = 0;
        foreach ($convert as $k => $v) {
            $convert[$k]['cid'] = $P;
            $convert[$k]['expend_coin'] = $v['expend_coin']/10000;
            $expend_coins+=  $v['expend_coin'];
            $P++;
        }  
         
        $this->expend_coins = $expend_coins;  
        $this->convert_counts = $convert_counts;  
        $this->convert = $convert;  
        $this->Page = $Page->show();
        $this->display();
        
    }
    
    /**
     * 兑换详情信息
     */
    public function ConRecordinfo(){
        $cid = intval($_POST['cid']);
        $editid = intval($_POST['editid']);
        $M = M("convertrecords");
        
        if($cid > 0){
            $convert_info = $M->table('sw_convertrecords u')
                      ->join('sw_convert as w on w.id = u.convert_id')
                      ->field('u.*,u.status,w.convert_name')
                      ->where("u.id=".$cid)
                      ->find();
            $convert_info['add_time'] = date("Y-m-d H:i:s",$convert_info['add_time']);
            if($convert_info['complete_time']){
                $convert_info['complete_time'] = date("Y-m-d H:i:s",$convert_info['complete_time']);
            }
            $this->ajaxReturn($convert_info);
        }else if($editid > 0){
            $data['status'] = intval($_POST['status']);
            $data['remarks'] = trim($_POST['remarks']);
            
            $res = $M->where("id=".$editid)->save($data);
            if($res){
                if($data['status'] == 3){
                    $coninfo = $M->field("expend_coin,username")->where("id=".$editid)->find();
                    $user = M("users");
                    $inter = $user->where("username='".$coninfo['username']."'")->setInc( 'goldcount', $coninfo['expend_coin'] );
                }
            
                $datas['complete_time'] = time();
                $arr = $M->where("id=".$editid)->save($datas);
                $this->success ("处理成功", U ( 'UserRecord/ConvertRecords' ) );
            }else{
                $this->error ("处理失败", U ( 'UserRecord/ConvertRecords' ) );
            }
        }
    }
    
    /**
     *批量删除兑换记录
     */
    public function ConvertDel(){
        $del_id = $_POST['orderid'];
        
        if($del_id){
            if(is_array($del_id)){
                $cids = implode ( ',', $del_id ); 

                $map ['id'] = array (
                    'in',
                    $cids 
                );

            }else{
                $map ['id'] = $del_id;
            }
        }
        
        $task    =  M("convertrecords");

        $task  = $task->where($map)->delete();
        if($task){
            $arr['ret'] = 1;
            $arr['message'] = "删除成功";   
        }else{
            $arr['ret'] = -1;
            $arr['message'] = "删除失败";
        }
        $this->ajaxReturn($arr);
    }

    /**
     *竞猜列表
     */
    public function QuizList($id =''){
        $quiz = M('quiz');
        if($id){
             $delete_id = $quiz->where('id='.$id)->delete();
            if($delete_id){
                $this->success('删除成功',U('Admin/UserRecord/QuizList'));
            }else{
                $this->success('删除失败');
            }
        }else{
            $user =  trim($_POST['username']);
            $user_s =  trim($_GET['username']);
            $where = "1=1";
            if($user || $user_s){
                if($user_s){
                    $where = " username like '%".$user_s."%'";
                    $this->username = $user_s;
                }else{
                    $where = " username like '%".$user."%'";
                    $this->username = $users;
                    $_GET['username'] = $users;
                }
                
            }

            $n = 20;
            $count = $quiz->where($where)->count();
            $Page = new\Think\Page($count,$n);
            $Page->setConfig ( 'prev', '上一页' );
            $Page->setConfig ( 'next', '下一页' );
            $quiz_list =  $quiz->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
            $quiz_count =  $quiz->select();
            foreach ($quiz_count as $k => $v) {
                $quiz_integral += $v['integral']/10000; 
            }
            
            $P = $Page->firstRow+1;
            $integrals = 0;
            foreach ($quiz_list as $k => $v) {
                $quiz_list[$k]['c_id'] = $P;
                $quiz_list[$k]['integral'] = $v['integral']/10000; 
                $integrals+= $v['integral']/10000;
                $P++;
            }
            $this->quiz_list  = $quiz_list;
            $this->Page =$Page->show();
            $this->integrals = $integrals;
            $this->quiz_integral = $quiz_integral;
            $this->user = $user;
            $this->display();
        }

    }
    /**
     *批量删除兑换记录
     */
    public function QuizDelAll(){
        $task    =  M("quiz");
        $id   =  $_REQUEST['id'];
        $cid  =  implode( ',',$id );
        $cids = is_array($id) ? $cid : $id;
        $map['id']  = array('in',$cids);
        if(!$id){
            $this->error('请勾选记录 ！');
        }
        $task  = $task->where($map)->delete();
        if($task){
            $this->success("删除成功",U('UserRecord/QuizList'));
        }else{
            $this->success("发生错误:" . mysql_error (),U('UserRecord/QuizList'));
        }

    }


}
?>