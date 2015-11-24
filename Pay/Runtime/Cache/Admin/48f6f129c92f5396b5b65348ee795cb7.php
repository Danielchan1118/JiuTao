<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="/Public/jquery/jquery-1.8.3.min.js"></script> 
<link href='/Public/youmi_admin/style/css/bui_css.css' rel="stylesheet" type="text/css" /> 
<title>菜单列表</title>
<style>
.bui-content .admin_menus{ background:#E6EFF9;text-align:left;}
</style>
</head>

<body>

<div class="bodytitle">
	<div id="h_title">菜单列表</div>
	<div class="add_cloum"><button type="button" id="btnShow" class="change_back"> 添加后台栏目 </button></div>
</div>

<div class="subbox">  
<div class="bui_content_b">
	<div class="bui-content">
	  <table cellspacing="0" class="table table-bordered"width="1130" >
		<tr class="phb_back phb_bors atim_tr admin_menus" >
		  <th>排序</th>
		  <th>序号</th>
		  <th>菜单英文名称</th>
		  <th>操作</th>
		</tr>
		<?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><tr class="phb_name <?php if($key%2 == 0): ?>phb_back<?php endif; ?>" style="text-align:left;" id="hidd<?php echo ($vo["id"]); ?>">
			  <td><input type="text" size="3" value="<?php echo ($vo["sort"]); ?>" style="border:1px solid #d0d0d0;text-align: center;width: 32px;" readonly></td>
			  <td><?php echo ($vo["id"]); ?></td>  
			  <td><?php echo ($vo["name"]); ?><font color="blue">&nbsp;(<?php echo ($vo["action"]); ?>)</font>
				  <?php switch($vo["is_show"]): case "0": ?><font style="color:rgb(0,0,255);">[显示]</font><?php break;?>
					<?php case "1": ?><font style="color:rgb(0,0,255);">[隐藏]</font><?php break; endswitch;?>
			  </td>    
			  <td><span><a href="javascript:;" id="btnShows" att="<?php echo ($vo["id"]); ?>">添加二级 | </a><a href="javascript:;" id="editid" att="<?php echo ($vo["id"]); ?>">修改 | </a><a href="javascript:;" id="onedel" delid="<?php echo ($vo["id"]); ?>">删除 </a></span></td>  
			</tr>

			<?php if(is_array($vo["listSon"])): $i = 0; $__LIST__ = $vo["listSon"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr class="phb_name" style="text-align:left;" id="hidd<?php echo ($vol["id"]); ?>">
					<td><input type="text" size="3" value="<?php echo ($vo["sort"]); ?>" style="border:1px solid #d0d0d0;text-align: center;width: 32px;" readonly></td>
					<td><?php echo ($vol["id"]); ?></td>  
					<td class="menus_td" style="padding-left: 20px;">  &nbsp;|_<?php echo ($vol["name"]); ?><font color="blue">&nbsp;(<?php echo ($vol["action"]); ?>)</font>
						  <?php switch($vol["is_show"]): case "0": ?><font style="color:rgb(0,0,255);">[显示]</font><?php break;?>
							<?php case "1": ?><font style="color:rgb(0,0,255);">[隐藏]</font><?php break; endswitch;?>
					</td>    
					<td><span><a href="javascript:;" id="editid" att="<?php echo ($vol["id"]); ?>">修改 | </a><a href="javascript:;" id="onedel" delid="<?php echo ($vol["id"]); ?>">删除 </a></span></td>  
				</tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
	  </table>
		<div class="pages_css">
		<?php echo ($Page); ?>
		</div>
	</div>
  </div>
</div>

<div id="menuid" style="display:none;"> 
	<form action="<?php echo U('Menus/menuEdit');?>" id="forms" method="post" >
		<div class="control-group">
            <label class="control-label">上级菜单：</label>
            <div class="controls">
			  <select name="pid" class="input-back-bor" >
				<option value="0" >--请选择--</option>
				<?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option id="mid<?php echo ($vo["id"]); ?>" value="<?php echo ($vo["id"]); ?>" > <?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">栏目名：</label>
            <div class="controls">
             <input type="text" name="name" id="name" value="" class="input-back-bor"/>
            </div>
          </div>
            <div class="control-group">
              <label class="control-label">方法：</label>
              <div class="controls">
				<input type="text" name="action" id="action" value=""  class="input-back-bor"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">是否显示：</label>
              <div class="controls">
               <input type="radio" name="is_show" value="0" id="radio2" checked />显示<input type="radio" name="is_show" value="1" id="radio1" />隐藏
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">排序：</label>
              <div class="controls">
               <input type="text" name="order_id" id="order_id" value="" class="input-back-bor"/>
              </div>
            </div>
			<div class="control-group">
              <label class="control-label">作者</label>
              <div class="controls">
               <input type="text" name="authority" id="authority" value="" class="input-back-bor"/>
              </div>
            </div>
		<span id="hiddenedit"></span>
	</form>
</div>

<script src="/Public/Plugin/bui/build/bui-min.js?t=201404241421"></script> 
<script type="text/javascript">
	BUI.use(['bui/overlay','bui/form'],function(Overlay,Form){
		var dialog = new Overlay.Dialog({
			title:'栏目操作',
			width:500,
			height:320,
			//配置DOM容器的编号
			contentId:'menuid',
			success:function () {
			  $("#forms").submit();
			  this.close();
			}
		  });
		$('#btnShow').on('click',function () {
		  dialog.show();
		});

		$('tbody tr td #editid').on('click',function () {
			var editid = $(this).attr("att");
			$.ajax({
				type:'post',
				url:"<?php echo U('Admin/Menus/menuEdit');?>",
				dataType:'json',
				data:{"editid" : editid},
				success:function(data){
					if(data){
						if(data.pid>0){
							$("#mid"+data.pid).attr("selected","selected");
						}else{
							$("#mid"+data.id).attr("selected","selected");
						}
						$("#name").val(data.name);
						$("#action").val(data.action);
						$("#order_id").val(data.sort);
						$("#authority").val(data.author);
						$("#radio"+data.is_show).attr("checked","checked");
						$("#hiddenedit").html("<input type='hidden' name='editids' value="+editid+">");
					}else{
						alert("操作失败！");
					}
				}
			});	
			dialog.show();
		});

		$('tbody tr td #btnShows').on('click',function () {
			var secondid = $(this).attr("att");
			$.ajax({
				type:'post',
				url:"<?php echo U('Admin/Menus/menuEdit');?>",
				dataType:'json',
				data:{"secondid" : secondid},
				success:function(data){
					if(data){
						$("#mid"+data).attr("selected","selected");
					}else{
						alert("操作失败！");
					}
				}
			});	
		  dialog.show();
		});
	});
	
	$("#forms").submit(function(){
		var action = $("#action").val();
		if(action ==''){
			alert('操作失败，方法名不能为空！');
			return false;
		}
	});
</script>

<script src="/Public/youmi/js/WeiZhuan.js" type="text/javascript"></script> 
<script type="text/javascript">
  //需要使用的方法放到init,如果后面跟一个参数，框架内部会实例化
  WeiZhuan.init({'init':'OneDel'});
  var AjaxUrl = {
    OrderDel : "<?php echo U('/Admin/Menus/menuDel');?>",
  };
</script>
</body>
</html>