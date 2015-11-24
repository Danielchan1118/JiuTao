var editpass={
	CheckPass:function(){
		$("#checkpass").click(function(){
			var password = $("#password").val();
			$.ajax({
			  type: 'POST',
			  url: Url.checkurl,
			  data:{password:password},
			  dataType:'text',
			  success:function(data){
				 if(data==1){
					 $("#myform").css("display","block");
				 }else{
				 	alert("验证失败！");
				 }
				}
			});
		})
	},

	init:function(){
	    editpass.CheckPass();
	}
};

editpass.init();