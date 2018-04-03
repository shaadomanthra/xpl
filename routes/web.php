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


Route::get('/', 'System\UpdateController@welcome')->name('root');

// usage inside a laravel route
Route::post('/contactform', function()
{

	if(!request()->get('name') || !request()->get('email') || !request()->get('subject') || !request()->get('message')){
		flash('Input fields cannot be empty !')->error();
		return redirect()->back()->withInput();
	}
	$captcha = $_POST['g-recaptcha-response'];
	if(!$captcha){
		flash('Please verify using recaptcha !')->error();
		return redirect()->back()->withInput();
	}
	$secretKey = "6Lc9yFAUAAAAACg-A58P_L7IlpHjTB69xkA2Xt65";
	$ip = $_SERVER['REMOTE_ADDR'];
	$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);

	$responseKeys = json_decode($response,true);
	if(intval($responseKeys["success"]) !== 1) {
		flash('Recaptcha error kindly retry')->error();
		return redirect()->back()->withInput();
	} else {

		Mail::raw(scriptStripper(request()->message), function($message)
		{
			$message->subject(scriptStripper(request()->subject));
			$message->replyTo(scriptStripper(request()->email), scriptStripper(request()->name));
			$message->from('team@packetprep.com', 'Packetprep');
			$message->to('packetcode@gmail.com');
		});
		flash('Successfully sent your message to packetprep team !')->success()->important();
		return redirect()->back();
	}
    
})->name('contactform');


Route::get('/about',function(){ return view('appl.pages.packetprep'); })->name('about');
Route::get('/contact',function(){ return view('appl.pages.contact')->with('recaptcha',true); })->name('contact');

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


Route::get('/material', 'Dataentry\ProjectController@material')->name('material');
Route::resource('dataentry','Dataentry\ProjectController')->middleware('auth');
Route::resource('dataentry/{project}/category','Dataentry\CategoryController')->middleware('auth');
Route::get('dataentry/{project}/category/{category}/question','Dataentry\QuestionController@category')->middleware('auth')->name('category.question');
Route::get('dataentry/{project}/category/{category}/question/{id}','Dataentry\QuestionController@category')->middleware('auth')->name('category.question');
Route::resource('dataentry/{project}/tag','Dataentry\TagController')->middleware('auth');
Route::get('dataentry/{project}/tag/{tag}/question','Dataentry\QuestionController@tag')->middleware('auth')->name('tag.question');
Route::get('dataentry/{project}/tag/{tag}/question/{id}','Dataentry\QuestionController@tag')->middleware('auth')->name('tag.question');
Route::resource('dataentry/{project}/passage','Dataentry\PassageController')->middleware('auth');
Route::resource('dataentry/{project}/question','Dataentry\QuestionController')->middleware('auth');

Route::resource('library','Library\RepositoryController')->middleware('auth');
Route::resource('library/{repository}/structure','Library\structureController')->middleware('auth');


Route::get('/recruit', 'Recruit\JobController@recruit')->name('recruit');
Route::resource('job','Recruit\JobController');
Route::resource('form','Recruit\FormController');


Route::get('/{username}', 'User\UserController@index')->name('profile');
Route::get('/{username}/edit', 'User\UserController@edit')->name('profile.edit');
Route::get('/{username}/manage', 'User\UserController@manage')->name('profile.manage');
Route::put('/{username}', 'User\UserController@update')->name('profile.update');
Route::delete('/{username}', 'User\UserController@destroy')->name('profile.delete');





