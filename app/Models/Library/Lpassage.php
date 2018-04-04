<?php

namespace PacketPrep\Models\Library;

use Illuminate\Database\Eloquent\Model;

class Lpassage extends Model
{
    protected $fillable = [
        'name',
        'passage',
        'user_id',
        'repository_id',
        'stage',
        'status',
        // add all other fields
    ];
}
