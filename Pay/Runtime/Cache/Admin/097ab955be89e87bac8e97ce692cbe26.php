<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>权限设置</title>
<link href='/Public/youmi_admin/style/css/css.css' rel="stylesheet" type="text/css" />
<script src="/Public/jquery/jquery-1.8.3.min.js"></script> 
<link href='/Public/youmi_admin/style/css/bui_css.css' rel="stylesheet" type="text/css" /> 
<style type="text/css">
.btn { background: white; padding: 0px 12px 0 12px; height: 20px; line-height: 20px; }
</style>
</head>
<body>
  <!-- body title -->
<div class="bui_head_bor">
  <div class="bui_head_t">
    <div class="bodytitle"><div id="h_title">&nbsp;&nbsp;权限设置</div>
    </div>
</div>
<form action="<?php echo U('/Admin/Menus/rolePriv?id='.$role_id);?>" method="post">
<div class="subbox">  
  <div class="bui_content_b">
    <div class="bui-content">
      <table cellspacing="0" class="table table-bordered role-td" width="1130" >
        <?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><tr class="phb_back"  style="text-align:left;">
              <td><input type="checkbox" name="menu_id[]" value="<?php echo ($vo["id"]); ?>" level="0" <?php if(($vo["flag"]) == "1"): ?>checked<?php endif; ?> onclick="javascript:checknode(this);" /></td>
              <td><?php echo ($vo["name"]); ?><font color="blue">&nbsp;(<?php echo ($vo["action"]); ?>)</font>
                  <?php switch($vo["is_show"]): case "0": ?><font style="color:rgb(0,0,255);">[显示]</font><?php break;?>
                    <?php case "1": ?><font style="color:red;">[隐藏]</font><?php break; endswitch;?>
              </td>           
            </tr>

              <?php if(is_array($vo["listSon"])): $i = 0; $__LIST__ = $vo["listSon"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr class="phb_name" style="text-align:left;">
                <td><input type="checkbox" name="menu_id[]" value="<?php echo ($vol["id"]); ?>" level="1" <?php if(($vol["flag"]) == "1"): ?>checked<?php endif; ?> onclick="javascript:checknode(this);" /></td>
                <td class="menus_td" style="padding-left: 20px;">  &nbsp;|_<?php echo ($vol["name"]); ?><font color="blue">&nbsp;(<?php echo ($vol["action"]); ?>)</font>
                      <?php switch($vol["is_show"]): case "0": ?><font style="color:rgb(0,0,255);">[显示]</font><?php break;?>
                        <?php case "1": ?><font style="color:red;">[隐藏]</font><?php break; endswitch;?>
                </td>    
              </tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
      </table>
      <div class=""><input class="button" name="dosubmit" id="dosubmit" value="提交" type="submit"></div>
    </div>
  </div>
</div>
</body>
<script type="text/javascript">
function checknode(obj){
  var chk = $("input[type='checkbox']");
  var count = chk.length;
  var num = chk.index(obj);
  var level_top = level_bottom =  chk.eq(num).attr('level')
//根据子节点找到父节点并选中
  for (var i=num; i>=0; i--){
    var le = chk.eq(i).attr('level');

    if(eval(le) < eval(level_top)){
      chk.eq(i).attr("checked",'checked');
      var level_top = level_top-1;
    }

  }
//找到当前节点的所有子节点，并勾选/不勾选
  for (var j=num+1; j<count; j++){
    var le = chk.eq(j).attr('level');

    if(eval(le) > eval(level_bottom))
      chk.eq(j).attr(
          "checked",
          chk.eq(num).attr("checked")=="checked"?"checked":false
      );
    else if(eval(le) <= eval(level_bottom)) 
      break;
  }

} 
</script>
</html>