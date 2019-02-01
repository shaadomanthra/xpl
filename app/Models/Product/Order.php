<?php

namespace PacketPrep\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'txn_id',
        'payment_mode',
        'bank_txn_id',
        'bank_name',
        'txn_amount',
        'status',
        'credit_count',
        'credit_rate',
        // add all other fields
    ];

     public function product(){
        return $this->belongsTo('PacketPrep\Models\Product\Product');
    }

    public function user(){
        return $this->belongsTo('PacketPrep\User');
    }

}
