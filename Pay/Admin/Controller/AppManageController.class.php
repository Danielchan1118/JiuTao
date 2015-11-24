<?php
/**
 * 应用设置控制器
 * @author 付敏平
 */
namespace Admin\Controller;
header("Content-type: text/html; charset=utf-8"); 
class AppManageController extends AdminController {
	
	/**
	 * 应用列表
	 */
    public function AppList(){

    	$arrR = $_REQUEST;
		$strUrl = '/AppList/operation/report';
		if(!empty($arrR)){			
			foreach($arrR as $k => $v){
				if('_URL_' != $k){
					$strUrl .= "/".$k."/".$v;
				}
			}
		}
		$this->strUrl = $strUrl;

    	$app_name = trim( $_POST['name'] );
		$coopuser = trim( $_POST['coopuser'] );
		$app_type = intval( $_POST['app_type'] );
		$throw_type = intval( $_POST['throw_type'] );
		$throwtype = intval( $_GET['throw_type'] );
		$apptype = intval( $_GET['app_type'] );
		$coopuser_type = trim( $_GET['coopuser'] );
		$orderid = intval($_POST['orderid']);
    	$where = '1=1';
    	if($throw_type > 0 || $throwtype > 0){ 
			if($throwtype > 0){
				$where.= " AND a.is_throw =".$throwtype;
				$this->throw_type = $throwtype;
			}else{
				$where.= " AND a.is_throw =".$throw_type;
				$this->throw_type = $throw_type;
				$_GET['throw_type'] = $throw_type;
			}
		}
		
    	if($app_type > 0 || $apptype > 0){ 
			if($apptype > 0){
				$where.= " AND a.app_type =".$apptype;
				$this->app_type = $apptype;
			}else{
				$where.= " AND a.app_type =".$app_type;
				$this->app_type = $app_type;
				$_GET['app_type'] = $app_type;
			}
		}

		if($app_name){ 
			$this->app_name = $app_name;
			$where.= " AND a.app_name like '%".$app_name."%'";
		}
    	if($app_name){ 
			$this->app_name = $app_name;
			$where.= " AND a.app_name like '%".$app_name."%'";
		}
		$user = M('cooperation_user');
		if($coopuser || $coopuser_type){
			if($coopuser_type){
				$did = $user->where("username='".$coopuser_type."'")->getfield("id");
				$where.= " AND a.did = ".$did;
				$this->coopuser = $coopuser_type;
			}else{
				$did = $user->where("username='".$coopuser."'")->getfield("id");
				$where.= " AND a.did = ".$did;
				$this->coopuser = $coopuser;
				$_GET['coopuser'] = $coopuser;
			}
		}
		
		if($orderid > 0){
			$this->orderid = $orderid;
			if($orderid == 1){
				$order = " order_id  desc ,";
			}else{
				$order = " order_id  asc ,";
			}
			
		}

		$app = M("app");
		$n = 17;
		$counts = $app->table('sw_app a')->join('sw_cooperation_user as c on a.did=c.id')->join('LEFT JOIN sw_throw as th on a.id=th.app_id')->where($where)->count();
		$Page  = new \Think\Page($counts,$n);// 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig ( 'prev', '上一页' );
		$Page->setConfig ( 'next', '下一页' );		
		$app_list = $app->table('sw_app a')
					  ->join('sw_cooperation_user as c on a.did=c.id')
					  ->join('LEFT JOIN sw_throw as th on a.id=th.app_id')
					  ->field('a.id,a.app_name,a.app_type,a.app_cover,a.app_size,a.app_downloadnum,a.stauts,a.is_throw,c.username,a.expend_money,a.order_id,a.app_integral,throw_starttime')
					  ->where($where)
					  ->order($order."a.add_time desc")
					  ->limit($Page->firstRow.','.$Page->listRows)
					  ->select();

		$P = $Page->firstRow;
		if($P == 0){
			$P = 1;
		}
		if($P >1){
			foreach ($app_list as $k => $v) {
				$app_list[$k]['cid'] = $P+1;
				$P++;
			}
		}elseif($P >0){
			foreach ($app_list as $k => $v) {
				$app_list[$k]['cid'] = $P;
				$P++;
			}
		}
		
		/*因导出Excel需要签到数据,以下foreach把签到数据放进array $app_list*/
		foreach($app_list as $kk => $vv){
			$app_list[$kk]["NO"] = intval($kk+1);
			if( "" != $vv['throw_starttime']){
				$app_list[$kk]["throwtime"] = date("Y-m-d H:i:s", $vv['throw_starttime']);
			}else{
				$app_list[$kk]["throwtime"] = "";
			}

			$qiandao = $this->appQianDao($vv['id']);//单个
			if( !empty($qiandao['sign_list']) )
			{
				foreach ($qiandao['sign_list'] as $key => $value)
				{
					if( 1 == $value['num'])
					{
						$app_list[$kk]["score"]['first'] = $value['inter'];
					}elseif( $key == $qiandao['count_num'] )
					{
						$app_list[$kk]["score"]['end'] = $value['inter'];
					}else
					{
						$app_list[$kk]["score"][$key] = $value['inter'];
					}
				}
			}
		}		

		//Excel调用导出方法 
		if( $_REQUEST['operation']){ 

			$app_list1 = $app->table('sw_app a')
					  ->join('sw_cooperation_user as c on a.did=c.id')
					  ->join('LEFT JOIN sw_throw as th on a.id=th.app_id')
					  ->field('a.id,a.app_name,a.app_type,a.app_cover,a.app_size,a.app_downloadnum,a.stauts,a.is_throw,c.username,a.expend_money,a.order_id,a.app_integral,throw_starttime')
					  ->where($where)
					  ->order($order."a.add_time desc")
					  ->select();

			$P1 = $Page->firstRow;
			if($P1 == 0){
				$P1 = 1;
			}
			if($P1 >0){
				foreach ($app_list1 as $ke => $va) {
					$app_list1[$ke]['cid'] = $P1;
					$P1++;
				}
			}
			
			/*因导出Excel需要签到数据,以下foreach把签到数据放进array $app_list*/
			foreach($app_list1 as $kk1 => $vv1){
				$app_list1[$kk1]["NO"] = intval($kk1+1);
				if( "" != $vv1['throw_starttime']){
					$app_list1[$kk1]["throwtime"] = date("Y-m-d H:i:s", $vv1['throw_starttime']);
				}else{
					$app_list1[$kk1]["throwtime"] = "";
				}

				$qiandao1 = $this->appQianDao($vv1['id']);//单个
				if( !empty($qiandao1['sign_list']) )
				{
					foreach ($qiandao1['sign_list'] as $key1 => $value1)
					{
						if( 1 == $value1['num'])
						{
							$app_list1[$kk1]["score"]['first'] = $value1['inter'];
						}elseif( $key1 == $qiandao1['count_num'] )
						{
							$app_list1[$kk1]["score"]['end'] = $value1['inter'];
						}else
						{
							$app_list1[$kk1]["score"][$key1] = $value1['inter'];
						}
					}
				}
			}

			if( 'report' == $_REQUEST['operation'] ){ $operation = 'report'; }
			$this->dcOrDrExcel($app_list1,$operation);
		}

		$user_list = $user->field('id,username')->select();
		$this->app_list = $app_list;
		$this->user_list = $user_list;
		$this->Page  = $Page->show();
		$this->display();
    }
	
	/**
	 * 签到列表
	 */
	public function signlist($edit_id = 0){
		$edit_id = intval($_POST['edit_id']);
		if($edit_id>0){
			$app = M("app");
			$signinfo = $app->where("id=".$edit_id)->getfield("signdatas");
			if($signinfo){
				$signlist = unserialize($signinfo);
				$signlist[1]['count'] = count($signlist);
			}else{
				$sign = M("sign_in");
				$signlists = $sign->field("sign_num")->order("sort asc")->select();
				$signlist = array();
				foreach($signlists as $k=>$v){
					$signlist[$k+1]['num'] = $v['sign_num'];
					$signlist[$k+1]['inter'] = 0;
				}
				$signlist[1]['count'] = count($signlist);
			}
			
			$this->ajaxReturn($signlist);
		}
	}

    /**
     * 应用操作编辑或添加
     */
    public function AppDo($edit_id = ''){
		if (IS_POST) {
			$app = M("app");
			$map ['app_intro'] 		 = trim ( $_POST ['app_intro'] );// 如何做
			$map ['app_downloadnum'] = trim ( $_POST ['app_downloadnum'] );//下载次数：
			$map ['remarks'] 		 = trim ( $_POST ['remarks'] );	//备注
			$map ['stauts'] 		 = intval ( $_POST ['stauts'] );//状　　态：		
			$map ['expend_money'] 	 = floatval($_POST ['expend_money']);//消耗金额：			
			$map ['edit_time'] 		 = time();
			$map ['is_tj'] 	 = intval($_POST['is_tuijian']);	
			$map ['app_integral'] = intval($_POST['app_integral']);//总积分
			$map ['order_id'] = intval($_POST['order_id']);
				
			$sign = M("sign_in");
			$sign_count = $sign->count();

			$signtype = $_POST['signtype'];
			$signrule = array();

			for($i=1; $i<=$sign_count; $i++){
				$signrule[$i]['inter'] = intval($_POST['inter'.$i]);
				$signrule[$i]['num'] = intval($_POST['signnum'.$i]);
			}
			$edit_id = intval($_POST['edit_id']);
			$map ['signdatas'] = serialize($signrule);
			$data['APP_KEY'] = $_POST['app_key'];
			$data['add_time'] = time();
			$model = M("sign_data");
			if($edit_id > 0){
				$dataInfo = $app->where("id=".$edit_id)->find();//原来的数据
				$res  = $app->where("id=".$edit_id)->save( $map );
	
				if($res){
					$mess = "应用设置成功!";
					$log_str = "应用修改：修改总积分原总积分为".$dataInfo['app_integral']."，现总积分为".$map ['app_integral']."，  原扣商家金额为".$dataInfo['expend_money']."，现扣商家金额为".$map ['expend_money']."元";
					$model->where("APP_KEY='".$app_key."'")->save($data);
				}else{
					$mess = "应用设置失败!";
				}
			}

			if($res){
				$this->admin_log($log_str); 	
				$this->success ( $mess, U ( 'AppManage/AppList' ) );
			}else{
				$this->error ( "发生错误:" . mysql_error (), U ( 'AppManage/AppList' ) );
			}
		}else{
			if($edit_id > 0){
				$app = M("app");
				$appInfo = $app->field("id,app_intro,app_downloadnum,android_url,remarks,stauts,expend_money,add_time,is_tj,app_integral,order_id,app_name,signdatas,package_name")->where('id='.$edit_id)->find();
				$sign_list = unserialize($appInfo['signdatas']);

				$sign = M("sign_in");
				$signlists = $sign->order("sort asc")->select();
				$file_name = substr($appInfo['android_url'],strrpos($appInfo['android_url'],"/")+1);
				$this->host = $_SERVER['HTTP_HOST'];
				$this->file_name = $file_name;
				$this->appInfo = $appInfo;
				$this->sign_list = $sign_list;
				$this->signlists = $signlists;
			}
			
			$this->display();
		}
    }

    /**
     * 删除应用
     */
    public function appDel(){
		$del_id = intval($_POST['orderid']);
    	$app = M("throw");
    	$applist = $app->where('app_id='.$del_id)->count();
		$arr = array();
		if($applist){
			$arr['ret'] = 4;
			$arr['message'] = "数据不能删除，已经参与投放了";		
		}else if($del_id > 0){
			$ap = M("app");
			$appInfo = $ap->field('app_cover,app_images,android_url')->where('id='.$del_id)->find();
			unlink(substr($appInfo['app_cover'], 1));
			unlink(substr($appInfo['app_images'], 1));
			unlink(substr($appInfo['android_url'], 1));
			if($ap->where('id='.$del_id)->delete()){
				$del = M("delapp");
				$datas['app_id'] = $del_id;
				$datas['delete_time'] = time();
				$del->add($datas);

			 	$arr['ret'] = 1;
				$arr['message'] = "删除成功";	
			}else{
	     		$arr['ret'] = -1;
				$arr['message'] = "删除失败";
	     	}
		}
		$this->ajaxReturn($arr);

	}
	/**
	 * 签到列表
	 */
	public function Signin_list(){
		$M =  M('Sign_in');
		$del_id = $_POST['orderid'];
        if($del_id>0){
            $delete_grade = $M->where('id='.$del_id)->delete();
            if($delete_grade){
                $arr['ret'] = 1;
			 	$arr['message'] = "删除成功";	
            }else{
                $arr['ret'] = -1;
			 	$arr['message'] = "删除失败";
            }
			$this->ajaxReturn($arr);
        }else{
            $sign_list = $M->order('sign_num asc')->select();
            $this->sign_name = $sign_name;
            $this->sign_list = $sign_list;
            $this->display();
        }
		
	}
	/**
	 *添加签到
	 */
	public function Sign_edit(){
		$edit_id = intval($_POST['edit_id']);
		$editid = intval($_POST['editid']);
		$date['sign_name'] =  trim( $_POST['sign_name']);
		$M =  M('Sign_in');

        if($editid  > 0 || $date['sign_name']){
			$date['sign_num'] =  intval( $_POST['sign_num']);
            $date['sort']      =  intval( $_POST['sort']);

            if($date['sign_name']==''){
                $this->error('请填写数据后再提交',U('AppManage/Signin_list'));
            }
            $date['add_time'] =  time();
            if($editid>0){
                $result =  $M->where('id='.$editid)->save($date);
                $message = '修改成功';
            }else{
                $result=  $M->add($date);
                $message = '添加成功';
            }

            if($result){
                $this->success($message,U('AppManage/Signin_list'));
            }else{
                $this->error('操作失败',U('AppManage/Signin_list'));
            }
		}else if($edit_id > 0){
			$sign_edit =  $M->where('id='.$edit_id)->find();
			$this->ajaxReturn($sign_edit);
	    }else{
	        $this->error('操作失败',U('AppManage/Signin_list'));
	    }
	}
	
    //获取sdk包的大小
    public function getBagSize($fileName){
    	$f = fopen($fileName,'r');
    	fseek($f,0,SEEK_END);
    	$size = ftell($f); 
    	fclose($f);
    	return $this->chSize($size);
    }

    //字节转换
    public function chSize($size){
    	if($size){
    		if(((1024*1024) > $size && $size >= 1024)){
    			return sprintf("%.2f KB", ($size/1024) );
    		}elseif((1024*1024*1024) > $size && $size >= (1024*1024)){
    			return sprintf("%.2f MB", ($size/(1024*1024)) );
    		}
    	}else{
    		return 0;
    	}
    }

	/*
	 * @name 导出,入Excel
	 * $pargam array $datas 二维数组
	 * $pargam string $operation 判断导出或导入
	 * 
	 */
	public function dcOrDrExcel($datas,$operation){
		
		switch ( $operation ) { 
			case 'report': 
			
				$author = $this->admin_user;
				$title    = 'APPList';
				$fileName = '应用列表_'.date('Y-m-d-H_i_s').'.xlsx';

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

				$subTitle = array( '序号', '应用名称', '应用类型', '上线时间', '状态', '投放状态', '排序', '返利游币总值', '首次安装', '第二天', '第三天', '第四天', '第五天', '第六天', '第七天', '深度', '备注（商家)' ); 
				$colspan = range( 'A', 'Q' ); 
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

					if( $subTitle[$index] == '序号'){
						$objPHPExcel->getActiveSheet()->getColumnDimension( $col )->setWidth( 8 ); 
					}elseif( $subTitle[$index] == '应用名称'){
						$objPHPExcel->getActiveSheet()->getColumnDimension( $col )->setWidth( 30 ); 
					}else{
						$objPHPExcel->getActiveSheet()->getColumnDimension( $col )->setWidth( 18 ); 
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
					$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $value['NO'] );
					$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $value['app_name'] );
					$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $strS );
					$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $value['throwtime'] );
					$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $stauts );
					$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $is_throw );
					$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $value['order_id'] );//PAIXU order_id
					$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $value['app_integral'] ); 
					$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $value['score']['first'] );
					$objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $value['score'][2] );
					$objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $value['score'][3] );
					$objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $value['score'][4] );
					$objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $value['score'][5] );
					$objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $value['score'][6] );
					$objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $value['score'][7] );
					$objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $value['score']['end'] );
					$objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $value['username'] );
				} 
				
				//在默认sheet后，创建一个worksheet    
				$objPHPExcel->createSheet(); 				
				$objWriter->save( $fileName ); 
				$this->download( $fileName, true ); 
				break; 	
		} 
	}
	
	//下载文档
	public function download( $fileName, $delDesFile = false, $isExit = true ) { 
		if ( file_exists( $fileName ) ) { 
			header( 'Content-Description: File Transfer' ); 
			header( 'Content-Type: application/octet-stream' ); 
			header( 'Content-Disposition: attachment;filename = ' . $fileName ); 
			header( 'Content-Transfer-Encoding: binary' ); 
			header( 'Expires: 0' ); 
			header( 'Cache-Control: must-revalidate, post-check = 0, pre-check = 0' ); 
			header( 'Pragma: public' ); 
			header( 'Content-Length: ' . filesize( $fileName ) ); 
			ob_clean(); 
			flush(); 
			readfile( $fileName ); 
			if ( $delDesFile ) { 
				unlink( $fileName ); 
			} 
			if ( $isExit ) { 
				exit; 
			} 
		} 
	}

	/**
	 * @name 查看签到 
	 * 
	 */	
	public function justLook()
	{	
		$edit_id = intval($_GET['id']);
		if($edit_id > 0)
		{
			$app = M("app");
			$appInfo = $app->field("id,app_intro,app_downloadnum,android_url,remarks,stauts,expend_money,add_time,is_tj,app_integral,order_id,app_name,signdatas,package_name")->where('id='.$edit_id)->find();
			$sign_list = unserialize($appInfo['signdatas']);
			$count_num = count($sign_list);
			$sign = M("sign_in");
			$signlists = $sign->order("sort asc")->select();
			$res['sign_list'] = $sign_list;
			$res['signlists'] = $signlists;
			$res['count_num'] = $count_num;
			$this->ajaxReturn($res);
		}
	}

		/**
	 * @name 统计应用签到 
	 * 
	 */	
	public function appQianDao($id)
	{	
		$edit_id = intval($id);
		if($edit_id > 0)
		{
			$app = M("app");
			$appInfo = $app->field("id,app_intro,app_downloadnum,android_url,remarks,stauts,expend_money,add_time,is_tj,app_integral,order_id,app_name,signdatas,package_name")->where('id='.$edit_id)->find();
			$sign_list = unserialize($appInfo['signdatas']);
			$count_num = count($sign_list);
			$res['sign_list'] = $sign_list;
			$res['count_num'] = $count_num;
			return $res;
		}
	}
	
}