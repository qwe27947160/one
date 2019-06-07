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
		}
	}
}