<?php

namespace PacketPrep\Models\Course;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
     protected $fillable = [
        'name',
        'slug',
        'user_id',
        'description',
        'intro_youtube',
        'intro_vimeo',
        'priority',
        'weightage_min',
        'weightage_avg',
        'weightage_max',
        'price',
        'important_topics',
        'reference_books',
        'status',
        // add all other fields
    ];


    public static function getName($slug){
    	 return (new Course)->where('slug',$slug)->first()->name;
    }

    public static function get($slug){
        return (new Course)->where('slug',$slug)->first();
    }

    public static function getID($slug){
        return (new Course)->where('slug',$slug)->first()->id;
    }
}
