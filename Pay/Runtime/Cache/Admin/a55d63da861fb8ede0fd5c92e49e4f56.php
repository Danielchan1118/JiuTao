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
	<form action="<?php echo U('UserCenter/UserList');?>" method="post" enctype="multipart/form-data">
		<div class="margin_bottom">
			<span class="span-right-space">用户名：<input type="text" name="username" value="<?php echo ($username); ?>" class="input-back-bor"></span>
			<span class="span-right-space">注册时间：<input type="text" readonly="readonly" style="width: 185px" name="reservation" id="reservation" class="form-control" value="<?php echo (date('Y-m-d',$start_time)); ?> - <?php echo (date('Y-m-d',$end_time)); ?>" />
				<script type="text/javascript">
				  $(document).ready(function() {
					 $('#reservation').daterangepicker(null, function(start, end, label) {
					 console.log(start.toISOString(), end.toISOString(), label);
					 });
				  });
				</script>
			</span>
			<span >等级：<select name="levels" class="input-back-bor" style="width:80px;">
				<option value="0">-请选择-</option>
				<?php if(is_array($level_count)): $i = 0; $__LIST__ = $level_count;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($lo["id"]); ?>" <?php if(($lo["id"]) == $levels): ?>selected='selected'<?php endif; ?>>LV<?php echo ($lo["grade"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select></span>
			<span class="span-right-space"> <input type="submit" name="do_sumbit" value="搜索" class="change_back"/></span>
			<span class="span-right-space"><i class="lr1">总共：<?php echo ($counts); ?> </i><i class="lr1">总积分<?php echo ($goldcounts); ?>万</i> 总任务积分<?php echo ($taskgolds); ?>万</span>
			<span class="span-right-space"><a href="javascript:;" id="settui" class="change_back a_style">设置推广员  </a></span>
		</div>
	</form>

</div>

<div class="subbox">  
	<div class="bui_content_b">
		<div class="bui-content">
			<table  cellspacing="0" class="table table-bordered">
				<tr class="phb_name phb_back phb_bors atim_tr" style="font-size: 12px;font-weight: 600;">
					<th></th>
					<th>序号</th>
					<th>用户名</th>
					<th>邮箱</th>
					<th>等级</th>
					<th>游币值</th>
					<th>任务游币</th>
					<th>下载所得游币</th>
					<th>激活</th>
					<th>兑换消耗游币</th>
					<th>成长值</th>
					<th>关注微信</th>
					<th>注册时间</th>
					<th>操作</th>
				</tr>
				<?php if(is_array($user_list)): $key = 0; $__LIST__ = $user_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><tr id="hidd<?php echo ($vo["id"]); ?>" class="phb_name <?php if($key%2 == 0): ?>phb_back<?php endif; ?>">
				  <td ><input value="<?php echo ($vo["id"]); ?>" name="ordercheck" data-check-data="order<?php echo ($vo["id"]); ?>" type="checkbox"/></td>
				  <td><?php echo ($vo["cid"]); ?></td>
				  <td><a att="<?php echo ($vo["id"]); ?>" id="usershows" href="javascript:;"><?php echo ($vo["username"]); ?></a></td>
				  <td><?php echo ($vo["email"]); ?></td>
				  <td>LV<?php echo ($vo["level"]); ?></td>
				  <td><?php echo ($vo["goldcount"]); ?></td>
				  <td><?php echo ($vo["taskgold"]); ?></td>
				  <td><?php echo ($vo["glods"]); ?></td>
				  <td>10000</td>
				  <td><?php echo ($vo["expend_coins"]); ?></td>
				  <td><?php echo ($vo["usablegold"]); ?></td>
				  <td><?php if($vo["is_watch"] == 1): ?><span style="color:green">已关注 </span><?php elseif($vo["is_watch"] == 0): ?> 未关注<?php endif; ?></td>
				  <td><?php echo (date('Y-m-d H:i:s',$vo["add_time"])); ?></td>
				  <td><span><a att="<?php echo ($vo["id"]); ?>" id="btnShows" href="javascript:;">修改</a> | <a href="javascript:;" id="onedel" delid="<?php echo ($vo["id"]); ?>" >删除</a> | <a href="<?php echo U('UserCenter/RecordsList?user='.$vo['username']);?>">用户记录</a></span></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</table>
			<div>
			  <ul class="toolbar pull-left">
				<li><label class="checkbox" for="check_box"><input type="checkbox" data-check='uncheck'><a href="javascript:;" >全选</a></label></li>
				<li><p><button class="button" id="alldel" > 批量删除 </button></p></li>
			  </ul>
			  <span class="lm1"> <i class="lr1">当前总积分数：<?php echo ($scores); ?> 万</i> <i class="lr1">当前总任务积分：<?php echo ($general_scores); ?></i>  当前总共：<?php echo ($count); ?></span>
			  <div class="pages_css">
				<?php echo ($Page); ?>
			  </div>
			</div>
		</div>
	</div>
</div> 
	
<div id="userid" style="display:none;">
   <form action="<?php echo U('UserCenter/UserInfo');?>" method="post" id="userform">
    <table cellpadding="0" cellspacing="0">
	<tr>
        <td>昵称:</td>
        <td><?php echo $_SESSION['admin_user']; ?></td>
      </tr>
      <tr>
        <td>用户名：<input type="hidden" name="edit_ids" value="<?php echo ($userinfo["id"]); ?>" id="h_id"></td>
        <td id="username"></td>
      </tr>
       <tr id="headimg" style="display:none;">
        <td>头像：</td>
        <td><img src="" width="60px" height="60px" /></td>
      </tr>
      <tr class="user-input-tr">
        <td>等级：</td>
        <td><input type="text" value="" name="level" id="level" class="input-back-bor"></td>
      </tr>
      <tr class="user-input-tr">
        <td>手机：</td>
        <td><input name="mobilephone" type="text" id="mobilephone"  value="" class="input-back-bor" /></td>
      </tr>
	  
      <tr class="user-input-tr">
        <td>游币数：</td>
        <td><input type="text" id="goldcount" value="" class="input-back-bor" style="width:80px;" readonly /> <?php if($_SESSION['admin_user']=='cici'): ?>添加游币：<input name="goldcount" type="text"  value="" class="input-back-bor" style="width:80px;" /><?php endif; ?></td>
      </tr>
      <?php if($_SESSION['admin_user']=='cici'): ?><tr class="user-input-tr">
	        <td>备注：</td>
	        <td><textarea cols="30" type="text" name="remark" id="remark" rows="5"></textarea></td>
	      </tr><?php endif; ?>
	  <tr class="user-input-tr">
        <td>成长值：</td>
        <td><input type="text" id="usablegold" value="" class="input-back-bor" style="width:80px;" readonly /></td>
      </tr>
	  <tr class="user-input-tr">
        <td>任务值：</td>
        <td id="taskgold"></td>
      </tr>
      <tr class="user-input-tr">
        <td>电子邮件：</td>
        <td><input name="email" type="text" id="email" value="" class="input-back-bor" /></td>
      </tr>
      <tr class="user-input-tr">
        <td>手机分辨率：</td>
        <td id="mobilewidth"></td>
      </tr>
      <tr class="user-input-tr">
        <td>下载软件数量：</td>
        <td id="installcount"></td>
      </tr>
    </table>
	<span id="editsub"></span>
  </form>
</div>
<div id="set_id" style="display:none;">
	<form action="<?php echo U('UserCenter/SetPromoter');?>" method="post" id="setform">
    <table cellpadding="0" cellspacing="0">
      <tr class="user-input-tr">
        <td>邀请好友奖励</td>
        <td><input type="text" name="invite_rewards" value="<?php echo ($find_set["invite_rewards"]); ?>" id="invite_rewards" class="input-back-bor"><input name="id" type="hidden" value="<?php echo ($find_set["id"]); ?>"></td>
      </tr>
       <tr class="user-input-tr">
        <td>下载试玩奖励</td>
        <td><input type="text" name="down_award" value="<?php echo ($find_set["down_award"]); ?>" id="down_award" class="input-back-bor"></td>
      </tr>
      <tr class="user-input-tr">
        <td>一级好友奖励</td>
        <td><input type="text" value="<?php echo ($find_set["one_friend"]); ?>" name="one_friend" id="one_friend" class="input-back-bor"></td>
      </tr>
      <tr class="user-input-tr">
        <td>二级好友奖励：</td>
        <td><input name="two_friend" type="text" id="two_friend"  value="<?php echo ($find_set["two_friend"]); ?>" class="input-back-bor" /></td>
      </tr>
    </table>
  </form>
	

</div>
	
<script src="/Public/Plugin/bui/build/bui-min.js?t=201404241421"></script> 
<script type="text/javascript">
	BUI.use(['bui/overlay','bui/form'],function(Overlay,Form){
		var dialog = new Overlay.Dialog({
			title:'用户操作',
			width:500,
			height:600,
			//配置DOM容器的编号
			contentId:'userid',
			success:function () {
			  $("#userform").submit();
			  this.close();
			}
		  });

		$('tbody tr td #btnShows').on('click',function () {
			var edit_id = $(this).attr("att");
			showdata(edit_id);
			dialog.show();
		});
		
		$('tbody tr td #usershows').on('click',function () {
			var edit_id = $(this).attr("att");
			showdata(edit_id);
			dialog.show();
		});
		
	});

	function showdata(edit_id){
		$.ajax({
			type:'post',
			url:"<?php echo U('UserCenter/UserInfo');?>",
			dataType:'json',
			data:{"edit_id" : edit_id},
			success:function(data){
				if(data){
					$("#username").html(data.username);
					if(data.headimg){
						$("#headimg").css("display","black");
						$("#headimg img").attr(data.headimg);
					}
					$("#level").val("LV"+data.level);
					$("#mobilephone").val(data.mobilephone);
					$("#h_id").val(data.id);
					$("#goldcount").val(data.goldcount);
					$("#remark").html(data.remark);
					$("#email").val(data.email);
					$("#usablegold").val(data.usablegold);
					$("#taskgold").html(data.taskgold);
					$("#mobilewidth").html(data.mobilewidth+"*"+data.mobileheight);
					$("#installcount").html(data.installcount);
				}else{
					alert("操作错误");
				}
			}
		});	
	}
	BUI.use(['bui/overlay','bui/form'],function(Overlay,Form){
		var dialog = new Overlay.Dialog({
			title:'用户操作',
			width:500,
			height:400,
			//配置DOM容器的编号
			contentId:'set_id',
			success:function () {
			  $("#setform").submit();
			  this.close();
			}
		  });
		$('#settui').on('click',function(){
			$(".set_id").css("display","block");
			dialog.show();
		});
		
	});
</script>	

<script src="/Public/youmi/js/WeiZhuan.js" type="text/javascript"></script> 
<script type="text/javascript">
  WeiZhuan.init({'init':'Check,AllDel,OneDel'});

  var AjaxUrl = {
    OrderDel : "<?php echo U('UserCenter/test');?>",
  };

</script>
</body>
</html>