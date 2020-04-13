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
        'time',
        'code',
        'status',
        'window_change',
        'face_detect',
        'cheat_detect'
    ];

    public function user(){
        return $this->belongsTo('PacketPrep\User');
    }
}
