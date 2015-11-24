<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=2.0" /> 
<title>鬼故事 - 添加内容</title>
<script src="/Public/jquery/jquery-1.8.3.min.js"></script>
<link rel='stylesheet' href='/Public/Admin/statics/admin/css/admin.css' />
</head>
<body>
<a href="javascript:history.go(-1);" style="float:left;">返回</a><br/>
	<form action="<?php echo U('AdminLogin/addadmin?aid='.$edit_admin['id']);?>" enctype="multipart/form-data" method="post" >
    <table cellpadding="0" cellspacing="0">
      <tr class="admin_lin">
        <td>用户名：</td>
        <td><input type="text" name="username" value="<?php echo ($edit_admin["username"]); ?>"/></td>
      </tr>
	  <tr class="admin_lin">
        <td>密码：</td>
        <td><input name="password" type="password"  value="<?php echo ($edit_admin["password"]); ?>" /></td>
      </tr>	 
	   <!--<tr class="admin_lin">
        <td>所属角色</td>
        <td>
			<select name="role">
				<?php if(is_array($role_list)): $i = 0; $__LIST__ = $role_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vol["id"]); ?>"><?php echo ($vol["role_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
		</td>
		</td>
      </tr>	-->
	  <tr class="user-input-tr">
        <td>状态</td>
        <td>
			<input type="radio" name="is_show" value="0" checked="">开启
			<input type="radio" name="is_show" value="1">关闭
		</td>
		</td>
      </tr>	
	  <tr><td>&nbsp;&nbsp;</td><td><input type="submit" name="dosubmit" value="提交" ></td></tr>
    </table>
  </form>
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
    

</script>