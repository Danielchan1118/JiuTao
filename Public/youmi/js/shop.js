$("#telphone").blur(function(){
	 var user = $(this).val();
	 var telphone = /^(13[0-9]{9})| (18[0-9]{9}) |(15[89][0-9]{8})$/;
	 if(user=='' || !telphone.test(user)){
	 		$("#show_error_tphone").css("color","red");
	 		$("#show_error_tphone").html("格式不对，应是13530072549格式");
	 		return false;
	 }else{
	 		$("#show_error_tphone").css("color","green");
	 		$("#show_error_tphone").html("格式正确，可以使用");
	 		return true;
	 }
});

$("#phone").blur(function(){
	 var phone = $(this).val();
	 var telphone = /(^[0-9]{3,4}[0-9]{7,8}$)|(^[0-9]{7,8}$)|(^[0-9]{3,4}\-[0-9]{7,8}$)|(^[0-9]{7,8}$)|(^\([0-9]{3,4}\)[0-9]{3,8}$)|(^0{0,1}13[0-9]{9}$)/;
	 if(phone=='' || !telphone.test(phone)){
	 		$("#show_error_phone").css("color","red");
	 		$("#show_error_phone").html("格式不对，应是0749-7849704格式");
	 		return false;
	 }else{
	 		$("#show_error_phone").css("color","green");
	 		$("#show_error_phone").html("格式正确，可以使用");
	 		return true;
	 }
});

$("#qq").blur(function(){
	 var qq = $(this).val();
	 var qq_verify = /^[0-9]{6,10}$/;
	 if(qq=='' || !qq_verify.test(qq)){
	 		$("#show_error_qq").css("color","red");
	 		$("#show_error_qq").html("格式不对，应是6-10位的数字组成");
	 		return false;
	 }else{
	 		$("#show_error_qq").css("color","green");
	 		$("#show_error_qq").html("格式正确，可以使用");
	 		return true;
	 }
});

$("#email").blur(function(){
	 var email = $(this).val();
	 var email_verify = /^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$/;
	 if(email=='' || !email_verify.test(email)){
	 		$("#show_error_email").css("color","red");
	 		$("#show_error_email").html("格式不对，应是6-10位的数字组成");
	 		return false;
	 }else{
	 		$("#show_error_email").css("color","green");
	 		$("#show_error_email").html("格式正确，可以使用");
	 		return true;
	 }
});
$("#myform").submit(function(){
	var telphone =  $("#telphone").val();
	var phone =  $("#phone").val();
	var qq =  $("#qq").val();
	var email =  $("#email").val();
	var telphone1 = /^(13[0-9]{9})| (18[0-9]{9}) |(15[89][0-9]{8})$/;
	var phone1 = /(^[0-9]{3,4}[0-9]{7,8}$)|(^[0-9]{7,8}$)|(^[0-9]{3,4}\-[0-9]{7,8}$)|(^[0-9]{7,8}$)|(^\([0-9]{3,4}\)[0-9]{3,8}$)|(^0{0,1}13[0-9]{9}$)/;
	var qq1 = /^[0-9]{6,10}$/;
	var email1 = /^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$/;
	if(!telphone1.test(telphone)|| !phone1.test(phone) ||!qq1.test(qq) ||!email1.test(email)){
			alert('输入有误或者格式不对！');
			return false;
	}
});

$('#myforms').submit(function(){
	var $password1 = $('#password1').val();
	var $password2 = $('#password2').val();
	if($password1!== $password2){
		alert('两次密码不一样');
		return false;
	}
	if( $password1.length<6 || $password1.length>22 || $password2!==$password1 ){
		alert('您填写的信息数据有误，请检查!');
		return false;
	}
});

$("#checkpass").click(function(){
	var password = $("#password").val();
	$.ajax({
	  type: 'POST',
	  url: Url.checkurl,
	  data:{password:password},
	  dataType:'text',
	  success:function(data){
		 if(data==1){
			$("#myforms").css("display","block");
			$(".check_pass").css("display","none");
		 }else{
			alert("验证失败！");
		 }
		}
	});
});
