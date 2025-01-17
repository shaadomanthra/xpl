<?php

namespace PacketPrep\Http\Controllers\Mailer;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Mailer\MailEvent as Obj;
use PacketPrep\Models\Mailer\MailLog;
use PacketPrep\Jobs\SendEmail;
use PacketPrep\Jobs\PdfDownload;
use PacketPrep\Mail\EmailForQueuing;
use PacketPrep\User;

class MailController extends Controller
{
      public function __construct(){
        $this->app      =   'mailer';
        $this->module   =   'mail';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Obj $obj,Request $request)
    {

        $this->authorize('view', $obj);

        $search = $request->search;
        $item = $request->item;
        
        $objs = $obj->select(['name','id','status','created_at'])->where('name','LIKE',"%{$item}%")
                    ->orderBy('created_at','desc ')
                    ->paginate(config('global.no_of_records'));   
        $view = $search ? 'list': 'index';

        return view('appl.'.$this->app.'.'.$this->module.'.'.$view)
                ->with('objs',$objs)
                ->with('obj',$obj)
                ->with('app',$this);
    }


    /**
     * Handles the Stripe Webhook call.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function deliveryStatus(Request $request)
    {
        
        $data = $request->get('event-data');
        if($data){
            $message_id = $data['message']['headers']['message-id'];
            $m = MailLog::where('message_id',$message_id)->first();
         

            if ($m) {
                // if ($data['event'] === 'opened' || $data['event'] === 'clicked') {
                 
                // }

                if ($data['event'] === 'delivered') {
                    $m->status = 2;
                }else if($data['event'] === 'failed'){
                    $usrs = User::where('email',$m->email)->get();
                    if(count($usrs)>0)
                    foreach($usrs as $u){
                        $u->status = 3;
                        $u->save();
                    }
                    $m->status = 3;
                }
                $m->save();
            }
        }else{
            echo "no data";
            exit();
        }
        

    }

    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $obj = new Obj();

        $this->authorize('create', $obj);



        return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Create')
                ->with('editor',true)
                ->with('jqueryui',true)
                ->with('obj',$obj)
                ->with('app',$this);
    }

    public function sendmail($obj)
    {
        

        $emails = implode(',',explode("\n", $obj->emails));
        $emails =str_replace("\r", '', $emails);
        $emails = array_unique(explode(',',$emails));

      

        foreach($emails as $i=>$email){
            $details['email'] = $email;
            

            $subject = $obj->subject;
            $content = $obj->message;

            //Mail::to($details['email'])->send(new EmailForQueuing($details,$subject,$content));
            
            $m = new MailLog();
            $m->name = 'User';
            $m->email = $email;
            $m->message = $obj->message;
            $m->status = 0;
            $m->mailevent_id = $obj->id;
            $m->save();
            $details['maillog'] = $m->id;

            SendEmail::dispatch($details,$subject,$content)->delay(now()->addSeconds($i*2));

        }

        return count($emails);

    }


    public function freeze($obj)
    {
        

        $emails = implode(',',explode("\n", $obj->emails));
        $emails =str_replace("\r", '', $emails);
        $emails = array_unique(explode(',',$emails));

        $users = User::whereIn('email',$emails)->get();
            if($users)
            foreach($users as $u){
                $u->status=4;
                $u->save();
            }

        // foreach($emails as $i=>$email){
        //     $details['email'] = $email;
            

            


        // }

        return count($users);

    }
    

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Obj $obj, Request $request)
    {
         try{
            $obj = $obj->create($request->all());
            flash('A new ('.$this->app.'/'.$this->module.') item is created!')->success();
            return redirect()->route($this->module.'.index');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('Some error in Creating the record')->error();
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
        $obj = Obj::where('id',$id)->with('maillog')->first();
        $this->authorize('view', $obj);

        if(request()->get('sendmail')){
            $count = $this->sendmail($obj);
            flash('Successfully queued '.$count.' emails')->success();
            return redirect()->route($this->module.'.show',$id);
        }

        if(request()->get('freeze')){
            $count = $this->freeze($obj);
            flash('Successfully frozen  '.$count.' user accounts')->success();
            return redirect()->route($this->module.'.show',$id);
        }

        $logs=[];
        if($obj->maillog)
        $logs = $obj->maillog->groupBy('status');

        $emails = [];
        if($obj->emails){
            $emails = implode(',',explode("\n", $obj->emails));
            $emails =str_replace("\r", '', $emails);
            $emails = array_unique(explode(',',$emails));

        }

        foreach([0,1,2] as $k){
            if(!isset($logs[$k]))
                $logs[$k] = [];
        }

        $failed = [];
        foreach($logs[1] as $e){
            array_push($failed,$e->email);
        }

        $success= [];
        foreach($logs[2] as $e){
            array_push($success,$e->email);
        }
       


        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.show')
                    ->with('emails',$emails)
                    ->with('failed',$failed)
                    ->with('success',$success)
                    ->with('obj',$obj)->with('logs',$logs)->with('app',$this);
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
        $obj= Obj::where('id',$id)->first();
        $this->authorize('update', $obj);


        if($obj)
            return view('appl.'.$this->app.'.'.$this->module.'.createedit')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('editor',true)
                ->with('obj',$obj)->with('app',$this);
        else
            abort(404);
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
            $obj = Obj::where('id',$id)->first();

            $this->authorize('update', $obj);
            $obj = $obj->update($request->all()); 
            flash('('.$this->app.'/'.$this->module.') item is updated!')->success();
            return redirect()->route($this->module.'.show',$id);
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                 flash('Some error in updating the record')->error();
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
        $obj = Obj::where('id',$id)->first();
        $this->authorize('update', $obj);
        //mailogs
        $logs = MailLog::where('mailevent_id',$obj->id)->get();
        foreach($logs as $l)
            $l->delete();

        $obj->delete();

        flash('('.$this->app.'/'.$this->module.') item  Successfully deleted!')->success();
        return redirect()->route($this->module.'.index');
    }
}
