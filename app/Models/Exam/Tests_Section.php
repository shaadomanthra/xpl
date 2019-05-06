<?php

namespace PacketPrep\Models\Exam;

use Illuminate\Database\Eloquent\Model;

class Tests_Section extends Model
{
    //
    protected $table = 'tests_section';
      protected $fillable = [
        'user_id',
        'test_id',
        'section_id',
        'unattempted',
        'correct',
        'incorrect',
        'score',
        'time'
    ];
}
