<?php
namespace app\index\model;
use think\Model;


class Chapter extends Model{
	function Loadpage($map){
		return $this->hasMany('page')
					->where($map)
					->field('Imgpath')
					->order('ChapterPage ASC');
	}
}