<?php

namespace PacketPrep\Models\Exam;

use Illuminate\Database\Eloquent\Model;

class Tests_Overall extends Model
{
    //
     protected $table = 'tests_overall';
      protected $fillable = [
        'user_id',
        'test_id',
        'unattempted',
        'correct',
        'incorrect',
        'score',
        'time'
    ];
}
