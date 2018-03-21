<?php

namespace PacketPrep\Models\System;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'endnote',
        'status',
        'prime',
        'end_to',
    ];
}
