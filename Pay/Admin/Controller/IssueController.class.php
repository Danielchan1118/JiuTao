<?php 
/**
 * $name 后台
 * @author DanielChan
 */
namespace Admin\Controller;
class IssueController extends AdminController
{
	
	
	/**
	 * $name 首页
	 * 
	 */
	 public function IssueList($id = '',$uid='',$cid=''){
		//echo 'HELLO GUYS !';
		$M = M('pay');
		$nickname = trim($_POST['nickname']);
		$nick_name = trim($_GET['nickname']);
		$where.= "1=1";
		if($nickname || $nick_name){
			if($nick_name){
				$where.= " and m.nickname like '%".$nick_name."%'";
				$this->nickname = $nick_name;
			}else{
				$where.= " and m.nickname like '%".$nickname."%'";
				$this->nickname = $nickname;
				$_GET['nickname'] = $nickname;
			}
			
		}
		
		
		if($id>0){
				$get_url_img = $M->where('id='.$id)->getField('image_url');
				$images = explode(',',$get_url_img);
				foreach($images as $k=>$v){
					$i = explode(":",$v);
					$c = array("}","\\","]",'"'); 
					$a = trim(str_replace($c," ",$i[1]));		
					unlink(substr($a,1));					
					
				}
				$del = $M->where('id='.$id)->delete();
			if($del){
				$this->success('删除成功');
			}else{ 
				$this->error("删除失败");
			}
		}else if($uid>0){
			$is_show = $M->where('id='.$uid)->getField('is_show');
			if( 2 == $check ){
				$res = $M->where('id='.$uid)->setField('is_show',1);
			}else{
				$res = $M->where('id='.$uid)->setField('is_show',2);
			}
			if($res){
					$this->success('操作成功！');
				}else{
					$this->error('操作失败！');
			}
		}else{
			$n 		= 20;
			$counts = $M->table('oh_pay c')
					 ->join('oh_pay_cat as p on c.cat_id = p.id')
					 ->join('oh_member as m on c.uid = m.uid')->where($where)->count();
			$Page   = new \Think\Page($counts,$n);// 实例化分页类 传入总记录数和每页显示的记录数
			$Page->setConfig ( 'prev', '上一页' );
			$Page->setConfig ( 'next', '下一页' );
			$com = $M->table('oh_pay c')
					 ->join('oh_pay_cat as p on c.cat_id = p.id')
					 ->join('oh_member as m on c.uid = m.uid')
					 ->field('c.id,c.title,c.content,c.image_url,c.add_time,c.pay_type,c.status,c.comment_total,c.is_show,c.point_like,c.add_time,m.nickname,p.name')
					 ->where($where)
					 ->limit($Page->firstRow.','.$Page->listRows)
					 ->order('id desc')
					 ->select();
					 
			foreach($com as $k=>$v){//mb_substr($str,0,4,'utf-8')
				$com[$k]['content'] = mb_substr($v['content'],0,8,'utf-8');
				$com[$k]['title'] = mb_substr($v['title'],0,10,'utf-8');
			}		 
			$this->Page =$Page->show();
			$this->com = $com;
			$this->display();
		}
		
		
	 }
	 
	 //查看详情
	 public function Lookarticle(){
		$pay = M('pay');
		$id = intval($_GET['id']);
		$find_pay = $pay->table('oh_pay c')
					 ->join('oh_pay_cat as p on c.cat_id = p.id')
					 ->join('oh_member as m on c.uid = m.uid')
					 ->field('c.id,c.title,c.content,c.image_url,c.add_time,c.pay_type,c.status,c.comment_total,c.is_show,c.point_like,c.add_time,m.nickname,m.img_url,p.name')
					 ->where('c.id='.$id)
					 ->find();
		$images = explode(',',$find_pay['image_url']);
		$arr = array();
		foreach($images as $k=>$v){
			$i = explode(":",$v);
			$c = array("}","\\","]",'"');
			$arr['image'][] = trim(str_replace($c," ",$i[1]));			
			
		}
		$this->arr = $arr;
		$this->find_pay = $find_pay;
		$this->display();
	 }
	 
	 
	 /**
     *批量删除兑换记录
     */
    public function IssueDel(){
	    $pay    =  M("pay");
        $comment    =  M("comment");
        $letter_b    =  M("member_letter");
		$collect_b = M('member_collect');
        $del_id = $_POST['orderid'];
		
        if($del_id){
            if(is_array($del_id)){
                $cids = implode ( ',', $del_id ); 

                $map ['id'] = array (
                    'in',
                    $cids 
                );
				$comm['cat_id'] = array(
					'in',
					$cids
				);
				$letter['pay_id'] = array(
					'in',
					$cids
				);
				$collect['pay_id'] = array(
					'in',
					$cids
				);

            }else{
                $map ['id'] = $del_id;
                $comm ['cat_id'] = $del_id;
                $letter ['pay_id'] = $del_id;
                $collect ['pay_id'] = $del_id;
            }
        }
		$get_url_img = $pay->where($map)->select();
		$arr = array();
		foreach($get_url_img as $k=>$v){
			
			$arr[] = $v['image_url'];
			foreach($arr as $vv){
				$images = explode(',',$vv);
				foreach($images as $kkk=>$vvv){
					$i = explode(":",$vvv);
					$c = array("}","\\","]",'"'); 
					$a = trim(str_replace($c," ",$i[1]));		
					unlink(substr($a,1));					
					
				}
			}

		}
				
        $task  = $pay->where($map)->delete();
		$del_comment = $comment->where($comm)->delete();
		$del_letter = $letter_b->where($letter)->delete();
		$del_collect = $collect_b->where($collect)->delete();
        if($task){
            $arr['ret'] = 1;
            $arr['message'] = "删除成功";   
        }else{
            $arr['ret'] = -1;
            $arr['message'] = "删除失败";
        }
        $this->ajaxReturn($arr);
    }

}



















?>