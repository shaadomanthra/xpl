<?php

namespace PacketPrep\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Coupon extends Model
{


    protected $fillable = [
        'code',
        'percent',
        'status',
        'expiry'
        // add all other fields
    ];
}
