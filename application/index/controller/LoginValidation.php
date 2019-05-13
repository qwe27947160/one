<?php
namespace app\index\controller;
use think\Session;
use think\Db;
use L\Smtp;


class LoginValidation{
	public function creatPicture(){
		//1.创建黑色画布
		$image = imagecreatetruecolor(100, 30);
		 
		//2.为画布定义(背景)颜色
		$bgcolor = imagecolorallocate($image, 255, 255, 255);
		 
		//3.填充颜色
		imagefill($image, 0, 0, $bgcolor);
		 
		// 4.设置验证码内容
		 
		//4.1 定义验证码的内容
		$content = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		 
		//4.1 创建一个变量存储产生的验证码数据，便于用户提交核对
		$captcha = "";
		for ($i = 0; $i < 4; $i++) {
		    // 字体大小
		    $fontsize = 10;
		    // 字体颜色
		    $fontcolor = imagecolorallocate($image, mt_rand(0, 120), mt_rand(0, 120), mt_rand(0, 120));
		    // 设置字体内容
		    $fontcontent = substr($content, mt_rand(0, strlen($content)), 1);
		    $captcha .= $fontcontent;
		    // 显示的坐标
		    $x = ($i * 100 / 4) + mt_rand(5, 10);
		    $y = mt_rand(5, 10);
		    // 填充内容到画布中
		    imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor);
		}
		Session::set('captcha', $captcha);
		//4.3 设置背景干扰元素
		for ($i = 0; $i < 200; $i++) {
		    $pointcolor = imagecolorallocate($image, mt_rand(50, 200), mt_rand(50, 200), mt_rand(50, 200));
		    imagesetpixel($image, mt_rand(1, 99), mt_rand(1, 29), $pointcolor);
		}
		 
		//4.4 设置干扰线
		for ($i = 0; $i < 3; $i++) {
		    $linecolor = imagecolorallocate($image, mt_rand(50, 200), mt_rand(50, 200), mt_rand(50, 200));
		    imageline($image, mt_rand(1, 99), mt_rand(1, 29), mt_rand(1, 99), mt_rand(1, 29), $linecolor);
		}
		 
		//5.向浏览器输出图片头信息
		header('content-type:image/png');
		 
		//6.输出图片到浏览器
		imagepng($image);
		
		//7.销毁图片
		imagedestroy($image); 
	}

	public function register(){
		//1. 获取到用户提交的验证码
		$Verification = input('post.Verification');
		//2. 将session中的验证码和用户提交的验证码进行核对,当成功时提示验证码正确，并销毁之前的session值,不成功则重新提交
		if(strtolower(Session::get('captcha')) == strtolower($Verification)){
		    $regAccount = input('post.acc');
		    $regPass = md5(input('post.pass'));
		    $regEmail = input('post.email');
		    $regtime = time();
		    $token = md5($regAccount.$regPass.$regtime);
		    $token_exptime = time()+60*60*24;
		    $querySameName =  Db::table('user_msg') -> where(['username' => $regAccount ]) -> field('username') -> find();
		    if($querySameName) {
		    	echo json_encode(array("msg" => '此账号已被注册'));
		    	exit;
		    }

		    $result = Db::table('user_msg') -> where(['email' => $regEmail ]) -> field('email' ) -> find();
		    if($result) {
		    	echo json_encode(array("msg" => '此邮箱已经注册'));
		    	exit;
		    }
		    try{
		    	$data = ['username' => $regAccount, 
		    	'password' => $regPass, 
		    	'email' => $regEmail, 
		    	'token' => $token,
		    	'token_exptime' => $token_exptime,
		    	'regtime' => $regtime
		    	];
		    	$insertResult = Db::table('user_msg') -> insert($data);
		    	if($insertResult = 1){
		    		$result = $this -> activationEmail($regEmail, $regAccount, $token, '1');
		    		if($result){
						echo json_encode(array("msg" => '注册成功，请到邮箱激活账号'));
						Session::set('captcha', '');
					}else{
						echo json_encode(array("msg" => '邮件发送失败'));
					}
		    	}
		    }catch(\Exception $e){
		    	 echo '数据库写入有误'.$e;
		    }
		}else{
		    echo json_encode(array("msg" => '验证码错误'));
		}
	} 

	public function active(){
		$verify = stripslashes(trim($_GET['verify'])); 
		$nowtime = time(); 
		$result = Db::table('user_msg') -> where(['status' => 0 ,'token' => $verify]) -> field('id ,token_exptime') -> find();
		if($result){ 
		    if($nowtime>$result['token_exptime']){ //24hour 
		        $msg = '您的激活有效期已过，请登录您的帐号重新发送激活邮件.'; 
		    }else{ 
		        //mysql_query("update t_user set status=1 where id=".$row['id']); 
		        $updateResult = Db::table('user_msg') -> where('id' ,$result['id']) -> update(['status' => 1]);
		        if($updateResult == 0){
		        	return;
		        } 
		        $msg = '激活成功！'; 
		    } 
		}else { 
		    $msg = '已经激活过或者验证码有误';     
		} 
		echo $msg; 
	}

	public function activationEmail($regEmail, $regAccount, $token, $sendLogo){
		$smtpserver     = "ssl://smtp.163.com"; //SMTP服务器
	    $smtpserverport = "465"; //SMTP服务器端口
	    $smtpusermail   = "13662231744@163.com"; //SMTP服务器的用户邮箱
	    $smtpemailto    = $regEmail;
	    $smtpuser       = "13662231744@163.com"; //SMTP服务器的用户帐号
	    $smtppass       = "QQ1234"; //SMTP服务器的用户密码
	
	    if($sendLogo == '1'){
	    	$mailsubject    = "用户帐号激活"; //邮件主题
	    	$mailbody = "你好".$regAccount."：<br/>感谢您在我站注册了新帐号。<br/>请点击链接激活您的帐号。<br/> <a href=http://". $_SERVER['HTTP_HOST']."/active?verify=".$token." target= '_blank'>http://".$_SERVER['HTTP_HOST']."/active?verify=".$token."</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。"; //邮件内容
	    }else if($sendLogo == '2'){
	    	$mailsubject    = "用户密码找回"; //邮件主题
	    	$mailbody = "你好".$regAccount."：<<br/>请点击以下链接找回密码<br/> <a href=http://". $_SERVER['HTTP_HOST']."/findPass?email=".$regEmail." target= '_blank'>http://".$_SERVER['HTTP_HOST']."/findPass?email=".$regEmail."</a><br/> 如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。"; 
	    }

	    $mailsubject    = "=?UTF-8?B?" . base64_encode($mailsubject) . "?="; //防止乱码
	    $mailtype       = "HTML"; //邮件格式（HTML/TXT）,TXT为文本邮件. 139邮箱的短信提醒要设置为HTML才正常
	    ##########################################
	    $smtp           = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass); //这里面的一个true是表示使用身份验证,否则不使用身份验证.
	    $smtp->debug    = FALSE; //是否显示发送的调试信息
	    $result = $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
	    return $result;
	}


	public function findPassword(){
		$Verification = input('post.VerificationCode');
		$email = input('post.email');
		$token_exptime = time()+60*60*24;
		if(strtolower(Session::get('captcha')) == strtolower($Verification)){
			$res = Db::table('user_msg') -> where(['email' => $email, 'status' => '1']) -> find();
			if(!$res) {
				echo json_encode(array("msg" => '邮箱未激活'));
				exit;
			}
			$result = Db::table('user_msg') -> where(['email' => $email]) -> find();
			if(!$result) {
				echo json_encode(array("msg" => '此邮箱未注册'));
				exit;
			}else {
				$updateResult = Db::table('user_msg') -> where('email' ,$email) -> update(['find_exptime' => $token_exptime]);
				$result = $this -> activationEmail($email, $email, $token_exptime, '2');
				if($result) {
					echo json_encode(array("msg" => '邮件发送成功'));
					Session::set('captcha', '');
				}else { 
					echo json_encode(array("msg" => '邮件发送失败'));
				}
			}
		}else {
			echo json_encode(array("msg" => '验证码错误'));
		}
	}

	public function resetPassword() {
		$email = input('post.email');
		$pass = input('post.passAgain');
		try {
			$sqlResult = Db::table('user_msg') -> where('email' ,$email) -> update(['password' => md5($pass)]);
			if($sqlResult) {
				echo json_encode(array("msg" => '密码修改成功'));
			}else {
				echo json_encode(array("msg" => '密码修改失败'));
			}
		}catch(\Exception $e) {
		    	 echo '数据库操作有误'.$e;
		}
	}
}