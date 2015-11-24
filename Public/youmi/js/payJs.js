
function selorder() {
	$("input#payohterje").attr('checked', true);
		}
	var pintaib = $("#game_payto").val();
	var pay_rat = $("#pay_rate").val();
	var pintaibhz="元宝"
	function ylsu(o){
		 o.value=o.value.replace(/[^\d]/g,'');
		 var pay_rat = $("#pay_rate").val();
		 var pintaib = $("#game_payto").val();
		var moneysr=$("#othermoney").val();
		if(moneysr<5 || moneysr>50000 ){
			$("#ylsuname").html("<font id=\"jeerro\">充值金额请限制在5元到50000元之间</font>")
			}else{
				if(1==$('input:radio[name="game_type"]:checked').val()){
					$("#ylsuname").html("您将获得：<font id=\"dyyl\">"+parseInt(moneysr*(pay_rat/100))+"</font>"+pintaibhz)
				}else{
					$("#ylsuname").html("您将获得：<font id=\"dyyl\">"+parseInt(pintaib*moneysr*(pay_rat/100))+"</font>"+pintaibhz)
				}
			}
		}
	function ptcyxylsu(o){
		 o.value=o.value.replace(/[^\d]/g,'');
		var moneysr=$("#othermoney").val()
		var pay_rat = $("#pay_rate").val();
		var pintaib = $("#game_payto").val();
		
		if(moneysr<1 || moneysr>50000 ){
			$("#ylsuname").html("<font id=\"jeerro\">充值金额请限制在1元到50000元之间</font>")
			}else{
				$("#ylsuname").html("您将获得：<font id=\"dyyl\">"+parseInt(pintaib*moneysr*(pay_rat/100))+"</font>"+pintaibhz)
				}
		}
	function ylsu2(ob){
			var pay_rat = $("#pay_rate").val();
			var pintaib = $("#game_payto").val();
			$("#ylsuname").html("您将获得：<font id=\"dyyl\">"+parseInt(pintaib*ob*pay_rat/100)+"</font>"+pintaibhz)
			$("#othermoney").val("")
		
		
	}
	function ylsu0(ob){//rmb->ptb
		if(1==$('input:radio[name="game_type"]:checked').val()){
			var pay_rat = $("#pay_rate").val();
			var pintaib = $("#game_payto").val();
			$("#ylsuname").html("您将获得：<font id=\"dyyl\">"+parseInt(ob*pay_rat/100)+"</font>"+pintaibhz)
			$("#othermoney").val("")
		}else{
			ylsu2(ob);
		}
	}
		
	function wyje_set(){
		  var wycz=new Array("10","30","50","100","200","300","500","1000","5000")
		  var czcon=""
			var czother="<em class=\"otherje\"><label><b><input type=\"radio\"  name=\"pay_amount\"  id=\"payohterje\" value=\"\"/>其他</label></b><span><input id=\"othermoney\" type=\"text\" onkeyup=\"ylsu(this)\" name=\"oth_amount\" onfocus=\"selorder();\"  class=\"jeother\"/></span><i>请输入(5-50000)之间的整数</i></em>"
			for(i=1;i<=wycz.length;i++){
			  var wyczje="<em><label><input type=\"radio\" onclick=\"ylsu2("+wycz[i-1]+")\" name=\"pay_amount\" id=\"payje1\" value=\""+wycz[i-1]+"\"/>"+wycz[i-1]+"元</label></em>"
			  if(wycz[i-1]=="100"){
				  wyczje="<em><label><input type=\"radio\" onclick=\"ylsu2("+wycz[i-1]+")\" checked=\"checked\" name=\"pay_amount\" id=\"payje1\" value=\""+wycz[i-1]+"\"/>"+wycz[i-1]+"元</label></em>"
				  }
			  czcon+=wyczje
			  } 
		  
		   
		   $("#je_set").html(czcon+czother);
		}
	function szxje_set(){
		  var czkcz=new Array("10","20","30","50","100","300","500")
		  if(1==$('input:radio[name="game_type"]:checked').val()){
			var czcon="<input id=\"othermoney\" type=\"text\" onkeyup=\"ylsu(this)\" name=\"oth_amount\" onfocus=\"selorder();\" style=\"display:none;\" class=\"jeother\"/>"
			for(i=1;i<=czkcz.length;i++){
			  var wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu0("+czkcz[i-1]+")\"  name=\"pay_amount\" id=\"payje1\" value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
			  if(czkcz[i-1]=="100"){
				  wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu0("+czkcz[i-1]+")\" checked=\"checked\" name=\"pay_amount\" id=\"payje1\" value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
			  }
			  czcon+=wyczje
			  }
		  }else{
			var czcon="<input id=\"othermoney\" type=\"text\" onkeyup=\"ylsu(this)\" name=\"oth_amount\" onfocus=\"selorder();\" style=\"display:none;\" class=\"jeother\"/>"
		  for(i=1;i<=czkcz.length;i++){
			  var wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu2("+czkcz[i-1]+")\"  name=\"pay_amount\" id=\"payje1\" value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
			  if(czkcz[i-1]=="100"){
				  wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu2("+czkcz[i-1]+")\" checked=\"checked\" name=\"pay_amount\" id=\"payje1\" value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
				  }
			  czcon+=wyczje
			  }
		  }
		    
			  
		   $("#je_set").html(czcon);
		}
	function jwje_set(){
		  var czkcz=new Array("20","30","50","100","300","500")
		  if(1==$('input:radio[name="game_type"]:checked').val()){
			var czcon="<input id=\"othermoney\" type=\"text\" onkeyup=\"ylsu(this)\" name=\"oth_amount\" onfocus=\"selorder();\" style=\"display:none;\" class=\"jeother\"/>"
		  for(i=1;i<=czkcz.length;i++){
			  var wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu0("+czkcz[i-1]+")\" name=\"pay_amount\" id=\"payje1\" value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
			  if(czkcz[i-1]=="100"){
				  wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu0("+czkcz[i-1]+")\" checked=\"checked\" name=\"pay_amount\" id=\"payje1\" value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
				  }
			  czcon+=wyczje
			  } 
		  }else{
			var czcon="<input id=\"othermoney\" type=\"text\" onkeyup=\"ylsu(this)\" name=\"oth_amount\" onfocus=\"selorder();\" style=\"display:none;\" class=\"jeother\"/>"
		  for(i=1;i<=czkcz.length;i++){
			  var wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu2("+czkcz[i-1]+")\" name=\"pay_amount\" id=\"payje1\" value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
			  if(czkcz[i-1]=="100"){
				  wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu2("+czkcz[i-1]+")\" checked=\"checked\" name=\"pay_amount\" id=\"payje1\" value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
				  }
			  czcon+=wyczje
			  } 
		  }
		   
		   $("#je_set").html(czcon);
		}
	function ltje_set(){
		  var czkcz=new Array("5","10","15","25","30","35","40","45","50","100","300","350","1000")
		  if(1==$('input:radio[name="game_type"]:checked').val()){
			 var czcon="<input id=\"othermoney\" type=\"text\" onkeyup=\"ylsu(this)\" name=\"oth_amount\" onfocus=\"selorder();\" style=\"display:none;\" class=\"jeother\"/>"
		  for(i=1;i<=czkcz.length;i++){
			  var wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu0("+czkcz[i-1]+")\" name=\"pay_amount\" id=\"payje1\" value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
			  if(czkcz[i-1]=="100"){
				  wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu0("+czkcz[i-1]+")\" checked=\"checked\" name=\"pay_amount\" id=\"payje1\" value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
				  }
			  czcon+=wyczje
			  } 
		  }else{
			 var czcon="<input id=\"othermoney\" type=\"text\" onkeyup=\"ylsu(this)\" name=\"oth_amount\" onfocus=\"selorder();\" style=\"display:none;\" class=\"jeother\"/>"
		  for(i=1;i<=czkcz.length;i++){
			  var wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu2("+czkcz[i-1]+")\" name=\"pay_amount\" id=\"payje1\" value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
			  if(czkcz[i-1]=="100"){
				  wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu2("+czkcz[i-1]+")\" checked=\"checked\" name=\"pay_amount\" id=\"payje1\" value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
				  }
			  czcon+=wyczje
			  } 
		  }
		  
		   $("#je_set").html(czcon);
		}
	  function sdje_set(){
		var czkcz=new Array("5","10","15","18","20","25","30","35","50","60","68","100","300","468","500")
		if(1==$('input:radio[name="game_type"]:checked').val()){
			var czcon="<input id=\"othermoney\" type=\"text\" onkeyup=\"ylsu(this)\" name=\"oth_amount\" onfocus=\"selorder();\" style=\"display:none;\" class=\"jeother\"/>"
		for(i=1;i<=czkcz.length;i++){
			var wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu0("+czkcz[i-1]+")\" name=\"pay_amount\" id=\"payje1\" value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
			if(czkcz[i-1]=="100"){
				wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu0("+czkcz[i-1]+")\" checked=\"checked\" name=\"pay_amount\" id=\"payje1\"  value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
				}
			czcon+=wyczje
			} 
		}else{
			var czcon="<input id=\"othermoney\" type=\"text\" onkeyup=\"ylsu(this)\" name=\"oth_amount\" onfocus=\"selorder();\" style=\"display:none;\" class=\"jeother\"/>"
		for(i=1;i<=czkcz.length;i++){
			var wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu2("+czkcz[i-1]+")\" name=\"pay_amount\" id=\"payje1\" value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
			if(czkcz[i-1]=="100"){
				wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu2("+czkcz[i-1]+")\" checked=\"checked\" name=\"pay_amount\" id=\"payje1\"  value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
				}
			czcon+=wyczje
			} 
		}
		 
		 $("#je_set").html(czcon);
	  }
	  function wmje_set(){
		var czkcz=new Array("5","10","15","20","30","50","100")
		if(1==$('input:radio[name="game_type"]:checked').val()){
			var czcon="<input id=\"othermoney\" type=\"text\" onkeyup=\"ylsu(this)\" name=\"oth_amount\" onfocus=\"selorder();\" style=\"display:none;\" class=\"jeother\"/>"
		for(i=1;i<=czkcz.length;i++){
			var wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu0("+czkcz[i-1]+")\" name=\"pay_amount\" id=\"payje1\"  value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
			if(czkcz[i-1]=="100"){
				wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu0("+czkcz[i-1]+")\" checked=\"checked\" name=\"pay_amount\" id=\"payje1\"  value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
				}
			czcon+=wyczje
			} 
		}else{
			var czcon="<input id=\"othermoney\" type=\"text\" onkeyup=\"ylsu(this)\" name=\"oth_amount\" onfocus=\"selorder();\" style=\"display:none;\" class=\"jeother\"/>"
		for(i=1;i<=czkcz.length;i++){
			var wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu2("+czkcz[i-1]+")\" name=\"pay_amount\" id=\"payje1\"  value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
			if(czkcz[i-1]=="100"){
				wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu2("+czkcz[i-1]+")\" checked=\"checked\" name=\"pay_amount\" id=\"payje1\"  value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
				}
			czcon+=wyczje
			} 
		}
		 
		 $("#je_set").html(czcon);
	  }
	  function shje_set(){
		var czkcz=new Array("5","10","15","30","40","100")
		if(1==$('input:radio[name="game_type"]:checked').val()){
			var czcon="<input id=\"othermoney\" type=\"text\" onkeyup=\"ylsu(this)\" name=\"oth_amount\" onfocus=\"selorder();\" style=\"display:none;\" class=\"jeother\"/>"
		for(i=1;i<=czkcz.length;i++){
			var wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu0("+czkcz[i-1]+")\" name=\"pay_amount\" id=\"payje1\"  value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
			if(czkcz[i-1]=="100"){
				wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu0("+czkcz[i-1]+")\" checked=\"checked\" name=\"pay_amount\" id=\"payje1\" value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
				}
			czcon+=wyczje
			} 
		}else{
			var czcon="<input id=\"othermoney\" type=\"text\" onkeyup=\"ylsu(this)\" name=\"oth_amount\" onfocus=\"selorder();\" style=\"display:none;\" class=\"jeother\"/>"
		for(i=1;i<=czkcz.length;i++){
			var wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu2("+czkcz[i-1]+")\" name=\"pay_amount\" id=\"payje1\"  value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
			if(czkcz[i-1]=="100"){
				wyczje="<em class=\"cz170\"><label><input type=\"radio\" onclick=\"ylsu2("+czkcz[i-1]+")\" checked=\"checked\" name=\"pay_amount\" id=\"payje1\" value=\""+czkcz[i-1]+"\"/>"+czkcz[i-1]+"元面值的充值卡</label></em>"
				}
			czcon+=wyczje
			} 
		}
		 
		 $("#je_set").html(czcon);
	  }
	  
	   function ptcgame(){
		var czother="<em class=\"otherje\"><label><b><input type=\"radio\"  name=\"pay_amount\"  id=\"payohterje\" value=\"\"/>其他</label></b><span><input id=\"othermoney\" type=\"text\" onkeyup=\"ylsu(this)\" name=\"oth_amount\" onfocus=\"selorder();\"  class=\"jeother\"/></span><i>请输入(5-50000)之间的整数</i></em>"
		  $("#je_set").html(czother);
	  }
	  
	  function ptbcyx_set(){
		  var czother2="<em class=\"otherje\"><span><input id=\"othermoney\" type=\"text\" onkeyup=\"ptcyxylsu(this)\" name=\"oth_amount\" onfocus=\"selorder();\"  class=\"jeother\"/></span><i>请输入(1-50000)之间的整数</i></em>"
		   $("#je_set").html(czother2);
	  }
	  
	  function ptczsetpaynot(){
		$("#youid").hide();
		$("#youpintb").hide();
		$("#czwhere").show();
		$("#czzh1").show();
		$("#czzh2").show();
		}
		
		function paypalCon(){
			
			}
		function paypalSet(){
			$(".neiye_pay_left_infor_c_1").hide();
			$("#bank").hide();
			$("#tjanniu").hide();
			$("#paypalcz").show();
			}
		function nopaypalSet(){
			$(".neiye_pay_left_infor_c_1").show();
			$("#bank").show();
			$("#tjanniu").show();
			$("#paypalcz").hide();
			}
		

	function on_pay_type_change(obj,pay_type, pay_rate,pay_type_name,pay_type_desc,pay_help,pay_type_id){	
		if(pay_type == "yeepay"){
			nopaypalSet();
			$("#bank").show();
			wyje_set();
			ptczsetpaynot();
			wy_ts();
			ptcyxpd=0;
			$("#rengong").css("display","none");
			$("#paoqi").css("display","block");
			$("#pay_name").val(pay_type_name);
			$("#pay_tag").val(pay_type);
			}
		if(pay_type == "alipay"){
			nopaypalSet();
			$("#bank").hide();
			wyje_set();
			ptczsetpaynot();
			zfb_ts();
			ptcyxpd=0;
			$("#rengong").css("display","none");
			$("#paoqi").css("display","block");
			$("#pay_name").val(pay_type_name);
			$("#pay_tag").val(pay_type);
			}
		if(pay_type == "yeepay_szx"){
			nopaypalSet();
			$("#bank").hide();
			szxje_set();
			ptczsetpaynot();
			szx_ts();
			ptcyxpd=0;
			$("#rengong").css("display","none");
			$("#paoqi").css("display","block");
			$("#pay_name").val(pay_type_id);
			}
		if(pay_type == "unicom"){
			nopaypalSet();
			$("#bank").hide();
			jwje_set();
			ptczsetpaynot();
			liant_ts();
			ptcyxpd=0;
			$("#rengong").css("display","none");
			$("#paoqi").css("display","block");
			$("#pay_name").val(pay_type_id);
			}
		if(pay_type == "telecom"){
			nopaypalSet();
			$("#bank").hide();
			jwje_set();
			ptczsetpaynot();
			liant_ts();
			ptcyxpd=0;
			$("#rengong").css("display","none");
			$("#paoqi").css("display","block");
			$("#pay_name").val(pay_type_id);
			}
		if(pay_type == "sndacard"){
			nopaypalSet();
			$("#bank").hide();
			ltje_set();
			ptczsetpaynot();
			shengd_ts();
			ptcyxpd=0;
			$("#rengong").css("display","none");
			$("#paoqi").css("display","block");
			$("#pay_name").val(pay_type_id);
			}
		if(pay_type == "yeepay_zhengtu"){
			nopaypalSet();
			$("#bank").hide();
			sdje_set();
			ptczsetpaynot();
			zhent_ts();
			ptcyxpd=0;
			$("#rengong").css("display","none");
			$("#paoqi").css("display","block");
			$("#pay_name").val(pay_type_id);
			}
		if(pay_type == "JUNNET"){
			nopaypalSet();
			$("#bank").hide();
			wmje_set();
			ptczsetpaynot();
			junw_ts();
			ptcyxpd=0;
			$("#rengong").css("display","none");
			$("#paoqi").css("display","block");
			$("#pay_name").val(pay_type_id);
			}
		if(pay_type == "yeepay_jiuyou_net"){
			nopaypalSet();
			$("#bank").hide();
			shje_set();
			ptczsetpaynot();
			ptcyxpd=0;
			$("#rengong").css("display","none");
			$("#paoqi").css("display","block");
			$("#pay_name").val(pay_type_id);
			}
		if(pay_type == "yeepay_wanmei_net"){
			nopaypalSet();
			$("#bank").hide();
			wmje_set();
			ptczsetpaynot();
			wanm_ts();
			ptcyxpd=0;
			$("#rengong").css("display","none");
			$("#paoqi").css("display","block");
			$("#pay_name").val(pay_type_id);
			}
		if(pay_type == "offline"){
			nopaypalSet();
			var aumt=$(".jeother").val()!=""?$(".jeother").val():$('input:radio[name="pay_amount"]:checked').val();
			$("#bank").hide();
			ptczsetpay();
			pintaib=10;
			pintaibhz="元宝";
			ptb_ts();
			ylsu2(0);
			ptcyxpd=1;
			$("#rengong").css("display","none");
			$("#paoqi").css("display","block");
			$("#pay_name").val(pay_type_id);
			}
		if(pay_type == "yeepay_paypal"){
			paypalSet();
			paypal_ts();
			$("#rengong").css("display","none");
			$("#paoqi").css("display","block");
			$("#pay_name").val(pay_type_id);
		}
		if(pay_type == "rengong"){
			$(".neiye_pay_left_infor_c_1").hide();
			$("#bank").hide();
			$("#tjanniu").hide();
			$("#wxts").hide();
			$("#rengong").css("display","block");
			$("#paoqi").css("display","none");
			$("#pay_name").val(pay_type_id);
		}
		if(pay_type=='account'){
			window.location.href='exchange.html?gid=0&sid=0';
			$("#pay_name").val(pay_type_id);
		}
		$(".paytype").removeClass('curent');
		$(obj).addClass('curent');
		
		$("#pay_type").val(pay_type);
		$("#pay_rate").val(pay_rate);
		$("#pay_type_name").html(pay_type_name);
		
		
		$("#pay_type_content").html(pay_type_desc);
		
		$("#payhelp1").html('<a href=\"'+pay_help+'\"  target=\"_blank\">充值教程</a>');
		
		var othermoneyval=$(".jeother").val()!=""?$(".jeother").val():$('input:radio[name="pay_amount"]:checked').val();

		if(1==$('input:radio[name="game_type"]:checked').val()){
			ylsu0(othermoneyval);
		}else{
			ylsu2(othermoneyval);
		}
		
		on_rate_change();
	}
	
	
	
	function on_amount_change(obj){
		if(obj.value == '0'){
			$('#other_amount').show();
		}else{
			$('#other_amount').hide();
		}
		on_rate_change();
	}
	
	function on_oth_amount_blur(obj){
		if(parseInt(obj.value) < 5 ){
			alert("充值金额必须大于5");
			obj.value = 5;
		}
		
		var v = parseInt(obj.value);

		obj.value = ( isNaN(v) ? 0 : v );
		on_rate_change();
	}
	
	function on_rate_change(){
		var money = $('#pay_amount').val();
		if(money=='0'){
			money = parseInt($('#oth_amount').val());
		}
		var cur = Math.floor( money * parseFloat($('#pay_rate').val()) );
		var game_cur = Math.floor(cur * parseFloat($('#game_rate').val()));
		$('#pay_amount_show').html(game_cur);
		$('#parcen').html(parseFloat($('#pay_rate').val()) * parseFloat($('#game_rate').val()) );
		$('#parcen_top').html($('#parcen').html());

		$('#pay_point_show').html( Math.floor(cur * 1) );
		var addition = Math.floor(cur * (parseFloat($('#level_rate').val()) / 100)  );
		
		$('#addition_money').html(addition);
	}
	
	$(document.body).ready(function(){
			//var opt = $('#opt_yeepay');
			var isUserSate=false;
			on_pay_type_change($('#opt_alipay'),'alipay', '100','支付宝' , '只要您开通网上银行服务，足不出户即可实现快捷准确的帐号充值。请勿在此通道中使用其他方式充值。','/index.php?m=content&c=index&a=show&catid=28&id=22');
			//$('#game_id').val('49');
			//showServer('49');
			$("#opt_alipay").click();			   
		   	//账号
			zh_select('platform2');	  
			 
	});

	/**
	 * 手游选择
	 */
	function mobilefocusserver(name,val,payto){
		$("#mobilegame_id").val(val);
		$("#game_payto").val(payto);
	    $("#mobilegameSet a").html(name);
		$("#msg_for_mobilegame").hide();
	    $("#cz_select_mobilegame").hide();
		if(name == '亡灵传说'){
			$("#mobile_ptb").css("display","block");
			$("#zh_youxibi").css("display","none");
		}else{
			$("#zh_youxibi").css("display","block");
			$("#mobile_ptb").css("display","none");
		}
	}

	function focusserver(name,val,payto){
		$("#game_id").val(val);
		$("#game_payto").val(payto);
	    $("#gameSet a").html(name);
		$("#msg_for_game").hide();
	    $("#cz_select_game").hide();
		$("#zh_youxibi").css("display","block");
		$("#mobile_ptb").css("display","none");

		if(lmcount!=5){
			i=1;
			var html='';
			while(i<=lmcount)
			{		
				if(lm[i][2]==val)
				{
					html+="<li class=\"fwqxz\" onclick=\"getserver('"+lm[i][1]+"','"+lm[i][0]+"')\">"+lm[i][1]+"</li>";
				}
				i++;
			} 
			$(".cz_sega_boxa").html("<ul id=\"server_id\" class=\"all_servers\">"+html+"</ul><div style=\"clear:both\"></div>");
			
			$("#cz_select_server").show();
			
			var othermoneyval=$(".jeother").val()!=""?$(".jeother").val():$('input:radio[name="pay_amount"]:checked').val();
				ylsu2(othermoneyval); 
		} 
	}
	
	function on_member_name_change(){
		if($('#member_name').html() != '' ){
			$('#msg_member_name').html('充值所得积分将会累计到您所填写的充值账号上');
		}
	}
	/*
 	function hide_select(pay_platform) {
		var aumt=$(".jeother").val()!=""?$(".jeother").val():$('input:radio[name="pay_amount"]:checked').val();
		if(pay_platform == 'platform'){
			document.getElementById('div_game').style.display = 'block';
			pintaibhz="平台币";
			ylsu0(aumt);
		} else {
			document.getElementById('div_game').style.display = 'block';
			pintaibhz="元宝";
			ylsu2(aumt);
			if($('#game_paytorole').val()==1){
				get_role();
				$('#li_game_rname').show();
			}else{
				$('#li_game_rname').hide();
			}
		}
	}
	*/
	function zh_select(zhselect_dq){
		if(zhselect_dq == 'platform1'){
			$("#cz_zh").html("您需要充值的帐号:")
			$("#qrcz_zh").html("确认您充值的帐号:")
		}else if(zhselect_dq == 'platform2'){
			$("#cz_zh").html("您需要充值的帐号:")
			$("#qrcz_zh").html("确认您充值的帐号:")
		}
	}
	function selectbank(bankcode) {
	$("input[value='"+bankcode+"']").attr('checked', true);
	}
/*手游选择游戏*/
function open_all_mobilegame_data(){
    $("#cz_select_mobilegame").css('display','block');
}
/*关闭手游*/
function close_all_mobilegame_data1(){
    $("#cz_select_mobilegame").css('display','none');
}	
/*选择游戏*/
function open_all_game_data1(){
    $("#cz_select_game").css('display','block');
	$("#cz_select_server").css('display','none');
}
function close_all_game_data1(){
    $("#cz_select_game").css('display','none');
	$("#cz_select_server").css('display','none');
}

function close_all_sever_data2(){
    $("#cz_select_server").css('display','none');
	if($("#qfSet a").html()=="选择区服"){
		$("#msg_for_game").show();
		$("#msg_for_game").html("服务器不能为空!");
	}
	
}
function open_all_sever_data2(){
		if($("#gameSet a").html()=="选择游戏"){
				$("#msg_for_game").html("充入游戏不能为空!");
			}else{
					$("#cz_select_server").show();
				}
	}

function getserver(name,val){
	$("#server_id").val(val);
    $("#qfSet a").html(name);
	$("#qfSet1 a").html(name);
    $("#cz_select_game").hide();
	$("#cz_select_server").hide();
	$("#msg_for_game").hide();

}

/*充值弹窗 star*/
var ptcyxpd=0

function clearts(){
	$("#zhts1").html("")
	$("#zhts2").html("")
	}
function zhyits(){
	var srzh=$("#member_name").val();
	var resrzh=$("#re_member_name").val();
	if(resrzh!=srzh){
		$("#zhts2").html("两次输入不一致")
		return false;
		}else{
			$("#zhts2").html("");
			return true;
			}
	}
function tjqrboxclose(){
	$("#czinfobg").remove();
	$("#czinfobox").remove();
	}
function loginClose()
{
	$("#czinfobox").remove();
	window.location.href="/accounts/login?url=http://www.83wan.cn/members"; 
	
}	
/*充值弹窗 star*/


	
/*温馨提示*/	
function wy_ts(){
	$(".tscon").html("<h1>温馨提示：</h1><p>银行卡支付说明：</p><p>1、您必须开通了网上银行业务；</p><p>2、网上银行开通办法请咨询当地所属银行；</p><p>3、请您关闭所有屏蔽弹出窗口之类的功能，否则在线支付将无法继续，比如：3721、上网助手、google toolbar、alexa toolbar、baidu等；</p><p>4、如果您用信用卡支付，请确认该信用卡的网上交易限额大于等于您的充值金额；</p><p>5、请充值时务必确认好您的充值金额准确无误后再进行充值，避免输错金额导致的失误，如因未仔细确认金额造成的充值问题，我们将一律不予处理此类退款申诉。</p>");
	}
function zfb_ts(){
	$(".tscon").html("<h1>温馨提示：</h1><p>支付宝说明：</p><p>1、支付宝余额支付：只要您的支付宝账户中存有余额，就可以为游戏进行充值。</p><p>2、银行卡支付：只要您拥有与支付宝公司合作银行中的任意一张银行卡，并开通“网上银行”服务，即可完成充值。</p><p>3、如果您用信用卡支付，请确认该信用卡的网上交易限额大于等于您的充值金额；</p>");
	}
function szx_ts(){
	$(".tscon").html("<h1>温馨提示：</h1><p>神州行(易宝)充值卡说明：</p><p>1、请确认您的充值卡是序列号17位、密码18位，由中国移动发行的全国通用的神州行充值卡，而且是没有使用过的。</p><p>2、请务必使用与您选择的面额相同的神州行卡进行支付，如果选择金额额度不正确会导致卡面金额丢失。</p><p>3、本充值方式还支持江苏、浙江、广东、辽宁、福建的神州行地方卡。支持300和500元面额。</p><p>4、如果有疑问，请联系我们在线客服或拨打客服电话。</p>")}
function junw_ts(){
	$(".tscon").html("<h1>温馨提示：</h1><p>骏卡充值说明：</p><p>1、请确认您的骏卡充值卡是由“北京汇元网科技有限责任公司”发行的充值卡。</p><p>2、请按卡面金额进行充值，如填写额度不正确可能会无法完成充值。</p><p>3、不能使用特定游戏专属充值卡支付。</p><p><font color=\"#d70000\">4、骏卡充值有手续费，手续费为16%。【该手续费为发卡单位收取】</font></p><p>5、如果有疑问，请拨打骏卡客服电话：010－58103559。</p>")}
function liant_ts(){
	$(".tscon").html("<h1>温馨提示：</h1><p>联通卡充值说明：</p><p>1、支持中国联通发行的联通一卡充支付，面值为20元、30元、50元、100元、300元、500元</p><p><font color=\"#d70000\">2、联通卡充值有手续费，手续费为6%。【该手续费为发卡单位收取】</font></p><p>3、如果有疑问，请联系我们在线客服或拨打客服电话。</p>")}
function shengd_ts(){
	$(".tscon").html("<h1>温馨提示：</h1><p>盛大游戏卡充值说明：</p><p>1、请使用卡号以CSC5、CS、S、CA、CSB、YC、YD、YA、YB、801335开头的“盛大互动娱乐卡”进行支付，暂不支持SC开头的卡。</p><p>2、盛大游戏卡支持面值：5元、10元、30元、35元、45元、100元、350元、1000元。</p><p><font color=\"#d70000\">3、盛大游戏卡充值有手续费，手续费为16%。【该手续费为发卡单位收取】</font></p><p>4.如果有疑问，请联系我们在线客服或拨打客服电话。</p>")}
function wanm_ts(){
	$(".tscon").html("<h1>温馨提示：</h1><p>完美卡充值说明：</p><p>1、完美一卡通是指能为完美时空所属所有的网络产品充值的卡种，卡号10位，卡密15位。</p><p>2、完美卡可以进行多次在线支付，直至卡内余额为零。</p><p>3、完美卡支持的面额有：15元，30元，50元，100元。</p><p><font color=\"#d70000\">4、完美卡充值有手续费，手续费为19%。【该手续费为发卡单位收取】</font></p><p>5、如果有疑问，请联系我们在线客服或拨打客服电话。</p>")}
function zhent_ts(){
	$(".tscon").html("<h1>温馨提示：</h1><p>征途卡充值说明：</p><p>1、支持全国官方征途游戏充值卡，卡号16位，密码8位。</p><p>2、征途游戏卡支持面值：10元、15元、20元、25元、30元、50元，60元、100元、300元、468元。</p><p>3、<font color=\"#d70000\">征途卡充值有手续费，手续费为16%。【该手续费为发卡单位收取】</font></p><p>4、如果有疑问，请联系我们在线客服或拨打客服电话。</p>")}
function paypal_ts(){
	$(".tscon").html("<h1>温馨提示：</h1><p>Paypal说明：</p><p>1、电子支票从付款人的账户中结清资金后（通常需要3-5个工作日）才算转账成功。</p><p>2、转账Paypal手续费由转账人承担。比例是：4%+0.3USD / 笔 如：转账100美金，paypal手续费是100×4%+0.3USD / 笔，手续费是4.3美金。实际到账金额是：95.7美金。</p><p>3、建议使用的币种选择为美金，以减少汇率损失。</p><p>4、为了保障paypal账户的安全性，请使用paypal转账充值的玩家提供身份证、驾照或护照其中一样扫描证件给充值客服核对，以便查询处理。此信息为官方核对paypal转账之用，不会外泄。</p>")}
function ptb_ts(){
	$(".tscon").html("<h1>温馨提示：</h1><p>平台币充游戏说明：</p><p>1、平台币可以通过其他充值渠道获取。</p><p>2、平台币充游戏可以充1-50000任意金额。</p><p>3、平台币充游戏更为快捷。</p>")}
	