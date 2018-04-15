<?php

namespace PacketPrep\Models\Dataentry;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
     protected $fillable = [
        'name',
        'slug',
        'user_id_data_manager',
        'user_id_data_lead',
        'user_id_feeder',
        'user_id_proof_reader',
        'user_id_renovator',
        'user_id_validator',
        'target',
        'status',
        // add all other fields
    ];


    public static function getName($slug){
    	 $model = new Project;
    	 return $model->where('slug',$slug)->first()->name;
    }

    public static function get($slug){
        return (new Project)->where('slug',$slug)->first();
    }

    public static function getID($slug){
        return (new Project)->where('slug',$slug)->first()->id;
    }
}
