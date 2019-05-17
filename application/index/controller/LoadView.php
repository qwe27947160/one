<?php 
namespace app\index\controller;
use think\View;
use think\Db;
use \think\Request;
use \think\Config;


class LoadView {
	public function forgetpwd(){
        echo (new View()) -> fetch('user/forgetpwd');
	}

	public function findPass() {
		$email = input('get.email');
		$nowTime = time();
		$dbResult = Db::table('user_msg') -> where('email', $email) -> field('find_exptime') -> find();

		if($nowTime > $dbResult['find_exptime']) {
			echo '此链接已经超过24小时，请重新发送';		
		}else {
			echo (new View()) -> fetch('user/findPass', ['email' => $email]);
		}
	}

	public function register() {
		echo (new View()) -> fetch('user/register');
	}

	public function login() {
		echo (new View()) -> fetch('user/login');
	}

	public function allcomic() {
		$result = Db::table('comic') -> select();
		$h5_statements = '';
		foreach ($result as $data) {
			$h5_statements .= '<li><a href=chapter/' . $data -> getData()["urlname"] . ' class=pic><img src=' .$data -> getData()["cover"] . ' alt=' . $data -> getData()["title"] . '></a><p class=cover><a href=chapter/' . $data -> getData()["urlname"] . ' class=pic2><span>' .  $data -> getData()["title"] . '</span></a></p></li>';
		}
		echo (new View()) -> fetch('comic/allcomic', ['h5_statements' => $h5_statements]);
	}
}
