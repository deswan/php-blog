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

//pages
Route::get('/', 'IndexController@index');
Route::get('/code', 'IndexController@index');
Route::get('/essay', 'IndexController@index');
Route::get('/article/{article}', 'IndexController@article');

//api
Route::get('/getTagsAndYears/{type?}', 'IndexController@getTagsAndYears');
Route::get('/getArticles/{type?}', 'IndexController@getArticles');
Route::get('/getPageSum/{type?}', 'IndexController@getPageSum');

Route::group(['prefix'=>'admin65790'],function(){
  Route::get('/login','AdminLoginController@index')->name('login');
  Route::post('/login','AdminLoginController@login');
  Route::group(['middleware'=>'auth:admin'],function(){
    Route::get('/', 'AdminController@index');
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
