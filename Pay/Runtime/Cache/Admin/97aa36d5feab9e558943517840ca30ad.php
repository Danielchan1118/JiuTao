<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta charset="utf-8">
<title>资讯列表</title>
	<script src="/Public/jquery/jquery-1.8.3.min.js"></script> 
	<link href='/Public/youmi_admin/style/css/bui_css.css' rel="stylesheet" type="text/css" /> 
</head>
<body style="background:#EDEEF0"> 
<div class="bodytitle">
	<div id="h_title">资讯列表</div>
	<div class="add_cloum"><button type="button" id="newsedit" class="change_back"> 添加资讯 </button></div>
</div>

<div class="subbox">  
<div class="bui_content_b">
	<div class="bui-content">
			<table cellspacing="0" class="table table-bordered">
			  <thead>
				
				<tr class="phb_name phb_back phb_bors atim_tr">
				  <th width="15"></th>
				  <th>标题名称</th>
				  <th>作者</th>
				  <th>外部链接</th>
				  <th>添加时间</th>
				  <th>是否显示</th>
				  <th>排序</th>
				  <th>操作</th>
				</tr>
			  </thead>
			  <tbody>
			<?php if(is_array($articleList)): $key = 0; $__LIST__ = $articleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($key % 2 );++$key;?><tr align="center" id="hidd<?php echo ($v["id"]); ?>" class="phb_name <?php if($key%2 == 0): ?>phb_back<?php endif; ?>">
			  <td><input value="<?php echo ($v["id"]); ?>" name="ordercheck" data-check-data="order<?php echo ($v["id"]); ?>" type="checkbox"/></td>
			  <td><?php echo ($v["title"]); ?></td>
			  <td><?php echo ($v["author"]); ?></td>
			  <td><?php echo ($v["link"]); ?></td>
			  <td><?php if(($v["modify_time"]) > "0"): echo (date("Y-m-d",$v["modify_time"])); endif; ?></td>
			  <td><?php if(($v["status"]) == "0"): ?>是<?php else: ?>否<?php endif; ?></td>
			  <td><?php echo ($v["sort"]); ?></td>
			  <td><span > <a href    ="<?php echo U('Article/articleEdit?id='.$v['id']);?>">修改</a>&nbsp;|&nbsp; <a href="javascript:;" id="onedel" delid="<?php echo ($v["id"]); ?>">删除</a></span></td>
			 </tr><?php endforeach; endif; else: echo "" ;endif; ?>   
			  </tbody>
			</table>
			
			<div id="checkbox_class">
			  <ul class="toolbar pull-left">
				<li><label class="checkbox" for="check_box"><input type="checkbox" data-check="uncheck"><a href="javascript:;">全选</a></label></li>
				<li><p><button class="button change_back" id="alldel"> 批量终止 </button></p></li>
			  </ul>
				<div class="pages_css">
				<?php echo ($Page); ?>
				</div>
			</div>
	</div>
</div>
</div>
<script src="/Public/youmi/js/WeiZhuan.js" type="text/javascript"></script> 
<script type="text/javascript">
	$("#newsedit").click(function(){
		window.location.href="<?php echo U('Article/articleEdit');?>";
	});
  //需要使用的方法放到init,如果后面跟一个参数，框架内部会实例化
  WeiZhuan.init({'init':'Check,AllDel,OneDel'});
  var AjaxUrl = {
    OrderDel : "<?php echo U('/Admin/Article/allDel');?>",
  };

</script>