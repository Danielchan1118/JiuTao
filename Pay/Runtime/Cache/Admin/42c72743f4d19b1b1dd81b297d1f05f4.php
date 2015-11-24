<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<meta charset="utf-8">
<title>签到列表</title>
<script src="/Public/jquery/jquery-1.8.3.min.js"></script> 
<link href='/Public/youmi_admin/style/css/bui_css.css' rel="stylesheet" type="text/css" /> 
</head>
<body> 
<div class="bodytitle">
	<div id="h_title">签到列表</div>
	<div class="add_cloum"><button type="button" id="btnShow" class="change_back"> 添加签到 </button></div>
</div>

<div class="subbox">  
	<div class="bui_content_b">
	  <div class="bui-content">
		  <table cellspacing="0" class="table table-bordered" width="1130px">
			<thead>
			  <tr class="phb_name phb_back phb_bors atim_tr">
					<th>排序</th>
					<th>签到名</th>
					<th>签到数字</th>
					<th>时间</th>
					<th>操作</th>
			  </tr>
			</thead>
			<tbody>
			 <?php if(is_array($sign_list)): $key = 0; $__LIST__ = $sign_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($key % 2 );++$key;?><tr align="center" id="hidd<?php echo ($vol["id"]); ?>" class="phb_name <?php if($key%2 == 0): ?>phb_back<?php endif; ?>">
				<td><?php echo ($vol["sort"]); ?></td>
				<td><?php echo ($vol["sign_name"]); ?></td>
				<td><?php echo ($vol["sign_num"]); ?></td>
				<td><?php echo (date('Y-m-d H:i:s',$vol["add_time"])); ?></td>
				<td> <span><a href="javascript:;" id="onedel" delid="<?php echo ($vol["id"]); ?>">删除 | </a><a href="javascript:;" id="btnShows" att="<?php echo ($vol["id"]); ?>">修改</a></span></td>
			   </tr><?php endforeach; endif; else: echo "" ;endif; ?>    
			</tbody>
		  </table>

			<div class="pages_css"> <?php echo ($Page); ?>  </div>
	  </div>
	</div>
</div>
	
<div id="signid" style="display:none;"> 
	<form action="<?php echo U('AppManage/Sign_edit');?>" method="post" id="from_id">
		<table cellspacing="0" class="table table-bordered table-tr">
			<tr><td>排序：</td><td><input type="text" name="sort" value="<?php echo ($sign_edit["sort"]); ?>" id="integral" class="input-back-bor"/></td></tr>
			<tr><td>签到名：</td><td><input type="text" name="sign_name" value="<?php echo ($sign_edit["sign_name"]); ?>" id="sign_name" class="input-back-bor"/></td></tr>
			<tr><td>签到数字：</td><td><input type="text" name="sign_num" value="<?php echo ($sign_edit["sign_num"]); ?>" id="sign_num" class="input-back-bor"/>(第几天签到就写几)</td></tr>
			<input type="hidden" name="editid" id="edit_id" value=""/>
		</table>
	</form>
</div>

<script src="/Public/Plugin/bui/build/bui-min.js?t=201404241421"></script> 
<script src="/Public/youmi/js/WeiZhuan.js" type="text/javascript"></script>
<script type="text/javascript">
$(function (){
	BUI.use(['bui/overlay','bui/form'],function(Overlay,Form){
		var dialog = new Overlay.Dialog({
			title:'签到操作',
			width:500,
			height:320,
			//配置DOM容器的编号
			contentId:'signid',
			success:function () {
			  $("#from_id").submit();
			  this.close();
			}
		  });
		$('#btnShow').on('click',function () {
			$("#integral").val("");
			$("#sign_name").val("");
			$("#sign_num").val("");
			$("#edit_id").val("");
			dialog.show();
		});

		$('tbody tr td #btnShows').on('click',function () {
			var edit_id = $(this).attr("att");
			$.ajax({
				type:'post',
				url:"<?php echo U('Admin/AppManage/Sign_edit');?>",
				dataType:'json',
				data:{"edit_id" : edit_id},
				success:function(data){
					if(data){
						$("#integral").val(data.sort);
						$("#sign_name").val(data.sign_name);
						$("#sign_num").val(data.sign_num);
						$("#edit_id").val(edit_id);
					}else{
						alert(data.info);
					}
				}
			});	
		  dialog.show();
		});
	});


	$("#from_id").submit(function (){
		var integral = $("#integral").val();
  		var sign_name = $("#sign_name").val();
  		var sign_num = $("#sign_num").val();
  		if(integral.length == 0||sign_name.length  == 0 ||sign_num.length == 0){
  			
  			alert('操作失败，数据不能为空！');
  			return false;
  		}
	});

});
	
</script>
</body>
</html>
<script src="/Public/youmi/js/WeiZhuan.js" type="text/javascript"></script>
<script type="text/javascript">
	WeiZhuan.init({'init':'OneDel'});

	var AjaxUrl = {
	    OrderDel : "<?php echo U('AppManage/Signin_list');?>",
	};


</script>