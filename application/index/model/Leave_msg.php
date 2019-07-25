<?php
namespace app\index\model;
use think\Model;


class Leave_msg extends Model{
	/**  
	* 查询留言
	* @access public 
	* @param $arg1 留言type
	* @param $arg2 留言index 
	* @return array 返回类型
	*/ 
	public function queryLeaveMessage($arg1, $arg2) {
		return $this -> where(['type' => $arg1, 'index' => $arg2]) -> field('userName, msg, time') -> select();
	}
}