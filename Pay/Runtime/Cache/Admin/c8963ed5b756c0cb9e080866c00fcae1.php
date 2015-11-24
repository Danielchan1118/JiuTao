<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>找游网-总后台</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<script src="/Public/jquery/jquery-1.8.3.min.js"></script> 
	<link href='/Public/youmi_admin/style/css/bui_css.css' rel="stylesheet" type="text/css" /> 
	<script src="/Public/Plugin/mta/style/js/highcharts.js"></script>
	<script src="/Public/Plugin/mta/style/js/exporting.js"></script>
</head>
<body style="background:#EDEEF0">
<!-- body title -->
<div class="bodytitle"><div id="h_title">实时数据(<span id="clock"></span>)</div></div>
<div style="background:#EDEEF0;" class="subbox"><!--class="index_bor"-->
	<div class="index_body">
    	<!-- 上面第一部分 start -->
		<div class="index_frist">
       		<div class="index_frist_left">
                <div class="index_downum_top">昨日下载量</div>
                <div class="index_downum_bott">
                  <dl>
                    <dt>下载应用 (含重复下载)</dt>
                    <dd class="index_downum_dow"> <?php echo ($yesdata["nomove"]); ?> </dd>
                  </dl>
                </div>
            </div>

            <div class="index_frist_left">
                <div class="index_downum_top">昨日激活量</div>
                <div class="index_downum_bott">
                  <dl>
                    <dt>安装应用</dt>
                    <dd class="index_downum_dow"> <?php echo ($yesdata["move"]); ?> </dd>
                  </dl>
                </div>
            </div>

            <div class="index_frist_left">
                <div class="index_downum_top">昨日新增用户</div>
                <div class="index_downum_bott">
                  <dl>
                    <dt>新增用户</dt>
                    <dd class="index_downum_dow"><?php echo ($usercount); ?> </dd>
                  </dl>
                </div>
            </div>
			
			<!--<div class="index_frist_left">
                <div class="index_downum_top">昨日商家充值总额</div>
                <div class="index_downum_bott">
                  <dl>
                    <dt>充值总额</dt>
                    <dd class="index_downum_dow"><?php echo ($pay_money["money"]); ?> 元</dd>
                  </dl>
                </div>
            </div>
			
			<div class="index_frist_left" style="margin-right: 0px;">
                <div class="index_downum_top">昨日扣商家总额</div>
                <div class="index_downum_bott">
                  <dl>
                    <dt>扣总额</dt>
                    <dd class="index_downum_dow"><?php echo ($yesdata["money"]); ?> 元</dd>
                  </dl>
                </div>
            </div>-->

        </div>
        <!-- 上面第一部分 end -->
        
        <!-- 中间趋势图部分 start -->
        <div class="index_middel_qu">
        	<div class="index_qushitu_top"> 用户新增统计图 </div>
            <div class="index_qst_bott">
            	<div id="container" style="min-width: 100%; height: 376px; margin: 0 auto"></div>
            </div>
        </div>
        <!-- 中间趋势图部分 end --
        
        <!-- 下面部分 start -->
        <div class="index_middel_qu">
          <div class="index_qushitu_top index-tab-bot"> 应用排行榜 </div>
            <div class="index_qst_bott index_paid">
              <div id="container" >
                  <table cellspacing="0" class="table table-bordered admin-table" width="1155px">
                          <tr class="phb_name phb_back phb_bors atim_tr" >
                            <th>名次</th>
                            <th>软件名</th>
                            <th>安装量</th>
                            <th>下载量</th>
                            <th>运行量</th>
                          </tr>
                  <?php if(is_array($applist)): foreach($applist as $key=>$vo): ?><tr class="phb_name <?php if($key%2 == 0): ?>phb_back<?php endif; ?>" >
                      <td><?php echo $key+1; ?></td>
                      <td> <?php echo ($vo["app_name"]); ?></td>
                      <td> <?php echo ($vo["installcount"]); ?></td>
					  <td> <?php echo ($vo["app_downloadnum"]); ?></td>
                      <td> <?php echo ($vo["app_runnum"]); ?></td>
                    </tr><?php endforeach; endif; ?>
                           
                    </table>

              </div>
            </div>
        </div>

        <!-- 下面部分 start -->
        <div class="index_middel_qu">
          <div class="index_qushitu_top index-tab-bot"> 用户积分排行榜 </div>
            <div class="index_qst_bott index_paid">
              <div id="container">
                  <table cellspacing="0" class="table table-bordered admin-table" width="1155px">
                          <tr class="phb_name phb_back phb_bors atim_tr" >
                            <th>名次</th>
                            <th>用户名(呢称)</th>
                            <th>积分数</th>
                            <th>安装软件数</th>
                            <th>任务赚积分数</th>
                          </tr>
                  <?php if(is_array($userraking)): $key = 0; $__LIST__ = $userraking;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><tr class="phb_name <?php if($key%2 == 0): ?>phb_back<?php endif; ?>" >
                          <td><?php echo ($key); ?></td>
                          <td> <?php echo ($vo["username"]); ?>(<?php echo ($vo["nickname"]); ?>)</td>
                          <td> <?php echo ($vo['goldcount']/10000)."万"; ?></td>
                          <td> <?php echo ($vo["installcount"]); ?></td>
                          <td> <?php echo ($vo['taskgold']/10000)."万"; ?></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                           
                    </table>

              </div>
            </div>
        </div>

            
        <!-- 下面部分 end -->
	</div>
</div>

</div>
<script type="text/javascript">
	var data = {
		titles: "<?php echo ($title_data); ?>",
		downarray: <?php echo ($downarray); ?>,
		categories: <?php echo ($categories); ?>,
		data_titles: "<?php echo ($data_titles); ?> ",
    }
	
	var clock = new Clock();
	clock.display(document.getElementById("clock")); 
	
	//首页时钟
	function Clock() {
		  var date = new Date();
		  this.year = date.getFullYear();
		  this.month = date.getMonth() + 1;
		  this.date = date.getDate();
		  this.day = new Array("星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六")[date.getDay()];
		  this.hour = date.getHours() < 10 ? "0" + date.getHours() : date.getHours();
		  this.minute = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
		  this.second = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();

		  this.toString = function() {
		  return  this.hour + ":" + this.minute + ":" + this.second + " " + this.day; 
		  };

		  this.toSimpleDate = function() {
		  return this.year + "-" + this.month + "-" + this.date;
		  };

		  this.toDetailDate = function() {
		  return this.year + "-" + this.month + "-" + this.date + " " + this.hour + ":" + this.minute + ":" + this.second;
		  };

		  this.display = function(ele) {
		  var clock = new Clock();
		  ele.innerHTML = clock.toString();
		  window.setTimeout(function() {clock.display(ele);}, 1000);
		};
		
	}
</script>
<script type="text/javascript" src="/Public/youmi/js/js/DataCountNum.js"></script>
<body>
</html>