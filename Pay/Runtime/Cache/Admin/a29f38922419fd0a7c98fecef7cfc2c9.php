<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="/Public/jquery/jquery-1.8.3.min.js"></script> 
<link href='/Public/youmi_admin/style/css/bui_css.css' rel="stylesheet" type="text/css" /> 
<title>兑换中心</title>
</head>

<body>
<div class="bodytitle">
	<div id="h_title">兑换中心</div>
	<div class="margin_bottom">
		<a href="javascript:;" class="change_back" id="btnShow">添加顶级栏目</a>
	</div>
</div>

<div class="subbox">  
  <div class="bui_content_b">
    <div class="bui-content">
		<table cellspacing="0" class="table table-bordered">
		<tr class="phb_name phb_back phb_bors atim_tr">
			<th>图片</th>
			<th>兑换名称</th>
			<th>简写</th>
			<th>金币数</th>
			<th>排序</th>
			<th>操作</th>
		</tr>
		<?php if(is_array($test)): $key = 0; $__LIST__ = $test;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($key % 2 );++$key;?><tr class="phb_back" id="hidd<?php echo ($vol["id"]); ?>" >
				<td><img src="<?php echo ($vol["image"]); ?>" id="image<?php echo ($vol["id"]); ?>" width="50px" height="50px"></td>
				<td><?php echo ($vol["convert_name"]); ?></td>
				<td><?php echo ($vol["tag"]); ?></td>
				<td><?php echo ($vol["gold"]); ?></td>
				<td><?php echo ($vol["order_id"]); ?></td>
				<td><span><a href="javascript:;" id="addbtnShows" att="<?php echo ($vol["id"]); ?>">添加 </a> | <a href="javascript:;" id="onedel" delid="<?php echo ($vol["id"]); ?>"> 删除 </a> | <a href="javascript:;" id="btnShows" att="<?php echo ($vol["id"]); ?>"> 修改 </a></span></td>
			</tr>
				
			<?php if(is_array($vol["sub"])): $i = 0; $__LIST__ = $vol["sub"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="convert_tr" id="hidd<?php echo ($vo["id"]); ?>">
					<td class="convert_td"><img src="<?php echo ($vol["image"]); ?>" width="50px" height="50px"></td>
					<td><?php echo ($vo["convert_name"]); ?></td>
					<td><?php echo ($vo["tag"]); ?></td>
					<td><?php echo ($vo["gold"]); ?></td>
					<td><?php echo ($vo["order_id"]); ?></td>
					<td><span><a href="javascript:;" id="onedel" delid="<?php echo ($vo["id"]); ?>"> 删除 </a> | <a href="javascript:;" id="btnShows" att="<?php echo ($vo["id"]); ?>" attrid="<?php echo ($vol["id"]); ?>" > 修改 </a></span></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
		</table>
	</div>
  </div>
</div>
<div id="convertid" class="convert_class" style="display:none;">  
<form method='post' action="<?php echo U('Convert/ConvertAdd');?>" enctype="multipart/form-data" id="myform"  >
  <table cellspacing="0" class="table table-bordered table-tr" width="1130" >
	<tr>
		<td>兑换名称</td>
		<td><input type="text" name="convert_name" id="convert_name" value="<?php echo ($edit["convert_name"]); ?>" class="input-back-bor"/></td>
	</tr>
	 <tr>
		<td>封面图</td>
		<td> <input type="file" name="image" value="" style="display:none;" id="image" class="input-back-bor"/><img  src="" id="images" style="margin-left:20px;"><input type="hidden" name="image1" id="image1" value=""/></td>
	</tr>
	 <tr>
		<td>金币数</td>
		<td><input type="text" name="golds" id="golds" value="" class="input-back-bor"/> 万 </td>
	</tr>
	<tr>
		<td>兑换简写</td>
		<td><input type="text" name="tag" id="tag" value="" class="input-back-bor"/></td>
	</tr>
	<tr id="convert_goods">
		<td>兑换商品</td>
		<td> <input type="text" name="shop" id="shop" value="" class="input-back-bor"/></td>
	</tr>
	<tr>
		<td>备注信息</td>
		<td><textarea rows="5" cols="50" name="content" id="content"></textarea></td>
	</tr>
	<tr>
		<td>排序</td>
		<td> <input type="text" name="order_id" id="order_id" value="" class="input-back-bor"/></td>
	</tr>
	<input type="hidden" name="editid" id="edit_id" value=""/>
	<input type="hidden" name="data"  value="1"/>
	<input type="hidden" name="pid" id="add_id" value=""/>
  </table>
</form>
</div>
<script src="/Public/Plugin/bui/build/bui-min.js?t=201404241421"></script> 
<script src="/Public/youmi/js/WeiZhuan.js" type="text/javascript"></script> 
<script type="text/javascript">
	WeiZhuan.init({'init':'OneDel'});
	var AjaxUrl = {
		OrderDel : "<?php echo U('Convert/ConvertDel');?>",
	};

	BUI.use(['bui/overlay','bui/form'],function(Overlay,Form){
		var dialog = new Overlay.Dialog({
			title:'兑换操作',
			width:600,
			height:500,
			//配置DOM容器的编号
			contentId:'convertid',
			success:function () {
			  $("#myform").submit();
			  this.close();
			}
		});
		
		$('#btnShow').on('click',function () {
			$("#convert_name").val("");
			$("#images").attr("src","");
			$("#image1").val("");
			$("#golds").val("");
			$("#tag").val("");
			$("#shop").val("");
			$("#content").text("");
			$("#order_id").val("");
			$("#edit_id").val("");
			$("#image").css("display","block");
			$("#convert_goods td").css("display","none");
			dialog.show();
		});
		
		$('tbody tr td #addbtnShows').on('click',function () {
			var add_id = $(this).attr("att");
			var image = $("#image"+add_id).attr("src");
			$("#image").css("display","none");
			$("#convert_name").val(" ");
			$("#images").attr("src",image);
			$("#image1").val(' ');
			$("#golds").val(" ");
			$("#tag").val(" ");
			$("#shop").val(" ");
			$("#content").text(" ");
			$("#edit_id").val(" ");
			$("#add_id").val(add_id);
			$("#order_id").val(" ");
			$("#convert_goods td").css("","");
			dialog.show();
		});

		$('tbody tr td #btnShows').on('click',function () {
			var edit_id = $(this).attr("att");
			var attrid = $(this).attr("attrid");
			var image = $("#image"+attrid).attr("src");
			
			$.ajax({
				type:'post',
				url:"<?php echo U('Convert/ConvertAdd');?>",
				dataType:'json',
				data:{"edit_id" : edit_id},
				success:function(data){
					if(data){
						$("#convert_name").val(data.convert_name);

						if(data.image != '' && typeof(attrid) == 'undefined'){
							$("#images").attr("src",data.image);
							$("#image1").val(data.image);
						}else{
							$("#images").attr("src",image);
							$("#image1").val(image);
						}

						$("#golds").val(data.gold);
						$("#tag").val(data.tag);
						$("#shop").val(data.convert_goods);
						$("#content").text(data.remarks);
						$("#edit_id").val(edit_id);
						$("#order_id").val(data.order_id);
						if(typeof(attrid) == 'undefined'){
							$("#image").css("display","block");
							$("#convert_goods td").css("display","none");
						}else{
							$("#image").css("display","none");
							$("#convert_goods td").css("display","");
						}
						$("#add_id").val(attrid);
					}else{
						alert("操作错误");
					}
				}
			});	
		  dialog.show();
		});
	});

	 
	$("#myform").submit(function(){
		var convert_name = $("#convert_name").val();
		var golds = $("#golds").val();
		var tag = $("#tag").val();
		var content = $("#content").val();
		var order_id = $("#order_id").val();
		if(convert_name.length ==0 || golds.length ==0 || tag.length ==0 || content.length ==0 || order_id.length ==0){
			alert('操作失败，数据不能为空！');
			return false;
		}
	});
	
</script>

</body>
</html>