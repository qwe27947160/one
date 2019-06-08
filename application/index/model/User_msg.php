<?php
namespace app\index\model;
use think\Model;


class User_msg extends Model {
	public static function Query($map) {
		return static::where($map) -> field('username, password') -> find();
	}

	public static function get_user($username) {
		return self::where(['username' => $user]) -> find();
	}
}