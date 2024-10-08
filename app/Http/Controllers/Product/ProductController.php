<?php

namespace PacketPrep\Http\Controllers\Product;


use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Product\Product;
use PacketPrep\Models\Product\Order;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\Models\Exam\Tests_Overall;
use PacketPrep\Models\Course\Course;
use PacketPrep\Models\College\Service;
use PacketPrep\User;

use PacketPrep\Models\Training\Training;

use PacketPrep\Models\College\College;
use PacketPrep\Models\College\Zone;
use PacketPrep\Models\College\Metric;
use PacketPrep\Models\College\Branch;
use PacketPrep\Models\Product\Client;

use Illuminate\Support\Facades\Mail;
use PacketPrep\Mail\OrderSuccess;
use PacketPrep\Mail\OrderCreated;
use Illuminate\Support\Facades\DB;
use Instamojo as Instamojo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Product $product, Request $request)
  {

    $this->authorize('view', $product);

    $search = $request->search;
    $item = $request->item;

    $products = $product->where('name', 'LIKE', "%{$item}%")
      ->orderBy('created_at', 'desc ')
      ->paginate(config('global.no_of_records'));
    $view = $search ? 'list' : 'index';

    return view('appl.product.product.' . $view)
      ->with('products', $products)->with('product', $product);
  }

  public function statistics(Request $request)
  {
    //$slug = subdomain();
    //$client = client::where('slug',$slug)->first();
    //$this->authorize('view', $client);
    $users = new ProductController;
    $users->total = User::count();

    $last_year = (new \Carbon\Carbon('first day of last year'))->year;
    $this_year = (new \Carbon\Carbon('first day of this year'))->year;


    $last_year_first_day = (new \Carbon\Carbon('first day of January ' . $last_year))->startofMonth()->toDateTimeString();
    $this_year_first_day = (new \Carbon\Carbon('first day of January ' . $this_year))->startofMonth()->toDateTimeString();
    $users->last_year  = User::where('created_at', '>', $last_year_first_day)->where('created_at', '<', $this_year_first_day)->count();
    $users->this_year  = User::where(DB::raw('YEAR(created_at)'), '=', $this_year)->count();




    $last_month_first_day = (new \Carbon\Carbon('first day of last month'))->startofMonth()->toDateTimeString();
    $this_month_first_day = (new \Carbon\Carbon('first day of this month'))->startofMonth()->toDateTimeString();

    $users->last_month  = User::where('created_at', '>', $last_month_first_day)->where('created_at', '<', $this_month_first_day)->count();


    $users->this_month  = User::where(DB::raw('MONTH(created_at)'), '=', date('n'))->count();

    $metrics = Metric::all();


    return view('appl.product.pages.stats')->with('users', $users)->with('metrics', $metrics);
  }


  public function premium(Request $request)
  {
    $product = Product::where('slug', 'premium-access')->first();
    $user = \Auth::user();
    $entry = null;
    if ($user) {
      $entry = DB::table('product_user')
        ->where('product_id', $product->id)
        ->where('user_id', $user->id)
        ->first();
    }
    return view('appl.pages.premium')->with('entry', $entry);
  }


  public function activate(Request $request)
  {
    $code = $request->get('code');
    $user_id = $request->get('user_id');
    $user = User::where('id', $user_id)->first();
    $entry = DB::table('service_user')
      ->where('code', $code)
      ->where('user_id', $user_id)
      ->first();
    if ($entry) {

      $services = DB::table('service_user')
        ->where('code', $code)
        ->where('user_id', $user_id)
        ->get();
      foreach ($services as $service) {
        $s = Service::where('id', $service->service_id)->first();

        $product = Product::where('id', $s->product_id)->first();
        $pid = $product->id;
        $valid_till = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") . ' + ' . (24 * 31) . ' days'));
        if (!$user->products->contains($pid)) {
          $product = Product::where('id', $pid)->first();
          if ($product->status != 0)
            $user->products()->attach($pid, ['validity' => 24, 'created_at' => date("Y-m-d H:i:s"), 'valid_till' => $valid_till, 'status' => 1]);
        }
      }

      DB::table('service_user')
        ->where('code', $code)
        ->where('user_id', $user_id)
        ->update(['status' => 1]);
    } else
      abort('404', 'Your Code is Invalid');


    return view('appl.product.pages.productactivation');
  }

  public function attempts(Request $request)
  {

    if ($request->get('user'))
      $user = User::where('username', $request->get('user'))->first();
    else
      $user = \auth::user();

    $username = $user->username;
    $user->image = $user->getImage();
    $attempts_all = $attempts_lastmonth = $attempts_thismonth = $attempts_lastbeforemonth = 0;
    if ($user->checkRole(['hr-manager'])) {
      $count = 0;
      foreach ($user->exams as $exam) {
        $attempts_all = $attempts_all + $exam->getAttemptCount();
        $attempts_lastmonth = $attempts_lastmonth + $exam->getAttemptCount(null, 'lastmonth');
        $attempts_thismonth = $attempts_thismonth + $exam->getAttemptCount(null, 'thismonth');
        $attempts_lastbeforemonth = $attempts_lastbeforemonth + $exam->getAttemptCount(null, 'lastbeforemonth');
      }
      $data['attempts_all'] = $attempts_all;
      $data['attempts_lastmonth'] = $attempts_lastmonth;
      $data['attempts_thismonth'] = $attempts_thismonth;
      $data['attempts_lastbeforemonth'] = $attempts_lastbeforemonth;

      $e = $user->exams->pluck('id')->toArray();
      if (isset($exam)) {
        $attempts = $exam->getAttempts($e, $request->get('month'));
      } else {
        $exam = new Exam();
        $attempts = $exam->getAttempts($e, $request->get('month'));
      }
    }

    return view('appl.product.product.attempts')
      ->with('user', $user)->with('attempts', $attempts)
      ->with('data', $data);
  }

  public function welcome(Request $request)
  {

    $u = \auth::user();
    $user = Cache::remember('user_' . $u->id, 240, function () use ($u) {
      return User::where('id', $u->id)->with('college')->with('branch')->first();
    });

    $data['branches'] = Cache::get('branches');
    $data['colleges'] = Cache::get('colleges');




    $username = $user->username;
    $user->image = $user->getImage();
    $users = [];


    if ($user->checkRole(['hr-manager']) && !$user->isAdmin() && $user->role != 13 && subdomain() != 'packetprep') {

      $search = $request->search;
      $page = $request->get('page');
      $item = $request->item;

      $count = 0;



      $usertests = $user->clientexams()->orderBy('id', 'desc'); //->withCount('users');

      //dd($usertests->get()->pluck('name'));
      //dd($user->clientexams->pluck('id'));
      //$user->exams()->withCount('users')->orderBy('id','desc');


      if ($user->role == 10 || $user->role == 11) {
        $count = 0;
        $usercount = 0;
      } else {
        $count = (Tests_Overall::select('id')->whereIn('test_id', $usertests->pluck('id')->toArray())->count());
        $usercount = (User::select('id')->where('client_slug', subdomain())->where('status', '<>', '2')->count());
      }
      //$count = count($alltests);


      // foreach($user->exams as $exam){
      //   $count = $count + $exam->getAttemptCount();           
      // }

      if (request()->get('refresh')) {
        Cache::forget('my_usertests_' . $user->id);
      }

      if ($search || $page)
        $exams = $user->clientexams()->where('name', 'LIKE', "%{$item}%")->orderBy('id', 'desc')
          ->paginate(8);
      else {
        $exams = Cache::remember('my_usertests_' . $user->id, 60, function () use ($usertests) {
          return $usertests->paginate(8);
        });
      }

      if ($user->role == 10 || $user->role == 11) {
        foreach ($exams as $k => $e) {
          $exams[$k]->users_count = null;
        }
      } else {
        foreach ($exams as $k => $e) {
          $exams[$k]->users_count = Tests_Overall::select('id')->where('test_id', $e->id)->count();
        }
      }


      $exam = null;
      $ids = array();
      foreach ($exams as $k => $e) {
        if ($e)
          $exam = $e;

        if (!in_array($e->id, $ids))
          array_push($ids, $e->id);
        else
          unset($exams[$k]);
      }

      //dd($exams);

      $user->attempts = $count;
      $view = $search ? 'snippets.hr_tests' : 'hr_welcome';

      //$e = Exam::where('slug','psychometric-test')->first();
      $e = null;

      if (!$user->isAdmin())
        return view($view)
          ->with('user', $user)
          ->with('usercount', $usercount)
          ->with('exam', $exam)
          ->with('e', $e)
          ->with('exams', $exams);
    } else if ($user->checkRole(['hr-manager']) && !$user->isAdmin() && $user->role == 13 && subdomain() != 'packetprep') {


      $search = $request->search;
      $page = $request->get('page');
      $item = $request->item;

      $count = 0;



      $usertests = Exam::where('client', subdomain())->orderBy('id', 'desc');

      //dd($user->clientexams->pluck('id'));
      //$user->exams()->withCount('users')->orderBy('id','desc');


      $count = Cache::remember('tests_count_' . subdomain(), 60, function () use ($usertests) {
        return Tests_Overall::whereIn('test_id', $usertests->pluck('id')->toArray())->count();
      });
      //$count = count($alltests);



      // foreach($user->exams as $exam){
      //   $count = $count + $exam->getAttemptCount();           
      // }

      if ($search)
        $exams = Exam::where('client', subdomain())->where('name', 'LIKE', "%{$item}%")->orderBy('id', 'desc')->withCount('users')
          ->paginate(8);
      else
        $exams = Cache::remember('exams__' . subdomain(), 60, function () use ($usertests) {
          return $usertests->paginate(8);
        });



      $exam = null;
      $ids = array();
      foreach ($exams as $k => $e) {
        if ($e)
          $exam = $e;

        if (!in_array($e->id, $ids))
          array_push($ids, $e->id);
        else
          unset($exams[$k]);
      }

      //dd($exams);

      $user->attempts = $count;
      $view = $search ? 'snippets.hr_tests' : 'hr_welcome';

      //$e = Exam::where('slug','psychometric-test')->first();
      $e = null;

      if (!$user->isAdmin())
        return view($view)
          ->with('user', $user)
          ->with('exam', $exam)
          ->with('e', $e)
          ->with('exams', $exams);
    }

    if ($user->checkRole(['tpo']) && !$user->isAdmin() && subdomain() != 'packetprep') {

      $search = $request->search;
      $item = $request->item;

      $count = 0;
      $usertests = Exam::where('client', subdomain())->orderBy('id', 'desc');

      $count = Tests_Overall::whereIn('test_id', $usertests->pluck('id')->toArray())->count();
      //$count = count($alltests);



      // foreach($user->exams as $exam){
      //   $count = $count + $exam->getAttemptCount();           
      // }

      if ($search)
        $exams = Exam::where('client', subdomain())->where('name', 'LIKE', "%{$item}%")->orderBy('id', 'desc')
          ->paginate(8);
      else
        $exams = $usertests->paginate(8);

      $exam = null;
      foreach ($exams as $e) {
        if ($e) {
          $exam = $e;
          break;
        }
      }


      $user->attempts = $count;
      $view = $search ? 'snippets.hr_tests' : 'hr_welcome';

      //$e = Exam::where('slug','psychometric-test')->first();
      $e = null;

      if (!$user->isAdmin())
        return view($view)
          ->with('user', $user)
          ->with('exam', $exam)
          ->with('e', $e)
          ->with('exams', $exams);
    }

    $mytests = \auth::user()->tests(1);
    if ($user->role == 12 && subdomain() == 'packetprep') {
      $view = 'admin_pp';
      return view($view)->with('user', $user)->with('data', $data)->with('mytests', $mytests);
    }




    if ($_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in')
      $view = 'xplore_dashboard';
    else if (subdomain() == 'packetprep')
      $view = 'client_pp';
    else
      $view = 'client_dashboard';

    if (request()->get('mytests'))
      $view = 'xplore_dashboard2';

    return view($view)->with('user', $user)->with('data', $data)->with('mytests', $mytests);
  }

  // public function paginate($items, $perPage = 15, $page = null, $options = [])
  // {
  //   $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

  //   $items = $items instanceof Collection ? $items : Collection::make($items);

  //   return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
  // }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $product = new Product();
    $this->authorize('create', $product);

    $exams = Exam::all();
    $courses = Course::all();

    return view('appl.product.product.createedit')
      ->with('stub', 'Create')
      ->with('exams', $exams)
      ->with('courses', $courses)
      ->with('jqueryui', true)
      ->with('editor', true)
      ->with('product', $product);
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Product $product, Request $request)
  {
    try {

      if (!$request->slug)
        $request->slug  = $request->name;
      $request->slug = strtolower(str_replace(' ', '-', $request->slug));

      if (!$request->discount)
        $request->merge(['discount', 0]);

      $exams = $request->get('exams');
      $courses = $request->get('courses');

      $product->name = $request->name;
      $product->slug = $request->slug;
      $product->description = ($request->description) ? $request->description : null;
      $product->price = $request->price;
      $product->status = $request->status;
      $product->discount = $request->discount;
      $product->validity = $request->validity;
      $product->save();

      if ($exams) {
        $product->exams()->detach();
        foreach ($exams as $exam) {
          if (!$product->exams->contains($exam))
            $product->exams()->attach($exam);
        }
      } else {
      }

      if ($courses) {
        $product->courses()->detach();
        foreach ($courses as $course) {
          if (!$product->courses->contains($course))
            $product->courses()->attach($course);
        }
      } else {
        $product->courses()->detach();
      }

      flash('A new product(' . $request->name . ') is created!')->success();
      return redirect()->route('product.index');
    } catch (QueryException $e) {
      $error_code = $e->errorInfo[1];
      if ($error_code == 1062) {
        flash('The slug(<b>' . $request->slug . '</b>) is already taken. Kindly use a different slug.')->error();
        return redirect()->back()->withInput();;
      }
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $product = Product::where('slug', $id)->first();




    $this->authorize('view', $product);

    if ($product)
      return view('appl.product.product.show')
        ->with('product', $product);
    else
      abort(404);
  }


  public function products(Product $product, Request $request)
  {

    $search = $request->search;
    $item = $request->item;





    if (subdomain() == strtolower(env('APP_NAME')))
      $products = $product->where('name', 'LIKE', "%{$item}%")
        ->orderBy('created_at', 'desc ')
        ->paginate(config('global.no_of_records'));
    else {
      $client = client::where('slug', subdomain())->first();
      $products = $client->products()->paginate(config('global.no_of_records'));


      // $products = $product->where('name','LIKE',"%{$item}%")
      //           ->orderBy('created_at','desc ')
      //           ->paginate(config('global.no_of_records'));  
    }
    // $products = $product->where('name','LIKE',"%{$item}%")->where('status',1)
    //             ->orderBy('created_at','desc ')
    //             ->paginate(config('global.no_of_records'));   
    $view = $search ? 'list2' : 'index2';

    return view('appl.product.product.' . $view)
      ->with('products', $products)->with('product', $product);
  }

  public function transactions($id)
  {
    $user = \auth::user();

    if (request()->get('role'))
      dd($user->role);

    if (!$user)
      abort(403, 'Login to view th page!');

    if (!$user->isSiteAdmin())
      abort(403, 'Not athorized to view this page!');

    $product = Product::where('slug', $id)->with('orders')->first();
    $orderids = $product->orders->pluck('id')->toArray();


    $orders = Order::whereIn('id', $orderids)->orderBy('id', 'desc')->with('user')->paginate(20);

    $status = array("incomplete" => 0, "complete" => 0, "total" => 0);
    foreach ($product->orders as $o) {
      if ($o->status == 0 || $o->status == 2)
        $status['incomplete']++;
      else if ($o->status == 1)
        $status['complete']++;
      $status['total']++;
    }


    return view('appl.product.product.transactions')
      ->with('product', $product)
      ->with('orders', $orders)
      ->with('status', $status);
  }

  public function page($id)
  {
    $product = Product::where('slug', $id)->first();


    $user = \Auth::user();
    $entry = null;
    if ($user)
      $entry = DB::table('product_user')
        ->where('product_id', $product->id)
        ->where('user_id', $user->id)
        ->orderBy('id', 'desc')
        ->first();


    if ($product)
      return view('appl.product.product.page')
        ->with('entry', $entry)
        ->with('product', $product);
    else
      return view('appl.product.product.pageerror')
        ->with('product', $product);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $product = Product::where('slug', $id)->first();
    $this->authorize('update', $product);
    $exams = Exam::all();
    $courses = Course::all();



    if ($product)
      return view('appl.product.product.createedit')
        ->with('stub', 'Update')
        ->with('jqueryui', true)
        ->with('editor', true)
        ->with('exams', $exams)
        ->with('courses', $courses)
        ->with('product', $product);
    else
      abort(404);
  }

  function csvToArray($filename = '', $delimiter = ',')
  {
    if (!file_exists($filename) || !is_readable($filename))
      return false;

    $header = null;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== false) {
      while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
        if (!$header)
          $header = $row;
        else
          $data[] = array_combine($header, $row);
      }
      fclose($handle);
    }

    return $data;
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $slug)
  {
    try {
      $product = Product::where('slug', $slug)->first();

      $this->authorize('update', $product);

      if (!$request->discount)
        $request->merge(['discount', 0]);

      $exams = $request->get('exams');
      $courses = $request->get('courses');
      $product->name = $request->name;
      $product->slug = $request->slug;
      $product->description = ($request->description) ? $request->description : null;
      $product->price = $request->price;
      $product->validity = $request->validity;
      $product->discount = $request->discount;
      $product->status = $request->status;

      if ($exams) {
        $product->exams()->detach();
        foreach ($exams as $exam) {
          if (!$product->exams->contains($exam))
            $product->exams()->attach($exam);
        }
      } else {
      }

      if ($courses) {
        $product->courses()->detach();
        foreach ($courses as $course) {
          if (!$product->courses->contains($course))
            $product->courses()->attach($course);
        }
      } else {
        $product->courses()->detach();
      }


      if (isset($request->all()['file'])) {

        $file      = $request->all()['file'];
        if (strtolower($file->getClientOriginalExtension()) != 'csv') {
          flash('Supports only .csv files')->error();
          return redirect()->back()->withInput();
        }

        $data = $this->csvToArray($file);
        $not_found = [];
        $found = [];
        for ($i = 0; $i < count($data); $i++) {
          $email = $data[$i]['email'];
          $client_slug = $data[$i]['client_slug'];
          $validity = $data[$i]['validity'];
          $u = User::where('email', $email)->where('client_slug', $client_slug)->first();
          $valid_till = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") . ' + ' . ($validity * 31) . ' days'));


          if ($u) {
            array_push($found, $email);
            if (!$u->products->contains($product->id))
              $u->products()->attach($product->id, ['validity' => $validity, 'created_at' => date("Y-m-d H:i:s"), 'valid_till' => $valid_till, 'status' => 1]);
            else {
              $u->products()->detach($product->id);
              $u->products()->attach($product->id, ['validity' => $validity, 'created_at' => date("Y-m-d H:i:s"), 'valid_till' => $valid_till, 'status' => 1]);
            }
          } else {
            array_push($not_found, $email);
          }
        }

        flash('Successfully attached products to (' . count($found) . ') users and not found users is (' . count($not_found) . ').')->success();
      }



      $product->save();

      flash('Product (<b>' . $request->name . '</b>) Successfully updated!')->success();
      return redirect()->route('product.show', $request->slug);
    } catch (QueryException $e) {
      $error_code = $e->errorInfo[1];
      if ($error_code == 1062) {
        flash('The slug(<b>' . $request->slug . '</b>) is already taken. Kindly use a different slug.')->error();
        return redirect()->back()->withInput();
      }
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $product = Product::where('id', $id)->first();
    $this->authorize('update', $product);
    $product->delete();

    flash('Product Successfully deleted!')->success();
    return redirect()->route('product.index');
  }


  public function editor(Request $request)
  {
    $cpp = $request->get('code');

    $data = null;
    if ($cpp) {
      $data = $this->compile($cpp);
    }

    return view('appl.product.pages.editor')
      ->with('editor', true)
      ->with('code', true)
      ->with('cpp', $cpp)
      ->with('data', $data);
  }

  public function compile($code)
  {
    // Get cURL resource
    $curl = curl_init();
    // Set some options - we are passing in a useragent too here

    $code = json_encode($code);

    $headers = [
      'Authorization: Token bba456d8-b9c9-4c80-bb84-39d44c5b0acb',
      'Content-type: application/json'
    ];

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt_array($curl, [
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => 'https://run.glot.io/languages/c/latest',
      CURLOPT_POST => 1,
    ]);

    //$data ='{"command": "clang main.c && ./a.out 33","files": [{"name": "main.c", "content": '.$code.'}]}';
    $data = '{"files": [{"name": "main.c", "content": ' . $code . '}]}';
    //echo $data;
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    // Send the request & save response to $resp
    $resp = json_decode(curl_exec($curl));


    // Close request to clear up some resources
    curl_close($curl);

    if ($resp->error) {
      $data = "";
      $data = $data . $resp->stderr;
    } else {
      $data = "";
      $data = $data . $resp->stdout;
    }


    return $data;
  }
}
