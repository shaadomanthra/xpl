<?php

namespace PacketPrep\Http\Controllers\System;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\System\Update;
use PacketPrep\Models\System\Goal;
use PacketPrep\Models\System\Finance;
use PacketPrep\Models\System\Report;
use Illuminate\Support\Facades\Mail;
use PacketPrep\Mail\ContactMessage;

class UpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,Update $update)
    {
        $this->authorize('view', $update);
        $item = $request->item;

        $updates = $update->getUpdates();
        
        return view('appl.system.update.index')
            ->with('update',$update)
            ->with('updates',$updates);
    }

    public function welcome(){
        $goals = Goal::where('prime',1)->where('status',0)->orderBy('end_at','asc')->get();
        $updates = Update::where('status',1)->limit(2)->get();
        return view('welcome')->with('goals',$goals)->with('updates',$updates); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Update $update)
    {
        $this->authorize('create', $update);
        return view('appl.system.update.createedit')
                ->with('update',$update)
                ->with('stub','Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $update = new Update;
            $update->user_id = $request->user_id;
            $update->content = ($request->content)? summernote_imageupload(\auth::user(),$request->content):' ';
            $update->type = $request->type;
            $update->status = $request->status;
            $update->save();

            flash('A new update('.$request->name.') is created!')->success();
            return redirect()->route('update.index');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('Some error is there kindly recheck!')->error();
                 return redirect()->back()->withInput();;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $update = Update::where('id',$id)->first();
        $this->authorize('view', $update);
        if($update)
            return view('appl.system.update.show')
                    ->with('update',$update)
                    ->with('stub','Update');
        else
            abort(404);            
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $update = Update::where('id',$id)->first();
        $this->authorize('edit', $update);
        if($update)
            return view('appl.system.update.createedit')
                    ->with('update',$update)
                    ->with('stub','Update');
        else
            abort(404);
    }



    public function system(){
        $goals = Goal::where('status',0)->orderBy('end_at','asc')->limit(3)->get();
        $updates = Update::where('status',1)->limit(2)->get();

        if(\Carbon\Carbon::now()->month<4)  
            $year = \Carbon\Carbon::now()->year-1;
        else
            $year = \Carbon\Carbon::now()->year;

        $start = $year.'-04-01';
        $end = ($year+1).'-04-01';

        $finance = new Finance();
        $finance->cashin = $finance->cash('IN',$start,$end);  
        $finance->cashout = $finance->cash('OUT',$start,$end);  

        $reports = Report::orderBy('created_at','desc')->limit(3)->get();

        return view('appl.system.index')
                ->with('goals',$goals)
                ->with('finance',$finance)
                ->with('reports',$reports)
                ->with('updates',$updates); 
    }


    public function contact(){
        if(!request()->get('name') || !request()->get('email') || !request()->get('subject') || !request()->get('message')){
            flash('Input fields cannot be empty !')->error();
            return redirect()->back()->withInput();
        }
        $captcha = $_POST['g-recaptcha-response'];
        if(!$captcha){
            flash('Please verify using recaptcha !')->error();
            return redirect()->back()->withInput();
        }
        $secretKey = "6Lc9yFAUAAAAACg-A58P_L7IlpHjTB69xkA2Xt65";
        $ip = $_SERVER['REMOTE_ADDR'];
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);

        $responseKeys = json_decode($response,true);
        if(intval($responseKeys["success"]) !== 1) {
            flash('Recaptcha error kindly retry')->error();
            return redirect()->back()->withInput();
        } else {

            $contact['subject'] = request()->subject;
            $contact['message'] = request()->message;
            $contact['email'] = request()->email;
            $contact['name'] = request()->name;
            $contact['subj'] = 'Message from '.$contact['name'];
            Mail::to(config('mail.report'))->send(new ContactMessage($contact));
            $contact['subj'] = 'Message Delivered to Packetprep Team';
            Mail::to($contact['email'])->send(new ContactMessage($contact));

            
            flash('Successfully sent your message to packetprep team !')->success()->important();
            return redirect()->back();
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $update = Update::where('id',$id)->first();
            $update->user_id = $request->user_id;
            $update->content = ($request->content)? summernote_imageupload(\auth::user(),$request->content):' ';
            $update->type = $request->type;
            $update->status = $request->status;
            $update->save();

            flash('Update (<b>id '.$id.'</b>) Successfully updated!')->success();
            return redirect()->route('update.index');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                 flash('Some error is there kindly recheck!')->error();
                 return redirect()->back()->withInput();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $update = Update::where('id',$id)->first();
        $this->authorize('create', $update);
        $update->content = summernote_imageremove($update->content);
        $update->delete();
        flash('Update Successfully deleted!')->success();
        return redirect()->route('update.index');
    }
}
