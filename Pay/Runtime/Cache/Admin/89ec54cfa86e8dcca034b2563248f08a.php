<?php if (!defined('THINK_PATH')) exit();?><?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC " -//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1.0; maximum-scale=2.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<title>后台管理登录</title>
<link type="image/x-icon" rel="shortcut icon" href="/favicon.ico" />
<link type="text/css" rel="stylesheet" href="/Public/Admin/statics/css/style.css" />

	<link rel='stylesheet' href='/Public/Admin/statics/admin/css/admin.css' />
	<link rel='stylesheet' type='text/css' href='/Public/Admin/statics/admin/css/default.css' />
	<script type='text/javascript' src='/Public/Admin/statics/admin/js/common.js'></script>
	<script type='text/javascript' charset='UTF-8' src='/Public/Admin/statics/admin/js/jquery-1.9.0.min.js'></script>
	<script type='text/javascript' charset='UTF-8' src='/Public/Admin/statics/admin/js/jquery-migrate-1.2.1.min.js'></script>
	<script type='text/javascript' charset='UTF-8' src='/Public/Admin/statics/admin/js/artDialog.js'></script>
	<script type='text/javascript' charset='UTF-8' src='/Public/Admin/statics/admin/js/iframeTools.js'></script>
</head>
<body>


<div id="login" class="container">
  <div id="header">
    <div class="logo"> <a href="#"><img src="/Public/Admin/statics/admin/images/xspIcon.gif" width="303" height="43" /></a> </div>
  </div>
  <div id="wrapper" class="clearfix">
    <div class="login_box">
      <div class="login_title">后台管理登录</div>
      <div class="login_cont">
        <form action="<?php echo U('index/managerLogin');?>" method="post" enctype="multipart/form-data">
          <table class="form_table">
            <col width="90px" />
            <col />
            <tr>
              <th valign="middle">用户名：</th>
              <td><input class="normal" type="text" name="username" alt="请填写用户名" /></td>
            </tr>
            <tr>
              <th valign="middle">密码：</th>
              <td><input class="normal" type="password" name="password" alt="请填写密码" /></td>
            </tr>
            <tr>
              <th valign="middle"></th>
              <td><input class="submit" type="submit" name="dosubmit" value="登录" />
                <input class="submit" type="reset" value="取消" /></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>
  <div id="footer">Copyright © 2014 Shenzhen W.Y.R Technology Co., Ltd
		深圳微游人科技有限公司&nbsp;版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;粤ICP备14029663号-3 
		网络文化经营许可证：粤网文[2014]0603-203号&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;增值电信业务经营许可:粤B2-20140348</div>
</div>


</body>
</html>