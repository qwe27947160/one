<?php
namespace app\index\controller;
use app\index\model\Comic;
use app\index\model\Chapter;
use app\index\model\Animationscover;
use app\index\model\Animationsdir;
use app\index\model\Animationspath;
use \think\Controller;
use \think\Db;
use \think\View;
use \think\Request;
use \think\Config;
use \think\Session;
class Ni extends Controller
{
    protected $beforeActionList = [
        'first'
    ];

    protected function first() {
        echo Session::get('userName');
        if (!Session::get('uesrName')) {
            \think\View::share('islogin',0);
            return;
        } 
        Session::set('time', time() + 900);
        \think\View::share('islogin',1);
    }

    public function index() {
        //$this->first();
        $host = $_SERVER['HTTP_HOST'];
        preg_match('/(.*\.)?\w+\.\w+$/', $host, $matches);
    	$view = new View();
        if($matches[1] == 'dm.') {
            echo $view->fetch('comic/index');
        } else {
            try {
                $comicH5 = '';
                $comicResult = Db::table('comic')  -> order('rand()') -> limit(6) ->select();
                foreach ($comicResult as $data) {
                    $lastChapter = Db::table('chapter') -> where('ComicChapter', $data['ComicChapter']) -> field('ChapterName') -> order('ID desc') -> limit(1) -> find();

                    $comicH5 .= '<li class="comicItem"><a href="/mobile/comicChapter/' . $data['urlname'] . '" class="comicLink" title="' . $data['title'] . '"><div class="itemPic" data-original="' . $data['cover'] . '" style="background-image:url(\'' . $data['cover'] . '\');"><div class="videoDuration">更新到' . $lastChapter['ChapterName'] . '</div></div><div class="videoCon"><h2 class="videotit ellipsis1" style="text-align:center;">'. $data['title'] . '</h2></div></a></li>';
                }
                $videoH5 = '';
                $videoResult = Db::table('animationscover') -> order('rand()') -> limit (6) -> select();
                foreach ($videoResult as $data) {
                    $lastChapter = Db::table('animationsdir') -> where('cvdirid', $data['ID']) -> field('dirname') -> order('dirbluesid desc') -> limit(1) -> find();
                    $videoH5 .= '<li class="comicItem"><a href="/mobile' . $data['src'] . '" class="comicLink" title="' . $data['title'] . '"><div class="itemPic" data-original="' . $data['cover'] . '" style="background-image:url(\'' . $data['cover'] . '\');"><div class="videoDuration">更新到' . $lastChapter['dirname'] . '</div></div><div class="videoCon"><h2 class="videotit ellipsis1" style="text-align:center;">'. $data['title'] . '</h2></div></a></li>';
                }

                $view->assign(['comicH5' => $comicH5, 'videoH5' => $videoH5]);
                echo $view->fetch('mobile/main');
            } catch(\Exception $e){
                echo '数据库操作有误'.$e;
            }    
            
        }
    }

    public function load_chapter($name) {
        $view = new View();
        $view->assign('name',$name);
        echo $view->fetch('comic/chapter');
    }

    public function load_comic() {
    	$results = (new Comic)  -> order('rand()') -> limit(12) ->select();
        $L = array();
    	foreach ($results as $data){
            $data = $data -> getData();
            array_push($L,array("cd" => $data["ComicChapter"], "cn" => $data["urlname"],"cv" => $data["cover"] ,"ti" => $data["title"]));
    	}
        echo json_encode($L);
    }    

    public function query_chapter() {
        $Qychapter = isset($_POST['qy'])? $_POST['qy'] : ''; 
        $query_comic = (new Comic) -> where('urlname',$Qychapter) ->field('ComicChapter') ->find();
        $map['ComicChapter'] = $query_comic->getData('ComicChapter');
        $query_chapter = (new Comic) -> LoadChapter($map)  -> order('ChapterName') ->select();
        $L = array();
     
        foreach($query_chapter as $data){
            $data = $data -> getData();
            array_push($L,array("id" => $data["ComicChapter"] ,"pagenum" => $data["ChapterPage"] ,"pn" => $data["ChapterName"]));
        }
        echo json_encode($L);
        
    }

    public function load_page($comicid ,$pagenum) {
    	return view('comic/page',['comicid' => $comicid ,'pagenum' => $pagenum]);
    }

    public function query_page(){
    	$comicid = isset($_POST['qy1'])? $_POST['qy1'] : '';
    	$pagenum = isset($_POST['qy2'])? $_POST['qy2'] : '';
        $map['ChapterPage'] = $pagenum;
        $map['Comicid'] = $comicid;
        $querypg = (new Chapter)->Loadpage($map)->  select();
        $L = array();
        foreach($querypg as $data){
            $data = $data -> getData();
            array_push($L,array("ad" => $data["Imgpath"] ));
        }
        echo json_encode($L);
    }

    public function search() {
        $SearchName = isset($_GET['name'])? $_GET['name'] : '';
        $Test = new \L\Font();
        // 简体转繁体
        $fanti = $Test->c2t($SearchName);
        // 繁体转简体
        $jianti = $Test->t2c($SearchName);  
        $where['title'] = array('like',array('%'.$SearchName.'%' ,'%'.$fanti.'%' ,'%'.$jianti.'%' ) ,'OR');
        $SearchResult =  (new Comic)->where($where)->select();
        //var_dump($SearchResult);
        $h5_statements = ' ';
        $Serch_Msg = ' ';
    	if(empty($SearchResult)){
    		$RandResult = (new Comic) -> order('rand()') -> limit(4) -> select();
    		foreach ($RandResult as $data) {
                $data = $data -> getData();
    			$h5_statements .= '<ul id="ccover" class="cmcover"><li><a href=chapter/' . $data["urlname"] . ' class=pic><img src="' .$data["cover"] . '" alt=' . $data["title"] . '></a><p class=cover><a href=chapter/' . $data["urlname"] . ' class=pic2><span>' .  $data["title"] . '</span></a></p></li></ul>';
    			$Serch_Msg = '<h3 class=serach_font>找不到您需要的动漫，为您推荐下面的动漫:</h3>';
    		}
    	}else{
    		foreach ($SearchResult as $data) {
    			$data = $data -> getData();
    			$h5_statements .= '<ul id="ccover" class="cmcover"><li><a href=chapter/' . $data["urlname"] . ' class=pic><img src="' .$data["cover"] . '" alt=' . $data["title"] . '></a><p class=cover><a href=chapter/' . $data["urlname"] . ' class=pic2><span>' .  $data["title"] . '</span></a></p></li></ul>';

    			$Serch_Msg = '<h3 class=serach_font>为您找到如下动漫:</h3>';
    		}
    	}
    	$view = new View();
		$view->assign(['msg' => $Serch_Msg, 'empty' => $h5_statements]);
		echo $view->fetch('comic/search');
    }

    public function Load_Animations_Cover(){
        $result = (new Animationscover)  -> limit(12) -> select();
        $L = array();
    	foreach ($result as $data) {
            $data = $data -> getData();
            $cotdir = (new Animationsdir) -> where('cvdirid',$data["ID"]) -> count('cvdirid');
            array_push($L,array("as" => $data["ID"], "cv" => $data["cover"] ,"ti" => $data["title"], "src" => $data["src"], "cotdir" => $cotdir));
    	}
        echo json_encode($L);
        
    }

    public function load_vdir($name) {
        $query_bg = (new animationscover) -> where('src','/video/'.$name) ->field('cover,src,title,introduction,ID') ->find();
        $query_bg = $query_bg -> getData();
        $cotdir = (new animationsdir) -> where('cvdirid',$query_bg["ID"]) -> count('cvdirid');
        $view = new View();
        $view -> assign(['name' => $name, 'cover' => $query_bg['cover'], 'src' => $query_bg['src'], 'title' => $query_bg['title'], 'introduction' => $query_bg['introduction'], 'cotdir' =>  $cotdir, 'associated' => $query_bg["ID"]]);
        echo $view->fetch('comic/video_directory');
    }

    public function query_vdir($name){
        $query_vdir = (new Animationsdir) -> where('cvdirid' ,$name) -> order('dirbluesid desc') -> select();
        $L = array();
        foreach ($query_vdir as $data) {
            $data  = $data -> getData();
            array_push($L,array("cvid" => $data["cvdirid"], "dirid" => $data["dirbluesid"], "dirname" => $data["dirname"]));
        }
        echo json_encode($L);
    }

    public function load_vpath($cvdirid ,$dirbluesid){
    	$query_bg = (new animationscover) -> where('ID' ,$cvdirid) -> field('title') -> find();
    	$map = array('cvdirid' => $cvdirid, 'dirbluesid' => $dirbluesid);
    	$query_src = (new animationsdir) -> where($map) ->field('videopath') -> find();
        $query_src = $query_src -> getData();
        $QuVpage = (new animationsdir) -> where('cvdirid' ,$cvdirid) -> order('dirbluesid desc') -> select();
        $h5_statements = ' ';
        foreach ($QuVpage as $data2){
            $data2 = $data2 -> getData();
        	$h5_statements .= '<a target=_blank href=/animation/' . $data2["cvdirid"] . '/'. $data2["dirbluesid"] . ' title=' . $data2["dirname"] . '>' . $data2["dirname"] . '</a>';
        }

        $view = new View();
        $view -> assign(['empty' => $h5_statements, 'cvdirid' => $cvdirid, 'dirbluesid' => $dirbluesid, 'src' => $query_src['videopath'], 'title' => $query_bg['title']]);
        echo $view -> fetch('comic/video_page');
        
    }

    public function search_video(){
        $SearchName = isset($_GET['name'])? $_GET['name'] : '';
        $Test = new \L\Font();
        // 简体转繁体
        $fanti = $Test->c2t($SearchName);
        // 繁体转简体
        $jianti = $Test->t2c($SearchName); 
        $where['title'] = array('like',array('%'.$SearchName.'%' ,'%'.$fanti.'%' ,'%'.$jianti.'%' ) ,'OR');
        $SearchResult =  (new Animationscover)->where($where)->select();
        $h5_statements = ' ';
        $Serch_Msg = ' ';
    	if(empty($SearchResult)){
    		$RandResult = (new Animationscover) -> order('rand()') -> limit(1) -> select();
    		foreach ($RandResult as $data) {
                $data = $data -> getData();
    			$cotdir = (new animationsdir) -> where('cvdirid',$data["ID"]) -> count('cvdirid');
    			$h5_statements .= '<ul class=vdcv id=vdcv><li class=vdcvli><a data-pjax href=' . $data["src"] . ' title=' . $data["title"] . ' target=_self class=vdcvimg><img class=vdcvloading data-original=' .  $data["cover"] . 'alt=' . $data["title"] . 'style=display:inline src=' . $data["cover"] . '><span class=vdcvmask style=opacity:0;><i class=glyphicon glyphicon-play-circle glyphiconL></i></span></a><div class=vdcvinfo><a data-pjax href=' . $data["src"] . '>' . $data["title"] . '</a><p><span class=vdcvf1>更新至' . $cotdir . '集</span></p></div></li></ul>';

    			$Serch_Msg = '<h3 class=serach_font>找不到您需要的影视，为您推荐下面的影视 :</h3>';
    		}
    	}else{
    		foreach ($SearchResult as $data) {
                 $data = $data -> getData();
    			$cotdir = (new Animationsdir) -> where('cvdirid',$data["ID"]) -> count('cvdirid');
    			$h5_statements .= '<ul class=vdcv id=vdcv><li class=vdcvli><a data-pjax href=' . $data["src"] . ' title=' . $data["title"] . ' target=_self class=vdcvimg><img class=vdcvloading data-original=' .  $data["cover"] . 'alt=' . $data["title"] . 'style=display:inline src=' . $data["cover"] . '><span class=vdcvmask style=opacity:0;><i class=glyphicon glyphicon-play-circle glyphiconL></i></span></a><div class=vdcvinfo><a data-pjax href=' . $data["src"] . '>' . $data["title"] . '</a><p><span class=vdcvf1>更新至' . $cotdir . '集</span></p></div></li></ul>';

    			$Serch_Msg = '<h3 class=serach_font>为您找到如下影视 :</h3>';
    		}
    	}
    	$view = new View();
        $View -> assign(['msg' => $Serch_Msg, 'empty' => $h5_statements]);
		echo $view->fetch('comic/search');
    }
}

