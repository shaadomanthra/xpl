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

        /*
    	$year_of_passing = '2020';

       

        $college = College::where('name','Mahatma Gandhi Institute Of Technology')->first();
        $userss = $college->users->pluck('id');
        $entry = DB::table('metric_user')->where('metric_id', 15)->whereIn('user_id',$userss)->pluck('user_id'); 
        
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

  
        } */

        $entry = DB::table('metric_user')->where('metric_id', 15)->pluck('user_id'); 
        
        $users =  User::whereIn('id',$entry)->get();
        $users_details =  User_Details::whereIn('user_id',$entry)->orderBy('user_id')->get();
        $details = array();
        foreach($users_details as $detail){
            $details[$detail->user_id] = $detail;
        }
        
    
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
                if(isset($details[$users[$k]->id])){
                    $key = $users[$k]->id;
                    $users[$k]->phone = $details[$key]->phone;
                    $users[$k]->year_of_passing = $details[$key]->year_of_passing;
                    //$users[$k]->college = $u->colleges()->first()->name;
                    //$users[$k]->branch = $u->branches()->first()->name; 
                }
               

  
        } 
        //dd($users);

        //$entry = DB::table('branch_user')->whereIn('branch_id', [11,12,13,14,15,16,17,18])->pluck('user_id'); 
        //$users =  User_Details::whereIn('user_id',$entry)->get();
    
      

        return $users;
    }
}
