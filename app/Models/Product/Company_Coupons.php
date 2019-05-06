<?php

namespace PacketPrep\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Company_Coupons extends Model
{
    //
    protected $table = 'company_coupons';

     protected $fillable = [
        'user_id',
        'referral_id',
        'name',
        'referral',
        'company'

        // add all other fields
    ];
 
}
