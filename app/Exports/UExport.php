<?php

namespace PacketPrep\Exports;

use PacketPrep\Models\User\User_Details;
use Maatwebsite\Excel\Concerns\FromCollection;

class UExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$users = request()->session()->get('users');
    	foreach($users as $k=>$u){
    			$users[$k]->idno = $k+1;
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
                unset($users[$k]->gender);
                unset($users[$k]->video);
                unset($users[$k]->personality);
                unset($users[$k]->language);
                unset($users[$k]->fluency);
                unset($users[$k]->confidence);


    	}
        return $users;
    }
}
