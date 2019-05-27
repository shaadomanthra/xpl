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

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','activation_token','status','client_slug','user_id',
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

     public function batches()
    {
        return $this->belongsToMany('PacketPrep\Models\College\Batch');
    }

    public function colleges()
    {
        
        return $this->belongsToMany('PacketPrep\Models\College\College');
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

}
