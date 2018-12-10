<?php

namespace PacketPrep\Models\Dataentry;

use Illuminate\Database\Eloquent\Model;

class Passage extends Model
{
    protected $fillable = [
        'name',
        'passage',
        'user_id',
        'project_id',
        'stage',
        'status',
        // add all other fields
    ];

    public function questions()
    {
        return $this->hasMany('PacketPrep\Models\Dataentry\Question');
    }
}
