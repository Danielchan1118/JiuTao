<?php
/**
 * 充值中心控制器
 * @author danielchan
 */

namespace Admin\Controller;
class PayController extends AdminController {
    /**
     * 添加,修改充值方式
     *@param int id
     *
     */
    public function payWayEdit($id=0){
       $this->checkRole();
        $M = M ( 'pay_type' );
        if($_POST){
            if( !$_POST ['pay_name']){ $this->error('渠道名不能为空！',U("Pay/payWayList")); }
            if( !$_POST ['tag']){ $this->error('标签Tag名不能为空！',U("Pay/payWayList")); }

            $info ['sort']      = intval($_POST ['sort']);
            $info ['tag']       = trim($_POST ['tag']);
            $info ['payname']   = trim($_POST ['pay_name']);
            $info ['fee']       = intval($_POST ['fee']);
            $info ['content']   = trim($_POST ['content']);
            $info ['isdisplay'] = intval($_POST ['isdisplay']);
            $info ['status']    = intval($_POST ['status']);
            $info ['account']   = trim($_POST ['account']);
            $info ['key']       = trim($_POST ['key']);
            $info ['modifytime']= time ();
            $info ['operater']  = session ( 'admin_user' );

            if($id){  
                $log_str = '修改充值方式 ['.$info ['payname']."]";              
                $st = $M->where('id='.$id)->save($info);
            }else{
                $log_str = '添加充值方式 ['.$info ['payname']."]";
                $info ['addtime'] = time ();
                $st = $M->add ($info);
            }
            if($st){
                $this->admin_log($log_str);   
                $this->success('操作成功!',U('Pay/payWayList'));
            }else{

                $this->error('操作失败!',U('Pay/payWayList'));
            }
                    
        }else{
            $this->info = $M->where('id='.$id)->find();
            $this->display();
        }           
    }

    /**
     * 充值订单列表
     */
    public function orderList(){
        $this->checkRole();
        $all_time   =  trim( $_POST['reservation'] );
        $end_time = trim($_GET['end_time']);
        $start_time = trim($_GET['start_time']);
        $order_status = $_GET['order_status'];
        $uid = $_GET['uid'];
    	if($all_time){
            $all_time = explode(" - ",$all_time);
            $start_time = $all_time[0];
            $end_time   = $all_time[1];   
            $_GET['start_time'] = $start_time;        
           $_GET['end_time'] = $end_time;     
        }
        //开始时间
        if ($start_time) {
			$this->start_time = $start_time;
            $start_time = strtotime ( $start_time );
            
        }else{
			$start_time = strtotime( date('Y-m-d',strtotime('-6 day')).'00:00:00' ); // 默认查询7天注册信息
		}
        //结束时间
        if ($end_time) {
			$this->end_time = $end_time;
            $end_time = strtotime ( $end_time );
            
        }else{
			$end_time = strtotime( date('Y-m-d',time()).'23:59:59' );
		}
        
        if($_POST['order_id']){
            $orderid = " AND orderid='".$_POST['order_id']."'";
			$this->order_id  = $orderid;
        }
        if($_POST['order_status']){
            $order_status = " AND order_status='".$_POST['order_status']."'";
			$_GET['order_status'] = $order_status;
        }
        if($_POST['uid']){
            $did = ' AND did='.$_POST['uid'];
			$_GET['uid'] = $did;
        }
		
		$pay_time = " AND pay_time BETWEEN ".$start_time." AND ".$end_time;
		
        
        $where = ' paydelete=1 '.$pay_time.$orderid.$order_status.$did;

        $pay = M("pay_ok");
        $n = 20;
        $counts = $pay->where($where)->count();
        $Page  = new \Think\Page($counts,$n);// 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig ( 'prev', '上一页' );
		$Page->setConfig ( 'next', '下一页' );
        $pay_list = $pay->field('pk.*,pt.payname')->table('sw_pay_ok pk')
                            ->join('sw_pay_type pt ON pk.pay_tag=pt.tag')
                            ->where($where)
                            ->order("pay_time desc")->limit($Page->firstRow.','.$Page->listRows)
                            ->select();
        $pay_moneys =  0;
        foreach ($pay_list as $k => $v) {
                $pay_moneys += $v['pay_money'];
        }          

        $user = M('cooperation_user');
        $this->userList  = $user->field('id,username')->select();               
        $this->Page      = $Page->show();
        $this->end_time = $end_time;
        $this->pay_list = $pay_list;
		$this->pay_moneys = $pay_moneys;
		$this->start_time = $start_time;
        $this->uid       = $_POST['uid'];
        $this->status    = $_POST['order_status'];
        $this->display();
    }


    //批量删除充值记录
    public function orderDelAll(){
        $this->checkRole();//权限
        $cid = $_REQUEST ['id'];
        $cids = implode ( ',', $cid ); // 批量获取gid
        $id = is_array ( $cid ) ? $cids : $cid;
        $map ['id'] = array (
                'in',
                $id 
        );
        if (! $cid) {
            $this->error ( "请勾选记录！" );
        }
        $pay_ok = M ( "pay_ok" ); // 实例化card对象
        $flag = $pay_ok->where($map)->setField('paydelete',0);

        if ($flag!==false) {
            $log_str = '批量删除充值记录';
            $this->admin_log($log_str);
            $this->success ( "删除成功!", U ( 'Pay/orderList' ) );
        } else {
            $this->error ( "发生错误:" . mysql_error (), U ( 'Pay/orderList' ) );
        }
    }

     /**
     * 充值方式列表
     * @param int id
     */
    public function payWayList(){
        $this->checkRole();//权限
        $M = M ( 'pay_type' );
        $n = 20;
        $counts = $M->count();
        $Page  = new \Think\Page($counts,$n);// 实例化分页类 传入总记录数和每页显示的记录数
        $payList = $M->order("sort asc")->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->Page  = $Page->show();
        $P = $Page->firstRow;
        if($P == 0){
            $P = 1;
        }
        foreach ($payList as $k => $v) {
            $payList[$k]['cid'] = $P;
            $P++;
        }
        $this->payList  = $payList;
        $this->display();
    }

    /**
     * 删除充值方式
     * @param int id
     */
    public function payWayDel($id){
       $this->checkRole();
        $M = M ( 'pay_type' );
        $payname = $M->where('id='.$id)->getField('payname');
        if($M->delete($id)){
            $log_str = '删除充值方式 ['.$payname."]";
            $this->admin_log($log_str);
            $this->success('操作成功!',U('Pay/payWayList'));
        }else{
            $this->error('操作失败!'.mysql_error(),U('Pay/payWayList'));
        }

    }

}