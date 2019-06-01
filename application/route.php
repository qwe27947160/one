<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

Route::rule('load_comic','index/Ni/load_comic');
/********** 页面跳转 **********/
Route::rule('chapter/:name','index/Ni/load_chapter');
Route::rule('load_chapter','index/Ni/query_chapter');
Route::rule('page/:comicid/:pagenum','index/Ni/load_page');
Route::rule('load_page','index/Ni/query_page');
Route::rule('search','index/Ni/search');
Route::rule('Load_Animations_Cover','index/Ni/Load_Animations_Cover');
Route::rule('video/:name','index/Ni/load_vdir');
Route::rule('load_Vdor/:name','index/Ni/query_vdir');
Route::rule('animation/:cvdirid/:dirbluesid' ,'index/Ni/load_vpath');
Route::rule('search_video','index/Ni/search_video');
Route::rule('forgetpwd', 'index/LoginValidation/forgetpwd');

Route::rule('creatPicture', 'index/LoginValidation/creatPicture');
Route::rule('register', 'index/LoginValidation/register');
Route::rule('active', 'index/LoginValidation/active');
Route::rule('findPassword', 'index/LoginValidation/findPassword');
Route::rule('resetPassword', 'index/LoginValidation/resetPassword');

/********** loadview **********/
Route::rule('forgetpwd', 'index/LoadView/forgetpwd');
Route::rule('findPass', 'index/LoadView/findPass');
Route::rule('/user/register', 'index/LoadView/register');
Route::rule('/user/login', 'index/LoadView/login');
Route::rule('/allcomic', 'index/LoadView/allcomic');
Route::rule('/allvideo', 'index/LoadView/allvideo');

/******************mobileview*********************/
Route::rule('/mobile/comicChapter/:name', 'index/LoadView/comicChapter');