<?php

namespace PacketPrep\Models\Dataentry;

use Illuminate\Database\Eloquent\Model;
use PacketPrep\Models\Dataentry\Question;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'value',
        'user_id',
        'project_id',
        // add all other fields
    ];

    public function questions()
    {
        return $this->belongsToMany('PacketPrep\Models\Dataentry\Question');
    }
}
