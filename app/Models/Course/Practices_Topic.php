<?php

namespace PacketPrep\Models\Course;

use Illuminate\Database\Eloquent\Model;

class Practices_Topic extends Model
{
    //
     protected $table = 'practices_topic';
      protected $fillable = [
        'user_id',
        'category_id',
        'attempted',
        'correct',
        'incorrect',
        'time'
    ];
}
