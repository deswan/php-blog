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
    Route::resource('/categories', 'CategoryController', ['only' =>
        ['index', 'store','update']
    ]);
    Route::resource('/articles', 'ArticleController');
    Route::get('/articles/validate_title', 'ArticleController@validateTitle');
    Route::get('/categories/{id}/delete', 'CategoryController@delete');
    Route::get('/categories/data', 'CategoryController@data');
    Route::get('/categories/validateName', 'CategoryController@validateName');
});
