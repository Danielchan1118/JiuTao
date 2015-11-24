<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="/Public/jquery/jquery-1.8.3.min.js"></script> 
<link href='/Public/youmi_admin/style/css/bui_css.css' rel="stylesheet" type="text/css" /> 

<link href="/Public/Plugin/mta/style/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="all" href="/Public/Plugin/mta/style/css/daterangepicker-bs3.css" />
<script type="text/javascript" src="/Public/Plugin/mta/style/js/moment.js"></script>
<script type="text/javascript" src="/Public/Plugin/mta/style/js/daterangepicker.js"></script>

<title>会员列表</title>
</head>
<body>
<div class="bodytitle">
	<div id="h_title">会员列表</div>
	<form action="<?php echo U('Comment/Comment_list');?>" method="post" enctype="multipart/form-data">
		<div class="margin_bottom">
				评论人:<input type="text" value="<?php echo ($nickname); ?>" name="nickname" style="height: 27px;width: 182px;"><input type="submit" style="height: 28px;width: 64px;margin-left: 20px;" value="搜索">
		</div>
	</form>

</div>

<div class="subbox">  
	<div class="bui_content_b">
		<div class="bui-content">
			<table  cellspacing="0" class="table table-bordered">
				<tr class="phb_name phb_back phb_bors atim_tr" style="font-size: 12px;font-weight: 600;">
					<td>id</td>
						<td>评论人</td>
						<td>评论数据</td>
						<td>评论的内容</td>
						<td>评论时间</td>
						<td>操作</td>
				</tr>
				<?php if(is_array($com)): $key = 0; $__LIST__ = $com;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><tr id="hidd<?php echo ($vo["id"]); ?>" class="phb_name <?php if($key%2 == 0): ?>phb_back<?php endif; ?>">
				  <td><?php echo ($vo["id"]); ?></td>
							<td><?php echo ($vo["nickname"]); ?></td>
							<td><?php echo ($vo["p_content"]); ?></td>
							<td><?php echo ($vo["content"]); ?></td>
							<td><?php echo (date("Y-m-d",$vo["add_time"])); ?></td>
							<td><a href="<?php echo U('Comment/Comment_list?id='.$vo['id']);?>">删除</a>&nbsp;&nbsp;</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</table>
			<div>
			  <ul class="toolbar pull-left">
				<li><label class="checkbox" for="check_box"><input type="checkbox" data-check='uncheck'><a href="javascript:;" >全选</a></label></li>
				<li><p><button class="button" id="alldel" > 批量删除 </button></p></li>
			  </ul>
			  <div class="pages_css">
				<?php echo ($Page); ?>
			  </div>
			</div>
		</div>
	</div>
</div> 
	
</body>
</html>