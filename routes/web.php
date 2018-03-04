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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/packetprep',function(){
	return view('appl.pages.packetprep');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('dataentry','dataentry\projectController',[
	'as'=>'data',
	])->middleware('auth');
Route::resource('dataentry/{project}/category','dataentry\CategoryController',[
	'as'=>'project',
	])->middleware('auth');


