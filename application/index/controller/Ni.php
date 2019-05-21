<?php
namespace app\index\controller;
use app\index\model\Comic;
use app\index\model\Chapter;
use app\index\model\Animationscover;
use app\index\model\Animationsdir;
use app\index\model\Animationspath;
use think\Db;
use think\View;
use \think\Request;
use \think\Config;
class Ni 
{
    public function index(){
    	$view = new View();
        echo $view->fetch('comic/index');
    }

    public function load_chapter($name){
        $view = new View();
        $view->assign('name',$name);
        echo $view->fetch('comic/chapter');
    }

    public function load_comic(){
    	$result = (new Comic)  -> order('rand()') -> limit(12) ->select();
        $L = array();
    	foreach ($result as $data){
            array_push($L,array("cd" => $data -> getData()["ComicChapter"], "cn" => $data -> getData()["urlname"],"cv" => $data -> getData()["cover"] ,"ti" => $data -> getData()["title"]));
            
    	}
        echo json_encode($L);
    }    

    public function query_chapter(){
        $Qychapter = isset($_POST['qy'])? $_POST['qy'] : ''; 
        $query_comic = (new Comic) -> where('urlname',$Qychapter) ->field('ComicChapter') ->find();
        $map['ComicChapter'] = $query_comic->getData('ComicChapter');
        $query_chapter = (new Comic) -> LoadChapter($map)  -> order('ChapterName') ->select();
        $L = array();
     
        foreach($query_chapter as $data){
            //var_dump($data ->getData());
            array_push($L,array("id" => $data -> getData()["ComicChapter"] ,"pagenum" => $data ->getData()["ChapterPage"] ,"pn" => $data -> getData()["ChapterName"]));
        }
        echo json_encode($L);
        
    }

    public function load_page($comicid ,$pagenum){
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
            //var_dump($data ->getData());
            array_push($L,array("ad" => $data -> getData()["Imgpath"] ));
        }
        echo json_encode($L);
    }

    public function search(){
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
    			$h5_statements .= '<ul id="ccover" class="cmcover"><li><a href=chapter/' . $data -> getData()["urlname"] . ' class=pic><img src="' .$data -> getData()["cover"] . '" alt=' . $data -> getData()["title"] . '></a><p class=cover><a href=chapter/' . $data -> getData()["urlname"] . ' class=pic2><span>' .  $data -> getData()["title"] . '</span></a></p></li></ul>';

    			$Serch_Msg = '<h3 class=serach_font>找不到您需要的动漫，为您推荐下面的动漫:</h3>';
    		}
    	}else{
    		foreach ($SearchResult as $data) {
    			//var_dump($data);
    			$h5_statements .= '<ul id="ccover" class="cmcover"><li><a href=chapter/' . $data -> getData()["urlname"] . ' class=pic><img src="' .$data -> getData()["cover"] . '" alt=' . $data -> getData()["title"] . '></a><p class=cover><a href=chapter/' . $data -> getData()["urlname"] . ' class=pic2><span>' .  $data -> getData()["title"] . '</span></a></p></li></ul>';

    			$Serch_Msg = '<h3 class=serach_font>为您找到如下动漫:</h3>';
    		}
    	}
    	$view = new View();
		$view->assign('msg',$Serch_Msg);
		$view->assign('empty' ,$h5_statements);
		echo $view->fetch('comic/search');
    }

    public function Load_Animations_Cover(){
        $result = (new Animationscover)  -> select();
        $L = array();
    	foreach ($result as $data){
            $cotdir = (new Animationsdir) -> where('cvdirid',$data->getData()["associated"]) -> count('cvdirid');
            
            array_push($L,array("as" => $data -> getData()["associated"], "cv" => '"'. $data -> getData()["cover"] . '"',"ti" => '"' . $data -> getData()["title"] . '"' ,"src" => '"' . $data -> getData()["src"] . '"' ,"cotdir" => $cotdir));
    	}
        echo json_encode($L);
    }

    public function load_vdir($name){
        $query_bg = (new Animationscover) -> where('src','/video/'.$name) ->field('cover,src,title,introduction,associated') ->find();
        $cotdir = (new Animationsdir) -> where('cvdirid',$query_bg->getData()["associated"]) -> count('cvdirid');
        $cover => '"' . $query_bg->getData()['cover'] . '"';
        $src => '"' . $query_bg->getData()['src'] . '"';
        $title => '"' . $query_bg->getData()['title'] . '"';
        $introduction = $query_bg->getData()['introduction'];
        $associated = $query_bg->getData()["associated"];
     
        $view = new View();
        $view->assign('name',$name);
        $view->assign('cover',$cover);
        $view->assign('src',$src);
        $view->assign('title',$title);
        $view->assign('introduction',$introduction);
        $view->assign('cotdir',$cotdir);
        $view->assign('associated',$associated);
        echo $view->fetch('comic/video_directory');
    }

    public function query_vdir($name){
        $query_vdir = (new Animationsdir) -> where('cvdirid' ,$name) -> order('id desc') -> select();
        $L = array();
        foreach ($query_vdir as $data){
            array_push($L,array("cvid" => $data -> getData()["cvdirid"], "dirid" => $data -> getData()["dirbluesid"],"dirname" => $data -> getData()["dirname"]));
        }
        echo json_encode($L);
    }

    public function load_vpath($cvdirid ,$dirbluesid){
    	$query_bg = (new Animationscover) -> where('associated' ,$cvdirid) -> field('title') -> find();
    	$map['cvdirid'] = $cvdirid;
    	$map['dirbluesid'] = $dirbluesid;
    	$query_src = (new Animationspath) -> where($map) ->field('animationspath') -> find();
        $data['cvdirid'] = $cvdirid;
        $data['dirbluesid'] = $dirbluesid;
        $data['src'] = $query_src->getData()['animationspath'];
        $data['title'] = $query_bg->getData()['title'];

        $QuVpage = (new Animationsdir) -> where('cvdirid' ,$cvdirid) -> order('dirbluesid desc') -> select();
        $h5_statements = ' ';
        foreach ($QuVpage as $data2){
        	$h5_statements .= '<a target=_blank href=/animation/' . $data2 -> getData()["cvdirid"] . '/'. $data2 -> getData()["dirbluesid"] . ' title=' . $data2 -> getData()["dirname"] . '>' . $data2 -> getData()["dirname"] . '</a>';
        }

        $view = new View();
        $view -> assign('empty' ,$h5_statements);
        $view -> assign('data',$data);
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
    			$cotdir = (new Animationsdir) -> where('cvdirid',$data->getData()["associated"]) -> count('cvdirid');
    			$h5_statements .= '<ul class=vdcv id=vdcv><li class=vdcvli><a data-pjax href=' . $data -> getData()["src"] . ' title=' . $data -> getData()["title"] . ' target=_self class=vdcvimg><img class=vdcvloading data-original=' .  $data -> getData()["cover"] . 'alt=' . $data -> getData()["title"] . 'style=display:inline src=' . $data -> getData()["cover"] . '><span class=vdcvmask style=opacity:0;><i class=glyphicon glyphicon-play-circle glyphiconL></i></span></a><div class=vdcvinfo><a data-pjax href=' . $data -> getData()["src"] . '>' . $data -> getData()["title"] . '</a><p><span class=vdcvf1>更新至' . $cotdir . '集</span></p></div></li></ul>';

    			$Serch_Msg = '<h3 class=serach_font>找不到您需要的影视，为您推荐下面的影视 :</h3>';
    		}
    	}else{
    		foreach ($SearchResult as $data) {
    			$cotdir = (new Animationsdir) -> where('cvdirid',$data->getData()["associated"]) -> count('cvdirid');
    			$h5_statements .= '<ul class=vdcv id=vdcv><li class=vdcvli><a data-pjax href=' . $data -> getData()["src"] . ' title=' . $data -> getData()["title"] . ' target=_self class=vdcvimg><img class=vdcvloading data-original=' .  $data -> getData()["cover"] . 'alt=' . $data -> getData()["title"] . 'style=display:inline src=' . $data -> getData()["cover"] . '><span class=vdcvmask style=opacity:0;><i class=glyphicon glyphicon-play-circle glyphiconL></i></span></a><div class=vdcvinfo><a data-pjax href=' . $data -> getData()["src"] . '>' . $data -> getData()["title"] . '</a><p><span class=vdcvf1>更新至' . $cotdir . '集</span></p></div></li></ul>';

    			$Serch_Msg = '<h3 class=serach_font>为您找到如下影视 :</h3>';
    		}
    	}
    	$view = new View();
		$view->assign('msg',$Serch_Msg);
		$view->assign('empty' ,$h5_statements);
		echo $view->fetch('comic/search');
    }
}

