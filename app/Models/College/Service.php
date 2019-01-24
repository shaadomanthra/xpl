<?php

namespace PacketPrep\Models\College;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'product_id',
    ];

    public function product(){
        return $this->belongsTo('PacketPrep\Models\Product\Product');
    }


}
