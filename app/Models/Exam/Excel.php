<?php

namespace PacketPrep\Models\Exam;

use Illuminate\Database\Eloquent\Model;

class Excel extends Model
{
    protected $fillable = [
        'Sno',
        'Name',
        'Email',
        'Phone',
        'Score',
        // add all other fields
    ];
}
