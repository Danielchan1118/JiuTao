<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	  <title>版本操作-旧淘</title>
	</head>
	<body style="background:#EDEEF0">
		<form action="/Admin/UpVersions/versionAdd?id=<?php echo ($info_mass["id"]); ?>" method="post" enctype="multipart/form-data">
			<table cellspacing="0" class="table table-tr article-td" id="shar_input">
				<tr>
					<td>标题名称：</td>
					<td><input type="text" name="title" value="<?php echo ($info_mass["title"]); ?>" id="title" class="input-back-bor shop-input-class"/></td>
				</tr>
				<tr>
					<td>链接：</td>
					<td><input type="text" name="url" value="<?php echo ($info_mass["url"]); ?>" id="link" class="input-back-bor shop-input-class"/></td>
				</tr>
				<tr>
					<td>版本号：</td>
					<td><input type="text" name="version" value="<?php echo ($info_mass["version"]); ?>" id="link" class="input-back-bor shop-input-class"/></td>
				</tr>
				<tr>
					<td>内容：</td>
					<td><textarea name="content" id="detail" cols="50" rows="7"><?php echo ($info_mass["content"]); ?></textarea></td>
				</tr>
				<tr>
					<td>图片：</td>
					<td><input type="file" name="image" /><?php if(($info_mass["img"]) != ""): ?><img src="<?php echo ($info_mass["img"]); ?>" style="width: 300px;height: 167px;"><input type="hidden" name="images1" value="<?php echo ($info_mass["img"]); ?>"/><?php endif; ?><span style="color:red;">上传的图片的大小是533*262</span>
					</td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;</td>
					<td><input type="submit" value="提交" class="change_back"></td>
				</tr>
			</table>
		</form>
	</body>
</html>