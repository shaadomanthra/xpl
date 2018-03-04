<?php

namespace PacketPrep\Models\Dataentry;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
     protected $fillable = [
        'name',
        'slug',
        // add all other fields
    ];

    public static function getName($slug){
    	 $model = new Project;
    	 return $model->where('slug',$slug)->first()->name;
    }

}
