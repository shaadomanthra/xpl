<?php

namespace PacketPrep\Http\Controllers\Dataentry;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Dataentry\Passage;
use PacketPrep\Models\Dataentry\Project;

class PassageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

        public $project;
    

    public function __construct(){
        $this->project='';
        if(request()->route('project')){
            $this->project = Project::get(request()->route('project'));
        } 

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Passage $passage,Request $request)
    {
        $search = $request->search;
        $item = $request->item;
        $api = $request->api;

        $this->authorize('view', $passage);

        if($api){
            $passages = $passage
                        ->where('project_id',$this->project->id)
                        ->where(function ($query) use ($item) {
                                $query->where('name','LIKE',"%{$item}%")
                                      ->orWhere('passage', 'LIKE', "%{$item}%");
                            })
                        ->orderBy('created_at','desc ')
                        ->get();

            $view = $search ? 'list_attach': 'index';
        }
        else{
            $passages = $passage
                        ->where('project_id',$this->project->id)
                        ->where(function ($query) use ($item) {
                                $query->where('name','LIKE',"%{$item}%")
                                      ->orWhere('passage', 'LIKE', "%{$item}%");
                            })
                        ->orderBy('created_at','desc ')
                        ->paginate(config('global.no_of_records'));

            $view = $search ? 'list': 'index';
        }

        return view('appl.dataentry.passage.'.$view)
        ->with('project',$this->project)
        ->with('passage',$passage)
        ->with('passages',$passages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Passage $passage)
    {
        $this->authorize('create', $passage);
        return view('appl.dataentry.passage.createedit')
                ->with('editor',true)
                ->with('project',$this->project)->with('stub','Create');
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

            $passage_exists = Passage::where('name',$request->name)
                            ->where('passage',$request->passage)
                            ->where('project_id',$request->project_id)
                            ->first();
            if($passage_exists){
                flash('Passage already exists. Create unique passage.')->error();
                return redirect()->back()->withInput();
            }

            $passage_content = summernote_imageupload(\auth::user(),$request->passage);

            $request->merge(['passage'=>$passage_content]);
            $passage = Passage::create($request->all());
            flash('A new passage ('.$request->name.') is created!')->success();
            return redirect()->route('passage.index',$this->project->slug);
        }
        catch (QueryException $e){
           flash('There is some error in storing the data...kindly retry.')->error();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($project_slug,$id)
    {
        $passage = Passage::where('id',$id)->first();
        $this->authorize('view', $passage);
        if($passage)
            return view('appl.dataentry.passage.show')
                    ->with('project',$this->project)
                    ->with('mathjax',true)
                    ->with('passage',$passage);
        else
            abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($project_slug,$id)
    {
        $passage = Passage::where('id',$id)->first();
        $this->authorize('update', $passage);

        if($passage)
            return view('appl.dataentry.passage.createedit')
                    ->with('project',$this->project)
                    ->with('passage',$passage)
                    ->with('editor',true)
                    ->with('stub','Update');
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
    public function update(Request $request,$project_slug, $id)
    {
        $user = \auth::user();
        try{
            $passage = Passage::where('id',$id)->first();
            $passage->name = $request->name;
            $passage->passage = summernote_imageupload($user,$request->passage);
            $passage->status = $request->status;
            $passage->save(); 

            flash('Passage (<b>'.$request->name.'</b>) Successfully updated!')->success();
            return redirect()->route('passage.show',[$project_slug,$id]);
        }
        catch (QueryException $e){
            flash('There is some error in storing the data...kindly retry.')->error();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_slug,$id)
    {

        $passage = Passage::where('id',$id)->first();
        $this->authorize('update', $passage);

        $passage->passage = summernote_imageremove($passage->passage);
        $passage->delete();
        flash('Passage Successfully deleted!')->success();
        return redirect()->route('passage.index',$project_slug);
    }
}
