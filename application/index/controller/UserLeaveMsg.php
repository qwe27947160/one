<?php
namespace app\index\controller;
use \think\Controller;
use \think\Db;
use \think\View;
use \think\Request;
use \think\Config;
use \think\Session;
use app\index\model\Leave_msg;

class UserLeaveMsg extends Controller {

	public function addVideoLeaveMessage() {
		$request = Request::instance();
		$addMsg = new Leave_msg([
			'userName' => input('post.userName'),
			'type' => 2,
			'index' => input('post.id'),
			'msg' => input('post.msg'),
			'ip' => $request->ip(),
			'ua' => $request->header('user-agent')
		]);
		$result = $addMsg -> save();
		echo($result);
	}
}