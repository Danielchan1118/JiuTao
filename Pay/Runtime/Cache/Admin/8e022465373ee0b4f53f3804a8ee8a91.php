<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=2.0" /> 
<title>鬼故事 - 添加内容</title>
<script src="/Public/jquery/jquery-1.8.3.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Plugin/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Plugin/ueditor/ueditor.all.min.js"> </script>
</head>
<style type="text/css">
.

</style>
<body>
	<!--<form action="<?php echo U('Admin/Article/articleAdd?id='.$artinfo['aid']);?>" method="post" id="from_id">
		<table cellspacing="0" cellpadding="0">
			<tr>
				<td>标题名称：</td>
				<td><input type="text" name="title" value="<?php echo ($find_pay["title"]); ?>" id="title" /><span style="color:red; font-weight:bold;">&nbsp;&nbsp;注：标题长度不能超过13中文字符！</span></td>
			</tr>
			<tr>
				<td>外部链接：</td>
				<td><input type="text" name="web_link" value="<?php echo ($find_pay["web_link"]); ?>" id="link" /></td>
			</tr>
			<tr>
				<td>作者：</td><td><input type="text" name="author" value="<?php echo ($artinfo["author"]); ?>" id="author" /></td>
			</tr>
			<tr>
				<td>排序：</td>
				<td><input type="text" name="sort" value="<?php echo ($artinfo["sort"]); ?>" /><td>
			</tr>
			<tr>
				<td>是否显示：</td>
				<td>
					<input type="radio" name="is_on" value="0" checked />显示
					<input type="radio" name="is_on" value="1" <?php if(($artinfo["status"]) == "1"): ?>checked="checked"<?php endif; ?> />不显示
					<input type='hidden' id='conInfo' value='<?php echo ($artinfo["content"]); ?>'/>
				</td>
			</tr>
			<tr>
				<td>允许评论：</td>
				<td>
					<input type="radio" name="comment" value="0" checked />开启
					<input type="radio" name="comment" value="1" <?php if(($artinfo["is_comment"]) == "1"): ?>checked="checked"<?php endif; ?> />关闭
				</td>
			</tr>
			<tr><td>内容：</td><script id="editor" type="text/plain" style="width:1024px;height:500px;"></script></td></tr>
			<tr><td>&nbsp;&nbsp;</td><td><input type="submit" name="dosubmit" value="提交" ></td></tr>
		</table>
	</form>-->
	<div class="">用户名:<span><?php echo ($find_pay["nickname"]); ?></span></div>
	<div>产品类型:<span><?php echo ($find_pay["name"]); ?></span></div>
	<div>标题名称：<span><?php echo ($find_pay["title"]); ?></span></div>
	<div><?php echo ($find_pay["nickname"]); ?></div>
	<div>外部链接：</div>
	<div>2222</div>
	
	
</body>
</html>



<script type="text/javascript">
	$(function (){
		var ueditor = UE.getEditor('editor');
		ueditor.addListener("ready", function () {
	        // editor准备好之后才可以使用
	        var artInfo = $("#conInfo").val();
			if(artInfo){
				ueditor.setContent(artInfo);	 
			}		
		});
	});

	$('#from_id').submit(function(){
    	var title_id = $("#title").val();
    	if(title_id == ""){
    		alert('请填写完整信息再进行提交!');
    		return false;
    	}
    });
    

</script>