<?php 
namespace app\index\controller;
use think\View;
use think\Db;
use \think\Request;
use \think\Config;
use \think\Session;
use \think\Controller;

class LoadView extends Controller {
	protected $beforeActionList = [
        'first'
    ];

    protected function first() {
        if (!Session::get('userName')) {
            \think\View::share('islogin',0);
        } else {
            Session::set('time', time() + 900);
            \think\View::share(['islogin' => 1, 'username' => Session::get('userName')]);
        }
        $musicResult = Db::table('music')  -> select();
        $musicMsg = '';
        foreach ($musicResult as $data) {
            $musicMsg .= '{name:"' . $data['name'] . '",artist:"' . $data['artist'] . '",url:"' . $data['path'] . '",cover:"' . $data['cover'] . '"},';
        }
        \think\View::share(['musicMsg' => $musicMsg]);
    }

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
		$queryComicPage = Db::table('page') -> where($map) -> field('Imgpath') -> order('Imgpath') -> select();
		$comicPgaeH5 = '';
		foreach ($queryComicPage as $data) {
			$comicPgaeH5 .= '<li><img data-original="' . $data['Imgpath'] . '"></li>';
		}
		echo (new View()) -> fetch('mobile/comicPage', ['comicPgaeH5' => $comicPgaeH5]);	
	}

	public function videoChapter($name) {
		$imgPath = Db::table('animationscover') -> where('src', '/video/'.$name) -> find();
		$lastChapter = Db::table('animationsdir') -> where('cvdirid', $imgPath['ID']) -> field('dirname') -> order('dirbluesid desc') ->limit(1) -> find();
		$queryChapter = Db::table('animationsdir') -> where('cvdirid', $imgPath['ID']) -> order('dirbluesid ASC') -> select();
		$videoChapterH5 = '';
		foreach ($queryChapter as $data) {
			$videoChapterH5 .= '<li><a href="/mobilevideo/page/' . $data['cvdirid'] . '/' . $data['dirbluesid'] . '" target="_self" title="' . $data['dirname'] . '">' . $data['dirname'] . '</a></li>';
		}
		echo(new View()) -> fetch('mobile/videoChapter', ['imgPath' => $imgPath['cover'], 'title' => $imgPath['title'], 'lastChapter' => $lastChapter['dirname'], 'p' => $imgPath['introduction'], 'videoChapterH5' => $videoChapterH5]);
	}

	public function videoPage($chapter, $page) {
		$imgPath = Db::table('animationscover') -> where('ID', $chapter) -> find();
		$map = array('cvdirid' => $chapter, 'dirbluesid' => $page);
    	$src = Db::table('animationsdir') -> where($map) ->field('videopath, dirname') -> find(); 
		$queryChapter = Db::table('animationsdir') -> where('cvdirid', $chapter) -> order('dirbluesid ASC') -> select();
		$videoChapterH5 = '';
		foreach ($queryChapter as $data) {
			$videoChapterH5 .= '<li><a href="/mobilevideo/page/' . $data['cvdirid'] . '/' . $data['dirbluesid'] . '" target="_self" title="' . $data['dirname'] . '">' . $data['dirname'] . '</a></li>';
		}
		echo(new View()) -> fetch('mobile/videoPage', ['p' => $imgPath['introduction'], 'videoChapterH5' => $videoChapterH5, 'src' => $src['videopath'], 'title' => $imgPath['title'], 'name' => $src['dirname']]);
	}

	public function allmobilecomic() {
		$comicResult = Db::table('comic') -> select();
		$comicH5 = '';
		foreach ($comicResult as $data) {
		    $lastChapter = Db::table('chapter') -> where('ComicChapter', $data['ComicChapter']) -> field('ChapterName') -> order('ID desc') -> limit(1) -> find();

		    $comicH5 .= '<li class="comicItem"><a href="/mobile/comicChapter/' . $data['urlname'] . '" class="comicLink" title="' . $data['title'] . '"><div class="itemPic" data-original="' . $data['cover'] . '" style="background-image:url(\'' . $data['cover'] . '\');"><div class="videoDuration">更新到' . $lastChapter['ChapterName'] . '</div></div><div class="videoCon"><h2 class="videotit ellipsis1" style="text-align:center;">'. $data['title'] . '</h2></div></a></li>';
		}
		echo(new View()) -> fetch('mobile/all', ['H5' => $comicH5, 'name' => '全部在线漫画']);
	}

	public function allMobileVideo() {
	    $videoH5 = '';
        $videoResult = Db::table('animationscover') -> select();
        foreach ($videoResult as $data) {
            $lastChapter = Db::table('animationsdir') -> where('cvdirid', $data['ID']) -> field('dirname') -> order('dirbluesid desc') -> limit(1) -> find();
            $videoH5 .= '<li class="comicItem"><a href="/mobile' . $data['src'] . '" class="comicLink" title="' . $data['title'] . '"><div class="itemPic" data-original="' . $data['cover'] . '" style="background-image:url(\'' . $data['cover'] . '\');"><div class="videoDuration">更新到' . $lastChapter['dirname'] . '</div></div><div class="videoCon"><h2 class="videotit ellipsis1" style="text-align:center;">'. $data['title'] . '</h2></div></a></li>';
        }
        echo(new View()) -> fetch('mobile/all', ['H5' => $videoH5, 'name' => '全部在线动画']);
	}
}
