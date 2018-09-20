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
	Route::post('/', 'Product\OrderController@callback');
	Route::post('/contactform', 'System\UpdateController@contact')->name('contactform');



	Route::get('/terms',function(){ return view('appl.pages.terms'); })->name('terms');
	Route::get('/privacy',function(){ return view('appl.product.pages.privacy'); })->name('privacy');
	Route::get('/refund',function(){ return view('appl.product.pages.refund'); })->name('refund');
	Route::get('/disclaimer',function(){ return view('appl.product.pages.disclaimer'); })->name('disclaimer');
	Route::get('/about',function(){ return view('appl.pages.about'); })->name('about');
	Route::get('/contact',function(){ return view('appl.pages.contact')->with('recaptcha',true); })->name('contact');
	Route::get('/faq',function(){ return view('appl.product.pages.faq'); })->name('faq');
	Route::get('/checkout',function(){ return view('appl.product.pages.checkout'); })->name('checkout')->middleware('auth');
	Route::get('/checkout-success',function(){ return view('appl.product.pages.checkout_success'); })->name('checkout-success');
	Route::get('/credit-rates',function(){ return view('appl.product.pages.credit_rates'); })->name('credit-rate');


	Route::get('/payment/status', 'Product\OrderController@status')->name('payment.status');
	Route::post('/payment/order', 'Product\OrderController@order')->name('payment.order');
	Route::get('/admin/transactions', 'Product\OrderController@list_transactions')->name('order.list');
	Route::get('/admin/transactions/{order_id}', 'Product\OrderController@show_transaction')->name('order.show');
	Route::get('/admin/buy', 'Product\OrderController@buycredits')->name('order.buy');
	Route::get('/admin/ordersuccess', 'Product\OrderController@ordersuccess')->name('order.success');
	Route::get('/admin/orderfailure', 'Product\OrderController@orderfailure')->name('order.failure');
	Route::get('admin/image','Product\AdminController@image')->name('admin.image')->middleware('auth');
	Route::post('admin/image','Product\AdminController@imageupload')->name('admin.image')->middleware('auth');
	Route::get('admin/user','Product\AdminController@user')->name('admin.user')->middleware('auth');
	Route::get('admin/adduser','Product\AdminController@adduser')->name('admin.user.create')->middleware('auth');
	Route::post('admin/adduser','Product\AdminController@storeuser')->name('admin.user.store')->middleware('auth');
	Route::get('admin/edituser/{user}','Product\AdminController@edituser')->name('admin.user.edit')->middleware('auth');
	Route::put('admin/updateuser/{user}','Product\AdminController@updateuser')->name('admin.user.update')->middleware('auth');
	Route::get('admin/user/{user}','Product\AdminController@viewuser')->name('admin.user.view')->middleware('auth');
	Route::get('admin/user/{user}/course','Product\AdminController@usercourse')->name('admin.user.course')->middleware('auth');
	Route::post('admin/user/{user}/course','Product\AdminController@storeusercourse')->name('admin.user.course')->middleware('auth');

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
	Route::post('client/image','Product\ClientController@imageupload')->name('client.image')->middleware('auth');
	Route::get('admin','Product\AdminController@index')->name('admin.index')->middleware('auth');
	Route::get('admin/settings','Product\AdminController@settings')->name('admin.settings')->middleware('auth');
	Route::post('admin/settings','Product\AdminController@settings_store')->name('admin.settings')->middleware('auth');

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
	//Route::resource('course/{course}/index','Course\IndexController');
	Route::get('course/{course}/{category}/video','Course\CourseController@video')->name('course.category.video')->middleware('auth');
	Route::get('course/{project}/{category}/practice','Dataentry\QuestionController@categoryCourse')->name('course.question')->middleware('auth');
	Route::get('course/{project}/{category}/practice/{id}','Dataentry\QuestionController@categoryCourse')->name('course.question')->middleware('auth');
	Route::post('course/{project}/{category}/practice/{id}','Dataentry\QuestionController@categoryCourseSave')->name('course.question')->middleware('auth');

	Route::get('/recruit', 'Recruit\JobController@recruit')->name('recruit');
	Route::resource('job','Recruit\JobController');
	Route::resource('form','Recruit\FormController');

    Route::get('/{username}', 'User\UserController@index')->name('profile');
	Route::get('/{username}/edit', 'User\UserController@edit')->name('profile.edit');
	Route::get('/{username}/manage', 'User\UserController@manage')->name('profile.manage');
	Route::put('/{username}', 'User\UserController@update')->name('profile.update');
	Route::delete('/{username}', 'User\UserController@destroy')->name('profile.delete');

});






