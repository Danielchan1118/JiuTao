<?php
/**
 *用户记录管理控制器
 */
namespace Admin\Controller;
class UpVersionsController extends AdminController {
    /**
     * 分享中心信息
     */
    public function versionAdd(){
    	$M = M('upversion');
        $id = intval($_GET['id']);
    	if(IS_POST){
            $data['title']       = trim($_POST['title']);
            $data['content']     = trim($_POST['content']);
            $data['url']         = trim($_POST['url']);
			$data['version']     = trim($_POST['version']);
            if($data['title'] == ''){ $this->error('标题不能为空！'); }
            if($data['content'] == ''){ $this->error('内容不能为空！'); }
            if($data['url'] == ''){ $this->error('链接不能为空！'); }
            if($data['version'] == ''){ $this->error('版本号不能为空！'); }

			if( $_FILES['image']['size'] > 0 ){              
                $imgPath = './Public/Uploads/UpVersions/images/';
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
                    $this->error($upload->getError());    
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
                $this->success($msg,U('UpVersions/versionList'));
            }else{
                $this->error('操作失败！');
            }
    		  
    	}else{
            $this ->info_mass = $M->where('id='.$id)->find();
            $this->display(); 
        }
    	
		
	}
	public function linksList(){
	   $M = M('blogroll');
	   $liknslist = $M->select();
	   $this->liknslist = $liknslist;
	   $this->display();
	
	}
	
	public function linksAdd(){
		$M = M('blogroll');
        $id = intval($_GET['id']);
    	if(IS_POST){
            $data['name']       = trim($_POST['title']);
            $data['links']         = trim($_POST['url']);
			$data['add_time']     = time();
            if($data['name'] == ''){ $this->error('标题不能为空！'); }
            if($data['links'] == ''){ $this->error('链接不能为空！'); }
            if($id){
                $res = $M->where('id='.$id)->save($data);
                $msg = "修改成功！";
            }else{
                $res = $M->add($data);
                $msg = "添加成功！";
            }

            if($res){
                $this->success($msg,U('UpVersions/linksList'));
            }else{
                $this->error('操作失败！');
            }
    		  
    	}else{
				
            $this->display(); 
        }
	}
	public function deletelinks(){
		$M = M('blogroll');
		$d_id = intval($_REQUEST['d_id']);
		if($d_id){
			$delte_links= $M->where('id='.$d_id)->delete();
			if($delte_links){
				$this->success("删除成功",U('UpVersions/linksList'));
			}else{
				$this->error("删除失败");
			}
	    }
	$dele_likns = $M->where('id='.$d_id)->delete();
	}

    /**
     * 分享中心信息
     */
    public function versionList(){
        $M = M('upversion');
        $lists = $M->select();
		$this->lists = $lists;
        $this->display();
    }

}
?>