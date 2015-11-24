<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="/Public/jquery/jquery-1.8.3.min.js"></script> 
<link href="/Public/Plugin/mta/style/css/bootstrap.min.css" rel="stylesheet">
<link href='/Public/youmi_admin/style/css/bui_css.css' rel="stylesheet" type="text/css" />
<style type="text/css">
	.sign_data{width:400px; height:50px; float:left;}
	.sign_data input{width:57px; height:20px;}
	.hidden{display:none;}
	.show{display:block;}
	#sign_type{width:100%; height:200px; float:left;}
	.content .sign_data input{width:150px; height:30px;}
	.lookClose { float:right; width:30px; height:20px; margin-right:10px; /*opacity:0;*/ cursor:pointer;}
	#justLook { display:none; width:850px; border-radius:15px; position: fixed; z-index:1000; top:50%; left: 200px; background:#E6EFF9; padding-bottom: 10px; } 
	#backgroung{ position: absolute;left: 0;z-index: 99;height: 100%;width: 100%;background: #000;opacity: 0.3;}
</style> 
<title>应用管理</title>
</head>

<body>
<div class="bodytitle">
	
	<div id="h_title">应用列表</div>	
		<div class="margin_bottom">
			<form action="<?php echo U('AppManage/AppList');?>" method="post" style="float:left;">
			<span class="span-right-space">应用名：<input type="text" name="name" value="<?php echo ($app_name); ?>" class="input-back-bor" /></span>
			<span class="span-right-space">商家名： <input type="text" class="input-back-bor" id="lbClassName"  name="coopuser" value="<?php echo ($coopuser); ?>"></span>
			<span class="controls" style="display: -webkit-inline-box;">
				<div class="dropdown dropdown_shop">
					<div style="text-align:right;padding-right:10px"><a href="javascript:;" onclick="$('.dropdown').css('display','none');">&nbsp;X&nbsp;</a></div>
					<div class="select-list cf">
						<?php if(is_array($user_list)): $i = 0; $__LIST__ = $user_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><label  onmouseover="this.className='in'" onmouseout="this.className='out'"><a href="javascript:;" key="<?php echo ($vo["id"]); ?>" class="radio-box"> <?php echo ($vo["username"]); ?> </a></label><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
				</div>
			</span>
			<span class="span-right-space">投放类型： <select name="throw_type" style="width:80px;" class="input-back-bor" ><option value="0">-请选择-</option><option value="1" <?php if($throw_type == 1): ?>selected<?php endif; ?> >未投放</option><option value="2" <?php if($throw_type == 2): ?>selected<?php endif; ?>>已投放</option></select></span>
			<span class="span-right-space">应用类型： <select name="app_type" style="width:80px;" class="input-back-bor" ><option value="0">-请选择-</option><option value="1" <?php if($app_type == 1): ?>selected<?php endif; ?> >游戏</option><option value="2" <?php if($app_type == 2): ?>selected<?php endif; ?> >应用</option></select></span>
			<span class="span-right-space">排序： <select name="orderid" style="width:80px;" class="input-back-bor" ><option value="0">-请选择-</option><option value="1" <?php if($orderid == 1): ?>selected<?php endif; ?> >倒序</option><option value="2" <?php if($orderid == 2): ?>selected<?php endif; ?> >顺序</option></select></span>
		  <span class="span-right-space" ><button type="submit" class="change_back"> 查询 </button></span> 
		  </form> 
			<form action="/Admin/AppManage<?php echo ($strUrl); ?>" method="post" style="float:left;"> 
				<input type="submit" value="导出Excel" class="change_back"/> 
			</form>
			<div style="clear:both;"></div>
		</div>
	

</div>

	<div class="subbox">  
		<div id="backgroung" style="display:none;"></div>
		<div class="bui_content_b">
		  <div class="bui-content">

			
			<div id="justLook">
				<div class="control-group">
					<div class="controls" id="controls">

					</div>
				</div>
			</div>
			
			  <table cellspacing="0" class="table table-bordered" width="1130px">
				<tr class="phb_name phb_back phb_bors atim_tr">
					<th>排序</th>
					<th>应用ID</th>
					<th>应用名</th>
					<th>商家</th>
					<th>应用类型</th>
					<th>封面图片</th>
					<th>文件大小</th>
					<th>下载次数</th>
					<th>投放金额</th>
					<th>总游币</th>
					<th>状态</th>
					<th>投放状态</th>
					<th>应用排序</th>
					<th>编辑</th>
					<th></th>
				</tr>
				<?php if(is_array($app_list)): $key = 0; $__LIST__ = $app_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($key % 2 );++$key;?><tr id="hidd<?php echo ($v["id"]); ?>" class="phb_name <?php if($key%2 == 0): ?>phb_back<?php endif; ?>">
					<td><?php echo ($v["cid"]); ?></td>
					<td id="eid"><?php echo ($v["id"]); ?></td>
					<td><?php echo substr($v['app_name'],0,12);?></td>
					<td><?php echo ($v["username"]); ?></td>
					<td><?php if($v["app_type"] == 1): ?>游戏 <?php elseif($v["app_type"] == 2): ?> 应用<?php endif; ?></td>
					<td><img src="<?php echo ($v["app_cover"]); ?>" width="60" height="60" /></td>
					<td><?php echo ($v["app_size"]); ?></td>
					<td><?php echo ($v["app_downloadnum"]); ?></td>
					<td><?php echo ($v["expend_money"]); ?></td>
					<td><?php echo ($v["app_integral"]); ?></td>
					<td>
						<?php switch($v["stauts"]): case "1": ?>已审核<?php break;?>
							<?php case "2": ?><font color='green'>未审核</font><?php break; endswitch;?>
					</td>
					<td>
						<?php switch($v["is_throw"]): case "1": ?>未投放<?php break;?>
							<?php case "2": ?><font color='green'>已投放</font><?php break; endswitch;?>
					</td>
					<td><?php echo ($v["order_id"]); ?></td>
					<td><span><a href="javascript:;" class="seesign" att="<?php echo ($v["id"]); ?>">查看签到</a> | <a href="<?php echo U('CheckApp/CreateAppThree?app_id='.$v['id']);?>">应用修改</a> | <a href="<?php echo U('AppManage/AppDo?edit_id='.$v['id']);?>">设置 | <a href="javascript:;" id="onedel" delid="<?php echo ($v["id"]); ?>">删除</a></span><td></tr><?php endforeach; endif; else: echo "" ;endif; ?>
		
			</table>	
				<div class="pages_css"> <?php echo ($Page); ?>  </div>
		  </div>
		</div>
	</div>

<div id="signinfo" style="display:none;">
	
</div>

<script type="text/javascript">
$(function(){
	$(".seesign").each(function (i,e){
		$(e).click(function(){
			var edit_id = $(e).attr("att");
			$("#backgroung").css("display","block");
			$.ajax({
				type:'get',
				url:"<?php echo U('AppManage/justLook');?>",
				dataType:'json',
				data:{"id" : edit_id},
				success:function(data){
					$html = '';
					$html += "<div class='lookClose'>关闭</div>";
					$html += "<div style='clear:both;'></div>";
					if( false != data.sign_list )
					{
						for(var i in data.sign_list){
							$html += "<div class='sign_data' id='data"+i+"'><input type='checkbox' value='"+i+"' id='check"+i+"'";
							if( data.sign_list[i].inter > 1){ $html += "checked"; }
							$html += "/> <img src='/Public/youmi/image/sign/"+i+"_y.png' width='30px' height='30px' />"; 
							if( data.sign_list[i].num == 1)
							{ 
								$html += "首次签到"; 
							}else if( i == data.count_num )
							{
								$html += "深度使用"; 
							}else
							{
								$html += "第"+data.sign_list[i].num+"天签到"; 
							}								
							$html += "积分:<input type='text' value='"+data.sign_list[i].inter+"' name='inter"+i+"'  id='inter"+i+"' /></div>";
						}
					}
				else
					{
						for(i=0;i<data.signlists.length;i++)
						{
							$html += "<div class='sign_data' id='data"+(i+1)+"'> <input type='checkbox' value='"+(i+1)+"' id='check"+(i+1)+"' /> <img src='/Public/youmi/image/sign/"+(i+1)+"_y.png' width='50px' height='50px' /> "+data.signlists[i].sign_name +"积分:<input type='text' value='' id='inter"+(i+1)+"' name='inter"+(i+1)+"' /> </div>";
						}	
					}
					$html += "<div style='clear:both;'></div>";
					$('#controls').html($html);
					$('#justLook').css('display','block');
					$(".lookClose").click(function(){
						$('#justLook').css('display','none');
						$('#backgroung').css('display','none');
					});
				}
			});
		});
	});
})


</script> 
<script src="/Public/youmi/js/WeiZhuan.js" type="text/javascript"></script> 
<script type="text/javascript">
	WeiZhuan.init({'init':'OneDel'});
	var AjaxUrl = {
		OrderDel : "<?php echo U('AppManage/appDel');?>",
	};

	$(".bodytitle #lbClassName").click(function(){
		$(".dropdown").css("display","block"); 
	});

	var className = $.trim($("#lbClassName").text());
	$(".select-list label a").click(function(){
		$(".select-list label").removeClass("selected");
		$(this).parent().addClass("selected");
		$("#lbClassName").val($(this).html());
		$("#lbClassName").attr("appid",$(this).attr('key'));
		$(".dropdown").css("display","none");
	}).each(function(){
		if($(this).text() == className){
			$(this).parent().addClass("selected");
		}
	});
</script>


</body>
</html>