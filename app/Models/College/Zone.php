<?php

namespace PacketPrep\Models\College;

use Illuminate\Database\Eloquent\Model;
use PacketPrep\Models\College\Branch;

class Zone extends Model
{
    protected $fillable = [
        'name',
        // add all other fields
    ];


    public function colleges(){
        return $this->belongsToMany('PacketPrep\Models\College\College');
    }

    public function users(){
        return $this->belongsToMany('PacketPrep\User');
    }

    public function count_branch($branch){
        $b = Branch::where('name',$branch)->first();
        $branch_users = $b->users()->pluck('id')->toArray();
        $obj_users = $this->users()->pluck('id')->toArray();
        $u= array_intersect($obj_users,$branch_users);
        return count($u);
    }


}
