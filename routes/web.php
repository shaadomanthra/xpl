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
use PacketPrep\Http\Middleware\Corporate;
use PacketPrep\User;
use Illuminate\Support\Facades\Storage;





	Route::post('/mail/delivery', 'Mailer\MailController@deliveryStatus')->middleware('mailgun');
	Route::post('/mail/delivery2', 'Mailer\MailController@deliveryStatus');
	Route::get('/mail/delivery', 'Mailer\MailController@deliveryStatus');

	Route::group(['middleware' => [RequestFilter::class,Corporate::class,nocache::class]], function () {
	
	Route::get('/', 'HomeController@root')->name('root');
	Route::get('/trail', 'HomeController@index')->name('trail');
	Route::get('/gu', 'HomeController@getUsers')->name('gu');
	Route::post('/', 'Product\OrderController@callback');
	Route::get('/instamojo', 'Product\OrderController@instamojo')->middleware('auth');
	Route::get('/order_payment', 'Product\OrderController@instamojo_return');
	Route::post('/order_payment', 'Product\OrderController@instamojo_return');
	Route::post('/contactform', 'System\UpdateController@contact')->name('contactform');

	Route::get('testemail','HomeController@testemail')->middleware('auth');
	Route::get('aws','HomeController@aws')->middleware('auth');
	Route::get('phpword','HomeController@phpword')->middleware('auth');





	Route::get('/dashboard','Product\ProductController@welcome')->name('dashboard')->middleware('auth');

	Route::get('/participants','Product\ProductController@participants')->name('participants')->middleware('auth');
	Route::get('/attempts','Product\ProductController@attempts')->name('attempts')->middleware('auth');

	Route::get('/editor','Product\ProductController@editor')->name('editor');
	Route::post('/editor','Product\ProductController@editor')->name('editor');

	Route::get('/targettcs/code','Product\EditorController@tcscode')->name('tcscode');
	Route::post('/targettcs/code','Product\EditorController@tcstestcase')->name('tcs.testcase');

	

	Route::get('/targettcs/code/one','Product\EditorController@tcscode_one')->name('tcscode.one');
	Route::post('/targettcs/code/one','Product\EditorController@tcstestcase_one')->name('tcs.testcase.one');

	Route::get('/targettcs/code/two','Product\EditorController@tcscode_two')->name('tcscode.two');
	Route::post('/targettcs/code/two','Product\EditorController@tcstestcase_two')->name('tcs.testcase.two');
	Route::get('/runcode','Product\EditorController@runcode')->name('runcode');
	Route::get('/stopcode','Product\EditorController@stopcode')->name('stopcode');
	Route::get('/autoruncode','Product\EditorController@autoruncode')->name('autoruncode');
	Route::get('/stopdocker','Product\EditorController@stop')->name('stop');
	Route::get('/removedocker','Product\EditorController@remove')->name('remove');

	Route::get('img/upl','HomeController@imageupload')->name('img.upl');


	Route::get('process_image','HomeController@process_image')->name('process_image');

	//Route::post('img/upl/file','VideoController@imageupload')->name('img.post');
	//Route::post('img/upl/file','HomeController@webcam_upload')->name('img.post');
	Route::get('face_detect_image','HomeController@face_detect_image')->name('img.post');
	Route::post('face_detect_image','HomeController@face_detect_image')->name('img.post');


	//piofx
	Route::get('/mcss',function(){ return view('piofx.mcss'); })->name('mcss');
	Route::get('/schools',function(){ return view('piofx.schools'); })->name('schools');
	Route::get('/ocrupload','Exam\SectionController@ocrupload')->name('ocrupload');
	Route::post('/ocrupload','Exam\SectionController@ocrupload')->name('ocrupload');
	Route::get('/xpc',function(){ return view('appl.pages.xp.xpc'); })->name('xpc');
	Route::get('/trialpdf',function(){ return view('appl.pages.pp.pdf'); })->name('ppdf');
	Route::get('/jobboard',function(){ return view('appl.pages.xp.jobboard'); })->name('jobboard');
	Route::get('/hiring',function(){ return view('appl.pages.xp.hiring'); })->name('hiring');
	Route::get('/oet',function(){ return view('piofx.oet')->with('menudark',1); })->name('oet');


	Route::get('/front',function(){ return view('layouts.front'); })->name('front')->middleware('auth');
	Route::get('/crt-aptitude',function(){ return view('appl.pages.crt_aptitude'); })->name('crt.aptitude');
	
	Route::get('/java-language-exam',function(){ return view('appl.pages.java_certification'); })->name('java.l.c');
	Route::get('/launch-offer',function(){ return view('appl.pages.launch_offer'); })->name('launch-offer');
	Route::get('/dxcmocks',function(){ return view('appl.dxc'); })->name('dxc');
	Route::get('/email-template',function(){ return view('mail.email'); })->name('email.template');
	Route::get('/versant',function(){ return view('appl.pages.verscent'); })->name('pages.verscent');
	Route::get('/frame',function(){ return view('appl.pages.frame'); })->name('pages.frame');

	Route::get('/cf-launch',function(){ return view('appl.pages.cf_launch'); })->name('cf.launch');

	Route::get('/terms',function(){ return view('appl.pages.terms'); })->name('terms');
	Route::get('/em',function(){ return view('appl.pages.eamcet'); })->name('eamcet');

	//pages
	Route::get('/premium','Product\ProductController@premium')->name('premium');
	Route::get('/hire',function(){ return view('xp_welcome')->with('welcome',1); })->name('xp');
	Route::get('/privacy',function(){ return view('appl.product.pages.privacy'); })->name('privacy');
	Route::get('/refund',function(){ return view('appl.product.pages.refund'); })->name('refund');
	Route::get('/disclaimer',function(){ return view('appl.product.pages.disclaimer'); })->name('disclaimer');
	Route::get('/about',function(){ return view('appl.pages.about'); })->name('xp.about');

	Route::get('/corporate-training',function(){ return view('appl.pages.xp.specific.corporate_training'); })->name('xp.ct');
	Route::get('/campus-recruitment-training',function(){ return view('appl.pages.xp.specific.campus_recruitment_training'); })->name('xp.crt');
	Route::get('/company-specific-training',function(){ return view('appl.pages.xp.specific.company_specific_training'); })->name('xp.cst');
	Route::get('/finishing-school-program',function(){ return view('appl.pages.xp.specific.finishing_school_program'); })->name('xp.fsp');
	Route::get('/proctored-online-examinations',function(){ return view('appl.pages.xp.specific.proctored-online-examinations'); })->name('xp.poe');
	Route::get('/aptitude-test',function(){ return view('appl.pages.xp.specific.aptitude_test'); })->name('xp.aptitude');
	Route::get('/news',function(){ return view('appl.pages.xp.specific.news'); })->name('xp.news');
	Route::get('/testimonials',function(){ return view('appl.pages.xp.specific.testimonials'); })->name('xp.testimonials');
	Route::get('/team',function(){ return view('appl.pages.xp.specific.team'); })->name('xp.team');

	Route::get('/aboutus',function(){ return view('appl.pages.xp.about'); })->name('about');
	Route::get('/faq',function(){ return view('appl.product.pages.faq'); })->name('faq')->middleware('corporate');;
	Route::get('/checkout','Product\OrderController@checkout')->name('checkout')->middleware('auth');
	Route::get('/checkout-success',function(){ return view('appl.product.pages.checkout_success'); })->name('checkout-success')->middleware('auth');
	Route::get('/credit-rates',function(){ return view('appl.product.pages.credit_rates'); })->name('credit-rate')->middleware('auth');;

	Route::get('/s3',function(){ 
		$files = Storage::disk('s3')->allFiles('urq');
		
		$json = array();
		foreach($files as $f){
			$ext = pathinfo($f, PATHINFO_EXTENSION);
			if($ext!='json'){
				$file = str_replace('urq/', '', $f);
				$image = 'https://s3-xplore.s3.ap-south-1.amazonaws.com/'.$f;
				$pieces = explode('_', $file);
				$jsonname = $pieces[0].'_'.$pieces[1];
				$n = explode('.',$pieces[2]);
				$qid = $n[0];
				$json[$jsonname][$qid][$file] = $image;
			}
			
		}
		foreach($json as $m => $j){
			$jsonfile = $m.'.json';
			//Storage::disk('s3')->put('urq/'.$jsonfile, json_encode($j));
		}

		dd('');
	});


	
	//campus
	Route::get('/campus', 'College\CampusController@main')
			->name('campus.main')->middleware('auth');
	Route::get('/campus/admin', 'College\CampusController@admin')
			->name('campus.admin')->middleware('auth');
	Route::get('/campus/courses', 'College\CampusController@courses')
			->name('campus.courses')->middleware('auth');
	Route::get('/campus/courses/{course}', 'College\CampusController@course_show')
			->name('campus.courses.show')->middleware('auth');
	Route::get('/campus/courses/{course}/{student}', 'College\CampusController@course_student')
			->name('campus.courses.student.show')->middleware('auth');

	Route::get('/campus/tests', 'College\CampusController@tests')		
			->name('campus.tests')->middleware('auth');
	Route::get('/campus/tests/{test}', 'College\CampusController@test_show')
			->name('campus.tests.show')->middleware('auth');
	Route::get('/campus/duplicates/{test}', 'College\CampusController@remove_duplicates')
			->name('remove.duplicates')->middleware('auth');
	Route::get('/user_details_update', 'College\CampusController@user_details_update')
			->name('user.details.update');

	Route::get('/test/{test}/add_attempt', 'Exam\AssessmentController@add_attempt')
	 ->name('test.attempt')->middleware('auth');

    Route::get('/test/{test}/analytics', 'College\CampusController@test_analytics')
	 ->name('test.analytics')->middleware('auth');
	Route::get('/exam/{test}/analytics', 'Exam\ExamController@test_analytics')
	 ->name('exam.analytics')->middleware('auth'); 
	Route::get('/test/{test}/pdfupload', 'Exam\ExamController@pdfupload')
			->name('test.pdfupload')->middleware('auth');
	Route::get('/test/{test}/report', 'Exam\ExamController@analytics')
			->name('test.report')->middleware('auth');
	Route::get('/test/{test}/reportd', 'Exam\ExamController@reportd')
			->name('test.reportd')->middleware('auth');
	Route::get('/test/{test}/analytics3', 'Exam\ExamController@analytics3')
			->name('test.analytics3')->middleware('auth');
	Route::get('/test/{test}/analytics4', 'Exam\ExamController@analytics4')
			->name('test.analytics4')->middleware('auth');
	Route::get('/test/{test}/live', 'Exam\AssessmentController@live')
			->name('test.live')->middleware('auth');
	Route::get('/test/{test}/proctor', 'Exam\AssessmentController@proctor')
			->name('test.proctor')->middleware('auth');
	Route::get('/test/{test}/proctorlist', 'Exam\ExamController@proctorlist')
			->name('test.proctorlist')->middleware('auth');
	Route::get('/test/{test}/candidatelist', 'Exam\ExamController@candidatelist')
			->name('test.candidatelist')->middleware('auth');
	Route::get('/test/{test}/questionlist', 'Exam\ExamController@questionlist')
			->name('test.questionlist')->middleware('auth');
	Route::get('/apitest/{test}', 'Exam\ExamController@questionlist')
			->name('test.questionlistapi')->middleware('cors');


	Route::post('/test/{test}/proctor', 'Exam\AssessmentController@proctor')
			->name('test.proctor')->middleware('auth');
	Route::get('/test/{test}/active', 'Exam\AssessmentController@active')
			->name('test.active')->middleware('auth');
	Route::get('/test/{test}/actives3', 'Exam\AssessmentController@actives3')
			->name('test.actives3')->middleware('auth');
	Route::get('/test/{test}/status', 'Exam\AssessmentController@status')
			->name('test.status')->middleware('auth');
	Route::get('/test/{test}/snaps', 'Exam\AssessmentController@snaps')
			->name('test.snaps')->middleware('auth');
	Route::get('/test/{test}/logs', 'Exam\AssessmentController@logs')
			->name('test.logs')->middleware('auth');
	Route::get('/test/{test}/accesscode', 'Exam\ExamController@accesscode')
			->name('test.accesscode')->middleware('auth');
	Route::get('/exam/{test}/set_creator', 'Exam\ExamController@set_creator')
			->name('test.sets')->middleware('auth');
	Route::post('/exam/{test}/set_creator', 'Exam\ExamController@set_creator')
			->name('test.sets')->middleware('auth');
	Route::post('/test/{test}/user_roles', 'Exam\ExamController@user_roles')
			->name('test.user_roles')->middleware('auth'); 
	Route::get('/test/{test}/user_roles', 'Exam\ExamController@user_roles')
			->name('test.user_roles')->middleware('auth'); 
	Route::get('/exam/{test}/upload', 'Exam\SectionController@upload')
			->name('test.upload')->middleware('auth'); 
	Route::post('/exam/{test}/upload', 'Exam\SectionController@upload')
			->name('test.upload')->middleware('auth'); 
	Route::get('/exam/{test}/download', 'Exam\SectionController@download')
			->name('test.download')->middleware('auth'); 

	Route::resource('/exam/{test}/mail', 'Exam\ExamMailController')->middleware('auth'); 

	Route::get('/campus/tests/{test}/{student}', 'College\CampusController@test_student')
			->name('campus.tests.student.show')->middleware('auth');

	Route::get('/campus/student_table', 'College\CampusController@student_table')
			->name('campus.student_table')->middleware('auth');
	Route::get('/campus/students', 'College\CampusController@students')
			->name('campus.students')->middleware('auth');
	Route::get('/campus/students/{student}', 'College\CampusController@student_show')
			->name('campus.students.show')->middleware('auth');

	Route::post('/campus/batches/{batch}/attach', 'College\BatchController@attachUser')
			->name('batch.attach')->middleware('auth');
	Route::get('/campus/batches/{batch}/attach', 'College\BatchController@attachUser')
			->name('batch.attach')->middleware('auth');
	Route::post('/campus/batches/{batch}/detach', 'College\BatchController@detachUser')
			->name('batch.detach')->middleware('auth');
	Route::get('/campus/batches/{batch}/detach', 'College\BatchController@detachUser')
			->name('batch.detach')->middleware('auth');
	
	Route::resource('/campus/batches', 'College\BatchController',['names' => [
        'index' => 'batch.index',
        'store' => 'batch.store',
        'create' => 'batch.create',
        'show' => 'batch.show',
        'edit'=> 'batch.edit',
        'update'=>'batch.update',
        'destroy'=>'batch.destroy',
    ]])->middleware('auth');
    
	//Route::resource('/campus/schedules', 'College\ScheduleController')->middleware('auth');
	//Route::resource('/campus/schedules/{schedule}/modules', 'College\ModulesController')->middleware('auth');

	//analytics
	Route::get('/admin/analytics/course', 'Product\AnalyticsController@analytics_course')->name('admin.analytics.course')->middleware('auth');
	Route::get('/admin/managers', 'User\UserController@hrmanagers')->name('hrmanagers')->middleware('auth');
	Route::get('/admin/analytics/practice_remove_duplicates', 'Product\AnalyticsController@remove_duplicates_practice')->name('admin.analytics.practice.remove');
	Route::get('/admin/analytics/practice_filldata', 'Product\AnalyticsController@practice_filldata')->name('admin.analytics.practice.filldata');
	Route::get('/admin/analytics/test_filldata', 'Product\AnalyticsController@test_filldata')->name('admin.analytics.test.filldata');
	Route::get('/admin/analytics/filldata', 'Product\AnalyticsController@filldata')->name('admin.analytics.filldata');
	Route::get('/admin/analytics/practice', 'Product\AnalyticsController@analytics_practice')->name('admin.analytics');
	Route::get('/admin/analytics/test', 'Product\AnalyticsController@analytics_test')->name('admin.analytics.test');


	Route::get('/payment/status', 'Product\OrderController@status')->name('payment.status');
	Route::post('/payment/order', 'Product\OrderController@order')->name('payment.order');
	Route::get('/transactions', 'Product\OrderController@transactions')->name('order.transactions')->middleware('auth');
	Route::get('/transactions/{order_id}', 'Product\OrderController@transaction')->name('order.transaction')->middleware('auth');
	Route::get('/admin/transactions', 'Product\OrderController@list_transactions')->name('order.list');
	
	Route::get('/admin/transactions/{order_id}', 'Product\OrderController@show_transaction')->name('order.show');
	Route::get('/admin/buy', 'Product\OrderController@buycredits')->name('order.buy');
	Route::get('/admin/ordersuccess', 'Product\OrderController@ordersuccess')->name('order.success');
	Route::get('/admin/orderfailure', 'Product\OrderController@orderfailure')->name('order.failure');
	Route::get('admin/image','Product\AdminController@image')->name('admin.image')->middleware('auth');
	Route::post('admin/image','Product\AdminController@imageupload')->name('admin.image')->middleware('auth');
	Route::get('admin/user','Product\AdminController@user')->name('admin.user')->middleware('auth');
	Route::get('admin/user/list','Product\AdminController@listuser')->name('admin.listuser')->middleware('auth');
	Route::get('admin/user/search','Product\AdminController@searchuser')->name('admin.searchuser')->middleware('auth');

	Route::post('admin/upload_users','User\UserController@upload_users')->name('upload.user')->middleware('auth');
	Route::get('admin/upload_users','User\UserController@upload_users')->name('upload.users')->middleware('auth');

	
	Route::get('admin/adduser','Product\AdminController@adduser')->name('admin.user.create')->middleware('auth');
	Route::post('admin/adduser','Product\AdminController@storeuser')->name('admin.user.store')->middleware('auth');
	Route::get('admin/edituser/{user}','Product\AdminController@edituser')->name('admin.user.edit')->middleware('auth');
	Route::put('admin/updateuser/{user}','Product\AdminController@updateuser')->name('admin.user.update')->middleware('auth');
	Route::get('admin/user/{user}','Product\AdminController@viewuser')->name('admin.user.view')->middleware('auth');
	Route::post('admin/user/{user}/delete','User\UserController@destroy')->name('admin.user.delete')->middleware('auth');
	Route::get('u/{user}','Product\AdminController@printuser')->name('admin.user.print')->middleware('auth');
	Route::get('admin/user/{user}/product','Product\AdminController@userproduct')->name('admin.user.product')->middleware('auth');
	Route::post('admin/user/{user}/product','Product\AdminController@storeuserproduct')->name('admin.user.product')->middleware('auth');

	Route::get('admin/user/{user}/product/{id}','Product\AdminController@edit_userproduct')->name('admin.user.product.edit')->middleware('auth');
	Route::post('admin/user/{user}/product/{id}','Product\AdminController@update_userproduct')->name('admin.user.product.update')->middleware('auth');


	Route::get('loadtest', function(){
		$user = User::where('id',6)->first();
		echo $user->name."<br>";
	
		if(!$user->roll_number && $user->roll_number!=0)
		$user->roll_number = 0;
		else
			$user->roll_number = $user->roll_number +1;

		$user->save();
		echo "user saved <br>";

		$user = User::where('id',6)->first();
		echo $user->roll_number."<br>";
	})->name('loadtest');

	Route::get('loadtest-dbread', function(){
		$user = User::where('id',6)->first();
		echo $user->name."<br>";
	})->name('loadtest-dbread');

	Route::get('loadtest-fileread', function(){
		$filename = 'corporate.json';
        $client = json_decode(file_get_contents($filename));
		echo $client->name."<br>";
	})->name('loadtest-fileread');

	Route::get('loadtest-dbwrite', function(){
		$user = User::where('id',6)->first();
		echo $user->name."<br>";
		if(!$user->roll_number && $user->roll_number!=0)
		$user->roll_number = 0;
		else
			$user->roll_number = $user->roll_number +1;
		$user->save();
	})->name('loadtest-dbwrite');

	Route::get('loadtest-filewrite', function(){
		$filename = 'corporate.json';
        $client = json_decode(file_get_contents($filename));
        $client->contact = "new contact";
        file_put_contents($filename, json_encode($client));
		echo $client->name."<br>";
	})->name('loadtest-filewrite');

	Route::get('/pricing',function(){ return view('appl.product.pages.pricing'); })->name('pricing');

	Route::get('/about-corporate',function(){ return view('appl.product.pages.about'); })->name('about-corporate');

	Route::get('/terms-corporate',function(){ return view('appl.product.pages.terms'); })->name('terms-corporate');

	Route::get('/contact','HomeController@contact')->name('contact');
	Route::get('/contactpage',function(){ return view('appl.pages.contact'); })->name('contactpage');

	Route::get('/downloads-corporate',function(){ return view('appl.product.pages.downloads'); })->name('downloads');

	/*customer */
	Route::get('/fullstackdevelopment','Product\CustomerController@development')->name('development');
	Route::get('/projects','Product\CustomerController@bootcamp')->name('bootcamp');
	Route::get('/firstacademy','Product\CustomerController@firstacademy')->name('firstacademy');
	Route::get('/firstacademy/test','Product\CustomerController@firstacademy_test')->name('firstacademy.test');
	Route::get('/gigacode','Product\CustomerController@gigacode')->name('gigacode');

	Route::get('/couponreferral','Product\CouponController@referral')->name('coupon.referral')->middleware('auth');
	Route::get('/couponcode','Product\CouponController@coupon')->name('coupon.code')->middleware('auth');
	Route::get('/couponadmin','Product\CouponController@couponAdmin')->name('customer.trcoupon.admin')->middleware('auth');


	/*test */
	// Route::get('/onlinetest', 'Product\TestController@main')->name('onlinetest');
	// Route::get('/onlinetest/{test}/instructions','Product\TestController@instructions')->name('onlinetest.instructions')->middleware('auth');
	// Route::get('/onlinetest/{test}/questions','Product\TestController@index')->name('onlinetest.questions')->middleware('auth');
	// Route::get('/onlinetest/{test}/questions/{id}','Product\TestController@index')->name('onlinetest.questions.id');
	// Route::get('/onlinetest/{test}/questions/{id}/save','Product\TestController@save')->name('onlinetest.questions.save');
	// Route::get('/onlinetest/{test}/questions/{id}/clear','Product\TestController@clear')->name('onlinetest.questions.clear');
	// Route::get('/onlinetest/{test}/submit','Product\TestController@submit')->name('onlinetest.submit');
	// Route::get('/onlinetest/{test}/analysis','Product\TestController@analysis')->name('onlinetest.analysis')->middleware('auth');
	// Route::get('/onlinetest/{test}/solutions','Product\TestController@solutions')->name('onlinetest.solutions')->middleware('auth');
	// Route::get('/onlinetest/{test}/solutions/{question}','Product\TestController@solutions')->name('onlinetest.solutions.q')->middleware('auth');

	Route::get('/sample-tests',function(){
		return view('appl.exam.assessment.sampletests');
	})->name('sampletests');


	Auth::routes();




	Route::get('/home', function () { return redirect('/'); })->name('home');
	Route::get('/apply', function () { return view('welcome'); })->name('apply');
	//Route::get('team','User\TeamController@index')->name('team');
	Route::get('user/export','User\TeamController@export')->name('export')->middleware('auth');


	/* user verify routes */
	Route::get('/activation', 'User\VerifyController@activation')->name('activation')->middleware('auth');
	Route::get('/refresh', 'User\VerifyController@refresh')->name('refresh')->middleware('auth');
	Route::post('/activation', 'User\VerifyController@activation')->name('activation');
	Route::get('/activation/mail/{token}', 'User\VerifyController@email')->name('email.verify');

	Route::post('/activation/phone', 'User\VerifyController@sms')->name('sms.verify');


	// Route::get('user/update_tables','User\UserController@update_user_tables')->name('update_tables')->middleware('auth');

	// Route::get('user/bootcampmail','User\TeamController@bootcampmail')->name('bootcampmail')->middleware('auth');
	
	Route::get('/share', function () { 

		return view('appl.product.pages.share');
			})->name('share');

	Route::get('/targettcs', 'Product\StudentController@targettcs')->name('targettcs');
	Route::get('/sreferral', 'Product\StudentController@referral')->name('sreferral');
	Route::get('/ambassador', 'Product\StudentController@ambassador')->name('ambassador');
	Route::get('/coordinator', 'Product\StudentController@coordinator')->name('coordinator');
	Route::get('/proaccess', 'Product\StudentController@proaccess')->name('proaccess')->middleware('auth');
	Route::get('/ambassador/apply', 'Product\StudentController@apply')->name('ambassador.apply')->middleware('auth');
	Route::post('/ambassador/apply', 'Product\StudentController@save')->name('ambassador.save')->middleware('auth');

	Route::get('/intern/connect','College\AmbassadorController@internconnect')->name('intern.connect')->middleware('auth');
	Route::get('/intern/generalist','College\AmbassadorController@interngeneralist')->name('intern.generalist');

	Route::get('/ambassador/leaderboard','College\AmbassadorController@leaderboard')->name('ambassador.leaderboard')->middleware('auth');
	Route::get('/ambassador/connect','College\AmbassadorController@connect2')->name('ambassador.connect')->middleware('auth');
	Route::get('/ambassador/list','College\AmbassadorController@list')->name('ambassador.list')->middleware('auth');
	Route::get('admin/ambassador/list','College\AmbassadorController@list2')->name('ambassador.list2')->middleware('auth');
	Route::get('/ambassador/college','College\AmbassadorController@college')->name('ambassador.college')->middleware('auth');
	Route::get('/ambassador/students','College\AmbassadorController@students')->name('ambassador.students')->middleware('auth');

	Route::get('/ambassador/college/{college}','College\AmbassadorController@college2')->name('ambassador.college.view')->middleware('auth');
	Route::get('/ambassador/students/{college}','College\AmbassadorController@students2')->name('ambassador.students.view')->middleware('auth');
	Route::get('/ambassador/onboard','College\AmbassadorController@onboard')->name('ambassador.onboard')->middleware('auth');

	Route::get('/ambassador/onboard','College\AmbassadorController@onboard')->name('ambassador.onboard')->middleware('auth');

	Route::get('/samplereport','Exam\ExamController@sample');

	Route::get('/referral', function () { 

		if(\auth::user()->colleges->first())
		$type = substr(\auth::user()->colleges->first()->type,0,1);
		else
		$type = 'd';


		if($type=='b')
			$type ='e';


		$username = \auth::user()->username;

		$users = \auth::user()->where('user_id',\auth::user()->id)->orderBy('updated_at','desc')->paginate(150);

		return view('appl.user.referral')
				->with('type',$type)
				->with('username',$username)
				->with('colleges',null)
				->with('users',$users); 

			})->middleware('auth')->name('referral');

	Route::get('/referral/list','Product\StudentController@referrallist')->middleware('auth')->name('referral.list');
	Route::get('/referral/{user}','Product\StudentController@userreferral')->middleware('auth')->name('user.referral');

	

	Route::get('/productpage/aptitude-assessments', function(){
		return Redirect::to('/sample-tests', 301); 
	});

	Route::get('/job/34283', function(){
		return Redirect::to('/jobs/34283', 301); 
	});

	Route::get('/srecieee', function(){
		return Redirect::to('/test/srecieee', 301); 
	});

	Route::get('gni/careerfair2020', function(){
		return Redirect::to('/jobs/career-fair-2020', 301); 
	});

	Route::get('/eamcet', function(){
		return Redirect::to('https://vaagdevi.xplore.co.in/register', 301); 
	});

	Route::get('/smec', function(){
		return Redirect::to('https://smechyd.xplore.co.in/productpage/stmartins-sctest', 301); 
	});

	Route::get('/test/052740', function(){
		return Redirect::to('https://iidt.xplore.co.in/test/067855', 301); 
	});

	Route::get('post/candidate','Job\PostController@candidate')->name('job.candidate');
	
	Route::get('post/{slug}/analytics','Job\PostController@analytics')->name('job.analytics');
	Route::get('post/{slug}/applicants','Job\PostController@applicant_index')->name('job.applicants');
	Route::post('post/{slug}/applicants','Job\PostController@applicant_index')->name('job.applicants');
	Route::post('post/updateapplicant','Job\PostController@updateApplicant')->name('update.applicant');
	Route::post('jobs/{slug}','Job\PostController@public_show')->name('post.apply');
	Route::resource('post','Job\PostController')->middleware('auth');

	Route::get('/job', function(){
		return Redirect::to('/jobs', 301); 
	});
	Route::get('jobs','Job\PostController@public_index')->name('jobs');
	Route::get('jobs/{slug}','Job\PostController@public_show')->name('job.show');

	Route::resource('product','Product\ProductController')->middleware('auth');
	Route::get('productpage','Product\ProductController@products')->name('products');
	Route::get('stats','Product\ProductController@statistics')->name('statistics');
	Route::get('productpage/{product}','Product\ProductController@page')->name('productpage');
	Route::get('productpage/{product}/transactions','Product\ProductController@transactions')->name('product.transactions');
	Route::get('users','User\UserController@userlist')->name('user.list');
	Route::get('users/add','User\UserController@add')->name('user.add');
	Route::get('users/{user}','User\UserController@view')->name('user.view');

	Route::get('apiuser','User\UserController@apiuser')->name('user.apiuser')->middleware('cors');
	Route::get('users/{user}/edit','User\UserController@edit')->name('user.edit');
	Route::get('performance','User\UserController@performance')->name('performance');

	Route::resource('client','Product\ClientController')->middleware('auth');
	Route::resource('client/{client}/clientuser','Product\ClientuserController')->middleware('auth');

	Route::post('client/image','Product\ClientController@imageupload')->name('client.image')->middleware('auth');
	Route::get('admin','Product\AdminController@index')->name('admin.index')->middleware('auth');
	Route::get('admin/settings','Product\AdminController@settings')->name('admin.settings')->middleware('auth');
	Route::post('admin/settings','Product\AdminController@settings_store')->name('admin.settings')->middleware('auth');

	

	Route::get('eregister',/*'Product\AdminController@estudentregister'*/ function(){
		return Redirect::to('/register');
	})->name('student.eregister');
	Route::get('sregister','Product\AdminController@sstudentregister')->name('student.sregister');


	Route::get('register/type',function () { 
		return Redirect::to('/register');
		if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com' || $_SERVER['HTTP_HOST'] == 'hiresyntax.com')
			return Redirect::to('/register');
		else
		return Redirect::to('/eregister'); 
			})->name('register.type');

	Route::get('dregister','Product\AdminController@dstudentregister')->name('student.dregister');
	Route::post('studentstore','Product\AdminController@studentstore')->name('admin.user.studentstore');
	Route::post('register/client','User\UserController@saveregister')->name('register.client');
	Route::post('register/sendotp','User\UserController@sendOTP')->name('register.sendotp');

	Route::get('api/register','User\UserController@apiregister')->name('api.register');
	Route::get('api/login','User\UserController@apilogin')->name('api.login');

	Route::get('/companies', 'Content\ArticleController@companies')->name('companies');
	
	Route::get('/j/listing', 'Content\ArticleController@public')->name('article.listing')->middleware('auth');
	Route::get('/j/template', function(){ return view('appl.content.article.template'); })->name('template');
	Route::get('/j/myblogs','Content\ArticleController@myblogs' )->name('myblogs')->middleware('auth');

	Route::get('joblist',/*'Product\AdminController@estudentregister'*/ function(){
		return Redirect::to('/job');
	})->name('job.list');

	Route::get('blog','Content\ArticleController@index' )->name('article.index');
	Route::get('j/{label}','Content\ArticleController@label' )->name('blog.label');
	Route::resource('article','Content\ArticleController',['names' => [
        'index' => 'blog.index',
        'store' => 'article.store',
        'create' => 'article.create',
        'edit'=> 'article.edit',
        'update'=>'article.update',
        'destroy'=>'article.destroy',
    ]]);
	

	/* Training */
	Route::post('training/{slug}/participant_import','Training\TrainingController@participantImport')->name('participant_import');
	Route::get('training/{slug}/students','Training\TrainingController@applicant_index')->name('training.students');
	Route::post('training/{slug}/{id}/attendance','Training\ScheduleController@attendance')->name('schedule.attendance');
	Route::get('training/{slug}/{id}/attendance','Training\ScheduleController@attendance')->name('schedule.attendance');
	Route::get('page/{slug}','Training\TrainingController@public_show')->name('trainingpage.show');
	Route::resource('training','Training\TrainingController')->middleware('auth');
	Route::resource('training/{training}/schedule','Training\ScheduleController')->middleware('auth');
	Route::resource('training/{training}/resource','Training\ResourceController')->middleware('auth');

    Route::resource('label','Content\LabelController')->middleware('auth');
    
	Route::resource('role','User\RoleController')->middleware('auth');
	Route::resource('tracks','Content\DocController',['names' => [
        'index' => 'docs.index',
        'store' => 'docs.store',
        'create' => 'docs.create',
        'show' => 'docs.show',
        'edit'=> 'docs.edit',
        'update'=>'docs.update',
        'destroy'=>'docs.destroy',
    ]]);
	Route::resource('tracks/{doc}/chapter','Content\ChapterController',['names' => [
        'index' => 'chapter.index',
        'store' => 'chapter.store',
        'create' => 'chapter.create',
        'show' => 'chapter.show',
        'edit'=> 'chapter.edit',
        'update'=>'chapter.update',
        'destroy'=>'chapter.destroy',
    ]]);

	Route::get('video', 'VideoController@get')->name('video.upload')->middleware('auth');
	Route::post('video', 'VideoController@save')->name('video.upload');

	Route::get('resume', 'User\UserController@resume')->name('resume.upload')->middleware('auth');
	Route::post('resume', 'User\UserController@resumesave')->name('resume.upload');

	Route::get('/proficiency-test', 'Product\TestController@proficiency_test')->name('proficiency_test');
	Route::get('/updates', 'System\UpdateController@public_updates')->name('updates');
	Route::get('/updates/{id}', 'System\UpdateController@public_view')->name('updates.view');
	Route::get('/system', 'System\UpdateController@system')->name('system')->middleware('auth');
	Route::resource('system/update','System\UpdateController')->middleware('auth');
	Route::resource('system/finance','System\FinanceController')->middleware('auth');
	Route::resource('system/goal','System\GoalController')->middleware('auth');
	Route::get('system/report/week','System\ReportController@week')->middleware('auth')->name('report.week');
	Route::resource('system/report','System\ReportController')->middleware('auth');

	Route::get('college/top30','College\CollegeController@top30')->middleware('auth')->name('college.top30');

	Route::get('college/upload','College\CollegeController@uploadColleges')->middleware('auth')->name('college.upload');
	Route::get('college/download','College\CollegeController@download')->middleware('auth')->name('college.download');
	Route::post('college/upload','College\CollegeController@uploadColleges')->middleware('auth')->name('college.upload');
	Route::resource('zone','College\ZoneController')->middleware('auth');
	Route::resource('branch','College\BranchController')->middleware('auth');
	Route::resource('college','College\CollegeController')->middleware('auth');
	Route::resource('metric','College\MetricController')->middleware('auth');
	Route::resource('service','College\ServiceController')->middleware('auth');


	Route::get('college/{college}/view','College\CollegeController@show2')->middleware('auth')->name('college.view');

	Route::get('college/{college}/students','College\CollegeController@students')->middleware('auth')->name('college.students');
	Route::get('college/{college}/userlist','College\CollegeController@userlist')->middleware('auth')->name('college.userlist');

	
	Route::post('productactivate','Product\ProductController@activate')->middleware('auth')->name('product.activate');

	Route::get('zone/{zone}/students','College\ZoneController@students')->middleware('auth')->name('zone.students');
	Route::get('zone/{zone}/view','College\ZoneController@show2')->middleware('auth')->name('zone.view');

	Route::get('metric/{metric}/students','College\MetricController@students')->middleware('auth')->name('metric.students');
	Route::get('metric/{metric}/view','College\MetricController@show2')->middleware('auth')->name('metric.view');

	Route::get('branch/{branch}/students','College\BranchController@students')->middleware('auth')->name('branch.students');
	Route::get('branch/{branch}/view','College\BranchController@show2')->middleware('auth')->name('branch.view');

	Route::get('service/{service}/students','College\ServiceController@students')->middleware('auth')->name('service.students');
	Route::get('service/{service}/view','College\ServiceController@show2')->middleware('auth')->name('service.view');

	Route::get('admin/analysis','College\CollegeController@analysis')->middleware('auth')->name('admin.analysis');
	
	Route::get('exam/createexam','Exam\ExamController@createExam')->middleware('auth')->name('exam.createexam');
	Route::post('exam/createexam','Exam\ExamController@storeExam')->middleware('auth')->name('exam.save');

	Route::post('exam/{exam}/section/save','Exam\SectionController@save')->middleware('auth')->name('section.save');
	Route::post('exam/{exam}/section/copy','Exam\SectionController@copy')->middleware('auth')->name('section.copy');
	Route::get('exam/{exam}/section/copy','Exam\SectionController@copy')->middleware('auth')->name('section.copy');
	
	Route::get('exam/psyreport','Exam\ExamController@psyreport')->middleware('auth')->name('exam.psyreport');
	Route::post('exam/copy','Exam\ExamController@copy')->middleware('auth')->name('e.exam.copy');
	Route::post('exam/owner','Exam\ExamController@owner')->middleware('auth')->name('e.exam.owner');
	Route::resource('exam','Exam\ExamController')->middleware('auth');
	Route::resource('examtype','Exam\ExamtypeController')->middleware('auth');
	Route::resource('exam/{exam}/sections','Exam\SectionController')->middleware('auth');
	Route::get('exam/{exam}/question','Dataentry\QuestionController@exam')->middleware('auth')->name('exam.questions');
	
	Route::get('exam/{exam}/question/{id}','Dataentry\QuestionController@exam')->middleware('auth')->name('exam.question');

	Route::get('exam/{exam}/passage','Dataentry\PassageController@exam')->middleware('auth')->name('exam.passages');
	Route::get('exam/{exam}/passage/{id}','Dataentry\PassageController@exam')->middleware('auth')->name('exam.passage');

	

	Route::get('certificate/brandpromoter/{user}','User\UserController@certificate')->name('certificate.brandpromoter');
	Route::get('certificate/{exam}/{user}','Exam\AssessmentController@certificate')->name('certificate');

	Route::get('certificate/sample','Exam\AssessmentController@certificate_sample')->name('certificate.sample');
	Route::get('report/{exam}/{user}','Exam\AssessmentController@report')->name('report');
	Route::get('test','Exam\AssessmentController@index')->name('assessment.index');
	Route::get('test/{test}/submit','Exam\AssessmentController@submit')->name('assessment.submit');
	Route::post('test/{test}/submission','Exam\AssessmentController@submission')->name('assessment.submission');
	Route::post('uploadimage/{test}','Exam\AssessmentController@upload_image')->name('assessment.upload');
	Route::post('deleteimage/{test}','Exam\AssessmentController@delete_image')->name('assessment.delete.image');
	Route::post('savetest/{test}','Exam\AssessmentController@savetest')->name('assessment.savetest');
	//Route::get('uploadimage/{test}','Exam\AssessmentController@upload_image')->name('assessment.uploadget');
	Route::get('test/{test}/analysis','Exam\AssessmentController@analysis2')->name('assessment.analysis')->middleware('auth');
	Route::get('test/{test}/analysis_api','Exam\AssessmentController@analysis3')->name('assessment.analysis3');
	Route::get('test/{test}/solutions','Exam\AssessmentController@solutions')->name('assessment.solutions')->middleware('auth');

	Route::get('test/{test}/responses','Exam\AssessmentController@responses2')->name('assessment.responses')->middleware('auth');
	Route::get('test/{test}/pdf','Exam\AssessmentController@responses2')->name('assessment.pdf');
	Route::get('test/{test}/response_images','Exam\AssessmentController@response_images')->name('assessment.response_images')->middleware('auth');
	Route::get('test/{test}/responses2','Exam\AssessmentController@responses')->name('assessment.response2')->middleware('auth');

	Route::post('test/{test}/comment','Exam\AssessmentController@comment')->name('assessment.comment')->middleware('auth');
	Route::post('test/{test}/solutions','Exam\AssessmentController@solutions')->name('assessment.solutions.post')->middleware('auth');
	Route::get('test/{test}/solutions/{question}','Exam\AssessmentController@solutions')->name('assessment.solutions.q')->middleware('auth');
	Route::post('test/{test}/solutions/{question}','Exam\AssessmentController@solutions')->name('assessment.solutions.q')->middleware('auth');
	Route::post('test/{test}/solutions/{question}','Exam\AssessmentController@solutions')->name('assessment.solutions.q.post')->middleware('auth');
	Route::get('test/{test}/try','Exam\AssessmentController@try2')->middleware('auth')->name('assessment.try');
	Route::get('test/{test}/view','Exam\AssessmentController@view')->middleware('auth')->name('assessment.view');
	Route::get('test/{test}','Exam\AssessmentController@show')->name('assessment.show');
	Route::post('test/{test}','Exam\AssessmentController@show')->name('assessment.show');
	Route::get('test/{test}/details','Exam\AssessmentController@show')->name('assessment.details');
	Route::get('test/{test}/access','Exam\AssessmentController@access')->name('assessment.access')->middleware('auth');
	Route::get('test/{test}/instructions','Exam\AssessmentController@instructions')->middleware('auth')->name('assessment.instructions');
	Route::post('test/{test}/instructions','Exam\AssessmentController@instructions')->middleware('auth')->name('assessment.instructions');

	Route::get('test/{test}/{id}','Exam\AssessmentController@try')->name('assessment.try.id');
	Route::get('test/{test}/{id}/save','Exam\AssessmentController@save')->name('assessment.save');
	Route::get('test/{test}/{id}/clear','Exam\AssessmentController@clear')->name('assessment.clear');
	
	Route::post('test/{test}/delete','Exam\AssessmentController@delete')->name('assessment.delete');
	

	Route::resource('/mail', 'Mailer\MailController')->middleware('auth');


	Route::resource('/coupon', 'Product\CouponController')->middleware('auth');
	Route::get('/coupon/getamount/{amount}/{code}/{product}', 'Product\CouponController@getamount');
	
	Route::get('/social', 'Social\MediaController@social')->name('social')->middleware('auth');
	Route::post('/social/imageupload', 'Social\BlogController@image_upload')->name('imageupload');
	Route::get('/social/imageremove', 'Social\BlogController@image_remove')->name('imageremove');
	//Route::resource('blog','Social\BlogController');
	Route::resource('social/media','Social\MediaController')->middleware('auth');
	Route::get('/social/word', 'Social\WordController@index')->name('word');

	Route::get('/user/activate/{token_name}', function($token_name){
		$user = User::where('activation_token', $token_name)->first();
        
        if(isset($user) ){
            if($user->status==5) {
                $user->status = 0;
                $user->save();

                $status = "Your e-mail is verified. You can now login.";
            }else{
                $status = "Your e-mail is already verified. You can now login.";
            }

        }else{
        	$status = "Sorry your account cannot be identified. Kindly contact administrator";
        	flash($status)->warning();
            return redirect('/login')->with('warning', $status);
        }
        flash($status)->warning();
        return redirect('/activation')->with('status', $status);
	})->name('activateuser');

	Route::get('/user/password/forgot', 'Auth\LoginController@forgotPassword')->name('password.forgot');
	Route::post('/user/password/forgot', 'Auth\LoginController@sendPassword')->name('password.forgot.send');

	Route::get('/user/password_change', 'User\UserController@changePassword')->name('password.change')->middleware('auth');
	Route::post('/user/password_change', 'User\UserController@changePassword')->name('password.change')->middleware('auth');

	

	Route::get('/wipro-verbal-ability-questions', function(){
		return Redirect::to('/wipro_verbal_ability_questions', 301); 
	});

	Route::get('/wipro-nlth-2020', function(){
		return Redirect::to('/wipro-nth-2020', 301); 
	})->name('material');

	

	
	Route::get('/course/set-theory', function(){
		return Redirect::to('/course/set-theory-gate-cs', 301); 
	});


	Route::get('c-program-to-check-if-the-given-number-is-a-prime-number', function(){
		return Redirect::to('c-program-to-check-prime-number', 301); 
	});

	Route::get('/course/quant', function(){
		return Redirect::to('/course/quantitative-aptitude', 301); 
	});
	Route::get('/material', 'Dataentry\ProjectController@material')->name('material');

	Route::get('dataentry/qdb','Dataentry\QdbController@index')->middleware('auth')->name('qdb.index');
	Route::get('dataentry/pdf','Dataentry\QuestionController@pdf')->middleware('auth')->name('dataentry.pdf');
	Route::get('dataentry/qdb/export','Dataentry\QdbController@exportQuestion')->middleware('auth')->name('qdb.export');
	Route::get('dataentry/qdb/import','Dataentry\QdbController@importQuestion')->middleware('auth')->name('qdb.import');
	Route::get('dataentry/qdb/replace','Dataentry\QdbController@replacement')->middleware('auth')->name('qdb.replace');



	Route::get('dataentry/fork','Dataentry\ProjectController@fork')->middleware('auth')->name('dataentry.fork');
	Route::get('d/{project}/c/export','Dataentry\QuestionController@export')->name('category.export');

	Route::get('dd/{project}/cc/import','Dataentry\QuestionController@import')->name('category.import');

	Route::resource('dataentry','Dataentry\ProjectController')->middleware('auth');
	Route::resource('dataentry/{project}/category','Dataentry\CategoryController')->middleware('auth');
	Route::get('dataentry/{project}/category/{category}/question','Dataentry\QuestionController@category')->middleware('auth')->name('category.question');
	Route::get('dataentry/{project}/category/{category}/cache','Dataentry\CategoryController@cache')->middleware('auth')->name('category.cache');
	
	Route::get('dataentry/{project}/category/{category}/question/{id}','Dataentry\QuestionController@category')->middleware('auth')->name('category.question');
	Route::resource('dataentry/{project}/tag','Dataentry\TagController')->middleware('auth');
	Route::get('dataentry/{project}/tag/{tag}/question','Dataentry\QuestionController@tag')->middleware('auth')->name('tag.question');
	Route::get('dataentry/{project}/tag/{tag}/question/{id}','Dataentry\QuestionController@tag')->middleware('auth')->name('tag.question');
	Route::get('questionapi/{question}','Dataentry\QuestionController@show2');
	
	Route::resource('dataentry/{project}/passage','Dataentry\PassageController')->middleware('auth');
	Route::resource('dataentry/{project}/question','Dataentry\QuestionController')->middleware('auth');
	Route::get('question/attach/{question}/{category}','Dataentry\QuestionController@attachCategory');
	Route::get('question/detach/{question}/{category}','Dataentry\QuestionController@detachCategory');
	Route::get('question/copy/{question}','Dataentry\QuestionController@copy')->name('question.copy')->middleware('auth');

	Route::get('question/attachsection/{question}/{section}','Dataentry\QuestionController@attachSection');
	Route::get('question/detachsection/{question}/{section}','Dataentry\QuestionController@detachSection');

	Route::get('question/addtest/{question}','Dataentry\QuestionController@addTest');
	Route::get('question/removetest/{question}','Dataentry\QuestionController@removeTest');

	// Route::resource('library','Library\RepositoryController')->middleware('auth');
	// Route::resource('library/{repository}/structure','Library\structureController')->middleware('auth');
	// Route::get('library/{repository}/structure/{structure}/question','Library\LquestionController@structure')->middleware('auth')->name('structure.question');
	// Route::get('library/{repository}/structure/{structure}/question/{id}','Library\LquestionController@structure')->middleware('auth')->name('structure.question');
	// Route::resource('library/{repository}/ltag','Library\LtagController')->middleware('auth');
	// Route::get('library/{repository}/ltag/{tag}/question','Library\LquestionController@tag')->middleware('auth')->name('ltag.question');
	// Route::get('library/{repository}/ltag/{tag}/question/{id}','Library\LquestionController@tag')->middleware('auth')->name('ltag.question');
	// Route::resource('library/{repository}/lpassage','Library\LpassageController')->middleware('auth');
	// Route::resource('library/{repository}/lquestion','Library\LquestionController')->middleware('auth');
	// Route::resource('library/{repository}/version','Library\VersionController')->middleware('auth');
	// Route::resource('library/{repository}/video','Library\VideoController')->middleware('auth');
	// Route::resource('library/{repository}/document','Library\DocumentController')->middleware('auth');

	Route::resource('course','Course\CourseController');
	Route::get('course/{course}/list','Course\CourseController@show4')->name('course.list');
	Route::get('course/{course}/batches','Course\CourseController@batches')->name('course.batches');
	//Route::resource('course/{course}/index','Course\IndexController');
	Route::get('course/{course}/{category}/view','Course\CourseController@video')->name('course.category.video');
	Route::get('course/{course}/analytics','Course\CourseController@analytics')->name('course.analytics');
	Route::get('course/{project}/{category}/practice','Dataentry\QuestionController@categoryCourse')->name('course.question')->middleware('auth');
	Route::get('course/{project}/{category}/practice/{id}','Dataentry\QuestionController@categoryCourse')->name('course.question')->middleware('auth');
	Route::post('course/{project}/{category}/practice/{id}','Dataentry\QuestionController@categoryCourseSave')->name('course.question')->middleware('auth');

	Route::get('/recruit', 'Recruit\JobController@recruit')->name('recruit');

	Route::get('/complete_profile', 'User\UserController@update_self')->name('profile.complete');

	Route::get('/agreement', 'User\UserController@agreement')->name('profile.agreement')->middleware('auth');
	Route::post('/agreement', 'User\UserController@agreement')->name('profile.agreement')->middleware('auth');
	
	//Route::resource('job','Recruit\JobController');
	Route::resource('form','Recruit\FormController')->middleware('auth');

	
	Route::get('profile', function(){
		$user = \auth::user();
		return redirect()->route('profile','@'.$user->username);
	})->name('p')->middleware('auth');

	Route::get('profile/edit', function(){
		$user = \auth::user();
		return redirect()->route('profile.edit','@'.$user->username);
	})->name('p.edit')->middleware('auth');
	Route::get('/{page}',function($page){
		if(strpos($page,'@')===0)
        {
        	return redirect()->route('profile',$page);
        }else{
        	return app('PacketPrep\Http\Controllers\Content\ArticleController')->show($page);
        }
	})->name('page');

	Route::get('user/mydetails', 'User\UserController@mydetails')->name('profile.mydetails')->middleware('auth');
	Route::post('user/mydetails', 'User\UserController@mydetails')->name('profile.mydetails')->middleware('auth');

	Route::get('user/details', 'User\UserController@details')->name('profile.details')->middleware('auth');
	Route::post('user/details', 'User\UserController@details')->name('profile.details')->middleware('auth');
    Route::get('user/{username}', 'User\UserController@index')->name('profile');
	Route::get('user/{username}/edit', 'User\UserController@edit')->name('profile.edit');
	Route::get('user/{username}/manage', 'User\UserController@manage')->name('profile.manage');
	Route::put('user/{username}', 'User\UserController@update')->name('profile.update');
	Route::delete('user/{username}', 'User\UserController@destroy')->name('profile.delete');

});






