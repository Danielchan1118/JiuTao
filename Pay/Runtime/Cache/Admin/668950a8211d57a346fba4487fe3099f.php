<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>资讯编辑</title>
	<script src="http://g.tbcdn.cn/fi/bui/jquery-1.8.1.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="/Public/Plugin/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/Plugin/ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/Public/Plugin/ueditor/lang/zh-cn/zh-cn.js"></script>
	
	<script src="/Public/jquery/jquery-1.8.3.min.js"></script> 
	<link href='/Public/youmi_admin/style/css/bui_css.css' rel="stylesheet" type="text/css" /> 
</head>
<body style="background:#EDEEF0">
<div class="bodytitle">
	<div id="h_title">资讯编辑</div>
	<div class="add_cloum"><button type="button" id="newsedit" class="change_back"> 资讯列表 </button></div>
</div>
 
<div class="subbox">  
	<div class="bui_content_b">
		<div class="bui-content"> 
			<form action="<?php echo U('Admin/Article/articleEdit?id='.$artinfo['id']);?>" method="post"id="from_id">
				<table cellspacing="0" class="table table-tr article-td">
				<tr><td>标题名称：</td>
					<td><input type="text" name="title" value="<?php echo ($artinfo["title"]); ?>" id="title" class="input-back-bor shop-input-class"/></td>
				</tr>
				<tr><td>外部链接：</td>
					<td><input type="text" name="web_link" value="<?php echo ($artinfo["link"]); ?>" id="link" class="input-back-bor shop-input-class"/></td>
				</tr>
				<tr><td>是否显示：</td>
					<td><input type="radio" name="is_on" value="0" checked />是<input type="radio" name="is_on" value="1" <?php if(($artinfo["status"]) == "1"): ?>checked="checked"<?php endif; ?> />否
					<input type='hidden' id='conInfo' value='<?php echo ($artinfo["content"]); ?>'/></td>
				</tr>
				
				<tr><td>作者：</td><td><input type="text" name="author" value="<?php echo ($artinfo["author"]); ?>" id="author" class="input-back-bor shop-input-class"/></td></tr>
				<tr><td>排序：</td>
					<td><input type="text" name="sort" value="<?php echo ($artinfo["sort"]); ?>" class="input-back-bor shop-input-class" /><td>
				</tr>
				<tr><td>内容：</td><script id="editor" type="text/plain" style="width:1024px;height:500px;"></script></td></tr>
				<tr><td>&nbsp;&nbsp;</td><td><input type="submit" value="提交" class="change_back"></td></tr>
			</table>
			</form>
		</div>
	</div>
</div>
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

		var author_id   = $("#author").val();
		var editor_id   = $("#editor").val();

    	if(title_id == "" || link_id == "" || editor_id ==""){
    		alert('请填写完整信息再进行提交!');
    		return false;
    	}
    });
    
	$("#newsedit").click(function(){
		window.location.href="<?php echo U('Article/articleList');?>";
	});
</script>