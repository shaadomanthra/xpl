<?php

namespace PacketPrep\Exports;

use PacketPrep\User;
use PacketPrep\Models\User\User_Details;
use PacketPrep\Models\College\College;
use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Support\Facades\DB;

class UsersExport implements FromCollection
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
                unset($users[$k]->video);
                unset($users[$k]->personality);
                unset($users[$k]->language);
                unset($users[$k]->fluency);
                unset($users[$k]->confidence);
                unset($users[$k]->user_id);
                unset($users[$k]->college_id);
                unset($users[$k]->branch_id);
  
        } 
        $ux = new User();
        foreach($ux as $k=>$v){
           
            unset($ux->$k);
        }
        $ux->name = "Name";
        $ux->email = "Email";
        $ux->roll_number = "roll_number";
        $ux->phone = "Phone";
        $ux->yop = "year_of_passing";
        $ux->addr = "Tenth ";
        
        $ux->window = "Twelveth";
        $ux->dob = "Bachelors";
        $ux->c1 = "Masters";
        $ux->c2 = "Hometown";
        $ux->c3 = "Current City";
        $ux->c4 = "Gender";
        $ux->c5 = "Date of Birth";


        $users->prepend($ux);
    
      

        return $users;
    }
}
