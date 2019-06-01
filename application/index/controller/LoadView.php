<?php 
namespace app\index\controller;
use think\View;
use think\Db;
use \think\Request;
use \think\Config;



class LoadView {
	public function forgetpwd(){
        echo (new View()) -> fetch('user/forgetpwd');
	}

	public function findPass() {
		$email = input('get.email');
		$nowTime = time();
		$dbResult = Db::table('user_msg') -> where('email', $email) -> field('find_exptime') -> find();

		if($nowTime > $dbResult['find_exptime']) {
			echo '此链接已经超过24小时，请重新发送';		
		}else {
			echo (new View()) -> fetch('user/findPass', ['email' => $email]);
		}
	}

	public function register() {
		echo (new View()) -> fetch('user/register');
	}

	public function login() {
		echo (new View()) -> fetch('user/login');
	}

	public function allcomic() {
		$result = Db::table('comic') -> select();
		$h5_statements = '';
		foreach ($result as $data) {
			$h5_statements .= '<li><a href=chapter/' . $data["urlname"] . ' class=pic><img src="' . $data["cover"] . '" alt=' . $data["title"] . '></a><p class=cover><a href=chapter/' . $data["urlname"] . ' class=pic2><span>' .  $data["title"] . '</span></a></p></li>';
		}
		echo (new View()) -> fetch('comic/allcomic', ['h5_statements' => $h5_statements]);
	}

	public function allvideo() {
		$result = Db::table('animationscover') -> select();
		$h5_statements = '';
		foreach ($result as $data) {
			$cotdir = Db::table('animationsdir')-> where('cvdirid',$data["ID"]) -> count('cvdirid');
			$h5_statements .= '<ul class=vdcv id=vdcv><li class=vdcvli><a data-pjax href=' . $data["src"] . ' title=' . $data["title"] . ' target=_self class=vdcvimg><img class=vdcvloading data-original=' .  $data["cover"] . 'alt=' . $data["title"] . 'style=display:inline src=' . $data["cover"] . '><span class=vdcvmask style=opacity:0;><i class=glyphicon glyphicon-play-circle glyphiconL></i></span></a><div class=vdcvinfo><a data-pjax href=' . $data["src"] . '>' . $data["title"] . '</a><p><span class=vdcvf1>更新至' . $cotdir . '集</span></p></div></li></ul>';
		}
		echo (new View()) -> fetch('comic/allvideo', ['h5_statements' => $h5_statements]);
	}

	public function comicChapter() {
		var_dump(input('post.name'));
		$imgPath = Db::table('comic') -> where('urlname', input('post.name')) -> select();
		var_dump($imgPath);
		//echo (new View()) -> fetch('mobile/comicChatper');
	}
}
