<?php

namespace PacketPrep\Exports;

use PacketPrep\User;
use PacketPrep\Models\User\User_Details;
use PacketPrep\Models\College\College;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\DB;

class UsersExport implements FromCollection,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       $users = request()->session()->get('users');
       $colleges = request()->session()->get('colleges');
       $branches= request()->session()->get('branches');
       $exam_data = request()->session()->get('exam_data');
       $exams = request()->session()->get('exams');
        foreach($users as $k=>$u){
                $id = $users[$k]->id;
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
                
                $c_id = $users[$k]->college_id;
                $b_id = $users[$k]->branch_id;
                $coll = $users[$k]->info;
                unset($users[$k]->info);
                unset($users[$k]->college_id);
                unset($users[$k]->branch_id);

                if($c_id==5 || $c_id==295)
                    $users[$k]->colleges =  $coll;
                else if(!$c_id)
                    $users[$k]->colleges = '-';
                else
                    $users[$k]->colleges = $colleges[$c_id]->name;
                   

                if($b_id)
                    $users[$k]->branches =  $branches[$b_id]->name;
                else
                    $users[$k]->branches = '-';



                foreach($exams as $m=>$ex){
                    $name = 'e_'.$ex->slug;
                    if(isset($exam_data[$ex->id][$id]['score'])){
                        $users[$k]->$name = $exam_data[$ex->id][$id]['score'];
                    }
                    else
                       {
                        $users[$k]->$name = '-';
                       }

                }

                $users[$k]->profile_score = $users[$k]->pivot->score;
                $users[$k]->shortlisted = $users[$k]->pivot->shortlisted;
            
            
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
        $ux->c6 = "Aadhar Number";
        $ux->c7 = "College";
        $ux->c8 = "Branch";

        foreach($exams as $k=>$ex){
                    $name = 'ck'.$k;
                    $ux->$name = $ex->name;
        }

        $ux->c9 = "Profile Score";
        $ux->c10 = "Shortlisted";


        $users->prepend($ux);
    
      

        return $users;
    }
}
