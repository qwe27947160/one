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

	public function addLeaveMessage() {
		$request = Request::instance();
		$addMsg = new Leave_msg;
		$addMsg -> data([
			'userName' => input('post.userName'),
			'type' => input('post.type1'),
			'index' => input('post.id'),
			'msg' => input('post.msg'),
			'ip' => $request->ip(),
			'ua' => $request->header('user-agent')
		]);
		$result = $addMsg -> save();
		if ($result == 1) {
			$rsQuery = (new Leave_msg) -> queryLeaveMessage(input('post.type1'),input('post.id'));
			$L = array();
			foreach ($rsQuery as $data) {
				$data = $data -> getData();
				array_push($L, $data);
			}
			echo json_encode($L);
		} else {
			echo('发表失败');
		}
	}

	public function firstquery() {
		$list($rsQuery, $sum) = (new Leave_msg) -> queryLeaveMessage(input('post.type1'),input('post.id'));
		var_dump($sum);
		$L = array();
			foreach ($rsQuery as $data) {
				$data = $data -> getData();
				array_push($L, $data);
			}
		echo json_encode($L);
	}
}