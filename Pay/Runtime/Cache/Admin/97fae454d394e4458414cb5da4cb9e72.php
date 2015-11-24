<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<title>旧淘 - 添加商家</title>
		<script src="/Public/jquery/jquery-1.8.3.min.js"></script>
		<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=C93319dd1af626cb71e11de3ee036917"></script>
		<script type="text/javascript">			
			$(function(){
				$("#address").blur(function(){
					var ares = $(this).val();
					if(ares == ''){
						alert('商家地址不能为空');
						return false;
					}
					$('#er_ads').html('');
					// 百度地图API功能
					// 创建地址解析器实例
					var myGeo = new BMap.Geocoder();
					// 将地址解析结果显示在地图上,并调整地图视野
					myGeo.getPoint(ares, function(point){
						if (point) {
							$('#lon').val(point.lng);
							$('#lat').val(point.lat);
						}else{
							$('#er_ads').html('请用输入规范地址,如：广东省深圳市xx区xx路');
						}
					});	
				});
			})		
		</script>
	</head>
	<body>
		<form action="<?php echo U('Admin/Vendors/vendorAdd?id='.$venInfo['id']);?>" method="post" enctype="multipart/form-data">
			<table cellspacing="0" cellpadding="0" >
				<tr>
					<td>商家名称：</td>
					<td><input type="text" name="ven_name" value="<?php echo ($venInfo["name"]); ?>" /></td>
				</tr>
				<tr>
				<tr>
					<td>商家图标：</td>
					<td>
						<input type="file" name="img_url" />
						<input type="hidden" name="has_img_url" value="<?php echo ($venInfo["ven_img_url"]); ?>" />
						<?php if(($venInfo["ven_img_url"]) != ""): ?><img src="<?php echo ($venInfo["ven_img_url"]); ?>" width="60" height="60"/><?php endif; ?>
					</td>
				</tr>
				<tr>
					<td>分类：</td>
					<td style="width:520px;"> 
						<?php if(is_array($catList)): $i = 0; $__LIST__ = $catList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type="checkbox" name="cat[]" value="<?php echo ($vo["id"]); ?>" <?php if( false !== stripos( $venInfo['cat_id'],$vo['id'] ) ){ echo checked; } ?> /><?php echo ($vo["name"]); ?>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
					</td>
				</tr>
				<tr>
					<td>所在城市：</td>
					<td><input type="text" name="city" value="<?php echo ($venInfo["at_city"]); ?>" /></td>
				</tr>			
				<tr>
					<td>联系人：</td>
					<td><input type="text" name="person" value="<?php echo ($venInfo["ven_name"]); ?>" /></td>
				</tr>
				<tr>
					<td>联系电话：</td>
					<td><input type="text" name="mobilephone" value="<?php echo ($venInfo["phone"]); ?>" /></td>
				</tr>
				<tr>
					<td>QQ号码：</td>
					<td><input type="text" name="qq" value="<?php echo ($venInfo["qq"]); ?>" /></td>
				</tr>
				<tr>
					<td>商家地址：</td>
					<td><input type="text" name="adds" value="<?php echo ($venInfo["address"]); ?>" id="address" />&nbsp;&nbsp;<span style="color:red;">*</span><span id="er_ads" style="color:red;"></span></td>
				</tr>
				<tr>
					<td>商家展示：</td>
					<td>
						<input type="file" name="show_img1" /><?php if(($venInfo["show_img_url1"]) != ""): ?><img src="<?php echo ($venInfo["show_img_url1"]); ?>" width="60" height="60"/><?php endif; ?><br/>
						<input type="file" name="show_img2" /><?php if(($venInfo["show_img_url2"]) != ""): ?><img src="<?php echo ($venInfo["show_img_url2"]); ?>" width="60" height="60"/><?php endif; ?><br/>
						<input type="file" name="show_img3" /><?php if(($venInfo["show_img_url3"]) != ""): ?><img src="<?php echo ($venInfo["show_img_url3"]); ?>" width="60" height="60"/><?php endif; ?><br/>
						<input type="file" name="show_img4" /><?php if(($venInfo["show_img_url4"]) != ""): ?><img src="<?php echo ($venInfo["show_img_url4"]); ?>" width="60" height="60"/><?php endif; ?>
						<input type="hidden" name="has_show_img1" value="<?php echo ($venInfo["show_img_url1"]); ?>" />
						<input type="hidden" name="has_show_img2" value="<?php echo ($venInfo["show_img_url2"]); ?>" />
						<input type="hidden" name="has_show_img3" value="<?php echo ($venInfo["show_img_url3"]); ?>" />
						<input type="hidden" name="has_show_img4" value="<?php echo ($venInfo["show_img_url4"]); ?>" />
					</td>
				</tr>
				<tr>
					<td>商家描述：</td>
					<td>
						<textarea name="content" style="resize:none; width:400px; height:130px; "><?php echo ($venInfo["depict"]); ?></textarea>
						<input type="hidden" name="lon" value="<?php echo ($venInfo["lon"]); ?>" id="lon"/>
						<input type="hidden" name="lat" value="<?php echo ($venInfo["lat"]); ?>" id="lat"/>						
					</td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;</td>
					<td><input type="submit" name="dosubmit" value="提交" ></td>
				</tr>
			</table>
		</form>
	</body>
</html>