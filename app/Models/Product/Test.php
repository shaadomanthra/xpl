<?php

namespace PacketPrep\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'question_id',
        'user_id',
        'test_id',
        'response',
        'answer',
        'accuracy',
        'time',

        // add all other fields
    ];
}
