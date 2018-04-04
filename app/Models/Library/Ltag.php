<?php

namespace PacketPrep\Models\Library;

use Illuminate\Database\Eloquent\Model;

class Ltag extends Model
{
    protected $fillable = [
        'name',
        'value',
        'user_id',
        'repository_id',
        // add all other fields
    ];

    public function questions()
    {
        return $this->belongsToMany('PacketPrep\Models\Library\Lquestion');
    }
}
