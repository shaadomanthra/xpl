<?php

namespace PacketPrep\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Coupon extends Model
{


    protected $fillable = [
        'code',
        'percent',
        'status'
        // add all other fields
    ];
}
