<?php

namespace PacketPrep\Models\Recruit;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
     protected $fillable = [
        'title',
        'slug',
        'user_id',
        'content',
        'vacancy',
        'status',
        // add all other fields
    ];

    public function forms()
    {
        return $this->hasMany('PacketPrep\Models\Recruit\Form');
    }
}
