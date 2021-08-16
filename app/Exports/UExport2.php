<?php

namespace PacketPrep\Exports;

use PacketPrep\Models\User\User_Details;
use Maatwebsite\Excel\Concerns\FromCollection;
use PacketPrep\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UExport2 implements FromCollection, WithHeadings
{
    use Exportable;

    public function headings(): array
    {
        return [
            'id',
            'Name',
            'Email',

            'created',
            'last_login',
            'Roll Number/Fathers Name',
            'Phone',
            'Hometown/ District',
            'Current City/ Address',
            'Fathers Phone',
            'Date of Birth',
            'Custom Field 1',
            'Custom Field 2',
            'Custom Field 3',
            'Custom Field 4',
            'Custom Field 5',
            'info'
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       $users = request()->session()->get('users');
        foreach($users as $k=>$u){
                $id = $users[$k]->id;             
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
