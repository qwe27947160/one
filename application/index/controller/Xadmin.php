<?php
namespace app\index\controller;
use think\Db;
use think\View;
use \think\Request;
use \think\Config;
use think\Controller;

class Xadmin extends Controller{
	public function index() {
		$view = new View();
		redirect('News/category')->remember();
		//return (new View) -> fetch('X-admin/index');
	}

	public function login() {
		echo (new View()) -> fetch('X-admin/index');
	}
}