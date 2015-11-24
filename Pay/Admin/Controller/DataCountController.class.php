<?php
/**
 * 数据统计控制器
 * @author 付敏平
 */
namespace Admin\Controller;
header("Content-type: text/html; charset=utf-8"); 
class DataCountController extends AdminController {
    /**
     *  分日统计
     */
    public function DownloadNum(){

       date_default_timezone_set('prc');
        $down = M("download_record");
		$app_down = M("app");
            $start_time = time()-7*24*60*60;
            $end_time = time();
            $num = 7;

        $usercount = array();
		$newcouts = array();
        $activatcount = array();
        $activeusercount = array();

        $datacount = array();
        for($i = 0; $i<=$num; $i++ ){
            $times = date('Y-m-d',$end_time - $i*24*60*60);
            $starttime = strtotime($times);
            $endtime = strtotime($times." 23:59:59");
            
            $where = "add_time between ".$starttime." and ".$endtime;
            $datacount[$i]['newcouts'][] = $down->field('count(*) as num')->where($where." and is_today_sign=1")->find();//安装用用户
            $datacount[$i]['user_count'][] = $down->field('count(*) as num')->where($where." and nomove=1")->find();//下载量
            $datacount[$i]['activatcount'][] = $down->field("SUM(app_money) AS money")->where($where." and app_money>0")->find();//消耗金额
            $datacount[$i]['activecount'][] = $down->field("count(*) as num")->where($where." and move = 1")->find();//活跃用户（含重复安装）
            $datacount[$i]['activeusercount'][] = $down->field("count(*) as num")->where($where." and move = 1")->group("username")->find();//激活量
            if(!$datacount[$i]['activeusercount'][0]['num']){
                $datacount[$i]['activeusercount'][0]['num'] = 0; 
            }
			if(!$datacount[$i]['user_count'][0]['num']){
                $datacount[$i]['user_count'][0]['num'] = 0; 
            }
            if(!$datacount[$i]['usercount'][0]['num']){
                $datacount[$i]['usercount'][0]['num'] = 0; 
            }
            if(!$datacount[$i]['activatcount'][0]['money']){
                $datacount[$i]['activatcount'][0]['money'] = 0; 
            }
            $datacount[$i]['times'][] = $times;
        }
       
            $this->assign("datacount",$datacount);
            $this->assign('start_time',$start_time);
            $this->assign('end_time',$end_time);
            $this->display();
    }
    //json数据

    public function Downloaddata(){
        date_default_timezone_set('prc');
        $all_time   = trim( $_POST['reservation'] );
        $down = M("download_record");
        $app_down = M("app");

        if($all_time){
            $times = explode(" - ",$all_time);
            $end_time = strtotime($times[1]." 23:59:59");
            $start_time = strtotime($times[0]);
            $num = intval(($end_time - $start_time)/(24*60*60));
        }

        $user_count = array();
        $activatcount = array();
		$newcouts = array();
        $activeusercount = array();

        $datacount = array();
        for($i = 0; $i<=$num; $i++ ){
            $times = date('Y-m-d',$end_time - $i*24*60*60);
            $starttime = strtotime($times);
            $endtime = strtotime($times." 23:59:59");
            $where = "add_time between ".$starttime." and ".$endtime;
            $datacount[$i]['newcouts'][] = $down->field('count(*) as num')->where($where." and is_today_sign=1")->find();//安装用用户
			$datacount[$i]['user_count'][] = $down->field('count(*) as num')->where($where." and nomove=1")->find();//下载量
            $datacount[$i]['activatcount'][] = $down->field("SUM(app_money) AS money")->where($where." and app_money>0")->find();//消耗金额
            $datacount[$i]['activecount'][] = $down->field("count(*) as num")->where($where." and move = 1")->find();//活跃用户（含重复安装）
            $datacount[$i]['activeusercount'][] = $down->field("count(*) as num")->where($where." and move = 1")->group("username")->find();//激活量
            if(!$datacount[$i]['activeusercount'][0]['num']){
                $datacount[$i]['activeusercount'][0]['num'] = 0; 
            }
			if(!$datacount[$i]['user_count'][0]['num']){
                $datacount[$i]['user_count'][0]['num'] = 0; 
            }
            if(!$datacount[$i]['usercount'][0]['num']){
                $datacount[$i]['usercount'][0]['num'] = 0; 
            }
            if(!$datacount[$i]['activatcount'][0]['money']){
                $datacount[$i]['activatcount'][0]['money'] = 0; 
            }
            $datacount[$i]['times'][] = $times;
        }
       
        if($all_time){
            $this->ajaxReturn($datacount);
        }
    }

    /**
     * 终端设备
     */
    public function CtrTerminal(){
        date_default_timezone_set('prc');
        $down = M("download_record");
        $all_time = trim($_POST['reservation']);

       if($all_time){
            $times = explode(" - ",$all_time);
            $end_time = strtotime($times[1]." 23:59:59");
            $start_time = strtotime($times[0]);
        }else{
            $start_time  = strtotime(date("Y-m-d",time()-7*24*60*60)." 00:00:00");
            $end_time = time();
        }

        $where = "add_time between ".$start_time." and ".$end_time;

        $downtype = trim($_POST['downtype']);

        switch ($downtype) {
            case 'evt_2':
                $field = "count(*) as num,mobilewidth,mobileheight";
                $group = "mobileheight,mobilewidth";
                break;
            case 'evt_3':
                $field = "count(*) as num,Network";
                $group = "Network";
                break;
            case 'evt_4':
                $field = "count(*) as num,ProvidersName";
                $group = "ProvidersName";
                break;
            case 'evt_5':
                $field = "count(*) as num,Mphonemodels";
                $group = "Mphonemodels";
                break;
            default:
                $field = "count(*) as num,Mpverinfor";
                $group = "Mpverinfor";
                $downtype = 'evt_1';
                break;
        }

        $todaynum = $down->field($field)->where($where)->group($group)->select();
        
        $ResolList = array();
        $downarray = array();

        foreach($todaynum as $v){
            switch ($downtype) {
                case 'evt_2':
                    $ResolList[] = $v['mobilewidth']."*".$v['mobileheight'];
                    break;
                case 'evt_3':
                   $ResolList[] = $v['Network'];
                    break;
                case 'evt_4':
                    $ResolList[] = $v['ProvidersName'];
                    break;
                case 'evt_5':
                    $ResolList[] = $v['Mphonemodels'];
                    break;
                default:
                    $ResolList[] = "'".$v['Mpverinfor']."'";
                    break;
            }

            $downarray[] = intval($v['num']);
        }

        if($_POST['downtype']){
            $arr['categories'] = $ResolList;
            $arr['downarray'] = $downarray;
            $this->ajaxReturn($arr);
        }else{
            $this->categories = "[".implode(",",$ResolList)."]";
            $this->downarray = "[".implode(",",$downarray)."]";
            $this->downtype = $downtype;
            $this->end_time = $end_time;
            $this->start_time = $start_time;
            $this->display();
        }
    }

    /**
     * 应用关键数据
     */
    public function AppDatas(){

        $arrR = $_REQUEST;
        $strUrl = '/AppDatas/operation/report';
        if(!empty($arrR)){          
            foreach($arrR as $k => $v){
                if('_URL_' != $k){
                    $strUrl .= "/".$k."/".$v;
                }
            }
        }
        $this->strUrl = $strUrl;

        date_default_timezone_set('prc');
        $posttime = $_REQUEST['reservation'];
        $appname = trim($_POST['app_name']);

        if($posttime){
            $times = explode(" - ",$posttime);
        }
       
        $down = M("download_record");
        $downcount = array();
        $appdata = array(); 

        if($appname){
            $app_name = " and a.app_name like '%".$appname."%'";
            $this->appname = $appname;
        }

        if(is_array($times)){
            $end_time = strtotime($times[1]);
            $start_time = strtotime($times[0]);
            $num = ($end_time - $start_time)/(24*60*60);
        }else{
            $start_time = time()-7*24*60*60;
            $end_time = time();
            $num = 7;
        }
        
        $moves = 0;
        $nomove = 0;
        $Activation = 0;
        $signs = 0;
        $app_money = 0;
       
        for($i = 0; $i<=$num; $i++ ){
            $times = date('Y-m-d',$end_time - $i*24*60*60);
            $starttime = strtotime($times);
            $endtime = strtotime($times." 23:59:59");

            $downcount =  $down->table('sw_download_record AS d')
                    ->join('sw_app AS a on d.APP_KEY = a.APP_KEY')
                    ->field('d.move, d.nomove, d.app_money, a.app_name,is_today_sign,app_money')
                    ->where(" d.add_time between ".$starttime." AND ".$endtime.$app_name)
                    ->order("d.add_time desc")
                    ->select();
            foreach($downcount as $k=>$v ){
                if($v['move'] == 1){
                    $appdata[$v['app_name']]['move']+= 1;
                    $moves+= 1;
                    $this->moves = $moves;
                }
                if($v['nomove']==1){
                    $appdata[$v['app_name']]['nomove']+= 1;
                    $nomove+=1;
                    $this->nomove = $nomove;
                }

                if($v['is_today_sign'] == 1){
                    $appdata[$v['app_name']]['sign'] += intval($v['is_today_sign']);   
                    $sign += 1;
                    $this->sign = $sign;
                }
                if($v['app_money'] > 0){
                    $appdata[$v['app_name']]['Activation'] +=1;
                    $appdata[$v['app_name']]['app_money']+= intval($v['app_money']);  
                    $app_money += intval($v['app_money']); 
                    $this->app_money = $app_money; 
                    $Activation += 1;     
                    $this->Activation = $Activation;           
                }
                $appdata[$v['app_name']]['app_name'] = $v['app_name'];
            }
        }

        $res['appdata']    = $appdata;
        $res['moves']      = $moves;
        $res['nomove']     = $nomove;
        $res['sign']       = $sign;
        $res['Activation'] = $Activation;
        $res['app_money']  = $app_money;
        //Excel调用导出方法 
        if( $_REQUEST['operation']){ 
            if( 'report' == $_REQUEST['operation'] ){ $operation = 'report'; }           
            $this->dcOrDrExcel($res,$operation,'AppDatas');
        }

        $this->end_time = $end_time;
        $this->start_time = $start_time;
        $this->AppData = $appdata;

        $this->display();
    }
    
    /**
     * 用户实时下载数据
     */
    public function userDownLog(){

        $arrR = $_REQUEST;
        $strUrl = '/userDownLog/operation/report';
        if(!empty($arrR)){          
            foreach($arrR as $k => $v){
                if('_URL_' != $k){
                    $strUrl .= "/".$k."/".$v;
                }
            }           
        }
        $this->strUrl = $strUrl;

        $all_time   =  trim( $_REQUEST['reservation'] );
        $end_time = trim($_GET['end_time']);
        $start_time = trim($_GET['start_time']);
        $username = trim( $_POST['username'] );
        $users = trim( $_GET['username'] );
        $appname = trim( $_POST['appname'] );
        $coopuser = trim( $_POST['coopuser'] );
		$coop_user = trim( $_GET['coopuser']);
        $stauts = intval( $_POST['stauts'] );
        $get_stauts = intval( $_GET['stauts'] );

        if($all_time){
            $times = explode(" - ",$all_time);
            $end_time = strtotime($times[1]." 23:59:59");
            $start_time = strtotime($times[0]);
            $_GET['end_time'] = $end_time;
            $_GET['start_time'] = $start_time;
        }else if(empty($end_time) || empty($start_time)){
            $end_time = time();
            $start_time  = strtotime(date("Y-m-d",time()-7*24*60*60)." 00:00:00");
        }

        $down = M("download_record");
        $user = M('cooperation_user');
        
        $where =  "r.add_time between ".$start_time." and ".$end_time;
        if($username || $users){
            if($users){
                $where.= " AND r.username like '%".$users."%'";
                $this->username = $users;
            }else{
                $where.= " AND r.username like '%".$username."%'";
                $_GET['username'] = $username;
                $this->username = $username;
            }
            
        }
        
        
        if($appname){ 
            $where.= " AND a.app_name = '".$appname."'";
            $this->appname = $appname;
        }
        
        if($coopuser || $coop_user){
			if($coop_user){
				$did = $user->where("username='".$coop_user."'")->getfield("id");
				$where.= " AND r.did = ".$did;
				$this->coopuser = $coop_user;
			}else{
				$did = $user->where("username='".$coopuser."'")->getfield("id");
				$where.= " AND r.did = ".$did;
				$this->coopuser = $coopuser;
				$_GET['coopuser'] = $coopuser;
			}
            
        }
        
        if($stauts > 0 || $get_stauts>0 ){
			if($get_stauts){
				if($get_stauts == 1){
                $where.= " AND r.move = 1";
				}else if($get_stauts == 2){
					$where.= " AND r.nomove = 1";
				}else if($get_stauts == 3){
					$where.= " AND r.is_today_sign = 1";
				}
				
				$this->stauts = $get_stauts;
			}else{
				if($stauts == 1){
                $where.= " AND r.move = 1";
				}else if($stauts == 2){
					$where.= " AND r.nomove = 1";
				}else if($stauts == 3){
					$where.= " AND r.is_today_sign = 1";
				}
				
				$this->stauts = $stauts;
				$_GET['stauts'] = $stauts;
			}
            
        }

        $n = 20;
        $counts = $down->table('sw_download_record r')
                      ->join('LEFT JOIN sw_app as a on a.APP_KEY = r.APP_KEY')
                      ->join('LEFT JOIN sw_cooperation_user as u on u.id = r.did')
                      ->where($where)
                      ->count();              
        $Page  = new \Think\Page($counts,$n); // 实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig ( 'prev', '上一页' );
        $Page->setConfig ( 'next', '下一页' );
        
        $downlist = $down->table('sw_download_record r')
                      ->join('LEFT JOIN sw_app as a on a.APP_KEY = r.APP_KEY')
                      ->join('LEFT JOIN sw_cooperation_user as u on u.id = r.did')
                      ->field('a.app_name,r.username,r.id,r.add_time,u.username as coopuser,r.app_money,r.glod,r.nomove,r.move,r.is_today_sign')
                      ->where($where)
                      ->order("r.add_time desc")
                      ->limit($Page->firstRow.','.$Page->listRows)
                      ->select();         
        $glods = 0;
        $app_moneys = 0;
        $P = $Page->firstRow+1;
        foreach ($downlist as $k => $v) {
            $downlist[$k]['cid'] = $P;
            $app_moneys +=$v['app_money'];
            $glods +=$v['glod'];
            $P++;
        } 

        //Excel调用导出方法 
        if( $_REQUEST['operation']){

            $downlist1 = $down->table('sw_download_record r')
                          ->join('sw_app as a on a.APP_KEY = r.APP_KEY')
                          ->join('sw_cooperation_user as u on u.id = r.did')
                          ->field('a.app_name,r.username,r.id,r.add_time,u.username as coopuser,r.app_money,r.glod,r.nomove,r.move,r.is_today_sign')
                          ->where($where)
                          ->order("r.add_time desc")
                          ->select();
            $glods1 = 0;
            $app_moneys1 = 0;
            $P1 = $Page->firstRow+1;
            foreach ($downlist1 as $kk => $vv) {
                $downlist1[$kk]['cid'] = $P1;
                $app_moneys1 +=$vv['app_money'];
                $glods1 +=$vv['glod'];
                $P1++;
            } 
            $downlist1['app_moneys1'] = $app_moneys1;
            $downlist1['glods1']      = $glods1;
            $downlist1['downlist1']   = $downlist1;
            if( 'report' == $_REQUEST['operation'] ){ $operation = 'report'; }           
            $this->dcOrDrExcel($downlist1,$operation,'userDownLog');
        } 

        $user_list = $user->field('id,username')->select();
        $this->app_moneys = $app_moneys;
        $this->glods = $glods;
        $this->user_list = $user_list;
        $this->downlist = $downlist;
        $this->Page  = $Page->show();
        $this->end_time = $end_time;
        $this->start_time = $start_time;
        $this->display();
    }
    
     /**
     * 商家统计
     */
    public function SellerDatas(){
        $arrR = $_REQUEST;
        $strUrl = '/SellerDatas/operation/report';
        if(!empty($arrR)){          
            foreach($arrR as $k => $v){
                if('_URL_' != $k){
                    $strUrl .= "/".$k."/".$v;
                }
            } 
        }
        $this->strUrl = $strUrl;

        $all_time   =  trim( $_REQUEST['reservation'] );
        $end_time = trim($_GET['end_time']);
        $start_time = trim($_GET['start_time']);
        $coopuser = trim( $_POST['coopuser'] );
        $coopuser_s = trim( $_GET['coopuser'] );
        $where = "1=1";
        if($all_time){
            $times = explode(" - ",$all_time);
            $end_time = strtotime($times[1]." 23:59:59");
            $start_time = strtotime($times[0]);
            $_GET['end_time'] = $end_time;
            $_GET['start_time'] = $start_time;
            $where = " a.add_time between ".$start_time." and ".$end_time;
        }else if(empty($end_time) || empty($start_time)){
            $end_time = time();
            $start_time  = strtotime(date("Y-m-d",time()-7*24*60*60)." 00:00:00");
        }
        
        $user = M('cooperation_user');

        
        
        if($coopuser || $coopuser_s){
            if($coopuser_s){
                $did = $user->where("username='".$coopuser_s."'")->getfield("id");
                $where.= " AND c.id = ".$did;
                $this->coopuser = $coopuser_s;
            }else{
                $did = $user->where("username='".$coopuser."'")->getfield("id");
                $where.= " AND c.id = ".$did;
                $this->coopuser = $coopuser;
                $_GET['coopuser'] = $coopuser;
            }
            
        }
        
        $n = 25;
        $counts = $user->table('sw_cooperation_user c')->join('sw_app as a on c.id = a.did')->where($where)->group("c.username")->count();
        $Page  = new \Think\Page($counts,$n); // 实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig ( 'prev', '上一页' );
        $Page->setConfig ( 'next', '下一页' );

        $user_info = $user->table('sw_cooperation_user c')
                      ->join('sw_app as a on c.id = a.did')
                      ->field('c.username, c.id,count(*) as appcount')
                      ->where($where)
                      ->group("c.username")
                      ->limit($Page->firstRow.','.$Page->listRows)
                      ->select();   
        $p = $Page->firstRow;
        if($p == 0){
            $p =1;
        }   
        $down = M("download_record");

        $usercount = array();             
        foreach($user_info as $k=>$v){
            $usercount[$k]['cid'] = $p;
            $usercount[$k]['username'] = $v['username'];
            $usercount[$k]['appcount'] = $v['appcount'];
            $downlist = $down->field("SUM(app_money) as money, SUM(move) as move")->where("add_time between ".$start_time." and ".$end_time." and did=".$v[id])->find();
            $usercount[$k]['app_money'] = $downlist['money'];
            $usercount[$k]['move'] = $downlist['move'];
            $p++;
        }             
        
        //Excel调用导出方法 
        if( $_REQUEST['operation']){ 

            $user_info1 = $user->table('sw_cooperation_user c')
                          ->join('sw_app as a on c.id = a.did')
                          ->field('c.username, c.id,count(*) as appcount')
                          ->where($where)
                          ->group("c.username")
                          ->select();   
            $p1 = $Page->firstRow;
            if($p1 == 0){
                $p1 =1;
            }   

            $usercount1 = array();             
            foreach($user_info1 as $kk=>$vv){
                $usercount1[$kk]['cid'] = $p1;
                $usercount1[$kk]['username'] = $vv['username'];
                $usercount1[$kk]['appcount'] = $vv['appcount'];
                $downlist1 = $down->field("SUM(app_money) as money, SUM(move) as move")->where("add_time between ".$start_time." and ".$end_time." and did=".$vv['id'])->find();
                $usercount1[$kk]['app_money'] = $downlist1['money'];
                $usercount1[$kk]['move'] = $downlist1['move'];
                $p1++;
            }           

            if( 'report' == $_REQUEST['operation'] ){ $operation = 'report'; }
            $this->dcOrDrExcel($usercount1,$operation,'SellerDatas');
        }

        $userlist = $user->field('id,username')->select();
        $this->user_list = $userlist;
        $this->user_info = $usercount;
        $this->Page  = $Page->show();
        $this->end_time = $end_time;
        $this->start_time = $start_time;
        $this->display();
    }

    /*
     * @name 导出,入Excel
     * $pargam array $datas 二维数组
     * $pargam string $operation 判断导出或导入
     * 
     */
    public function dcOrDrExcel($datas,$operation,$function_name){

        switch ( $operation ) { 
            case 'report': 
                $author = $this->admin_user;
                //路径按自己项目实际路径修改，文件请到PHPExcel官网下载  
                include_once LIB_PATH."ORG/Excel/PHPExcel.php";
                include_once LIB_PATH."ORG/Excel/PHPExcel/Writer/Excel2007.php"; 
                //或者include 'PHPExcel/Writer/Excel5.php'; 用于输出.xls的  
                //创建一个excel  
                $objPHPExcel = new\PHPExcel(); 
                //保存excel—2007格式  
                $objWriter = new\PHPExcel_Writer_Excel2007( $objPHPExcel ); 
                //或者$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 非2007格式  

               if( "SellerDatas" == $function_name ){
                    //设置excel的属性：
                    $title    = '商家应用消耗';
                    $fileName = '商家应用消耗_'.date('Y-m-d-H_i_s').'.xlsx';  
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
                    $objPHPExcel->getActiveSheet()->setTitle( '商家应用消耗导出表' ); 
                    //设置单元格的值  

                    $subTitle = array( '序号', '商家名', '上传数量', '消耗金额', '激活量' ); 
                    $colspan = range( 'A', 'E' ); 
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
                        $objPHPExcel->getActiveSheet()->getStyle( $col . '1' )->getFill()->getStartColor()->setARGB( 'FF808080' ); 
                        
                        //设置宽度
                        if( $subTitle[$index] == '序号'){
                            $objPHPExcel->getActiveSheet()->getColumnDimension( $col )->setWidth( 8 ); 
                        }else{
                            $objPHPExcel->getActiveSheet()->getColumnDimension( $col )->setWidth( 18 ); 
                        }
                    } 
                    // 内容输出             
                    foreach ( $datas as $key => $value ) { 
                        $i = intval($key+2);

                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $value['cid'] );
                        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $value['username'] );
                        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $value['appcount'] );
                        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $value['app_money'] );
                        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $value['move'] );
                    } 
                }elseif( "userDownLog" == $function_name ){
                    //设置excel的属性：
                    $title    = '用户实时下载记录';
                    $fileName = '用户实时下载记录_'.date('Y-m-d-H_i_s').'.xlsx';  
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
                    $objPHPExcel->getActiveSheet()->setTitle( '用户实时下载记录导出表' ); 
                    //设置单元格的值  

                    $subTitle = array( '序号', '用户', '应用名', '商家名', '消耗金额','得到积分','状态','下载时间' ); 
                    $colspan = range( 'A', 'H' ); 
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
                        $objPHPExcel->getActiveSheet()->getStyle( $col . '1' )->getFill()->getStartColor()->setARGB( 'FF808080' ); 
                        
                        //设置宽度
                        if( $subTitle[$index] == '序号'){
                            $objPHPExcel->getActiveSheet()->getColumnDimension( $col )->setWidth( 8 ); 
                        }else{
                            $objPHPExcel->getActiveSheet()->getColumnDimension( $col )->setWidth( 18 ); 
                        }
                    } 
                    // 内容输出
                    $i = 1;              
                    foreach ( $datas as $key => $value ) { 
                        $i += 1;
                        $add_time = date("Y-m-d H:i:s",$value['add_time']);
                        if( 1 == intval($value['is_today_sign']) ){
                            $STR = '签到';
                        }elseif( 1 == intval($value['move']) ){
                            $STR = '打开';
                        }elseif( 1 == intval($value['nomove']) ){
                            $STR = '下载';
                        }
                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $value['cid'] );
                        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $value['username'] );
                        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $value['app_name'] );
                        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $value['coopuser'] );
                        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $value['app_money'] );
                        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $value['glod'] );
                        $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $value['app_money'] );
                        $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $add_time );
                    } 

                    $i += 1;
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, '' );
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, '' );
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, '' );
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, '' );
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, '' );
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, '' );
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, '' );
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, '' );                   

                    $i += 1;
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, '' );
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, '当前消耗金额：' );
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $datas['app_moneys1'] );
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, '' );
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, '当前得到总积分：' );
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $datas['glods1'] );
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, '' );
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, '' );

                }elseif( "AppDatas" == $function_name ){
                    //设置excel的属性：
                    $title    = '应用统计';
                    $fileName = '应用统计_'.date('Y-m-d-H_i_s').'.xlsx';  
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
                    $objPHPExcel->getActiveSheet()->setTitle( '应用统计导出表' ); 
                    //设置单元格的值  

                    $subTitle = array( '应用名', '下载量', '激活量', '签到量','应用消耗金额' ); 
                    $colspan = range( 'A', 'F' ); 
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
                        $objPHPExcel->getActiveSheet()->getStyle( $col . '1' )->getFill()->getStartColor()->setARGB( 'FF808080' ); 
                        
                        //设置宽度
                        $objPHPExcel->getActiveSheet()->getColumnDimension( $col )->setWidth( 20 ); 
/*                        if( $subTitle[$index] == '序号'){
                            $objPHPExcel->getActiveSheet()->getColumnDimension( $col )->setWidth( 8 ); 
                        }else{
                            $objPHPExcel->getActiveSheet()->getColumnDimension( $col )->setWidth( 18 ); 
                        }
*/                    } 
                    // 内容输出 
                    $i = 1;           
                    foreach ( $datas['appdata'] as $key => $value ) { 
                        $i += 1;
                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $value['app_name'] );
                        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $value['nomove'] );
                        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $value['Activation'] );
                        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $value['sign'] );
                        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $value['app_money'] );
                    } 
                    $i += 1;
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, '' );
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, '' );
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, '' );
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, '' );
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, '' );
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, '' );

                    $i += 1;
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, '总计' );
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $datas['moves'] );
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $datas['nomove'] );
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $datas['Activation'] );
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $datas['sign'] );
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $datas['app_money'] );

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


/*  
    //导出CSV文件
    public function export(){
        $down = M("download_record");
        $downcount = array();
        $appdata = array(); 
        $end_time = trim($_POST['end_time']);
        $start_time = trim($_POST['start_time']);
        $type = trim($_POST['type']);

        if($end_time && $start_time){
            $num = ($end_time - $start_time)/(24*60*60);
        }else{
            $start_time  = strtotime(date("Y-m-d",time()-7*24*60*60)." 00:00:00");
            $end_time = time();
            $num = 7;
        }
        if($type == 'appdata'){
            for($i = 0; $i<=$num; $i++ ){
                $times = date('Y-m-d',$end_time - $i*24*60*60);
                $starttime = strtotime($times);
                $endtime = strtotime($times." 23:59:59");

                $downcount =  $down->table('sw_download_record AS d')
                        ->join('sw_app AS a on d.APP_KEY = a.APP_KEY')
                        ->field('d.move, d.nomove, d.app_money, a.app_name,is_today_sign,app_money')
                        ->where(" d.add_time between ".$starttime." and ".$endtime.$app_name)
                        ->order("d.add_time desc")
                        ->select();

                foreach($downcount as $k=>$v ){
                    if($v['move'] == 1){
                        $appdata[$v['app_name']]['move']+= 1;
                    }
                    if($v['nomove']==1){
                        $appdata[$v['app_name']]['nomove']+= 1;
                    }
                    if($v['is_today_sign'] == 1){
                        $appdata[$v['app_name']]['sign']+= intval($v['is_today_sign']);    
                    }
                    if($v['app_money'] > 0){
                        $appdata[$v['app_name']]['Activation'] +=1;
                        $appdata[$v['app_name']]['app_money']+= intval($v['app_money']);    
                    }
                    $appdata[$v['app_name']]['app_name'] = $v['app_name'];
                }
            }

            $str = "应用名,运行量,下载量,激活量,签到量,应用消耗金额\n";   
            $str = iconv('utf-8','gb2312',$str);   
            foreach($appdata as $v){
                $app_name = iconv('utf-8','gb2312',$v['app_name']); //中文转码   
                $move = iconv('utf-8','gb2312',$v['move']); 
                $nomove = iconv('utf-8','gb2312',$v['nomove']);
                $Activation = iconv('utf-8','gb2312',$v['Activation']);
                $sign = iconv('utf-8','gb2312',$v['sign']);
                $app_money = iconv('utf-8','gb2312',$v['app_money']);  
                $str .= $app_name.",".$move.",".$nomove.",".$Activation.",".$sign.",".$app_money."\n"; //用引文逗号分开   
            } 

            $file_name = "应用统计";  
        }else if($type == 'downnum'){
            $all_time   = trim( $_POST['times'] );
            if($all_time){
                $times = explode(" - ",$all_time);
                $end_time = strtotime($times[1]." 23:59:59");
                $start_time = strtotime($times[0]);
                $num = ($end_time - $start_time)/(24*60*60);
            }else{
                $start_time = time()-7*24*60*60;
                $end_time = time();
                $num = 7;
            }

            $datacount = array();
            for($i = 0; $i<=$num; $i++ ){
                $times = date('Y-m-d',$end_time - $i*24*60*60);
                $starttime = strtotime($times);
                $endtime = strtotime($times." 23:59:59");
                
                $where = " add_time between ".$starttime." and ".$endtime;
                
                $datacount[$i]['usercount'][] = $down->field("count(*) as num,username")->where($where." and is_today_sign=1")->group("username")->find();
                if(!$datacount[$i]['usercount'][0]['num']){
                    $datacount[$i]['usercount'][0]['num'] = 0; 
                }
                $datacount[$i]['activatcount'][] = $down->field("SUM(app_money) AS money")->where($where." and app_money>0")->find();
                $datacount[$i]['activecount'][] = $down->field("count(*) as num")->where($where." and move = 1")->find();
                if(!$datacount[$i]['activecount'][0]['num']){
                    $datacount[$i]['activecount'][0]['num'] = 0; 
                }
                $datacount[$i]['activeusercount'][] = $down->field("count(*) as num")->where($where." and move = 1")->group("username")->find();
                if(!$datacount[$i]['activeusercount'][0]['num']){
                    $datacount[$i]['activeusercount'][0]['num'] = 0; 
                }
                $datacount[$i]['times'] = $times;
            }

            $str = "日期,激活量,活跃用户,安装消耗金币,签到用户\n";   
            $str = iconv('utf-8','gb2312',$str);   
            foreach($datacount as $v){
                $times = iconv('utf-8','gb2312',$v['times']); //中文转码   
                $activecount = iconv('utf-8','gb2312',$v['activecount'][0]['num']); 
                $activeusercount = iconv('utf-8','gb2312',$v['activeusercount'][0]['num']);
                $activatcount = iconv('utf-8','gb2312',$v['activatcount'][0]['money']);
                $usercount = iconv('utf-8','gb2312',$v['usercount'][0]['num']);
                $str .= $times.",".$activecount.",".$activeusercount.",".$activatcount.",".$usercount."\n"; //用引文逗号分开   
            }   
            $file_name = "分日统计";
        }
        $filename = $file_name."_".date('Ymd').'.csv'; //设置文件名   
        $this->export_csv($filename,$str); //导出   

    }

    public function export_csv($filename,$data){   
        header("Content-type:text/csv");   
        header("Content-Disposition:attachment;filename=".$filename);   
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');   
        header('Expires:0');   
        header('Pragma:public');   
        echo $data;   
    }  
*/    

}

?>