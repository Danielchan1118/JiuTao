<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<!--描述-->
		<meta name="description" content="" />
		<!--关键字-->
		<meta name="keywords" content="" />
	<title>旧淘 - 商家列表</title>
	</head>
	<body>
		<table cellspacing="0" cellpadding="0" border="1">
			<tr align="center">
				<td>商家名称</td>
				<td>商家图标</td>
				<td>分类</td>
				<td>所在城市</td>
				<td>联系人</td>
				<td>联系电话</td>
				<td>QQ号码</td>				
				<td>商家地址</td>				
				<td>操作</td>		
			</tr>
			<?php if(is_array($venlist)): $i = 0; $__LIST__ = $venlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr  align="center">
					<td><?php echo ($vo["name"]); ?></td>
					<td><img src="<?php echo ($vo["ven_img_url"]); ?>" width="60" height="60"/></td>					
					<td><?php echo ($vo["cat_name"]); ?></td>
					<td><?php echo ($vo["at_city"]); ?></td>
					<td><?php echo ($vo["ven_name"]); ?></td>
					<td><?php echo ($vo["phone"]); ?></td>
					<td><?php echo ($vo["qq"]); ?></td>					
					<td><?php echo ($vo["address"]); ?></td>					
					<td align="center" >&nbsp;&nbsp;&nbsp;<a href="/Admin/Vendors/vendorAdd/id/<?php echo ($vo["id"]); ?>">修改</a>&nbsp;|&nbsp;<a href="/Admin/Vendors/vendorDel/id/<?php echo ($vo["id"]); ?>">删除</a>&nbsp;</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
	</body>
</html>