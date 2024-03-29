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
		$L = array();
		$page;
		if(input('post.page') == 0) {
			$page = 0;
		} else {
			$page = input('post.page') - 1;
		}

		
		list($rsQuery, $sum) = (new Leave_msg) -> queryLeaveMessage(input('post.type1'), input('post.id'), $page, 5);
		$L['varpage'] = $page;
		$L['queryPage'] = input('post.page');
		$L['msgSum'] = $sum;
		$L['msgData'] = array();
			foreach ($rsQuery as $data) {
				$data = $data -> getData();
				array_push($L['msgData'], $data);
			}
		echo json_encode($L);
	}
}