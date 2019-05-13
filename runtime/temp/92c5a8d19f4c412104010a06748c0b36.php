<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:70:"/www/web/migu666/public/../application/index/view/comic/forgetpwd.html";i:1557119585;s:56:"/www/web/migu666/application/index/view/public/meta.html";i:1557076651;s:60:"/www/web/migu666/application/index/view/public/css-link.html";i:1556785893;s:59:"/www/web/migu666/application/index/view/public/js-link.html";i:1556785851;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />	
<title>米谷 米谷</title>
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



<link href="/static/css/forgetpwd.css" rel="stylesheet" type="text/css" media="all" />
<!-- JS-LINK -->
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
<body class="user_body"> 
<div class="container">
	<div class="row">
		<div class="user_form modal-dialog clearfix">
			<div class="user_title">
				<h2 class="text_h2">找回密码</h2>
			</div>
			<div class="col-md-10 col-md-offset-1">
				<div class="col-md-12 mt20">
					<form class="form-horizontal" onsubmit="return false;">
						<div class="form-group mt20">
							<span class="col-md-3 control-label hidden-xs">您的Email:</span>
							<div class="col-md-8 col-sm-12 col-xs-12">
								<input type="text"  class="form-control" placeholder="注册使用的邮箱"  id="forgetEmail">
							</div>
						</div>

						<div class="form-group">
							<span class="col-md-3 control-label hidden-xs">验证码:</span>
							<div class="col-md-4 col-sm-4 col-xs-6">
								<input type="text" id="forgetCaptcha" class="form-control txt" placeholder="验证码" >
							</div>

							<div class="col-md-3 col-sm-4 col-xs-2">
								<img src="/creatPicture"  onclick="this.src='/creatPicture?'+new Date().getTime();" >
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-3 hidden-xs"></div>
							<div class="col-md-8 col-xs-12">
								<button type="submit" class="btn btn-success btn-block" id="submit">找回</button>
							</div>
						</div>
					</form>
				</div>	
			</div>
		</div>	
	</div>
</div>
</body>
<script type="text/javascript">
	layui.use('layer', function(){
		var layer = layui.layer;
		$('#submit').click(function(){
			var myReg=/^[a-zA-Z0-9_-]+@([a-zA-Z0-9]+\.)+(com|cn|net|org)$/;
			if(!myReg.test($('#forgetEmail').val())){
				layer.msg("邮箱格式不对!");
		　　　　return false;
			}
			
			$.ajax({
				url:'/findPassword',
				async:true,
				cache:false,
				type:"POST",
				dataType:'json',
				data:{
					email:$('#forgetEmail').val(),
					VerificationCode:$('#forgetCaptcha').val()
				},
				success:function(data){
					layer.msg(data.msg);
				}
			});
		});
	});	
</script>	
</html>