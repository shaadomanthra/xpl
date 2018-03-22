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

Route::get('/', function () { return view('welcome'); })->name('root');

Route::get('/about',function(){ return view('appl.pages.packetprep'); })->name('about');
Route::get('/contact',function(){ return view('appl.pages.contact'); })->name('contact');

Auth::routes();

Route::get('/home', function () { return redirect('/'); })->name('home');
Route::get('/apply', function () { return view('welcome'); })->name('apply');
Route::get('team','User\TeamController@index')->name('team');

Route::resource('role','User\RoleController')->middleware('auth');
Route::resource('docs','Content\DocController');
Route::resource('docs/{doc}/chapter','Content\ChapterController');

Route::get('/system', 'System\UpdateController@system')->name('system')->middleware('auth');
Route::resource('system/update','System\UpdateController')->middleware('auth');
Route::resource('system/finance','System\FinanceController')->middleware('auth');
Route::resource('system/goal','System\GoalController')->middleware('auth');
Route::resource('system/report','System\ReportController')->middleware('auth');

Route::get('/social', 'Social\MediaController@social')->name('social')->middleware('auth');
Route::post('/social/imageupload', 'Social\BlogController@image_upload')->name('imageupload');
Route::get('/social/imageremove', 'Social\BlogController@image_remove')->name('imageremove');
Route::resource('social/blog','Social\BlogController')->middleware('auth');
Route::resource('social/media','Social\MediaController')->middleware('auth');


Route::get('/user/activate/{token_name}', 'Auth\RegisterController@activateUser')->name('activateuser');



Route::resource('dataentry','dataentry\projectController')->middleware('auth');
Route::resource('dataentry/{project}/category','dataentry\CategoryController')->middleware('auth');


Route::get('/{username}', 'User\UserController@index')->name('profile');
Route::get('/{username}/edit', 'User\UserController@edit')->name('profile.edit');
Route::get('/{username}/manage', 'User\UserController@manage')->name('profile.manage');
Route::put('/{username}', 'User\UserController@update')->name('profile.update');
Route::delete('/{username}', 'User\UserController@destroy')->name('profile.delete');





