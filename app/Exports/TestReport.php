<?php

namespace PacketPrep\Exports;

use PacketPrep\User;
use PacketPrep\Models\Exam\Tests_Overall;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class TestReport implements FromCollection
{
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
    		$result[$k]->Email = $res->user->email;
    		$result[$k]->Phone= $res->user->phone;
    		foreach($sections[$res->user->id] as $m=>$sec){
    			$name = $exam_sections[$m]['name'];
    			$result[$k]->$name = $sec->score;
    		}
    		
    		$result[$k]->Score = $res->score;

    		unset($result[$k]->id);
    		unset($result[$k]->user_id);
    		unset($result[$k]->test_id);
    		unset($result[$k]->unattempted);
    		unset($result[$k]->correct);
    		unset($result[$k]->incorrect);
    		unset($result[$k]->score);
    		unset($result[$k]->time);
    		unset($result[$k]->max);
    		unset($result[$k]->code);
    		unset($result[$k]->status);
    		unset($result[$k]->updated_at);
    	}
    		

    	$ux = new Tests_Overall();
        $ux->created = "Timestamp";
    	$ux->sno = "Sno";
    	$ux->name = "Name";
    	$ux->email = "Email";
    	$ux->phone = "Phone";
    	foreach($exam_sections as $m=>$sec){
    			$name = $exam_sections[$m]['name'];
    			$ux->$name = $name;
    		}
    	$ux->Sc = "Score";
    	
    	unset($ux->id);
    		unset($ux->user_id);
    		unset($ux->test_id);
    		unset($ux->unattempted);
    		unset($ux->correct);
    		unset($ux->incorrect);
    		unset($ux->score);
    		unset($ux->time);
    		unset($ux->max);
    		unset($ux->code);
    		unset($ux->status);
    		unset($ux->created_at);
    		unset($ux->updated_at);

    	$result->prepend($ux);

        return $result;
    }
}
