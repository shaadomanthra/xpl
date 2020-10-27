<?php

namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Product\Client;
use PacketPrep\Models\Product\Product;
use PacketPrep\Models\Course\Course;
use PacketPrep\Models\User\Role;
use PacketPrep\User;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;


class ClientController extends Controller
{
    public function __construct(){
        $this->app      =   'product';
        $this->module   =   'client';
        $this->cache_path =  '../storage/app/cache/company/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(client $client,Request $request)
    {
        $this->authorize('view', $client);

        $search = $request->search;
        $item = $request->item;
        $user = \auth::user();
        if($user->role != 2){
           $clients = $client->where('name','LIKE',"%{$item}%")
                            ->withCount('siteusers')
                            ->with('creator')
                            ->where('user_id_creator',$user->id)
                            ->orderBy('created_at','desc ')
                            ->paginate(config('global.no_of_records')); 
        }else{
            $clients = $client->where('name','LIKE',"%{$item}%")
                            ->withCount('siteusers')
                            ->with('creator')
                            ->orderBy('created_at','desc ')
                            ->paginate(config('global.no_of_records'));

        }

        
        $view = $search ? 'list': 'index';

        return view('appl.product.client.'.$view)
        ->with('clients',$clients)->with('client',new client());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new client();
        $courses = Course::all();
        $products = Product::all();

        $this->authorize('create', $client);
        if(!$client->settings){
            $settings['register'] = NULL;
            $settings['change_password'] = NULL;
            $settings['add_users'] = NULL;
            $settings['add_tests'] = NULL;
            $settings['camera'] = NULL;
            $settings['face_detection'] = NULL;
            $settings['proctoring'] = NULL;
            $settings['set_creator'] = NULL;
            $settings['message_d'] = NULL;
            $settings['timer_d'] = NULL;
            $settings['message_l'] = NULL;
            $settings['timer_l'] = NULL;
            $client->settings = json_decode(json_encode($settings));
        }


        $users = array();

        return view('appl.product.client.createedit')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('editor',true)
                ->with('client',$client)
                ->with('courses',$courses)
                ->with('products',$products)
                ->with('users',$users);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(client $client,Request $request)
    {
        $courses = $request->get('course');

        try{
            $request->slug = str_replace(' ', '-', $request->slug);

            $client_exists = client::where('slug',$request->slug)->first();

            if($client_exists){
                flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
                 return redirect()->back()->withInput();
            }

            $client->name = $request->name;
            $client->slug = strtolower($request->slug);
            $client->user_id_creator = $request->user_id_creator;
            $client->user_id_owner = ($request->user_id_owner)?$request->user_id_owner:null;
            $client->user_id_manager = null;
            $client->status = $request->status;
            $client->contact = $request->contact;
            $settings['register'] = $request->get('register');
            $settings['change_password'] = $request->get('change_password');
            $settings['add_users'] = $request->get('add_users');
            $settings['add_tests'] = $request->get('add_tests');
            $settings['camera'] = $request->get('camera');
            $settings['face_detection'] = $request->get('face_detection');
            $settings['proctoring'] = $request->get('proctoring');
            $settings['set_creator'] = $request->get('set_creator');
            $settings['message_d'] = $request->get('message_d');
            $settings['timer_d'] = $request->get('timer_d');
            $settings['message_l'] = $request->get('message_l');
            $settings['timer_l'] = $request->get('timer_l');
            $client->settings = json_encode($settings);

            $client->save(); 

             /* If image is given upload and store path */
            if(isset($request->all()['file_'])){
                $file      = $request->all()['file_'];
                $filename = $request->get('slug').'_header.'.$file->getClientOriginalExtension();
                $path = Storage::disk('s3')->putFileAs('companies', $request->file('file_'),$filename,'public');

            }

            /* If image is given upload and store path */
            if(isset($request->all()['file2_'])){
                $file      = $request->all()['file2_'];
                $filename = $request->get('slug').'_banner.'.$file->getClientOriginalExtension();
                $path = Storage::disk('s3')->putFileAs('companies', $request->file('file2_'),$filename,'public');

            }

            $course_list =  Course::all()->pluck('id')->toArray();
            if($courses)
            foreach($course_list as $course){
                if(in_array($course, $courses)){
                    if(!$client->courses->contains($course))
                        $client->courses()->attach($course,['visible' => 1]);
                }else{
                    if($client->courses->contains($course))
                        $client->courses()->detach($course);
                }
                
            } 


            $products = $request->get('product');
            $product_list =  Product::all()->pluck('id')->toArray();
            if($products)
            foreach($product_list as $product){
                if(in_array($product, $products)){
                    if(!$client->products->contains($product))
                        $client->products()->attach($product);
                }else{
                    if($client->products->contains($product))
                        $client->products()->detach($product);
                }
                
            } 


            // $param = "?";
            // foreach($client->toArray() as $key=>$value){
            //         $param = $param.$key."=".$value."&";
            // }
            Cache::forever('client_'.$client->slug,$client);


            flash('A new client('.$request->name.') is created!')->success();
            return redirect()->route('client.index');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
                 return redirect()->back()->withInput();
            }
        }
        
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

           // Image::make(Input::file('image'))->resize(300, 200)->save('foo.jpg');
            //dd($request->all());
            //$path = $request->file('')->store('img/clients');

            $img = Image::make($_FILES['input_img']['tmp_name']);

            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });


            /* If image is given upload and store path */
            if(isset($request->all()['input_img'])){

                $file      = $request->all()['input_img'];
                $filename = $request->client_slug.'.'.$file->getClientOriginalExtension();

                $path = Storage::disk('s3')->putFileAs('companies', $file,$filename,'public');
            }

            // save image
            //$img->save('img/clients/'.$request->client_slug.'.png');


            flash('Image is successfully uploaded!')->success();
            return redirect()->route('client.show',$request->client_slug);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = client::where('slug',$id)->first();

          if(!$client->settings){
            $settings['register'] = NULL;
            $settings['change_password'] = NULL;
            $settings['add_users'] = NULL;
            $settings['add_tests'] = NULL;
            $settings['camera'] = NULL;
            $settings['face_detection'] = NULL;
            $settings['proctoring'] = NULL;
            $settings['set_creator'] = NULL;
            $settings['message_d'] = NULL;
            $settings['timer_d'] = NULL;
            $settings['message_l'] = NULL;
            $settings['timer_l'] = NULL;
             $client->settings = json_decode(json_encode($settings));
        }else{
            $client->settings = json_decode( $client->settings);
        }

        $this->authorize('edit', $client);

        if(request()->get('delete')=='logo'){
            if(Storage::disk('s3')->exists('companies/'.$client->slug.'.jpg')){
                Storage::disk('s3')->delete('companies/'.$client->slug.'.jpg');
             flash('Logo is deleted.')->error();
            }

            if(Storage::disk('s3')->exists('companies/'.$client->slug.'.png')){
                Storage::disk('s3')->delete('companies/'.$client->slug.'.png');
             flash('Logo is deleted.')->error();
            }

        }

        if(request()->get('delete')=='banner'){
            if(Storage::disk('s3')->exists('companies/'.$client->slug.'_banner.jpg')){
                Storage::disk('s3')->delete('companies/'.$client->slug.'_banner.jpg');
             flash('Dashboard banner is deleted.')->error();
            }

            if(Storage::disk('s3')->exists('companies/'.$client->slug.'_banner.png')){
                Storage::disk('s3')->delete('companies/'.$client->slug.'_banner.png');
             flash('Dashboard banner is deleted.')->error();
            }

        }

        if(request()->get('delete')=='header'){
            if(Storage::disk('s3')->exists('companies/'.$client->slug.'_header.jpg')){
                Storage::disk('s3')->delete('companies/'.$client->slug.'_header.jpg');
             flash('Login page banner image is deleted.')->error();
            }

            if(Storage::disk('s3')->exists('companies/'.$client->slug.'_header.png')){
                Storage::disk('s3')->delete('companies/'.$client->slug.'_header.png');
             flash('Login page banner image is deleted.')->error();
            }

        }

        $hr = Role::where('slug','hr-manager')->first();
        $users = $hr->users;
        
        $u =['attempts_all'=>0,'attempts_thismonth'=>0,'attempts_lastmonth'=>0];

        $test_ids  =$client->exams->pluck('id')->toArray();

        $u['attempts_all'] =  $client->getAttemptCount(null,$test_ids);
        $u['attempts_lastmonth'] =$client->getAttemptCount('lastmonth',$test_ids);
        $u['attempts_thismonth'] = $client->getAttemptCount('thismonth',$test_ids);


        $ucount = [];
        $ucount['users_all'] = User::where('client_slug',$client->slug)->count();
        $ucount['users_lastmonth'] = User::where('client_slug',$client->slug)->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count();
        $ucount['users_thismonth'] =User::where('client_slug',$client->slug)->whereMonth('created_at', '=', Carbon::now()->month)->count();



        if($client)
            return view('appl.product.client.show')
                    ->with('client',$client)
                    ->with('stub',$client->name)
                    ->with('attempts',$u)
                    ->with('users',$ucount);
        else
            abort(404);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = client::where('slug',$id)->first();
        $courses = Course::all();
        $products = Product::all();
        $this->authorize('edit', $client);

        $users = array();
        $users['client_owner'] = Role::getUsers('client-owner');
        $users['client_manager'] = Role::getUsers('client-manager');

        $client->settings = json_decode($client->settings);

        if(!$client->settings){
            $settings['register'] = NULL;
            $settings['change_password'] = NULL;
            $settings['add_users'] = NULL;
            $settings['add_tests'] = NULL;
            $settings['camera'] = NULL;
            $settings['face_detection'] = NULL;
            $settings['proctoring'] = NULL;
            $settings['set_creator'] = NULL;
            $settings['message_d'] = NULL;
            $settings['timer_d'] = NULL;
            $settings['message_l'] = NULL;
            $settings['timer_l'] = NULL;
             $client->settings = json_decode(json_encode($settings));
        }
        

        if($client)
            return view('appl.product.client.createedit')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('editor',true)
                ->with('users',$users)
                ->with('courses',$courses)
                ->with('products',$products)
                ->with('client',$client);
        else
            abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $engineers = $request->get('engineers');
        $courses = $request->get('course');

        Cache::forget('client_'.subdomain());

        try{
            $request->slug = str_replace(' ', '-', $request->slug);
            $client = client::where('id',$id)->first();

            $this->authorize('update', $client);


            $client->name = $request->name;
            $client->slug = strtolower($request->slug);
            $client->status = $request->status;
            $client->contact = htmlentities($request->contact);

            $settings['register'] = $request->get('register');
            $settings['change_password'] = $request->get('change_password');
            $settings['add_users'] = $request->get('add_users');
            $settings['add_tests'] = $request->get('add_tests');
            $settings['camera'] = $request->get('camera');
            $settings['face_detection'] = $request->get('face_detection');
            $settings['proctoring'] = $request->get('proctoring');
            $settings['set_creator'] = $request->get('set_creator');
            $settings['message_d'] = $request->get('message_d');
            $settings['timer_d'] = $request->get('timer_d');
            $settings['message_l'] = $request->get('message_l');
            $settings['timer_l'] = $request->get('timer_l');
            $client->settings = json_encode($settings);

            $client->save(); 

             /* If image is given upload and store path */
            if(isset($request->all()['file_'])){
                $file      = $request->all()['file_'];
                $filename = $request->get('slug').'_header.'.$file->getClientOriginalExtension();
                $path = Storage::disk('s3')->putFileAs('companies', $request->file('file_'),$filename,'public');

            }

            /* If image is given upload and store path */
            if(isset($request->all()['file2_'])){
                $file      = $request->all()['file2_'];
                $filename = $request->get('slug').'_banner.'.$file->getClientOriginalExtension();
                $path = Storage::disk('s3')->putFileAs('companies', $request->file('file2_'),$filename,'public');

            }


            $course_list =  Course::all()->pluck('id')->toArray();
            //update tags
            if($courses)
            foreach($course_list as $course){
                if(in_array($course, $courses)){
                    if(!$client->courses->contains($course))
                        $client->courses()->attach($course,['visible' => 0]);
                }else{
                    if($client->courses->contains($course))
                        $client->courses()->detach($course);
                }
                
            } else{
                $client->courses()->detach();
            }

            $products = $request->get('product');
            $product_list =  Product::all()->pluck('id')->toArray();
            if($products)
            foreach($product_list as $product){
                if(in_array($product, $products)){
                    if(!$client->products->contains($product))
                        $client->products()->attach($product);
                }else{
                    if($client->products->contains($product))
                        $client->products()->detach($product);
                }
                
            }else{
                 $client->products()->detach();
            }


            unset($client->courses);
            unset($client->products);
            // $param = "?";
            // foreach($client->toArray() as $key=>$value){
            //         $param = $param.$key."=".$value."&";
            // }

            Cache::forget('client_'.$client->slug);
            Cache::forever('client_'.$client->slug,$client);
            
            // $filename = $this->cache_path.$client->slug.'.json';
            // file_put_contents($filename, json_encode($client));

            flash('client (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('client.show',$request->slug);
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
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
        $client = client::where('id',$id)->first();
        $this->authorize('update', $client);
        
        $client->delete();
        flash('client Successfully deleted!')->success();
        return redirect()->route('client.index');
       
    }
}
