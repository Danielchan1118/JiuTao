<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员列表</title>
<script src="/Public/jquery/jquery-1.8.3.min.js"></script> 
<link href='/Public/youmi_admin/style/css/bui_css.css' rel="stylesheet" type="text/css" />  
</head>
<body>

<div class="bodytitle">
	<div id="h_title">管理员列表</div>
	<div style="margin-left: 20px;"><a href="javascript:;" id="btnShow" class="change_back" >添加管理员</a></div>
</div>

<div class="subbox">  
  <div class="bui_content_b">
    <div class="bui-content">
		<form action="<?php echo U('AdminLogin/adminDEl');?>" method="post">
			<table cellspacing="0" class="table table-bordered">
				<tr id="managerListtr" class="phb_name phb_back phb_bors atim_tr">
					<th width="15"></th>
					<th>用户名</th>
					<th>角色所属</th> 

					
					<th>登录IP</th>
					<th>登录时间</th>
					<th>状态</th>
					<th>操作</th>
				</tr>
				<?php if(is_array($admin_list)): $key = 0; $__LIST__ = $admin_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($key % 2 );++$key;?><tr align="center" id="hidd<?php echo ($vol["id"]); ?>" class="phb_name <?php if($key%2 == 0): ?>phb_back<?php endif; ?>">
						<td><input value="<?php echo ($vol["id"]); ?>" name="ordercheck" data-check-data="order<?php echo ($vol["id"]); ?>" type="checkbox"/></td>
						<td><?php echo ($vol["username"]); ?></td>
						<td><?php echo ($vol["role_name"]); ?></td>
						<td><?php echo ($vol["login_ip"]); ?></td>
						<td><?php echo (date("Y-m-d H:i:s",$vol["login_time"])); ?></td>
						<td><?php if(($vol["display"]) == "0"): ?>开启<?php else: ?>关闭<?php endif; ?></td>
						<td> <span><a href="javascript:;" att="<?php echo ($vol["id"]); ?>" id="btnShows">修改</a> <a href="javascript:;" id="onedel" delid="<?php echo ($vol["id"]); ?>"> 删除 </a> </span></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</table>
		</form>	
		
		<div id="checkbox_class">
		  <ul class="toolbar pull-left">
			<li><label class="checkbox" for="check_box"><input type="checkbox" data-check="uncheck"><a href="javascript:;">全选</a></label></li>
			<li><span><button class="button" id="alldel"> 批量删除 </button> </span></li>
		  </ul>
			<div class="pages_css">
			<?php echo ($Page); ?>		
			</div>
		</div>
    </div>
  </div>
</div>
<div id="adminid" style="display:none;" >
<form action="<?php echo U('AdminLogin/AddAdmin');?>" method="post" id="myform" onsubmit="return dianiji()">
  <table cellspacing="0" class="table table-bordered table-tr " width="480" >
	<tr>
		<td>用户名：</td>
		<td><input type="text" name="username" class="input-back-bor username" value="" id="UserName" maxlength="11" data-check="UserNmae"/> <span id="MessUsername"> 由6-16位的字母，数字组成</span></td>
	</tr>
	<tr>
		<td>密码：</td>
		<td><input type="password" name="password" class="input-back-bor" maxlength="16" id="password" data-check="NumberOrLetter"/> <span id="MessPassword">密码长度大于6小于22</span></td>
	</tr>
	<tr>
		<td>所属角色：</td>
		<td>
			<select name="role" id="selectrole">
				<option value="0" >--请选择--</option>
				<?php if(is_array($roleList)): $i = 0; $__LIST__ = $roleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option id="mid<?php echo ($v["id"]); ?>" value="<?php echo ($v["id"]); ?>" ><?php echo ($v["role_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
		</td>
	</tr>
	<tr>
		<td>状态：</td>
		<td><input  type="radio" name="is_show" id="radio0" value="0" checked />开启&nbsp;&nbsp;<input type="radio" id="radio1" name="is_show" value="1" />关闭</td>
	</tr>
	<input type='hidden' name='edit_id' id='edit_id' value="">
  </table>
</form>
</div>
<script src="/Public/Plugin/bui/build/bui-min.js?t=201404241421"></script> 
<script type="text/javascript">
	BUI.use(['bui/overlay','bui/form'],function(Overlay,Form){
		var dialog = new Overlay.Dialog({
			title:'管理员操作',
			width:500,
			height:320,
			//配置DOM容器的编号
			contentId:'adminid',
			success:function () {
			  $("#myform").submit();
			  this.close();
			}
		});
		$('#btnShow').on('click',function () {
			$(".username").attr("id","UserName");
			$("#UserName").val("");
			$("#UserName").removeAttr("readonly");
			$("#radio0").attr("checked","checked");
			$("#edit_id").val(" ");
			selectid = $("#selectrole ").val();
			$("#mid"+selectid).removeAttr("selected");
			dialog.show();
		});

		$('tbody tr td #btnShows').on('click',function () {
			var edit_id = $(this).attr("att");
			if(edit_id){
				$.ajax({
					type:'post',
					url:"<?php echo U('AdminLogin/AddAdmin');?>",
					dataType:'json',
					data:{"edit_id" : edit_id},
					success:function(data){
						if(data){
							if(data.username){
								$("#UserName").val(data.username);
								$("#UserName").attr("readonly","readonly");
								$(".username").removeAttr("id");
							}
							$("#mid"+data.role_id).attr("selected","selected");
							$("#radio"+data.display).attr("checked","checked");
							$("#edit_id").val(data.id);
						}else{
							alert("操作错误");
						}
					}
				});	
				dialog.show();
			}else{
				alert("操作有误");
			}
		});
	});
	
	function dianiji(){
		var username = $("#username").val();
		var password = $("#password").val();
		if(username =='' || password ==''){
			alert('操作失败，数据不能为空！');
			return false;
		}

	}
</script>

<script src="/Public/youmi/js/WeiZhuan.js" type="text/javascript"></script> 
<script type="text/javascript">
  WeiZhuan.init({'init':'OneDel,UserName,PassWord,PassWord2'});

  var AjaxUrl = {
	checkuser : "<?php echo U('Admin/check_username');?>",
    OrderDel : "<?php echo U('AdminLogin/adminDEl');?>",
  };

</script>

</body>
</html>