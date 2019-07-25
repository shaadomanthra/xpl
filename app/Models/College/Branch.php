<?php

namespace PacketPrep\Models\College;

use Illuminate\Database\Eloquent\Model;
use PacketPrep\Models\College\Zone;

class Branch extends Model
{
    protected $fillable = [
        'name',
        // add all other fields
    ];

    public function users(){
        return $this->belongsToMany('PacketPrep\User');
    }

    public function colleges(){
        return $this->belongsToMany('PacketPrep\Models\College\College');
    }

    public function count_zone($zone){
        $z = Zone::where('name',$zone)->first();
        $zone_users = $z->users()->pluck('id')->toArray();
        $obj_users = $this->users()->pluck('id')->toArray();
        $u= array_intersect($obj_users,$zone_users);
        return count($u);
    }
}
