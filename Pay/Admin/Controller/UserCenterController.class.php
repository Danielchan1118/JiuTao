<?php
/**
 * 会员管理
 * @author 付敏平
 */
namespace Admin\Controller;
class UserCenterController extends AdminController {
	/**
	 * 会员列表
	 */
	public function UserList(){
		$this->checkRole();
		$user = M("users");
		$level = M("grade");
		$task =  M("taskrecords");
		$down = M("download_record");
		$convert = M("convertrecords");
		$username = trim($_POST['username']);
		$all_time   =  trim( $_POST['reservation'] );
		$levels   =  intval( $_POST['levels'] );
		$where = '1=1';
		if($all_time){
            $times = explode(" - ",$all_time);
            $end_time = strtotime($times[1]." 23:59:59");
            $start_time = strtotime($times[0]);
            $_GET['end_time'] = $end_time;
            $_GET['start_time'] = $start_time;
            $where.= " and add_time between ".$start_time." and ".$end_time;
        }else{
            $end_time = time();
            $start_time  = strtotime(date("Y-m-d",time()-7*24*60*60)." 00:00:00");
        }

        if($levels>0){
        	$find_level = $level->field('id,grade')->where('id='.$levels)->find();
        	$find_grade = intval($find_level['grade']);
        	$where.= " and level = ".$find_grade;
        	
        }
		
		if($username ){
			$where .= " and username like '%".$username."%'";
			$this->username = $username;
		}
		
		$n = 20;
		$count = $user->where($where)->count();
		$Page = new \Think\Page($count,$n);
		$Page->setConfig ( 'prev', '上一页' );
		$Page->setConfig ( 'next', '下一页' );
		$user_list = $user->where($where)->field("id, username, level,is_watch, email, installcount,goldcount,usablegold,mobilewidth,mobileheight,Mpverinfor,Mphonemodels,add_time")->order("add_time desc")->limit($Page->firstRow.','.$Page->listRows)->select();//order("goldcount desc")
		$user_count = $user->field('SUM(goldcount) as goldcounts,SUM(taskgold) as taskgolds')->find();
		$level_count = $level->field('id,grade')->select();
		$goldcounts = $user_count['goldcounts']/10000;
		$taskgolds = $user_count['taskgolds']/10000;

		$scores = 0;
		$general_scores = 0;
		$P = $Page->firstRow+1;

		foreach ($user_list as $k => $v) {
			$task_count = $task->where("username='".$v['username']."'")->field('SUM(earn_coin) as coin')->find();
			$down_count = $down->where("username='".$v['username']."'")->field('SUM(glod) as glods')->find();
			$convert_count = $convert->where("username='".$v['username']."'")->field('SUM(expend_coin) as expend_coins')->find();
			$user_list[$k]['taskgold'] = $task_count['coin'];
			$user_list[$k]['glods'] = $down_count['glods'];
			$user_list[$k]['expend_coins'] = $convert_count['expend_coins'];
			$general_scores += $user_list[$k]['taskgold'];
			$scores+= $v['goldcount']/10000;
			$user_list[$k]['cid'] = $P;
			$P++;
		}	

		$counts = $user->count();
		$find_set  = M('setpromoter')->where('id=1')->find();
    	$this->find_set = $find_set;
		$this->assign("level_count",$level_count);
		$this->assign("goldcounts",$goldcounts);
		$this->assign("taskgolds",$taskgolds);
		$this->assign("start_time",$start_time);
		$this->assign("end_time",$end_time);
		$this->assign("count",$count);
		$this->assign("counts",$counts);
		$this->assign("scores",$scores);
		$this->assign("levels",$levels);
		$this->assign("general_scores",$general_scores);
		$this->Page  = $Page->show();
		$this->assign("user_list",$user_list);
		$this->display();
		
	}
	/**
	 * 删除会员
	 */
	public function usermassage(){
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
			$M = M("users");
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
	 * 会员信息
	 */
	public function UserInfo(){
		$this->checkRole();
		$user = M("users");
		$uid = intval($_POST['edit_id']);
		
		//$goldcount = $user->where("id=".$uid)->getField('goldcount');	
		if($_POST['edit_ids'] >0){
			$id =  intval($_POST['edit_ids']);
			$data['mobilephone'] = trim( $_POST['mobilephone'] );
			$data['level'] = trim( $_POST['level'] );
			$goldcounts = intval( $_POST['goldcount'] );
			$data['email'] = trim( $_POST['email'] );	
			$username = $user->where('id='.$id)->getField("username");			
			if($goldcounts > 0){
				$log_str = '管理员cici给用户'.$username.'添加游币:'.$goldcounts;
				$this->admin_log($log_str); //加监控日志
				$res = $user->where('id='.$id)->setInc( 'goldcount', $goldcounts);
				if($res){
					$editlog = M("edituser_log");
					$remark = trim( $_POST['remark'] );
					
					$logdata ['adminuser'] = $this->admin_user;
					$logdata ['username'] = $username;
					$logdata ['remark'] = $remark;
					$logdata ['intergral'] = $goldcount;
					$logdata ['ip'] = get_client_ip ();
					$logdata ['add_time'] = time();
					$editlog->add($logdata);
				}
			}
			
			if($data['email']=='' || $data['mobilephone']==''){
				$this->error('修改数据不能为空',U('UserCenter/UserList'));
			}
			//var_dump($data);exit;
			$user_edit = $user->where('id='.$id)->save($data);
			
			if($user_edit){	
				$this->success('修改成功',U('UserCenter/UserList'));
			}else{
				$this->error('修改失败',U('UserCenter/UserList'));
			}
		}else if($uid > 0){
			$userinfo = $user->where("id=".$uid)->find();
			$this->ajaxReturn($userinfo);
		}
	}

	/**
	 * 会员记录信息
	 */
	public function RecordsList(){
		$this->checkRole();
		$record_id = trim( $_POST['recordtype'] );
		$usernames = trim( $_POST['username'] );
		$username = $_GET['user'];

		if(!$usernames){
			$usernames = $username;
		}
		switch ($record_id) { 
			case 'evt_2':
				$records = M("convertrecords");
				$recordslist=$records->table('sw_convertrecords u')
	                        ->join('sw_convert as w on w.id = u.convert_id')
	                        ->field('u.id,u.convert_get,u.expend_coin,u.add_time,u.complete_time,w.convert_name')//,SUM(u.expend_coin) as integrals
	                        ->where("u.username='".$usernames."'")
	                        ->limit(20)
	                        ->select(); 
				break;
			case 'evt_3':
				$records = M("invitedrecords");
				$recordslist = $records->where("username='".$usernames."'")->limit(20)->select();
				break;

			case 'evt_5':
				$records = M("download_record");
				$recordslist = $records->table('sw_download_record r')
					  ->join('sw_app as a on a.APP_KEY = r.APP_KEY')
					  ->join('sw_cooperation_user as u on u.id = r.did')
					  ->field('r.id,a.app_name,r.username,r.id,r.add_time,u.username as coopuser,r.app_money,r.glod,r.nomove,r.move,r.is_today_sign')//SUM(r.glod) as integrals
					  ->where("r.username=".$usernames)
					  ->limit(20)
					  ->select();
			break;
			default:
				$records = M("taskrecords");
				$recordslist = $records->field('id,earn_coin,taskname,add_time')->where("username='".$usernames."'")->limit(20)->select();                
				$action = "evt_1";
				
		}
		if($username){
			$records = M("taskrecords");
			$integrals = $records->field('id,earn_coin,taskname,add_time')->where("username='".$username."'")->limit(20)->select(); 
			$this->assign("action",$action);
			$this->assign("username",$username);
			$this->assign("counts",$counts);
			if($integrals ==  null){
				$this->assign("integrals",1); 
			}else{
				$this->assign("integrals",$integrals);
			}
			
			$this->assign("recordslist",$recordslist);
			$this->display();
		}else{
				foreach ($recordslist as $k => $v) {
					$recordslist[$k]['add_time'] = date("Y-m-d H:i:s",$v['add_time']);
					//$recordslist['counts'] = count($recordslist);
					//$recordslist['integrals'] = $recordslist[0]['integrals']; 
				}
			if($recordslist == null){ 
				$recordslist = '';
			}
				$this->ajaxReturn($recordslist);

				
		}
	}

	/**
     *等级设置
     */
    public function GradeSet(){
    	$this->checkRole();
		$del_id = $_POST['orderid'];
		$grade =  M('grade');
		if($del_id > 0){
			$delete_grade = $grade->where('id='.$del_id)->delete();
			if($delete_grade){
				$arr['ret'] = 1;
			 	$arr['message'] = "删除成功";	
			}else{
				$arr['ret'] = -1;
			 	$arr['message'] = "删除失败";
			}
			$this->ajaxReturn($arr);
		}else{
			$grade_list = $grade->order('grade asc')->select();
			$this->grade_list = $grade_list;
			$this->display();
		}
    }

    /**
     *修改，添加等级设置
     */
    public function GradeEdit(){
    	$this->checkRole();
        $grades =  M('grade');
		$edit_id = intval($_POST['edit_id']);
		$editid = intval($_POST['editid']);
		$date['integral'] =  intval( $_POST['integral']);
		
        if($editid > 0 || $date['integral']){
            $date['grade']    =  intval( $_POST['grade']);
			$date['getglod']    =  intval( $_POST['getglod']);

            if($date['integral'] == 0 && $date['grade'] == 0){
                $this->error('请填写数据后再提交',U('UserCenter/GradeSet'));
            }
            $date['add_time'] =  time();
            if($editid > 0){
                $result =  $grades->where('id='.$editid)->save($date);
                $message = '修改成功';
            }else{
                $result=  $grades->add($date);
                $message = '添加成功';
            }

            if($result){
                $this->success($message,U('UserCenter/GradeSet'));
            }else{
                $this->error('操作失败',U('UserCenter/GradeSet'));
            }
        }else if($edit_id){
			$grades_edit =  $grades->where('id='.$edit_id)->find();
			$this->ajaxReturn($grades_edit);
        }else{
	        $this->error('操作失败',U('UserCenter/GradeSet'));
	    }
    }
    /*修改积分列表*/
    public function AddIntegral(){
    	$M = M('edituser_log');
    		$username = trim($_POST['username']);
			$all_time   =  trim( $_POST['reservation'] );
			$where = '1=1';
			if($all_time){
		        $times = explode(" - ",$all_time);
		        $end_time = strtotime($times[1]." 23:59:59");
		        $start_time = strtotime($times[0]);
		        $_GET['end_time'] = $end_time;
		        $_GET['start_time'] = $start_time;
		        $where.= " and add_time between ".$start_time." and ".$end_time;
		    }else{
		        $end_time = time();
		        $start_time  = strtotime(date("Y-m-d",time()-7*24*60*60)." 00:00:00");
		    }
			
			if($username ){
				$where .= " and username like '%".$username."%'";
				$this->username = $username;
			}
    		$edituser = $M->where($where)->select();
	    	$this->edituser = $edituser;
	    	$this->username = $username;
	    	$this->start_time = $start_time;
	    	$this->end_time = $end_time;
	    	$this->display();
    	
    }

    /*设置推广员*/
    public function SetPromoter(){
    	$M = M('setpromoter');
    	$id =  intval($_POST['id']);
    	$invite_rewards = intval($_POST['invite_rewards']);
    	if($id >0){
    		$data['invite_rewards'] = $invite_rewards;
    		$data['down_award'] = intval($_POST['down_award']);
    		$data['one_friend'] = intval($_POST['one_friend']);
    		$data['two_friend'] = intval($_POST['two_friend']);
    		$data['add_time'] = time();
    		$set_user = $M->where('id='.$id)->save($data);
    		if($set_user){
    			$this->success("设置成功");
    		}else{
    			$this->error("设置失败");
    		}
    	}else{
    		$this->error("数据不能为空");
    	} 

    }

    /**导出excel*/
    public function derive(){
    	switch ( $operation ) { 
			case 'report': 
			
				$author = $this->admin_user;
				$title    = 'APPList';
				$fileName = 'APPList_'.date('Y-m-d-H_i_s').'.xlsx';


				
				//路径按自己项目实际路径修改，文件请到PHPExcel官网下载  
				include_once LIB_PATH."ORG/Excel/PHPExcel.php";
				include_once LIB_PATH."ORG/Excel/PHPExcel/Writer/Excel2007.php"; 
				//或者include 'PHPExcel/Writer/Excel5.php'; 用于输出.xls的  
				//创建一个excel  
				$objPHPExcel = new\PHPExcel(); 
				//保存excel—2007格式  
				$objWriter = new\PHPExcel_Writer_Excel2007( $objPHPExcel ); 
				//或者$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 非2007格式  

				//设置excel的属性：  
				//创建人  
				$objPHPExcel->getProperties()->setCreator( $author ); 
				//最后修改人  
				$objPHPExcel->getProperties()->setLastModifiedBy( $author ); 
				//标题  
				$objPHPExcel->getProperties()->setTitle( $title ); 
				//题目  
				$objPHPExcel->getProperties()->setSubject( $title ); 
				//描述  
				$objPHPExcel->getProperties()->setDescription( $title ); 
				//种类  
				$objPHPExcel->getProperties()->setCategory( "file" ); 
				//  
				//设置当前的sheet  
				$objPHPExcel->setActiveSheetIndex( 0 ); 
				//设置sheet的name  
				$objPHPExcel->getActiveSheet()->setTitle( '应用APP导出表' ); 
				//设置单元格的值  
				$subTitle = array( '应用名', '商家', '应用类型', '文件大小', '下载次数', '投放金额', '总游币', '状态', '投放状态' ); 
				$colspan = range( 'A', 'I' ); 
				$count = count( $subTitle ); 
				// 标题输出  
				for ( $index = 0; $index < $count; $index++ ) { 
					$col = $colspan[$index]; 
					$objPHPExcel->getActiveSheet()->setCellValue( $col . '1', $subTitle[$index] ); 
					//设置font  
					$objPHPExcel->getActiveSheet()->getStyle( $col . '1' )->getFont()->setName( 'Candara' ); 
					$objPHPExcel->getActiveSheet()->getStyle( $col . '1' )->getFont()->setSize( 15 ); 
					$objPHPExcel->getActiveSheet()->getStyle( $col . '1' )->getFont()->setBold( true ); 
					$objPHPExcel->getActiveSheet()->getStyle( $col . '1' )->getFont()->getColor()->setARGB( '#FFFFFF' ); 
		  
					//设置填充色彩    
/*					$objPHPExcel->getActiveSheet()->getStyle( $col . '1' )->getFill() 
							->setFillType( PHPExcel_Style_Fill::FILL_SOLID ); 
*/					$objPHPExcel->getActiveSheet()->getStyle( $col . '1' )->getFill()->getStartColor()->setARGB( 'FF808080' ); 
					// align 设置居中  
/*					$objPHPExcel->getActiveSheet()->getStyle( $col . '1' )->getAlignment() 
							->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER ); 
*/					//设置宽度
					if( $subTitle[$index] == '序号' ){ 
						$objPHPExcel->getActiveSheet()->getColumnDimension( $col )->setWidth( 10 ); 
					}elseif( $subTitle[$index] == '应用名'){
						$objPHPExcel->getActiveSheet()->getColumnDimension( $col )->setWidth( 30 ); 
					}else{
						$objPHPExcel->getActiveSheet()->getColumnDimension( $col )->setWidth( 20 ); 
					}
				} 
				// 内容输出  			
				foreach ( $datas as $key => $value ) { 
					$i = intval($key+2);
					$strS = '';
					$strTime = '';					
					if(1 == $value['app_type']){ $strS = '游戏'; }else{ $strS = '应用';}
					if(1 == $value['stauts']){ $stauts = '已审核'; }else{ $stauts = '未审核';}
					if(1 == $value['is_throw']){ $is_throw = '未投放'; }else{ $is_throw = '已投放';}
					$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $value['app_name']);
					$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $value['username']);
					$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $strS );
					$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $value['app_size']);
					$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $value['app_downloadnum']);
					$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $value['expend_money']);
					$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $value['app_integral']); 
					$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $stauts );
					$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $is_throw );
				} 
				
				//在默认sheet后，创建一个worksheet    
				$objPHPExcel->createSheet(); 				
				$objWriter->save( $fileName ); 
				$this->download( $fileName, true ); 
				break; 	
		} 


    }


	
}
?>