<?php

namespace PacketPrep\Models\Exam;

use Illuminate\Database\Eloquent\Model;
use PacketPrep\Models\Dataentry\Question;
use Illuminate\Support\Facades\DB;

class Section extends Model
{
    protected $fillable = [
        'name',
        'negative',
        'mark',
        'time',
        'user_id',
        'exam_id',

        'instructions',
        // add all other fields
    ];

     public function questions()
    {
        return $this->belongsToMany('PacketPrep\Models\Dataentry\Question');
    }

    

}
