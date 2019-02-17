<?php
Route::get('admin/login', 'admin/Login/create');
Route::post('admin/login', 'admin/Login/save');

Route::group('admin', function(){
	Route::get('/', 'admin/Index/index');
	Route::resource('cate', 'admin/Cate')->model('id', '\app\common\model\Category');
	//Route::get('article', 'admin/Article/index');
	Route::resource('article', 'admin/Article')->model('id', '\app\common\model\Article');
	Route::put('article/status/:id', 'admin/Article_status/update')->model('\app\common\model\Article');
	Route::get('tags', 'admin/Tag/index');
	Route::resource('advertise', 'admin/Advertisement');
	Route::resource('link', 'admin/Link')->model('id', '\app\common\model\Link');
	Route::resource('navigator', 'admin/Navigator')->model('id', '\app\common\model\Navigator');
	Route::delete('logout', 'admin/Login/delete');
	Route::get('comments', 'admin/Comment/index');
	Route::delete('comments/:id', 'admin/Comment/delete')->model('\app\common\model\Comment');
	Route::resource('user', 'admin/User')->model('id', '\app\common\model\User');
	//Route::get('cate', 'admin/cate/index');
	//Route::get('cate/:id/edit', 'admin/cate/edit');
	
})->middleware('AdminAuth');

Route::get('/', 'index/index');
Route::get('show/:id', 'index/show')->middleware('IncreaseArticleViewCount');
Route::get('reg', 'index/Register/create');
Route::get('login', 'index/Login/create');
Route::post('login', 'index/login/save');

Route::group(['ext' => 'html'], function(){
    Route::post('thumb/:id/:type', 'index/ArticleThumb/save')->model('id', '\app\common\model\Article');
    Route::post('savecomment/:id', 'index/Comment/save')->middleware('checkCommentFrequency');
    Route::delete('comment/:id', 'index/Comment/delete');
    Route::delete('logout', 'index/login/delete');
})->middleware('Auth');

Route::get('articlethumbs/:id', 'index/ArticleThumb/read')->model('id', '\app\common\model\Article');

