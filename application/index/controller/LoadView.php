<?php 
namespace app\index\controller;
use think\View;
use think\Db;


class LoadView {
	public function forgetpwd(){
        echo (new View()) -> fetch('comic/forgetpwd');
	}

	public function findPass() {
		$email = input('get.email');
		$nowTime = time();
		$dbResult = Db::table('user_msg') -> where('email', $email) -> field('find_exptime') -> find();

		if($nowTime > $dbResult['find_exptime']) {
			echo '此链接已经超过24小时，请重新发送';		
		}else {
			echo (new View()) -> fetch('comic/findPass', ['email' => $email]);
		}
	}
}
