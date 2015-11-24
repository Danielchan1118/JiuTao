<?php
/**
 *用户记录管理控制器
 */
namespace Admin\Controller;
class SharingCenterController extends AdminController {
    /**
     * 分享中心信息
     */
    public function SharingCenter(){
    	$M = M('share_center');
        $id = intval($_GET['id']);
    	if(IS_POST){
            $data['title']       = trim($_POST['title']);
            $data['content']     = trim($_POST['content']);
            $data['url']         = trim($_POST['url']);
			$data['version']     = trim($_POST['version']);
            $data['service_url'] = trim($_POST['service_url']);
            $data['weixin_url']  = trim($_POST['weixin_url']);
            $data['fenx_url']    = trim($_POST['fenx_url']);
            if($data['title'] == ''){ $this->error('标题不能为空！'); }
            if($data['content'] == ''){ $this->error('内容不能为空！'); }
            if($data['url'] == ''){ $this->error('链接不能为空！'); }
            if($data['version'] == ''){ $this->error('版本号不能为空！'); }

			if( $_FILES['image']['size'] > 0 ){              
                $imgPath = './Public/Uploads/images/';
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

                $info   =   $upload->uploadOne($_FILES['image']);   
                if(!$info) {// 上传错误提示错误信息        
                    $this->error($upload->getError(),U('SharingCenter/SharingCenter'));    
                }else{// 上传成功 获取上传文件信息     
                    $data['img'] =  substr($imgPath.$info['savepath'].$info['savename'],1); 
                    unlink(substr($_POST['images1'], 1));
                }
            }

            if( $_FILES['VipImages']['size'] > 0 ){              
                $imgPath = './Public/Uploads/images/';
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

                $info   =   $upload->uploadOne($_FILES['VipImages']);   
                if(!$info) {// 上传错误提示错误信息        
                    $this->error($upload->getError(),U('SharingCenter/SharingCenter'));    
                }else{// 上传成功 获取上传文件信息     
                    $data['img'] =  substr($imgPath.$info['savepath'].$info['savename'],1); 
                    unlink(substr($_POST['images1'], 1));
                }
            }
            if($id){
                $res = $M->where('id='.$id)->save($data);
                $msg = "修改成功！";
            }else{
                $res = $M->add($data);
                $msg = "添加成功！";
            }
            
            if($res){
                $this->success($msg,U('SharingCenter/SharingCenterList'));
            }else{
                $this->error('操作失败！',U('SharingCenter/SharingCenterList'));
            }
    		  
    	}else{
            $info_mass = $M->where('id='.$id)->find();
            $this ->info_mass = $info_mass;
            $this->display(); 
        }
    	
		
	}

    /**
     * 分享中心信息
     */
    public function SharingCenterList(){
        $M = M('share_center');
        $this->List = $M->select();
        $this->display();
    }

}
?>