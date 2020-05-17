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
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','activation_token','status','client_slug','user_id','phone',
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

    public function products(){
        return $this->belongsToMany('PacketPrep\Models\Product\Product')->withPivot('status','validity','created_at','valid_till');
    }

    public function getImage(){
        $user = $this;
        $username = $this->username;
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
        return $user->image;
    }

    public function attempted($id){
        $test = DB::table('tests_overall')
                    ->where('user_id', \auth::user()->id)
                    ->where('test_id', $id)
                    ->first();
        return $test;
    }

    public function newtests(){
        $email = $this->email;

        if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com' || $_SERVER['HTTP_HOST'] == 'hiresyntax.com' )
            $tests = DB::table('exams')->where('slug','psychometric-test')->orWhere('emails','LIKE',"%{$email}%")
                ->get();
        else if($_SERVER['HTTP_HOST'] == 'xp.test' || $_SERVER['HTTP_HOST'] == 'xplore.co.in')
            $tests = DB::table('exams')->where('emails','LIKE',"%{$email}%")
                ->get();
        else
        {
            $users = $this->where('client_slug',subdomain())->pluck('id')->toArray();
                $tests = DB::table('exams')->whereIn('user_id',$users)->where('status',1)
                ->get();

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

    public function tests(){
        $attempts = DB::table('tests_overall')
                ->where('user_id', $this->id)
                ->orderBy('id','desc')
                ->get();
        $test_idgroup = $attempts->groupby('test_id');
        $test_ids = $attempts->pluck('test_id')->toArray();
        $ids_ordered = implode(',', $test_ids);
        if($ids_ordered)
        $tests = DB::table('exams')
                ->whereIn('id', $test_ids)
                ->orderByRaw("FIELD(id, $ids_ordered)")
                ->get();
        else
        $tests = DB::table('exams')
                ->whereIn('id', $test_ids)
                ->get(); 
        foreach($tests as $k=>$t){
            $tests[$k]->attempt_at = $test_idgroup[$t->id][0]->created_at;
            $tests[$k]->score = $test_idgroup[$t->id][0]->score;
            $tests[$k]->max = $test_idgroup[$t->id][0]->max;
            $tests[$k]->attempt_status = $test_idgroup[$t->id][0]->status;
        }
        return $tests;
    }

    public function getPsy(){
        $e = Exam::where('slug','psychometric-test')->first();

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

        $r = Role::where('slug',$role)->first();

        return $r->users;
    }
    

    public function checkRole($roles){
        $user = $this;
        if($user->isAdmin())
            return true;
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

    public function send_sms($numbers,$password){
                // Authorisation details.
        $username = "packetcode@gmail.com";
        $hash = "c1120d3477ff90880eb3327e1526a4f76114d87812ad7d9da247eac6fdb74f13";


        // Config variables. Consult http://api.textlocal.in/docs for more info.
        $test = "0";

        // Data for text message. This is the text message data.
        $sender = "PKTPRP"; // This is who the message appears to be from.
        
        $message = "Your login password for packetprep.com is ".$password;
        // 612 chars or less
        // A single number or a comma-seperated list of numbers
        $message = urlencode($message);
        $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
        $ch = curl_init('http://api.textlocal.in/send/?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); // This is the result from the API
        curl_close($ch);
    }

    

}
