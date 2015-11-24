<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="/Public/jquery/jquery-1.8.3.min.js"></script> 
	<link href='/Public/youmi_admin/style/css/bui_css.css' rel="stylesheet" type="text/css" /> 
<title>广告位列表</title>
</head>

<body style="background:#EDEEF0">

<div class="bodytitle">
	<div id="h_title">广告列表</div>
	<form action="<?php echo U('/Admin/AdManage/AddType?edit_id='.$info[id]);?>" method="post">
        <div class="margin_bottom">
        <span class="span-right-space">
              类型名称：<input type="text" name="type" value="<?php echo ($info["ads_type"]); ?>"  class="input-back-bor" style="color:red;" />
        </span>
        
        <span><input type="submit" value="添加类型" class="change_back"/></span>
        </div>
    </form>
</div>

<div class="subbox">
    <div class="bui_content_b">
        <div class="bui-content">
        <table cellspacing="0" class="table table-bordered" width="1130">
            <tr class="phb_name phb_back phb_bors atim_tr">
                <th>广告位ID</th>
                <th>广告位名称</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($sele_list)): $key = 0; $__LIST__ = $sele_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($key % 2 );++$key;?><tr class="phb_name <?php if($key%2 == 0): ?>phb_back<?php endif; ?>">
                    <td><?php echo ($vol["id"]); ?></td>
                    <td><?php echo ($vol["ads_type"]); ?></td>
                    <td> <a href="<?php echo U('/Admin/AdManage/AddType?edit_id='.$vol[id]);?>">修改</a> | <a href="<?php echo U('/Admin/AdManage/AddType?del_id='.$vol[id]);?>">删除</a></td> 
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
        </div>
    </div>
</div>
</body>
</html>