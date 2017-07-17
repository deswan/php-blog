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
        ['index', 'store','update','delete']
    ]);
    Route::resource('/articles', 'ArticleController',['only' =>
        ['index','show','store','update','delete']
    ]);
    Route::resource('/drafts', 'DraftController',['only' =>
        ['index','show','store','delete']
    ]);
    Route::post('/drafts/{draft}', 'DraftController@update');
    Route::get('/tags/validateName', 'CategoryController@validateName');
});
Route::group(['prefix'=>'stat'],function(){
    Route::get('/{year?}/{month?}', 'StatController@index');
});
