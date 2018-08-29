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

use PacketPrep\Http\Middleware\RequestFilter;



Route::group(['middleware' => [RequestFilter::class]], function () {
	
	Route::get('/', 'Product\ProductController@welcome')->name('root');
	Route::post('/', function(){ return view('appl.product.pages.checkout_success'); });
	Route::post('/contactform', 'System\UpdateController@contact')->name('contactform');



	Route::get('/terms',function(){ return view('appl.pages.terms'); })->name('terms');
	Route::get('/privacy',function(){ return view('appl.product.pages.privacy'); })->name('privacy');
	Route::get('/refund',function(){ return view('appl.product.pages.refund'); })->name('refund');
	Route::get('/disclaimer',function(){ return view('appl.product.pages.disclaimer'); })->name('disclaimer');
	Route::get('/about',function(){ return view('appl.pages.about'); })->name('about');
	Route::get('/contact',function(){ return view('appl.pages.contact')->with('recaptcha',true); })->name('contact');
	Route::get('/features',function(){ return view('appl.product.pages.features'); })->name('features');
	Route::get('/checkout',function(){ return view('appl.product.pages.checkout'); })->name('checkout');
	Route::get('/checkout-success',function(){ return view('appl.product.pages.checkout_success'); })->name('checkout-success');

	Route::post('/payment/status', 'Product\OrderController@paymentCallback');
	Route::get('/payment/order', 'Product\OrderController@order');
	Route::get('/pricing',function(){ return view('appl.product.pages.pricing'); })->name('pricing');
	Route::get('/about-corporate',function(){ return view('appl.product.pages.about'); })->name('about-corporate');
	Route::get('/terms-corporate',function(){ return view('appl.product.pages.terms'); })->name('terms-corporate');
	Route::get('/contact-corporate',function(){ return view('appl.product.pages.contact'); })->name('contact-corporate');
	Route::get('/downloads-corporate',function(){ return view('appl.product.pages.downloads'); })->name('downloads');


	Auth::routes();




	Route::get('/home', function () { return redirect('/'); })->name('home');
	Route::get('/apply', function () { return view('welcome'); })->name('apply');
	Route::get('team','User\TeamController@index')->name('team');

	Route::resource('product','Product\ProductController')->middleware('auth');
	Route::resource('client','Product\ClientController')->middleware('auth');
	Route::resource('client/{client}/clientuser','Product\ClientuserController')->middleware('auth');

	Route::resource('role','User\RoleController')->middleware('auth');
	Route::resource('docs','Content\DocController');
	Route::resource('docs/{doc}/chapter','Content\ChapterController');

	Route::get('/updates', 'System\UpdateController@public_updates')->name('updates');
	Route::get('/updates/{id}', 'System\UpdateController@public_view')->name('updates.view');
	Route::get('/system', 'System\UpdateController@system')->name('system')->middleware('auth');
	Route::resource('system/update','System\UpdateController')->middleware('auth');
	Route::resource('system/finance','System\FinanceController')->middleware('auth');
	Route::resource('system/goal','System\GoalController')->middleware('auth');
	Route::get('system/report/week','System\ReportController@week')->middleware('auth')->name('report.week');
	Route::resource('system/report','System\ReportController')->middleware('auth');

	/*
	Route::get('/social', 'Social\MediaController@social')->name('social')->middleware('auth');
	Route::post('/social/imageupload', 'Social\BlogController@image_upload')->name('imageupload');
	Route::get('/social/imageremove', 'Social\BlogController@image_remove')->name('imageremove');
	Route::resource('social/blog','Social\BlogController')->middleware('auth');
	Route::resource('social/media','Social\MediaController')->middleware('auth');
	*/

	Route::get('/user/activate/{token_name}', 'Auth\RegisterController@activateUser')->name('activateuser');


	Route::get('/material', 'Dataentry\ProjectController@material')->name('material');
	Route::get('dataentry/qdb','Dataentry\QdbController@index')->middleware('auth')->name('qdb.index');
	Route::get('dataentry/qdb/export','Dataentry\QdbController@exportQuestion')->middleware('auth')->name('qdb.export');
	Route::get('dataentry/qdb/import','Dataentry\QdbController@importQuestion')->middleware('auth')->name('qdb.import');
	Route::get('dataentry/qdb/replace','Dataentry\QdbController@replacement')->middleware('auth')->name('qdb.replace');

	Route::get('dataentry/fork','Dataentry\ProjectController@fork')->middleware('auth')->name('dataentry.fork');
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
	Route::get('library/{repository}/structure/{structure}/question','Library\LquestionController@structure')->middleware('auth')->name('structure.question');
	Route::get('library/{repository}/structure/{structure}/question/{id}','Library\LquestionController@structure')->middleware('auth')->name('structure.question');
	Route::resource('library/{repository}/ltag','Library\LtagController')->middleware('auth');
	Route::get('library/{repository}/ltag/{tag}/question','Library\LquestionController@tag')->middleware('auth')->name('ltag.question');
	Route::get('library/{repository}/ltag/{tag}/question/{id}','Library\LquestionController@tag')->middleware('auth')->name('ltag.question');
	Route::resource('library/{repository}/lpassage','Library\LpassageController')->middleware('auth');
	Route::resource('library/{repository}/lquestion','Library\LquestionController')->middleware('auth');
	Route::resource('library/{repository}/version','Library\VersionController')->middleware('auth');
	Route::resource('library/{repository}/video','Library\VideoController')->middleware('auth');
	Route::resource('library/{repository}/document','Library\DocumentController')->middleware('auth');

	Route::resource('course','Course\CourseController');
	Route::resource('course/{course}/index','Course\IndexController');


	Route::get('/recruit', 'Recruit\JobController@recruit')->name('recruit');
	Route::resource('job','Recruit\JobController');
	Route::resource('form','Recruit\FormController');

    Route::get('/{username}', 'User\UserController@index')->name('profile');
	Route::get('/{username}/edit', 'User\UserController@edit')->name('profile.edit');
	Route::get('/{username}/manage', 'User\UserController@manage')->name('profile.manage');
	Route::put('/{username}', 'User\UserController@update')->name('profile.update');
	Route::delete('/{username}', 'User\UserController@destroy')->name('profile.delete');

});






