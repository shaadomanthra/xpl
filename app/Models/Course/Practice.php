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
        // add all other fields
    ];
}
