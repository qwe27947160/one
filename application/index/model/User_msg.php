<?php
namespace app\index\model;
use think\Model;

class User_msg extends Model {
	function loginquery($map) {
		return $this -> where($map) -> find();
	}
}