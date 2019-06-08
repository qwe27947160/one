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
		if (Session::get('time') < time()) {
			
		} else {
			$this->redirect('/user/login');
		}
	}

	public function index() {
		$user = input('post.user');
		$pass = input('post.pass');
		$user = User_msg::get_user($user);
		//print_r($user);
		if(!$user) {
			echo json_encode(array('rs' => '帐号错误'));
		} else if ($user->password != md5($pass)) {
			echo json_encode(array('rs' => '密码错误'));
		} else {
			Session::set('time', time() . 3600);
			$this->redirect('/user/admin');
		}
	}

	public function userAdmin() {
		echo (new View) -> fetch('/X-admin/index');
	}
}