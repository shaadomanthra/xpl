<?php

namespace PacketPrep\Http\Controllers\User;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\User;
use PacketPrep\Models\User\User_Details;
use PacketPrep\Models\College\College;
use PacketPrep\Models\College\Branch;
use PacketPrep\Models\User\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

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

                if(Storage::disk('public')->exists('articles/profile_'.$user->username.'.jpg'))
                {
                    $user->image = asset('/storage/articles/profile_'.$username.'.jpg');
                }
                if(Storage::disk('public')->exists('articles/profile_'.$user->username.'.png'))
                {
                    $user->image = asset('/storage/articles/profile_'.$username.'.png');
                }

                if(Storage::disk('public')->exists('articles/profile_'.$user->username.'.jpeg'))
                {
                    $user->image = asset('/storage/articles/profile_'.$username.'.jpeg');
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

    public function update_user_tables()
    {
        $users = User::whereNull('college_id')->get();
        $user_ids = $users->pluck('id')->toArray();

        $user_details = User_Details::whereIn('user_id',$user_ids)->get()->groupBy('user_id');

        foreach($users as $user){
            //dd($user_details[$user->id][0]['phone']);
            $user->roll_number = $user_details[$user->id][0]['roll_number'];
            $user->year_of_passing = $user_details[$user->id][0]['year_of_passing'];
            $user->phone = $user_details[$user->id][0]['phone'];
            //dd($user->colleges->first());
            if($user->colleges)
            $user->college_id = $user->colleges->first()->id;
            if($user->branches->first())
            $user->branch_id = $user->branches->first()->id;

            echo $user->id.' - '.$user->name.'<br>';
            $user->save();
        }
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

        $colleges = College::orderby('name','asc')->get();
        $branches = Branch::all();

            
        if($user)
        {
            return view('appl.user.edit')
                    ->with('user',$user)
                    ->with('colleges',$colleges)
                    ->with('branches',$branches)
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

        /* If image is given upload and store path */
            if(isset($request->all()['file_'])){

                $image = '/articles/profile_'.$username;
            
                if(Storage::disk('public')->exists($image.'.jpg')){
                    Storage::disk('public')->delete($image.'.jpg');
                }

                 if(Storage::disk('public')->exists($image.'.png')){
                    Storage::disk('public')->delete($image.'.png');
                }

                 if(Storage::disk('public')->exists($image.'.jpeg')){
                    Storage::disk('public')->delete($image.'.jpeg');
                }

                $file      = $request->all()['file_'];
                $filename = 'profile_'.$username.'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('articles', $request->file('file_'),$filename);
                $request->merge(['image' => $path]);

            }else{
                $request->merge(['image' => '']);
            }

        $user->video = $request->get('video');
        
       
        
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

        $user->hometown = $request->hometown;
        $user->current_city = ($request->city)?$request->city:' ';
        $user->gender = $request->gender;
        $user->dob = $request->dob;
        $user->tenth = $request->tenth;
        $user->twelveth = $request->twelveth;
        $user->bachelors = $request->graduation;
        $user->masters = $request->masters;
        $user->year_of_passing = $request->year_of_passing;
        

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


        $college_id = $request->get('college_id');
        $branches = $request->get('branches');

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
        if($college_id){
            $user->colleges()->detach();
            $user->colleges()->attach($college_id);
        }

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

    public function certificate($user){

        if($user=='sample'){
            $user = User::where('username','demo123')->first();
            
            return view('appl.user.certificate')
                    ->with('user',$user);
        }else{
            $user = User::where('username',$user)->first();
            if($user){

                if(count($user->referrals)>=50){
                    return view('appl.user.certificate')
                    ->with('user',$user);
                }else{
                    abort('403','referrals Credits are less than 50');
                }

            }else{
                abort('404','page not found');
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
        //
    }
}
