<?php 
/**
 * $name 后台
 * @author DanielChan
 */
namespace Admin\Controller;
class VendorsController extends AdminController
{

	/**
	 * $name 商家添加
	 */
	public function  vendorAdd(){
		$id = intval($_GET['id']);
		$cat = M('pay_cat');
		$ven = M('vendor');
		if($_POST){
			$data['name'] 	  = trim($_POST["ven_name"]);
			$cat_id 		  = implode(',',$_POST["cat"]);
			$data['cat_id']   = $cat_id;
			$data['at_city']  = trim($_POST["city"]);
			$data['lon'] 	  = trim($_POST["lon"]);
			$data['lat'] 	  = trim($_POST["lat"]);
			$data['depict']   = trim($_POST["content"]);
			$data['address']  = trim($_POST["adds"]);
			$data['phone'] 	  = trim($_POST["mobilephone"]);
			$data['ven_name'] = trim($_POST["person"]);
			$data['qq'] 	  = trim($_POST["qq"]);
			$data['add_time'] = time();

			if( empty($data['name']) ){ $this->error('商家名不能为空'); }
			if( empty($data['lon']) ){ $this->error('经度不能为空'); }
			if( empty($data['lat']) ){ $this->error('纬度不能为空'); }
			
			//商家商标上传 
			if( $_FILES['img_url']['size'] > 0 ){              
                $imgPath = './Public/Uploads/vendors/';
                $this->MakeDir($imgPath);
                $appth  =  $imgPath . '/'; 
                $upload = new \Think\Upload();// 实例化上传类    
                $upload->maxSize  = 3145728;
                $upload->rootPath = $appth;
                $upload->savePath = '';
                $upload->saveName = array('uniqid','');
                $upload->exts     = array('jpg', 'gif', 'png', 'jpeg');
                $upload->autoSub  = true;
                $upload->subName  = array('date','Ymd');

                $info   =   $upload->uploadOne($_FILES['img_url']);    
                if(!$info) {// 上传错误提示错误信息        
                    $this->error($upload->getError());    
                }else{// 上传成功 获取上传文件信息     
                    $data['ven_img_url'] =  substr($imgPath.$info['savepath'].$info['savename'],1); 
                    unlink(substr($_POST['has_img_url'], 1));
                }
            }
			
			//商家展示1上传 
			if( $_FILES['show_img1']['size'] > 0 ){              
                $imgPath = './Public/Uploads/vendors/';
                $this->MakeDir($imgPath);
                $appth  =  $imgPath . '/'; 
                $upload = new \Think\Upload();// 实例化上传类    
                $upload->maxSize  = 3145728;
                $upload->rootPath = $appth;
                $upload->savePath = '';
                $upload->saveName = array('uniqid','');
                $upload->exts     = array('jpg', 'gif', 'png', 'jpeg');
                $upload->autoSub  = true;
                $upload->subName  = array('date','Ymd');

                $info   =   $upload->uploadOne($_FILES['show_img1']);    
                if(!$info) {// 上传错误提示错误信息        
                    $this->error($upload->getError());    
                }else{// 上传成功 获取上传文件信息     
                    $data['show_img_url1'] =  substr($imgPath.$info['savepath'].$info['savename'],1); 
                    unlink(substr($_POST['has_show_img1'], 1));
                }
            }
			//商家展示2上传 
			if( $_FILES['show_img2']['size'] > 0 ){              
                $imgPath = './Public/Uploads/vendors/';
                $this->MakeDir($imgPath);
                $appth  =  $imgPath . '/'; 
                $upload = new \Think\Upload();// 实例化上传类    
                $upload->maxSize  = 3145728;
                $upload->rootPath = $appth;
                $upload->savePath = '';
                $upload->saveName = array('uniqid','');
                $upload->exts     = array('jpg', 'gif', 'png', 'jpeg');
                $upload->autoSub  = true;
                $upload->subName  = array('date','Ymd');

                $info   =   $upload->uploadOne($_FILES['show_img2']);    
                if(!$info) {// 上传错误提示错误信息        
                    $this->error($upload->getError());    
                }else{// 上传成功 获取上传文件信息     
                    $data['show_img_url2'] =  substr($imgPath.$info['savepath'].$info['savename'],1); 
                    unlink(substr($_POST['has_show_img2'], 1));
                }
            }
			//商家展示3上传 
			if( $_FILES['show_img3']['size'] > 0 ){              
                $imgPath = './Public/Uploads/vendors/';
                $this->MakeDir($imgPath);
                $appth  =  $imgPath . '/'; 
                $upload = new \Think\Upload();// 实例化上传类    
                $upload->maxSize  = 3145728;
                $upload->rootPath = $appth;
                $upload->savePath = '';
                $upload->saveName = array('uniqid','');
                $upload->exts     = array('jpg', 'gif', 'png', 'jpeg');
                $upload->autoSub  = true;
                $upload->subName  = array('date','Ymd');

                $info   =   $upload->uploadOne($_FILES['show_img3']);    
                if(!$info) {// 上传错误提示错误信息        
                    $this->error($upload->getError());    
                }else{// 上传成功 获取上传文件信息     
                    $data['show_img_url3'] =  substr($imgPath.$info['savepath'].$info['savename'],1); 
                    unlink(substr($_POST['has_show_img3'], 1));
                }
            }
			//商家展示4上传 
			if( $_FILES['show_img4']['size'] > 0 ){              
                $imgPath = './Public/Uploads/vendors/';
                $this->MakeDir($imgPath);
                $appth  =  $imgPath . '/'; 
                $upload = new \Think\Upload();// 实例化上传类    
                $upload->maxSize  = 3145728;
                $upload->rootPath = $appth;
                $upload->savePath = '';
                $upload->saveName = array('uniqid','');
                $upload->exts     = array('jpg', 'gif', 'png', 'jpeg');
                $upload->autoSub  = true;
                $upload->subName  = array('date','Ymd');

                $info   =   $upload->uploadOne($_FILES['show_img4']);    
                if(!$info) {// 上传错误提示错误信息        
                    $this->error($upload->getError());    
                }else{// 上传成功 获取上传文件信息     
                    $data['show_img_url4'] =  substr($imgPath.$info['savepath'].$info['savename'],1); 
                    unlink(substr($_POST['has_show_img4'], 1));
                }
            }
			
			if($id){
				$res = $ven->where('id='.$id)->save($data);
			}else{				
				$res = $ven->add($data);
			}
 
			if($res){
				$this->success('操作成功',U('Vendors/vendorList'));
			}else{
				$this->error('操作失败  '.mysql_error());
			}	
		}else{
			$this->catList = $cat->where('pid<>0')->select();
			$this->venInfo = $ven->where('id='.$id)->find();
			$this->display();
		}
	}

	/**
	 * $name 商家列表
	 */
	public function vendorList(){
		$cat = M('pay_cat');
		$ven = M('vendor');
		$list = $ven->order('id DESC')->select();
		foreach( $list as $k => $v ){
			$catList = $cat->field('name')->where(' id IN ('.$v['cat_id'].')')->select();
			foreach( $catList as $vo ){
				$list[$k]['cat_name']  .= $list[$k]['cat_name'] ? ','.$vo['name'] : $vo['name'];	
			}
		}
		$this->venlist = $list;
		$this->display();
	}
	
	/**
	 * $name 商家删除
	 */
	public function vendorDel(){
		$id = intval($_GET['id']);
		$ven = M('vendor');
		$venInfo = $ven->where('id='.$id)->find();
		
		if( $venInfo['ven_img_url'] ){  unlink(substr($venInfo['ven_img_url'], 1)); }
		if( $venInfo['show_img_url1'] ){  unlink(substr($venInfo['show_img_url1'], 1)); }
		if( $venInfo['show_img_url2'] ){  unlink(substr($venInfo['show_img_url2'], 1)); }
		if( $venInfo['show_img_url3'] ){  unlink(substr($venInfo['show_img_url3'], 1)); }
		if( $venInfo['show_img_url4'] ){  unlink(substr($venInfo['show_img_url4'], 1)); }
		
		if($ven->delete($id)){
			$this->success('删除成功',U('Vendors/vendorList'));
		}else{
			$this->error('删除失败');
		}
	}
	

}



















?>