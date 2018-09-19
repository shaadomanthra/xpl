<?php

namespace PacketPrep\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'client_id',
        'order_id',
        'txn_id',
        'package',
        'payment_mode',
        'bank_txn_id',
        'bank_name',
        'txn_amount',
        'status',
        'credit_count',
        'credit_rate',
        // add all other fields
    ];
}
