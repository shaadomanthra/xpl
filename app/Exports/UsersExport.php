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
    	$year_of_passing = '2020';

        /*$data = User::whereHas('colleges', function ($query)  {
                                $query->whereIn('name', ['Mahatma Gandhi Institute Of Technology']);
                            })->whereHas('metrics', function ($query)  {
                                $query->where('name', '=', 'MS in Abroad');
                            })->get(); */
        //dd($data);

        $college = College::where('name','Mahatma Gandhi Institute Of Technology')->first();
        $userss = $college->users->pluck('id');
        $entry = DB::table('metric_user')->where('metric_id', 15)->whereIn('user_id',$userss)->pluck('user_id'); 
        
        //$entry = DB::table('metric_user')->where('metric_id', 15)->pluck('user_id');
        $users =  User::whereIn('id',$entry)->get();
    
        foreach($users as $k=>$u){
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
                $detail = User_Details::where('user_id',$u->id)->first();
                if($detail){
                     if($u->metrics->contains(15))
                        $users[$k]->ms_abroad = 'MS in Aborad';
                     else 
                        $users[$k]->ms_abroad = '';

                    if($u->metrics->contains(6))
                        $users[$k]->mtech = 'Mtech';
                     else 
                        $users[$k]->mtech = '';

                    if($u->metrics->contains(5))
                        $users[$k]->mba = 'MBA';
                     else 
                        $users[$k]->mba = '';

                    if($u->metrics->contains(9))
                        $users[$k]->job = 'Software JOB';
                     else 
                        $users[$k]->job = '';

                    if($u->metrics->contains(8))
                        $users[$k]->gjob = 'Government JOB';
                     else 
                        $users[$k]->gjob = '';

                    $users[$k]->phone = $detail->phone;
                    $users[$k]->year_of_passing = $detail->year_of_passing;
                    $users[$k]->college = $u->colleges()->first()->name;
                    $users[$k]->branch = $u->branches()->first()->name;
                }

                //if($k==100)
                  //  break;
  
        }

        /*
        //$users = new UsersExport();
        foreach($data as $k => $d){
            $detail = User_Details::where('user_id',$d->id)->first();
            if($detail){
                $data[$k]->phone = $detail->phone;
                $data[$k]->college = $d->colleges()->first()->name;
                $data[$k]->branch = $d->branches()->first()->name;
            }
        } */

        return $users;
    }
}
