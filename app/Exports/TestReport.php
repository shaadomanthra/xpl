<?php
namespace PacketPrep\Exports;

use PacketPrep\User;
use PacketPrep\Models\Exam\Tests_Overall;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class TestReport implements FromCollection, ShouldQueue
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $users = request()->session()->get('users');
        //$usr = User::whereIn('id',$users)->get();
        $result = request()->session()->get('result');
        $sections = request()->session()->get('sections');
        $exam_sections = request()->session()->get('exam_sections');

        foreach($result as $k=>$res){


            $result[$k]->Sno = $k+1;
            $result[$k]->Name = $res->user->name;
            if(isset($res->user->college->name))
                $result[$k]->College = $res->user->college->name;
            else
                $result[$k]->College = '-';
            if(isset($res->user->branch->name))
                $result[$k]->Branch = $res->user->branch->name;
            else
                $result[$k]->Branch = '-';

            if(isset($res->user->year_of_passing))
                $result[$k]->YOP = $res->user->year_of_passing;
            else
                $result[$k]->YOP = '-';

            
            $result[$k]->Email = $res->user->email;
            $result[$k]->Phone= $res->user->phone;
            $result[$k]->cheat_d = $res->window_change;
            if($res->cheat_detect==2)
            $result[$k]->cheating = 'Cheating - Not Clear';
            elseif($res->cheat_detect==1)
            $result[$k]->cheating = 'Potential Cheating';
            else
              $result[$k]->cheating = 'No Cheating';  
            foreach($sections[$res->user->id] as $m=>$sec){
                if(isset($exam_sections[$m]['name'])){
                    $name = $exam_sections[$m]['name'];
                    $result[$k]->$name = $sec->score;  
                }
                
            }
            
            $result[$k]->Score = $res->score;

            if($res->user->fluency)
                $result[$k]->f= $res->user->fluency;
            else if(intval($res->user->confidence)>1000)
                $result[$k]->f = $res->user->confidence;
            else
                $result[$k]->f = '';

            unset($result[$k]->id);
            unset($result[$k]->user_id);
            unset($result[$k]->test_id);
            unset($result[$k]->unattempted);
            unset($result[$k]->correct);
            unset($result[$k]->incorrect);
            unset($result[$k]->score);
            unset($result[$k]->window_change);
            unset($result[$k]->face_detect);
            unset($result[$k]->cheat_detect);
            unset($result[$k]->params);
            unset($result[$k]->shortlist);
            unset($result[$k]->time);
            unset($result[$k]->max);
            unset($result[$k]->code);
            unset($result[$k]->status);
            unset($result[$k]->updated_at);
            if(isset($result[$k]->roll_number))
             unset($result[$k]->roll_number);
        }

            

        $ux = new Tests_Overall();
        $ux->created = "Timestamp";
        $ux->sno = "Sno";
        $ux->name = "Name";
        $ux->college = "College";

        $ux->branch = "Branch";
        $ux->yop = "Year of Passing";
        $ux->email = "Email";
        $ux->phone = "Phone";
        $ux->cheat_d = "Window Swap";
        $ux->window = "Cheating";
        foreach($exam_sections as $m=>$sec){
                $name = $exam_sections[$m]['name'];
                $ux->$name = $name;
            }
        $ux->Sc = "Score";
        $ux->adm = "Admission Number";
        
        unset($ux->id);
            unset($ux->user_id);
            unset($ux->test_id);
            unset($ux->unattempted);
            unset($ux->correct);
            unset($ux->incorrect);
            unset($ux->score);
            unset($ux->time);
            unset($ux->max);
            unset($ux->window_change);
            unset($ux->face_detect);
            unset($ux->cheat_detect);
            unset($ux->params);
            unset($ux->shortlist);
            unset($ux->code);
            unset($ux->status);
            unset($ux->created_at);
            unset($ux->updated_at);

        $result->prepend($ux);

        return $result;
    }

     public function startRow(): int 
    {
         return 1;
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
