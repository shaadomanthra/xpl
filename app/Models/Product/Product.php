<?php

namespace PacketPrep\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'status'

        // add all other fields
    ];

    public function users(){
        return $this->belongsToMany('Packetprep\User');
    }

    public static function  update_pivot($product_id,$user_id,$validity,$status,$valid_till){

        
        return DB::table('product_user')
                ->where('user_id', $user_id)
                ->where('product_id', $product_id)
                ->update(['validity' => $validity,'status' => $status,'valid_till' => $valid_till]);

    }

    public function validityExpired(){

        $product_id = $this->id;
        $user_id = \auth::user()->id;

        $entry = DB::table('product_user')
                ->where('product_id', $product_id)
                ->where('user_id', $user_id)
                ->first();


        if(strtotime($entry->valid_till) > strtotime(date('Y-m-d')) && $entry->status==1)
            return false;
        else
            return true;

    }
}
