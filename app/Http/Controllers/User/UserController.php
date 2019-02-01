<?php

namespace PacketPrep\Http\Controllers\User;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\User;
use PacketPrep\Models\User\User_Details;
use PacketPrep\Models\User\Role;
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
                if(!isset($user_details))
                    $view = 'index';

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
                        elseif(auth::user()->id == $user->id || auth::user()->isAdmin())
                            $view = 'index';
                        else
                            $view = 'private';
                        
                }

                return view('appl.user.'.$view)
                            ->with('user',$user)
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
        if(!$user_details)
            $user_details = new User_Details();
            
        $user_details->countries = $user_details->getCountry();
            
        if($user)
        {
            return view('appl.user.edit')
                    ->with('user',$user)
                    ->with('editor',true)
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

        $user_details->bio = scriptStripper(summernote_imageupload($user,$request->bio));
        //dd($user_details->bio);
        $user_details->country = $request->country;
        $user_details->city = ($request->city)?$request->city:' ';
        $user_details->facebook_link = $request->facebook_link;
        $user_details->twitter_link = $request->twitter_link;
        $user_details->privacy = $request->privacy;
        $user_details->phone = $request->phone;
        $user_details->save();
        flash('User data updated!')->success();
        return redirect()->route('profile','@'.$username);

    }

    /**
     * Edit the specified resource from storage by manager
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function manage($username,Request $request)
    {
        $username = substr($username, 1);
        $user = User::where('username',$username)->first();
        $this->authorize($user);

        $user_details = User_Details::where('user_id',$user->id)->first();

        $all_userroles = (new Role)->get()->pluck('id');

        if($request->update)
        {
            if(!$user_details){
                $user_details = new User_Details;
                $user_details->user_id = $user->id;
                $user_details->country = 'IN';
                $user_details->city = '';
            }

            $user_details->designation = $request->designation;
            $user_details->save();
               
                
            foreach($all_userroles as $u_role){
                $role_name = 'role_'.$u_role;
                if($request->$role_name){
                    if(!$user->roles->contains($u_role))
                        $user->roles()->attach($u_role);
                }else{
                    if($user->roles->contains($u_role)){
                        $user->roles()->detach($u_role);
                    }
                }
            }

            $user->status = $request->status;
            $user->save();

            flash('User data updated!')->success();
            return redirect()->route('profile','@'.$username);
        }

        $userroles = array();
        foreach($user->roles as $role){
            array_push($userroles, $role->id);
        }

        $roles = Role::displayUserRoleUnorderedList((new Role)->get()->toTree(),['select_id'=>$userroles]);   

        if($user)
        {
            return view('appl.user.manage')
                    ->with('user',$user)
                    ->with('user_details',$user_details)
                    ->with('roles',$roles);
        }else
            abort(404,'User not found');
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
