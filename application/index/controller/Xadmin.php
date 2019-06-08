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
			$userModel = (new User_msg) -> loginQuery(['username' => $user]);
			if($userModel['username'] != $user) {
				echo json_encode(array('rs' => '帐号错误'));
			} else if ($userModel['password'] != $pass) {
				echo json_encode(array('rs' => '密码错误'));
			} else {
				echo json_encode(array('rs' => 'OK'));
			}
		} catch(\Exception $e) {

		}
	}
}