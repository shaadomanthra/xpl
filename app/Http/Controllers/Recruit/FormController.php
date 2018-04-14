<?php

namespace PacketPrep\Http\Controllers\Recruit;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Recruit\Form;
use PacketPrep\Models\Recruit\Job;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Mail;
use PacketPrep\Mail\Formalerts;

class FormController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Form $form,Request $request)
    {
        $this->authorize('view', $form);
        $search = $request->search;
        $item = $request->item;
        $forms = $form->getForms();
        $view = $search ? 'list': 'index';
        $jobs = Job::get();

        return view('appl.recruit.form.'.$view)
                ->with('forms',$forms)
                ->with('jobs',$jobs)
                ->with('form',new Form());
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->get('job'))
            $job = Job::where('slug',request()->get('job'))->first();
        else
            abort(404,'Job Reference not given');

        $form = new Form();

        return view('appl.recruit.form.createedit')
                ->with('stub','Create')
                ->with('job',$job)
                ->with('jqueryui',true)
                ->with('recaptcha',true)
                ->with('form',$form);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Form $form,Request $request)
    {

        try{

            if(!$request->name || !$request->email || !$request->phone){
                flash('Name, email, phone fields cannot be empty')->error();
                 return redirect()->back()->withInput();
            }

            $id = Form::where('email',$request->email)->where('job_id',$request->job_id)->first();
            if($id){
                flash('Your Application is already registered with our database. This form data cannot be stored. Kindly contact the administrator')->error();
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
                  $form->name = scriptStripper($request->name);
                $form->email= scriptStripper($request->email);
                $form->dob = scriptStripper($request->dob);
                $form->phone = scriptStripper($request->phone);
                $form->address = scriptStripper($request->address);
                $form->education = scriptStripper($request->education);
                $form->experience = scriptStripper($request->experience);
                $form->why = scriptStripper($request->why);
                $form->reason = scriptStripper($request->reason);
                $form->status = $request->status;
                $form->job_id = $request->job_id;
                $form->user_id = null;
                $form->save(); 
                
                $applicant = Form::where('email',$form->email)->where('job_id',$form->job_id)->first();


                Mail::to(config('mail.report'))->send(new Formalerts($applicant));

                return view('appl.recruit.form.success');
            }
        }
            
        catch (QueryException $e){
            flash('Some unknown error occured. Kindly retry!')->error();
            return redirect()->back()->withInput();
            
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
        $form = Form::where('id',$id)->first();
        $this->authorize('view', $form);
        if($form)
            return view('appl.recruit.form.show')
                    ->with('form',$form);
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
        $form = Form::where('id',$id)->first();
        $job = Job::where('id',$form->job_id)->first();
        $this->authorize('edit', $form);

        if($form)
            return view('appl.recruit.form.createedit')
                ->with('stub','Update')
                ->with('job',$job)
                ->with('recaptcha',true)
                ->with('form',$form);
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

            $form = Form::where('id',$id)->first();

            $this->authorize('update', $form);
            if(!$request->name || !$request->email || !$request->phone){
                flash('Name, email, phone fields cannot be empty')->error();
                 return redirect()->back()->withInput();
            }

            $form->name = scriptStripper($request->name);
            $form->email= scriptStripper($request->email);
            $form->dob = scriptStripper($request->dob);
            $form->phone = scriptStripper($request->phone);
            $form->address = scriptStripper($request->address);
            $form->education = scriptStripper($request->education);
            $form->experience = scriptStripper($request->experience);
            $form->why = scriptStripper($request->why);
            $form->reason = scriptStripper($request->reason);
            $form->status = $request->status;
            $form->save(); 

            flash('Form by (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('form.show',$form->id);
        }
        catch (QueryException $e){
            flash('Some unknown error occured. Kindly retry!')->error();
            return redirect()->back()->withInput();
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
        $form = Form::where('id',$id)->first();
        $this->authorize('update', $form);
        $form->delete();
        flash('Form Successfully deleted!')->success();
        return redirect()->route('form.index');
       
    }
}
