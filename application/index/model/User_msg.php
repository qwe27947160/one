<?php
namespace app\index\model;
use think\Model;


class User_msg extends Model {
	public static function get_user($user) {
		return self::whereOr(['username' => $user, 'email' => $user]) -> find();
	}
}