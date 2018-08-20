<?php

namespace PacketPrep\Http\Controllers\Product;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\User;
use PacketPrep\Models\Product\Client;
use PacketPrep\Models\User\User_Details;
use PacketPrep\Models\User\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use PacketPrep\Mail\ActivateUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;

class ClientuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function index($client, Request $request)
    {

        $search = $request->search;
        $item = $request->item;
        $client = client::where('slug',$client)->first();

        $user = new user();
        $users = $user->where('name','LIKE',"%{$item}%")
                        ->where('client_slug',$client->slug)
                        ->whereHas('roles', function ($query) {
                            $query->wherein('slug',  ['client-manager','client-owner']);
                        })
                        ->orderBy('name','asc')
                        ->paginate(config('global.no_of_records'));
        
        $view = $search ? 'list': 'index';
        return view('appl.product.clientuser.'.$view)->with('users',$users)->with('stub','Users')->with('client',$client);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($client)
    {
        $client = client::where('slug',$client)->first();
        $clientuser = new User();
        return view('appl.product.clientuser.createedit')
                ->with('stub','Create')
                ->with('client',$client)
                ->with('clientuser',$clientuser);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($client,Request $request)
    {

        $client = client::where('slug',$client)->first();
        $user = User::where('email',$request->email)->first();

        if($user){
                flash('The user (<b>'.$request->email.'</b>) account exists. Kindly use a different email.')->error();
                 return redirect()->back()->withInput();
        }

        $parts = explode("@", $request->email);
        $username = $parts[0];
        $client_slug = $client->slug;
        $password = str_random(5);
        
        $user = User::create([
            'name' => $request->name,
            'username' => $username,
            'email' => $request->email,
            'client_slug' => $client_slug,
            'password' => bcrypt($password),
            'activation_token' => str_random(20),
            'status'=>1,
        ]);

        $user->password = $password;


        if(!$user->roles->contains($request->role)){
            $user->roles()->attach($request->role);
        }

        if($request->role == 32){
            $client->user_id_owner = $user->id;
        }elseif($request->role == 33){
            $client->user_id_manager = $user->id;
        }
        $client->save();

        Mail::to($user->email)->send(new ActivateUser($user));

        flash('A new user('.$request->name.') is created!')->success();
            return redirect()->route('clientuser.index',$client->slug);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($client,$id)
    {
        $client = client::where('slug',$client)->first();

        $clientuser =User::where('username',$id)->first();

        if($clientuser->roles->find(32))
            $clientuser->role = 32;
        elseif($clientuser->roles->find(33))
            $clientuser->role = 33;
        elseif($clientuser->roles->find(36))
            $clientuser->role = 36;

        return view('appl.product.clientuser.createedit')
                ->with('stub','Update')
                ->with('client',$client)
                ->with('clientuser',$clientuser);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $client,$id)
    {
        $client = client::where('slug',$client)->first();
        $user =User::where('username',$id)->first();



        if(!$user->roles->contains($request->role)){
            $user->roles()->detach([32,33,36]);
            $user->roles()->attach($request->role);
        }

        if($request->role == 32){
            $client->user_id_owner = $user->id;
        }elseif($request->role == 33){
            $client->user_id_manager = $user->id;
        }
        $client->save();


        flash('User('.$request->name.') Record updated!')->success();
            return redirect()->route('clientuser.index',$client->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
