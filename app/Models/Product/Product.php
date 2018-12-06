<?php

namespace PacketPrep\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price'
        // add all other fields
    ];
}
