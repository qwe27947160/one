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
		
		try {
			$user = User_msg::where(['username' => $user])->find();
			if($user == 'NULL') {
				echo json_encode(array('rs' => '帐号错误'));
			} else if ($user->getData()['password'] != $pass) {
				echo json_encode(array('rs' => '密码错误'));
			} else {
				echo json_encode(array('rs' => 'OK'));
			}
		} catch(\Exception $e) {
			echo $e;
		}
	}
}