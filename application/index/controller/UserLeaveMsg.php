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
		$addMsg = new Leave_msg;
		$addMsg -> data([
			'userName' => input('post.userName'),
			'type' => 2,
			'index' => input('post.id'),
			'msg' => input('post.msg'),
			'ip' => $request->ip(),
			'ua' => $request->header('user-agent')
		]);
		$result = $addMsg -> save();
		if ($result == 1) {

		} else {
			echo('发表失败');
		}
	}

	public function queryLeaveMessage() {

	}
}