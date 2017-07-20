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

Route::get('/', 'IndexController@index');

Route::group(['prefix'=>'admin'],function(){
    Route::get('/', 'AdminController@index');
    Route::resource('/tags', 'CategoryController', ['only' =>
        ['index','show','store','update']
    ]);
    Route::resource('/articles', 'ArticleController',['only' =>
        ['index','show','store','edit']
    ]);
    Route::resource('/drafts', 'DraftController',['only' =>
        ['index','show','store','edit']
    ]);
    Route::post('/articles/{article}', 'ArticleController@update'); //将更新方法改为post
    Route::post('/drafts/{draft}', 'DraftController@update');
    Route::post('/tags/{tag}', 'CategoryController@update');

    Route::get('/articles/{article}/delete', 'ArticleController@destroy');
    Route::get('/drafts/{draft}/delete', 'DraftController@destroy');
    Route::get('/tags/{tag}/delete', 'CategoryController@destroy');

    Route::post('/drafts/release/{draft}', 'DraftController@release');
    Route::get('/tags/validateName', 'CategoryController@validateName');
});
Route::group(['prefix'=>'stat'],function(){
    Route::get('/{year?}/{month?}', 'StatController@index');
});
