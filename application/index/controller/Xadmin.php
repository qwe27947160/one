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
		$userModel = (new User_msg) -> loginQuery(['username' => $user]) -> getData();
		var_dump($userModel);
		
		/*
		if(!) {
			echo json_encode(array('rs' => '帐号错误'));
		} else if (!) {
			echo json_encode(array('rs' => '密码错误'));
		} else {
			echo json_encode(array('rs' => 'OK'));
		}
		*/
	}
}