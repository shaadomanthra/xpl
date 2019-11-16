<?php

namespace PacketPrep\Exports;

use PacketPrep\User;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;


class ExamExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$ex = new ExamExport();
    	$users = request()->session()->get('users');
    	//$usr = User::whereIn('id',$users)->get();
   		$data = request()->session()->get('d');
   		$sections = request()->session()->get('sections');

   		$ids_ordered = implode(',', $users);

		$usr = User::whereIn('id', $users)
		 ->orderByRaw(DB::raw("FIELD(id, $ids_ordered)"))
		 ->get();

    	foreach($usr as $k=>$u){
    		$usr[$k]->college = $data[$u->id]['college'];
    		$usr[$k]->branch = $data[$u->id]['branch'];

    		unset($usr[$k]->created_at);
    		unset($usr[$k]->college_id);
    		unset($usr[$k]->branch_id);
    		unset($usr[$k]->updated_at);
    		unset($usr[$k]->password);
    		unset($usr[$k]->remember_token);
    		unset($usr[$k]->username);
    		unset($usr[$k]->status);
    		unset($usr[$k]->activation_token);
    		unset($usr[$k]->role);
    		unset($usr[$k]->client_slug);
    		unset($usr[$k]->user_id);
    		if($sections)
    		foreach($sections as $s){
    			$name = $s->name;
    			if(trim($data[$u->id][$s->name])!=null )
    			$usr[$k]->$name = $data[$u->id][$s->name];
    			else
    			$usr[$k]->$name = 0;	
    		}
    		$usr[$k]->score = $data[$u->id]['score'];
    		$usr[$k]->id = $k+1;
    	}
    	$ux = new User();
    	$ux->sno = "Sno";
    	$ux->name = "Name";
    	$ux->email = "Email";
    	$ux->roll_number = "Roll number";
    	$ux->phone = "Phone";
    	$ux->year_of_passing = "Year of Passing";
        $ux->tenth = "Tenth";
        $ux->twelveth = "Twelveth";
        $ux->bachelors = "Bachelors";
        $ux->masters = "Masters";
        $ux->hometown = "Hometown";
        $ux->current_city = "Current City";
        $ux->gender = "Gender";
        $ux->dob = "Date of Birth";
    	
    	
    	$ux->college = "College";
    	$ux->branch = "Branch";
    	if($sections)
    	foreach($sections as $s){
    			$name = $s->name;
    			$ux->$name = $s->name;
    	}
    	$ux->Score = "Score Obtained";
    	

    	unset($ux->created_at);
    		unset($ux->college_id);
    		unset($ux->branch_id);
    		unset($ux->updated_at);
    		unset($ux->password);
    		unset($ux->remember_token);
    		unset($ux->username);
    		unset($ux->status);
    		unset($ux->activation_token);
    		unset($ux->role);
    		unset($ux->client_slug);
    		unset($ux->user_id);

    	$usr->prepend($ux);
    	//dd($usr[1]);
    	
    	//dd($data);
        return $usr;
    }
}
