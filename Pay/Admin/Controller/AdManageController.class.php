<?php
/**
 * 广告管管理控制器
 * @author 付敏平
 */
namespace Admin\Controller;
class AdManageController extends AdminController {
    /**
     * 广告列表
     */
    public function AdList(){
        $M = M('ads');
		
        $n = 10;
        $count = $M->count();
        $Page = new \Think\Page($count,$n);
        $adlist  =  $M->table(PREFIX.'ads u')
                      ->join(PREFIX.'ads_type as w on u.type_id=w.id')
                      ->field('u.id,u.ads_name,u.images,u.url,u.type_id,u.is_show,u.start_time,u.end_time,u.order_id,u.add_time,w.ads_type')
                      ->limit($Page->firstRow.','.$Page->listRows)
                      ->select(); 
			  		  
        $this->adlist =$adlist;
        $this->display();
    }

    /**
     * 添加类型
     */
    public function AddType($edit_id='',$del_id =''){
        $M = M('ads_type');  
		$ads = M('ads');		
        if($_POST){
            $arr['ads_type'] = trim(htmlspecialchars($_POST['type']));
            $arr['add_time'] = time();
            if($arr['ads_type']==''){
                $this->error('名称不能为空');
            }
            if($edit_id){
                 $addtype = $M->where('id='.$edit_id)->save($arr);
             }else{
                $addtype = $M->add($arr);
             }
           
            if($addtype){
                $this->success('操作成功',U('AdManage/AddType'));
            }else{
                $this->error('操作失败');
            }
        }else{
            if($del_id >0){
                $del_type = $ads->where('type_id='.$del_id)->find();
                if($del_type){
                    $this->error('该类型下有广告,不能删除,请确认该类型下无广告,继续操作');
                }else{
                    $rest = $M->where("id=".$del_id)->delete();
                    if($rest){
                        $this->success('删除成功',U('AdManage/AddType'));
                    }else{
                        $this->error('删除失败');
                    }
                }                
            }else{
                $this->info = $ads->where('id='.$edit_id)->find();
                $sele_list = $M->select();
                $this->sele_list = $sele_list;
                $this->display();
            }
        }
    }

    /**
     * @name 修改/添加广告
     * @param int $id
     * 
     */
    public function AdMan($id='0'){
        if($_POST){
			$arr['ads_name'] = trim($_POST["ads_name"]); 
            if(!$arr['ads_name']){
                $this->error('广告名称不能为空');
            }
			$all_time   = trim( $_POST['reservation'] );
			if($all_time){
				$times = explode(" - ",$all_time);
				$arr['end_time'] = strtotime($times[1]);
				$arr['start_time'] = strtotime($times[0]);
				$_GET['end_time'] = $end_time;
				$_GET['start_time'] = $start_time;
			}else if(empty($end_time) || empty($start_time)){
				$arr['end_time'] = time();
				$arr['start_time']  = time()-7*24*60*60;
			}
          
            $arr['url'] = $_POST["url"];
			$arr['order_id'] = $_POST["order_id"];
            $arr['is_show'] = $_POST["is_show"];
            $arr['type_id'] = $_POST["type_name"];
            $arr['add_time'] = time();

            if( $_FILES['image']['size'] > 0 ){              
                $imgPath = './Public/Uploads/ads/';
                $this->MakeDir($imgPath);
                $appth =  $imgPath . '/'; 
                $upload = new \Think\Upload();// 实例化上传类    
                $upload->maxSize = 3145728;
                $upload->rootPath = $appth;
                $upload->savePath = '';
                $upload->saveName = array('uniqid','');
                $upload->exts     = array('jpg', 'gif', 'png', 'jpeg');
                $upload->autoSub  = true;
                $upload->subName  = array('date','Ymd');
                
                $imageinfo=getimagesize($_FILES['image']['tmp_name']);
                $width  = $imageinfo[0];         //这个就是得到的图像宽度
                $height = $arrs[1]; 
                if($width!=620 && $height!=300){
                    $this->error('图片的像素是 620*300 ！');
                }
                $info   =   $upload->uploadOne($_FILES['image']);    
                if(!$info) {// 上传错误提示错误信息        
                    $this->error($upload->getError(),U('AdManage/AdList'));    
                }else{// 上传成功 获取上传文件信息     
                    $arr['images'] =  substr($imgPath.$info['savepath'].$info['savename'],1); 
                    unlink(substr($_POST['image1'], 1));
                }
            }else{
				$arr['images'] = $_POST['image1'];
			}
			
			
            $ads = M('ads');
            if($id>0){
                $res = $ads->where('id='.$id)->save($arr);
            }else{
                $res = $ads->add($arr);
            }
            if($res){
                $this->success('操作成功',U('AdManage/AdList'));
            }else{
                $this->error('操作失败');
            }
        }else{
			if($id >0){
				$ads = M('ads');
				$adsInfo = $ads->where('id='.$id)->find();
			}else{
				$adsInfo['end_time'] = time();
				$adsInfo['start_time']  = time()-7*24*60*60;
			}
			$M = M('ads_type');  
			$typeList = $M->select();
			$this->typeList = $typeList;
			$this->adsInfo = $adsInfo;
			$this->display();
        }     
    }

    /**
     * @name 删除广告
     * @param int $id
     * 
     */
    public function delAd(){
		$del_id = intval($_POST['orderid']);
		if($del_id > 0){
			$ads = M('ads');
			$img_url = $ads->where('id='.$del_id)->getField('images');
			unlink($img_url);
			$res = $ads->where('id='.$del_id)->delete();
			if($res){
				$arr['ret'] = 1;
			 	$arr['message'] = "删除成功";	
			}else{
				$arr['ret'] = 1;
			 	$arr['message'] = "删除失败";	
			}
			$this->ajaxReturn($arr);
		}
    }
}
?>