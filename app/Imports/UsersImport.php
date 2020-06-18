<?php

namespace PacketPrep\Imports;

use PacketPrep\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use PacketPrep\Models\Training\Training;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        $u = User::where('email',$row[1])->first();

        if(!$u){
            $u = new User([
           'name'     => $row[0],
           'email'    => $row[1], 
           'username'    => $this->username($row[1]), 
           'phone'    => $row[2], 
           'password' => Hash::make($row[2]),
           'status'   => 1,
            ]);
        }

        return $u;
    }

    public function username($email){
        $parts = explode("@", $email);
        return $parts[0];
    }
}
