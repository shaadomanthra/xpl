<?php

namespace PacketPrep\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PacketPrep\User;
use PacketPrep\Models\User\Role;
use PacketPrep\Models\Exam\Tests_Overall;
use Carbon\Carbon;

class Client extends Model
{
     protected $fillable = [
        'name',
        'slug',
        'user_id_creator',
        'user_id_owner',
        'user_id_manager',
        'status',
        'contact',
        'settings',
        // add all other fields
    ];

    public function users()
    {
        return $this->belongsToMany('PacketPrep\User');
    }

    public function creator()
    {
        return $this->hasOne('PacketPrep\User','id','user_id_creator');
    }

    public function siteusers()
    {
        return $this->hasMany('PacketPrep\User','client_slug','slug');
    }


    public function exams()
    {
        return $this->hasMany('PacketPrep\Models\Exam\Exam','client','slug');
    }

    public function courses(){
        return $this->belongsToMany('PacketPrep\Models\Course\Course')->withPivot('visible');
    }
    public function products(){
        return $this->belongsToMany('PacketPrep\Models\Product\Product');
    }

    public function updateVisibility($client_id,$course_id=null,$visible){

        if($course_id)
        return DB::table('client_course')
                ->where('client_id', $client_id)
                ->where('course_id', $course_id)
                ->update(['visible' => $visible]);
        else
        return DB::table('client_course')
                ->where('client_id', $client_id)
                ->update(['visible' => $visible]);

    }

    public function getAttemptCount($month=null,$test_ids,$code=null)
    {
        if($code)
        return Tests_Overall::where('code',$code)->whereIn('test_id',$test_ids)->count();
        else{
          
          if($month=='thismonth')
            return Tests_Overall::whereIn('test_id',$test_ids)->whereMonth('created_at', Carbon::now()->month)->count();
          elseif($month=='lastmonth')
            return Tests_Overall::whereIn('test_id',$test_ids)->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->count();
          elseif($month=='lastbeforemonth')
            return Tests_Overall::whereIn('test_id',$test_ids)->whereMonth('created_at', '=', Carbon::now()->subMonth(2)->month)->count();
          else
            return Tests_Overall::whereIn('test_id',$test_ids)->count();
        }
    }


    public function getCreditsUsedCount($client_id=null){

        if(!$client_id)
            $client_id = $this->id;

        return DB::table('course_user')
                ->where('client_id', $client_id)->sum('credits');

    }

    public function getCreditsIssued($client_id=null){

        if(!$client_id)
            $client_id = $this->id;

        $records= DB::table('course_user')
                ->where('client_id', $client_id)->limit(5)->get();

                return $records;

    }


    public function site_admin(){
        $role = Role::where('slug','hr-manager')->first();
        foreach($role->users as $u){
            if($u->client_slug==$this->slug)
                return $u;
        }

        return null;
    }


    public static function getClientSlug($id){


        $slug = Client::where('id',$id)->first()->slug;

        if($slug)
            return $slug;
        else
            return null;
    }

    public function getPackageRate(){

        $o = Order::where('client_id', $this->id)->where(function ($query) {
                $query->where('package', '=', 'flex')
                      ->orWhere('package', '=', 'basic')
                      ->orWhere('package', '=', 'pro')
                      ->orWhere('package', '=', 'ultimate');
            })->first();

        if($o)
            return $o->credit_rate;
        else
            return '200';
    }


    public function getOfferRate(){

        $sum = Order::where('client_id',$this->id)->Where('status',1)->sum('credit_count');
        if($sum < 200){
            return '200';
        }
        elseif($sum > 199 && $sum < 500){
            return '175';
        }elseif($sum > 499 && $sum < 1000){
            return '150';
        }elseif($sum > 999 )
            return '125';
    }


    public function getCreditPoints(){

        $sum = Order::where('client_id',$this->id)->Where('status',1)->sum('credit_count');
        return $sum;
    }

    public function getPackageName(){

        $o = Order::where('client_id',$this->id)->where(function ($query) {
                $query->where('package', '=', 'flex')
                      ->orWhere('package', '=', 'basic')
                      ->orWhere('package', '=', 'pro')
                      ->orWhere('package', '=', 'ultimate');
            })->first();

        if($o)
            return $o->package;
        else
            return null;
    }

    public function usercount(){
        return User::where('client_slug',$this->slug)->count();
    }
    





}
