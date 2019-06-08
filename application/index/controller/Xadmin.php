<?php
namespace app\index\controller;
use think\Db;
use think\View;
use \think\Request;
use \think\Config;
use think\Controller;
use think\Session;
use app\index\model\User_msg;
use app\index\model\Loginmsg;

class Xadmin extends Controller{
	protected $beforeActionList = [
        'aaabbb' =>  ['except'=>'validation']
    ];
	public function aaabbb() {
		//if( request()->action() == 'validation' ) return;
		if (Session::get('time') < time()) {
			$this->redirect('/user/login');
			return;
		} 
		Session::set('time', time() + 900);
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
			//写入登录人信息
			$request = Request::instance();
			$loginMsg = new Loginmsg(['user' => $user, 'ip' => $request->ip(), 'ua' => $request->header('user-agent'), 'time' => time()]);
			$loginMsg -> save();
			//返回前端 让前端重定义url
			Session::set('time', time() + 900);
			echo json_encode(array('code' => '1', 'rs' => '登录成功'));
		}
	}

	public function userAdmin() {
		
		echo (new View) -> fetch('/X-admin/index');
	}
}