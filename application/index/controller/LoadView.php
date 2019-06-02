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

	public function comicChapter($name) {
		$imgPath = Db::table('comic') -> where('urlname', $name) -> find();
		$lastChapter = Db::table('chapter') -> where('ComicChapter', $imgPath['ComicChapter']) -> field('ChapterName') -> order('ID desc') -> limit(1) -> find();
		$queryChapter = Db::table('chapter') -> where('ComicChapter', $imgPath['ComicChapter']) -> order('ChapterName ASC') -> select();
		$comicChapterH5 = '';
		foreach ($queryChapter as $data) {
			$comicChapterH5 .= '<li><a href="/mobileComic/page/' . $data['ComicChapter'] . '/' . $data['ChapterPage'] . '" target="_self" title="' . $data['ChapterName'] . '">' . $data['ChapterName'] . '</a></li>';
		}
		echo (new View()) -> fetch('mobile/comicChatper', ['imgPath' => "'".$imgPath['cover']."'", 'title' => $imgPath['title'], 'lastChapter' => $lastChapter['ChapterName'], 'comicChapterH5' => $comicChapterH5]);
	}

	public function comicPage($chapterId, $pageId) {
		$map = array('Comicid' => $chapterId, 'ChapterPage' => $pageId);
		$queryComicPage = Db::table('page') -> where('ChapterPage', $pageId) -> field('Imgpath') -> select();
		$comicPgaeH5 = '';
		foreach ($queryComicPage as $data) {
			$comicPgaeH5 .= '<li><img data-original="' . $data['Imgpath'] . '" src="' . $data['Imgpath'] . '"></li>'
		}
		echo (new View()) -> fetch('mobile/comicPage', ['comicPgaeH5' => $comicPgaeH5]);	
	}
}
