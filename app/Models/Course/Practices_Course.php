<?php

namespace PacketPrep\Models\Course;

use Illuminate\Database\Eloquent\Model;

class Practices_Course extends Model
{
    //
     protected $table = 'practices_course';
      protected $fillable = [
        'user_id',
        'course_id',
        'attempted',
        'correct',
        'incorrect',
        'time'
    ];


    public function user()
    {
        return $this->belongsTo('PacketPrep\User');
    }

}

