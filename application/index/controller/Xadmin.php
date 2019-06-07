<?php
namespace app\index\controller;
use think\Db;
use think\View;
use \think\Request;
use \think\Config;
use think\Controller;

class Xadmin extends Controller{
	public function index() {
		$user = input('post.user');
		$pass = input('post.pass');
		if(!Db::table('user_msg') -> where('username', $user) -> find()) {
			echo json_encode(array('rs' => '帐号错误'));
		} else if (!Db::table('user_msg') -> where('password', md5($pass)) -> find()) {
			echo json_encode(array('rs' => '密码错误'));
		} else {
			echo json_encode(array('rs' => 'OK'));
		}
	}
}