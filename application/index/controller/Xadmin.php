<?php
namespace app\index\controller;
use think\Db;
use think\View;
use \think\Request;
use \think\Config;

class Xadmin {
	public function index() {
		echo(new View) -> fetch('X-admin/index');
	}
}