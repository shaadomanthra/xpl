<?php

namespace PacketPrep\Models\Library;

use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
     protected $fillable = [
        'name',
        'slug',
        'user_id_data_manager',
        'user_id_data_lead',
        'target',
        'status',
        // add all other fields
    ];

    public function users()
    {
        return $this->belongsToMany('PacketPrep\User');
    }

    public static function getName($slug){
         $model = new Repository;
         return $model->where('slug',$slug)->first()->name;
    }

    public static function get($slug){
        return (new Repository)->where('slug',$slug)->first();
    }

    public static function getID($slug){
        return (new Repository)->where('slug',$slug)->first()->id;
    }
}
