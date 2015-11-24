<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>版本操作-旧淘</title>
	</head>
	<body style="background:#EDEEF0"> 
		<table cellspacing="0" width="1130px">
			<thead>
				<tr >
					<th >ID</th>
					<th >名称</th>
					<th >友情链接</th>
					<th >操作</th>	    
					<th >修改时间</th>	    
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($liknslist)): $i = 0; $__LIST__ = $liknslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr align="center" >
						<th ><?php echo ($v["id"]); ?></th>
						<th ><?php echo ($v["name"]); ?></th>
						<th ><?php echo ($v["links"]); ?></th>
						<th ><?php echo (date("Y-m-d H:i:s",$v["add_time"])); ?></th>
						<th><a href="linksAdd?id=<?php echo ($v["id"]); ?>">修改</a><a href="deletelinks?d_id=<?php echo ($v["id"]); ?>">删除</a></th>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>     
			</tbody>
		</table>
	</body>
</html>