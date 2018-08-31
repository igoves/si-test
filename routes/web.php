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

Route::get('/', 'UserController@index');
Route::get('/list', 'UserController@list');
Route::post('/search', 'UserController@search');
Route::get('/add', ['as' => 'add.show', 'uses' => 'UserController@show']);
Route::post('/add', ['as' => 'add.store', 'uses' => 'UserController@store']);
Route::get('/edit', ['as' => 'edit.edit', 'uses' => 'UserController@edit']);
Route::post('/edit', ['as' => 'edit.update', 'uses' => 'UserController@update']);
Route::post('/remove_photo', ['as' => 'remove_photo', 'uses' => 'UserController@remove_photo']);
