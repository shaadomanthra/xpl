<?php

namespace PacketPrep\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
     protected $fillable = [
        'name',
        'slug',
        'user_id_creator',
        'user_id_owner',
        'user_id_manager',
        'status',
        // add all other fields
    ];

    public function users()
    {
        return $this->belongsToMany('PacketPrep\User');
    }

    public function courses(){
        return $this->belongsToMany('PacketPrep\Models\Course\Course')->withPivot('visible');;
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


}
