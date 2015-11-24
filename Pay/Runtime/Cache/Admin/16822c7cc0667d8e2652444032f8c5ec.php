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
	<form action="<?php echo U('Issue/IssueList');?>" method="post" enctype="multipart/form-data">
		<div class="margin_bottom">
			<span class="span-right-space">用户名：<input type="text" value="<?php echo ($nickname); ?>" name="nickname" style="height: 27px;width: 182px;"><input type="submit" style="height: 28px;width: 64px;margin-left: 20px;" value="搜索"></span>
		</div>
	</form>

</div>

<div class="subbox">  
	<div class="bui_content_b">
		<div class="bui-content">
			<table  cellspacing="0" class="table table-bordered">
				<tr class="phb_name phb_back phb_bors atim_tr" style="font-size: 12px;font-weight: 600;">
					<td></td>
						<td>id</td>
						<td>用户名</td>
						<td>产品类型</td>
						<td>标题</td>
						<td class="Width_add">内容</td>
						<td>交易方式</td>
						<td>订单状态</td>
						<td>评论数量</td>
						<td>收藏数量</td>
						<td>是否显示</td>
						<td>评论时间</td>
						<td class="Width_add">操作</td>
				</tr>
				<?php if(is_array($com)): $key = 0; $__LIST__ = $com;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><tr id="hidd<?php echo ($vo["id"]); ?>" class="phb_name <?php if($key%2 == 0): ?>phb_back<?php endif; ?>">
				  <td ><input value="<?php echo ($vo["id"]); ?>" name="ordercheck" data-check-data="order<?php echo ($vo["id"]); ?>" type="checkbox"/></td>
				  <td><?php echo ($vo["id"]); ?></td>
							<td><?php echo ($vo["nickname"]); ?></td>
							<td><?php echo ($vo["name"]); ?></td>
							<td><?php echo ($vo["title"]); ?></td>
							<td class="Width_add"><?php echo ($vo["content"]); ?></td>
							<td><?php if($vo["pay_type"] == 1): ?>出售
									 <?php elseif($vo["pay_type"] == 2): ?>交换
									 <?php else: ?> 免费赠送<?php endif; ?>							
							</td>
							<td><?php if($vo["status"] == 1): ?>在售
									 <?php elseif($vo["pay_type"] == 2): ?>已换
									 <?php else: ?> 已过期<?php endif; ?></td>
							<td><?php echo ($vo["comment_total"]); ?></td>
							<td><?php echo ($vo["point_like"]); ?></td>
							<td><?php if(($vo["is_show"]) == "1"): ?>是<?php else: ?><span style="color:red;">否</span><?php endif; ?></td>
							<td><?php echo (date("Y-m-d",$vo["add_time"])); ?></td>
							<td class="Width_add"><a href="<?php echo U('admin/Issue/Lookarticle?id='.$vo['id']);?>">查看详情</a>&nbsp;&nbsp;<?php if(($vo["is_show"]) == "2"): ?><a href="<?php echo U('Issue/IssueList?uid='.$vo['id']);?>" style="color:red;">未审</a><?php else: ?><a href="<?php echo U('Issue/IssueList?uid='.$vo['id']);?>">已审</a><?php endif; ?>&nbsp;&nbsp;<a href="<?php echo U('Issue/IssueList?id='.$vo['id']);?>">删除</a></td>
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
<script src="/Public/Admin/statics/js/WeiZhuan.js" type="text/javascript"></script> 
<script type="text/javascript">

//需要使用的方法放到init,如果后面跟一个参数，框架内部会实例化
    WeiZhuan.init({'init':'Check,AllDel,OneDel'});
	var AjaxUrl = {
	OrderDel : "<?php echo U('Issue/IssueDel');?>",
	};
	
</script>