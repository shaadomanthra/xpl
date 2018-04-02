<?php

namespace PacketPrep\Http\Controllers\Recruit;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Recruit\Job;

class JobController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Job $job,Request $request)
    {

        $search = $request->search;
        $item = $request->item;
        $jobs = $job->where('title','LIKE',"%{$item}%")->orderBy('created_at','desc ')->paginate(config('global.no_of_records'));
        $view = $search ? 'list': 'index';

        return view('appl.recruit.job.'.$view)
        ->with('jobs',$jobs)->with('job',new Job());
    }


    public function material(){
        return view('appl.dataentry.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $job = new Job();
        $this->authorize('create', $job);

        return view('appl.recruit.job.createedit')
                ->with('stub','Create')
                ->with('job',$job);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Job $job,Request $request)
    {

        try{

            if(!$request->title || !$request->slug || !$request->content){
                flash('Title, slug, Content fields cannot be empty')->error();
                 return redirect()->back()->withInput();
            }

            $request->slug = str_replace(' ', '-', $request->slug);
            $job->title = $request->title;
            $job->slug = $request->slug;
            $job->user_id= $request->user_id;
            $job->content = $request->content;
            $job->vacancy = $request->vacancy;
            $job->status = $request->status;
            $job->save(); 

            flash('A new Job('.$request->title.') is created!')->success();
            return redirect()->route('job.index');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
                 return redirect()->back()->withInput();
            }
        }
        
    }

    public function recruit(){
        return view('appl.recruit.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = Job::where('slug',$id)->first();
        

        if($job)
            return view('appl.recruit.job.show')
                    ->with('job',$job);
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
        $job = Job::where('id',$id)->first();
        $this->authorize('edit', $job);

        if($job)
            return view('appl.recruit.job.createedit')
                ->with('stub','Update')
                ->with('job',$job);
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

            $job = Job::where('id',$id)->first();

            $this->authorize('update', $job);
            if(!$request->title || !$request->slug || !$request->content){
                flash('Title, slug, Content fields cannot be empty')->error();
                 return redirect()->back()->withInput();
            }

            $request->slug = str_replace(' ', '-', $request->slug);
            $job->title = $request->title;
            $job->slug = $request->slug;
            $job->content = $request->content;
            $job->vacancy = $request->vacancy;
            $job->status = $request->status;
            $job->save(); 

            flash('Job (<b>'.$request->title.'</b>) Successfully updated!')->success();
            return redirect()->route('job.show',$request->slug);
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
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
        $job = Job::where('id',$id)->first();
        $this->authorize('update', $job);
        $job->delete();
        flash('Job Successfully deleted!')->success();
        return redirect()->route('job.index');
       
    }
}
