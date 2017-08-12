<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
\DB::enableQueryLog();

Route::get('/', 'IndexController@index');

//适应history路由模式
Route::get('/code', 'IndexController@index');
Route::get('/essay', 'IndexController@index');

//文章详情页
Route::get('/article/{article}', 'IndexController@article');

//ajax
Route::get('/getTagsAndYears/{type?}', 'IndexController@getTagsAndYears');  //分类及月份数据
Route::get('/getArticles/{type?}', 'IndexController@getArticles');  //文章列表
Route::get('/getPageSum/{type?}', 'IndexController@getPageSum');  //总页数

Route::group(['prefix'=>'admin65790'],function(){
  Route::get('/login','AdminLoginController@index')->name('login');
  Route::post('/login','AdminLoginController@login');
  Route::group(['middleware'=>'auth:admin'],function(){
    Route::get('/', 'AdminController@index');

    //ajax
    Route::resource('/tags', 'CategoryController', ['only' =>
    ['index','show','store']
    ]);
    Route::resource('/articles', 'ArticleController',['only' =>
    ['index','show','store','edit']
    ]);
    Route::resource('/drafts', 'DraftController',['only' =>
    ['index','store','edit']
    ]);
    Route::post('/uploadFile', 'ArticleController@uploadFile'); //上传图片

    Route::post('/articles/{article}', 'ArticleController@update'); //将更新方法改为post
    Route::post('/drafts/{draft}', 'DraftController@update');
    Route::post('/tags/{tag}', 'CategoryController@update');

    Route::get('/articles/{article}/delete', 'ArticleController@destroy');
    Route::get('/drafts/{draft}/delete', 'DraftController@destroy');
    Route::get('/tags/{tag}/delete', 'CategoryController@destroy');

    Route::post('/drafts/release/{draft}', 'DraftController@release');
    Route::get('/tags/validateName', 'CategoryController@validateName');
  });
});

Route::group(['prefix'=>'stat'],function(){
  Route::group(['middleware'=>'auth:admin'],function(){
    Route::get('/getData/{article_id?}', 'StatController@getData');
  });
  Route::get('/visit', 'StatController@visit');
});
