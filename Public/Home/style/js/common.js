
(function() {

/*
    var windowScroll = function() {
        var state = false,
            header = $("header"),
            nav = $("nav");

        function _dealScroll() {
            //alert(this.scrollY);
            var scroll_top;
            if(this.scrollY !== undefined){
                scroll_top = this.scrollY;
            }else{
                scroll_top = document.documentElement.scrollTop;
            }
            if(!state && scroll_top > 0) {
                state = true;
                $(header).addClass("scroll");
                $(nav).addClass("scroll");

                    $(".nav-icons").addClass("hidden");

            }
            else if(state && scroll_top <= 0) {
                state = false;
                $(header).removeClass("scroll");
                $(nav).removeClass("scroll");
                setTimeout(function(){
                    $(".nav-icons").removeClass("hidden");
                },150);
            }
        }

        function _bind() {
            $(window).on("scroll", _dealScroll);
        }

        return {
            bind: _bind
        };
    }();
*/
    var searchBox = function() {
        var form = $(".search-box"),
            input = $("#keyword");

        function _validInput() {
            if($(input).val() == "")
                return false;
            return true;
        }

        function _bind() {
            $(form).on("submit", function(e) {
                return _validInput();
            });
        }

        return {
            bind: _bind
        };
    }();

    function validText(value) {
        if( value == "" || value == null ) return 0;
        return 1;
    }

    function validEmail(value) {
        if(value == "" || value == null) return 0;
        return /^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/.test(value);
    }

    function validQQ(value) {
        if(value == "" || value == null) return 0;
        return /[0-9]{6,11}/.test(value);
    }

    function formValid(type, value) {
        switch(type) {
            case "text":
            case "password":
                return validText(value);
            case "email":
                return validEmail(value);
            case "tel":
                return validTel(value);
            default: return false;
        }
    }

    var lr = function() {
        var el = $(".log-reg"),
            cl = $('.commenting-unlogin'),
            state = "n",
            log = $(".login-cover"),
            reg = $(".reg-cover"),
            alog = $(".reg-cover a.log"),
            areg = $(".login-cover a.reg"),
            lc = $(".login-cover a.close"),
            rc = $(".reg-cover a.close"),
            lInputWrs = $(".login-form-container .input-name"),
            rInputWrs = $(".reg-form-container .input-name"),
            lsub = $(".login-form-container .submit"),
            rsub = $(".reg-form-container .submit"),
            inputL = [];

        function placeholder(el) {
            this.el = el;
            this.input = $(this.el).children("input").get(0);
            this.inputFocus = false;
            this.parent = $(this.el).parent().get(0);
            this.state = 0;  //0代表无状态， 1代表输入正确， -1代表输入错误
        }
        placeholder.prototype.binded = [];
        placeholder.prototype.className = "input-name";
        placeholder.prototype.fire = function() {
            $(this.input).on("focus", this.handleFocus);
            var p = this.parent;
            if( $.inArray(p, this.binded) >= 0 ) return ;
            this.binded.push(p);
            $(p).on("click", "." + this.className, this.handleClick);
        };
        placeholder.prototype.handleFocus = function(e) {
            var that = inputL[ $.inArray( e.currentTarget, $(inputL).map(function(index, el) {
                return el.input;
            }) ) ];
            that.inputFocus = true;
            that.dealInputF();
        };
        placeholder.prototype.handleBlur = function(e) {
            var that = e.data.that;
            that.dealInputB.call(this, that);
        }
        placeholder.prototype.handleClick = function(e) {
            var that = inputL[ $.inArray( e.currentTarget, $(inputL).map(function(index, el) {
                return el.el;
            }) ) ];
            that.dealInputF();
        };
        placeholder.prototype.dealInputF = function() {
            if( !this.inputFocus ) {
                $(this.input).focus();
                this.inputFocus = true;
            }
            $(this.el).addClass("focus");
            $(this.input).one("blur", {that: this}, this.handleBlur);
        };
        placeholder.prototype.dealInputB = function(that) {
            var note = formValid(this.type, this.value);
            that.inputFocus = false;
            if( note === 0 ) {
                $(that.el).removeClass("focus");
                that.state = 0;
            }
            else if( !note ) {
                alert( $(that.el).data("value") + "格式不正确");
                that.state = -1;
            } else {
                that.state = 1;
            }
        }

        function firePlaceholder(arr) {
            inputL = $(arr).map(function(index, el) {
                return new placeholder(el);
            });
            $(inputL).each(function(index, el) {
                el.fire();
            });
        }

        function _show(type) {
            if( type === "l" ) {
                // console.log('l');
                state = "l";
                $(log).fadeIn();
                firePlaceholder(lInputWrs);
                $(log).on("click", function(e) {
                    if(e.target === log.get(0))
                    _hide("l");
                });
                $(areg).one("click", function(e) {
                    _hide("l");
                    _show("r");
                });
            }
            else {
                state = "r";
                $(reg).fadeIn();
                firePlaceholder(rInputWrs);
                $(reg).on("click", function(e) {
                    if(e.target === reg.get(0))
                        _hide("r");
                });
                $(alog).one("click", function(e) {
                    _hide("r");
                    _show("l");
                });
            }
        }

        function _hide(type) {
            type === "l" ? $(log).fadeOut() : $(reg).fadeOut();
            state = "n";
        }

        function _togglePopup(type) {
            state === "n" ? _show(type) : _hide(type);
        }

        function _bind() {
            $(el).on("click", ".button", function() {
                _togglePopup( $(this).data("type") );
            });
            $(cl).on("click", ".comment-login", function() {
                _togglePopup( $(this).data("type") );
            });
        }

        return {
            bind: _bind
        };
    }();



    //windowScroll.bind();
    searchBox.bind();
    lr.bind();
})();

// salt = 'zijicai';
// digest_len = 40;

// function encode(data)
// {
//     var json = JSON.stringify(data);
//     var digest = CryptoJS.SHA1(json+salt);
//     return digest+json;
// }

// function decode(response)
// {
//     var digest = response.substr(0, digest_len);
//     var json = decodeURIComponent(response.substr(digest_len));
//     if (CryptoJS.SHA1(json+salt) != digest)
//     {
//         return false;
//     }
//     return $.parseJSON(json);
// }

function is_empty(str)
{
    return $.trim(str).length == 0;
}

function login()
{
    var username = $("#user-name").val();
    var password = $("#pw").val();

    if (username.length == 0
        || password.length == 0)
    {
        alert("账号和密码不能为空");
        return;
    }
    $("#circular-loading").removeClass('hidden');
    $.post(
        '/login',
        {username : username, password : password},
        function(res) {
            $("#circular-loading").addClass('hidden');
            res = $.parseJSON(res);
            if (res.code == 0) {
                location.reload();
            } else {
                alert(res.msg);
            }
        }
    );
}

function register()
{
    var email = $("#email").val();
    var nickname = $("#uname").val();
    var password = $("#passw").val();
    var password_repeat = $("#cpassw").val();

    if (is_empty(email) || is_empty(nickname)
        || is_empty(password) || is_empty(password_repeat))
    {
        alert('所有选项必须填写');
        return;
    }
    $(".load-tip").text('注册中');
    $("#circular-loading").removeClass('hidden');
    $.post(
        '/login/register',
        {email : email, nickname : nickname, password : password,
            password_repeat : password_repeat},
        function(res) {
            $("#circular-loading").addClass('hidden');
            res = $.parseJSON(res);
            if (res.code == 0) {
                location.reload();
            } else {
                alert(res.msg);
            }
        }
    );
}

function enter_login(e)
{
    var key = window.event ? e.keyCode : e.which;
    if (key == 13) {
        login();
    }   
}

$(".login-form-container").find(".submit").on("click", login);
$(".reg-form-container").find(".submit").on("click", register);

function favorites()
{
    var goods_id = $("#goods_id").val(),
        favorites_num = parseInt($(".ershou-favorite").text()),
        background_image = '';
    $.ajax({
	  url: '/Goods/favorites',
	  type: 'post',
	  dataType:'json',
	  data:{goods_id:goods_id},
	  success:function(data){
			
			if (data.action == 1) {
				favorites_num++;
				$(".ershou-favorite").css('background-image', 'url(/Public/Home/style/image/heart_full.png)');
			}else if(data.action == 3){
				favorites_num--;
				$(".ershou-favorite").css('background-image', 'url(/Public/Home/style/image/heart.png)');
			}
			$(".ershou-favorite").text(favorites_num);
		}
    });
}

function cancel_favorites(goods_id)
{
	$.ajax({
	  url:'/UserCenter/getCollect',
	  type:'post',
	  dataType:'json',
	  data:{pay_id : goods_id},
	  success:function(data){
		res = data;
		if (res.code != 1) {
			alert(res.msg);	
			return;
		}
		$("#goods"+goods_id).remove();
	  }
	});	
}

function stu_cert()
{
    var param1 = $("#i1").attr("param"),
        value1 = $("#i1").val(),
        param2 = $("#i2").attr("param"),
        value2 = $("#i2").val();
    $.post(
        '/user/stu_cert', 
        {param1:param1, param2:param2, value1:value1, value2:value2},
        function(res){
            res = $.parseJSON(res);
            if (res.code != 0) {
                $("#not_match").text(res.msg);
                return;
            }
            $(".std_id_box").hide();
            $("#id_succeed").show();
            setTimeout(function(){
               location.reload();
            }, 2000);
        }
    );
}

/*删除商品*/
function off_shelf(goods_id)
{
    if (!confirm('删除后商品别人将看不到，是否确认删除')) {
        return;
    }
	
	$.ajax({
	  url:'/UserCenter/payDel',
	  type:'post',
	  dataType:'json',
	  data:{pay_id : goods_id},
	  success:function(data){
		res = data;
		if (res.code != 1) {
			alert(res.msg);			
		} else {
            location.reload();
        }
	  }
	});		
}

function on_shelf(goods_id)
{
    $.post('/goods/on_shelf', {goods_id : goods_id}, function(res){
        res = $.parseJSON(res);
        if (res.code != 0) {
            alert(res.msg);
        } else {
            location.reload();
        }
    });
}

function sold(goods_id)
{
    if (!confirm('商品卖出后其他用户将看不到商品，是否确认售出')) {
        return;
    }
	
	$.ajax({
	  url:'/UserCenter/changePayStatus',
	  type:'post',
	  dataType:'json',
	  data:{pay_id : goods_id},
	  success:function(data){
		res = data;
		if (res.code != 1) {
			alert(res.msg);			
		} else {
            location.reload();
        }
	  }
	});   
}

function feedback()
{
    var contact  = $("#contact").val(),
        feedback = $("#feedback").val();
    if ($.trim(feedback).length == 0) {
        alert('反馈不能为空哦，亲');
        return;
    }
    $.post('/feedback', {contact:contact,feedback:feedback}, function(res){
        res = $.parseJSON(res);
        if (res.code != 0) {
            alert(res.msg);
        } else {
            $(".fade_back").hide();
            $(".thanks_fd").show();
            setTimeout(function(){
                $(".thanks_fd").hide();
            }, 2000);
        }
    });
}

function read(message_id, goods_id)
{
    var message_num = parseInt($(".person_message").text());
    if (goods_id) {
        window.open('/goods/'+goods_id);
    }
    $.post('/message/read', {message_id:message_id}, function(res){
        res = $.parseJSON(res);
        if (res.code != 0) {
            alert(res.msg);
        } else {
            $("#message"+message_id).remove();
            if (message_num-1 <= 0) {
                $(".person_message").remove();
            } else {
                $(".person_message").text(message_num-1);
            }
        }
    });
}