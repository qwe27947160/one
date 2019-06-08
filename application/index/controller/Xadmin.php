<?php
namespace app\index\controller;
use think\Db;
use think\View;
use \think\Request;
use \think\Config;
use think\Controller;
use think\Session;
use app\index\model\User_msg;


class Xadmin extends Controller{
	
	public function _initialize() {
		echo(request()->action());
		return;
		if (Session::get('time') < time()) {
			$this->redirect('/user/login');
		} 
	}

	public function validation() {
		$user = input('post.user');
		$pass = input('post.pass');
		$user = User_msg::get_user($user);
		//print_r($user);
		if(!$user) {
			echo json_encode(array('code' => '0', 'rs' => '帐号错误'));
		} else if ($user->password != md5($pass)) {
			echo json_encode(array('code' => '0', 'rs' => '密码错误'));
		} else {
			Session::set('time', time() + 30);
			echo json_encode(array('code' => '1', 'rs' => '登录成功'));
		}
	}

	public function userAdmin() {
		echo (new View) -> fetch('/X-admin/index');
	}
}