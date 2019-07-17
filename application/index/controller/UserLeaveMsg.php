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
			$ss = $this -> queryLeaveMessage(input('post.type1'),input('post.id'));
			print($ss);
		} else {
			echo('发表失败');
		}
	}

	/**  
	* 查询留言
	* @access public 
	* @param $arg1 留言type
	* @param $arg2 留言index 
	* @return array 返回类型
	*/ 
	public function queryLeaveMessage($arg1, $arg2) {
		$queryMsg = new Leave_msg;
		return $qyeryMsg -> where(['type' => $arg1, 'index' => $arg2]) -> select();
	}
}