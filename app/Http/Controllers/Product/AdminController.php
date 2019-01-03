<?php

namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Product\Client;
use PacketPrep\Models\Course\Course;
use PacketPrep\Models\Product\Product;
use PacketPrep\Models\User\Role;
use PacketPrep\User;
use Intervention\Image\ImageManagerStatic as Image;

use PacketPrep\Models\User\User_Details;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use PacketPrep\Mail\ActivateUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$slug = subdomain();
        //$client = client::where('slug',$slug)->first();
        //$this->authorize('view', $client);


        return view('appl.product.admin.index');//->with('client',$client);
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
        $user = new User();
        $search = $request->search;
        $item = $request->item;
        $recent = $request->get('recent');

        if($recent){
        $users = $user->where(function ($query) use ($item) {
                                $query->where('name','LIKE',"%{$item}%")
                                      ->orWhere('email', 'LIKE', "%{$item}%");
                            })->orderBy('updated_at','desc')->paginate(config('global.no_of_records'));
        }else
        $users = $user->where(function ($query) use ($item) {
                                $query->where('name','LIKE',"%{$item}%")
                                      ->orWhere('email', 'LIKE', "%{$item}%");
                            })->orderBy('created_at','desc')->paginate(config('global.no_of_records'));
        
        $view = $search ? 'list': 'index';

        return view('appl.product.admin.user.'.$view)->with('users',$users);
    }

    public function adduser(Request $request)
    {

        return view('appl.product.admin.user.createedit')->with('stub','Create');
    }

    public function storeuser(Request $request)
    {
        

        list($u, $domain) = explode('@', $request->email);

        if ($domain != 'gmail.com') {
            flash('Kindly use only gmail.com for email address.')->error();
                 return redirect()->back()->withInput();
        }

        $user = User::where('email',$request->email)->first();

        if($user){
                flash('The user (<b>'.$request->email.'</b>) account exists. Kindly use a different email.')->error();
                 return redirect()->back()->withInput();
        }



        $parts = explode("@", $request->email);
        $username = $parts[0];
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
            'activation_token' => $password,
            'status'=>1,
        ]);

        $user->password = $password;

        Mail::to($user->email)->send(new ActivateUser($user));

        flash('A new user('.$request->name.') is created!')->success();
        return redirect()->route('admin.user.view',$user->username);

    }

    public function viewuser($id,Request $request)
    {
        $user = User::where('username',$id)->first();
        return view('appl.product.admin.user.show')->with('user',$user);
    }

    public function edituser($id,Request $request)
    {
        $user = User::where('username',$id)->first();

        return view('appl.product.admin.user.createedit')->with('user',$user)->with('stub','Update');
    } 


    public function updateuser($id,Request $request)
    {
        $user = User::where('username',$id)->first();

        $user->name = $request->get('name');
        $user->status = $request->get('status');
        $user->save();

        flash('User('.$user->email.') details updated!')->success();
        return redirect()->route('admin.user.view',$user->username);
    } 

    public function userproduct($id)
    {
        $products = Product::where('status',1)->get();
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
                if($product->status!=0)
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
