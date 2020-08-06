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
        'salary_num',
        'location',
        'academic',
        'last_date',
        'yop',
        'user_id',
        'viewer_id',
        'exam_ids',
        'status',
        // add all other fields
    ];

    public function user(){
      return $this->belongsTo('PacketPrep\User');
    }

    public function viewer(){
      return $this->belongsTo('PacketPrep\User','viewer_id');
    }

    public function users()
    {
        return $this->belongsToMany('PacketPrep\User')->withPivot('created_at');
    }
}
