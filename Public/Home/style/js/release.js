var status=0;
var uploading = 1;
function getImgURL(node) {  
  var imgURL = "";  
    try{   
        var file = null;
        if(node.files && node.files[0] ){
          file = node.files[0]; 
        }else if(node.files && node.files.item(0)) {                          
          file = node.files.item(0);   
        }   
        //Firefox 因安全性问题已无法直接通过input[file].value 获取完整的文件路径
        try{
          //Firefox7.0 
      imgURL =  file.getAsDataURL();  
      //alert("//Firefox7.0"+imgRUL);                   
        }catch(e){
          //Firefox8.0以上                          
          imgRUL = window.URL.createObjectURL(file);
      //alert("//Firefox8.0以上"+imgRUL);
        }
     }catch(e){      //这里不知道怎么处理了，如果是遨游的话会报这个异常               
        //支持html5的浏览器,比如高版本的firefox、chrome、ie10
        if (node.files && node.files[0]) {                        
          var reader = new FileReader(); 
          reader.onload = function (e) {                                  
              imgURL = e.target.result;  
          };
          reader.readAsDataURL(node.files[0]); 
        }  
     }
  imgurl = imgURL;
  // creatImg(imgRUL);
  return imgRUL;
}
   
//    function creatImg(imgRUL){   //根据指定URL创建一个Img对象
//   alert(imgRUL);
// }

var catSelect=function(){
    var class_id = 0,
    parent_class_id = 0,
    $mainCat=$('.goods-cat .form-value'),
    $viceCat=$('.goods-cat .form-value-l');
    $mainCat.children('.form-input-wr').click(function(){
        $mainCat.children('.select').css('display', 'block');
        $viceCat.children('.select').css('display', 'none');
    })
    $mainCat.children('.select').children('li').click(function(){
        var val=$(this).text(),
        cid = $(this).attr('cid');
        parent_class_id = $(this).val();

        $("#cat_l").val(parent_class_id);
        $(this).parent('ul').parent('div').children('div').css({
            'background-color': 'rgb(255,255,255)',
            'border-color':'rgb(68,193,165)'
        });
        $mainCat.children('.form-input-wr').children('span').text(val);
        $mainCat.children('.select').css('display','none');

        if ($("#cul"+parent_class_id).length) {
            $viceCat.css('display', 'block');
            $viceCat.children('.form-input-l-wr').children('span').text('未选择');
        } else {
            $viceCat.css('display', 'none');
        }
    });
    $(".form-input-l-wr").click(function(){
        $("#cul"+parent_class_id).css('display', 'block');
        $("#cul"+parent_class_id).children('li').click(function(){
            $("#cul"+parent_class_id).css('display', 'none');
            val = $(this).text();
            class_id = $(this).val();
            $('.form-input-l-wr').children('span').text(val);
            $(this).parent('ul').parent('div').children('div').css({
                'background-color': 'rgb(255,255,255)',
                'border-color':'rgb(68,193,165)'
            });
            $("#cat_l").val(class_id);
        });
    });
    $(document).click(function(){ if ($(event.srcElement).is(".goods-cat .form-value,.goods-cat .form-value *,goods-cat form-value-l,.goods-cat .form-value-l *")) {  return false; } else { $mainCat.children('.select').css('display','none');$viceCat.children('.select').css('display','none'); } });
}

$('.photo-area').attr('id','unique_img');
var img_count=0;
var addImg=function(){
    $('.choose-area').click(function(){
        $(this).next().click();
    });
    $('input[type="file"]').change(function(){
        img_count++;
        if(img_count<8){
            // alert($(this).val());
                var src=getImgURL(this);
                var $img=$('<img style="max-width:140px;max-height:140px;margin:auto;display:block;" src="'+src+'">');
                var $c_node=$('#unique_img').clone(true).attr('id','');
                $c_node.append($img);
                $c_node.children('div').css('display','none');
                $c_node.children('span').css('display','block');
                $('#unique_img').before($c_node);
            }
        else if(img_count==8){
                var src=getImgURL(this);
                var $img=$('<img style="width:auto;height:140px;" src="'+src+'">');
                var $c_node=$('#unique_img').clone(true).attr('id','');
                $c_node.append($img);
                $c_node.children('div').css('display','none');
                $c_node.children('span').css('display','block');
                $('#unique_img').before($c_node);
                $('#unique_img').css('display','none');
        }
    });
function o_a_i(){
    if(status==0){
      $('.upload-area').css('display','inline-block');
      $('.photo-area').removeClass('over-up');
      $('.photo-area').addClass('init-up');
    }
    else if(status>=8){
      $('.upload-area').css('display','none');
    }
    else{
        $("#upload-button").show();
      $('.upload-area').css('display','inline-block');
    }
}
    $('.close').click(function(){
        $(this).parent('div').remove();
        $(this).parent('div').empty();
        status--;
        uploading--;
        o_a_i();
    })
}
 var discount=function(){//使用情况
    $('.user_status .form-value .form-input-wr span').click(function(){
        var val=$(this).attr('data-value');
        $('.user_status .form-value .form-input-wr span').removeClass('sel');
        $(this).addClass('sel');
        $('#discount').val(val);
    })
 }
  var pay_type=function(){//交易方式
    $('.pay_type .form-value .form-input-wr span').click(function(){
        var val=$(this).attr('data-value');
        $('.pay_type .form-value .form-input-wr span').removeClass('sel_1');
        $(this).addClass('sel_1');
        $('#pay_type').val(val);
		if(val == 4){
			$(".action_price").css("display","block");
			$(".add_price").css("display","block");
			$(".former_price").css("display","none");
			$(".transfer_pre").css("display","none");
			return;
		}else if(val==3){
			$(".action_price").css("display","none");
			$(".add_price").css("display","none");
			$(".former_price").css("display","none");
			$(".transfer_pre").css("display","none");
			return;
		}else{
			$(".action_price").css("display","none");
			$(".add_price").css("display","none");
			$(".former_price").css("display","block");
			$(".transfer_pre").css("display","block");
			return;
		}
    })
 }
   var period=function(){//发布周期
    $('.period .form-value .form-input-wr span').click(function(){
        var val=$(this).attr('data-value');
        $('.period .form-value .form-input-wr span').removeClass('sel_2');
        $(this).addClass('sel_2');
        $('#period').val(val);
    })
 }
var act=function(){
    $('.form-value input,.form-value textarea').focus(function(){
        $(this).parent('div').css({
            'background-color': 'rgb(255,255,255)',
            'border-color':'rgb(68,193,165)'
        });
        $(this).parent('div').removeClass('form-alert');
    });
    $('.form-value input,.form-value textarea').blur(function(){
       if($(this).val()==''){
        $(this).parent('div').css({
            'border': '1px solid rgb(208,224,226)',
            'background-color': 'rgb(246,249,249)'
        });
       } 
       else{
        $(this).parent('div').css({
            'background-color': 'rgb(255,255,255)',
            'border-color':'rgb(68,193,165)'
        });
       }
    });
}
function submitCaution(elem){
    $('#'+elem).parent('div').css({
        'background-color': 'rgb(255,233,236)',
        'border-color':'rgb(235,80,83)'
    });
    $('#'+elem).parent('div').addClass('form-alert');
}
var submitAct=function(){
    $('.form-wr form').submit(function(){
        var tel=$('#tel').val(),
            price=$('#price').val(),
            title=$('#title').val(),
            qq=$('#qq').val(),
            desc=$('#desc').val();
        var i=1;
        if(price==''){
            submitCaution('price');
            i=0;
        }
        if(title==''){
            submitCaution('title');
            i=0;
        }
        if(desc==''){
            submitCaution('desc');
            i=0;
        }
        if(!tel.match(/^1[3|4|5|8][0-9]\d{4,8}$/)) {
            submitCaution('tel');
            i=0;
        }
        if(!qq.match(/^[1-9]d{4,8}$/)){
            submitCaution('qq');
            i=0;
        }
        if(i==0) return false;
        else return true;
    })
}

function pre_release()
{
	var url,url_small;
    var tel=$('#tel').val(),
        real_price=$('#real_price').val(),//原价   cat_l
        pay_price=$('#pay_price').val(),//转让价
        weixin=$('#weixin').val(),
        name=$('#title').val(),
        qq=$('#qq').val(),
        desc=$('#desc').val();
    //获取图片 pay_type
    var images = new Array();
	var arr_img=  new Array();
    var j = 0,i=0;
	
    var upload_success = 1;
    $('.img_url').each(function(index, img){   //JSON.parse(jsonstr);JSON.stringify(jsonstr)    
		 url=$(this).attr("data1");
		 url_small=$(this).attr("data");		 
         arr_img[j++] = JSON.parse('{"imgurl":"'+url_small+'"}');
         images[i++] = JSON.parse('{"imgurl":"'+url+'"}');
          
    });
    if (images.length == 0) {
        alert('正所谓没图没真相，补上图片吧，亲！');
        return;
    }

    var i=1;
   
	
	
    if(name == ''){
        submitCaution('title');
        i=0;
    }
    if(desc==''){
        submitCaution('desc');
        i=0;
    }
	if(qq!=''){
		if(!qq.match(/^\d{6,11}$/)){
			submitCaution('qq');
			i=0;
			return;
		}
	}
    
	if(tel!=''){
		if(!tel.match(/^\d{7,11}$/)){
			submitCaution('tel');
			alert("电话号码不正确！");
			return;
		}
	}
	
	
    if (!i) {
        return;
    }
	if(qq =='' && tel=='' && weixin==''){
			alert("联系方式至少填一项");
			return;
	}
	var pay_type = $("#pay_type").val();
	if(pay_type == 4){//竞拍
		var action_price = $("#action_price").val();
		var add_price = $("#add_price").val();
		if(!action_price.match(/^[1-9]+[0-9]*]*$/) || !add_price.match(/^[1-9]+[0-9]*]*$/)){
			alert("价格不为整数");  
			//$('#real_price').focus();  
			return false; 
		}
	}else if(pay_type !=3){
		if(!real_price.match(/^[1-9]+[0-9]*]*$/) || !pay_price.match(/^[1-9]+[0-9]*]*$/)){
			alert("价格不为整数");  
			//$('#real_price').focus();  
			return false; 
		}
		 if(real_price == '' || real_price < 0){
        submitCaution('real_price');
        i=0;
    }
	
	if(pay_price == '' || pay_price < 0){//转让价
        submitCaution('pay_price');
        i=0;
    }
		
	}
	 if(pay_type == ''){
		alert("交易放式还没有选择！");
		return;
	} 
    var trade_place = $("#trade_place").val();
    var period = $("#period").val();
    var discount = $("#discount").val();
	if(discount ==''){
		alert("使用情况还没有选择！");
		return;
	}
	if(period ==''){
		alert("发布周期还没有选择！");
		return;
	}
    var goods_class_id = $("#cat_l").val();
	if(goods_class_id == ''){
		alert("分类还没有选择！");
		return;
	}
    $('.load-tip').text('正在发布');
    $('#circular-loading').removeClass('hidden');
    $('.form-submit').attr('disabled', true);
	//var checkbox = document.getElementById('test');  //发布规则
	checkbox = document.getElementById('form-share');  //发布规则
	if(!checkbox.checked){
		alert("商品规则还没有选择！");
		return;
	}
    //提交表单   discount
    $.post(
        '/Release/ajax_release',
        {	
			real_price: real_price,
			pay_price : pay_price,
			pay_type : pay_type,
			period : period,
            title : name,
            content : desc,
            current_price : action_price,
            markups : add_price,
            location : trade_place,
            use_status : discount,
            cat_id : goods_class_id,
            img_url : JSON.stringify(images),
            former_url : JSON.stringify(arr_img),
            qq : qq,
            weixin : weixin,
            phone : tel
        },
        function(data) {
            $('#circular-loading').addClass('hidden');
            res = $.parseJSON(res);
			if(data.res ==1){
				window.location.href = data.url;
			}else if(data.res ==-1){
				alert("发布失败，请重新发布！");
			}
                
             
        }
    );
}



function move()
{
    var tel=$('#tel').val(),
        price=$('#price').val(),
        name=$('#title').val(),
        qq=$('#qq').val(),
        desc=$('#desc').val(),
        ot_name=$('#ot_name').val();

    //获取图片
    var images = new Array();
    var j = 0;
    var upload_success = 1;
    $('.image').each(function(index, img){
        if (index != 0) {
            if (img.src.indexOf('qiniu') == -1 &&
                img.src.indexOf('goods_image') == -1) {
                upload_success = 0;
            } else {
                images[j++] = img.src;
            }
        }
    });

    if (!upload_success) {
        alert('有图片上传失败，请删除重试哦，亲！');
        return;
    }
    if (images.length == 0) {
        alert('正所谓没图没真相，补上图片吧，亲！');
        return;
    }

    var trade_place = $("#trade_place").val();
    var discount = $("#discount").val();
    var goods_class_id = $("#cat_l").val();

    $('.load-tip').text('正在发布');
    $('#circular-loading').removeClass('hidden');
    $('.form-submit').attr('disabled', true);

    //提交表单
    $.post(
        '/manage/goods/move_act',
        {
            goods_name : name,
            goods_detail : desc,
            goods_price : price,
            goods_trade_place : trade_place,
            goods_is_discount : discount,
            goods_class_id : goods_class_id,
            goods_image : images.join(','),
            user_qq : qq,
            user_phone_number : tel,
            ot_name : ot_name
        },
        function(res) {
            $('#circular-loading').addClass('hidden');
            res = $.parseJSON(res);
            if (res.code != 0) {
                alert(res.msg);
                $('.form-submit').attr('disabled', false);
            } else {
                window.location.href = res.data.goods_url;
            }
        }
    );
}

function one()
{
    var real_price=$('#real_price').val(),//原价
        pay_price=$('#pay_price').val(),//转让价
        name=$('#title').val(),
        desc=$('#desc').val();

    //获取图片
    var images = new Array();
    var j = 0;
    var upload_success = 1;
    $('.image').each(function(index, img){
        if (index != 0) {
            if (img.src.indexOf('qiniu') == -1 &&
                img.src.indexOf('goods_image') == -1) {
                upload_success = 0;
            } else {
                images[j++] = img.src;
            }
        }
    });

    if (!upload_success) {
        alert('有图片上传失败，请删除重试哦，亲！');
        return;
    }
    if (images.length == 0) {
        alert('正所谓没图没真相，补上图片吧，亲！');
        return;
    }

    $('.load-tip').text('正在发布');
    $('#circular-loading').removeClass('hidden');
    // $('.form-submit').attr('disabled', true);

    //提交表单
    $.post(
        '/manage/one/release',
        {
            one_name : name,
            one_detail : desc,
            one_price : price,
            one_image : images.join(',')
        },
        function(res) {
            $('#circular-loading').addClass('hidden');
            res = $.parseJSON(res);
            if (res.code != 0) {
                alert(res.msg);
                $('.form-submit').attr('disabled', false);
            } else {
                window.location.href = '/mobile/one/'+res.data.one_id;
            }
        }
    );
}

function reward()
{
    var price=$('#price').val(),
        name=$('#title').val(),
        desc=$('#desc').val(),
        type=$('#cat_l').val(),
        day=$('#day').val(),
        stock=$("#stock").val();

    //获取图片
    var images = new Array();
    var j = 0;
    var upload_success = 1;
    $('.image').each(function(index, img){
        if (index != 0) {
            if (img.src.indexOf('qiniu') == -1 &&
                img.src.indexOf('goods_image') == -1) {
                upload_success = 0;
            } else {
                images[j++] = img.src;
            }
        }
    });

    if (!upload_success) {
        alert('有图片上传失败，请删除重试哦，亲！');
        return;
    }
    if (images.length == 0) {
        alert('补上图片吧，亲！');
        return;
    }
    if (!name) {
        alert('信息没有填写完整');
        return;
    }
    if (!type)
    {
        alert('没有选择分类');
        return;
    }
    if (day && day%15 != 0)
    {
        alert('签到天数必须为15的整数倍');
        return;
    }
    if (type == 3 && !day)
    {
        alert('签到礼品必须填写天数');
        return;
    }

    $('.load-tip').text('正在发布');
    $('#circular-loading').removeClass('hidden');
    // $('.form-submit').attr('disabled', true);

    //提交表单
    $.post(
        '/goods/release',
        {
            goods_name : name,
            goods_detail : desc,
            goods_price : price,
            goods_image : images.join(','),
            goods_type : type,
            goods_exchange_need_day : day,
            goods_stock : stock
        },
        function(res) {
            $('#circular-loading').addClass('hidden');
            res = $.parseJSON(res);
            if (res.code != 0) {
                alert(res.msg);
                $('.form-submit').attr('disabled', false);
            } else {
                alert('上传成功');
                window.close();
            }
        }
    );
}

function modify()
{
    var tel=$('#tel').val(),
        price=$('#price').val(),
        name=$('#title').val(),
        qq=$('#qq').val(),
        desc=$('#desc').val();

    //获取图片
    var images = new Array();
	alert(images);
    var j = 0;
    var upload_success = 1;
    $('.image').each(function(index, img) {
	
        if (index != 0) {
            if (img.src.indexOf('qiniu') == -1 &&
                img.src.indexOf('goods_image') == -1) {
                upload_success = 0;
            } else {
                images[j++] = img.src;
            }
        }
    });

    if (!upload_success) {
        alert('有图片上传失败，请重新上传该张图片哦，亲！');
        return;
    }
    if (images.length == 0) {
        alert('正所谓没图没真相，补上图片吧，亲！');
        return;
    }

    var i=1;
    if(price == '' || price < 0) {
        submitCaution('price');
        i=0;
    }
    if(name == '') {
        submitCaution('title');
        i=0;
    }
    if(desc=='') {
        submitCaution('desc');
        i=0;
    }
    if(!tel.match(/^\d{7,11}$/) && qq == '') {
        submitCaution('tel');
        i=0;
    }
    if(!qq.match(/^\d{6,11}$/) && tel == ''){
        submitCaution('qq');
        i=0;
    }
    if (!i) {
        return;
    }

    var trade_place = $("#trade_place").val();
    var discount = $("#discount").val();
    var goods_class_id = $("#cat_l").val();
    var goods_id = $("#goods_id").val();

    //提交表单
    $.post(
        '/goods/release',
        {
            goods_id : goods_id,
            goods_name : name,
            goods_detail : desc,
            goods_price : price,
            goods_trade_place : trade_place,
            goods_is_discount : discount,
            goods_class_id : goods_class_id,
            goods_image : images.join(','),
            user_qq : qq,
            user_phone_number : tel
        },
        function(res) {
            res = $.parseJSON(res);
            if (res.code != 0) {
                alert(res.msg);
            } else {
                window.location.href = '/goods/'+res.data.goods_id;
            }
        }
    );
}

var selectPhoto=function(){
    $('.camera-button').click(function(){
        $(this).parent('div').css('display','none');
        $('.gallery').css('display','block');
    })
}

var closeRemindApp=function(){
    $('.close.ico').click(function(){
        $('.download_guide').remove();
    });
    $('.btn_continue.ico').click(function(){
        $('.download_guide').remove();
    });
}
var checkbox=function(){
	$("#form-share").click(function(){
		checkbox = document.getElementById('form-share');  //发布规则
		if(!checkbox.checked){
			alert("商品规则还没有选择！");
		return;
		}
	});
} 
$(document).ready(function(){
    // photo_init();
    act();
	checkbox();
    selectPhoto();
    catSelect();
    discount();
    addImg();
    submitAct();
    closeRemindApp();
	pay_type();
	period();
});

function o_o_i(){
    if(status<=0){
        $('.upload-area').css('display','inline-block');
        $('.photo-area').removeClass('over-up');
        $('.photo-area').addClass('init-up');
    }
    else if(status>=8){
        // $('.upload-area').css('display','none');
        var $elem=$('.clone-target').children('div').clone(true);
        $('.upload-area').before($elem);
        $("#upload-button").hide();
    }
    else{
        $('.upload-area').css('display','inline-block');
        $('.photo-area').removeClass('init-up');
        $('.photo-area').addClass('over-up');
        var $elem=$('.clone-target').children('div').clone(true);
        $('.upload-area').before($elem);
    }
}
$(function(){
    var elem = [], processNode = [];
    $('#upload').uploadify({
	'formData'     : {
					'timestamp' : '{$time}',            //时间
					'token'     : '{$time | md5}',		//加密字段
					'url'		: $('#url').val()+'/Uploads/images/',	//url
					'imageUrl'	: $('#root').val()				//root
				},

		'fileTypeDesc' : 'Image Files',					//类型描述
		//'removeCompleted' : false,    //是否自动消失
		'fileTypeExts' : '*.gif;*.png;*.jpeg;*.jpg;*.bmp',		//允许类型
		'fileSizeLimit' : '5MB',					//允许上传最大值
		'swf'      : $('#public').val()+'/Home/style/js/uploadify.swf',	//加载swf
		'uploader' : $('#url').val()+'/uploadify',					//上传路径
		'buttonText' :'',
        'successTimeout': 30,
        'queueSizeLimit': 8,
        'onSelect' : function(file) {
            status++;
            o_o_i();
            elem[status] = $(".photo:last")[0];
            processNode[status] = processSetUp(elem[status]);
        },
        'onUploadProgress' : function(file, bytesUploaded, bytesTotal, totalBytesUploaded, totalBytesTotal) {
            var rate = bytesUploaded/bytesTotal;
            processNode[uploading](rate);
        },
        'onUploadError' : function(file, errorCode, errorMsg, errorString) {
            alert('文件 ' + file.name + ' 上传失败：' + errorString);
        },
       'onUploadSuccess' : function(file, data, response) {	
			res = $.parseJSON(data);
            
			if(res){
				$(elem[uploading]).children('div').children('img').attr('src',res.url);
				$(elem[uploading]).children('div').children('img').attr('data',res.bre_url);
				$(elem[uploading]).children('div').children('img').attr('data1',res.url);
				 $(elem[uploading]).children('div').children('img').addClass('img_url');
				//$(".image").append('<input type="hidden"  name="huyuming" value="'+res.bre_url+'">');
				//$(".image").append('<input type="hidden" name="bre_url1" value="'+res.url+'">');
				$(elem[uploading]).addClass('uploadComplete');
			}else{
				alert('上传失败,从新上传！');
			}
            uploading++;
        },
        'onSelectError' : function() {
            alert('最多只能上传九张图片');
        }
    });
});

function test(){
	var id = $(this).attr('data');
			var fav_ids = window.localStorage["fav_ids"];
			var arr_id = Array();
			if(typeof fav_ids != 'undefined' && fav_ids!=null)
				arr_id = fav_ids.split(',');
			else{
				fav_ids = ""+id;
				window.localStorage["fav_ids"] = fav_ids;
				$(".shoucang_"+id).addClass('icoJokeCollection_y');
				$html = "收藏成功";
				tishi($html);
				return;
			}
}


function processSetUp(elem) {
    var bar = document.createElement('div');
    bar.className = 'processbar';
    elem.appendChild(bar);
    
    return function (x) {
        bar.style.width = x.toFixed(3)*100 + '%';
    }
}