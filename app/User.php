<?php

namespace PacketPrep;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PacketPrep\Models\User\Role;
use PacketPrep\Models\Product\Client;
use PacketPrep\Models\User\User_Details;
use PacketPrep\Notifications\MailResetPasswordToken;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','activation_token','status','client_slug'
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

    public function details()
    {
        return $this->hasOne('PacketPrep\Models\User\User_Details');
    }

    public function roles()
    {
        return $this->belongsToMany('PacketPrep\Models\User\Role');
    }

    public function courses(){
        return $this->belongsToMany('PacketPrep\Models\Course\Course')->withPivot('credits','validity','created_at','valid_till');
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
