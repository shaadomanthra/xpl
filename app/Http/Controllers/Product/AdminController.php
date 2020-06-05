<?php

namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Product\Client;
use PacketPrep\Models\Dataentry\Question;
use PacketPrep\Models\Dataentry\Category;
use PacketPrep\Models\Dataentry\Project;
use PacketPrep\Models\Course\Course;
use PacketPrep\Models\Product\Product;
use PacketPrep\Models\User\Role;
use PacketPrep\User;
use Intervention\Image\ImageManagerStatic as Image;

use PacketPrep\Models\User\User_Details;
use PacketPrep\Models\College\College;
use PacketPrep\Models\College\Zone;
use PacketPrep\Models\College\Ambassador;
use PacketPrep\Models\Course\Practice;
use PacketPrep\Models\College\Service;
use PacketPrep\Models\College\Metric;
use PacketPrep\Models\College\Branch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use PacketPrep\Mail\ActivateUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function __construct(){
        $this->cache_path =  '../storage/app/cache/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        ini_set('memory_limit', '-1');
        //$slug = subdomain();
        //$client = client::where('slug',$slug)->first();
        //$this->authorize('view', $client);

        if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager']))
        {
             abort(403,'Unauthorised Access');   
        }

        $data = array();
        $users = new AdminController;
        $extension = 'json';

        $filename  = $this->cache_path.'analytics_'.substr (url('/'), 8,5).'.' . $extension;
       

        $services = Service::all();
        $zones = Zone::all();
        $branches = Branch::all();
        $metrics = Metric::all();

        if(file_exists($filename) && !$request->get('refresh')){
            $data =   json_decode(file_get_contents($filename),true);
            $data['users']['total'] = User::count();

            return view('appl.product.admin.index')
                    ->with('users',$users)
                    ->with('metrics',$metrics)
                    ->with('branches',$branches)
                    ->with('services',$services)
                    ->with('zones',$zones)
                    ->with('data',$data);
        }else{
        
        $data['users']['total'] = User::count();

        $last_year = (new \Carbon\Carbon('first day of last year'))->year;
        $this_year = (new \Carbon\Carbon('first day of this year'))->year;


        $last_year_first_day = (new \Carbon\Carbon('first day of January '.$last_year))->startofMonth()->toDateTimeString();
        $this_year_first_day = (new \Carbon\Carbon('first day of January '.$this_year))->startofMonth()->toDateTimeString();

        $users->last_year  = User::where('created_at','>', $last_year_first_day)->where('created_at','<', $this_year_first_day)->count();
        $users->this_year  = User::where(DB::raw('YEAR(created_at)'), '=', $this_year)->count();

        $data['users']['last_year'] =$users->last_year;
        $data['users']['this_year'] = $users->this_year;


        $last_month_first_day = (new \Carbon\Carbon('first day of last month'))->startofMonth()->toDateTimeString();
        $this_month_first_day = (new \Carbon\Carbon('first day of this month'))->startofMonth()->toDateTimeString();
        
        $users->last_month  = User::where('created_at','>', $last_month_first_day)->where('created_at','<', $this_month_first_day)->count();
        $users->this_month  = User::where(DB::raw('MONTH(created_at)'), '=', date('n'))->count();

        $data['users']['last_month'] = $users->last_month;
        $data['users']['this_month'] = $users->this_month;

        

        foreach($metrics as $metric){
            $data['metric'][$metric->name] = count($metric->users);
        }
        

        foreach($branches as $branch){
            $data['branch'][$branch->name] = count($branch->users);
        }
        

        foreach($zones as $zone){
            $data['zone'][$zone->name]['users'] = count($zone->users);
            $data['zone'][$zone->name]['colleges'] = count($zone->colleges);
        }

         file_put_contents($filename, json_encode($data,JSON_PRETTY_PRINT));

        }
           

        if($request->get('refresh')){
            
            file_put_contents($filename, json_encode($data,JSON_PRETTY_PRINT));
        }    

        return view('appl.product.admin.index')
                    ->with('users',$users)
                    ->with('metrics',$metrics)
                    ->with('branches',$branches)
                    ->with('services',$services)
                    ->with('zones',$zones)
                    ->with('data',$data);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        $slug = subdomain();
        $client = client::where('slug',$slug)->first();
        $courses = $client->courses;
        $this->authorize('edit', $client);

        $users = array();
        $users['client_owner'] = Role::getUsers('client-owner');
        $users['client_manager'] = Role::getUsers('client-manager');

        if($client)
            return view('appl.product.admin.settings')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('users',$users)
                ->with('courses',$courses)
                ->with('client',$client);
        else
            abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function settings_store(Request $request)
    {
        $slug = subdomain();
        $courses = $request->get('course');

        try{
            $request->slug = str_replace(' ', '-', $request->slug);
            $client = client::where('slug',$slug)->first();

            $client->name = $request->name;
            $client->contact = htmlentities($request->contact);
            $client->save(); 

            $course_list =  $client->courses->pluck('id')->toArray();
            //update tags
            if($courses)
            foreach($course_list as $course){
                if(in_array($course, $courses)){
                    $client->updateVisibility($client->id,$course,1);
                        
                }else{
                    $client->updateVisibility($client->id,$course,0);
                }
                
            } else{
                $client->updateVisibility($client->id,null,0);
            }


            unset($client->courses);
            $param = "?";
            foreach($client->toArray() as $key=>$value){
                    $param = $param.$key."=".$value."&";
            }
            $data =  file_get_contents('http://json.onlinelibrary.co/json.php'.$param);

            flash('Your Settings Successfully updated!')->success();
            return redirect()->route('admin.settings');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
                 return redirect()->back()->withInput();
            }
        }
    }


    public function image()
    {
        $slug = subdomain();
        $client = client::where('slug',$slug)->first();
        $this->authorize('edit', $client);


        if($client)
            return view('appl.product.admin.image')
                    ->with('client',$client);
        else
            abort(404);
    }

            /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function imageupload(Request $request)
    {

        try{
            $request->client_slug = str_replace(' ', '-', $request->client_slug);
            $slug = subdomain();
            $client = client::where('slug',$slug)->first();

           // Image::make(Input::file('image'))->resize(300, 200)->save('foo.jpg');
            //dd($request->all());
            //$path = $request->file('')->store('img/clients');

            $img = Image::make($_FILES['input_img']['tmp_name']);

            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            // save image
            $img->save('img/clients/'.$request->client_slug.'.png');


            flash('Image is successfully uploaded!')->success();
            return view('appl.product.admin.image')
                    ->with('client',$client);
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('The image could not be uploaded')->error();
                 return redirect()->back()->withInput();
            }
        }
        
    }
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager']))
        {
             abort(403,'Unauthorised Access');   
        }

        $user = new User();
        $search = $request->search;
        $item = $request->item;
        $recent = $request->get('recent');
        $metric = $request->get('metric');

        if($recent){
        $users = $user->where(function ($query) use ($item) {
                                $query->where('name','LIKE',"%{$item}%")
                                      ->orWhere('email', 'LIKE', "%{$item}%")->orWhere('phone', 'LIKE', "%{$item}%");
                            })->orderBy('updated_at','desc')->paginate(config('global.no_of_records'));
        }elseif($metric){
            $m = Metric::where('name',$metric)->first();
        $users = $m->users()->orderBy('created_at','desc')->paginate(config('global.no_of_records'));

        }else{
            $users = $user->where('name','LIKE',"%{$item}%")
                                      ->orWhere('email', 'LIKE', "%{$item}%")->orWhere('phone', 'LIKE', "%{$item}%")->orderBy('created_at','desc')->paginate(config('global.no_of_records'));
                                      
        }
        
        
        $view = $search ? 'list': 'index';

        return view('appl.product.admin.user.'.$view)->with('users',$users)->with('metric',$metric);
    }


    public function estudentregister(Request $request)
    {
       
        $colleges = College::orderBy('name','asc')->get();
         
          


        $filename = '../json/branches.json';
        if(file_exists($filename))
        {
            $branches = json_decode(file_get_contents($filename));
        }else{
            $branches =  Branch::all();
            file_put_contents($filename, json_encode($branches,JSON_PRETTY_PRINT));
        }

        $filename = '../json/krishnateja.json';
        if(file_exists($filename))
        {
            $user = json_decode(file_get_contents($filename));
        }else{
            $user =  User::where('username','krishnateja')->first();
            file_put_contents($filename, json_encode($user,JSON_PRETTY_PRINT));
        }

        if($request->code){
            /* programs */
            $programs = ['aspire','elevate','accelerate','grandmaster'];
            if(!in_array(strtolower($request->code), $programs)){
                $u = User::where('username',$request->code)->first();
                if($u)
                    $user = $u;
            }
        }


        return view('appl.product.admin.user.estudentproduct')
            ->with('stub','Create')
            ->with('colleges',$colleges)
            ->with('recaptcha',1)
                ->with('user',$user)
                ->with('branches',$branches);
    }


    public function sstudentregister(Request $request)
    {
        $colleges = College::orderBy('name','asc')->get();
        $metrics = Metric::all();
        $services = Service::all();
        $branches = Branch::all();

        if(!$request->code)
            $user = User::where('username','krishnateja')->first();
        else
            $user = User::where('username',$request->code)->first();
        

        return view('appl.product.admin.user.register')
            ->with('stub','Create')
            ->with('colleges',$colleges)
                ->with('services',$services)
                ->with('metrics',$metrics)
                ->with('user',$user)
                ->with('branches',$branches);
    }

    public function dstudentregister(Request $request)
    {
        $colleges = College::orderBy('created_at','desc')->get();
        $metrics = Metric::all();

        $services = Service::all();
        $branches = Branch::all();

         if(!$request->code)
            abort('403','Activation code Required');
        else
            $user = User::where('username',$request->code)->first();

        return view('appl.product.admin.user.dstudentproduct')
            ->with('stub','Create')
            ->with('colleges',$colleges)
                ->with('services',$services)
                ->with('metrics',$metrics)
                ->with('user',$user)
                ->with('branches',$branches);
    }




    public function adduser(Request $request)
    {
        $colleges = College::orderBy('name','asc')->get();
        $metrics = Metric::all();
        $services = Service::all();
        $branches = Branch::all();
        $clients = Client::orderBy('name','asc')->get();


        if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager']))
        {
             abort(403,'Unauthorised Access');   
        }

        return view('appl.product.admin.user.createedit')
            ->with('stub','Create')
            ->with('colleges',$colleges)
                ->with('services',$services)
                ->with('metrics',$metrics)
                ->with('clients',$clients)
                ->with('branches',$branches);
    }

    public function studentstore(Request $request)
    {
        /* programs */
        $programs = ['aspire','elevate','accelerate','grandmaster'];

        //dd($request->all());
        $direct = $request->get('type');
        $coll = $request->get('coll');

        if($request->name==null){
            flash('Name cannot be empty')->error();
                 return redirect()->back()->withInput();
        }

        if($request->email==null){
            flash('Email cannot be empty')->error();
                 return redirect()->back()->withInput();
        }

        if($request->roll_number==null){
            flash('Roll Number number cannot be empty')->error();
                 return redirect()->back()->withInput();
        }

        if($request->phone==null){
            flash('Phone number cannot be empty')->error();
                 return redirect()->back()->withInput();
        }

        if($request->code != null){
            if(!in_array(strtolower($request->code), $programs)){
                $us = User::where('username',$request->code)->first();
                if($us){
                    $request->user_id = $us->id;
                } 
            }
        }
        

        // list($u, $domain) = explode('@', $request->email);
        // if ($domain != 'gmail.com') {
        //     flash('Kindly use only gmail.com for email address.')->error();
        //          return redirect()->back()->withInput();
        // }

        $user = User::where('email',$request->email)->first();

        if($user){
            flash('The user (<b>'.$request->email.'</b>) account exists. Kindly use the following link to <a href="https://xplore.co.in/password/reset">reset your password</a> or use different email id to create an new account.')->error();
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
            } 

        $parts = explode("@", $request->email);
        $username = $parts[0];
        $password = substr($request->phone,0,4);

        $user = User::where('username',$username)->first();

        if($user){         
            while(1){
                $username = $username.'_'.str_random(5);
                $user = User::where('username',$username)->first();
                if(!$user)
                    break;
            }
        }
        
        $user = User::create([
            'name' => $request->name,
            'username' => $username,
            'email' => $request->email,
            'password' => bcrypt($password),
            'activation_token' => $password,
            'user_id' =>$request->user_id,
            'status'=>1,
        ]);

        $user_details = new user_details;
        $user_details->user_id = $user->id;
        $user_details->bio = $request->get('bio');
        $user_details->country = 'IN';
        $user_details->phone = $request->get('phone');
        $user_details->phone_2 = $request->get('phone_2');
        $user_details->year_of_passing = $request->get('year_of_passing');
        $user_details->roll_number = strtoupper($request->get('roll_number'));
        $user_details->save();

        $college_id = $request->get('college_id');
        $branches = $request->get('branches');
        $services = $request->get('services');
        $metrics = $request->get('metrics');


        if(isset($us)){
            $a = new Ambassador;
            $a->user_id = $us->id;
            $a->uid = $user->id;
            $a->college_id = $college_id;
            $a->mode = 'onboard';
            $a->save();

            if($us->id!=1){
                $coll = null;
            }   

            
        }

        //branches
        $branch_list =  Branch::orderBy('created_at','desc ')
                        ->get()->pluck('id')->toArray();
        if($branches)
            foreach($branch_list as $branch){
                if(in_array($branch, $branches)){
                    $branch_id  = $branch;
                    if(!$user->branches->contains($branch))
                        $user->branches()->attach($branch);
                }else{
                    if($user->branches->contains($branch))
                        $user->branches()->detach($branch);
                }
                
        }else{
                $user->branches()->detach();
        } 

        $user->college_id = $college_id;
        $user->phone = $request->get('phone');
        $user->roll_number = $request->get('roll_number');
        $user->year_of_passing = $request->get('year_of_passing');
        $user->tenth = $request->get('tenth');
        $user->twelveth= $request->get('twelveth');
        $user->bachelors = $request->get('bachelors');
        $user->masters = $request->get('masters');
        $user->hometown = $request->get('hometown');
        $user->current_city = $request->get('current_city');
        $user->gender = $request->get('gender');
        $user->dob = $request->get('dob');

        if(isset($branch_id))
            $user->branch_id = $branch_id;
        else
            $user->branch_id = null;
        $user->save();

        Auth::login($user);

        if(!$coll){
        //pro access
            $pid = 31;
            $month = 12;

            $valid_till = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") .' + '.($month*31).' days'));
            if(!$user->products->contains($pid)){
                $product = Product::where('id',$pid)->first();
                if($product->status!=0)
                    $user->products()->attach($pid,['validity'=>$month,'created_at'=>date("Y-m-d H:i:s"),'valid_till'=>$valid_till,'status'=>1]);
            }
        }

        foreach($programs as $p){
            if(strtolower($request->get('code')) == $p){
               $product = Product::where('slug',$request->get('code'))->first();
                $month = $product->validity;

                $valid_till = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") .' + '.($month*31).' days'));
                if(!$user->products->contains($product->id)){
                    if($product->status!=0)
                        $user->products()->attach($product->id,['validity'=>$month,'created_at'=>date("Y-m-d H:i:s"),'valid_till'=>$valid_till,'status'=>1]);
                } 
            }
        }

        //Services
        $service_list =  Service::orderBy('created_at','desc ')
                        ->get()->pluck('id')->toArray();
        if($services)
            foreach($service_list as $service){
                if(in_array($service, $services)){
                    $s = Service::where('id',$service)->first();
                    
                    if($s->id ==12 ){

                        if($request->user_id == 60 || $request->user_id == 55){
                        //pro access
                        $pid = 31;
                        $month = 3;

                        $valid_till = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") .' + '.($month*31).' days'));
                        if(!$user->products->contains($pid)){
                            $product = Product::where('id',$pid)->first();
                            if($product->status!=0)
                            $user->products()->attach($pid,['validity'=>$month,'created_at'=>date("Y-m-d H:i:s"),'valid_till'=>$valid_till,'status'=>1]);
                            }
                        }

                    }
                    if($s->product){
                    $p = $s->product->price;
                    if($p !=0){
                        if(!$user->services->contains($service))
                        $user->services()->attach($service,['code' => 'D'.$user->id,'status'=>0]);
                    }else{
                        $pid = $s->product->id;
                        $month = 24;
                        if($s->product->validity)
                            $month = $s->product->validity;

                        $valid_till = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") .' + '.($month*31).' days'));
                        if(!$user->products->contains($pid)){
                            $product = Product::where('id',$pid)->first();
                            if($product->status!=0)
                            $user->products()->attach($pid,['validity'=>$month,'created_at'=>date("Y-m-d H:i:s"),'valid_till'=>$valid_till,'status'=>1]);
                        }

                    }
                    }
                }else{
                    if($user->services->contains($service))
                        $user->services()->detach($service);
                }
                
        }else{
                $user->services()->detach();
        } 

        //Metrics
        $metric_list =  Metric::orderBy('created_at','desc ')
                        ->get()->pluck('id')->toArray();
        if($metrics)
            foreach($metric_list as $metric){
                if(in_array($metric, $metrics)){
                    if(!$user->metrics->contains($metric))
                        $user->metrics()->attach($metric);
                }else{
                    if($user->metrics->contains($metric))
                        $user->metrics()->detach($metric);
                }
                
        }else{
                $user->metrics()->detach();
        } 

        if($college_id){
            $user->colleges()->detach();
            $user->colleges()->attach($college_id);
        }

        $col = College::where('id',$college_id)->first();
        $zone_id = $col->zones->first()->id;

        if($zone_id){
            $user->zones()->detach();
            $user->zones()->attach($zone_id);
        }
            


        $user->password = $password;

        Mail::to($user->email)->send(new ActivateUser($user));

        flash('A new user('.$request->name.') is created!')->success();
        if(!$direct)
            return redirect()->route('admin.user.view',$user->username);
        else{
            if ($request->session()->has('redirect.url')) {
                return redirect()->to($request->session()->get('redirect.url')); 
            }else
             return redirect()->route('dashboard');   
        }

    }

    public function storeuser(Request $request)
    {
        
        $direct = $request->get('type');
        list($u, $domain) = explode('@', $request->email);

        // if ($domain != 'gmail.com') {
        //     flash('Kindly use only gmail.com for email address.')->error();
        //          return redirect()->back()->withInput();
        // }

        $user = User::where('email',$request->email)->first();

        if($user){
                flash('The user (<b>'.$request->email.'</b>) account exists. Kindly use a different email.')->error();
                 return redirect()->back()->withInput();
        }



        $parts = explode("@", $request->email);
        $username = $parts[0];
        if($request->get('phone'))
        $password = $request->get('phone');
        else
        $password = str_random(5);

        $user = User::where('username',$username)->first();

        if($user){         
            while(1){
                $username = $username.'_'.str_random(5);
                $user = User::where('username',$username)->first();
                if(!$user)
                    break;
            }
        }

        
        $user = User::create([
            'name' => $request->name,
            'username' => $username,
            'email' => $request->email,
            'password' => bcrypt($password),
            'client_slug' => $request->client_slug,
            'phone' =>$request->get('phone'),
            'activation_token' => $password,
            'user_id' => $request->user_id,
            'status'=>1,
        ]);

        $user_details = new user_details;
        $user_details->user_id = $user->id;
        $user_details->bio = $request->get('bio');
        $user_details->country = 'IN';
        $user_details->phone = $request->get('phone');
        $user_details->phone_2 = $request->get('phone_2');
        $user_details->year_of_passing = $request->get('year_of_passing');
        $user_details->roll_number = $request->get('roll_number');
        $user_details->save();

        $college_id = $request->get('college_id');
        $branches = $request->get('branches');
        $services = $request->get('services');
        $metrics = $request->get('metrics');

        $user->college_id = $college_id;

        //branches
        $branch_list =  Branch::orderBy('created_at','desc ')
                        ->get()->pluck('id')->toArray();
        if($branches)
            foreach($branch_list as $branch){
                if(in_array($branch, $branches)){
                    $user->branch_id = $branch;
                    if(!$user->branches->contains($branch))
                        $user->branches()->attach($branch);
                }else{
                    if($user->branches->contains($branch))
                        $user->branches()->detach($branch);
                }
                
        }else{
                $user->branches()->detach();
        } 

        $user->save();


        if($user->user_id == 60 || $request->user_id == 55){
        //pro access
        $pid = 18;
                        $month = 3;

                        $valid_till = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") .' + '.($month*31).' days'));
                        if(!$user->products->contains($pid)){
                            $product = Product::where('id',$pid)->first();
                            if($product->status!=0)
                            $user->products()->attach($pid,['validity'=>$month,'created_at'=>date("Y-m-d H:i:s"),'valid_till'=>$valid_till,'status'=>1]);
            }
        }

         if($request->get('ambassador')==1){
            if(!$user->roles->contains(37))
                $user->roles()->attach(37);
        }

        if($request->get('ambassador')==2){
            if($user->roles->contains(37))
                $user->roles()->detach(37);
        }

        if($request->get('coordinator')==1){
            if(!$user->roles->contains(40))
                $user->roles()->attach(40);
        }

        if($request->get('coordinator')==2){
            if($user->roles->contains(40))
                $user->roles()->detach(40);
        }

        if($request->get('tpo')==1){
            if(!$user->roles->contains(41))
                $user->roles()->attach(41);
        }

        if($request->get('tpo')==2){
            if($user->roles->contains(41))
                $user->roles()->detach(41);
        }

        if(in_array($request->get('hrmanager'),[10,11,12])){
            if(!$user->roles->contains(28))
                $user->roles()->attach(28);
            $user->role = $request->get('hrmanager');
            $user->save();
        }

        if($request->get('hrmanager')==1){
            if($user->roles->contains(28))
                $user->roles()->detach(28);
            $user->role = $request->get('hrmanager');
            $user->save();
        }

        //Services
        $service_list =  Service::orderBy('created_at','desc ')
                        ->get()->pluck('id')->toArray();
        if($services)
            foreach($service_list as $service){
                if(in_array($service, $services)){
                    $s = Service::where('id',$service)->first();
                    
                    if($s->product){
                    $p = $s->product->price;
                    if($p !=0){
                        if(!$user->services->contains($service))
                        $user->services()->attach($service,['code' => 'D'.$user->id,'status'=>0]);
                    }else{
                        $pid = $s->product->id;
                        $month = 24;
                        if($s->product->validity)
                            $month = $s->product->validity;
                        $valid_till = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") .' + '.($month*31).' days'));
                        if(!$user->products->contains($pid)){
                            $product = Product::where('id',$pid)->first();
                            if($product->status!=0)
                            $user->products()->attach($pid,['validity'=>$month,'created_at'=>date("Y-m-d H:i:s"),'valid_till'=>$valid_till,'status'=>1]);
                        }

                    }
                    }
                }else{
                    if($user->services->contains($service))
                        $user->services()->detach($service);
                }
                
        }else{
                $user->services()->detach();
        } 

        //Metrics
        $metric_list =  Metric::orderBy('created_at','desc ')
                        ->get()->pluck('id')->toArray();
        if($metrics)
            foreach($metric_list as $metric){
                if(in_array($metric, $metrics)){
                    if(!$user->metrics->contains($metric))
                        $user->metrics()->attach($metric);
                }else{
                    if($user->metrics->contains($metric))
                        $user->metrics()->detach($metric);
                }
                
        }else{
                $user->metrics()->detach();
        } 

        if($college_id){
            $user->colleges()->detach();
            $user->colleges()->attach($college_id);
        }

        $col = College::where('id',$college_id)->first();
        $zone_id = $col->zones->first()->id;

        if($zone_id){
            $user->zones()->detach();
            $user->zones()->attach($zone_id);
        }
            


        $user->password = $password;

        //Mail::to($user->email)->send(new ActivateUser($user));

        flash('A new user('.$request->name.') is created!')->success();
        if(!$direct)
        return redirect()->route('admin.user.view',$user->username);
        else
        return view('appl.product.admin.user.successstudent');   

    }

    public function viewuser($id,Request $request)
    {
        if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager']))
        {
             abort(403,'Unauthorised Access');   
        }

        $user = User::where('username',$id)->first();
        return view('appl.product.admin.user.show')->with('user',$user);
    }

    public function listuser(Request $request)
    {
        if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager']))
        {
             abort(403,'Unauthorised Access');   
        }
        $user = new User();
        $search = $request->search;
        $item = $request->item;
        $recent = $request->get('recent');
        $from = $request->get('from');
        $to = $request->get('to');
        
        if($from && $to)
        $users = $user->where('id','>=',$from)->where('id','<=',$to)->orderBy('created_at','desc')->paginate(500);
        else
        $users = $user->orderBy('created_at','desc')->paginate(500);
        
        $view = $search ? 'list': 'index';

        return view('appl.product.admin.user.userlist')->with('users',$users);
    }

    public function printuser($id,Request $request)
    {
        if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager']))
        {
             abort(403,'Unauthorised Access');   
        }

        $user = User::where('username',$id)->first();

        return view('appl.product.admin.user.print')->with('user',$user);
    }

    public function edituser($id,Request $request)
    {
        if(!\auth::user()->checkRole(['administrator','investor','patron','promoter','employee','client-owner','client-manager','manager']))
        {
             abort(403,'Unauthorised Access');   
        }

        $user = User::where('username',$id)->first();
        $user_details = $user->details;
        $colleges = College::orderBy('name','asc')->get();
        $metrics = Metric::all();
        $services = Service::all();
        $branches = Branch::all();
        $clients = Client::all();
        

        return view('appl.product.admin.user.createedit')
                ->with('user',$user)
                ->with('user_details',$user_details)
                ->with('colleges',$colleges)
                ->with('services',$services)
                ->with('metrics',$metrics)
                ->with('branches',$branches)
                ->with('clients',$clients)
                ->with('stub','Update');
    } 


    public function updateuser($id,Request $request)
    {
        $user = User::where('username',$id)->first();


        $user->name = $request->get('name');
        $user->status = $request->get('status');
        $user->phone = $request->get('phone');
        $user->client_slug = $request->get('client_slug');
        $user->year_of_passing = $request->get('year_of_passing');
        $user->roll_number = $request->get('roll_number');

        if($request->get('confidence')){
            $user->confidence = $request->get('confidence');
        }
        
        if($request->get('fluency')){
            $user->fluency = $request->get('fluency');
        }
        
        if($request->get('language')){
            $user->language = $request->get('language');

            $user->personality = round(($user->confidence+$user->fluency+$user->language)/3,1);
        }


        $user->save();

        $user_details = User_Details::where('user_id',$user->id)->first();
        if(!$user_details){
            $user_details = new User_Details;
        }
        $user_details->user_id = $user->id;
        $user_details->country = 'IN';
        $user_details->phone = $request->get('phone');
        $user_details->phone_2 = $request->get('phone_2');
        $user_details->year_of_passing = $request->get('year_of_passing');
        $user_details->roll_number = $request->get('roll_number');


        $user_details->save();


        $college_id = $request->get('college_id');
        $branches = $request->get('branches');
        $services = $request->get('services');
        $metrics = $request->get('metrics');

        //branches
        $branch_list =  Branch::orderBy('created_at','desc ')
                        ->get()->pluck('id')->toArray();
        if($branches)
            foreach($branch_list as $branch){
                if(in_array($branch, $branches)){
                    if(!$user->branches->contains($branch))
                        $user->branches()->attach($branch);
                }else{
                    if($user->branches->contains($branch))
                        $user->branches()->detach($branch);
                }
                
        }else{
                $user->branches()->detach();
        } 

        if($user->user_id == 60 || $request->user_id == 55){
        //pro access
        $pid = 18;
                        $month = 3;

                        $valid_till = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") .' + '.($month*31).' days'));
                        if(!$user->products->contains($pid)){
                            $product = Product::where('id',$pid)->first();
                            if($product->status!=0)
                            $user->products()->attach($pid,['validity'=>$month,'created_at'=>date("Y-m-d H:i:s"),'valid_till'=>$valid_till,'status'=>1]);
            }
        }

        if($request->get('ambassador')==1){
            if(!$user->roles->contains(37))
                $user->roles()->attach(37);
        }

        if($request->get('ambassador')==2){
            if($user->roles->contains(37))
                $user->roles()->detach(37);
        }

        if($request->get('coordinator')==1){
            if(!$user->roles->contains(40))
                $user->roles()->attach(40);
        }

        if($request->get('coordinator')==2){
            if($user->roles->contains(40))
                $user->roles()->detach(40);
        }

         if($request->get('tpo')==1){
            if(!$user->roles->contains(41))
                $user->roles()->attach(41);
        }

        if($request->get('tpo')==2){
            if($user->roles->contains(41))
                $user->roles()->detach(41);
        }

        if(in_array($request->get('hrmanager'),[10,11,12])){
            if(!$user->roles->contains(28))
                $user->roles()->attach(28);
            $user->role = $request->get('hrmanager');
            $user->save();
        }

        if($request->get('hrmanager')==1){
            if($user->roles->contains(28))
                $user->roles()->detach(28);
            $user->role = $request->get('hrmanager');
            $user->save();
        }

        //Services
        $service_list =  Service::orderBy('created_at','desc ')
                        ->get()->pluck('id')->toArray();
        if($services)
            foreach($service_list as $service){
                if(in_array($service, $services)){
                    $s = Service::where('id',$service)->first();
                    
                    if($s->product){
                    $p = $s->product->price;
                    if($p !=0){
                        if(!$user->services->contains($service))
                        $user->services()->attach($service,['code' => 'D'.$user->id,'status'=>0]);
                    }else{
                        $pid = $s->product->id;
                        $valid_till = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") .' + '.(24*31).' days'));
                        if(!$user->products->contains($pid)){
                            $product = Product::where('id',$pid)->first();
                            if($product->status!=0)
                            $user->products()->attach($pid,['validity'=>24,'created_at'=>date("Y-m-d H:i:s"),'valid_till'=>$valid_till,'status'=>1]);
                        }

                    }
                    }
                    
                }else{
                    if($user->services->contains($service))
                        $user->services()->detach($service);
                }
                
        }else{
                $user->services()->detach();
        } 

        //Metrics
        $metric_list =  Metric::orderBy('created_at','desc ')
                        ->get()->pluck('id')->toArray();
        if($metrics)
            foreach($metric_list as $metric){
                if(in_array($metric, $metrics)){
                    if(!$user->metrics->contains($metric))
                        $user->metrics()->attach($metric);
                }else{
                    if($user->metrics->contains($metric))
                        $user->metrics()->detach($metric);
                }
                
        }else{
                $user->metrics()->detach();
        } 

        //dd($college_id);
        if($college_id){
            $user->colleges()->detach();
            $user->colleges()->attach($college_id);
        }

        $col = College::where('id',$college_id)->first();
        $zone_id = $col->zones->first()->id;
        
        if($zone_id){
            $user->zones()->detach();
            $user->zones()->attach($zone_id);
        }


        flash('User('.$user->email.') details updated!')->success();
        return redirect()->route('admin.user.view',$user->username);
    } 

    public function userproduct($id)
    {
        $products = Product::get();
        $user = User::where('username',$id)->first();
        return view('appl.product.admin.user.adduserproduct')->with('products',$products)->with('user',$user);
    } 

    public function storeuserproduct($id,Request $request)
    {
        //dd($request->all());
        $user = User::where('username',$id)->first();

        $valid_till = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") .' + '.(($request->get('validity'))*31).' days'));

        if($request->get('product_id')!=-1){
            if(!$user->products->contains($request->get('product_id'))){
                $product = Product::where('id',$request->get('product_id'))->first();
                
                $user->products()->attach($request->get('product_id'),['validity'=>$request->get('validity'),'created_at'=>date("Y-m-d H:i:s"),'valid_till'=>$valid_till,'status'=>$request->get('status')]);
            }
        }else{
            $products = Product::all();
            foreach($products as $product){
                if(!$user->products->contains($product->id))
                if($product->status!=0)
                $user->products()->attach($product->id,['validity'=>$request->get('validity'),'created_at'=>date("Y-m-d H:i:s"),'valid_till'=>$valid_till,'status'=>$request->get('status')]);
            }

        }

        flash('Product successfully added!')->success();
        return redirect()->route('admin.user.view',$user->username);
    } 


    public function edit_userproduct($id,$product_id){
        $products = Product::where('status',1)->get();
        $product = Product::where('id',$product_id)->first();
        $user = User::where('id',$id)->first();
        return view('appl.product.admin.user.edituserproduct')
                ->with('products',$products)
                ->with('product',$product)
                ->with('user',$user);
    }

    public function update_userproduct($id,$product_id,Request $request){
        //dd($request->all());
        $user = User::where('id',$id)->first();

        $valid_till = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") .' + '.(($request->get('validity'))*31).' days'));

        $status = $request->get('status');
        $validity = $request->get('validity');

        Product::update_pivot($product_id,$id,$validity,$status,$valid_till);

        flash('Product successfully updated!')->success();
        return redirect()->route('admin.user.view',$user->username);
    }

}
