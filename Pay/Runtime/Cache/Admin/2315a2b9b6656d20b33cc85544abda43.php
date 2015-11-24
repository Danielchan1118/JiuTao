<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<!--描述-->
		<meta name="description" content="" />
		<!--关键字-->
		<meta name="keywords" content="" />
		<title>旧淘 - 添加分类</title>
	</head>
	<body>
		<form action="<?php echo U('Admin/Article/catAdd?id='.$catInfo['id']);?>" method="post"  enctype="multipart/form-data">
			<table cellspacing="0" cellpadding="0">
				<tr>
					<td>父级菜单：</td>
					<td>
						<select name="pid">
							<option value="0">顶级菜单</option>
							<?php if(is_array($catList)): $i = 0; $__LIST__ = $catList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($vo["id"]) == $catInfo['pid']): ?>selected<?php endif; ?> ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>分类名：</td>
					<td><input type="text" name="cat_name" value="<?php echo ($catInfo["name"]); ?>" /></td>
				</tr>
				<tr>
					<td>是否推荐/热门：</td>
					<td>
						<select name="status">
							<option value="1" selected >否</option>
							<option value="2" <?php if(($catInfo["is_status"]) == "2"): ?>selected=selected<?php endif; ?> >是</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>是否隐藏：</td>
					<td>
						<select name="is_hidden">
							<option value="1" selected >否</option>
							<option value="2" <?php if(($catInfo["is_hidden"]) == "2"): ?>selected=selected<?php endif; ?> >是</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>分类图标：</td>
					<td>
						<input type="file" name="img_url" />
						<input type="hidden" name="has_img_url" value="<?php echo ($catInfo["cat_img_url"]); ?>" />
						<?php if(($catInfo["cat_img_url"]) != ""): ?><img src="<?php echo ($catInfo["cat_img_url"]); ?>" width="60" height="60"/><?php endif; ?>
					</td>
				<tr>
				<tr>
					<td>菜单栏图标：</td>
					<td>
						<input type="file" name="menu_img_url" />
						<input type="hidden" name="has_menu_img_url" value="<?php echo ($catInfo["little_img_url"]); ?>" />
						<?php if(($catInfo["little_img_url"]) != ""): ?><img src="<?php echo ($catInfo["little_img_url"]); ?>" width="60" height="60"/><?php endif; ?>
					</td>
				<tr>				
					<td>&nbsp;&nbsp;</td>
					<td><span style="color:red;font-weight:bold; "> 注：菜单栏图标传小图；分类图标传大图</span></td>
				</tr>	
				</tr>				
				<tr>
					<td>排序：</td>
					<td><input type="text" name="ord" value="<?php echo ($catInfo["ord_id"]); ?>" /></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;</td>
					<td><input type="submit" name="dosubmit" value="提交" ></td>
				</tr>
			</table>
		</form>
	</body>
</html>