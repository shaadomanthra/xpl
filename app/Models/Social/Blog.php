<?php

namespace PacketPrep\Models\Social;

use Illuminate\Database\Eloquent\Model;
use PacketPrep\User;

class Blog extends Model
{
    //

    public function getName($uid){
    	return User::where('id',$uid)->first()->name;
    }

    public function getUsername($uid){
    	return User::where('id',$uid)->first()->username;
    }
}
