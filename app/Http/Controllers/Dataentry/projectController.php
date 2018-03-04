<?php

namespace PacketPrep\Http\Controllers\Dataentry;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use PacketPrep\Exceptions\Handler;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Dataentry\Project as ProjectModel;

class projectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProjectModel $project,Request $request)
    {
        $search = $request->search;
        $item = $request->item;
        $projects = $project->where('name','LIKE',"%{$item}%")->orderBy('created_at','desc ')->paginate(config('global.no_of_records'));
        $view = $search ? 'list': 'index';
        return view('appl.dataentry.project.'.$view)->withProjects($projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('appl.dataentry.project.create');
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
            $request->slug = str_replace(' ', '-', $request->slug);
            $project = ProjectModel::create($request->all());
            flash('A new project('.$request->name.') is created!')->success();
            return redirect()->route('data.dataentry.index');
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
        $project = ProjectModel::where('slug',$id)->first();
        if($project)
            return view('appl.dataentry.project.show')->withProject($project);
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
        $project = ProjectModel::where('slug',$id)->first();
        if($project)
            return view('appl.dataentry.project.edit')->withProject($project);
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
            $projectToUpdate = ProjectModel::where('slug',$id)->first();
            $projectToUpdate->name = $request->name;
            $projectToUpdate->slug = $request->slug;
            $projectToUpdate->save();
            flash('Project (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('data.dataentry.show',$request->slug);
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
        
        ProjectModel::where('slug',$id)->first()->delete();
        flash('Project Successfully deleted!')->success();
        return redirect()->route('data.dataentry.index');
       
    }
}
