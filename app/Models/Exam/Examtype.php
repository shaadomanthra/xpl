<?php

namespace PacketPrep\Models\Exam;

use Illuminate\Database\Eloquent\Model;

class Examtype extends Model
{
    protected $fillable = [
        'name',
        'slug',
        // add all other fields
    ];

    public function exams()
    {
        return $this->hasMany('PacketPrep\Models\Exam\Exam');
    }
}
