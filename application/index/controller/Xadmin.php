<?php
namespace app\index\controller;
use think\Db;
use think\View;
use \think\Request;
use \think\Config;
use think\Controller;
use app\index\model\User_msg;


class Xadmin extends Controller{
	public function index() {
		$user = input('post.user');
		$pass = input('post.pass');
		$user = User_msg::get_user($user);
		//print_r($user);
		if(!$user) {
			echo json_encode(array('rs' => '帐号错误', 'code' => '0'));
		} else if ($user->password != md5($pass)) {
			echo json_encode(array('rs' => '密码错误', 'code' => '0'));
		} else {
			echo json_encode(array('rs' => '登录成功', 'code' => '1'));
		}
	}
}