<?php

namespace PacketPrep;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PacketPrep\Models\User\Role;
use PacketPrep\Models\Product\Client;
use PacketPrep\Models\Product\Product;
use PacketPrep\Models\Course\Course;
use PacketPrep\Models\User\User_Details;
use PacketPrep\Notifications\MailResetPasswordToken;
use Illuminate\Support\Facades\DB;
use PacketPrep\Models\College\College;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\Models\Exam\Section;
use PacketPrep\Models\Exam\Tests_Section;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','activation_token','status','client_slug','user_id','phone','year_of_passing','branch_id','role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


        /**
     * Send a password reset email to the user
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }


    /**
     * The roles that belong to the user.
     */

    public function ambassadors()
    {
        return $this->belongsTo('PacketPrep\Models\College\Ambassador');
    }

    public function referrals()
    {
        return $this->hasMany('PacketPrep\User');
    }

    
    public function details()
    {
        return $this->hasOne('PacketPrep\Models\User\User_Details');
    }

    public function roles()
    {
        return $this->belongsToMany('PacketPrep\Models\User\Role');
    }

    public function zones()
    {
        return $this->belongsToMany('PacketPrep\Models\College\Zone');
    }

    public function branches()
    {
        return $this->belongsToMany('PacketPrep\Models\College\Branch');
    }

    public function branch()
    {
        return $this->belongsTo('PacketPrep\Models\College\Branch');
    }


    public function exams()
    {
        return $this->hasMany('PacketPrep\Models\Exam\Exam');
    }

    
     public function batches()
    {
        return $this->belongsToMany('PacketPrep\Models\College\Batch');
    }

    public function colleges()
    {
        
        return $this->belongsToMany('PacketPrep\Models\College\College');
    }

    public function college()
    {
        
        return $this->belongsTo('PacketPrep\Models\College\College');
    }

    public function posts()
    {
        return $this->belongsToMany('PacketPrep\Models\Job\Post');
    }

    
    public function clientexams()
    {
        
        
        return $this->belongsToMany('PacketPrep\Models\Exam\Exam')->withPivot('role');
    }

    public function services()
    {
        return $this->belongsToMany('PacketPrep\Models\College\Service')->withPivot(['code','status']);
    }

    public function myservice()
    {
        return $this->belongsToMany('PacketPrep\Models\College\Service')->withPivot(['code','status']);
    }

    public function metrics()
    {
        return $this->belongsToMany('PacketPrep\Models\College\Metric');
    }

    public function courses(){
        return $this->belongsToMany('PacketPrep\Models\Course\Course')->withPivot('credits','validity','created_at','valid_till');
    }

    public function schedules(){
        return $this->belongsToMany('PacketPrep\Models\Training\Schedule');
    }
     public function trainings(){
        return $this->belongsToMany('PacketPrep\Models\Training\Training');
    }

    public function products(){
        return $this->belongsToMany('PacketPrep\Models\Product\Product')->withPivot('status','validity','created_at','valid_till');
    }

    public function myproducts(){
        $user = $this;
        if(request()->get('refresh'))
            Cache::forget('myproducts_'.$user->id);
        $products = Cache::remember('myproducts_'.$user->id, 240, function() use ($user) {
          return $user->products()->with('courses')->with('exams')->get();
        });
        return $products;
        
    }

     public static function directlogin($name,$email,$phone,$hcode)
    {
        $user = User::where('email',$email)->where('client_slug',subdomain())->first();
        if(!$user){
            $data = User::directregister($name,$email,$phone,$hcode);

            if($data['error']!=1){
                \Auth::loginUsingId($data['uid']);
            }else{
                echo json_encode($data);
                exit();
            }
        }else{
            \Auth::loginUsingId($user->id);
        }
    }

    public static function directregister($name,$email,$phone,$hcode)
    {

        $user = User::where('email',$email)->where('client_slug',subdomain())->first();
        $parts = explode("@", $email);
        $username = $parts[0];
        $request = request();

        $u = User::where('username',$username)->first();

        if($u){
            $username = $username.'_'.rand(10,100);
        }

        if($hcode!='piofxapp734'){
            $data['error'] = 1;
            $data['message'] = 'Invalid hashcode used';
        } else if(!$email || !$phone || !$name){
            $data['error'] = 1;
            $data['message'] = 'Email or phone or name not given';
        }
        else if($user){
            $data['error'] = 1;
            $data['message'] = 'User with email ('.$email.') already exists';
            
        }else{
            $user = User::create([
                'name' => $name,
                'username' => strtolower($username),
                'email' => strtolower($email),
                'password' => bcrypt($phone),
                'activation_token' => str_random(20),
                'client_slug' => subdomain(),
                'user_id' =>'2',
                'status'=>1
            ]);

            $user->phone = $phone;
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

            $data['error'] = 0;
            $data['message'] = 'User with email ('.$email.') is created';
            $data['uid'] = $user->id;
        }

        return $data;
    }

    public function getImage($signature=null){

        if($signature)
            return Storage::disk('s3')->url('articles/signature.jpg');

        $user = $this;
        $username = $this->username;

        $d = \carbon\carbon::now()->format('d');
        if($d==05){
            Cache::forget('userimage_'.$username);
        }

        if(request()->get('refresh')){
            Cache::forget('userimage_'.$username);
        }
        $user->image = Cache::get('userimage_'.$username);

        if($user->image)
            return $user->image;
        if(Storage::disk('s3')->exists('articles/'.strtolower($user->roll_number).'.jpg'))
                {
                    $user->image = Storage::disk('s3')->url('articles/'.strtolower($user->roll_number).'.jpg');
                }

        if(Storage::disk('s3')->exists('articles/'.$user->username.'.jpg'))
                {
                    $user->image = Storage::disk('s3')->url('articles/'.$user->username.'.jpg');
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
                
        Cache::forever('userimage_'.$username,$user->image);
                

        return $user->image;
    }

    public function attempted_test($id){
        $user = \auth::user();

        


        $test = Cache::remember('attempt_'.$user->id.'_'.$id, 240, function() use ($user,$id) {
                $test = DB::table('tests_overall')
                    ->where('user_id', $user->id)
                    ->where('test_id', $id)
                    ->first();
                if($test)
                    return $test;
                return 0;
        });

        return $test;

    }

    public function attempted($id){
        $user = \auth::user();
        //Cache::forget('attempt_'.$user->id.'_'.$id);
        $attempts = Cache::get('attempts_'.$user->id);
        //dd($attempts->where('test_id',$id)->count());
        if(!$attempts)
            return 0;

        if($attempts->where('test_id',$id)->count()){
            return $attempts->where('test_id',$id);
        }else{
            return 0;
        }

        // $test = Cache::remember('attempt_'.$user->id.'_'.$id, 240, function() use ($user,$id) {
        //         $test = DB::table('tests_overall')
        //             ->where('user_id', $user->id)
        //             ->where('test_id', $id)
        //             ->first();
        //         if($test)
        //             return $test;
        //         return 0;
        // });

        // return $test;
    }

    public function newtests(){
        $email = $this->email;

        if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com' || $_SERVER['HTTP_HOST'] == 'hiresyntax.com' )
            $tests = DB::table('exams')->where('slug','psychometric-test')->orWhere('emails','LIKE',"%{$email}%")
                ->get();
        else if($_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in')
            $tests = Cache::remember('mytests_'.$this->id, 240, function() use ($email) {
                $tests = DB::table('exams')->where('emails','LIKE',"%{$email}%")->get();
                if($tests)
                    return $tests;
                return 0;
            });
        else
        {
            $user = $this;
            
            $client = subdomain();
            //$tests = Cache::get('tests_'.subdomain());
            
            $tests = Cache::remember('tests_'.subdomain(), 240, function() use ($client) {
                return Exam::where('client',$client)->with('examtype')->orderBy('id','desc')->get();
            });

        }
  
        /*
        if(!subdomain())
            $tests = DB::table('exams')->where('slug','psychometric-test')->orWhere('emails','LIKE',"%{$email}%")
                ->get();
        else{
            if(subdomain()=='hire'){
                $tests = DB::table('exams')->where('slug','psychometric-test')->orWhere('emails','LIKE',"%{$email}%")
                ->get();
            }else{
                $users = $this->where('client_slug',subdomain())->pluck('id')->toArray();
                $tests = DB::table('exams')->whereIn('user_id',$users)->where('status',1)
                ->get();

            }
        }*/


        return $tests;
    }


    public function authorizedEmail($e){
        $user = $this;

        $emails = $e->emails;
        $emails = implode(',',explode("\n", $e->emails));
        $emails =str_replace("\r", '', $emails);
        $emails = array_unique(explode(',',$emails));

        $flag = 0;
        foreach($emails as $em){
            if(strtoupper($user->email) == strtoupper(trim($em))){
                $flag = 1;break;
            }
        }
        return $flag;

    }

    public function tests($all=null){
        
        $user = $this;
        if(request()->get('refresh')){
            Cache::forget('attempts_'.$user->id);
        }


        
        //Cache::forget('attempts_'.$user->id);
        $attempts = Cache::remember('attempts_'.$user->id, 240, function() use ($user) {
          return DB::table('tests_overall')
                ->where('user_id', $user->id)
                ->orderBy('id','desc')
                ->get()->keyBy('test_id');
        });


        if($all)
            return $attempts;
        // Cache::remember('attempts_'.$this->id, 40, function() use ($this) {
        //   return DB::table('tests_overall')
        //         ->where('user_id', $this->id)
        //         ->orderBy('id','desc')
        //         ->get();;
        // });

        if($attempts->count()){

            if(!isset($attempts['test_id'])){
                $test_idgroup = $attempts->groupby('test_id');
                $test_ids = $attempts->pluck('test_id')->toArray();
            }else{
                $test_idgroup[$attempts['test_id']][0] = json_decode(json_encode($attempts));
                $test_ids = [$attempts['test_id']];
            }
            

            //Cache::forget('tests_'.$user->id);
            $alltests = Cache::get('tests_'.subdomain());

            if($alltests)
                $tests = $alltests->whereIn('id',$test_ids);
            else
                $tests = [];
        
        }else{
            $tests = [];
        }

        $tests_section = Tests_Section::where('user_id',$user->id)->get();
        $sections = Section::whereIn('id',$tests_section->pluck('section_id')->toArray())->get()->keyBy('id');

        $tests_section = $tests_section->groupBy('test_id');
       
        foreach($tests as $k=>$t){

            $tests[$k]->attempt_at = $test_idgroup[$t->id][0]->created_at;
            $tests[$k]->score = $test_idgroup[$t->id][0]->score;
            $tests[$k]->max = $test_idgroup[$t->id][0]->max;
            $tests[$k]->attempt_status = $test_idgroup[$t->id][0]->status;
            
            $str ='';
            foreach($tests_section[$t->id] as $m=>$n){
               
                if(isset($sections[$n->section_id]))
                $str =$str.$sections[$n->section_id]->name.' - '.$n->score.'<br>';
            }
            $tests[$k]->details = $str;
        }

        return $tests;
    }

    public function getPsy(){
        $e = Exam::where('slug','psychometric-test')->first();

        if(!$e)
            return null;

        return $e->psychometric_test($this);
    }

    public function productvalid($slug){
        $product_id = Product::where('slug',$slug)->first()->id;
        $user_id = \auth::user()->id;

        $entry = DB::table('product_user')
                ->where('product_id', $product_id)
                ->where('user_id', $user_id)
                ->orderBy('id','desc')
                ->first();
        if(!$entry)       
            return 2;


        if(strtotime($entry->valid_till) > strtotime(date('Y-m-d')))
            return 0;
        elseif($entry->status==0)
            return -1;
        else
            return 1;
    }

    public function productvalidity($slug){
        $course = Course::where('slug',$slug)->first();
        //dd($course->products->first());
        $user_id = \auth::user()->id;
        $entry = null;
        if($course->products->first())
        $entry = DB::table('product_user')
                ->where('product_id', $course->products->first()->id)
                ->where('user_id', $user_id)
                ->orderBy('id','desc')
                ->first();
        if($entry)
        return $entry->valid_till;
        else
        return null;
    }
    

    public function repositories()
    {
        return $this->belongsToMany('PacketPrep\Models\Library\Respository');
    }
    

    public function getRole($role){

        if(request()->get('order')){
            $order = request()->get('order');
        }else{
            $order = 'name';
        }
        if(subdomain()=='xplore' || subdomain()=='piofx' || subdomain() =='gradable' ){
            $users = Role::where('slug',$role)->first()->users()->orderBy('name');
            $d = $users->whereIn('role',[2,12,13])->where('status','<>',2)->get();
            return $d;
        }
        else{
            $r =Role::where('slug',$role)->first();
            $users = $r->users()->orderBy($order)->where('client_slug',subdomain())->where('status','<>',2)->get()->keyBy('id');
            if(!$users)
                return $r->users()->orderBy($order)->where('status','<>',2)->get()->keyBy('id');
            else
            return  $users;
        }

    }
    

    public function checkRole($roles){
        $user = $this;
        if($user->isAdmin())
            return true;

        if($user->role==1)
            return false;

        $userroles = Cache::remember('userroles_'.$user->id, 240, function() use ($user) {
           return $user->roles->pluck('slug')->toArray();
        });

        
        foreach($roles as $r){
            if(in_array($r, $userroles)){
                return true;
            }
        }
        return false;
    }

    public function checkExamRole($exam,$roles){
        $user = $this;
        if($user->isAdmin())
            return true;

        if($user->role==1)
            return false;
        
        $exams = Cache::remember('userexamroles_'.$user->id, 60, function() use ($user) {
           return $user->clientexams;
        });
        $ex = $exams->find($exam->id);
        foreach($roles as $r){

            if($ex->pivot->role == $r){
                return true;
            }
        }
        return false;
    }

    public function checkUserRole($roles){
        $user = $this;
        $userroles = array();
        foreach($user->roles as $role)
            array_push($userroles, $role->slug);
        
        foreach($roles as $r){
            if(in_array($r, $userroles)){
                return true;
            }
        }
        return false;
    }

    public function getCollege($id){
        if($id)
            return  User::where('id',$id)->first()->colleges()->first()->name;
        else
            return null;
    }
    public function getName($id){
        if($id)
            return  User::where('id',$id)->get()->first()->name;
        else
            return null;

    }

    public function client_id(){
        $slug = $this->client_slug;
        if(!$slug)
            $slug = 'demo';
        return Client::where('slug',$slug)->first()->id;
    }
    public function getClient(){
        $slug = $this->client_slug;
        if(!$slug)
            $slug = 'demo';
        return Client::where('slug',$slug)->first();
    }

    public function getUserName($id){
        return  User::where('id',$id)->get()->first()->username;

    }

    public function getDesignation($id){
        return User_Details::where('user_id',$id)->get()->first()->designation;
    }

    public function isAdmin(){
        if(\Auth::user())
            {
                if(\Auth::user()->role == 2 )
                    return true;
                else
                    return false;
            }
        return false;
    }

    public function isSiteAdmin(){
        if(\Auth::user())
            {
                if(\Auth::user()->role == 2 || \Auth::user()->role == 11 || \Auth::user()->role == 12 ||\Auth::user()->role == 13)
                    return true;
                else
                    return false;
            }
        return false;
    }

    public function send_sms($number,$code){
                // Authorisation details.
        $url = "https://2factor.in/API/V1/95f80a8a-3945-11ec-a13b-0200cd936042/SMS/+91".$number."/".$code;
        $d = $this->curl_get_contents($url);
        
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

     public function profile_complete_step(){
        $fields = ["name",'email','phone','username','current_city','hometown','college_id','branch_id','year_of_passing','roll_number','gender','dob','tenth','twelveth','bachelors','pic','aadhar'];
        return round(100/count($fields),2);
     }
    public function profile_complete($username=null,$user=null){

        if($this->username == $username)
            $u = $this;
        elseif($username)
            $u = $this->where('username',$username)->first();
        else
            $u =$this;

        if($user)
            $u = $user;

        $fields = ["name",'email','phone','username','current_city','hometown','college_id','branch_id','year_of_passing','roll_number','gender','dob','tenth','twelveth','bachelors','pic','aadhar'];

        $count =0;
        foreach($fields as $f){
            if(isset($u->$f)){
                if(!$u->$f){
                    $count++;
                }else{
                }
            }else{
                if(isset($u[$f]))
                if(!$u[$f]){
                    $count++;
                }else{
                }
            }
            
        }

        if(!is_array($u))
        if($u->getImage()){
            $count--;
        }

        $percent = round((1-($count/count($fields)))*100,2);

        return $percent;

    }

    

}
