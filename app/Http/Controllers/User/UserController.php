<?php

namespace PacketPrep\Http\Controllers\User;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\User;
use PacketPrep\Models\User\User_Details;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($username)
    {
        
        if(strpos($username,'@')===0)
        {

            $username = substr($username, 1);
            $user = User::where('username',$username)->first();
            $user_details = User_Details::where('user_id',$user->id)->first();


            if($user)
            {
                if(!isset($user_details->privacy))
                    $view = 'private';

                elseif($user_details->privacy==0)
                    $view = 'index';
                elseif($user_details->privacy==1){

                    if(auth::user())
                      $view = 'index';
                      else
                        $view = 'private';

                }else{

                        if(!auth::user())
                            $view = 'private';
                        elseif(auth::user()->id == $user->id)
                            $view = 'index';
                        else
                            $view = 'private';
                        
                }

                return view('appl.user.'.$view)
                            ->with('user',$user)
                            ->with('mathjax',true)
                            ->with('user_details',$user_details);

            }else{
                abort(404);
                }
        }
        else
            abort(404);
       
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($username)
    {

        $username = substr($username, 1);
        $user = User::where('username',$username)->first();
        $this->authorize($user);
        $user_details = User_Details::where('user_id',$user->id)->first();
        $user_details->countries = $user_details->country();
        if($user)
        {
            return view('appl.user.edit')
                    ->with('user',$user)
                    ->with('user_details',$user_details);
        }else
            abort(404,'User not found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $username)
    {
        
        $username = substr($username, 1);
        $user = User::where('username',$username)->first();
        $user_details = User_Details::where('user_id',$user->id)->first();
        $this->authorize($user);
        /* create user details if not defined */
        if(!$user_details)
        {
            $user_details_new = new User_Details;
            $user_details_new->user_id = $user->id;
            $user_details_new->country = 'IN';
            $user_details_new->city = '';
            $user_details_new->save();
            $user_details = User_Details::where('user_id',$user->id)->first();
        }

        // update basic data
        $user->name = $request->name;
        if($request->password){
            if($request->password == $request->repassword)
                $user->password = Hash::make($request->password);
            else
            {
                flash('Password and Repassword mismatch...kindly re-enter password')->error();
                 return redirect()->back()->withInput();
            }
        }
        $user->save();


        //update user details
        $user_details->user_id = $user->id;
        $user_details->bio = summernote_imageupload($user,$request->bio);
        $user_details->country = $request->country;
        $user_details->city = ($request->city)?$request->city:' ';
        $user_details->facebook_link = $request->facebook_link;
        $user_details->twitter_link = $request->twitter_link;
        $user_details->privacy = $request->privacy;
        $user_details->save();
        flash('User data updated!')->success();
        return redirect()->route('profile','@'.$username);

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
