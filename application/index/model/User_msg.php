<?php
namespace app\index\model;
use think\Model;
use \think\Request;
use \think\Config;

class User_msg extends Model {
	function loginQuery($map) {
		return $this -> where($map) -> find();
	}
}