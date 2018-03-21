<?php

namespace PacketPrep\Models\System;

use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'content',
        'status',
        // add all other fields
    ];
}
