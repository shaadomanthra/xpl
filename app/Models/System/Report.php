<?php

namespace PacketPrep\Models\System;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'content',
    ];
}
