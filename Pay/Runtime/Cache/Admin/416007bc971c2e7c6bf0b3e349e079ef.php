<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员列表</title>
<script src="/Public/jquery/jquery-1.8.3.min.js"></script> 
<link rel='stylesheet' href='/Public/Admin/statics/admin/css/admin.css' />
<link rel='stylesheet' type='text/css' href='/Public/Admin/statics/admin/css/default.css' />
<link rel='stylesheet' type='text/css' href='/Public/Admin/statics/admin/css/style.css' />
</head>
<body>
<div class="content_box" style="border:none">
      <div class="content" style="height: 587px;">
        <table width="93%" cellspacing="0" cellpadding="5" id="border_table_org" class="border_table_org" style="float: left; display: table;">
          <thead>
            <tr><th>我的个人信息</th></tr>
          </thead>
          <tbody>
            <tr>
              <td><table class="list_table2" width="100%">
                  <colgroup><col width="80px"><col></colgroup>
                  <tbody>
                    <tr>
                      <th width="15"></th>
					<th>用户名</th>
					<th>登录IP</th>
					<th>登录时间</th>
					<th>状态</th>
					<th>操作</th>
                    </tr>
                    <?php if(is_array($admin_list)): $key = 0; $__LIST__ = $admin_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($key % 2 );++$key;?><tr align="center" id="hidd<?php echo ($vol["id"]); ?>" class="phb_name <?php if($key%2 == 0): ?>phb_back<?php endif; ?>">
							<td><input value="<?php echo ($vol["id"]); ?>" name="ordercheck" data-check-data="order<?php echo ($vol["id"]); ?>" type="checkbox"/></td>
							<td><?php echo ($vol["username"]); ?></td>
							<td><?php echo ($vol["login_ip"]); ?></td>
							<td><?php echo (date("Y-m-d H:i:s",$vol["login_time"])); ?></td>
							<td><?php if(($vol["status"]) == "0"): ?>开启<?php else: ?>关闭<?php endif; ?></td>
							<td> <span><a href="<?php echo U('AdminLogin/addadmin?aid='.$vol['id']);?>">修改</a> <a href="<?php echo U('AdminLogin/admindel?id='.$vol['id']);?>"> 删除 </a> </span></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>                   
                  </tbody>
                </table></td>
            </tr>
          </tbody>
        </table>
        <span id="border_iframe" style="display: none;"><iframe id="right_iframe" src="/Admin/AdminLogin/listadmin.html" frameborder="false" scrolling="auto" width="100%" height="auto" style="border: none; height: 587px;" allowtransparency="true"></iframe></span>
      </div>
    </div>

</body>
</html>