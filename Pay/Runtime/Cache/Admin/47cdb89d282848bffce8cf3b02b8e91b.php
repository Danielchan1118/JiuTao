<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="/Public/jquery/jquery-1.8.3.min.js"></script> 
<link href='/Public/youmi_admin/style/css/bui_css.css' rel="stylesheet" type="text/css" /> 

	<title>任务记录</title>
</head>
<body>

<div class="bodytitle">
	<div id="h_title">任务记录</div>
	<div class="margin_bottom">
	 <form action="/Admin/UserRecord/TaskRecord" method="post" enctype="multipart/form-data">
		<span class="span-right-space">用户名：<input type="text" name="username" value="<?php echo ($username); ?>" class="input-back-bor">  </span>
		<span class="span-right-space">类型:
		<select name="active_type" style="width:120px;" class="input-back-bor">
			<option value="0">-请选择-</option>
			<option value="vip" <?php if(($vip) == $active_type): ?>selected='selected'<?php endif; ?>>vip</option>
			<?php if(is_array($activity_list)): $i = 0; $__LIST__ = $activity_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vol["atr_name"]); ?>" <?php if(($vol["atr_name"]) == $active_type): ?>selected='selected'<?php endif; ?>><?php echo ($vol["atr_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		 </select> 
		 </span>
		<span class="span-right-space"><input type="submit" name="do_sumbit" value="提交" class="change_back"></span>
		<span class="span-right-space"><i class="lr1">总金币<?php echo ($earn_coins_count); ?>万 </i></span>
	</form>
	</div>
</div>

    <div class="subbox">  
        <div class="bui_content_b">
            <div class="bui-content">
				<form action="/Admin/UserRecord/TaskDelAll" method="post" enctype="multipart/form-data">
					<table cellspacing="0" class="table table-bordered">
						<tr class="phb_name phb_back phb_bors atim_tr">
						    <th><input value="" id="check_box" onclick="selectall('id[]');" type="checkbox"></th>
						    <th height="23"> 序号 </th>
						    <th> 用户 </th>
						    <th> 任务名称 </th>
						    <th> 赚取金币 </th>
						    <th> 完成时间 </th>
					        <th> 操作 </th>
					  	</tr>
					  <?php if(is_array($tasks)): $key = 0; $__LIST__ = $tasks;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><tr id="hidd<?php echo ($vo["id"]); ?>" class="phb_name <?php if($key%2 == 0): ?>phb_back<?php endif; ?>">
						    <td><input value="<?php echo ($vo["id"]); ?>" name="id[]" type="checkbox"/></td>
						    <td height="23"><?php echo ($vo["cid"]); ?></td>
						    <td><?php echo ($vo["username"]); ?></td>
						    <td><?php echo ($vo["atr_name"]); ?></td>
						    <td><?php echo ($vo["earn_coin"]); ?></td>
						    <td><?php echo (date('Y-m-d H:i:s',$vo["add_time"])); ?></td>
					        <td><span> <a href="javascript:;" id="onedel" delid="<?php echo ($vo["id"]); ?>" >删除</a></span>  </td>
					  	</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</table>
					<div id="checkbox_class">
					  <ul class="toolbar pull-left">
						<li><label class="checkbox" for="check_box"><input type="checkbox" data-check="uncheck"><a href="javascript:;">全选</a></label></li>
						<li><p><button class="button" id="alldel"> 批量终止 </button></p></li>
					  </ul>
					  <span class="lm1">当页总金币：<?php echo ($earn_coins); ?>万</span>
						<div class="pages_css">
						<?php echo ($Page); ?>		
						</div>
					</div>
				</form>                   
            </div>
        </div>
    </div>    
</body>
</html>
<script src="/Public/youmi/js/WeiZhuan.js" type="text/javascript"></script> 
<script type="text/javascript">
  WeiZhuan.init({'init':'Check,AllDel,OneDel'});

  var AjaxUrl = {
    OrderDel : "<?php echo U('/Admin/UserRecord/DeleteTask');?>",
  };

</script>