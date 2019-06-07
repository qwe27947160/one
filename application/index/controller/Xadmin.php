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
		echo (new View()) -> fetch('X-admin/index');
	}

	public function login() {

	}	
}