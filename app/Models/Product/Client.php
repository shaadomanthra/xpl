<?php

namespace PacketPrep\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
     protected $fillable = [
        'name',
        'slug',
        'user_id_creator',
        'user_id_owner',
        'user_id_manager',
        'status',
        // add all other fields
    ];

    public function users()
    {
        return $this->belongsToMany('PacketPrep\User');
    }


}
