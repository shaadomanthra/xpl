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
use Carbon\Carbon;
use PacketPrep\Exports\UExport;
use Maatwebsite\Excel\Facades\Excel;
use PacketPrep\Models\College\Metric;
use Illuminate\Support\Facades\Cache;

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

                if(Storage::disk('s3')->exists('articles/profile_'.$user->username.'.jpg'))
                {
                    $user->image = Storage::disk('s3')->url('articles/profile_'.$user->username.'.jpg');
                }
                if(Storage::disk('s3')->exists('articles/profile_'.$user->username.'.png'))
                {
                    $user->image = Storage::disk('s3')->url('articles/profile_'.$user->username.'.png');
                }

                if(Storage::disk('s3')->exists('articles/profile_'.$user->username.'.jpeg'))
                {
                    $user->image = Storage::disk('s3')->url('articles/profile_'.$user->username.'.jpeg');
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

    public function validation(Request $request){
        $user = \auth::user();
        return view('appl.user.validate.index')->with('user',$user);
    }

    public function hrmanagers()
    {

        $hr = Role::where('slug','hr-manager')->first();
        $users = $hr->users;
        

        foreach($users as $k=>$user){

            $users[$k]->attempts_all  =0;
            $users[$k]->attempts_lastmonth =0;
            $users[$k]->attempts_thismonth =0;
        foreach($user->exams as $exam){
            $users[$k]->attempts_all = $users[$k]->attempts_all + $exam->getAttemptCount();
            $users[$k]->attempts_lastmonth = $users[$k]->attempts_lastmonth + $exam->getAttemptCount(null,'lastmonth');
            $users[$k]->attempts_thismonth = $users[$k]->attempts_thismonth + $exam->getAttemptCount(null,'thismonth');
          }
        }
            
        if($users)
        {
            return view('appl.user.hrmanagers')
                    ->with('users',$users);
        }else
            abort(404,'User not found');
    }


    public function userlist(Request $r){



    if(request()->get('export')){
        $users = User::where('client_slug',subdomain())->get();
        request()->session()->put('users',$users);
        $name = "Userlist_".subdomain().".csv";
        ob_end_clean(); // this
        ob_start(); 
        return Excel::download(new UExport, $name, \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);

    }

    $month = $r->get('month');

    if($month=='thismonth')
        $users = User::where('client_slug',subdomain())->whereMonth('created_at', Carbon::now()->month);
    elseif($month=='lastmonth')
        $users = User::where('client_slug',subdomain())->whereMonth('created_at', Carbon::now()->subMonth()->month);
    elseif($month=='lastbeforemonth')
        $users = User::where('client_slug',subdomain())->whereMonth('created_at', Carbon::now()->subMonth(2)->month);
    else
        $users = User::where('client_slug',subdomain())->with('roles');

     if($r->get('role')){
        $rol = $r->get('role');
        $role = Role::where('slug',$rol)->first();
        if($rol=='student' || !$rol)
            $uids = User::pluck('id')->toArray();  
        elseif($role)
            $uids = $role->users->pluck('id')->toArray();
        else
            $uids = null;  
        
    }else{
        $uids = null;
    }
    
    if($uids){
        $users = $users->whereIn('id',$uids);
    }

    $users = $users->orderBy('id','desc')->with('roles')->paginate(30);


    if($uids){
    $data['users_all'] =  User::where('client_slug',subdomain())->whereIn('id',$uids)->count();
    $data['users_lastmonth'] = User::where('client_slug',subdomain())->whereIn('id',$uids)->whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
    $data['users_thismonth'] = User::where('client_slug',subdomain())->whereIn('id',$uids)->whereMonth('created_at', Carbon::now()->month)->count();
    $data['users_lastbeforemonth'] = User::where('client_slug',subdomain())->whereIn('id',$uids)->whereMonth('created_at', Carbon::now()->subMonth(2)->month)->count();

    }else{
        $data['users_all'] =  User::where('client_slug',subdomain())->count();
    $data['users_lastmonth'] = User::where('client_slug',subdomain())->whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
    $data['users_thismonth'] = User::where('client_slug',subdomain())->whereMonth('created_at', Carbon::now()->month)->count();
    $data['users_lastbeforemonth'] = User::where('client_slug',subdomain())->whereMonth('created_at', Carbon::now()->subMonth(2)->month)->count();

    }
    
    $count=0;
    if($r->get('role')=='student')
    foreach($users as $u){
        if($u->roles()->first())
            $count++;
    }
    
    if($r->get('username'))
        $user = User::where('username',$r->get('username'))->first();
    else    
        $user = \auth::user();


    



    
      return view('appl.user.userlist')
                    ->with('count',$count)
                    ->with('users',$users)->with('data',$data)->with('user',$user);

    }

    public function exportCsv($users)
    {
   $fileName = 'users.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Title', 'Assign', 'Description', 'Start Date', 'Due Date');

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {
                $row['Title']  = $task->title;
                $row['Assign']    = $task->assign->name;
                $row['Description']    = $task->description;
                $row['Start Date']  = $task->start_at;
                $row['Due Date']  = $task->end_at;

                fputcsv($file, array($row['Title'], $row['Assign'], $row['Description'], $row['Start Date'], $row['Due Date']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
        $user = User::where('username',$username)->with('college')->with('branch')->first();

        $this->authorize($user);
        $user_details = User_Details::where('user_id',$user->id)->first();
        if(!$user_details)
            $user_details = new User_Details();
            
        $user_details->countries = $user_details->getCountry();

        $colleges = College::orderby('name','asc')->get();
        $branches = Branch::all();

            
        if($user)
        {
            $editor = false;
            if(request()->get('complete_profile')){
                $view = 'complete_profile';
            }
            else{
                $view = 'edit';
                $editor  = true;
            }
            return view('appl.user.'.$view)
                    ->with('user',$user)
                    ->with('colleges',$colleges)
                    ->with('branches',$branches)
                    ->with('editor',$editor)
                    ->with('user_details',$user_details);
        }else
            abort(404,'User not found');
    }



    public function sendOTP(Request $r){
        $code = $r->get('code');
        $url = "https://2factor.in/API/V1/b2122bd6-9856-11ea-9fa5-0200cd936042/SMS/+91".$r->get('number')."/".$code;
        $d = $this->curl_get_contents($url);
        echo $d;
        
    }

    function curl_get_contents($url)
    {
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
    }

    public function saveregister(Request $request)
    {
        $code = intval(request()->session()->get('code'));
        $code_verify = intval($request->otp);

        

        if($code_verify != $code){
            flash('Sms verification code did not match.')->error();
                 return redirect()->back()->withInput();
        }

        if($request->name==null){
            flash('Name cannot be empty')->error();
                 return redirect()->back()->withInput();
        }

        if($request->email==null){
            flash('Email cannot be empty')->error();
                 return redirect()->back()->withInput();
        }

        if($request->fathername==null){
            flash('Fathers name cannot be empty')->error();
                 return redirect()->back()->withInput();
        }

        if($request->phone==null){
            flash('Phone number cannot be empty')->error();
                 return redirect()->back()->withInput();
        }


        if($request->password){
            if($request->password != $request->password_confirmation){
                flash('Password and Confirm-password mismatch...kindly re-enter password')->error();
                 return redirect()->back()->withInput();
            }
        }

        $user = User::where('email',$request->email)->where('client_slug',subdomain())->first();
     

        if($user){
            flash('The user (<b>'.$request->email.'</b>) account exists. Kindly use a different email.')->error();
            return redirect()->back()->withInput();
        }

        $url = url()->full();
        $subdomain = subdomain();


        $parts = explode("@", $request->email);
        $username = $parts[0];

        $u = User::where('username',$username)->first();

        if($u){
            $username = $username.'_'.rand(10,100);
        }


        $user = User::create([
            'name' => $request->name,
            'username' => strtolower($username),
            'email' => strtolower($request->email),
            'password' => bcrypt($request->password),
            'activation_token' => str_random(20),
            'client_slug' => $subdomain,
            'user_id' =>1,
            'status'=>1,
        ]);

        $user->phone = $request->get('phone');
        $user->roll_number = $request->get('fathername');
        $user->hometown = $request->get('hometown');
        $user->current_city = $request->get('current_city');
        $user->dob = $request->get('dob');
        $user->gender = $request->get('gender');
        $user->video = $request->get('video');
        $user->personality = $request->get('personality');
        $user->confidence = $request->get('confidence');
        $user->fluency = $request->get('fluency');
        $user->language = $request->get('language');
        
        
        $user->save();
        

        flash('Successfully created your account.')->success();
        return redirect()->route('login');

    }

     public function hasSubdomain($url) {
        $parsed = parse_url($url);
        $exploded = explode('.', $parsed["host"]);
        return (count($exploded) > 2);
    }

    public function update_self(){
        $user = \auth::user();
        request()->request->add(['complete_profile' => '1']);
        return $this->edit('@'.$user->username);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($username,Request $request)
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
            
                if(Storage::disk('s3')->exists($image.'.jpg')){
                    Storage::disk('s3')->delete($image.'.jpg');
                }

                 if(Storage::disk('s3')->exists($image.'.png')){
                    Storage::disk('s3')->delete($image.'.png');
                }

                 if(Storage::disk('s3')->exists($image.'.jpeg')){
                    Storage::disk('s3')->delete($image.'.jpeg');
                }

                $file      = $request->all()['file_'];
                try {
                $filename = 'profile_'.$username.'.'.$file->getClientOriginalExtension();
                $path = Storage::disk('s3')->putFileAs('articles', $request->file('file_'),$filename,'public');
                $request->merge(['image' => $path]);
                } catch (Exception $e) {

                }

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

        $user->roll_number = $request->roll_number;
        $user->college_id = $request->college_id;
        $user->branch_id = $request->branch_id;
        $user->hometown = $request->hometown;
        $user->current_city = ($request->current_city)?$request->current_city:' ';
        $user->gender = $request->gender;
        $user->dob = $request->dob;
        $user->tenth = $request->tenth;
        $user->twelveth = $request->twelveth;
        $user->bachelors = $request->graduation;
        $user->masters = $request->masters;
        $user->year_of_passing = $request->year_of_passing;
        $user->aadhar = $request->aadhar;
        $user->info = $request->info;
        

        $user->save();

        //update user details
        $user_details->user_id = $user->id;

        $user_details->bio = scriptStripper(summernote_imageupload($user,$request->bio));
        // //dd($user_details->bio);
        // $user_details->country = $request->country;
        // $user_details->city = ($request->city)?$request->city:' ';
        // $user_details->facebook_link = $request->facebook_link;
        // $user_details->twitter_link = $request->twitter_link;
        // $user_details->privacy = $request->privacy;
        // $user_details->phone = $request->phone;

        
    
        $user_details->save();

        $metrics = $request->get('metrics');

        

        if($metrics){
            $user->metrics()->detach();
            foreach($metrics as $metric){

                    $user->metrics()->attach($metric);
            } 
        }
        
       
        Cache::forget('id-' . $user->id);

        


        flash('User data updated!')->success();
        if(request()->get('redirect'))
            return redirect()->to(request()->get('redirect'));
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
        $obj = User::where('username',$id)->first();
        $this->authorize('update', $obj);
        if($obj->details)
            $obj->details->delete();
        $obj->roles()->detach();
        $obj->colleges()->detach();
        $obj->branches()->detach();
        $obj->zones()->detach();
        if($obj->exams)
            $obj->exams()->delete();
        if($obj->products)
            $obj->products()->detach();
        $obj->delete();

        flash('User is  Successfully deleted!')->success();
        return redirect()->route('admin.user');
    }
}
