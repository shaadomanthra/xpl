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
        'price','type',
        'expiry'
        // add all other fields
    ];


    public function getAccess($coupon){
    	$coupon = $this->where('code',str_to_upper($coupon))->first();
    	dd($coupon);
    }
}
