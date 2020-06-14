<?php

namespace PacketPrep\Models\Job;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'title',
        'details',
        'education',
        'salary',
        'location',
        'academic',
        'last_date',
        'yop',
        'user_id',
        'status',
        // add all other fields
    ];

    public function user(){
      return $this->belongsTo('PacketPrep\User');
    }

    public function users()
    {
        return $this->belongsToMany('PacketPrep\User');
    }
}
