<?php

namespace PacketPrep\Exports;

use PacketPrep\User;
use PacketPrep\Models\User\User_Details;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$year_of_passing = '2020';

        $data = User::whereHas('colleges', function ($query)  {
                                $query->whereIn('name', ['Mahatma Gandhi Institute Of Technology']);
                            })->whereHas('metrics', function ($query)  {
                                $query->where('name', '=', 'MS in Abroad');
                            })->get();
        //dd($data);

        $users = new UsersExport();
        foreach($data as $k => $d){
            $detail = User_Details::where('user_id',$d->id)->first();
            if($detail){
                $data[$k]->phone = $detail->phone;
                $data[$k]->college = $d->colleges()->first()->name;
                $data[$k]->branch = $d->branches()->first()->name;
            }
        }

        return $data;
    }
}
