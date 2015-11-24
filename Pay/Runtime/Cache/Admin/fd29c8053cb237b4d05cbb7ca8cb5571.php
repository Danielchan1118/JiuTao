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

<title>版本列表</title>
</head>
<body>
<div class="bodytitle">
	<div id="h_title">版本列表</div>
	

</div>

<div class="subbox">  
	<div class="bui_content_b">
		<div class="bui-content">
			<table  cellspacing="0" class="table table-bordered">
				<tr class="phb_name phb_back phb_bors atim_tr" style="font-size: 12px;font-weight: 600;">
					<th >ID</th>
					<th >标题名称</th>
					<th >链接</th>
					<th >版本号</th>
					<th >内容</th>
					<th >图片</th>
					<th >操作</th>
				</tr>
				<?php if(is_array($lists)): $key = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><tr id="hidd<?php echo ($vo["id"]); ?>" class="phb_name <?php if($key%2 == 0): ?>phb_back<?php endif; ?>">
				 <th ><?php echo ($vo["id"]); ?></th>
						<th ><?php echo ($vo["title"]); ?></th>
						<th ><?php echo ($vo["url"]); ?></th>
						<th ><?php echo ($vo["version"]); ?></th>
						<th ><?php echo ($vo["content"]); ?></th>
						<th ><img src="<?php echo ($vo["img"]); ?>" style="width: 80px;height: 60px;"></th>
						<th><a href="versionAdd?id=<?php echo ($vo["id"]); ?>">修改</a></th>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</table>
			<div>
			 
			  <div class="pages_css">
				<?php echo ($Page); ?>
			  </div>
			</div>
		</div>
	</div>
</div> 
	
</body>
</html>