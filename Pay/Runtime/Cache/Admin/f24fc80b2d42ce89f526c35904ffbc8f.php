<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>角色列表</title>
	<script src="/Public/jquery/jquery-1.8.3.min.js"></script> 
	<link href='/Public/youmi_admin/style/css/bui_css.css' rel="stylesheet" type="text/css" />  
</head>
<body>

<div class="bodytitle">
	<div id="h_title">角色列表</div>
	<div style="margin-left: 20px;"><a href="javascript:;" id="btnShow" class="change_back">添加角色</a></div>
</div>

<div class="subbox">  
  <div class="bui_content_b">
    <div class="bui-content">
      <table cellspacing="0" class="table table-bordered"width="1130" >
        <tr class="phb_name phb_back phb_bors atim_tr">
          <th>序号</th>
          <th>角色名</th>
          <th>角色描述</th>
          <th>状态</th>
          <th>管理操作</th> 
        </tr>
        <?php if(is_array($rList)): $key = 0; $__LIST__ = $rList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($key % 2 );++$key;?><tr id="hidd<?php echo ($v["id"]); ?>" class="phb_name <?php if($key%2 == 0): ?>phb_back<?php endif; ?>">
          <td><?php echo ($v["cid"]); ?></td>  
          <td><?php echo ($v["role_name"]); ?></td>
          <td><?php echo ($v["role_detail"]); ?></td>
          <td><?php if(($v["display"]) == "1"): ?>禁止<?php else: ?>启用<?php endif; ?></td>
          <td><span><a href="/Admin/Menus/rolePriv/id/<?php echo ($v["id"]); ?>">权限管理</a>&nbsp;|&nbsp;<a href="javascript:;" id="btnShows" att="<?php echo ($v["id"]); ?>" >修改</a>&nbsp;|&nbsp;<a href="javascript:;" id="onedel" delid="<?php echo ($v["id"]); ?>">删除</a></span></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
      </table>
      <div class="pages_css">
        <?php echo ($Page); ?>
      </div>
    </div>
  </div>
</div>
<div id="roleid" style="display:none;">  
<form action="<?php echo U('AdminLogin/roleEdit');?>" method="post" id="roleform" onsubmit="return dianji()">

  <div class="control-group">
            <label class="control-label">角色名称:</label>
            <div class="controls">
			 <input type="text" name="name" id="rolename" value="" class="input-back-bor" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">角色描述:</label>
            <div class="controls">
            <textarea name="detail" id="detail" cols="50" rows="7" ></textarea>
            </div>
          </div>
            <div class="control-group">
              <label class="control-label">是否启用</label>
              <div class="controls">
				<input type="radio" name="display" value="0" id="radio0" />启用&nbsp;&nbsp;<input type="radio" name="display" value="1" id="radio1" />禁止
              </div>
            </div>
		<span id="editsub"></span>
</form>
</div>

<script src="/Public/Plugin/bui/build/bui-min.js?t=201404241421"></script> 
<script type="text/javascript">
	BUI.use(['bui/overlay','bui/form'],function(Overlay,Form){

		var form = new Form.Form({
			srcNode : '#form'
		}).render();
 
		var dialog = new Overlay.Dialog({
			title:'角色操作',
			width:500,
			height:320,
			//配置DOM容器的编号
			contentId:'roleid',
			success:function () {
			  $("#roleform").submit();
			  this.close();
			}
		  });
		$('#btnShow').on('click',function () {
			$("#rolename").val("");
			$("#detail").text("");
			$("#radio0").attr("checked","checked");
			$("#editsub").html("");
		  dialog.show();
		});

		$('tbody tr td #btnShows').on('click',function () {
			var edit_id = $(this).attr("att");
			$.ajax({
				type:'post',
				url:"<?php echo U('AdminLogin/roleEdit');?>",
				dataType:'json',
				data:{"edit_id" : edit_id},
				success:function(data){
					if(data){
						$("#rolename").val(data.role_name);
						$("#detail").text(data.role_detail);
						$("#radio"+data.display).attr("checked","checked");
						$("#editsub").html("<input type='hidden' name='editid' id='editid' value="+data.id+">");
					}else{
						alert("操作错误");
					}
				}
			});	
		  dialog.show();
		});
	});

	
	
</script>
<script src="/Public/youmi/js/WeiZhuan.js" type="text/javascript"></script> 
<script type="text/javascript">
  WeiZhuan.init({'init':'OneDel'});

  var AjaxUrl = {
    OrderDel : "<?php echo U('AdminLogin/roleDel');?>",
  };

  function dianji(){
		var rolename = $("#rolename").val();
		var detail = $("#detail").val();
		if(rolename.length ==0 || detail.length ==0){
			alert('操作失败，数据不能为空！');
			return false;
		}
	}
</script>
</body>
</html>