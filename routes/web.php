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


Route::get('/home', function () { return redirect('/'); })->name('home');
Route::get('/apply', function () { return view('welcome'); })->name('apply');
Route::resource('team','User\TeamController');
Auth::routes();

Route::get('/{username}', 'User\UserController@index')->name('profile');
Route::get('/{username}/edit', 'User\UserController@edit')->name('profile.edit');
Route::put('/{username}', 'User\UserController@update')->name('profile.update');
Route::delete('/{username}', 'User\UserController@destroy')->name('profile.delete');



Route::get('/user/activate/{token_name(token)}', 'Auth\RegisterController@activateUser')->name('activateuser');



Route::resource('dataentry','dataentry\projectController',[
	'as'=>'data',
	])->middleware('auth');
Route::resource('dataentry/{project}/category','dataentry\CategoryController',[
	'as'=>'project',
	])->middleware('auth');


