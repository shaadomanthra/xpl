<?php

namespace PacketPrep\Exports;

use PacketPrep\Tests_overall;
use Maatwebsite\Excel\Concerns\FromCollection;
use PacketPrep\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PerformanceExport implements FromCollection, WithHeadings
{
     use Exportable;

   

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       $data = request()->session()->get('data');
       $exams = request()->session()->get('exams');
        foreach($users as $k=>$u){
                $id = $users[$k]->id;                
                unset($users[$k]->created_at);
                unset($users[$k]->updated_at);
                unset($users[$k]->password);
                unset($users[$k]->remember_token);
                unset($users[$k]->username);
                unset($users[$k]->status);
                unset($users[$k]->activation_token);
                unset($users[$k]->role);
                unset($users[$k]->year_of_passing);
                unset($users[$k]->client_slug);
                unset($users[$k]->tenth);
                unset($users[$k]->twelveth);
                unset($users[$k]->bachelors);
                unset($users[$k]->masters);
                unset($users[$k]->college_id);
                unset($users[$k]->branch_id);
                unset($users[$k]->user_id);
                unset($users[$k]->aadhar);
              
            
        } 



    
      

        return $users;
    }
}
