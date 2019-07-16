<?php
namespace app\index\controller;
use \think\Controller;
use \think\Db;
use \think\View;
use \think\Request;
use \think\Config;
use \think\Session;
use app\index\model\Leave_Msg;

class UserLeaveMsg extends Controller {

	public function addVideoLeaveMessage() {
		$request = Request::instance();
		$addMsg = new Leave_msg([
			'type' => 2,
			'index' => input('post.id'),
			'msg' => input('post.msg'),
			'ip' => $request->ip(),
			'ua' => $request->header('user-agent')
		]);
		$addMsg -> save();
	}
}