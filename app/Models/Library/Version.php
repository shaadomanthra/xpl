<?php

namespace PacketPrep\Models\Library;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $fillable = [
        'name',
        'content',
        'user_id',
        'repository_id',
        'structure_id',
        'status',
        // add all other fields
    ];

    public function structure()
    {
        return $this->belongsTo('PacketPrep\Models\Library\Structure');
    }

    public function user(){
    	return $this->belongsTo('PacketPrep\User');
    }
}
