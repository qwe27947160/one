<?php
namespace app\index\model;
use think\Model;


class Comic extends Model{
	function LoadChapter($map){
		return $this->hasMany('chapter')
					->where($map)
					->field('ChapterPage ,ComicChapter ,ChapterName' );
	}
}