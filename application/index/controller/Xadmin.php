<?php
namespace app\index\controller;
use think\Db;
use think\View;
use \think\Request;
use \think\Config;

class Xadmin {
	public function index() {
		return (new View) -> fetch('X-admin/index');
	}
}