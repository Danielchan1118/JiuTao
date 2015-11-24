<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<meta charset="utf-8">
<title></title>
<form action="<?php echo U('Index/info_edit');?>" enctype="multipart/form-data" method="post" >
    <table cellpadding="0" cellspacing="0">
	<tr>
        <td>昵称:</td>
        <td><input type="text" name="nickname" value="<?php echo ($infos["nickname"]); ?>" id="h_id"/><input type="hidden" name="id" value="<?php echo ($infos["id"]); ?>" /></td>
      </tr>
      <tr>
        <td>用户名：</td>
        <td><input type="text" name="username" value="<?php echo ($infos["username"]); ?>" id="h_id"/></td>
      </tr>
      <tr class="user-input-tr">
        <td>邮箱：</td>
        <td><input type="text" value="" name="email" id="level" class="input-back-bor"/></td>
      </tr>
      <tr class="user-input-tr">
        <td>手机号码：</td>
        <td><input name="number" type="text" id="mobil" value="" class="input-back-bor"/></td>
      </tr>	  
	  <tr class="user-input-tr">
        <td>新密码：</td>
        <td><input name="password" type="password"  value="" class="input-back-bor"/></td>
      </tr>	 
	  <tr class="user-input-tr">
        <td>再次输入新密码：</td>
        <td><input name="password1" type="password"  value="" class="input-back-bor"/></td>
      </tr>	
    </table>
	<input class="ipt-btn" type="submit" name="dosubmit" value="确认修改" />
  </form>
  
  </body>
</html>