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
        'expiry',
        'product_id'
        // add all other fields
    ];


    public function getAccess($coupon){
    	$coupon = $this->where('code',str_to_upper($coupon))->first();
    }

    public function product()
    {
        return $this->belongsTo('PacketPrep\Models\Product\Product');
    }

    public function order()
    {
        return $this->hasMany('PacketPrep\Models\Product\Order');
    }
}
