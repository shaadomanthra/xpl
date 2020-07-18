<?php

namespace PacketPrep\Exports;

use PacketPrep\Models\User\User_Details;
use Maatwebsite\Excel\Concerns\FromCollection;
use PacketPrep\User;

class UExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$users = request()->session()->get('users');
    	foreach($users as $k=>$u){
    			unset($users[$k]->id);
                unset($users[$k]->created_at);
                unset($users[$k]->updated_at);
                unset($users[$k]->password);
                unset($users[$k]->remember_token);
                unset($users[$k]->username);
                unset($users[$k]->status);
                unset($users[$k]->activation_token);
                unset($users[$k]->role);
                unset($users[$k]->client_slug);
                unset($users[$k]->user_id);
                unset($users[$k]->branch_id);
                unset($users[$k]->college_id);
                unset($users[$k]->year_of_passing);
                unset($users[$k]->tenth);
                unset($users[$k]->twelveth);
                unset($users[$k]->bachelors);
                unset($users[$k]->masters);
                
    	}

        $ux = new User();
        foreach($ux as $k=>$v){
           
            unset($ux->$k);
        }
        $ux->name = "Name";
        $ux->email = "Email";
        $ux->roll_number = "Father Name";
        $ux->phone = "Phone";
        $ux->yop = "District";
        $ux->addr = "Address ";
        
        $ux->window = "Fathers Phone Number";
        $ux->dob = "Date of Birth";
        $ux->c1 = "Custom Field 1";
        $ux->c2 = "Custom Field 2";
        $ux->c3 = "Custom Field 3";
        $ux->c4 = "Custom Field 4";
        $ux->c5 = "Custom Field 5";


        $users->prepend($ux);

        dd($users);
        return $users;
    }
}
