<?php
namespace app\index\controller;
use \think\Db;
use \think\View;
use \think\Request;
use \think\Config;
use \think\Controller;
use \think\Session;
use app\index\model\User_msg;
use app\index\model\Loginmsg;
use app\index\model\Watch_record;


class Xadmin extends Controller{
	protected $beforeActionList = [
        'first' =>  ['except'=>'validation']
    ];
	public function first() {
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
		//(判断密码错误30分钟内超过3次，禁止继续登录)
		if(Loginmsg::where(['user' => $user ,'state' => 1,'time' => ['exp','> TIMESTAMPADD(MINUTE,-30,CURRENT_TIMESTAMP())']]) -> count() > 3){
			echo json_encode(array('code' => '0', 'rs' => '此账号密码30分钟内错误3次，禁止登录'));
			return;
		}

		$userQyery = User_msg::get_user($user);
		$request = Request::instance();
		$userMsg = array('user' => $user, 'ip' => $request->ip(), 'ua' => $request->header('user-agent'));
		$loginMsg = new Loginmsg($userMsg);
		if(!$userQyery) {
			$loginMsg -> state = 0;
			echo json_encode(array('code' => '0', 'rs' => '帐号错误'));
		} else if ($userQyery->password != md5($pass)) {
			$loginMsg -> state = 1;
			echo json_encode(array('code' => '0', 'rs' => '密码错误'));
		} else {
			//写入登录人信息
			$loginMsg -> state = 2;
			//返回前端 让前端重定义url
			Session::set('time', time() + 900);
			Session::set('userName', $user);
			echo json_encode(array('code' => '1', 'rs' => '登录成功'));
		}
		$loginMsg -> save($userMsg);
	}

	public function userAdmin() {
		echo (new View) -> fetch('/X-admin/index',['userName' => Session::get('userName')]);
	}

	public function exit() {
		Session::delete('time');
		Session::delete('userName');
		$this->redirect('/');
	}

	public function comicRecord($name) {
		$result = (new Watch_record) -> where(['status' => '1', 'user_name' => $name]) -> field('cover') -> select();
		foreach ($result as $data) {
			$data = $data -> getData();
			var_dump($data);
		}
	}
}