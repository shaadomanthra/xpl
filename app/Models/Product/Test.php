<?php

namespace PacketPrep\Models\Product;

use Illuminate\Database\Eloquent\Model;
use PacketPrep\Models\Exam\Section;

class Test extends Model
{
    protected $fillable = [
        'question_id',
        'user_id',
        'test_id',
        'response',
        'answer',
        'accuracy',
        'time','status',
        'section_id',
        'dynamic',
        'code'

        // add all other fields
    ];

    public function section()
    {
        return $this->belongsTo('PacketPrep\Models\Exam\Section');
    }

    public function question()
    {
        return $this->belongsTo('PacketPrep\Models\Dataentry\Question');
    }
}
