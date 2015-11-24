<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="/Public/jquery/jquery-1.8.3.min.js"></script> 
<link href='/Public/youmi_admin/style/css/bui_css.css' rel="stylesheet" type="text/css" /> 

<title>等级设置</title>
</head>
<body> 
<div class="bodytitle">
	<div id="h_title">等级设置</div>
    <div style="margin-left: 20px;"><a href="javascript:;" id="btnShow" class="change_back" >添加等级  </a></div>
</div>

<div class="subbox">  
<div class="bui_content_b">
  <div class="bui-content">
      <table cellspacing="0" class="table table-bordered" width="1130px">
        <thead>
          <tr class="phb_name phb_back phb_bors atim_tr">
                <th>序号</th>
                <th>添加时间</th>
                <th>积分</th>
                <th>用户等级</th>
				<th>获取游币</th>
                <th>操作</th>
          </tr>
        </thead>
          <tbody>
           <?php if(is_array($grade_list)): $key = 0; $__LIST__ = $grade_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($key % 2 );++$key;?><tr align="center" id="hidd<?php echo ($v["id"]); ?>" class="phb_name <?php if($key%2 == 0): ?>phb_back<?php endif; ?>">
                <td><?php echo ($key); ?></td>
                <td><?php echo (date('Y-m-d H:i:s',$v["add_time"])); ?></td>
                <td><?php echo ($v['integral']/10000)."万"; ?></td>
                <td>Lv<?php echo ($v["grade"]); ?></td>
				<td><?php echo ($v['getglod']/10000)."万"; ?></td>
                <td><span> <a href="javascript:;" id="onedel" delid="<?php echo ($v["id"]); ?>">删除 | </a><a href="javascript:;" id="btnShows" att="<?php echo ($v["id"]); ?>" >修改</a></span></td>
               </tr><?php endforeach; endif; else: echo "" ;endif; ?>     
          </tbody>
      </table>

        <div class="pages_css"> <?php echo ($Page); ?>  </div>
    </div>
  </div>
</div>

<div id="levelid" style="display:none;">
	<form action="<?php echo U('UserCenter/GradeEdit');?>" method="post" id="from_id">
		<table cellspacing="0" class="table table-bordered table-tr">
			<tr><td>积分：</td>
				<td><input type="text" name="integral" value="" id="integral" class="input-back-bor"/></td>
			</tr>
			<tr><td>等级：</td><td><input type="text" name="grade" value="" id="grade" class="input-back-bor"/></td></tr>
			<tr><td>获取游币：</td><td><input type="text" name="getglod" value="" id="getglod" class="input-back-bor"/></td></tr>
			<input type="hidden" name="editid" id="edit_id" value=""/>
		</table>
	</form>
</div>

<script src="/Public/Plugin/bui/build/bui-min.js?t=201404241421"></script> 
<script src="/Public/youmi/js/WeiZhuan.js" type="text/javascript"></script>
<script type="text/javascript">
	BUI.use(['bui/overlay','bui/form'],function(Overlay,Form){
		var dialog = new Overlay.Dialog({
			title:'等级设置',
			width:500,
			height:320,
			//配置DOM容器的编号
			contentId:'levelid',
			success:function () {
			  $("#from_id").submit();
			  this.close();
			}
		  });
		$('#btnShow').on('click',function () {
			$("#integral").val("");
			$("#grade").val("");
			$("#getglod").val("");
			$("#edit_id").val("");
			dialog.show();
		});

		$('tbody tr td #btnShows').on('click',function () {
			var edit_id = $(this).attr("att");
			$.ajax({
				type:'post',
				url:"<?php echo U('UserCenter/GradeEdit');?>",
				dataType:'json',
				data:{"edit_id" : edit_id},
				success:function(data){
					if(data){
						$("#integral").val(data.integral);
						$("#grade").val(data.grade);
						$("#getglod").val(data.getglod);
						$("#edit_id").val(edit_id);
					}else{
						alert("操作错误");
					}
				}
			});	
		  dialog.show();
		});
		
	});

	 WeiZhuan.init({'init':'OneDel'});

  	var AjaxUrl = {
    	OrderDel : "<?php echo U('UserCenter/GradeSet');?>",
  	};

	$("#from_id").submit(function(){
  		var integral = $("#integral").val();
  		var grade = $("#grade").val();
  		if(integral.length ==0 || grade.length ==0){
  			alert('操作失败，数据不能为空！');
  			return false;
  		}

  	});
	

</script>

</body>
</html>