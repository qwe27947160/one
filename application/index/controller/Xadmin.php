<?php
namespace app\index\controller;
use think\Db;
use think\View;
use \think\Request;
use \think\Config;

class Xadmin extends Controller{
	public function index() {
		$view = new View();
		$this -> redirect('X-admin/index');
		//return (new View) -> fetch('X-admin/index');
	}
}