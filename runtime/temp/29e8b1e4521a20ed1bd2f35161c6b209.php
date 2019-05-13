<?php if (!defined('THINK_PATH')) exit(); /*a:8:{s:66:"/www/web/migu666/public/../application/index/view/comic/index.html";i:1552551032;s:55:"/www/web/migu666/application/index/view/public/ico.html";i:1552551032;s:60:"/www/web/migu666/application/index/view/public/css-link.html";i:1556785893;s:59:"/www/web/migu666/application/index/view/public/js-link.html";i:1556785851;s:58:"/www/web/migu666/application/index/view/public/header.html";i:1552551032;s:57:"/www/web/migu666/application/index/view/public/lunbo.html";i:1552551032;s:60:"/www/web/migu666/application/index/view/public/inputbox.html";i:1552551032;s:58:"/www/web/migu666/application/index/view/public/footer.html";i:1552551032;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<title>米谷 米谷</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta charset="utf-8">
<meta http-equiv="x-pjax-version" content="v123">
<style type="text/css">
.animated {position: fixed;top: 0;left: 0;right: 0;transition: all .2s ease-in-out;}
.animated.slideDown {top: -100px;}
.animated.slideUp {top: 0;}
</style>
<link href="/static/imgs/ico/ico.jpg" rel="shortcut icon">
<!-- CSS-LINK -->

<link href="/static/css/same.css" rel="stylesheet" type="text/css" media="all" />
<link href="/static/css/jquery.bscslider.css" rel="stylesheet" type="text/css" media="all" />
<link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">	
<link href="/static/css/load_comic.css" rel="stylesheet" type="text/css" media="all" />
<link href="/static/css/load_chapter.css" rel="stylesheet" type="text/css" media="all" />
<link href="/static/css/load_page.css" rel="stylesheet" type="text/css" media="all" />
<link href="/static/css/VideoCover.css" rel="stylesheet" type="text/css" media="all" />
<link href="/static/css/header.css" rel="stylesheet" type="text/css" media="all" />
<link href="/static/css/inputbox.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
<link href="/static/layui/css/layui.css" rel="stylesheet" type="text/css" media="all" />



<!-- CSS-LINK -->
<script src="/static/js/modernizr.custom.js"></script>
<script src="/static/js/jquery.min.js"></script>
<script src="//cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/jquery.bscslider.js"></script>
<script src="/static/js/load_comic.js"></script>
<script src="https://cdn.bootcss.com/jquery_lazyload/1.9.7/jquery.lazyload.js"></script>

<script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="//cdn.bootcss.com/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
<script src="/static/layui/layui.js"></script>
</head>
<body> 
<!--header-->

<div id="header">
	<div id="page_top">
		<div id="bg-wrap">
			<div class="mask"></div>
		</div>

		<div class="header_content">
			<div class="head_width">
				<div class="header_nav">
					<ul>
						<li class="menu_home">
							<a data-pjax href="http://ci.migu666.net">首页</a>
						</li>
					</ul>
				</div>
				<div class="loginBox">
					<a class="logBtn" id='logBtn'>登录</a>
					<span></span>
					<a class="regBtn" id='regBtn'>注册</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="go_top"></div>

<div id="loginHtml">
	<div class="layui-form-item">
	   <label class="layui-form-label">帐号</label>
	   <div class="layui-input-block">
	    	<input type="text" name="username" lay-verify="title" autocomplete="off" placeholder="请输入帐号" class="layui-input" id="lgAcc" />
	   </div>
	</div>

	<div class="layui-form-item">
		<label class="layui-form-label">密码</label>
		<div class="layui-input-block">
			<input type="password" name="password" placeholder="请输入密码" autocomplete="off" class="layui-input" id="lgPass" />
		</div>
	</div>
	
	<div class="layui-form-item">
		<img src="/creatPicture"  onclick="this.src='/creatPicture?'+new Date().getTime();" width="200" height="40">
		<input type="text" id="regCaptcha" placeholder="请输入图片中的验证码">
	</div>

	<div class="layui-form-item">
		<button class="layui-btn headButton" lay-filter="demo2" id="lgButton">登录</button>
	</div>

	<div class="layui-form-item">
		<a href="/forgetpwd" style="margin-left: 27%;" target="_black">忘记密码？</a>
	</div>
</div>

<script type="text/javascript" src="https://npmcdn.com/headroom.js@0.9.3/dist/headroom.min.js"></script>
<script>


    (function() {
	    new Headroom(document.querySelector("#page_top"), { //这里的nav-scroll改为你的导航栏的id或class
	        offset : 200, //  开始动作的位置
	            tolerance: 5, // scroll tolerance in px before state changes        
	        classes: {
	            initial: "animated",  // 当元素初始化后所设置的class
	            pinned: "slideUp", // 向上滚动时设置的class
	            unpinned: "slideDown" // 向下滚动时所设置的class
	        }
	    }).init();

	    new Headroom(document.querySelector(".go_top"), { //这里的nav-scroll改为你的导航栏的id或class
	        offset : 300, //  开始动作的位置
	            tolerance: 5, // scroll tolerance in px before state changes        
	        classes: {
	            initial: "gotop",  // 当元素初始化后所设置的class
	            pinned: "gotopUp", // 向上滚动时设置的class
	            unpinned: "gotopDown" // 向下滚动时所设置的class
	        }
	    }).init();

	    $(".go_top").on("click", function() {
			$('body,html').animate({
				scrollTop: 0
			}, 1000);
			return false;
	    });
    }());

    var topheight = $(window).height() - 980 + 'px';
 	console.log($(window).height());
    $(window).scroll(function(){
	// 滚动条距离顶部的距离 大于 200px时
		if($(window).scrollTop() >= 300){
			$(".gotop.gotopDown").css('top',topheight);
			$(".gotop.gotopUp").css('top',topheight);
		} else{
			$(".gotop.gotopDown").css('top',topheight);
			$(".gotop.gotopUp").css('top','-900px');
		}
	});

    var loginHtml = $('#loginHtml').html();
    $('#loginHtml').html('');

	//注册格式验证
	function regEvent(){
		var emailReg=/^[a-zA-Z0-9_-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/;
		var regularFormula  = /^[a-zA-Z0-9_]{6,10}$/; 
		if(!$('#regAcc').val().match(regularFormula)){
			layer.msg('帐号不能为空，且长度为6至10位的数字和英文字母');
			$('#regAcc').focus();
			return false;	
		}else if(!$('#regPass').val().match(regularFormula)){
			layer.msg('密码不能为空，且长度为6至10位的数字和英文字母');
			$('#regPass').focus();
			return false;
		}else if($('#regPass').val() != $('#regPass2').val()){
			layer.msg('两次密码不一样');
			$('#regPass2').focus();
			return false;
		}else if(!emailReg.test($('#regEmail').val())){
			layer.msg('email格式不正确');
			$('#regEmail').focus();
			return false;
		}

		$.ajax({
			url:'/register',
			async:true,
			cache:false,
			type:"POST",
			dataType:'json',
			data:{
				acc:$('#regAcc').val(),
				pass:$('#regPass').val(),
				email:$('#regEmail').val(),
				Verification:$('#regCaptcha').val()
			},
			success:function(data){
				layer.msg(data.msg);
			}
		});
	}

    layui.use('layer', function(){
		$('#logBtn').click(function(){
			var layer = layui.layer;
			layer.open({
				type:1
				,title:'登录'
				,area:['400px', '400px']
				,content:loginHtml
			});
		});

		$('#regBtn').click(function(){
			var layer = layui.layer;
			layer.open({
				type:1
				,title:'注册'
				,area:['400px', '500px']
				,content:'<div class="layui-form-item"><label class="layui-form-label">帐号</label><div class="layui-input-block"><input type="text" name="username" lay-verify="title" autocomplete="off" placeholder="请输入帐号" class="layui-input" id="regAcc"></div></div> <div class="layui-form-item"><label class=layui-form-label>密码</label><div class="layui-input-block"><input type=password name=password placeholder=请输入密码 autocomplete=off class=layui-input id="regPass"></div></div> <div class="layui-form-item"><label class=layui-form-label id="pass2Lab">验证密码</label><div class="layui-input-block"><input type=password name=password placeholder=请再次输入密码 autocomplete=off class=layui-input id="regPass2"></div></div><div class="layui-form-item"><label class="layui-form-label">邮箱</label><div class="layui-input-block"><input type="text" name="username" lay-verify="title" autocomplete="off" placeholder="请输入邮箱" class="layui-input" id="regEmail"></div></div><div class="layui-form-item"><img src="/creatPicture"  onclick="this.src=\'/creatPicture?\'+new Date().getTime();" width="200" height="40"><input type="text" id="regCaptcha" placeholder="请输入图片中的验证码"></div><div class="layui-form-item"><button class="layui-btn headButton" lay-submit="" lay-filter="demo2" id="regButton" onclick=regEvent()>注册</button></div>'
			});
		});


	});

	
</script>

<style type="text/css">
.animated {position: fixed;top: 0;left: 0;right: 0;transition: all 1s ease-in-out;}
.animated.slideDown {top: -100px;}
.animated.slideUp {top: 0;}

.gotop {position: fixed;top: -900px;right: 50px;transition: all 1s ease-in-out;}

</style>





<!--轮播-->

<div class="containmain" >	
<!--content-->
	<div class="row1">
		<div class="lunbo_div">
			<div id="myCarousel" class="carousel slide " data-ride="carousel">
	<!-- 轮播（Carousel）指标 -->
	<ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<li data-target="#myCarousel" data-slide-to="1"></li>
		<li data-target="#myCarousel" data-slide-to="2"></li>
	</ol>   
	<!-- 轮播（Carousel）项目 -->
	<div class="carousel-inner">
		<div class="item active">
			<img src="/static/imgs/img1.jpg" alt="First slide">
		</div>
		<div class="item">
			<img src="/static/imgs/img2.jpg" alt="Second slide">
		</div>
		<div class="item">
			<img src="/static/imgs/img3.jpg" alt="Third slide">
		</div>
	</div>
	<!-- 轮播（Carousel）导航 -->
	<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div> 
		</div>
		<ul class="ad_menu">
	     	<li>
	     		<img  src="/static/imgs/ad/1.jpg">
	     	</li>

	     	<li>
	     		<img  src="/static/imgs/ad/1.jpg">
	     	</li>
	    </ul>
		
	   
	    <ul class="ad_menu">
	     	<li>
	     		<img  src="/static/imgs/ad/1.jpg">
	     	</li>

	     	<li>
	     		<img  src="/static/imgs/ad/1.jpg">
	     	</li>
	    </ul>
	</div>

	<div class="row1">
		<div class="headicon">
			<span class="glyphicon glyphicon-book" style="color: rgb(0, 223, 255); font-size: 30px;"></span>
			<b>在线漫画</b>
			<div class="search_box">
	<form method="get" action="/search">
		<input type="text" placeholder="搜索漫画时可不要多字哦" class="form_ms" name='name'>
		<input type="submit" class="serch_buttom" value="">
	</form>
</div>
		</div>
		
		<div id="cmmain" class="ulstyle">
			<ul id="ccover" class="cmcover">
			 	
			</ul>
		</div> 
	</div>

	<div class="row1">
		<div class="headicon">
			<span class="glyphicon glyphicon-play-circle" style="color: rgb(194, 33, 189); font-size: 30px;"></span>
			<b>在线影视</b>
			<div class="search_box">
	<form method="get" action="/search_video">
		<input type="text" placeholder="搜索影片时可不要多字哦" class="form_ms" name='name'>
		<input type="submit" class="serch_buttom" value="">
	</form>
</div>
		</div>
		<div class="ulstyle">
			<ul class="vdcv" id="vdcv"></ul>
		</div>
	</div>
</div>	
<div class="footer"></div>
<script type="text/javascript">
$(document).ready(function(){
	load_comic();
	Load_Animations_Cover();
});
</script>
</body>
</html>