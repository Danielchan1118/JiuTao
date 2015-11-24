<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<!--描述-->
		<meta name="description" content="" />
		<!--关键字-->
		<meta name="keywords" content="" />
		<title>旧淘 - 分类列表</title>
	</head>
	<body>
		<table cellspacing="0" cellpadding="0" border="0">
			<tr align="center">
				<td>名称</td>
				<td>分类图标</td>
				<td>菜单栏图标</td>
				<td>是否隐藏</td>
				<td>是否推荐/热门</td>
				<td>排序</td>
				<td>操作</td>				
			</tr>
			<?php if(is_array($listInfo)): $i = 0; $__LIST__ = $listInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td><?php echo ($vo["name"]); ?></td>
					<td><img src="<?php echo ($vo["cat_img_url"]); ?>" width="60" height="60"/></td>
					<td><img src="<?php echo ($vo["little_img_url"]); ?>" width="60" height="60"/></td>	
					<td align="center" ><?php if(($vo["is_hidden"]) == "2"): ?>是<?php else: ?>否<?php endif; ?></td>
					<td align="center" ><?php if(($vo["is_status"]) == "2"): ?>是<?php else: ?>否<?php endif; ?></td>
					<td align="center" ><?php echo ($vo["ord_id"]); ?></td>					
					<td align="center" >&nbsp;<a href="/Admin/Article/catAdd/id/<?php echo ($vo["id"]); ?>">修改</a>&nbsp;|&nbsp;<a href="/Admin/Article/catDel/id/<?php echo ($vo["id"]); ?>">删除</a>&nbsp;</td>					
				</tr>
				<?php if(($vo["sub"]) != ""): if(is_array($vo["sub"])): $i = 0; $__LIST__ = $vo["sub"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
							<td>&nbsp;&nbsp;&nbsp;|_<?php echo ($v["name"]); ?></td>
							<td><img src="<?php echo ($v["cat_img_url"]); ?>" width="60" height="60"/></td>
							<td><img src="<?php echo ($v["little_img_url"]); ?>" width="60" height="60"/></td>	
							<td align="center" ><?php if(($v["is_hidden"]) == "2"): ?>是<?php else: ?>否<?php endif; ?></td>
							<td align="center" ><?php if(($v["is_status"]) == "2"): ?>是<?php else: ?>否<?php endif; ?></td>					
							<td align="center" ><?php echo ($v["ord_id"]); ?></td>
							<td align="center" >&nbsp;&nbsp;&nbsp;<a href="/Admin/Article/catAdd/id/<?php echo ($v["id"]); ?>">修改</a>&nbsp;|&nbsp;<a href="/Admin/Article/catDel/id/<?php echo ($v["id"]); ?>">删除</a>&nbsp;</td>					
						</tr><?php endforeach; endif; else: echo "" ;endif; endif; endforeach; endif; else: echo "" ;endif; ?>
		</table>
	</body>
</html>