<?php

namespace PacketPrep\Models\Course;

use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
    protected $fillable = [
        'user_id',
        'qid',
        'response',
        'answer',
        'accuracy',
        'time',
        'course_id',
        'category_id',
        // add all other fields
    ];

    public function users(){
    	return $this->belongsTo('PacketPrep\User');
    }

    public function question(){
    	return $this->belongsTo('PacketPrep\Models\Dataentry\Question','qid','id');
    }
}
