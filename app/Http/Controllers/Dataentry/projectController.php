<?php

namespace PacketPrep\Http\Controllers\Dataentry;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use PacketPrep\Exceptions\Handler;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Dataentry\Project;
use PacketPrep\Models\Dataentry\Category;
use PacketPrep\Models\User\Role;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project,Request $request)
    {
        $search = $request->search;
        $item = $request->item;
        $projects = $project->where('name','LIKE',"%{$item}%")->orderBy('created_at','desc ')->paginate(config('global.no_of_records'));
        $view = $search ? 'list': 'index';

        return view('appl.dataentry.project.'.$view)
        ->with('projects',$projects);
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
        $users = array();
        $users['data_lead'] = Role::getUsers('data-lead');
        $users['feeder'] = Role::getUsers('feeder');
        $users['proof_reader'] = Role::getUsers('proof-reader');
        $users['renovator'] = Role::getUsers('renovator');
        $users['validator'] = Role::getUsers('validator');

        return view('appl.dataentry.project.createedit')
                ->with('stub','Create')
                ->with('jqueryui',true)
                ->with('users',$users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Project $project,Request $request)
    {

        try{
            $request->slug = str_replace(' ', '-', $request->slug);
            $project->name = $request->name;
            $project->slug = $request->slug;
            $project->user_id_data_manager = $request->user_id_data_manager;
            $project->user_id_data_lead = $request->user_id_data_lead;
            $project->user_id_feeder = $request->user_id_feeder;
            $project->user_id_proof_reader = $request->user_id_proof_reader;
            $project->user_id_renovator = $request->user_id_renovator;
            $project->user_id_validator = $request->user_id_validator;
            $project->status = $request->status;
            $project->target = $request->target;
            $project->save(); 

            // save category
            $category = new Category;
            $child_attributes =['name'=>$request->name,'slug'=>$request->slug];
            $child = new Category($child_attributes);
            $child->save();

            flash('A new project('.$request->name.') is created!')->success();
            return redirect()->route('dataentry.index');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('The slug(<b>'.$request->slug.'</b>) is already taken. Kindly use a different slug.')->error();
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
        $project = Project::where('slug',$id)->first();
        if($project)
            return view('appl.dataentry.project.show')->with('project',$project);
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
        $project = Project::where('slug',$id)->first();

        $users = array();
        $users['data_lead'] = Role::getUsers('data-lead');
        $users['feeder'] = Role::getUsers('feeder');
        $users['proof_reader'] = Role::getUsers('proof-reader');
        $users['renovator'] = Role::getUsers('renovator');
        $users['validator'] = Role::getUsers('validator');

        if($project)
            return view('appl.dataentry.project.createedit')
                ->with('stub','Update')
                ->with('jqueryui',true)
                ->with('users',$users)
                ->with('project',$project);
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
            $request->slug = str_replace(' ', '-', $request->slug);
            $project = Project::where('id',$id)->first();

            $category = Category::where('slug',$project->slug)->first();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->save();

            $project->name = $request->name;
            $project->slug = $request->slug;
            $project->user_id_data_manager = $request->user_id_data_manager;
            $project->user_id_data_lead = $request->user_id_data_lead;
            $project->user_id_feeder = $request->user_id_feeder;
            $project->user_id_proof_reader = $request->user_id_proof_reader;
            $project->user_id_renovator = $request->user_id_renovator;
            $project->user_id_validator = $request->user_id_validator;
            $project->status = $request->status;
            $project->target = $request->target;
            $project->save(); 

            flash('Project (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('dataentry.show',$request->slug);
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
        $project = Project::where('id',$id)->first();
        $node = Category::where('slug',$project->slug)->first();
        $node->delete();
        $project->delete();
        flash('Project Successfully deleted!')->success();
        return redirect()->route('dataentry.index');
       
    }
}
